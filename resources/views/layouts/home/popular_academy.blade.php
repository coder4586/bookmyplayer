<section class="register-academy-section clearfix">
    <div class="container">
        <div class="register-academy-wrap">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-8">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/register-accademy-img.png" loading="lazy" alt="Register Academy"></figure>
                </div>
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="register-academy-cont">
                        <h3>Grow your Academy. Register today and inspire the champions of tomorrow.</h3>
                        <a class="btn btn-secondary" href="https://www.bookmyplayer.com/register-your-academy">Register Academy</a>
                    </div>
                </div>
            </div>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/dotted.png" loading="lazy" alt="Dotted Icon" class="doted-shape">
        </div>
    </div>
</section>

<section class="popular-sports-academies-section clearfix">
    <div class="container">
        <div class="top_flex">
            <h2>Popular Sports Academies</h2>
            <div class="slider_arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left4" class="lazy" alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right4" class="lazy" alt="arrow">
            </div>
        </div>
        <div class="loader_img academy_loader mt-3">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader">
        </div>
        <div class="js-popular-sports-academies">
            @if(isset($data['academies']) && !empty($data['academies']))
            @foreach($data['academies'] as $academy)
            @php
            $photos = explode(',', $academy->photos ?? '');
            $firstPhoto = $photos[0] ?? null;
            $firstPhotoUrl = $firstPhoto ? env('AWS_S3_BASE_URL') . "/academy/{$academy->id}/{$firstPhoto}" : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
            $logo = $academy->logo ?? null;
            $logoUrl = $logo ? env('AWS_S3_BASE_URL') . "/academy/{$academy->id}/{$logo}" : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
            $rating = $academy->rating ?? 'N/A';
            $reviews = $academy->reviews ?? '0';
            $url = $academy->url ?? '#';
            $name = $academy->name ?? 'Academy';
            $sport = $academy->sport ?? 'Sport';
            $address1 = $academy->address1 ?? 'Address';
            @endphp

            <div class="popular-sports-academies-item">
                            <a href="{{ $url }}">
                                <div class="academy_card">
                                    <div class="popular-sports-academies-inner">
                                        <div class="image-wrapper">
                                            <img src="{{ $firstPhotoUrl }}" loading="lazy" alt="Academy Image" class="academy_image">
                                        </div>
                                        <div class="popular-sports-content">
                                            <div class="sport-logo-text">
                                                <div class="left-box">
                                                    <div class="logo-wrap">
                                                        <img src="{{ $logoUrl }}" loading="lazy" alt="Academy Logo" class="academy_logo">
                                                    </div>
                                                    <span><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/single-star.png" loading="lazy" alt="Star Icon"> <b>{{ $rating }}</b> ({{ $reviews }})</span>
                                                </div>
                                                <span><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/verified-icon-svg.svg" loading="lazy" alt="Verify Icon"> Verified</span>
                                            </div>
                                            <p class="academy_name"><a href="{{ $url }}">{{ $name }}</a></p>
                                            <h5 class="text-capitalize">{{ $sport }}</h5>
                                            <p class="academy_name"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location2.svg" alt="location" loading="lazy" width="14" height="14"> {{ $address1 }}</p>
                                            <p>Monday To Sunday</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

            @endforeach
            @endif
        </div>
    </div>
</section>