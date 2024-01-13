<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.meta')
    @include('includes.styles')
    @yield('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    @include('includes.mobile')
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            @include('includes.sidebar')
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include('includes.header')
                @yield('content')
                @include('includes.footer')
            </div>
        </div>
    </div>
    @include('includes.user')
    @include('includes.scripts')
    @yield('scripts')
    @include('includes.alert')
</body>
</html>
