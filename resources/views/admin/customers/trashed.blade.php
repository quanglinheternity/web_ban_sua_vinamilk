@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Danh sách đánh giá đã xóa</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->ten_khach_hang }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->so_dien_thoai }}</td>
                    <td>{{ $customer->dia_chi }}</td>

                    <td>
                        <form action="{{ route('admin.customers.restore', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">Khôi phục</button>
                        </form>

                        <form action="{{ route('admin.customers.forceDelete', $customer->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn khách hàng này không?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa vĩnh viễn</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $customers->links('pagination::bootstrap-4') }}
        <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>
@endsection
