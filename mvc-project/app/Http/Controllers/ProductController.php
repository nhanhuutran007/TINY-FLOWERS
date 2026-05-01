<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|unique:products',
            'name' => 'required',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();
            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images');
                    
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0755, true, true);
                    }
                    
                    $file->move($path, $imageName);
                    $data['image'] = $imageName;
                }
            }

            Product::create($data);
            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Product Image Upload Error: ' . $e->getMessage());
            return back()->withErrors(['image' => 'Có lỗi xảy ra khi lưu ảnh sản phẩm: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'barcode' => 'required|unique:products,barcode,' . $product->id,
            'name' => 'required',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();
            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file->isValid()) {
                    // Delete old image
                    if ($product->image && $product->image !== 'default-product.png') {
                        $oldPath = public_path('images/' . $product->image);
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }

                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images');
                    
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0755, true, true);
                    }
                    
                    $file->move($path, $imageName);
                    $data['image'] = $imageName;
                }
            }

            $product->update($data);
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Product Image Update Error: ' . $e->getMessage());
            return back()->withErrors(['image' => 'Có lỗi xảy ra khi cập nhật ảnh sản phẩm: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        if ($product->image && $product->image !== 'default-product.png') {
            $oldPath = public_path('images/' . $product->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
