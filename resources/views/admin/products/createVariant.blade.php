@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Sản Phẩm biến thể</h2>


    <form action="{{ route('admin.products.variants.store',  $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Mã code biến thế</label>
            <input type="text" name="variant_code"
                class="form-control @error('variant_code') is-invalid @enderror"
                value="{{ old('variant_code') }}">
            @error('variant_code') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Tên sản phẩm biến thể</label>
            <input type="text" name="variant_name" class="form-control @error('variant_name') is-invalid @enderror" value="{{ old('variant_name') }}" >
            @error('variant_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Size Ml</label>
            <select name="size_ml_id" class="form-control
            @error('size_ml_id') is-invalid
            @enderror" onchange="toggleSizeBox()" >
                <option value="">Chọn size ml</option>
                @foreach ($sizeMls as $sizeMl)
                    <option value="{{ $sizeMl->id }}" {{ old('size_ml_id') == $sizeMl->id ? 'selected' : '' }}>
                        {{ $sizeMl->size_ml_name }}
                    </option>
                @endforeach
            </select>
            @error('size_ml_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Size Hộp</label>
            <select name="size_box_id" id="sizeBoxSelect" class="form-control
            @error('size_box_id') is-invalid
            @enderror" disabled>
                <option value="">Chọn Size hộp</option>
                @foreach ($sizeBoxs as $sizeBox)
                    <option value="{{ $sizeBox->id }}" {{ old('size_box_id') == $sizeBox->id ? 'selected' : '' }}>
                        {{ $sizeBox->size_box_name }}
                    </option>
                @endforeach
            </select>
            @error('size_box_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Giá</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" >
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label ">Giá khuyến mãi</label>
            <input type="number" name="promotional_price" class="form-control @error('promotional_price') is-invalid @enderror" value="{{ old('promotional_price') }}" min="0">
            @error('promotional_price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 col-md-12">
            <label for="" class="form-label ">Số lượng</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror " value="{{ old('stock') }}" min="0" >
            @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
        </div>



    </div>

        <button type="submit" class="btn btn-primary">Thêm biến thể</button>
        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
@section('scripts')
<script>
    function toggleSizeBox() {
        var sizeMlSelect = document.querySelector('select[name="size_ml_id"]');
        var sizeBoxSelect = document.getElementById('sizeBoxSelect');
        if(sizeMlSelect.value) {
            sizeBoxSelect.disabled = false;
        } else {
            sizeBoxSelect.disabled = true;
            sizeBoxSelect.value = "";
        }
    }
    // Khởi tạo trạng thái khi load trang (phục hồi nếu có old value)
    document.addEventListener('DOMContentLoaded', function () {
        toggleSizeBox();
    });
</script>
@endsection
