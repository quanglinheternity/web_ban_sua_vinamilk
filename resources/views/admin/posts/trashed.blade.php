@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Bài Viết Đã Xóa</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách bài viết
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Ngày xóa</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trashedPosts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="100">
                    @else
                        <span class="text-muted">Không có ảnh</span>
                    @endif
                </td>
                <td>{{ $post->deleted_at }}</td>
                <td>
                    <!-- Khôi phục bài viết -->
                    <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-undo"></i> Khôi phục
                        </button>
                    </form>

                    <!-- Xóa vĩnh viễn bài viết -->
                    <form action="{{ route('admin.posts.forceDelete', $post->id) }}" method="POST" class="d-inline-block"
                          onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn bài viết này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Xóa vĩnh viễn
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $trashedPosts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
