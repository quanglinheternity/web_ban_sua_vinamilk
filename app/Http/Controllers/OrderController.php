<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['orderStatus', 'paymentMethod']);
        // Add filters if needed
        if ($request->has('order_code')) {
            $query->where('order_code', 'like', '%' . $request->order_code . '%');
        }
        if ($request->has('status_id')) {
            $query->where('trang_thai_id', $request->status_id);
        }
        if ($request->has('payment_status')) {
            $query->where('trang_thai_thanh_toan', $request->payment_status);
        }

        // Pagination
        $perPage = $request->per_page ?? 15;
        $orders = $query->paginate($perPage);
        // $paymentMethods = PaymentMethod::all();
        $order_statuses = OrderStatus::all();
        // dd($orders);
        return view('admin.orders.index' , compact('orders', 'order_statuses'));
    }


    public function updateStatus(Request $request, string $id)
    {
        // dd($request->all());
        $order = Order::findOrFail($id);
        $order->update([
            'trang_thai_id' => $request->trang_thai_id,
        ]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $order = Order::with(['orderDetails.detailProductVariants.productVariant.product' ,'orderStatus', 'paymentMethod'])->findOrFail($id);
        // dd($order->orderDetails->first()->detailProductVariants->productVariant->product);
        // dd($order->orderStatus);
        $orderStatuses = OrderStatus::all();
        // dd($orderStatuses-);
        return view('admin.orders.show', compact('order', 'orderStatuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Xóa đơn hàng thành công');
    }
}
