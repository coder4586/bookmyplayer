@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/coach_details_v4.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/remodal.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/review.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/fancybox.css') }}" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/review_v2.js') }}" defer></script>
<script src="{{ asset('asset/js/coach_details_v5.js') }}" defer></script>
<script src="{{ asset('asset/js/remodal.js') }}" defer></script>
<script src="{{ asset('asset/js/fancybox.umd.js') }}"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>
@endpush
@extends('layouts.app')
@section('content')

@php
$object_type = "coach";


@endphp

<section class="coach-details-section clearfix">
    @if(Session::has('success_message_add_review_coach'))
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="Success">
                </figure>
                <h6> {{ Session::get('success_message_add_review_coach') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_add_review_coach'))
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt="Error"></figure>
                <h6> {{ Session::get('error_message_add_review_coach') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="coach-short-details">
                    <figure>
                        <a href="{{$data['logo']}}" data-fancybox="gallery" data-caption="Logo">
                            <img src="{{$data['logo']}}" class="img-fluid coach_top_img" alt="logo">
                        </a>
                        <span class="recommended">Recommended</span>
                    </figure>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h6>{{$data['d']->name}}</h6>
                        <div class="verified"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/verified.svg" alt="verify" width="17" height="17">Verified </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start mt-2">
                        <div class="free">Free Trial Class*</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="address">
                            <i class="fa-solid fa-location-dot"></i>
                            <p>{{$data['address']}}</p>
                        </div>
                        <div class="rating">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/star-rating.svg" alt="star" width="17" height="17">
                            <strong>
                                {{ $data['reviews']->count() > 0 ? round($data['reviews']->sum('rating') / $data['reviews']->count(), 1) : "0" }}
                            </strong>
                            ({{ $data['reviews']->count() }})
                        </div>

                    </div>
                    <br>
                    @if(session('success_contact'))
                    <div class="alert alert-success mt-3">
                        {{ session('success_contact') }}
                    </div>
                    @endif
                    <div class="row g-2 mt-3">
                        <div class="col-sm-6"><button id="openWhatsappModal2" class="btn btn-secondary">Message</button></div>
                        <!-- <div class="col-sm-6"><a href="https://api.whatsapp.com/send/?phone=+91{{env('WHATSAPP_LEAD_MOBILE')}}&text=Please+share+more+details+for+{{ $object_type }}+{{$data['d']->name}}" class="btn btn-success"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-whatsapp.svg" width="20" height="20" alt="whatsapp">
                                WhatsApp Now</a></div> -->
                        <div class="col-sm-6"><button class="btn btn-success" id="openWhatsappModal">
                                WhatsApp Now</button></div>
                    </div>

                </div>

                @if(count($data['packages'])>0)
                <div class="coach-short-details coach-new-details">
                    <div class="prize">Pricing & Fee</div>
                    <ul class="tags new-tags mt-3">

                        @foreach ($data['packages'] as $packages)
                        @php
                        $d = array_filter(explode(",", $packages), 'strlen');
                        $formated_pkg = isset($d[1]) && isset($d[0]) ? $d[1] . "RS" . $d[0] : null;
                        @endphp

                        @if($formated_pkg)
                        <div class="prize mt-2 d-flex justify-content-between align-items-center">
                            <span class="price_coach">{{ $d[1] }}</span>
                            <span class="price_value">₹ {{ $d[0] }}</span>
                        </div>
                        @endif
                        @endforeach

                    </ul>
                </div>
                @endif
                @if(count($data['loc_nearby'])>0)
                <div class="coach-short-details coach-new-details">
                    <div>
                        <div class="prize">Areas Served</div>
                        <ul class="tags mt-3">
                            @foreach ($data['loc_nearby'] as $loc)
                            <li><a href="{{ $loc['url'] }}">{{ $loc['locality_name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if(!$MOBILE)
                @if(count($data['skills'])>0)
                <div class="coach-short-details coach-new-details">
                    <div class="prize">Coaching Skills</div>
                    <ul class="tags mt-3">
                        @foreach ($data['skills'] as $skill)
                        <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="coach-short-details coach-new-details">
                    <div class="image-container">
                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register_coach_details.webp" loading="lazy" alt="" class="img-fluid">
                        <div class="overlay-text">
                            <h2>Register as a Coach</h2>
                            <p>Create your free profile today to stat responding to leads and earning a regular income. Stay ahead of competition by ranking higher with our platform</p>
                            <div class="button-aligment"> <a href="/register-as-a-coach-trainer"> <button>Register now</button></a></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>



            <div class="col-md-6 col-lg-7 col-xl-8">
                <h1 style="font-size: 22px;">{{$data['d']->heighlight}}</h1>
                <ul class="tabs-details">
                    <li><a href="#anchor1" class="active">About</a></li>
                    <li><a href="#anchor2">Skills & Locations</a></li>
                    <li><a href="#anchor3">Certificates</a></li>
                    <li><a href="#anchor4">Photos & Videos</a></li>
                    <li><a href="#anchor5">Reviews</a></li>
                    <li><a href="#anchor6">FAQs</a></li>
                </ul>
                <section class="tabs-content" id="anchor1">
                    <h6>About {{$data['d']->name}} ({{ ucfirst($data['sport']) }}
                        Coach in
                        {{ $data['address'] }})
                    </h6>
                    <div class="about_coach">{!! $data['about'] !!}</div>
                </section>
                <section class="tabs-content" id="anchor2">
                    <div class="row">
                        <div class="col-lg-6">
                            <h6>Skills</h6>
                            <ul>
                                @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if(!empty($data['loc_nearby']))
                        <div class="col-lg-6">
                            <h6 class="text-captalized">Locations Served-{{$data['address']}}</h6>
                            <ul>
                                @foreach ($data['loc_nearby'] as $loc)
                                <li class="text-capitalizr"><a href="{{ $loc['url'] }}">{{ $loc['locality_name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                 </section>
                 



                <section class="tabs-content" id="anchor4">
                    @if(count($data['photos']) > 0)
                    <div class="slider_flex">
                        <h6>Photos ({{count($data['photos'])}})</h6>
                        <div class="slider_arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left1" class="lazy" alt="arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right1" class="lazy" alt="arrow">
                        </div>
                    </div>
                    <div class="photos-slider">
                        <div class="photos-slider">
                            <div class="photos-js mt-3 mb-4">
                                <div id="photos">
                                    <div class="loader_img">
                                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(count($data['videos']) > 0)
                        <div class="slider_flex">
                            <h6>Videos ({{count($data['videos'])}})</h6>
                            <div class="slider_arrow">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left2" class="lazy" alt="arrow">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right2" class="lazy" alt="arrow">
                            </div>
                        </div>
                        <div class="videos-slider">
                            <div class="videos-js mt-3">
                                <div id="videos">
                                    <div class="loader_img">
                                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                </section>

                <section class="tabs-content" id="anchor5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6>Reviews & Ratings ({{ isset($data['reviews']) ? count($data['reviews']) : 0 }})</h6>
                        <button class="btn btn-secondary" id="openCustomModal">Review Now</button>
                    </div>
                    @if(count($data['reviews']) > 0)
                    <div class="reviews-box scrollbar">
                        <div id="coach-reviews">
                            <div class="loader_img">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                            </div>
                        </div>
                    </div>
                    @endif
                </section>

                <section class="tabs-content" id="anchor6">
                    <h6 class="mb-3">Frequently Asks Questions</h6>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div id="faqs">
                            <div class="loader_img">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@if($MOBILE)

<div class="coach-short-details coach-new-details">
    <div class="image-container">
        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register_coach_details.webp" loading="lazy" alt="" class="img-fluid">
        <div class="overlay-text">
            <h2>Register as a Coach</h2>
            <p>Create your free profile today to stat responding to leads and earning a regular income. Stay ahead of competition by ranking higher with our platform</p>
            <div class="button-aligment"> <a href="/register-as-a-coach-trainer"> <button>Register now</button></a></div>
        </div>
    </div>
</div>
@endif

<section class="popular-teachers-section clearfix">
    <div class="container">
        <div class="slider_flex">
            <h2 class="text-capitalize">Other {{ $data['d']->sport }} Coaches in {{ $data['address'] }} </h2>
            <div class="slider_arrow" style="width:10rem">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left3" class="lazy" alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right3" class="lazy" alt="arrow">
            </div>
        </div>
        <div class="popular-teachers-js">
            <div id="popular_coaches">
                <div class="loader_img">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">Contact {{$data['d']->name}}</h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details" value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details" value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details" value="{{ isset($data['d']->id) ? $data['d']->id : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details" value="coach">
                    <input type="hidden" name="loc_id" id="loc_id_details" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details" value="message" required>
                    <input type="hidden" name="latitude" id="latitude2" value="{{ isset($data['d']->lat) ? $data['d']->lat : '' }}">
                    <input type="hidden" name="longitude" id="longitude2" value="{{ isset($data['d']->lng) ? $data['d']->lng : '' }}">
                    <input type="hidden" id="coachName" value="{{ isset($data['d']->name) ? $data['d']->name : '' }}">
                    <input type="hidden" id="coachPhone" value="{{ isset($data['d']->phone) ? $data['d']->phone : '' }}">
                    <input type="hidden" id="coachAddress" value="{{ isset($data['d']->address) ? $data['d']->address : '' }}">

                    <span class="error" id="formError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc" placeholder="Enter your description" autocomplete="off">
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <p style="color:#FE5C4D">Your number will be verified</p>
                    </div>
                    <button type="button" id="otp_modal" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>

<div id="customModalOverlay" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <span class="custom-close-btn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt="Cross" width="24" height="24"></span>
        <div class="custom-modal-content">
            <section class="post-a-review-section clearfix">
                <div class="container">
                    <div class="profile-box mb-2">
                        <figure><img src="{{$data['logo']}}" class="img-fluid" alt=""></figure>
                        <article>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-capitalize">{{$data['d']->name}}</h6>
                                <h6 class="text-capitalize"><span>{{$data['d']->sport ? $data['d']->sport : "sport"}}</span></h6>
                            </div>

                            <p><i class="fa-solid fa-location-dot"></i> {{$data['d']->city}}, {{$data['d']->state}}</p>
                            <p><i class="fa-regular fa-envelope"></i> {{$data['d']->email ? $data['d']->email : "-"}}</p>
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

                    <form method="POST" action="{{ route('add.coach.review') }}" id="reviewForm">
                        @csrf
                        <div class="start-reviewing-box">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Start Reviewing</h5>
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
                                <input type="hidden" name="object_type" value="coach">
                                <input type="hidden" name="object_id" value="{{ $data['d']->id }}">
                                <span id="error-message" style="color: red; display: none;"></span>
                                <div class="col-md-6"><input type="text" name="name" class="form-control your-name" id="review_name" value=""
                                        placeholder="Enter Full name"></div>
                                <div class="col-md-6"><input type="email" name="email" class="form-control your-email" id="review_email"
                                        value="" placeholder="Enter Email address"></div>
                                <div class="col-12"><input type="tel" name="phone" class="form-control your-phone" id="review_phone" value=""
                                        placeholder="Phone Number"></div>
                                <div class="col-md-12"><textarea name="comment" id="review_comment" class="form-control"
                                        placeholder="Type your Review here..."></textarea></div>
                                <div class="col-md-12 text-center"><button type="button" class="btn btn-secondary" id="review_button">Post
                                        Review</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="confirm-box" id="modal01" style="z-index: 1000; display:none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content-3">
        <div class="modal-header">
            <h5 class="modal-title" id="modal1Title">Verify Code</h5>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" class="otp_close" alt="cross" height="24" width="24">
        </div>
        <div class="modal-body">
            <p>We have sent a verification code to your mobile number/email.</p>
            <div class="d-flex justify-content-center align-items-center edit-phone-number">
                <h6 id="phoneNumberSpan"></h6>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" class="change_num" alt="edit">
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4">
                <input type="text" class="form-control mob_otp_input3" id="otp10" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp20" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp30" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp40" maxlength="1" placeholder="*">
            </div>
            <p class="m-0" id='resend-otp-signup-locid' style="display:none; cursor:pointer;"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-resend.svg" alt="resend"></p>
            <p class="mb-4">
                <span class="mob_login_verify d-flex justify-content-center align-items-center">
                    <span id="time">Resend OTP In 1m 16s</span>
                </span>
            </p>
            <div id="error_msg" class="alert alert-danger error_msg text-center" role="alert"></div>
            <div class="d-flex justify-content-center align-items-center">
                <input type="submit" class="btn btn-secondary btn-lg" id="btn-signup5" value="Verify OTP">
            </div>
        </div>
    </div>
</div>








<!-- /CONTENT SECTION -->

@endsection