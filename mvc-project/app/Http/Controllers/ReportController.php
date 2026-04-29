<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'this_month');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($filter == 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } elseif ($filter == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        $stats = [
            'total_revenue' => Order::where('status', 'Delivered')
                ->whereBetween('created_at', [$startDate, $endDate])->sum('total_amount'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        // Revenue Chart (based on filter)
        $chartLabels = collect();
        $chartData = collect();

        if ($filter == 'this_year') {
            // Monthly for the year
            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create(Carbon::now()->year, $i, 1)->startOfMonth();
                $monthEnd = Carbon::create(Carbon::now()->year, $i, 1)->endOfMonth();
                $revenue = Order::where('status', 'Delivered')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->sum('total_amount');
                $chartLabels->push('Tháng ' . $i);
                $chartData->push($revenue);
            }
        } else {
            // Daily for the month
            $daysInMonth = $startDate->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dayStart = $startDate->copy()->addDays($i - 1)->startOfDay();
                $dayEnd = $startDate->copy()->addDays($i - 1)->endOfDay();
                if ($dayStart > Carbon::now()) break; // Don't show future days in this month
                
                $revenue = Order::where('status', 'Delivered')
                    ->whereBetween('created_at', [$dayStart, $dayEnd])
                    ->sum('total_amount');
                $chartLabels->push($dayStart->format('d/m'));
                $chartData->push($revenue);
            }
        }

        // Payment Methods
        $paymentMethods = Order::select('payment_method', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();
        $pmLabels = $paymentMethods->pluck('payment_method')->map(function($method) {
            return ucfirst($method);
        });
        $pmData = $paymentMethods->pluck('total');

        // Top Selling Products
        $topSelling = OrderItem::with('product')
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('reports.index', compact('stats', 'chartLabels', 'chartData', 'pmLabels', 'pmData', 'topSelling', 'filter'));
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->input('filter', 'this_month');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($filter == 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } elseif ($filter == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        // Lấy danh sách đơn hàng
        $orders = Order::with(['user', 'customer'])
            ->where('status', 'Delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính lợi nhuận nếu có cost_price trong OrderItem
        foreach ($orders as $order) {
            $totalCost = OrderItem::where('order_id', $order->id)->sum(DB::raw('cost_price * quantity'));
            $order->cost_total = $totalCost;
            $order->profit = $order->total_amount - $totalCost;
        }

        $totalRevenue = $orders->sum('total_amount');
        $totalProfit = $orders->sum('profit');
        
        $stats = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $orders->count(),
        ];

        $profit = $totalProfit;
        $dateFrom = $startDate->format('Y-m-d');
        $dateTo = $endDate->format('Y-m-d');
        
        $reportDate = Carbon::now()->format('d/m/Y H:i');
        $reporterName = auth()->user() ? auth()->user()->name : 'Admin';

        return view('reports.pdf', compact('orders', 'stats', 'profit', 'dateFrom', 'dateTo', 'reportDate', 'reporterName'));
    }
}
