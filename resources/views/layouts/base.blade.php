<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="current-uid" content="@current_uid(request())" />
    <meta name="recaptcha-site-key" content="{{ env('RECAPTCHA_SITE_KEY') }}" />
    @stack('meta')
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&display=swap&subset=cyrillic-ext" rel="stylesheet">

    <title>@yield('title')</title>
    <meta name="description" lang="ru" content="@yield('description')" />
{{--    <script src="{{ mix('assets/vendor.dll.js') }}"></script>--}}
    @stack('styles')
</head>
<body>

@yield('content')
@include('layouts.blocks.footer')

</body>
</html>
