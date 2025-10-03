<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Bee Digital Solution</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('/build/img/favicon.png')}}">

    @include('layout.partials.head')
</head>

{{-- @component('components.loader')
@endcomponent --}}
<!-- Main Wrapper -->
@include('layout.partials.header')
@include('layout.partials.sidebar')
@yield('content')
</div>
<!-- /Main Wrapper -->
{{-- @include('layout.partials.theme-settings') --}}
@component('components.modalpopup')
@endcomponent
@include('layout.partials.footer-scripts')
</body>

</html>
