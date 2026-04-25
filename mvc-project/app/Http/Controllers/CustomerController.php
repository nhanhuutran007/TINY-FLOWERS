<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest('user_id')
            ->get();
            
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'address' => 'nullable'
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Thêm khách hàng thành công!');
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers,phone,' . $customer->id,
            'address' => 'nullable'
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'customer') {
            $user->delete();
        }
        return redirect()->route('customers.index')->with('success', 'Xóa khách hàng thành công!');
    }
}
