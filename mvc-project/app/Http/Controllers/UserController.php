<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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

        try {
            $user->fullname = $request->fullname;
            $user->email = $request->email;

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                if ($file->isValid()) {
                    // Delete old avatar if exists
                    if ($user->profile_picture) {
                        $oldPath = public_path('images/avatars/' . $user->profile_picture);
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }

                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images/avatars');
                    
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0755, true, true);
                    }
                    
                    $file->move($path, $imageName);
                    $user->profile_picture = $imageName;
                }
            }

            $user->save();
            return back()->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Avatar Upload Error: ' . $e->getMessage());
            return back()->withErrors(['avatar' => 'Có lỗi xảy ra khi lưu ảnh: ' . $e->getMessage()]);
        }
    }

    // Standard resource methods for Admin User Management
    public function index()
    {
        $users = User::latest('user_id')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
        ]);

        User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
            'is_active' => 1
        ]);

        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'role' => 'required|in:admin,customer',
            'status' => 'nullable'
        ]);

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->has('status')) {
            $user->status = 'active';
            $user->is_active = 1;
        } else {
            $user->status = 'locked';
            $user->is_active = 0;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->user_id === \Illuminate\Support\Facades\Auth::id()) {
            return back()->with('error', 'Không thể xóa chính mình!');
        }

        if ($user->profile_picture) {
            $path = public_path('images/avatars/' . $user->profile_picture);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
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
