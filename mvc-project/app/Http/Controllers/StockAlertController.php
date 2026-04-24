<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockAlertController extends Controller
{
    public function index()
    {
        $outOfStock = Product::where('stock_quantity', 0)->get();
        $lowStock = Product::where('stock_quantity', '>', 0)
                          ->where('stock_quantity', '<=', 10)
                          ->get();

        return response()->json([
            'success' => true,
            'total' => $outOfStock->count() + $lowStock->count(),
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock
        ]);
    }
}
