@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Banners</h2>
    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form tìm kiếm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm banner</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.banners.index') }}">
                <div class="row g-3">
                    <!-- Tiêu đề -->
                    <div class="col-md-6">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" value="{{ request('title') }}">
                    </div>
                    <!-- Trạng thái -->
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                    <!-- Nút tìm kiếm & Làm mới -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync"></i> Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <a href="{{ route('admin.banners.create') }}" class="btn btn-success btn-sm mb-3">+ Thêm Banner</a>
    <!-- Kiểm tra nếu có banner đã xóa mềm thì hiển thị nút -->
    @if (\App\Models\Banner::onlyTrashed()->count() > 0)
        <a href="{{ route('admin.banners.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Banners Đã Xóa</a>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
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
                    @if ($banner->status)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
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
