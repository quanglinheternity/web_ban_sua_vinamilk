@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Đơn Hàng</h2>
    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form tìm kiếm -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="order_code" class="form-control" placeholder="Nhập mã đơn hàng" value="{{ request('order_code') }}">
            </div>

            <div class="col-md-3">
                <select name="status_id" class="form-control">
                    <option value="">-- Trạng thái --</option>
                    @foreach ($order_statuses as $item)
                        <option value="{{ $item->id }}" {{ request('status_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->ten_trang_thai }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </div>
        </div>
    </form>


    <!-- Danh sách liên hệ -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn hàng</th>
                <th>Tên người nhận</th>
                <th>Số điện thoại</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order  )
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->ten_nguoi_nhan }}</td>
                <td>{{ $order->so_dien_thoai }}</td>
                <td>{{ number_format($order->tong_tien, 0, ',', '.') }} VNĐ</td>
                <td>{{ $order->orderStatus->ten_trang_thai }}</td>
                <td>{{ $order->paymentMethod->ten_phuong_thuc }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Xem</a>
                    {{-- <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Sửa</a> --}}
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Phân trang -->
<div class="h-14.5">
        {{ $orders->links( 'pagination::bootstrap-4'  ) }}
</div>
</div>
@endsection
