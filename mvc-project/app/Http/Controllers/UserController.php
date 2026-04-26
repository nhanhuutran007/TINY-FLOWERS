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
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'customer') {
            return view('profile.customer', compact('user'));
        }

        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');

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
            $user->profile_picture = $imageName;
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePasswordView()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');
        
        if ($user->role === 'customer') {
            return view('profile.customer-password', compact('user'));
        }
        
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function addressView()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');
        
        if ($user->role === 'customer') {
            return view('profile.customer-address', compact('user'));
        }
        
        return view('profile.index', compact('user'));
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');

        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Cập nhật sổ địa chỉ thành công!');
    }

    public function ordersView()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return redirect()->route('login');
        
        $orders = \App\Models\Order::with(['items.product', 'customer'])->where('user_id', $user->user_id)->orderBy('created_at', 'desc')->get();
        
        if ($user->role === 'customer') {
            return view('profile.customer-orders', compact('user', 'orders'));
        }
        
        return view('profile.index', compact('user'));
    }
}
