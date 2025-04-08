<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <i class="bi bi-speedometer2"></i>
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ url('/admin') }}" class="nav-link active">
                        <i class="bi bi-house-door-fill"></i> <!-- Icon Home đậm -->
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/products') }}" class="nav-link">
                        <i class="bi bi-box"></i> <!-- Icon hộp sản phẩm -->
                        <p>Sản phẩm</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="bi bi-tags"></i> <!-- Icon thẻ danh mục -->
                        <p>Danh mục</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index')}}" class="nav-link">
                        <i class="bi bi-people"></i> <!-- Icon người dùng -->
                        <p>Người Dùng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.banners.index')}}" class="nav-link">
                        <i class="bi bi-image"></i> <!-- Icon Banner -->
                        <p>Banner</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index')}}" class="nav-link">
                        <i class="bi bi-file-text"></i> <!-- Icon Bài viết -->
                        <p>Bài viết</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contacts.index')}}" class="nav-link">
                        <i class="bi bi-envelope"></i> <!-- Icon Liên hệ -->
                        <p>Liên hệ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index')}}" class="nav-link">
                        <i class="bi bi-star"></i> <!-- Icon Đánh giá -->
                        <p>Đánh giá</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
