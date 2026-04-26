<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function orderDetails($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('account.order_details', compact('order'));
    }

    public function storeReview(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện.'], 401);
        }

        $productId = $request->input('product_id');
        $user = Auth::user();

        try {
            $deleted = Favorite::where('user_id', $user->user_id)
                ->where('product_id', $productId)
                ->delete();

            if ($deleted) {
                return response()->json(['success' => true, 'action' => 'removed']);
            }

            Favorite::create([
                'user_id' => $user->user_id,
                'product_id' => $productId
            ]);

            return response()->json(['success' => true, 'action' => 'added']);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return response()->json(['success' => true, 'action' => 'added']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['success' => true, 'action' => 'added']);
            }
            throw $e;
        }
    }
}
