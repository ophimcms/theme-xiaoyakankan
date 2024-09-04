@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
@endphp
@push('header')
    <link href="{{ asset('/themes/xiaoyakankan/theme/app2.css') }}" rel="stylesheet">
    <script>var isA = false;</script>
@endpush
@section('body')
    @include('themes::themexiaoyakankan.inc.nav')
    @if (get_theme_option('ads_header'))
        {!! get_theme_option('ads_header') !!}
    @endif
    @yield('slider_recommended')
    @yield('content')
@endsection

@section('footer')
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/1.12.4-jquery.min.js') }}"></script>
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/2.0.0-lazyload.min.js') }}"></script>
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/0.13.2-hls.min.js') }}"></script>
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/1.26.0-DPlayer.min.js') }}"></script>
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/1.0.1-browser-storage.min.js') }}"></script>
    <script src="{{ asset('/themes/xiaoyakankan/theme/js/js-app.js') }}"></script>
    {!! get_theme_option('footer') !!}
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif
    {!! setting('site_scripts_google_analytics') !!}
@endsection
