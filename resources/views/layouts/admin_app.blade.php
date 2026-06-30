<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">
<head>
    @include('admin.menu.meta')
    @stack('styles')
</head>

<body>
    @include('admin.menu.header')
    @yield('content')
    @include('partials.admin_mobile_navigation')
    @include('admin.footer.footer')

    <input type="hidden" value="{{ asset('/') }}" id="asset_url">
    <script src="{{ asset('asset/js/jquery.min.js') }}" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="{{ asset('asset/js/jquery.lazyload.min.js') }}"
        crossorigin="anonymous"></script>
        <script src="{{ asset('asset/js/crypto-js.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/admin/menu_v4.js') }}"></script>
    @stack('scripts')
    @yield('script')
</body>

</html>
