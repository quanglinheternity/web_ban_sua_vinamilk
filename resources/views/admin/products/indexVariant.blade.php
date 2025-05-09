@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="container mt-4">
        <h2 class="mb-4">Sản Phẩm</h2>

        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $product->img) ?
                    asset('storage/' . $product->img) : asset('images/no-image.jpg') }}"
                     alt="{{ $product->ten_san_pham }}" class="card-img-top">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title">{{ $product->ten_san_pham }}</h2>
                        <p class="card-text"><strong>Mã sản phẩm:</strong> {{ $product->ma_san_pham }}</p>
                        <p class="card-text"><strong>Giá:</strong> {{ number_format($product->gia, 0, ',', '.') }} VNĐ</p>
                        <p class="card-text"><strong>Giá khuyến mãi:</strong> {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VNĐ</p>
                        <p class="card-text"><strong>Trạng thái:</strong>
                            @if($product->status)
                                <span class="badge bg-success">Còn hoạt động</span>
                            @else
                                <span class="badge bg-danger">Hết hoạt động</span>
                            @endif
                        </p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm biến thể</h3>
            </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
         @endif
         {{-- Danh sách san pham --}}
            <div class="card-body">
                <a href="{{ route('admin.products.variants.create' , $product->id) }}" class="btn btn-success btn-sm mb-3">+ Thêm</a>
                {{-- @if(\App\Models\Product::onlyTrashed()->count() > 0)
                    <a href="{{ route('admin.products.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Sản phẩm Đã Xóa</a>
                @endif --}}
                <h3>Chọn dung tích (ml):</h3>
                <select id="mlSelect" class="form-control mb-3">
                    <option value="">-- Chọn dung tích --</option>
                    @foreach ($productVariants as $variant)
                        <option value="ml_{{ $variant->id }}">{{ $variant->sizeMl->size_ml_name }}</option>
                    @endforeach
                </select>

<h3>Danh sách loại hộp:</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ML</th>
            <th>Mã biến thể</th>
            <th>Tên biến thể</th>
            <th>Giá</th>
            <th>Giá KM</th>
            <th>Loại hộp</th>
            <th>Tồn kho</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody id="boxList">
        @foreach ($productVariants as $variant)
            @foreach ($variant->detailProductVariants as $detail)
                <tr class="box-row" data-ml="ml_{{ $variant->id }}">
                    <td>{{ $variant->sizeMl->size_ml_name ?? 'Không có' }}</td>
                    <td>{{ $detail->variant_code ?? 'Không có mã' }}</td>
                    <td>{{ $detail->variant_name }}</td>
                    <td>{{ number_format($detail->price, 2) }} VNĐ</td>
                    <td>{{ number_format($detail->promotional_price, 2) }} VNĐ</td>
                    <td>{{ $detail->sizeBox->size_box_name ?? 'Không có' }}</td>
                    <td>{{ $detail->stock }}</td>
                    <td>
                        <a href="{{ route('admin.products.variants.edit', [$product->id, $detail->id]) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('admin.products.variants.destroy', $detail->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
            </div>
        </div>
        {{-- <div class="h-14.5">
            {{ $product->links( 'pagination::bootstrap-4'  ) }}
        </div> --}}
    </div>
</div>
@endsection

@section('scripts')
<script>




    // Gọi khi trang load

    document.addEventListener('DOMContentLoaded', function () {
        const mlSelect = document.getElementById('mlSelect');
        const rows= document.querySelectorAll('.box-row');
        // console.log(rows);
        mlSelect.addEventListener('change', function () {
            const selectedValue = mlSelect.value;
            rows.forEach(row => {
                row.style.display = (selectedValue === '' || row.dataset.ml === selectedValue) ? '' : 'none';

            })
        })
    })
    // $(document).ready(function () {
    //     $('#productTable').DataTable({
    //         "language": {
    //             "search": "Tìm kiếm:",
    //             "lengthMenu": "Hiển thị _MENU_ dòng",
    //             "info": "Hiển thị _START_ đến _END_ của _TOTAL_ sản phẩm",
    //             "paginate": {
    //                 "first": "Đầu",
    //                 "last": "Cuối",
    //                 "next": "Tiếp",
    //                 "previous": "Trước"
    //             },
    //         }
    //     });
    // });
    // function updatePriceRange() {
    //     let min = document.getElementById('gia_min_range').value;
    //     let max = document.getElementById('gia_max_range').value;

    //     // Đảm bảo min không lớn hơn max
    //     if (parseInt(min) > parseInt(max)) {
    //         document.getElementById('gia_min_range').value = max;
    //         document.getElementById('gia_max_range').value = min;
    //         min = document.getElementById('gia_min_range').value;
    //         max = document.getElementById('gia_max_range').value;
    //     }

    //     // Hiển thị giá trị trên giao diện
    //     document.getElementById('price-range-text').innerText = min + " - " + max + " VNĐ";
    // }
    // window.onload = function () {
    //     updatePriceRange();
    // };
</script>

@endsection
