<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'user'])->latest();

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->get();
        return view('orders.index', compact('orders', 'dateFrom', 'dateTo'));
    }

    public function exportPdf(Request $request)
    {
        $query = Order::with(['customer', 'user'])->latest();

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->get();
        
        $reportDate = \Carbon\Carbon::now()->format('d/m/Y H:i');
        $reporterName = auth()->user() ? auth()->user()->name : 'Admin';

        return view('orders.pdf', compact('orders', 'dateFrom', 'dateTo', 'reportDate', 'reporterName'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer', 'user']);
        return view('orders.show', compact('order'));
    }

    public function printBill(Order $order)
    {
        $order->load(['items.product', 'customer', 'user']);
        return view('orders.print_bill', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.show', $order)->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }
}
