<!DOCTYPE html>
<html>
<head>
    <title>Đặt hàng thành công</title>
</head>
<body>
    <h1>Đặt hàng thành công!</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <a href="{{ route('client.index') }}">Quay lại trang chủ</a>
</body>
</html>
