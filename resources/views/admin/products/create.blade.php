@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Sản Phẩm</h2>



    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Mã sản phẩm</label>
            <input type="text" name="ma_san_pham"
                class="form-control @error('ma_san_pham') is-invalid @enderror"
                value="{{ old('ma_san_pham') }}">
            @error('ma_san_pham') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="ten_san_pham" class="form-control @error('ten_san_pham') is-invalid @enderror" value="{{ old('ten_san_pham') }}" >
            @error('ten_san_pham') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-control
            @error('category_id') is-invalid
            @enderror" >
                <option value="">Chọn danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->ten_danh_muc }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Giá</label>
            <input type="number" name="gia" class="form-control @error('gia') is-invalid @enderror" value="{{ old('gia') }}" min="0" >
            @error('gia') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label ">Giá khuyến mãi</label>
            <input type="number" name="gia_khuyen_mai" class="form-control @error('gia_khuyen_mai') is-invalid @enderror" value="{{ old('gia_khuyen_mai') }}" min="0">
            @error('gia_khuyen_mai') <div class="text-danger">{{ $message }}</div> @enderror
        </div>


        <div class="mb-3 col-md-6">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control  @error('image') is-invalid @enderror">
            @error('image') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="" class="form-label ">Số lượng</label>
            <input type="number" name="so_luong" class="form-control @error('so_luong') is-invalid @enderror " value="{{ old('so_luong') }}" min="0" >
            @error('so_luong') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="" class="form-label">Ngày nhập</label>
            <input type="date" name="ngay_nhap" class="form-control  @error('ngay_nhap') is-invalid
            @enderror" value="{{ old('ngay_nhap') }}" min="0" >
            @error('ngay_nhap') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label">Trạng thái</label>
            <select name="trang_thai" class="form-control" required>
                <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Tạm ngừng</option>
            </select>
            @error('trang_thai') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control">{{ old('mo_ta') }}</textarea>
            @error('mo_ta') <div class="text-danger">{{ $message }}</div> @enderror
        </div>


    </div>

        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
