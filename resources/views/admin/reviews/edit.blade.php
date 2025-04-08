@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa đánh giá</h2>
        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="product_id">Sản phẩm</label>
                <select name="product_id" class="form-control">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $review->product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="rating">Đánh giá</label>
                <input type="number" name="rating" class="form-control" min="1" max="5" value="{{ $review->rating }}">
            </div>

            <div class="mb-3">
                <label for="comment">Bình luận</label>
                <textarea name="comment" class="form-control">{{ $review->comment }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
@endsection
