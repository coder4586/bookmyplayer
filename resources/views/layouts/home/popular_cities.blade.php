<section class="top-cities-section clearfix">
    <div class="container">
        <div class="col-12 text-center">
            <div class="top_flex">
                <h2>BookMyPlayer's Top 100 Cities</h2>
                <div class="slider_arrow">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left3" class="lazy" alt="arrow">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right3" class="lazy" alt="arrow">
                </div>
            </div>
            <div class="loader_img mt-3">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader">
            </div>
        </div>
        <div class="js-top-cities">
            @if(isset($data['locations']) && !empty($data['locations']))
            @foreach ($data['locations'] as $location)

            <a href="{{$location->url}}">
                <div class="cities-item">
                    <div class="city_card hidden">
                        <div class="cities-item-inner">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/top-city-icon.png" loading="lazy" alt="City Icon">
                            <span>{{ $location->locality_name }}</span>
                        </div>
                    </div>
                </div>
            </a>

            @endforeach
            @endif
        </div>
    </div>
</section>