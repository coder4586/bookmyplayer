<section class="popular-coaches-section clearfix">
    <div class="container">
    <div class="top_flex">
            <h2>Coaches in Demand</h2>
            <div class="slider_arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left1" class="lazy" alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right1" class="lazy" alt="arrow">
            </div>
        </div>
        <div class="loader_img mt-3">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader">
        </div>
        <div class="popular-coaches-js mt-3">
            @if(isset($data['coaches']) && !empty($data['coaches']))
            @php
            foreach ($data['coaches'] as $coach) {
            $firstPhoto = $coach->profile_img ?? null;
            $firstPhotoUrl = $firstPhoto ? env('AWS_S3_BASE_URL') . "/coach/{$coach->id}/{$firstPhoto}" : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
            $name = $coach->name ?? 'Coach';
            $sport = $coach->sport ?? 'Sport';
            $city = $coach->city ?? 'City';
            $url = $coach->url ?? '#';
            @endphp
            <div class="item">
                <div class="coach_card hidden">
                    <a href="{{ $url }}">
                        <div class="coach-card">
                            <figure><img src="{{ $firstPhotoUrl }}" loading="lazy" alt="Coach Image" class="coach_img"></figure>
                            <h6 class="text-capitalize academy_name">{{ $name }}</h6>
                            <p class="text-capitalize">{{ $sport }}</p>
                            <p class="text-capitalize academy_name"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location2.svg" alt="location" loading="lazy" height="20" width="20"></img>{{ $city }}</p>
                            <p><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" alt="stars" loading="lazy" height="20" width="80"></img> (25)</p>
                        </div>
                    </a>
                </div>

            </div>
            @php
            }
            @endphp
            @endif
        </div>
    </div>
</section>
