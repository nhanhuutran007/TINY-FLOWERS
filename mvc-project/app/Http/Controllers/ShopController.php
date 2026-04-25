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

        if ($request->has('category') && $request->category != '') {
            $categoryName = $request->category;
            $query->whereHas('category', function($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('barcode', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->latest()->paginate(15);
        
        $title = 'Tất cả sản phẩm';
        if ($request->has('category') && $request->category != '') {
            $title = $request->category;
        } elseif ($request->has('search') && $request->search != '') {
            $title = 'Kết quả tìm kiếm: ' . $request->search;
        }

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
