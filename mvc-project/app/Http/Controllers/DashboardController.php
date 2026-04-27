<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        // Basic Stats
        $totalRevenue = \App\Models\Order::where('status', 'Delivered')->sum('total_amount');
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalProducts = \App\Models\Product::count();

        // Advanced Metrics
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // This month's data
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $monthlyRevenue = \App\Models\Order::where('status', 'Delivered')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total_amount');
        
        $prevMonthStart = \Carbon\Carbon::now()->subMonth()->startOfMonth();
        $prevMonthEnd = \Carbon\Carbon::now()->subMonth()->endOfMonth();
        $prevMonthlyRevenue = \App\Models\Order::where('status', 'Delivered')
            ->whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])
            ->sum('total_amount');
        
        $revenueGrowth = 0;
        if ($prevMonthlyRevenue > 0) {
            $revenueGrowth = (($monthlyRevenue - $prevMonthlyRevenue) / $prevMonthlyRevenue) * 100;
        }

        // Recent Orders with relations
        $recentOrders = \App\Models\Order::with(['customer', 'user'])
            ->latest()
            ->take(8)
            ->get();

        // Real Top Selling Products
        $topSelling = \App\Models\OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        // Chart Data: Last 12 months for a more professional look
        $chartLabels = collect();
        $chartData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M');
            $revenue = \App\Models\Order::where('status', 'Delivered')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            
            $chartLabels->push($monthLabel);
            $chartData->push($revenue);
        }

        // Weekly revenue for small chart
        $weeklyLabels = collect();
        $weeklyData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            $dayLabel = $date->format('D');
            $revenue = \App\Models\Order::where('status', 'Delivered')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total_amount');
            $weeklyLabels->push($dayLabel);
            $weeklyData->push($revenue);
        }

        return view('dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'recentOrders', 'topSelling', 'chartLabels', 'chartData',
            'avgOrderValue', 'monthlyRevenue', 'revenueGrowth',
            'weeklyLabels', 'weeklyData'
        ));
    }
}

