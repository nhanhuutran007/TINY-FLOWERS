<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = Auth::user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,bank_transfer',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction();

            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'subtotal' => $total,
                'discount' => 0,
                'total_amount' => $total,
                'amount_paid' => 0,
                'change_amount' => 0,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'cost_price' => $item['price'], // Note: we are storing selling price as cost_price here to reflect price at time of purchase. Wait, order_items has cost_price and selling_price. Let's just use selling_price
                    'selling_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Update stock
                $product = \App\Models\Product::find($id);
                if ($product) {
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('checkout.success', compact('order'));
    }
}
