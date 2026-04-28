<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Đăng nhập Google thất bại. Vui lòng thử lại.']);
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if ($user) {
            // Update google_id if logging in via email-matched account
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        } else {
            // Generate a unique username from name
            $baseUsername = Str::slug($googleUser->getName(), '.');
            $username = $baseUsername;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            $user = User::create([
                'fullname'   => $googleUser->getName(),
                'username'   => $username,
                'email'      => $googleUser->getEmail(),
                'google_id'  => $googleUser->getId(),
                'password'   => bcrypt(Str::random(24)),
                'role'       => 'customer',
                'status'     => 1,
            ]);
        }

        if ($user->status == 'locked' || $user->status === 0) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.']);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('success', 'Chào mừng ' . $user->fullname . '! Đăng nhập Google thành công.');
    }
}
