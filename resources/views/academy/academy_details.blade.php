@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/academy_detail_v13.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('asset/css/fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/review.css') }}" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('asset/js/academy_detail_v26.js') }}" defer></script>
    <script src="{{ asset('asset/js/fancybox.umd.js') }}"></script>
    <script src="{{ asset('asset/js/review_v2.js') }}" defer></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    </script>
@endpush
@extends('layouts.app')
@section('content')

@php
    $photoCount = !empty($data['banners']) && !(count($data['banners']) === 1 && $data['banners'][0] === "") ? count($data['banners']) : 0;
    $videoCount = !empty($data['videos']) && !(count($data['videos']) === 1 && $data['videos'][0] === "") ? count($data['videos']) : 0;
    $allowedIds = [1, 3203, 29704, 41002, 41042];
    $object_type = $data['cattype'] == "aid" ? "academy" : "tournament";
    if ($data['cattype'] == "certificate") {
        $object_type = "certificate";
    }
    if ($data['cattype'] == "player") {
        $object_type = "player";
    }
    $id = $data['id'];
    $sport = $data['d']->sport ? $data['d']->sport : null;

    $phone = $data['d']->phone;

    $phoneParts = explode(',', $phone);

    if (isset($phoneParts[0])) {
        $firstPhone = $phoneParts[0];
        if (strpos($firstPhone, '+91') === 0) {
            $firstPhone = substr($firstPhone, 3);
        } elseif (strpos($firstPhone, '0') === 0) {
            $firstPhone = substr($firstPhone, 1);
        }

        $phone = $firstPhone;
    }

    if ($videoCount > 0 && $data['videos'][0] !== "") {
        $videoSrc = "https://f005.backblazeb2.com/file/bmpcdn90/academy/{$data['d']->id}/{$data['videos'][0]}";
    }

    $weekly_schedule = json_decode($data['d']->completion_percentage, true);
    $sorted_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    $open_days = [];
    $closed_days = [];

    if (is_array($weekly_schedule)) {
        foreach ($sorted_days as $day) {
            foreach ($weekly_schedule as $day_info) {
                if ($day_info['day'] === $day) {
                    if ($day_info['status'] === 'open' && count($day_info['hours']) > 0) {
                        $open_days[] = $day_info;
                    } elseif ($day_info['status'] === 'closed') {
                        $closed_days[] = $day_info['day'];
                    }
                }
            }
        }
    }
    $remainingVideos = 4 - $photoCount;
@endphp


<section class="academy-club-section clearfix">
    @if(Session::has('success_message_add_review_academy'))
        <div class="confirm-box review_box" style="z-index: 10;">
            <div class="confirm-backdrop confirm-backdrop-review"></div>
            <div class="confirm-content">
                <div class="confirm-body">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="Success">
                    </figure>
                    <h6> {{ Session::get('success_message_add_review_academy') }}</h6>
                </div>
                <div class="confirm-footer">
                    <button class="get_back btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('error_message_add_review_academy'))
        <div class="confirm-box review_box" style="z-index: 10;">
            <div class="confirm-backdrop confirm-backdrop-review"></div>
            <div class="confirm-content">
                <div class="confirm-body">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt="Error">
                    </figure>
                    <h6> {{ Session::get('error_message_add_review_academy') }}</h6>
                </div>
                <div class="confirm-footer">
                    <button class="get_back btn btn-secondary">Go Back</button>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <section class="clearfix">
            @if($videoCount > 0)
                        <div class="academy-slider">
                            <div class="rtl-slider-flex">
                                <div class="rtl-slider">
                                    <div class="rtl-slider-slide1 video_container">
                                        <video id="myVideo" autoplay loop muted playsinline class="background-clip"
                                            controlsList="nodownload">
                                            <source src="{{ $videoSrc }}" type="video/mp4">
                                        </video>
                                        <div class="video_content">
                                            <h2 class="banner_posetive text-capitalize"></h2>
                                            <p>
                                              {{ $data['listingTitle'] }}
                                               @if(!empty($data['d']->city))
                                                  , {{ $data['d']->city }}
                                               @endif
                                            </p>
                                             
                                            <button id="openWhatsappModal">Enquire Now</button>
                                        </div>

                                        <div class="video_controls">
                                            <div class="play_volume" id="playPauseBtn">
                                                <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/play_2.png" alt="Play"
                                                    style="width:100% !important; height:100% !important">
                                            </div>
                                            <div class="play_volume" id="muteBtn">
                                                <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/volume_2.png" alt="Volume"
                                                    style="width:100% !important; height:100% !important">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rtl-slider-nav">
                                    @foreach (array_slice($data['banners'], 0, 4) as $photo)
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $photo }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="rtl-slider-slide1">
                                                <img src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $photo }}"
                                                    alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                                            </div>
                                        </a>
                                    @endforeach

                                    @if ($remainingVideos > 0 && $videoCount > 0)
                                        @for ($i = 0; $i < $remainingVideos; $i++)
                                            @if (isset($data['videos'][$i]))
                                                <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                                    data-fancybox="photos-gallery" data-caption="">
                                                    <div class="video-container">
                                                        <video controls controlsList="nodownload">
                                                            <source
                                                                src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </a>
                                            @endif
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <a href="#media_section">
                                <div class="slide-counter">
                                    <span>Photos {{ $photoCount }}</span>
                                    <span>Videos {{ $videoCount }}</span>
                                </div>
                            </a>
                            <div class="image_description">
                                @php
                                    $rating = is_numeric($data['d']->rating) ? (int) ceil((float) $data['d']->rating) : 4;
                                    if ($rating < 1 || $rating > 5) {
                                        $rating = 4;
                                    }
                                    $starImage = $rating == 1 ? 'single-star.png' : $rating . 'star.png';
                                    $reviews = is_numeric($data['totalReviews']) ? $data['totalReviews'] : '23';
                                @endphp
                                <div class="review_number">
                                    <span class="review_text" style="color:#fff">{{ $data['d']->rating ?? 4 }}</span>
                                </div>
                                <div class="star_big"><img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/{{ $starImage }}"
                                        alt="Stars" width="64" height="16"></div>
                                <div class="single_star"><img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/single-star.png"
                                        alt="Stars" width="20" height="20"></div>
                                <span class="review_text" style="color:#fff">{!! $reviews !!} Reviews</span>
                            </div>
                        </div>
            @elseif ($photoCount > 0)
                        <div class="academy-slider">
                            <div class="rtl-slider-flex"> 
                                <div class="rtl-slider">

                                    @if($data['is_banner_set'] == true)
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['banners'][0] }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="rtl-slider-slide1">
                                                <img src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['banners'][0] }}"
                                                    alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                                            </div>
                                        </a>
                                    @elseif(!empty($data['first_banner_img']))
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['first_banner_img'] }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="rtl-slider-slide1">
                                                <img src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['first_banner_img'] }}"
                                                    alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['banners'][0] }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="rtl-slider-slide1">
                                                <img src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['banners'][0] }}"
                                                    alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                <div class="rtl-slider-nav">
                                    @foreach (array_slice($data['banners'], 0, 4) as $photo)
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $photo }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="rtl-slider-slide1">
                                                <img src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $photo }}"
                                                    alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                                            </div>
                                        </a>
                                    @endforeach

                                    @if ($remainingVideos > 0 && $videoCount > 0)
                                        @for ($i = 0; $i < $remainingVideos; $i++)
                                            @if (isset($data['videos'][$i]))
                                                <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                                    data-fancybox="photos-gallery" data-caption="">
                                                    <div class="video-container">
                                                        <video controls controlsList="nodownload">
                                                            <source
                                                                src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </a>
                                            @endif
                                        @endfor
                                    @endif

                                </div>
                            </div>
                            <a href="#media_section">
                                <div class="slide-counter">
                                    <span>Photos {{ $photoCount }}</span>
                                    <span>Videos {{ $videoCount }}</span>
                                </div>
                            </a>
                            <div class="image_description">
                                @php
                                    $rating = is_numeric($data['d']->rating) ? (int) ceil((float) $data['d']->rating) : 4;
                                    if ($rating < 1 || $rating > 5) {
                                        $rating = 4;
                                    }
                                    $starImage = $rating == 1 ? 'single-star.png' : $rating . 'star.png';
                                    $reviews = is_numeric($data['totalReviews']) ? $data['totalReviews'] : '23';
                                @endphp
                                <div class="review_number">
                                    <span class="review_text" style="color:#fff">{!! $rating !!}</span>
                                </div>
                                <div class="star_big"><img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/{{ $starImage }}"
                                        alt="Stars" width="64" height="16"></div>
                                <div class="single_star"><img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/single-star.png"
                                        alt="Stars" width="20" height="20"></div>
                                <span class="review_text" style="color:#fff">{!! $reviews !!} Reviews</span>
                            </div>
                        </div>

            @else
                <div class="academy-slider">
                    <div class="rtl-slider-flex">
                        <div class="rtl-slider">
                            <div class="rtl-slider-slide1">
                                <img src="{{ $data['banner'] }}" alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                            </div>
                        </div>
                        <div class="rtl-slider-nav">
                            <div class="rtl-slider-slide1">
                                <img src="{{ $data['banner'] }}" alt="Banner Images" onerror="this.onerror=null; this.src='{{ env('AWS_S3_BASE_URL') }}/asset/images/home-banner.png';">
                            </div>

                            @if ($remainingVideos > 0 && $videoCount > 0)
                                @for ($i = 0; $i < $remainingVideos; $i++)
                                    @if (isset($data['videos'][$i]))
                                        <a href="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                            data-fancybox="photos-gallery" data-caption="">
                                            <div class="video-container">
                                                <video controls controlsList="nodownload">
                                                    <source
                                                        src="{{ env('AWS_CF_BASE_URL') . '/academy/' . $data['d']->id . '/' . $data['videos'][$i] }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </a>
                                    @endif
                                @endfor
                            @endif
                        </div>

                    </div>
                    <a href="#media_section">
                        <div class="slide-counter">
                            <span>Photos 0</span>
                            <span>Videos {{ $videoCount }}</span>
                        </div>
                    </a>
                </div>
            @endif

            <div class="academy-short-details">
                <div class="details">
                    <figure><img src="{{ $data['logo']  }}" class="img-fluid logo_img" alt="Academy Logo"></figure>
                    <article>
                        <h1 class="trim_name" style="font-size: 24px;">{{ $data['listingTitle']  }}
                            @if($data['d']->id == 3203)
                                <div class="verified">
                                    <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/verified.svg" alt="Verify Icon"
                                        width="16" height="17">Verified Premium Academy
                                </div>
                            @endif
                        </h1>
                        <p class="trim_name2"><i class="fa-solid fa-location-dot"></i>
                            {{ $data['address'] ? $data['address'] : "" }}</p>
                        <p><i class="fa-regular fa-clock"></i>
                            <strong>{{ $data['d']->timing ? $data['d']->timing : "" }}</strong></p>
                    </article>
                </div>
                <div class="aside">
                    <button type="button" id="openWhatsappModal2"><img
                            src="{{ env('AWS_S3_BASE_URL') }}/asset/images/icon-whatsapp.svg" alt="Whatsapp Icon"
                            loading="lazy" width="20" height="20">WhatsApp</button>
                </div>
            </div>
        </section>
    </div>
</section>



<section class="academy-details-section clearfix">
    <input type="hidden" name="" style="display: none;" id="loc_id_value"
        value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
    <input type="hidden" name="" style="display: none;" id="sport_value"
        value="{{ $data['d']->sport ? $data['d']->sport : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5 col-xl-4 academy-sidebar">
                @if(!$MOBILE)

                                @php
                                    $priceArray = array_filter(explode(",", $data['fee']), 'strlen');
                                @endphp
                                <div class="academy-price-fee training_fee">
                                    <div class="d-flex justify-content-between align-items-start training_box">
                                        @if(!empty($priceArray) && count($priceArray) > 0)
                                            <h2 style="font-size:22px;">Training Fees</h2>
                                        @else
                                            <h2 style="font-size:22px;">Training Fees <span class="estimate_text">(Estimate)</span></h2>
                                        @endif
                                        <div class="position-relative">
                                            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/price.png" alt="price icon"
                                                loading="lazy" class="price_change">
                                            <div class="tooltip-box">Request Price Change</div>
                                        </div>
                                    </div>
                                    @if(!empty($priceArray) && count($priceArray) > 0)
                                    @foreach ($priceArray as $price)
                                    @php
                                     $priceWithoutRs = preg_replace('/\b[Rr][Ss]\b/', '', $price);
                                     $modifiedPrice = preg_replace_callback('/\d{3,}/', function ($matches) {
                                     return '<strong style="font-size: 0.875rem;">₹' . $matches[0] . '</strong>';
                                     }, $priceWithoutRs);
                                    @endphp

<p>{!! $modifiedPrice !!}</p>
                                    @endforeach

                                    @else
                                        <div class="sport_estimate_price container">
                                        </div>
                                    @endif
                                </div>
                @endif
                <div class="academy-price-fee2 mt-3">
                    <h2 style="font-size:22px;">Share</h2>
                    <div class="academy-url-copy"><input type="text" name="" id="academy-url-input"
                            value="{{ $data['d']->url ?? '' }}">
                        <button type="button" id="copy-button"><img
                                src="{{ env('AWS_S3_BASE_URL') }}/asset/images/icon-copy.svg" loading="lazy"
                                alt="Copy Icon" width="40" height="40"></button>
                    </div>
                </div>

                @if(!empty($data['d']->facebook) || !empty($data['d']->instagram))
                            <div class="academy-price-fee mt-3">
                                <h2 style="font-size: 22px;">Social</h2>
                                @if(!empty($data['d']->facebook))
                                    <div class="academy-url-copy">
                                        <a href="{{ $data['d']->facebook }}" class="link-overflow">
                                            <div class="d-flex justify-content-start align-items-center gap-3">
                                                <div class="fb_back">
                                                    <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/email/facebook.png"
                                                        loading="lazy" alt="Facebook Icon" width="16" height="16">
                                                </div>
                                                <span class="text_flow">{{ $data['d']->facebook }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                @if(!empty($data['d']->instagram))
                                                @php
                                                    // Check if Instagram handle starts with '@' and construct URL accordingly
                                                    $instagramHandle = $data['d']->instagram;
                                                    $instagramUrl = Str::startsWith($instagramHandle, '@')
                                                        ? 'https://www.instagram.com/' . ltrim($instagramHandle, '@')
                                                        : $instagramHandle;
                                                @endphp

                                                <div class="academy-url-copy">
                                                    <a href="{{ $instagramUrl }}" class="link-overflow" rel="noopener noreferrer">
                                                        <div class="d-flex justify-content-start align-items-center gap-3">
                                                            <div class="fb_back">
                                                                <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/email/instagram.png"
                                                                    loading="lazy" alt="Instagram Icon" width="16" height="16">
                                                            </div>
                                                            <span class="text_flow">{{ $instagramUrl }}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                @endif
                            </div>
                @endif



                @if($data['d']->id == 3203)
                    <div class="academy-price-fee mt-3">
                        <h2 style="font-size: 22px;">Location</h2>
                        <div class="academy-url-copy">
                            <a href="https://maps.app.goo.gl/TmY2mLR3soJsE8qY8" class="link-overflow">
                                <div class="d-flex justify-content-start align-items-center gap-3">
                                    <div class="fb_back">
                                        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/detect.svg" loading="lazy"
                                            alt="Instagram" width="16" height="16">
                                    </div>
                                    <span class="text_flow">https://maps.app.goo.gl/TmY2mLR3soJsE8qY8 </span>


                                </div>
                            </a>
                        </div>
                    </div>
                @endif



                <div class="academy-message-form">
                    <h6 style="font-size:22px;">Message To {{ $data['title'] }}</h6>
                    <div class="error_msg_new">
                        <div id="error_message" style="display: none; color:red;"></div>
                    </div>
                    <form id="contact_form" action="{{ route('submit.contact') }}" method="post">
                        @csrf
                        <input type="hidden" id="academy_phone2" value="{{ $phone }}" style="display: none;">
                        <input type="hidden" name="source" id="source_details2" value="message" style="display: none;">
                        <input type="hidden" name="sport" id="sport_details2"
                            value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}" style="display: none;">
                        <input type="hidden" name="sport_id" id="sport_id_details2"
                            value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}" style="display: none;">
                        <input type="hidden" name="object_id" id="object_id_details2"
                            value="{{ isset($data['id']) ? $data['id'] : '' }}" style="display: none;">
                        <input type="hidden" name="object_type" id="object_type_details2"
                            value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}"
                            style="display: none;">
                        <input type="hidden" name="loc_id" id="loc_id_details2"
                            value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}" style="display: none;">
                        <input type="hidden" id="listing_title2"
                            value="{{ isset($data['listingTitle']) ? $data['listingTitle'] : '' }}"
                            style="display: none;">
                        <input type="hidden" id="academy_address2"
                            value="{{ isset($data['address']) ? $data['address'] : '' }}" style="display: none;">

                        <input type="hidden" name="latitude" id="latitude1" style="display: none;">
                        <input type="hidden" name="longitude" id="longitude1" style="display: none;">
                        <input type="hidden" name="screen" id="screen_details2" value="message" style="display: none;">
                        <div class="mt-3" style="margin-top:2rem !important;">
                            <input type="text" class="form-control your-name" name="name" id="contact_name"
                                placeholder="Enter your Full name">
                        </div>
                        <div class="mt-3">
                            <input type="email" class="form-control your-email" name="email" id="email"
                                placeholder="Enter your Email">
                        </div>
                        <div class="mt-3">
                            <input type="number" class="form-control your-phone" name="phone" id="phone"
                                placeholder="Enter your Phone Number">
                        </div>
                        <div class="mt-3">
                            <textarea id="message" class="form-control" name="description"
                                placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="button" id="otp_modal" class="btn btn-secondary">Send</button>
                        </div>
                    </form>

                </div>

                @if(!empty($data['reviewPageUrl']) || $data['reviewPageUrl'] != null)
                            <div class="academy-price-fee mt-3">
                                <h2 style="font-size: 22px;">Latest Reviews</h2>
                                    <div class="academy-url-copy review-page-link">
                                        <a href="{{ $data['reviewPageUrl'] }}" class="link-overflow">
                                            <div class="d-flex justify-content-start align-items-center gap-3">
                                                <span class="text_flow">{{ $data['reviewPageUrl'] }}</span>
                                            </div>
                                        </a>
                                    </div>
                            </div>
                @endif
                <div class="academy-near-location hidden">
                    <h3 style="font-size:16px" class="heading_border">Explore Other Locations</h3>
                    <div class="loader_img3 mt-3 ">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy"
                            alt="loader">
                    </div>
                    <div class="height500 scrollbar">
                    </div>
                </div>
                
                <div class="academy-price-fee">
                    <div class="register-as-a-academy">
                        <h2 style="font-size:22px">Register as a Academy</h2>
                        <p>Create your free profile today to start responding to leads and earning a regular income.
                            Stay Ahead of the competition by ranking higher with our platform.</p>
                        <a href="https://www.bookmyplayer.com/register-your-academy" class="btn btn-secondary">Register
                            Now</a>
                    </div>
                </div>
                <div class="academy-login"><a
                        href="https://www.bookmyplayer.com/academy/manage-this-business-{{$data["d"]->id}}">Own This
                        Business?<br>Login To Manage!</a></div>

                <div class="academy-price-fee">
                    <div class="register-as-a-academy register_as_coach">
                        <h2 style="font-size:22px">Register as a Coach</h2>
                        <p>Create your free profile today to start responding to leads and earning a regular income.
                            Stay ahead of competition by ranking higher with our platform.</p>
                        <a href="https://www.bookmyplayer.com/register-as-a-coach-trainer"
                            class="btn btn-secondary">Register Now</a>
                    </div>
                </div>

                <div>
                <button id="report_academy_issue" class="btn btn-secondary w-100">Report An Issue</button>
                </div>

  @if (!empty($data['nearby_serving_location']) && count($data['nearby_serving_location']) > 0)
    <div class="academy-near-location">
        <h3 style="font-size:16px" class="heading_border">Near By Serving Locations</h3>
        <div class="height500">
            @php
                $imageIndex = 1;
            @endphp
            @foreach ($data['nearby_serving_location'] as $location)
                <div class="location">
                    <aside>{{ $loop->iteration }}</aside>
                    <div class="info_on_img">
                        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/build_icon_{{ $imageIndex }}.png" 
                             loading="lazy" 
                             alt="Near Locations" 
                             class="grey_border">
                        <div class="image_text">
                            <span class="sample_hd">Academy</span>
                            <div class="hd">
                                <span>City</span>
                            </div>
                        </div>
                        <div class="count_local">
                            <span>{{ $loop->index + 1 }}</span>
                        </div>
                    </div>
                    <article>
                        <h6>
                            <a href="{{ $location['url'] }}">
                                {{ $location['locality_name'] }}
                            </a>
                        </h6>
                        <p class="text-capitalize">
                            {{ $location['locality_name'] }}
                        </p>
                    </article>
                </a>
                </div>
                @php
                    $imageIndex = $imageIndex < 8 ? $imageIndex + 1 : 1;
                @endphp
            @endforeach
        </div>
    </div>
@endif
            </div>
            <div class="col-md-6 col-lg-7 col-xl-8">
            <div class="overview-box white-box">
    <div class="d-flex justify-content-between align-items-start gap-1" style="border-bottom:1px solid #dcdcdc; margin-bottom:5px;">
        <h2 style="font-size:22px; border-bottom:none;">Overview: {{ $data['listingTitle'] }} </h2>

        <div class="position-relative">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/report_icon.png" alt="report icon" id="report_icon" loading="lazy" height="25" weight="25">
            <div class="tooltip-box2">Report An Issue</div>
        </div>
    </div>

    <div class="row" style="flex-wrap: wrap;">
        <div class="col-lg-4 col-md-6 col-4">
            <p>Sports <strong class="d-block text-capitalize">{{ $data['sport'] ? $data['sport'] : "Sport" }}</strong></p>
        </div>
        <div class="col-lg-4 col-md-6 col-4">
            <p>Age Group <strong class="d-block">{{ $data['d']->age_group ? $data['d']->age_group : "Open For All"  }}</strong></p>
        </div>
        <div class="col-lg-4 col-md-6 col-4">
            <p>Language Spoken <strong class="d-block">
                @php
                    if (is_array($data['d']->spoken_languages)) {
                        $languages = $data['d']->spoken_languages;
                    } else {
                        $languages = array_filter(explode(",", $data['d']->spoken_languages), 'strlen');
                    }
                    $languages = !empty($data['d']->spoken_languages) ? explode(',', $data['d']->spoken_languages) : ['Hindi', 'English'];
                @endphp

                @foreach($languages as $index => $language)
                    {{ trim($language) }}{{ $index < count($languages) - 1 ? ',' : '' }}
                @endforeach
            </strong></p>
        </div>
    </div>

    @if(count($open_days) == 0)
        <div class="row" style="flex-wrap: wrap;">
            <div class="col-lg-4 col-md-6 col-4">
                <p>Training Days <strong class="d-block">Monday - Sunday</strong></p>
            </div>
            <div class="col-lg-4 col-md-6 col-4">
                <p>Training Time <strong class="d-block">{{ $data['d']->timing ? $data['d']->timing : "N/A" }}</strong></p>
            </div>
            <div class="col-lg-4 col-md-6 col-4">
              <p>Closed On <strong class="d-block closed-on-text">
                {{ str_replace(',', ', ', $data['d']->closed_on) }}
                </strong></p>
            </div>


        </div>
    @endif

    @if($data['d']->categories)
        <div class="row" style="flex-wrap: wrap;">
            <div class="col-lg-12">
                <p class="text-capitalize">Categories <strong class="d-block">{{ $data['d']->categories ? $data['d']->categories : "" }}</strong></p>
            </div>
        </div>
    @endif
</div>



                @if(count($open_days) > 0)
                    <div class="overview-box days-box white-box">
                        <h2 style="font-size:22px">Training Days And Time</h2>

                        <div class="row">
                            @foreach($open_days as $index => $day_info)
                                    <div class="col-lg-4 col-md-6 col-4 flex-wrap">
                                        <p><strong>{{ $day_info['day'] }}</strong>:</p>
                                        @foreach($day_info['hours'] as $hour)
                                            <p class="mb-0">{{ $hour['open'] }} - {{ $hour['close'] }}</p>
                                        @endforeach
                                    </div>

                                    @if(($index + 1) % 3 == 0 && $index + 1 < count($open_days))
                                        </div>
                                        <div class="row mt-3">
                                    @endif
                            @endforeach
                        </div>


                        @if(count($closed_days) > 0)
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <p><strong>Closed On:</strong></p>
                                    <p>{{ implode(', ', $closed_days) }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif






                @if($MOBILE)

                                <div class="academy-price-fee training-fee">
                                    @php
                                        $priceArray = array_filter(explode(",", $data['fee']), 'strlen');
                                    @endphp
                                    <div class="training-fee-box">
                                    <div class="d-flex justify-content-between align-item-start">
                                        @if(!empty($priceArray) && count($priceArray) > 0)
                                            <h2 style="font-size:22px;">Training Fees</h2>
                                        @else
                                            <h2 style="font-size:22px;">Training Fees <span class="estimate_text">(Estimate)</span></h2>
                                        @endif
                                        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/price.png" alt="price icon" loading="lazy"
                                            class="price_change">
                                    </div>
                                    <div>
                                        <p style="color:red; font-size:12px">*Please click the ₹ icon to request a price change</p>
                                    </div>
                                    </div>

                                    @if(!empty($priceArray) && count($priceArray) > 0)
                                        @foreach ($priceArray as $price)
                                        @php
                                         $priceWithoutRs = preg_replace('/\b[Rr][Ss]\b/', '', $price);
                                         $modifiedPrice = preg_replace_callback('/\d{3,}/', function ($matches) {
                                           return '₹' . $matches[0];
                                         }, $priceWithoutRs);
                                       @endphp
                                     <p>{{ $modifiedPrice }}</p>
                                        @endforeach

                                    @else
                                        <div class="sport_estimate_price container">
                                        </div>
                                    @endif

                                </div>



                @endif


                @if($data['d']->review_summary)
                    <div class="skills-box white-box">
                        <h2 style="font-size:22px">Review Summary: {{ $data['listingTitle'] }} </h2>
                        <p class="fb_fonts customer_para">
                            {{$data['d']->review_summary}}
                        </p>
                    </div>
                @endif


                <div class="facilities-box white-box hidden">
                    <h2 style="font-size:22px">Skills: {{ $data['listingTitle'] }} </h2>
                    <p class="fb_font customer_message">Summary of student reviews. BookMyPlayer.com</p>
                    <div class="loader_img6 mt-3 ">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy"
                            alt="loader">
                    </div>
                </div>

                @if($data['d']->sport_id == 31)
                    <div class="membersip-plans white-box hidden" id="Membership-Plans">
                        <h6>Membership Plans</h6>
                        <div class="membersip-plans-wrap">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                        </div>
                    </div>

                    <div class="icons-list-box gym_fitness white-box mb-3 hidden" id="Fitness-options">
                        <h6>Fitness Options</h6>
                        <div class="icons-list-box__wrap">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                        </div>
                    </div>

                    <div class="icons-list-box white-box mb-3 hidden" id="Premium-Facilities">
                        <h6>Premium Facilities</h6>
                        <div class="icons-list-box__wrap">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                        </div>
                    </div>

                    <div class="icons-list-box white-box mb-3 hidden" id="Equipment">
                        <h6>Equipment</h6>
                        <div class="icons-list-box__wrap gym_equipment">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                        </div>
                    </div>

                    <div class="gym-area-box white-box hidden" id="Gym-Area">
                        <h6>Gym Area</h6>
                        <div class="gym_area">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                        </div>


                    </div>


                    <div class="trial-classes-panel white-box hidden" id="Trial-Classes">
                        <h4>Trial Classes</h4>
                        <p>Encourage potential members to experience the gym's atmosphere and services firsthand with a free
                            or discounted trial class.</p>
                        <ul class="trial_list">
                            <div class="loader_img7 mt-3 " style="text-align: center;">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                    loading="lazy" alt="loader">
                            </div>
                    </div>
                    </ul>

                @endif



                <div class="reviews-rating-box">


                    <div class="reviews-box scrollbar">
                        <div class="d-flex justify-content-between align-items-center mb-3 heading_border">
                            <h3 class="review_heading">Reviews & Rating <span class="academy_review_count">(0)</span>
                            </h3>
                            <!-- <a href="https://www.bookmyplayer.com/academy/add-review/{{ $data['d']->id }}" class="btn btn-secondary no-wrap">Review</a> -->
                            <button class="btn btn-secondary no-wrap" id="openCustomModal">Review</button>

                        </div>
                        <div class="loader_img5 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                    </div>
                </div>


                <div class="about-box white-box hidden">
                    <h2 style="font-size:22px">About: {{ $data['d']->name }}</h2>
                    <div class="loader_img10 mt-3 ">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy"
                            alt="loader">
                    </div>
                    <p class="add-read-more show-less-content about_academy">
                    </p>
                    <div style="text-align: end;">
                        <button id="openWhatsappModal" class="btn btn-secondary">Enquire Now</button>
                    </div>
                </div>


                <div class="photos-box white-box white-box2 hidden" id="media_section">
                    <div class="slider_flex">
                        <h2 style="font-size:22px">Photos: (<span class="photo_count"></span>)</h2>
                        <div class="slider_arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left1"
                                class="lazy" alt="arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right1"
                                class="lazy" alt="arrow">
                        </div>
                    </div>

                    <div class="photos-slider">
                        <div class="loader_img4 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                        <div class="photos-js mt-3 mb-4">
                        </div>
                    </div>
                </div>


                <div class="videos-box white-box white-box2 hidden">
                    <div class="slider_flex">
                        <h4 style="font-size:22px">Videos (<span class="video_count"></span>)</h4>
                        <div class="slider_arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left2"
                                class="lazy" alt="arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right2"
                                class="lazy" alt="arrow">
                        </div>
                    </div>
                    <div class="videos-slider">
                        <div class="loader_img4 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                        <div class="videos-js mt-3">
                        </div>
                    </div>
                </div>



                <div class="certifications-box hidden">
                    <div class="white-box white-box2">
                        <h4 style="font-size:22px" class="text-capitalize">Recognised <span
                                class="certificate_sport"></span> Certifications (<span
                                class="certificate_count"></span>)</h4>
                        <table class="table table-fixed table-lock-height table-custom-width01">
                            <thead class="table-light scrollbar">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col">Type</th>
                                </tr>
                            </thead>
                            <tbody class="scrollbar certificate-table">
                            </tbody>
                        </table>
                        <div class="loader_img8 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                    </div>
                </div>

                <div class="tournaments-box hidden">
                    <div class="white-box white-box2">
                        <h4 style="font-size:22px" class="text-capitalize">Participate In <span
                                class="tournament_sport"></span> Tournaments (<span class="tournament_count"></span>)
                        </h4>
                        <table class="table table-fixed table-lock-height table-custom-width02">
                            <thead class="table-light scrollbar">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody class="tournament-table scrollbar">
                            </tbody>
                        </table>
                        <div class="loader_img8 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                    </div>
                </div>

                <div class="nearby-box hidden">
                    <div class="white-box white-box2">
                        <h4 style="font-size:22px" class="text-capitalize">Nearby Schools (<span
                                class="school_count"></span>)</h4>
                        <table class="table table-fixed table-lock-height table-custom-width02">
                            <thead class="table-light scrollbar">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">School Name</th>
                                    <th scope="col">Location</th>
                                </tr>
                            </thead>
                            <tbody class="school-table scrollbar">
                            </tbody>
                        </table>
                        <div class="loader_img8 mt-3 ">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif"
                                loading="lazy" alt="loader">
                        </div>
                    </div>
                </div>

                <div class="faqs-box white-box hidden">
                    <h3 style="font-size:22px">Frequently Asked Questions</h3>
                    <div class="loader_img9 mt-3 ">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy"
                            alt="loader">
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<section class="similar-academies-section clearfix hidden">
    <div class="container">
        <div class="slider_flex">
            <h2>Similar Academies</h2>
            <div class="slider_arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left3" class="lazy"
                    alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right3" class="lazy"
                    alt="arrow">
            </div>
        </div>

        <div class="loader_img7 mt-3 ">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy"
                alt="loader">
        </div>

        <div class="similar-academies-js">
        </div>
    </div>
</section>

<section class="other-links-section clearfix hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border">Other <span
                    class="text-capitalize">{{ $data['d']->sport ? $data['d']->sport : "Sport" }}</span> Academies</h4>
            <ul style="cursor:pointer" class="other_links">

            </ul>
        </section>
    </div>
</section>



<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content whatsapp_modal">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel">Contact</h5>
                <div type="button" class="close" id="close_whatsapp" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp" style="display: none;">
                    <input type="hidden" name="sport" id="sport_details"
                        value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}" style="display: none;">
                    <input type="hidden" name="sport_id" id="sport_id_details"
                        value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}" style="display: none;">
                    <input type="hidden" name="object_id" id="object_id_details"
                        value="{{ isset($data['id']) ? $data['id'] : '' }}" style="display: none;">
                    <input type="hidden" name="object_type" id="object_type_details"
                        value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}" style="display: none;">
                    <input type="hidden" name="loc_id" id="loc_id_details"
                        value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}" style="display: none;">
                    <input type="hidden" id="listing_title"
                        value="{{ isset($data['listingTitle']) ? $data['listingTitle'] : '' }}" style="display: none;">
                    <input type="hidden" id="academy_address"
                        value="{{ isset($data['address']) ? $data['address'] : '' }}" style="display: none;">

                    <input type="hidden" id="academy_phone" value="{{ $phone }}" style="display: none;">
                    <input type="hidden" name="screen" id="screen_details" value="message" style="display: none;">
                    <span class="error" id="formError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name"
                            placeholder="Please enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email"
                            placeholder="Please enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone"
                            placeholder="Please enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc"
                            placeholder="Please enter your message" autocomplete="off">
                        </textarea>

                    </div>
                    <button type="button" id="otp_modal2" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="whatsappModal2" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel2">Contact</h5>
                <div type="button" class="close" id="close_whatsapp2" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" id="academy_phone2" value="{{ $phone }}" style="display: none;">
                    <input type="hidden" name="source" id="source_details3" value="message" style="display: none;">
                    <input type="hidden" name="sport" id="sport_details3"
                        value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}" style="display: none;">
                    <input type="hidden" name="sport_id" id="sport_id_details3"
                        value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}" style="display: none;">
                    <input type="hidden" name="object_id" id="object_id_details3"
                        value="{{ isset($data['id']) ? $data['id'] : '' }}" style="display: none;">
                    <input type="hidden" name="object_type" id="object_type_details3"
                        value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}" style="display: none;">
                    <input type="hidden" name="loc_id" id="loc_id_details3"
                        value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}" style="display: none;">
                    <input type="hidden" id="listing_title3"
                        value="{{ isset($data['listingTitle']) ? $data['listingTitle'] : '' }}" style="display: none;">
                    <input type="hidden" id="academy_address3"
                        value="{{ isset($data['address']) ? $data['address'] : '' }}" style="display: none;">
                    <span class="error" id="formError2" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name2"
                            placeholder="Please enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email2"
                            placeholder="Please enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone2"
                            placeholder="Please enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc2"
                            placeholder="Please enter your message" autocomplete="off"></textarea>

                    </div>
                    <!-- <button type="button" id="similarAcademyFormButton" class="btn btn-primary">Send</button> -->
                    <button type="button" id="otp_modal3" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>

<div id="customModalOverlay" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <span class="custom-close-btn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt="Cross"
                width="24" height="24"></span>
        <div class="custom-modal-content">
            <section class="post-a-review-section clearfix">
                <div class="container">
                    <div class="profile-box mb-2">
                        <figure><img src="{{$data['logo']}}" class="img-fluid" alt="Profile Image"></figure>
                        <article>
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="text-capitalize">{{$data['d']->name}}</h6>
                                <h6 class="text-capitalize">
                                    <span>{{$data['d']->sport ? $data['d']->sport : "sport"}}</span></h6>
                            </div>
                            <p><i class="fa-solid fa-location-dot"></i> {{$data['d']->city}}, {{$data['d']->state}}</p>
                        </article>
                    </div>
                    @if(Session::has('comment_error'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach(Session::get('comment_error') as $error)
                                    {{ $error }}
                                    <br>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('comment_success'))
                        <div class="alert alert-success">
                            {{ Session::get('comment_success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('add.academy.review') }}" id="reviewForm">
                        @csrf
                        <div class="start-reviewing-box">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <h5>Review {{$data['d']->name}}</h5>
                                <div id="full-stars-example">
                                    <div class="rating-group">
                                        <input class="rating__input" name="rating" id="rating-5" value="5" type="radio">
                                        <label class="rating__label" for="rating-5">&#9733;</label>

                                        <input class="rating__input" name="rating" id="rating-4" value="4" type="radio">
                                        <label class="rating__label" for="rating-4">&#9733;</label>

                                        <input class="rating__input" name="rating" id="rating-3" value="3" type="radio">
                                        <label class="rating__label" for="rating-3">&#9733;</label>

                                        <input class="rating__input" name="rating" id="rating-2" value="2" type="radio">
                                        <label class="rating__label" for="rating-2">&#9733;</label>

                                        <input class="rating__input" name="rating" id="rating-1" value="1" type="radio">
                                        <label class="rating__label" for="rating-1">&#9733;</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 g-md-3 mt-2">
                                <input type="hidden" name="object_type" value="academy">
                                <input type="hidden" name="object_id" value="{{ $data['d']->id }}">
                                <span id="error-message" style="color: red; display: none;"></span>
                                <div class="col-md-6"><input type="text" name="name" id="review_name"
                                        class="form-control your-name" value="" placeholder="Enter Full name"></div>
                                <div class="col-md-6"><input type="text" name="email" id="review_email"
                                        class="form-control your-email" value="" placeholder="Enter Email address">
                                </div>
                                <div class="col-12"><input type="number" name="phone" id="review_phone"
                                        class="form-control your-phone" value="" placeholder="Phone Number"></div>
                                <div class="col-md-12"><textarea name="comment" id="review_comment" class="form-control"
                                        placeholder="Type your Review here..."></textarea></div>
                                <div class="col-md-12 text-center"><button type="button" class="btn btn-secondary"
                                        id="review_academy_button">Post
                                        Review</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>



<div class="modal fade" id="priceChangeModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content whatsapp_modal">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="priceChangeLabel">Request for Price Change</h5>
                <div type="button" class="close" id="close_price" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="" method="post">
                    @csrf

                    <span class="error" id="priceError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="price_name"
                            placeholder="Please enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="price_email"
                            placeholder="Please enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="price_phone"
                            placeholder="Please enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="price_desc"
                            placeholder="Please enter your message" autocomplete="off">
                        </textarea>

                    </div>
                    <button type="button" id="price_send" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="confirm-box" id="modal01" style="z-index: 1000; display:none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content-3">
        <div class="modal-header">
            <h5 class="modal-title" id="modal1Title">Verify Code</h5>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" class="otp_close" alt="cross" height="24"
                width="24">
        </div>
        <div class="modal-body">
            <p>We have sent a verification code to your mobile number/email.</p>
            <div class="d-flex justify-content-center align-items-center edit-phone-number">
                <h6 id="phoneNumberSpan"></h6>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" class="change_num" alt="edit">
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4">
                <input type="text" class="form-control mob_otp_input3" id="otp1" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp2" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp3" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp4" maxlength="1" placeholder="*">
            </div>
            <p class="m-0" id='resend-otp-signup-locid' style="display:none; cursor:pointer;"><img
                    src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-resend.svg" alt="resend"></p>
            <p class="mb-4">
                <span class="mob_login_verify d-flex justify-content-center align-items-center">
                    <span id="time">Resend OTP In 1m 16s</span>
                </span>
            </p>
            <div id="error_msg" class="alert alert-danger error_msg text-center" role="alert"></div>
            <div class="d-flex justify-content-center align-items-center">
                <input type="submit" class="btn btn-secondary btn-lg" id="btn-signup4" value="Verify OTP">
            </div>
        </div>
    </div>
</div>

@endsection