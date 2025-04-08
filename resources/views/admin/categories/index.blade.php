@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách danh mục</h3>
        </div>

        <!-- Form tìm kiếm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm danh mục</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}">
                <div class="row g-3">
                    <!-- Mã sản phẩm -->
                    <div class="col-md-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="ten_danh_muc" class="form-control" placeholder="Nhập Tên Danh Mục"
                            value="{{ request('ten_danh_muc') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-control">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                    </div>
                    <!-- Nút tìm kiếm & Làm mới -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-3 ">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary w-100 ms-1 ml-3">
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
     {{-- Danh sách san pham --}}
        <div class="card-body">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm mb-3">+ Thêm</a>
            @if (\App\Models\Category::onlyTrashed()->count() > 0)
                <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Danh Mục Đã Xóa</a>

            @endif
            <table id="productTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Danh mục sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Thời gian tạo</th>
                        <th>Thời gian cập nhật</th>
                        <th>Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cate)
                    <tr>
                        <td>{{ $cate->id }}</td>
                        <td>{{ $cate->ten_danh_muc }}</td>
                        <td>
                            @if ($cate->trang_thai == true)
                                <span class="badge badge-success">Còn hoạt động</span>
                            @else
                                <span class="badge badge-danger">Hết hoạt động</span>
                            @endif
                        </td>
                        <td>{{ $cate->created_at }}</td>
                        <td>{{ $cate->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cate->id)}}" class="btn btn-primary btn-sm d-inline-block">Sửa</a>
                            <form action="{{ route('admin.categories.destroy', $cate->id)}}"class="d-inline-block" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">XÓA</button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="h-14.5">
        {{ $categories->links( 'pagination::bootstrap-4'  ) }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "info": "Hiển thị _START_ đến _END_ của _TOTAL_ sản phẩm",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Tiếp",
                    "previous": "Trước"
                },
            }
        });
    });

    function updatePriceRange() {
        let min = document.getElementById('gia_min_range').value;
        let max = document.getElementById('gia_max_range').value;

        // Đảm bảo min không lớn hơn max
        if (parseInt(min) > parseInt(max)) {
            document.getElementById('gia_min_range').value = max;
            document.getElementById('gia_max_range').value = min;
            min = document.getElementById('gia_min_range').value;
            max = document.getElementById('gia_max_range').value;
        }

        // Hiển thị giá trị trên giao diện
        document.getElementById('price-range-text').innerText = min + " - " + max + " VNĐ";
    }

    // Gọi khi trang load
    window.onload = function () {
        updatePriceRange();
    };
</script>

@endsection
