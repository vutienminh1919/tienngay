<!DOCTYPE html>
<html>
<head>
    <link type=”image/x-icon” href="{{asset('images/icon-logo.svg')}}" rel="shortcut icon"/>
    <title>Nhà đầu tư - @yield('page_name')</title>
    <script src="{{ asset('js/tabler.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/selectize/js/standalone/selectize.min.js') }}"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tabler.min.css') }}">
    {{--    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">--}}
    <link rel="stylesheet" href="{{ asset('js/selectize/css/selectize.bootstrap3.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/selectize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('project_js/notification/update_read.js') }}"></script>
    <script src="{{ asset('project_js/investor/lib/jssip.min.js') }}"></script>
    <script src="{{ asset('project_js/investor/lib/jquery.md5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    @toastr_css


    @php
        $y = date("Y");
        $t = date("d-m-Y");
    @endphp
    @if (strtotime('13-12-'.$y) < strtotime($t) && strtotime('26-12-'.$y) >= strtotime($t))
        @include('layout.noel')
    @elseif(strtotime('27-12-'.$y) <= strtotime($t) && strtotime('31-12-'.$y) >= strtotime($t))
        @include('layout.tet')
    @elseif(strtotime('01-01'.$y) <= strtotime($t) && strtotime('30-01-'.$y) > strtotime($t))
        @include('layout.tet')
    @else
        @include('layout.default')
    @endif


</head>
<body class="antialiased right_col">
@include('layout.modal_dang_xu_ly')
<div class="wrapper">
    @include('layout.modal_success')
    @include('layout.model_fail')
    @include('layout.sidebar')
    @include('layout.header')
    @include('layout.modal_alert')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('layout.alert_error')
            @yield('content')
            @include('layout.footer')
        </div>
    </div>
</div>
@toastr_js
@toastr_render
</body>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@yield('js')
</html>
