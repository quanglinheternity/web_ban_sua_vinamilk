@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách khách hàng</h3>
        </div>

        <!-- Form tìm kiếm -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm khách hàng</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.customers.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" name="ten_khach_hang" class="form-control" placeholder="Nhập tên khách hàng" value="{{ request('ten_khach_hang') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Nhập email" value="{{ request('email') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 me-3">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary w-100 ms-1 ml-3">
                                <i class="fas fa-sync"></i> Làm mới
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-body">
            <a href="{{ route('admin.customers.create') }}" class="btn btn-success btn-sm mb-3">+ Thêm</a>
            @if (\App\Models\Customer::onlyTrashed()->count() > 0)
                <a href="{{ route('admin.customers.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Khách Hàng Đã Xóa</a>
            @endif
            <table id="customerTable" class="table table-bordered table-striped">
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
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary btn-sm d-inline-block">Sửa</a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" class="d-inline-block" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="h-14.5">
        {{ $customers->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#customerTable').DataTable({
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "info": "Hiển thị _START_ đến _END_ của _TOTAL_ khách hàng",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Tiếp",
                    "previous": "Trước"
                },
            }
        });
    });
</script>
@endsection
