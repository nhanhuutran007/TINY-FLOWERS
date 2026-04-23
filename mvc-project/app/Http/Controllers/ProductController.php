<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'barcode' => 'required|unique:products,barcode,' . $product->id,
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && $product->image !== 'default-product.png') {
                $oldPath = public_path('uploads/products/' . $product->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && $product->image !== 'default-product.png') {
            $oldPath = public_path('uploads/products/' . $product->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
