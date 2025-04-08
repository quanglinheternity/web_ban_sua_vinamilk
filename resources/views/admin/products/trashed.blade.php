@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Sản Phẩm Đã Xóa Mềm</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->ma_san_pham }}</td>
                <td>{{ $product->ten_san_pham }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="80">
                    @else
                        Không có ảnh
                    @endif
                </td>
                <td>{{ $product->category->ten_danh_muc ?? 'Không xác định' }}</td>
                <td>
                    @if ($product->trang_thai)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-danger">Tạm ngừng</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm">Khôi phục</button>
                    </form>
                    <form action="{{ route('admin.products.forceDelete', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa vĩnh viễn</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $products->links('pagination::bootstrap-4') }}
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>
</div>
@endsection
