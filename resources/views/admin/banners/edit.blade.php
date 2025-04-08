@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh Sửa Banner</h2>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-md-12">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}">
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $banner->description) }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>



            <div class="mb-3 col-md-6">
                <label class="form-label">Ảnh hiện tại</label><br>
                @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" class="img-thumbnail" width="150">
                @else
                    <p>Chưa có ảnh</p>
                @endif
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Chọn ảnh mới</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3 col-md-12">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
