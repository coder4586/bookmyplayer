
<header>
    <div class="result_location">
        <div class="result_place">
            <div class="result_left">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location_mob.svg" alt="location" srcset="" />
                <h1 class="results_in"><span>{{count($data['d'])}} Academies</span> <span>In {{$data['city']}}</span></h1>
            </div>
            <span class="precise_location" id="lat_lng_finder"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/detect2.svg" alt="location" /></span>
        </div>
    </div>
    <div class="filter_section">
        <div class="filter_sort sport_sort" id="openPopup">
            <span>Sports</span>
        </div>
        <div class="filter_sort rate_sort" id="top_rated">
            <span>Top Rated</span>
        </div>
        <div class="filter_sort">
            <span id="clear_mob_filter">Clear Filter</span>
        </div>
    </div>
</header>
<section class="localities">
    <h2 class="fb_font">Localities in {{$data['city']}}</h2>
    <div class="grid-container">
        @foreach($data['otherLocalities'] as $index => $locality) @if($index < 7)
        <a href="{{$locality->url}}" class="sector_tag">
            <div class="grid-item">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/local_icon_{{ ($index % 7) + 1 }}.png" loading="lazy" alt="locality" /><span class="local_name">{{$locality->locality_name}}</span>
                <span class="locality-name" style="display: none;">{{$locality->locality_name}}</span>
            </div>
        </a>
        @endif @endforeach @if(count($data['otherLocalities']) > 7 )
        <div class="grid-item expand">
            <div class="expand_img"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/down_white.svg" loading="lazy" alt="more" /></div>
            <span>More</span>
        </div>
        @endif @foreach($data['otherLocalities'] as $index => $locality) @if($index >= 7)
        <a href="{{$locality->url}}" class="sector_tag">
            <div class="grid-item extra" style="display: none;">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/local_icon_{{ (($index - 7) % 7) + 1 }}.png" loading="lazy" alt="locality" /><span class="local_name">{{$locality->locality_name}}</span>
                <span class="locality-name" style="display: none;">{{$locality->locality_name}}</span>
            </div>
        </a>
        @endif @endforeach
        <!-- Less Icon (initially hidden) -->
        <div class="grid-item less" style="display: none;">
            <div class="expand_img"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/up_white.svg" loading="lazy" alt="less" /></div>
            <span>Less</span>
        </div>
    </div>
</section>
