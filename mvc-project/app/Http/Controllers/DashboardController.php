<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = \App\Models\Order::where('status', 'Delivered')->sum('total_amount');
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalProducts = \App\Models\Product::count();

        // Recent Orders
        $recentOrders = \App\Models\Order::with('customer', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Top Selling Products (simulated based on order items)
        $topSelling = \App\Models\OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Last 7 days revenue for chart
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $revenue = \App\Models\Order::where('status', 'Delivered')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $last7Days->push([
                'date' => \Carbon\Carbon::now()->subDays($i)->format('d/m'),
                'revenue' => $revenue
            ]);
        }

        $chartLabels = $last7Days->pluck('date');
        $chartData = $last7Days->pluck('revenue');

        return view('dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'recentOrders', 'topSelling', 'chartLabels', 'chartData'
        ));
    }
}
