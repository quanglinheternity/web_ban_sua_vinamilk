@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Chi tiết đánh giá</h2>
    <div class="card">
        <div class="card-body">
            <h4>Sản phẩm: {{ optional($review->product)->ten_san_pham }}</h4>
            <h5>Khách hàng: {{ optional($review->customer)->ten_khach_hang }}</h5>
            <p><strong>Đánh giá:</strong> {{ $review->rating }}/5</p>
            <p><strong>Bình luận:</strong> {{ $review->comment }}</p>
            <p><strong>Ngày tạo:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
