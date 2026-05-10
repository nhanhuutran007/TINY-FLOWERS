<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('inventory.index', compact('products'));
    }

    public function stockEntry(Request $request)
    {
        $query = Product::with('category')->orderBy('stock_quantity', 'asc')->orderBy('name', 'asc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('barcode', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->get();
        return view('inventory.stock-entry', compact('products'));
    }

    public function storeStockEntry(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255'
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock_quantity += $request->quantity;
        
        // If stock was 0 (status 0), and now it's > 0, we might want to keep it as 0 unless admin manually changes it, 
        // OR we can auto-enable it if that's what the user prefers. 
        // Based on previous logic, saving it will trigger the boot method.
        // The boot method sets status to 0 IF stock <= 0. It doesn't set it to 1 if stock > 0.
        // So the admin will still need to manually enable the product if it was "Stopped Selling".
        
        $product->save();

        return redirect()->route('inventory.stock-entry')->with('success', "Đã nhập thêm {$request->quantity} sản phẩm cho '{$product->name}' thành công!");
    }

    public function stockAlerts()
    {
        $lowStockThreshold = 10;
        
        $outOfStock = Product::where('stock_quantity', '<=', 0)->get();
        $lowStock = Product::where('stock_quantity', '>', 0)
                           ->where('stock_quantity', '<', $lowStockThreshold)
                           ->get();
                           
        return response()->json([
            'total' => $outOfStock->count() + $lowStock->count(),
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock
        ]);
    }
}
