@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Danh sách đánh giá</h2>
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="product_name" class="form-control" placeholder="Tên sản phẩm" value="{{ request('product_name') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-control">
                        <option value="">-- Số sao --</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Sao</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Sao</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Sao</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Sao</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Sao</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-9">Tìm kiếm</button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary px-3">Reset</a>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (\App\Models\Review::onlyTrashed()->count() > 0)
        <a href="{{ route('admin.reviews.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Đánh Giá Đã Xóa</a>
    @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Khách hàng</th>
                    <th>Đánh giá</th>
                    <th>Bình luận</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ optional($review->product)->ten_san_pham }}</td>
                        <td>{{ optional($review->customer)->ten_khach_hang }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ $review->comment }}</td>
                        <td>
                            @if ($review->status)
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-warning">Đã ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info">Xem</a>
                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-primary">Sửa</a>
                            <form action="{{ route('admin.reviews.toggleStatus', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $review->status ? 'btn-warning' : 'btn-success' }}">
                                    {{ $review->status ? 'Ẩn' : 'Duyệt' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $reviews->links() }}
    </div>
@endsection
