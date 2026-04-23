<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'user'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer', 'user']);
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }
}
