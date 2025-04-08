@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Sửa Khách Hàng</h2>

    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Tên khách hàng</label>
                <input type="text" name="ten_khach_hang" class="form-control @error('ten_khach_hang') is-invalid @enderror" value="{{ old('ten_khach_hang', $customer->ten_khach_hang) }}">
                @error('ten_khach_hang') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}">
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror" value="{{ old('so_dien_thoai', $customer->so_dien_thoai) }}">
                @error('so_dien_thoai') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control @error('dia_chi') is-invalid @enderror" value="{{ old('dia_chi', $customer->dia_chi) }}">
                @error('dia_chi') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật khách hàng</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
