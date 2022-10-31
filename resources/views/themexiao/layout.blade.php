@extends('themes::layout')
@php
$menu = \Ophim\Core\Models\Menu::getTree();
@endphp

@push('header')

    <link rel="stylesheet" href="/themes/xiao/css/mytheme-font.css" type="text/css" />
    <link rel="stylesheet" href="/themes/xiao/css/mytheme-ui.css" type="text/css" />
    <link rel="stylesheet" href="/themes/xiao/css/mytheme-site.css" type="text/css" />
    <link rel="stylesheet" href="/themes/xiao/css/mytheme-color2.css" type="text/css" name="default" />
    <link rel="stylesheet" href="/themes/xiao/css/mytheme-color0.css" type="text/css" name="skin" disabled />
    <link rel="stylesheet" href="/themes/xiao/css/mytheme-color2.css" type="text/css" name="skin" disabled />
    <link rel="stylesheet" href="/themes/xiao/css/layer.css" type="text/css" />
    <link rel="stylesheet" href="/themes/xiao/css/custom.css" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js" integrity="sha512-f0VlzJbcEB6KiW8ZVtL+5HWPDyW1+nJEjguZ5IVnSQkvZbwBt2RfCBY0CBO1PsMAqxxrG4Di6TfsCPP3ZRwKpA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="/themes/xiao/js/jquery.min.js"></script>
    <script type="text/javascript" src="/themes/xiao/js/layer/layer.js"></script>
    <script type="text/javascript" src="/themes/xiao/js/mytheme-site.js"></script>
    <script type="text/javascript" src="/themes/xiao/js/mytheme-ui.js"></script>
@endpush

@section('body')
    @include('themes::themexiao.inc.header')
    <script type="text/javascript">
        MyTheme.Other.Headroom();
    </script>
    @yield('slider_recommended')
    @yield('player')
    <div class="container">
        <div class="row">
            @yield('content')
            @yield('sidebar')
        </div>
    </div>
@endsection

@section('footer')
    {!! get_theme_option('footer') !!}
    <script type="text/javascript">
        MyTheme.Other.Skin();
    </script>
    @if (get_theme_option('ads_header'))
        {!! get_theme_option('ads_catfish') !!}
    @endif
    {!! setting('site_scripts_google_analytics') !!}
@endsection
