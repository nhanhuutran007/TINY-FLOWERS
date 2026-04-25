<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // We use the relation we will define on the User model
        $favorites = $user->favorites()->with('product')->get();
        
        return view('profile.favorites', compact('user', 'favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích.',
                'redirect' => route('login')
            ], 401);
        }

        $favorite = Favorite::where('user_id', $user->user_id)->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'success',
                'action' => 'removed',
                'message' => 'Đã xóa khỏi danh sách yêu thích.'
            ]);
        } else {
            Favorite::create([
                'user_id' => $user->user_id,
                'product_id' => $product->id
            ]);
            return response()->json([
                'status' => 'success',
                'action' => 'added',
                'message' => 'Đã thêm vào danh sách yêu thích.'
            ]);
        }
    }
}
