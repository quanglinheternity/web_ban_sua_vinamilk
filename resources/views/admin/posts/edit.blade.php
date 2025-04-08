@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh Sửa Bài Viết</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post->title) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Tiêu đề -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $post->title) }}">
                        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <!-- Nội dung -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Nội dung</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $post->content) }}</textarea>
                        @error('content') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <!-- Ảnh đại diện -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image') <div class="text-danger">{{ $message }}</div> @enderror

                        @if ($post->image)
                            <div class="mt-2">
                                <p>Ảnh hiện tại:</p>
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh hiện tại" class="img-thumbnail" width="200">
                            </div>
                        @endif
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $post->status) == '1' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('status', $post->status) == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Nút lưu -->
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
