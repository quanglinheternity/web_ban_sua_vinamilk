@extends('client.layouts.master')

@section('content')

<!-- page-title -->
<div class="tf-page-title" style="margin-top: 100px;">
    <div class="container-full">
        <div class="heading text-center">Giỏ hàng của bạn</div>
    </div>
</div>
<!-- /page-title -->
@if (session()->has('message'))
    <div class="alert {{ session('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- page-cart -->
<section class="flat-spacing-11">
    <div class="container">
        <div class="tf-page-cart-wrap">
            <div class="tf-page-cart-item">
                <div id="success-message" style="display: none;">
                    Sản phẩm đã được xóa khỏi giỏ hàng thành công.
                </div>
                <table class="tf-table-page-cart">
                    <thead>
                        <tr>
                            <th class="pro-thumbnail">Ảnh sản phẩm</th>
                            <th class="pro-title">Tên sản phẩm</th>
                            <th class="pro-price">Giá tiền</th>
                            <th class="pro-quantity">Số lượng</th>
                            <th class="pro-subtotal">Tổng tiền</th>
                            <th class="pro-remove">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tongGioHang = 0;
                        @endphp
                        @foreach ($chiTietGioHang as $sanPham)
                            @php
                                $giaSanPham = $sanPham->product->gia_khuyen_mai ?? $sanPham->product->gia;
                                $tongTienSanPham = $giaSanPham * $sanPham->so_luong;
                                $tongGioHang += $tongTienSanPham;
                            @endphp
                            <tr data-id="{{ $sanPham->product->id }}">
                                <td class="pro-thumbnail">
                                    <a href="{{ route('client.showProduct', $sanPham->product->id) }}" class="img-box">
                                        <img src="{{ asset(Storage::url($sanPham->product->img)) }}" alt="Ảnh sản phẩm" width="150">
                                    </a>
                                </td>
                                <td class="pro-title">{{ $sanPham->product->ten_san_pham }}</td>
                                <td class="pro-price">{{ number_format($sanPham->product->gia_khuyen_mai ?? $sanPham->product->gia) }} VND</td>
                                <td class="pro-quantity">
                                    <div class="wg-quantity small ">
                                        <button class="btn-quantity btn-decrease"style="border: none">-</button>
                                        <input type="text" class="quantity-product" value="{{ $sanPham->so_luong }}" data-dongia="{{ $sanPham->product->gia_khuyen_mai ?? $sanPham->product->gia }}" data-sanPhamId="{{$sanPham->product->id}}">
                                        <button class="btn-quantity btn-increase" style="border: none">+</button>
                                    </div>
                                </td>
                                <td class="pro-subtotal">{{ number_format(($sanPham->product->gia_khuyen_mai ?? $sanPham->product->gia) * $sanPham->so_luong) }} VND</td>
                                <td class="pro-remove">
                                    <button class="btn-remove" style="border: none"><i class="fa-regular fa-trash-can"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tf-page-cart-footer">
                <div class="tf-cart-footer-inner mt-3">
                    <div class="tf-page-cart-checkout">
                        <div class="shipping-calculator">
                            <summary class="accordion-shipping-header d-flex justify-content-between align-items-center collapsed" data-bs-target="#shipping" data-bs-toggle="collapse" aria-controls="shipping">
                                <h2 class="shipping-calculator-title">Tổng:</h2>
                            </summary>
                        </div>
                            <div class="tf-cart-totals-discounts">
                                <h3>Tạm Tính: </h3>
                                <span class="total-value">{{ number_format($tongGioHang) }}đ</span>
                            </div>
                            <div class="tf-cart-totals-discounts">
                                <h3>Tiền Vận Chuyển: </h3>
                                <span class="total-value">30.000đ</span>
                            </div>
                            <div class="tf-cart-totals-discounts">
                                <h3>Thành Tiền:</h3>
                                <span class="total-value">{{ number_format($tongGioHang + 30000) }}đ</span>
                            </div>
                            <div class="mt-5">
                                <button class="tf-btn w-100 btn-fill animate-hover-btn radius-3 justify-content-center checkout-btn" data-total="{{ $tongGioHang + 30000 }}">
                                    Check out
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Xóa sản phẩm
            $('.btn-remove').click(function(e) {
                e.preventDefault();
                if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?')){
                    var btnProductId = $(this).closest('tr').data('id');
                    // Thực hiện hành động xóa sản phẩm ở đây
                    // console.log('Xóa sản phẩm với ID:', btnProductId);
                    var row=$(this).closest('tr');
                    $.ajax({
                        url: '{{ route('client.removeFromCart') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            san_pham_id: btnProductId
                        },
                        success: function(response) {
                            row.remove();
                            updateCartTotal();
                            // console.log(response.message);
                            if (response.success) {
                                $('#success-message').show(); // Hiển thị thông báo
                                setTimeout(function() {
                                    $('#success-message').fadeOut(); // Ẩn thông báo sau 5 giây
                                }, 5000);
                            }
                        },
                        error: function(xhr) {
                            alert('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
                            console.log(xhr.responseText);
                            // dump(xhr);
                        }
                    });
               }
            });
            //sửa lý tăng giản
            $('.btn-quantity').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var input= button.closest('.wg-quantity').find('.quantity-product');
                var oldValue = parseFloat(input.val());
                // console.log(input);
                if(button.hasClass('btn-increase')) {
                    newValue = oldValue + 1;
                    // console.log(newValue);
                }else if(button.hasClass('btn-decrease') ) {
                    newValue = oldValue > 1 ? oldValue - 1 : 1;
                    // console.log(newValue);
                }
                //lấy thông tin  cần thiết để gửi ajax
                var sanPhamId = input.data('sanphamid');
                // console.log(sanPhamId);
                var donGia= input.data('dongia');
                // console.log(donGia);

                $.ajax({

                    url:'{{ route('client.updateCartQuantity')}}',
                    method:'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            san_pham_id: sanPhamId,
                            so_luong: newValue
                        },
                        success: function(response) {

                            // console.log(response);
                            if (response.success) {
                                // Cập nhật tổng tiền của sản phẩm này
                                var subtotal = newValue * donGia;
                                // Giả sử bạn có một phần tử hiển thị tổng tiền của sản phẩm
                                input.closest('tr').find('.pro-subtotal').text(subtotal.toLocaleString('vi-VN', { maximumFractionDigits: 0 }) + 'VND');

                                // Gọi hàm cập nhật tổng tiền giỏ hàng
                                updateCartTotal();
                            } else {
                                alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
                            }
                        },
                        error: function() {
                            alert('Không thể kết nối đến máy chủ.');
                        }

                });
            })
            $('.checkout-btn').click(function () {
                const total = $(this).data('total');
                // console.log(total);

                const form = $('<form>', {
                    action: "{{ route('client.checkout') }}",
                    method: 'POST'
                }).append($('<input>', {
                    type: 'hidden',
                    name: 'tong_gio_hang',
                    value: total
                })).append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: '{{ csrf_token() }}'
                }));

                $('body').append(form);
                form.submit(); // Gửi form thật, chuyển hướng thật
            });

                // Hàm tính toán và cập nhật tổng tiền của giỏ hàng
            function updateCartTotal() {
                var total = 0;
                $('.pro-subtotal').each(function() {
                    // Loại bỏ tất cả các ký tự không phải số và dấu thập phân
                    var cleanNumber = $(this).text().replace(/[^\d-]/g, '');
                    total += parseFloat(cleanNumber) || 0; // Nếu parseFloat thất bại, sử dụng 0
                });

                var shippingFee = 30000; // Phí vận chuyển cố định
                var grandTotal = total + shippingFee;

               // Cập nhật giá trị hiển thị
                $('.tf-cart-totals-discounts .total-value').eq(0).text(total.toLocaleString('vi-VN') + 'đ');
                $('.tf-cart-totals-discounts .total-value').eq(1).text(shippingFee.toLocaleString('vi-VN') + 'đ');
                $('.tf-cart-totals-discounts .total-value').eq(2).text(grandTotal.toLocaleString('vi-VN') + 'đ');
                 // Cập nhật giá trị ẩn cho tổng giỏ hàng
                $('input[name="tong_gio_hang"]').val(grandTotal);
            }
        });

    </script>
@endsection
