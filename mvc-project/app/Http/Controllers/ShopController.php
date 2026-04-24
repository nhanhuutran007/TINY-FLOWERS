<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 1);

        if ($request->has('category')) {
            $categoryName = $request->category;
            $query->whereHas('category', function($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
        }

        $products = $query->latest()->paginate(15);
        $title = $request->category ?? 'Tất cả sản phẩm';

        return view('shop.index', compact('products', 'title'));
    }

    public function collections(Request $request)
    {
        $products = Product::where('status', 1)
                          ->where(function($q) {
                              $q->where('category_id', 'like', '%Set%')
                                ->orWhere('name', 'like', '%Set%')
                                ->orWhere('name', 'like', '%Combo%');
                          })
                          ->latest()->paginate(12);
        
        $title = 'Bộ sưu tập Lookbook';
        return view('shop.index', compact('products', 'title'));
    }
}
