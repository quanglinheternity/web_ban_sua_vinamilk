@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách sản phẩm</h3>
        </div>

        <!-- Form tìm kiếm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm sản phẩm</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}">
                <div class="row g-3">
                    <!-- Mã sản phẩm -->
                    <div class="col-md-3">
                        <label class="form-label">Mã sản phẩm</label>
                        <input type="text" name="ma_san_pham" class="form-control" placeholder="Nhập mã sản phẩm"
                            value="{{ request('ma_san_pham') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="ten_san_pham" class="form-control" placeholder="Nhập tên sản phẩm"
                            value="{{ request('ten_san_pham') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Danh mục sản phẩm</label>
                        <select name="category_id" class=" form-control">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $cate)
                                <option value="{{ $cate->id }}" {{ request('category') == $cate->id ? 'selected' : '' }}>
                                    {{ $cate->ten_danh_muc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Ngày nhập</label>
                        <input type="date" name="ngay_nhap" class="form-control" value="{{ request('ngay_nhap')}}" >
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Khoảng giá: <span id="price-range-text"></span></label>

                        <!-- Thanh kéo min-max -->
                        <input type="range" id="gia_min_range" name="gia_min" min="0" max="10000000" step="100"
                               value="{{ request('gia_min', 0) }}" oninput="updatePriceRange()">

                        <input type="range" id="gia_max_range" name="gia_max" min="0" max="10000000" step="100"
                               value="{{ request('gia_max', 10000000) }}" oninput="updatePriceRange()">
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
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100 ms-1 ml-3">
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
            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm mb-3">+ Thêm</a>
            @if(\App\Models\Product::onlyTrashed()->count() > 0)
                <a href="{{ route('admin.products.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Sản phẩm Đã Xóa</a>
            @endif
            <table id="productTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Giá</th>
                        <th>Giá khuyến mãi</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->ma_san_pham }}</td>
                        <td>{{ $product->categories->ten_danh_muc ?? 'Không có danh mục'}}</td>
                        <td>{{ $product->ten_san_pham }}</td>
                        <td><img src="{{ asset('storage/' . $product->img) }}" alt="" width="80px"></td>
                        <td>{{ number_format( $product->gia, 2) }} VNĐ</td>
                        <td>{{ number_format( $product->gia_khuyen_mai, 2) }} VNĐ</td>
                        <td>{{ $product->so_luong }}</td>
                        <td>
                            @if ($product->trang_thai == true)
                                <span class="badge badge-success">Còn hàng</span>
                            @else
                                <span class="badge badge-danger">Hết hàng</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-success btn-sm d-inline-block">Xem</a>
                            <a href="{{ route('admin.products.edit', $product->id)}}" class="btn btn-primary btn-sm d-inline-block">Sửa</a>
                            <form action="{{ route('admin.products.destroy', $product->id)}}"class="d-inline-block" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
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
        {{ $products->links( 'pagination::bootstrap-4'  ) }}
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
