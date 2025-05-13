@extends('admin.layouts.master')

@section('title', 'Danh mục đã xóa mềm')

@section('content')
    <div class="container mt-4">
        <h2>Danh mục đã xóa mềm</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->ten_danh_muc }}</td>
                        <td>{{ $category->trang_thai ? 'Hoạt động' : 'Ẩn' }}</td>
                        <td>
                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                            </form>

                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection
