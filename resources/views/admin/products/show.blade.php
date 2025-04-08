@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chi Tiết Sản Phẩm</h2>

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $product->img) ?
                asset('storage/' . $product->img) : asset('images/no-image.jpg') }}"
                 alt="{{ $product->ten_san_pham }}" class="card-img-top">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->ten_san_pham }}</h2>
                    <p class="card-text"><strong>Mã sản phẩm:</strong> {{ $product->ma_san_pham }}</p>
                    <p class="card-text"><strong>Mô tả:</strong> {{ $product->mo_ta }}</p>
                    <p class="card-text"><strong>Giá:</strong> {{ number_format($product->gia, 0, ',', '.') }} VNĐ</p>
                    <p class="card-text"><strong>Giá khuyến mãi:</strong> {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VNĐ</p>
                    <p class="card-text"><strong>Số lượng:</strong> {{ $product->so_luong }}</p>
                    <p class="card-text"><strong>Ngày nhập:</strong> {{ $product->ngay_nhap }}</p>
                    <p class="card-text"><strong>Danh mục:</strong> {{ $product->categories->ten_danh_muc  ?? 'Chưa có danh mục' }}</p>
                    <p class="card-text"><strong>Trạng thái:</strong>
                        @if($product->status)
                            <span class="badge bg-success">Còn hàng</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif
                    </p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
