<div id="mobileNavigation" style="z-index: 2000 !important;">
    <div class="navigation_wrapper">
        <div class="d-flex justify-content-around">
            <center>
            <a class="m-0 text-center text-white text-decoration-none navigation_txt"
                    href="/">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/footer_icon_1.png" class="lazy" height="20" width="20"
                    alt="Home Icon"><br>
                Home</a>
            </center>
            <center>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/footer_icon_3.png" class="lazy mega_menu" height="20"
                    width="20" alt="Sport Icon" data-url="{{ route('get_subcategories') }}" data-id="2"><br>
                <a class="m-0 text-center text-white text-decoration-none mega_menu navigation_txt"
                    href="javascript:void(0)" data-url="{{ route('get_subcategories') }}" data-id="2">
                    Sport</a>
            </center>
            <center>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/footer_icon_1.png" class="lazy mega_menu" height="20"
                    width="20" alt="City Icon" data-url="{{ route('get_subcategories') }}" data-id="1"><br>
                <a class="m-0 text-center text-white text-decoration-none mega_menu navigation_txt"
                    href="javascript:void(0)" data-url="{{ route('get_subcategories') }}" data-id="1">
                    City</a>
            </center>
            @if (!session()->has('userId'))
            <center>
            <a class="m-0 text-center text-white text-decoration-none navigation_txt"
                    href="/login">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/footer_icon_2.png" class="lazy" height="20" width="20"
                    alt="Login Icon"><br>
                Login</a>
            </center>
            @endif
        </div>
    </div>
</div>
