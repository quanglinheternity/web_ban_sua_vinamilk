@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Danh Mục</h2>



    <form action="{{ route('admin.categories.store') }}" method="POST" >
        @csrf
        <div class="row">
        <div class="mb-3 col-md-12">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="ten_danh_muc" class="form-control @error('ten_danh_muc') is-invalid @enderror" value="{{ old('ten_danh_muc') }}" >
            @error('ten_danh_muc') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label">Trạng thái</label>
            <select name="trang_thai" class="form-control" required>
                <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Tạm ngừng</option>
            </select>
            @error('trang_thai') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

        <button type="submit" class="btn btn-primary">Thêm Danh mục</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
