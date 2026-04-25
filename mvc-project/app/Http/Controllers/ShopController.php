<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 1);

        if ($request->has('category') && $request->category != '') {
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

    public function checkout()
    {
        $title = 'Thanh toán';
        return view('shop.checkout', compact('title'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'cart_data' => 'required|string'
        ]);

        $cartData = json_decode($request->cart_data, true);

        if (empty($cartData)) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Process customer
        $customer = Customer::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => $request->name, 'address' => $request->address]
        );

        $subtotal = 0;
        foreach ($cartData as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $shippingFee = 30000;
        if ($subtotal > 1000000) {
            $shippingFee = 0;
        }
        
        $totalAmount = $subtotal + $shippingFee;

        $orderNumber = 'ORD-' . strtoupper(Str::random(6));
        
        $order = new Order();
        $order->order_number = $orderNumber;
        $order->customer_id = $customer->id;
        $order->user_id = null;
        $order->subtotal = $subtotal;
        $order->shipping_fee = $shippingFee;
        $order->total_amount = $totalAmount;
        $order->amount_paid = 0;
        $order->change_amount = 0;
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'pending';
        $order->shipping_address = $request->address;
        $order->notes = $request->notes;
        $order->status = 'pending';
        $order->save();

        foreach ($cartData as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->product_name = $product->name;
                $orderItem->cost_price = $product->cost_price;
                $orderItem->selling_price = $item['price'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->subtotal = $item['price'] * $item['quantity'];
                $orderItem->save();
                
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }
        }

        $customer->total_spent += $totalAmount;
        $customer->save();

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function checkoutSuccess($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        $title = 'Đặt hàng thành công';
        return view('shop.checkout-success', compact('order', 'title'));
    }
}
