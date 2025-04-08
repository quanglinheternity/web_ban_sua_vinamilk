@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Bài Viết Mới</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tiêu đề" value="{{ old('title') }}" >
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nội dung -->
                <div class="mb-3">
                    <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Nhập nội dung bài viết" >{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label class="form-label">Ảnh đại diện</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút lưu -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Lưu bài viết</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
