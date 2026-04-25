<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đánh giá sản phẩm.');
        }

        // Check if user already reviewed this product
        $existingReview = \App\Models\Review::where('user_id', $user->user_id)
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        \App\Models\Review::create([
            'user_id' => $user->user_id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
