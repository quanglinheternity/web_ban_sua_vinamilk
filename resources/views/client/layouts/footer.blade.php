<footer id="footer" class="footer md-pb-70">
    <div class="footer-wrap">
        <div class="footer-body">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="footer-infor">
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img src="./assets/images/logo.png" alt="">
                                </a>
                            </div>


                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 footer-col-block">
                        <div class="footer-heading footer-heading-desktop">
                            <h6>Liên Hệ:</h6>
                        </div>
                        <div class="footer-heading footer-heading-moblie">
                            <h6>Liên Hệ:</h6>
                        </div>
                        <ul>
                                <li>
                                    <p>Địa Chỉ: 13 đường Trịnh Văn Bô, Nam Từ Liêm <br> Hà Nội, Việt Nam</p>
                                </li>
                                <li>
                                    <p>Email: <a href="#">pawpaw@gmail.com</a></p>
                                </li>
                                <li>
                                    <p>Phone: <a href="#">123456789</a></p>
                                </li>
                            </ul>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="footer-newsletter footer-col-block">
                            <div class="footer-heading footer-heading-desktop">
                                <h6>Flow chúng tôi để nhận thông tin mới nhất</h6>
                            </div>
                            <div class="footer-heading footer-heading-moblie">
                                <h6>Flow chúng tôi để nhận thông tin mới nhất</h6>
                            </div>
                            <div class="tf-collapse-content">
                                <form class="form-newsletter subscribe-form" id="" action="#" method="post" accept-charset="utf-8" data-mailchimp="true">
                                    <div class="subscribe-content">
                                        <fieldset class="email">
                                            <input type="email" name="email-form" class="subscribe-email" placeholder="Enter your email...." tabindex="0" aria-required="true">
                                        </fieldset>
                                        <div class="button-submit">
                                            <button id="" class="subscribe-button tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn" type="button">Subscribe<i class="icon icon-arrow1-top-left"></i></button>
                                        </div>
                                    </div>
                                    <div class="subscribe-msg"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    // Lấy element của menu
//     codocument.addEventListener("DOMContentLoaded", function () {
//     const header = document.querySelector(".header-default");

//     window.addEventListener("scroll", function () {
//         if (window.scrollY > 50) { // Khi cuộn xuống 50px
//             header.classList.add("scrolled");
//         } else {
//             header.classList.remove("scrolled");
//         }
//     });
// });
</script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/lazysize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/count-down.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/multiple-modal.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/assets_font/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
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
</script>


</html>
