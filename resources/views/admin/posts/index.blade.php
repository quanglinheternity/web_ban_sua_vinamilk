@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Bài Viết</h2>
    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form tìm kiếm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm bài viết</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.posts.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" value="{{ request('title') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync"></i> Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <a href="{{ route('admin.posts.create') }}" class="btn btn-success btn-sm mb-3">+ Thêm Bài Viết</a>
    @if (\App\Models\Post::onlyTrashed()->count() > 0)
        <a href="{{ route('admin.posts.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Bài Viết Đã Xóa</a>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" width="100">
                    @endif
                </td>
                <td>
                    @if ($post->status)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="{{ route('admin.posts.edit', $post->title) }}" class="btn btn-primary btn-sm">Sửa</a>

                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
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
        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
