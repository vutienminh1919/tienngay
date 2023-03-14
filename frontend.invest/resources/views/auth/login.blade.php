<!DOCTYPE html>
<html>
<head>
    <title>Nhà đầu tư</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

    <script src="{{ asset('js/tabler.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="antialiased border-primary d-flex flex-column bg-login">
@php
    $y = date("Y");
    $t = date("d-m-Y");
@endphp
@if (strtotime('13-12-'.$y) < strtotime($t) && strtotime('26-12-'.$y) >= strtotime($t))
    @include('auth.Noel');
@elseif(strtotime('27-12-'.$y) <= strtotime($t) && strtotime('31-12-'.$y) >= strtotime($t))
    @include('auth.tet');
@elseif(strtotime('01-01-'.$y) <= strtotime($t) && strtotime('29-01-'.$y) > strtotime($t))
    @include('auth.tet');
@elseif(strtotime('25-10-'.$y) <= strtotime($t) && strtotime('03-11-'.$y) > strtotime($t))
    @include('auth.halloween');
@elseif(strtotime('29-11-'.$y) <= strtotime($t) && strtotime('06-12-'.$y) > strtotime($t))
    @include('auth.image');
@else
    @include('auth.default')
@endif
</body>
</html>


