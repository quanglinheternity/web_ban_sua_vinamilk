@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chi Tiết Đơn Hàng: {{ $order->order_code }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Back Button -->
    <div class="d-flex justify-content-between mb-3">
        <div class="mb-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        @foreach ($orderStatuses as $trangThai => $nextTrangThai)


            @if($nextTrangThai->id == $order->trang_thai_id)
            @php
                $trangThaiSau = null;
                        foreach ($orderStatuses as $nextTrangThai) {
                            if (($nextTrangThai['id'] == $order['trang_thai_id'] + 1) && $nextTrangThai['id'] <= 3) {
                                $trangThaiSau = $nextTrangThai;
                                break;
                            }
                        }
                        // dd($trangThaiSau);

            @endphp

            <div class="d-flex gap-2">
            @if(isset($trangThaiSau) && $trangThaiSau['id'] <= 3)
            <div class="mb-3 mr-2 ">
                    <form action="{{ route('admin.orders.update.status', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="trang_thai_id" value="{{ $nextTrangThai->id }}">
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Bạn có chắc chắn muốn chuyển trạng thái đơn hàng này sang {{ $nextTrangThai->ten_trang_thai }}?')">
                            {{ $nextTrangThai->ten_trang_thai }}
                        </button>
                    </form>
            </div>
                @if($order['trang_thai_id'] == 1)
                <div class="mb-3 ml-2">
                    <form action="{{ route('admin.orders.update.status', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn Hủy đơn hàng này?')">
                            <input type="hidden" name="trang_thai_id" value="4">
                            <i class="fas fa-trash"></i> Hủy đơn hàng
                        </button>
                    </form>
                </div>
                @endif
            @endif
        </div>
            @endif

        @endforeach

    </div>

    <!-- Order Information Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Thông tin chung
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Customer Info -->
                <div class="col-md-6">
                    <h5 class="mb-3">Thông tin khách hàng</h5>
                    <p><strong>Tên người nhận:</strong> {{ $order->ten_nguoi_nhan }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->so_dien_thoai }}</p>
                    <p><strong>Email:</strong> {{ $order->email_nguoi_nhan ?? 'N/A' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->dia_chi_nhan_hang }}</p>
                </div>

                <!-- Order Details -->
                <div class="col-md-6">
                    <h5 class="mb-3">Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong>
                        <span class="badge bg-info">
                            {{ $order->orderStatus->ten_trang_thai }}
                        </span>
                    </p>
                    <p><strong>Phương thức TT:</strong>
                        {{ $order->paymentMethod->ten_phuong_thuc }}
                    </p>
                    <p><strong>Ghi chú:</strong> {{ $order->ghi_chu ?? 'Không có' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Chi tiết sản phẩm
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="55%">Sản phẩm</th>
                        <th width="15%" class="text-center">Số lượng</th>
                        <th width="15%" class="text-end">Đơn giá</th>
                        <th width="15%" class="text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $item)
                    <tr>
                        <td>{{ $item->detailProductVariants->productVariant->product->ten_san_pham }}</td>
                        <td class="text-center">{{ $item->so_luong }}</td>
                        <td class="text-end">{{ number_format($item->detailProductVariants->promotional_price ?? $item->detailProductVariants->price, 0, ',', '.') }}₫</td>
                        <td class="text-end">{{ number_format($item->tong_tien, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="row justify-content-end">
         <!-- Order Status Update Form -->

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-subtitle mb-2">Tổng hợp đơn hàng</h5>
                    <div class="d-flex justify-content-between">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->tong_tien - 30000, 0, ',', '.') }}₫</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Phí vận chuyển:</span>
                        <span>30.000₫</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-danger">
                            {{ number_format($order->tong_tien, 0, ',', '.') }}₫
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>
@endsection

<style>
    .table thead th {
        background-color: #f8f9fa;
    }
    .card-header {
        font-weight: 600;
    }
</style>
