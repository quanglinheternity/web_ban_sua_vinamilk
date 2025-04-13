@extends('client.layouts.master')
@section('content')
<style>
    .css_select_div {
        text-align: center;
    }

    .css_select {
        display: inline-table;
        width: 25%;
        padding: 5px;
        margin: 5px;
        border: solid 1px #686868;
        border-radius: 5px;
    }

    .size-selector {
        border-radius: 8px;
        padding: 10px;
        display: flex;
    }

    .size-option {
        margin: 0 5px;
        padding: 10px 20px;
        border: 1px solid #000;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .size-option:hover {
        background-color: #f0f0f0;
    }

    .size-option.active {
        background-color: #d9d9d9;
        color: white;
    }
</style>
<div id="header" class="header-default">
    <div class="px_15 lg-px_40">
        <div class="row wrapper-header align-items-center">
            <div class="col-md-4 col-3 tf-lg-hidden">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"></a>
            </div>
        </div>
    </div>
</div>
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">Thanh toán</div>
    </div>
</div>
<!-- /page-title -->

<!-- page-cart -->
<section class="flat-spacing-11">
    <div class="container">
        <div class="tf-page-cart-wrap layout-2">
            <div class="tf-page-cart-item">
                <h5 class="fw-5 mb_20">Thông Tin Chi Tiết</h5>
                <form class="form-checkout" action="{{ route('client.checkoutStore') }}" id="form1" method="POST">
                    @csrf
                    <div class="box">
                        <input type="hidden" name="tong_tien" value="{{ $tong_tien ?? 0 }}">
                        <fieldset class="fieldset">
                            <label for="ho_ten">Họ Tên</label>
                            <input type="text" class="form-control" id="ho_ten" name="ten_nguoi_nhan"
                                   value="{{ old('ten_nguoi_nhan', $User->name ?? '') }}"
                                   placeholder="Nhập họ tên người nhận...">
                            @error('ten_nguoi_nhan')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </fieldset>
                    </div>

                    <fieldset class="box fieldset">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email_nguoi_nhan"
                               value="{{ old('email_nguoi_nhan', $User->email ?? '') }}"
                               placeholder="Nhập email người nhận...">
                        @error('email_nguoi_nhan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="box fieldset">
                        <label for="sdt">Số điện thoại:</label>
                        <input type="text" class="form-control" id="sdt" name="sdt_nguoi_nhan"
                               value="{{ old('sdt_nguoi_nhan', $User->customer->so_dien_thoai ?? '') }}"
                               placeholder="Nhập số điện thoại người nhận...">
                        @error('sdt_nguoi_nhan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="box fieldset">
                        <label for="address">Địa chỉ:</label><br>
                        <select class="css_select" id="tinh" name="tinh" title="Chọn Tỉnh Thành">
                            <option value="">Tỉnh Thành</option>
                        </select>
                        <select class="css_select" id="quan" name="quan" title="Chọn Quận Huyện">
                            <option value="">Quận Huyện</option>
                        </select>
                        <select class="css_select" id="phuong" name="phuong" title="Chọn Phường Xã">
                            <option value="">Phường Xã</option>
                        </select>
                        <input type="hidden" id="ten_tinh" name="ten_tinh" value="{{ old('ten_tinh') }}">
                        <input type="hidden" id="ten_quan" name="ten_quan" value="{{ old('ten_quan') }}">
                        <input type="hidden" id="ten_phuong" name="ten_phuong" value="{{ old('ten_phuong') }}">

                        <input type="text" class="form-control" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan"
                               value="{{ old('dia_chi_nguoi_nhan', $User->customer->dia_chi ?? '') }}"
                               placeholder="Nhập địa chỉ cụ thể (sẽ được tự động cập nhật)">
                        @error('dia_chi_nguoi_nhan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="box fieldset">
                        <label for="note">Ghi chú</label>
                        <textarea class="form-control" name="ghi_chu" id="note"
                                  placeholder="Ghi chú">{{ old('ghi_chu') }}</textarea>
                        @error('ghi_chu')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="box fieldset">
                        <label for="payment">Phương thức thanh toán:</label>
                        <select class="form-control" id="payment" name="phuong_thuc_thanh_toan">
                            <option value="" selected disabled>Chọn phương thức thanh toán</option>
                            <option value="1" {{ old('phuong_thuc_thanh_toan') == 'cod' ? 'selected' : 'cod' }}>
                                Thanh toán khi nhận hàng (COD)
                            </option>
                            <option value="2" {{ old('phuong_thuc_thanh_toan') == 'vnpay' ? 'selected' : 'vnpay' }}>
                                VNPay
                            </option>
                        </select>
                        @error('phuong_thuc_thanh_toan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div class="box-checkbox fieldset-radio mb_20">
                        <input type="checkbox" name="confirmOrder" id="check-agree" class="tf-check"
                               {{ old('confirmOrder') ? 'checked' : '' }}>
                        <label for="check-agree" class="text_black-2">Xác nhận đặt hàng</label>
                        @error('confirmOrder')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="tf-btn radius-3 mt-4 btn-fill btn-icon animate-hover-btn justify-content-center">
                        Place Order
                    </button>
                </form>
            </div>
            <div class="tf-page-cart-footer">
                <div class="tf-cart-footer-inner">
                    <h5 class="fw-5 mb_20">Đơn Hàng</h5>
                    <form class="tf-page-cart-checkout widget-wrap-checkout" action="" onsubmit="handleSubmit()" method="POST">
                        <ul class="wrap-checkout-product">
                            <?php foreach ($chiTietGioHang as $sanpham) { ?>
                                <li class="checkout-product-item">
                                    <figure class="img-product">
                                        <img src="<?= $sanpham->product->img ?>" alt="product">
                                        <span class="quantity"><?= $sanpham->so_luong ?></span>
                                    </figure>
                                    <div class="content">
                                        <div class="info">
                                            <p class="name"><?= $sanpham->product->ten_san_pham ?></p>
                                        </div>
                                        <span class="price"><?= number_format(   ($sanpham->product->gia_khuyen_mai ?? $sanpham->product->gia) * $sanpham['so_luong']) ?>Đ</span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- <?php var_dump($tong_tien) ?> -->
                        <div class="coupon-box">
                            <input type="hidden" name="tong_gio_hang" value="<?= number_format($tong_tien) ?? 0 ?>">
                            <input type="text" name="code_Voucher" placeholder="Nhập mã Giảm Giá (nếu có)">
                            <button name="apply_Voucher" class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Áp Dụng</button><br>

                        </div>
                        {{-- <?php if (isset($voucher)) { ?>
                            <p class="text-danger"><?= $voucher  ?></p>
                        <?php } ?> --}}
                        <div class="d-flex justify-content-between line pb_18">
                            <h6 class="fw-4">Vận Chuyển</h6>
                            <h6 class="total fw-4">30.000Đ</h6>
                        </div>
                        <div class="d-flex justify-content-between line pb_20">
                            <h6 class="fw-5">Tổng</h6>
                            <input type="hidden" name="tong_tien" value="{{ $tong_tien }}">
                            <h6 class="total fw-5"><?= number_format( $tong_tien) ?>Đ</h6>
                        </div>
                        <div class="wd-check-payment">


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        //Lấy tỉnh thành
        $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm', function(data_tinh) {
            if (data_tinh.error == 0) {
                $.each(data_tinh.data, function(key_tinh, val_tinh) {
                    $("#tinh").append('<option value="' + val_tinh.id + '">' + val_tinh.full_name + '</option>');
                });
                $("#tinh").change(function(e) {
                    var idtinh = $(this).val();
                    $("#ten_tinh").val($("#tinh option:selected").text()); // Đặt tên tỉnh vào input ẩn

                    //Lấy quận huyện
                    $.getJSON('https://esgoo.net/api-tinhthanh/2/' + idtinh + '.htm', function(data_quan) {
                        if (data_quan.error == 0) {
                            $("#quan").html('<option value="0">Quận Huyện</option>');
                            $("#phuong").html('<option value="0">Phường Xã</option>');
                            $.each(data_quan.data, function(key_quan, val_quan) {
                                $("#quan").append('<option value="' + val_quan.id + '">' + val_quan.full_name + '</option>');
                            });

                            $("#quan").change(function(e) {
                                var idquan = $(this).val();
                                $("#ten_quan").val($("#quan option:selected").text()); // Đặt tên quận vào input ẩn

                                //Lấy phường xã
                                $.getJSON('https://esgoo.net/api-tinhthanh/3/' + idquan + '.htm', function(data_phuong) {
                                    if (data_phuong.error == 0) {
                                        $("#phuong").html('<option value="0">Phường Xã</option>');
                                        $.each(data_phuong.data, function(key_phuong, val_phuong) {
                                            $("#phuong").append('<option value="' + val_phuong.id + '">' + val_phuong.full_name + '</option>');
                                        });

                                        $("#phuong").change(function(e) {
                                            $("#ten_phuong").val($("#phuong option:selected").text()); // Đặt tên phường vào input ẩn
                                        });
                                    }
                                });
                            });
                        }
                    });
                });
            }
        });
    });
    $('form').on('submit', function () {
    let tenTinh = $('#tinh option:selected').text();
    let tenQuan = $('#quan option:selected').text();
    let tenPhuong = $('#phuong option:selected').text();
    let diaChiChiTiet = $('#dia_chi_cu_the').val().trim();

    // Kiểm tra nếu chưa chọn tỉnh/quận/phường
    if (!tenTinh || !tenQuan || !tenPhuong ||) {
        alert('Vui lòng điền đầy đủ địa chỉ.');
        return false; // Ngăn form submit
    }

    // Gộp địa chỉ
    let fullAddress = `${diaChiChiTiet}, ${tenPhuong}, ${tenQuan}, ${tenTinh}`;
    $('#dia_chi_nguoi_nhan').val(fullAddress);
});



</script>

@endsection
