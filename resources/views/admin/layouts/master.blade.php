
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Thêm vào thẻ <head> của trang -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="loader-wrapper">
    <div class="loader"></div>
</div>

<div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <div class="content-wrapper p-4">
        @yield('content')
    </div>

    @include('admin.layouts.footer')
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
