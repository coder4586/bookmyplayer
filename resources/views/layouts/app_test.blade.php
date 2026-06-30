<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">
<head>
    @include('menu.meta')
    @stack('styles')
</head>

<body>
    @yield('content')
    @include('partials.mobile_navigation')
    @include('footer.footer')

    <input type="hidden" value="{{ asset('/') }}" id="asset_url">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-lazyload@1.9.7/jquery.lazyload.min.js"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script type="text/javascript" src="{{ asset('asset/js/menu.js') }}"></script>
    @stack('scripts')
    @yield('script')
</body>

</html>
