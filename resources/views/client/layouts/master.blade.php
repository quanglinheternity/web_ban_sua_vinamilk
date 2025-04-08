<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @include('client.layouts.header')
    @include('client.layouts.menu')
  <!-- #region-->
    <div class="content">
        @yield('content')
    </div>

    {{-- @include('client.layouts.nav') --}}

    @include('client.layouts.footer')
</body>

</html>
