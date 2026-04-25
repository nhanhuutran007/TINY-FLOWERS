<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => \App\Models\Order::where('status', 'Delivered')->sum('total_amount'),
            'total_orders' => \App\Models\Order::count(),
            'total_products' => \App\Models\Product::count(),
            'total_customers' => \App\Models\User::where('role', 'customer')->count(),
        ];

        // Revenue Chart (last 7 days)
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

        // Payment Methods
        $paymentMethods = \App\Models\Order::select('payment_method', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->get();
        $pmLabels = $paymentMethods->pluck('payment_method')->map(function($method) {
            return ucfirst($method);
        });
        $pmData = $paymentMethods->pluck('total');

        // Top Selling Products
        $topSelling = \App\Models\OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('reports.index', compact('stats', 'chartLabels', 'chartData', 'pmLabels', 'pmData', 'topSelling'));
    }
}
