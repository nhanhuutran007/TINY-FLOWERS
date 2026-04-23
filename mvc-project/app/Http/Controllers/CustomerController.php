<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
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

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Xóa khách hàng thành công!');
    }
}
