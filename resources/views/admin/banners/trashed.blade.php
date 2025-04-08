@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Banners Đã Xóa</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-sm mb-3">Quay Lại</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td>{{ $banner->title }}</td>
                <td><img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" width="100"></td>
                <td>{{ $banner->description }}</td>
                <td>
                    <a href="{{ route('admin.banners.restore', $banner->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                    <form action="{{ route('admin.banners.forceDelete', $banner->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa Vĩnh Viễn</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $banners->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
