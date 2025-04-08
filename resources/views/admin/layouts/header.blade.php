<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="bi bi-list"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-bell"></i> <span class="badge badge-danger">3</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a>
        </li>
        <li class="nav-item">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a class="nav-link" href="#" onclick="confirmLogout(event);">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>
                </form>
            </li>
        </li>

    </ul>
</nav>
<script>
    function confirmLogout(event) {
        event.preventDefault();
        if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
