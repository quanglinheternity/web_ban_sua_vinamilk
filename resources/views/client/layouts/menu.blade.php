
<header id="header" class="header-default header-absolute">
    <div class="px_15 lg-px_40">
        <div class="row wrapper-header align-items-center">
            <div class="col-xl-3 col-md-4 col-6">
                <a href="{{ url('/') }}" class="logo-header">
                    <img src="{{ asset('/assets/images/logo.png') }}" alt="logo" style="width: 100px;">
                </a>
            </div>
            <div class="col-xl-6 tf-md-hidden">
                <nav class="box-navigation text-center">
                    <ul class="box-nav-ul d-flex align-items-center justify-content-center gap-30">
                        <li class="menu-item">
                            <a href="{{ url('/') }}" class="item-link"><i class="fa-solid fa-house" style="color: rgb(8, 8, 8);"></i>Trang Chủ</a>
                        </li>
                        <!-- Product -->
                        <li class="menu-item">
                            <a href="{{ url('/ListProducts') }}" class="item-link btn-open-sub collapsed mb-menu-link current"><i class="fa-solid fa-jar"></i>Sản phẩm</a>
                        </li>
                        <li class="menu-item position-relative">
                            <a href="" class="item-link"><i class="fa-solid fa-newspaper"></i>Bài Viết</a>
                        </li>
                        <li class="menu-item position-relative">
                            <a href="{{ url('/contact') }}" class="item-link"><i class="fa-solid fa-square-phone-flip"></i>Liên Hệ</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-xl-3 col-md-4 col-3">
                <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                    <li class="nav-search"><a href=""  aria-controls="offcanvasLeft" class="nav-icon-item"><i class="icon icon-search"></i></a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon icon-account"></i>
                        </a>
                        <ul class="dropdown-menu mt-1 dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (Auth::check())
                                <li><a class="dropdown-item" href="">Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="">Đơn hàng của tôi</a></li>
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                        <a class="dropdown-item" href="#" onclick="confirmLogout(event);">
                                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                        </a>
                                    </form>
                                </li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}">Đăng Nhập, Ký</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-wishlist"><a href="" class="nav-icon-item"><i class="icon icon-heart"></i><span class="count-box">0</span></a></li>
                    <li class="nav-cart"><a href="" class="nav-icon-item"><i class="icon icon-bag"></i><span class="count-box">0</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<script>
    function confirmLogout(event) {
        event.preventDefault();
        if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
