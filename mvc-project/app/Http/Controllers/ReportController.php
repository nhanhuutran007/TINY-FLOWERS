<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Simple mock data for now, would be replaced with real queries
        $stats = [
            'total_revenue' => \App\Models\Order::sum('total_amount'),
            'total_orders' => \App\Models\Order::count(),
            'total_products' => \App\Models\Product::count(),
            'total_customers' => \App\Models\Customer::count(),
        ];
        
        return view('reports.index', compact('stats'));
    }
}
