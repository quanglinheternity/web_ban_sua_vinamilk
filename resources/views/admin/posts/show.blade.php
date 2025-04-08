@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chi Tiết Bài Viết</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Tiêu đề -->
            <h2 class="text-primary">{{ $post->title }}</h2>

            <!-- Ảnh đại diện -->
            @if ($post->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid" style="max-width: 500px; max-height: 400px;">
                </div>
            @endif

            <!-- Nội dung -->
            <div class="mb-3">
                <label class="fw-bold">Nội dung:</label>
                <p>{!! nl2br(e($post->content)) !!}</p>
            </div>

            <!-- Trạng thái -->
            <div class="mb-3">
                <label class="fw-bold">Trạng thái:</label>
                @if ($post->status)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </div>

            <!-- Ngày tạo -->
            <div class="mb-3">
                <label class="fw-bold">Ngày tạo:</label>
                <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <!-- Ngày cập nhật -->
            <div class="mb-3">
                <label class="fw-bold">Cập nhật lần cuối:</label>
                <span>{{ $post->updated_at->format('d/m/Y H:i') }}</span>
            </div>

            <!-- Nút quay lại -->
            <div class="mb-3">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">Sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection
