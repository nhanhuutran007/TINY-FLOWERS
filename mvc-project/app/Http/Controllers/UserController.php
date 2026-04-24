<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function profile()
    {
        // For development, we get the admin user since authentication is hardcoded
        $user = User::where('email', 'admin@admin.com')->first();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->fullname = $request->fullname;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists (custom logic for avatar if needed)
            $imageName = time() . '.' . $request->avatar->extension();
            $path = public_path('images/avatars');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $request->avatar->move($path, $imageName);
            // Assuming there's an avatar or profile_picture column. 
            // The seeder doesn't show one, so let's check User model.
        }

        $user->save();

        // Update session
        Session::put('user', [
            'name' => $user->fullname,
            'email' => $user->email,
            'role' => $user->role
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePasswordView()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);

        $user = User::where('email', 'admin@admin.com')->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
