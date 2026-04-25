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
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('selling_price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('selling_price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(15);
        $title = $request->category ?? 'Tất cả sản phẩm';
        if ($request->has('search') && $request->search != '') {
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

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        
        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->where('status', 1)
                                  ->inRandomOrder()
                                  ->limit(4)
                                  ->get();
                                  
        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
