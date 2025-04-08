@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Danh sách đánh giá đã xóa</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Khách hàng</th>
                    <th>Đánh giá</th>
                    <th>Bình luận</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ optional($review->product)->name }}</td>
                        <td>{{ optional($review->customer)->name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ $review->comment }}</td>
                        <td>
                            <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Khôi phục</button>
                            </form>

                            <form action="{{ route('admin.reviews.forceDelete', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn đánh giá này không?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $reviews->links() }}
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>
@endsection
