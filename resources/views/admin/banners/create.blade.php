@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Banner</h2>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Ảnh Banner</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Banner</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
