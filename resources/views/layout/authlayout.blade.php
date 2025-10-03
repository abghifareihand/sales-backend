<!-- resources/views/layout/authlayout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title', 'Bee Digital Solution')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('/build/img/favicon.png')}}">

    <!-- Include CSS/JS head partial -->
    @include('layout.partials.head')
</head>
<body class="account-page">

    <!-- Yield konten halaman -->
    @yield('content')

    <!-- Footer scripts -->
    @include('layout.partials.footer-scripts')
</body>
</html>
