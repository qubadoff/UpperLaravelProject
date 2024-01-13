<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.meta')
    @include('includes.styles')
    @yield('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        @yield('content')
    </div>
    @include('includes.scripts')
    @yield('scripts')
    @include('includes.alert')
</body>
</html>
