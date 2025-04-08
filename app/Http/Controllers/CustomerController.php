<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        if ($request->filled('ten_khach_hang')) {
            $query->where('ten_khach_hang', 'like', '%' . $request->ten_khach_hang . '%');
        }
        $customers = $query->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_khach_hang' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'so_dien_thoai' => 'required|string|max:15',
            'dia_chi' => 'nullable|string',
        ]);

        Customer::create($request->all());
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng đã được thêm');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_khach_hang' => "required|string|max:255|unique:customers,ten_khach_hang,$id",
            'email' => "required|email|unique:customers,email,$id",
            'so_dien_thoai' => 'required|string|max:15||regex:/^0[0-9]{9,14}$/',
            'dia_chi' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng đã được cập nhật');
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng đã được xóa');
    }
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore(); // Khôi phục

        return redirect()->route('admin.customers.trashed')->with('success', 'Khách hàng đã được khôi phục!');
    }
    public function trashed()
    {
        $customers = customer::onlyTrashed()->paginate(10);
        return view('admin.customers.trashed', compact('customers'));
    }
    public function forceDelete($id)
    {
        $customer = customer::onlyTrashed()->findOrFail($id);
        $customer->forceDelete(); // Xóa vĩnh viễn khỏi database

        return redirect()->route('admin.customers.trashed')->with('success', 'Khách hàng đã bị xóa vĩnh viễn!');
    }
}
