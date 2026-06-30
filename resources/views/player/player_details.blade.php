@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/player_details.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/remodal.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/review.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/fancybox.css') }}" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/player_details_v4.js') }}" defer></script>
<script src="{{ asset('asset/js/review_v2.js') }}" defer></script>
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
// Strip HTML tags from the 'about' field and check if it is not empty or contains non-space characters
$cleanedAbout = strip_tags($data['about']);
@endphp



<section class="player-details-section clearfix mt-3">
    @if(Session::has('success_message_add_review_player'))
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="Success">
                </figure>
                <h6> {{ Session::get('success_message_add_review_player') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_add_review_player'))
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt="Error"></figure>
                <h6> {{ Session::get('error_message_add_review_player') }}</h6>
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
                <div class="player-short-details">
                    <figure>
                        <div class="player-details-js">
                            <div class="item">
                                <a href="{{$data['logo']}}" data-fancybox="gallery" data-caption="Player Logo">
                                    <img src="{{$data['logo']}}" class="img-fluid player_top_img" loading="lazy" alt="Player Logo">
                                </a>
                            </div>

                        </div>
                        <figcaption>Want to play national</figcaption>
                    </figure>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h1 style="font-size:22px;">{{$data['d']->name ?? ""}}</h1>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <p>{{$data['sport'] ?? "sport"}}</p>
                        <p class="color-FB5D52">National Level</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="text-icon">
                            <p>Date Of Birth: {{$data['d']->dob ?? ""}}</p>
                        </div>
                        <p class="color-FB5D52 f-14">{{$data['age']}}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="text-icon">
                            <p class="text-capitalize">{{$data['d']['city']}}, {{$data['d']['state']}}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="text-icon">
                            <p>{{$data['d']->views ?? "0"}} views since last week</p>
                        </div>
                        <p class="color-2860F1 f-14"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-trending-up.svg" loading="lazy" alt="">14%</p>
                    </div>

                    @if(session('success_contact'))
                    <div class="alert alert-success mt-3">
                        {{ session('success_contact') }}
                    </div>
                    @endif

                    <div class="row g-2 mt-3">
                        <div class="col-sm-6"><button class="btn btn-info" id="openWhatsappModal2"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-comment.svg" loading="lazy" alt="Message"> Message</button>
                        </div>
                        <div class="col-sm-6"><button class="btn btn-success" id="openWhatsappModal"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whataspp"> WhatsApp</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="btn btn-light">
                            Connections</a>
                    </div>

                </div>
                <div class="coach-short-details coach-new-details">
                    <div class="image-container">
                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register_player_details.webp" loading="lazy" alt="" class="img-fluid">
                        <div class="overlay-text">
                            <h2>Register as a Player</h2>
                            <p>Participate in professional leagues, gain sponsorships and endorsements, and advance your carrer in sports</p>
                            <div class="button-aligment"> <a href="/register-as-a-player"> <button>Register now</button></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-8">
                <h6>{{$data['d']->heighlight ?? ""}}</h6>

                <div id="horizontal-nav">
                    <div class="btn-prev" role="button" tabindex="0">
                        <svg viewBox="0 0 24 24">
                            <path d="M8.59,16.59L13.17,12L8.59,7.41L10,6l6,6l-6,6L8.59,16.59z" fill="hsl(141, 15%, 50%)">
                            </path>
                        </svg>
                    </div>
                    <div class="menu-wrap">
                        <ul class="menu-anchor tabs-details">
                            <li class="list-item">
                                <a href="#anchor1" class="active">Technical Overview</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor2">Skills</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor3">About</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor4">Experience</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor5">Education</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor6">Honor & Awards</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor7">Achievements & Certificates</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor8">Photos & Videos</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor9">Recommendation</a>
                            </li>
                            <li class="list-item">
                                <a href="#anchor10">Interests</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-next" role="button">
                        <svg viewBox="0 0 24 24">
                            <path d="M8.59,16.59L13.17,12L8.59,7.41L10,6l6,6l-6,6L8.59,16.59z" fill="hsl(141, 15%, 50%)">
                            </path>
                        </svg>
                    </div>
                </div>

                <section class="tabs-content" id="anchor1">
                    <div class="white-box">
                        <h6>Technical Overview of {{$data['d']->name}}</h6>
                        <div class="row">
                            @foreach ($data['default_specifications'] as $specification)
                            <div class="col-lg-4 col-md-6 text-capitalize">
                                <p>{{ $specification['specification'] }}<strong class="d-block">{{ $specification['description'] }}</strong></p>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <p>Played Level <strong class="d-block">National</strong></p>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <p>Date of Birth <strong class="d-block">{{$data['d']->dob ?? "-"}}</strong></p>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <p>Age <strong class="d-block">{{$data['age']}}</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <p>Height <strong class="d-block">{{$data['height']}}</strong></p>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <p>Weight <strong class="d-block">{{ $data['d']->weight ? $data['d']->weight . " kg" : "-" }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="tabs-content" id="anchor2">
                    <div class="white-box">
                        <h6>{{$data['d']->name}} Skills in {{$data['sport'] ?? "sport"}}</h6>
                        <ul class="tags">
                            @foreach ($data['skills'] as $skill)
                            <li>{{ucwords($skill)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                <section class="tabs-content" id="anchor3">
                    <div class="white-box">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <h6>Message on Whatsapp to Contact {{$data['d']->name}} for:</h6>
                            <div id="openWhatsappModal3">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" width="24" height="24" style="cursor:pointer;">
                            </div>
                        </div>

                        <ul>
                            <li>Participation in {{$data['sport']}} tournaments in {{$data['d']['state']}} and other states.</li>
                            <li>Participation in {{$data['sport']}} competitions at National and International level.</li>
                            <li>Play local, district and state level tournaments, events and competitions.</li>
                            <li>Ideal connections: {{$data['sport']}} Tournament Organizers, Local, District & State level teams and competitions.</li>
                        </ul>
                    </div>
                </section>


                @if(($data['about'] !== "" && $data['about'] !== "-") && trim($cleanedAbout) !== "")
                <section class="tabs-content" id="anchor3">
                    <div class="white-box">
                        <h6>About {{$data['d']->name}}</h6>
                        <p>{!! $data['about'] !!}</p>
                    </div>
                </section>
                @endif


                @if (count($data['experience']) > 0)
                <section class="tabs-content" id="anchor4">
                    <div class="white-box">
                        <h6>Experience</h6>
                        @foreach ($data['experience'] as $experience)
                        @php
                        $exp = array_filter(explode(";", $experience), 'strlen');
                        @endphp

                        @if (count($exp) == 3)
                        <div class="content-icon">
                            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/exp1.png" loading="lazy" alt="">
                            </figure>
                            <article>
                                <h6>{{$exp[0] ?? "-"}}</h6>
                                <p><span>{{$exp[1] ?? "-"}}</span></p>
                                <p>{{$exp[2] ?? "-"}}</p>
                            </article>
                        </div>
                        @endif

                        @endforeach
                    </div>
                </section>
                @endif

                @if (count($data['education']) > 0)
                <section class="tabs-content" id="anchor5">
                    <div class="white-box">
                        <h6>Education</h6>
                        @foreach ($data['education'] as $education)
                        @php
                        $edu = array_filter(explode(";", $education), 'strlen');
                        @endphp
                        @if (count($edu) == 2)

                        <div class="content-icon">
                            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/edu1.png" loading="lazy" alt="">
                            </figure>
                            <article>
                                <h6>{{$edu[0] ?? "Graduation"}}</h6>
                                <p><span>{{$edu[1] ?? "-"}}</span></p>
                            </article>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </section>
                @endif

                <section class="tabs-content" id="anchor6">
                    <div class="white-box">
                        <h6>Honor & Awards</h6>
                        <ul>
                            @foreach ($data['awards'] as $award)
                            <li>{{ucwords($award)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                <section class="tabs-content" id="anchor8">
                    @if(count($data['photos'])>0)
                    <div class="slider_flex">
                        <h6>Photos ({{ count($data['photos']) }})</h6>
                        <div class="slider_arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left1" class="lazy" loading="lazy" alt="arrow">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right1" class="lazy" loading="lazy" alt="arrow">
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

                        @if(count($data['videos'])>0)
                        <div class="slider_flex">
                            <h6>Videos ({{ count($data['videos'])}})</h6>
                            <div class="slider_arrow">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left2" class="lazy" loading="lazy" alt="arrow">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right2" class="lazy" loading="lazy" alt="arrow">
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
                            @endif
                </section>

                <section class="tabs-content" id="anchor9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6>Recommendation</h6>
                        <button class="btn btn-secondary" id="openCustomModal">Review Now</button>
                    </div>

                    <div class="reviews-box">
                        <ul class="tabs">
                            <li><a href="#tab1">Receive Reviews</a></li>
                            <li><a href="#tab2">Given Reviews</a></li>
                        </ul>
                        <div class="tabContainer">
                            <div id="tab1" class="tabContent">
                                <div class="scrollbar">
                                    <div id="coach-reviews">
                                        <div class="loader_img">
                                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" class="lazy" alt="loader">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="tab2" class="tabContent">
                                <div class="scrollbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="tabs-content" id="anchor10">
                    <div class="white-box">
                        <h6>Interests</h6>
                        <ul>
                            @foreach ($data['default_intersest'] as $interestItem)
                            <li>{{ $interestItem['interest'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </section>

            </div>
        </div>
    </div>
</section>

<section class="popular-teachers-section clearfix">
    <div class="container">
        <div class="slider_flex">
            <h2>Other Players</h2>
            <div class="slider_arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left3" class="lazy" loading="lazy" alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right3" class="lazy" loading="lazy" alt="arrow">
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
                <h5 class="modal-title" id="whatsappModalLabel">Contact {{$data['d']->name ?? ""}}</h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;"><img src="" alt=""></span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact.player') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details" value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details" value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details" value="{{ isset($data['d']->id) ? $data['d']->id : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details" value="player">
                    <input type="hidden" name="loc_id" id="loc_id_details" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details" value="message" required>
                    <input type="hidden" name="latitude" id="latitude2" value="{{ isset($data['d']->lat) ? $data['d']->lat : '' }}">
                    <input type="hidden" name="longitude" id="longitude2" value="{{ isset($data['d']->lng) ? $data['d']->lng : '' }}">
                    <input type="hidden" id="playerName" value="{{ isset($data['d']->name) ? $data['d']->name : '' }}">
                    <input type="hidden" id="playerPhone" value="{{ isset($data['d']->phone) ? $data['d']->phone : '' }}">
                    <input type="hidden" id="playerAddress" value="{{ isset($data['d']->address) ? $data['d']->address : '' }}">

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
                    <button type="button" id="formSubmitButton" class="btn btn-primary">Send</button>
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

                    <form method="POST" action="{{ route('add.player.review') }}" id="reviewForm">
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
                                <input type="hidden" name="object_type" value="player">
                                <input type="hidden" name="object_id" value="{{ $data['d']->id }}">
                                <span id="error-message" style="color: red; display: none;"></span>
                                <div class="col-md-6"><input type="text" name="name" id="review_name" class="form-control your-name" value=""
                                        placeholder="Enter Full name"></div>
                                <div class="col-md-6"><input type="email" name="email" id="review_email" class="form-control your-email"
                                        value="" placeholder="Enter Email address"></div>
                                <div class="col-12"><input type="tel" name="phone" id="review_phone" class="form-control your-phone" value=""
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


@endsection