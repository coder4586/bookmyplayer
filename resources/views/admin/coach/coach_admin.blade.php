@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('asset/css/tournament_v3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/pricing.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/coach_admin_v7.css') }}" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/admin/coach_admin_v7.js') }}" defer></script>
<script src="{{ asset('asset/js/tournament_v13.js') }}" defer></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>
@endpush

@php

@endphp

@extends('layouts.admin_app')
@section('content')

<!-- CONTENT SECTION -->
<section class="dashboard-menu-section clearfix">
    <input type="hidden" id="hiddenSportId" data-sport_id="{{ $data['d']->sport_id }}" />


    @if(Session::has('success_update_coach'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_update_coach') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_update_coach'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_update_coach') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_add_faq'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_add_faq') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_add_faq'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_add_faq') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_delete_faq'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_delete_faq') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_delete_faq'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_delete_faq') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_upload_photo'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_upload_photo') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_upload_photo'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_upload_photo') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_delete_photos'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_delete_photos') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_delete_photos'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_delete_photos') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_upload_cert'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_upload_cert') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_upload_cert'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_upload_cert') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success_message_delete_cert'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_delete_cert') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_delete_cert'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_delete_cert') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('success_message_create_ticket'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="">
                </figure>
                <h6> {{ Session::get('success_message_create_ticket') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_create_ticket'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
                <h6> {{ Session::get('error_message_create_ticket') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="row">
            @if(!$MOBILE)
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu active" id="dashboard_box"><span class="icon-icon-01"></span>Dashboard</div>
                </div>
            </div>
            @endif
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="profile-progress">
                        <div class="progress-bar"><span style="width: {{$data['overall_percent']}}%;"></span></div>
                        <div class="progress-txt">{{$data['overall_percent']}}%</div>
                    </div>
                    <div class="top_menu" id="profile_box"><span class="icon-icon-02"></span>Edit Profile</div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="page-menu active-page">
                    <div class="top_menu" id="leads_box">
                        <div class="lead_count_box">
                            <span class="leads_count">{{$data['leads'] ? count($data['leads']) : "0"}}</span>
                        </div>
                        <span class="icon-icon-03"></span>Leads
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="boost_box"><span class="icon-icon-04"></span>Plans</div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="notification_box">
                        <div class="lead_count_box">
                            <span class="leads_count">0</span>
                        </div>
                        <span class="icon-icon-06"></span>Contact Support
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu" id="tournament_box"><span class="icon-icon-04"></span>Tournaments</div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu" id="view_box"><span class="icon-icon-04"></span>View Tournaments</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dashboard-info-section clearfix" id="dashboard_info">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="profile-box">
                    <figure class="profile_top_pic">
                        <img src="{{ $data['logo'] }}" alt="">
                    </figure>

                    <article>
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="hidden" id="coach_name" value="{{$data['d']->name ? $data['d']->name : '-'}}">
                            <h6 id="top-left-card-name">{{$data['d']->name ? $data['d']->name : '-'}}</h6>
                            <h6><span class="text-capitalize">{{$data['sport']}} Coach</span></h6>
                        </div>

                        <p class="location_top"><i class="fa-solid fa-location-dot"></i>{{$data['address'] ? $data['address'] : null}}</p>
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <p class="dashboard-email" style="flex-grow: 1;" id="email-display"><i class="fa-regular fa-envelope"></i>
                                {{$data['d']->email ? $data['d']->email : '-'}}
                            </p>
                            @if($data['email_verified']>0)
                            <div class="validate" id="verified">Verified</div>
                            @else
                            <div class="validate" id="verify-email-button">Verify Email</div>
                            @endif
                        </div>
                        <p><i class="fa-solid fa-mobile-screen-button"></i> +91
                            {{$data['d']->phone ? $data['d']->phone : '-'}}
                        </p>
                        <p>Last Login: {{$data['last_login']}}</p>
                        <div class="d-flex justify-content-between align-items-center gap-3 mt-3">
                            <a href="{{ $data['d']->url }}"><button class="btn btn-success">View Profile</button></a>
                            @if($data['pin']==null)
                            <button class="btn btn-primary set_pin_btn" id="pin_btn">Set Pin</button>
                            @else
                            <input type="hidden" id="pin_value" value="{{ $data['pin'] }}">
                            <button class="btn btn-success update_pin_btn" id="pin_btn">View Pin</button>
                            @endif
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-md-6">
                <div class="upgrade-box">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-premium.svg" alt="" width="80" height="80"></figure>
                    <h5>Upgrade to Premium</h5>
                    <p>Become a vip member to get more features</p>
                    <div class="upgradebutton" id="upgrade_box"><button class="btn btn-secondary btn-lg"><i class="fa-solid fa-crown"></i> Upgrade Now</button></div>
                </div>
            </div>
        </div>
    </div>
</section>



<main id="dashboard_page">

    <section class="dashboard-total-section clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="total-box">
                        <figure><img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/icon-03.svg" class="img-fluid" alt=""></figure>
                        <aside>
                            <p>Last Login</p>
                            <h5>{{$data['last_login']}}</h5>
                        </aside>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="total-box">
                        <figure><img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/icon-03.svg" class="img-fluid" alt=""></figure>
                        <aside>
                            <p>Total Leads</p>
                            <h5>{{count($data['leads'])}}</h5>
                        </aside>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="total-box">
                        <figure><img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/icon-03.svg" class="img-fluid" alt=""></figure>
                        <aside>
                            <p>Total Visitors</p>
                            <h5>{{$data['d']->views ?? 0}}</h5>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-reviews-section clearfix">
        <div class="container">
            <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>Reviews & Ratings ({{$data['reviews'] ? count($data['reviews']) : '0'}})</h6>
                <a href="#modal02" class="btn btn-secondary">Request Review</a>
            </div> -->

            <div class="remodal reviews-form" data-remodal-id="modal02" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
                <div>
                    <h5>Request Review</h5>
                    <!-- <p>Enter the details of your client and send for a review of your Service. Or Just copy the link and
                        send.</p>
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="" placeholder="Enter your Full name">
                    </div>
                    <div class="mt-3">
                        <input type="email" class="form-control your-email" id="" placeholder="Enter your Email">
                    </div>
                    <div class="mt-3 mb-4">
                        <input type="tel" class="form-control your-phone" id="" placeholder="Enter your Phone Number">
                    </div>
                    <input type="submit" class="btn btn-secondary btn-lg" value="Send Request for Review">
                    <div class="divider line one-line">OR</div> -->
                    <div class="row">
                        <div class="col-sm-8"><input type="text" class="form-control" id="linkInputDashboard" value="https://www.bookmyplayer.com/coach/add-review/{{$data['d']->id}}"></div>
                        <div class="col-sm-4"><button type="button" class="btn btn-secondary btn-lg" id="copy_link_dashboard">Copy Link</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reviews-box">
                <div id="coach-admin-reviews">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" alt="">
                </div>
                <!-- <div class="text-end mt-3 mb-3">
                    <a href="#" class="btn btn-outline-primary">See all Reviews</a>
                </div> -->
            </div>
        </div>
    </section>
</main>

<main id="profile_page" class="hidden">
    <section class="complete-profile-section clearfix mt-3">
        <div class="container">
            <section class="notifications_box" style="display: flex; justify-content: space-between; align-items:start; gap:1rem; text-align:start; flex-wrap:nowrap;">
                <h5>Complete your profile to 80% or more to get more leads.</h5>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt="cross" width="24" height="24" class="notification_cross" style="cursor:pointer">
            </section>
        </div>
    </section>
    <section class="add-personal-info-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd01">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Add Personal Info
                        </button>
                        <div class="radialProgressBar progress-90">
                            <div class="overlay">{{$data['completion_percent']['personal_info_percent']}}%</div>
                        </div>
                    </h2>
                    <form action="{{ route('coach.update') }}" method="post" id="coach_update" autocomplete="off">
                        @csrf
                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionadd01">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="" class="form-label">Summary Heading</label>
                                            <label for="" class="form-label"><span>0 - 10 Words</span></label>
                                        </div>
                                        <input name="heighlight" id="profile-heighlight" class="form-control" value="{{$data['d']->heighlight ? $data['d']->heighlight : ''}}">

                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" name="name" placeholder="Please Enter Your Name" class="form-control your-name" id="profile-name" value="{{$data['d']->name ? $data['d']->name : ''}}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="email" placeholder="Please Enter Your Email" name="email" class="form-control" id="" value="{{$data['d']->email ? $data['d']->email : ''}}">

                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="tel" class="form-control" placeholder="Please Enter Your Phone Number" value="{{$data['d']->phone ? $data['d']->phone : ''}}">
                                        <div class="verified">Verified</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="col-lg-8 col-md-6 w-100 location-box">
                                            <input type="text" placeholder="Please Enter Your City" name="city" class="form-control" id="locationInput" value="{{$data['address'] ? $data['address'] : 'select'}}">
                                            <div id="location-name" class="location-list">
                                                <!-- Dynamically filled based on input -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select range form this location</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-center align-items-center gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="gender" type="radio" id="male" value="male" {{ $data['d']->gender == 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $data['d']->gender == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="" class="form-label">About Yourself</label>
                                            <label for="" class="form-label"><span>0 - 500 Words</span></label>
                                        </div>
                                        <textarea name="about" id="profile-about" class="form-control" style="display: none;">{{$data['d']->about ? $data['d']->about : ''}}</textarea>
                                        <div id="editor" class="mb-4"></div>
                                    </div>
                                    <div class="col-lg-12 text-end top_btn_margin">
                                        <button type="button" id="btn-save-personal-info" class="btn btn-secondary">Save & Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="add-pricing-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd02">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Add Pricing (<span id="package-count">{{ count($data['packages']) }}</span>)
                        </button>
                        <div class="radialProgressBar progress-package progress-{{$data['completion_percent']['package']}}">
                            <div class="overlay">{{$data['completion_percent']['package']}}%</div>
                        </div>
                    </h2>
                    <form action="{{ route('coach.update') }}" method="post" id="package_update" autocomplete="off">
                        @csrf
                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionadd02">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3" id="packageList">
                                    @foreach($data['packages'] as $package)
                                    <div class="col-lg-4 col-md-6 skill-item">
                                        <div class="input-container">
                                            <input type="text" class="form-control" value="{{ $package }}">
                                            <div class="remove">
                                                <img src="https://d2bdxhtfh3zsqc.cloudfront.net/asset/images/remove.svg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <input type="hidden" name="package" id="package_hidden">
                                    <input type="hidden" name="trial_class" id="trial_hidden">
                                    <div class="add-name-price">
                                        <div class="row g-2 g-md-3 d-flex justify-content-between align-items-center">
                                            <div class="col-lg-5 col-md-5">
                                                <input type="text" class="form-control" id="packageName" placeholder="Enter The Package Name">
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" id="packageAmount" placeholder="Enter Amount (In Numbers)">
                                            </div>
                                            <div class="col-lg-3 col-md-4 group_check">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="packageType" id="personalRadio" value="Personal" checked>
                                                    <label class="form-check-label" for="personalRadio">Personal</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="packageType" id="groupRadio" value="Group">
                                                    <label class="form-check-label" for="groupRadio">Group</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" id="btn-add-pricing" class="btn btn-success btn-add price-add"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-check mt-3">
                                                    <input type="checkbox" class="form-check-input" id="free-class-checkbox" {{$data['d']->trial_class == 1 ? "checked" : ""}}>
                                                    <label class="form-check-label" for="free-class-checkbox">Yes I will
                                                        provide a Free
                                                        Trial Class</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="average">Your Site Average Price is <strong>₹ 1550</strong>
                                                    (High)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end mt-2">
                                    <button type="button" class="btn btn-secondary pacakage-save-btn" id="btn-save-coach-packages">Save
                                        &amp; Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('coach.update') }}" method="post" id="skill_update" autocomplete="off">
        @csrf
        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
        <section class="add-skills-section clearfix">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd03">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                Add Skills, Achievements & Experience
                            </button>
                            <div class="radialProgressBar progress-{{ $data['completion_percent']['skills'] }}">
                                <div class="overlay">{{ $data['completion_percent']['skills'] }}%</div>
                            </div>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree" data-bs-parent="#accordionadd03">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3" id="skills-container">
                                    @foreach($data['skills'] as $skill)
                                    <div class="col-lg-4 col-md-6 skill-item">
                                        <input type="text" class="form-control" value="{{ $skill }}">
                                        <div class="remove">
                                            <img src="https://d2bdxhtfh3zsqc.cloudfront.net/asset/images/remove.svg" alt="">
                                        </div>
                                    </div>
                                    @endforeach

                                    <div id="coach-skills-listing"> </div>
                                    <input type="hidden" name="skill" id="skill_hidden">
                                    <div class="col-lg-4 col-10 col-md-5" class="skill-box">
                                        <input type="text" class="form-control white-bg" id="new-skill" placeholder="Enter your Skills and Achievements here..">
                                        <div id="skill-name" class="skill-list">
                                            <!-- Dynamically filled based on input -->
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-2 col-md-1">
                                        <button type="button" class="btn btn-success btn-add" id="btn-add-skill"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <select name="experience" class="form-control your-name" id="">
                                            <option value="">Experience</option>
                                            @for ($i = 1; $i <= 20; $i++) <option value="{{ $i }}" {{ $data['d']->experience == $i ? 'selected' : '' }}>
                                                {{ $i }} year{{ $i > 1 ? 's' : '' }}
                                                </option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <button type="button" class="btn btn-secondary btn-save-coach-skills">Save &
                                            Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>


    <section class="add-classes-locations-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd04">
                <form action="{{ route('coach.update') }}" method="post" id="training_update" autocomplete="off">
                    @csrf
                    <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                    <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                Add Classes Locations
                            </button>
                            <div class="radialProgressBar progress-0" id="progress-bar">
                                <div class="overlay">0%</div>
                            </div>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionadd04">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3">
                                    <div class="col-auto training-label">
                                        <label for="" class="col-form-label">Training Locations</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row g-2 g-md-3 align-items-center training-location">
                                            <input type="hidden" name="location" id="location_place">
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <input type="checkbox" value="online" name="checkbox" class="form-check-input" id="exampleCheck11" {{in_array("online", $data['location_type']) ? "checked" : ""}}>
                                                    <label class="form-check-label" for="exampleCheck11">Online</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <input type="checkbox" value="home" name="checkbox" class="form-check-input" id="exampleCheck12" {{in_array("home", $data['location_type']) ? "checked" : ""}}>
                                                    <label class="form-check-label" for="exampleCheck12">Home</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <input type="checkbox" value="other" name="checkbox" class="form-check-input" id="exampleCheck13" {{in_array("other", $data['location_type']) ? "checked" : ""}}>
                                                    <label class="form-check-label" for="exampleCheck13">Other
                                                        Places</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-body location-border-top">
                                    <div class="row g-2 g-md-3" id="location-container">
                                        <div class="col-lg-6 col-10 col-md-6 training-box">
                                            <input type="text" class="form-control white-bg" id="new-location" value="{{$data['location_description']}}" placeholder="Enter your training location...">
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <button class="btn btn-secondary location-save-btn">Save & Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="add-certificates-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd05">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            Add Certificates ({{count($data['certificates'])}})
                        </button>
                        <div class="radialProgressBar progress-{{ $data['completion_percent']['certificate'] }}">
                            <div class="overlay">
                                {{ $data['completion_percent']['certificate'] }}%
                            </div>
                        </div>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse " aria-labelledby="headingFive" data-bs-parent="#accordionadd05">
                        <div class="accordion-body">
                            <div class="row g-2 g-md-3">
                                <form action="{{ route('coach.delete.certificates') }}" method="post" id="delete_form3" autocomplete="off">
                                    @csrf
                                    <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                    <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                    <div class="row g-2 g-md-3" id="certificateContainer">
                                        @foreach($data['certificates'] as $certificate)
                                        <div class="col-lg-3 col-md-6">
                                            <div class="add-card">
                                                <div class="delete">
                                                    <input type="checkbox" class="certificate-checkbox" name="selected_certificates[]" value="{{ $certificate }}">
                                                </div>
                                                @php
                                                $extension = pathinfo($certificate, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic', 'bmp', 'tiff', 'svg', 'ico', 'avif']))
                                                <figure><img src="{{ $certificate }}" alt=""></figure>
                                                @elseif($extension == 'pdf')
                                                <div class="pdf-container">
                                                    <figure><img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/pdf_img.png" alt="PDF File"></figure>
                                                    <a href="{{ $certificate }}" target="_blank" class="view-pdf-link">View PDF</a>
                                                </div>
                                                @elseif($extension == 'doc' || $extension == 'docx')
                                                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/logo.svg" alt="DOC File"></figure>
                                                <a href="{{ $certificate }}" target="_blank">View Document</a>
                                                @else
                                                <p>Unknown file type</p>
                                                @endif
                                                <!-- <input type="text" class="form-control white-bg" id="" value="" placeholder="Enter Certificate name"> -->
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </form>
                                <div class="col-lg-3 col-md-6">
                                    <form action="{{ route('coach.upload.certificates') }}" method="post" enctype="multipart/form-data" id="certificate_submit" autocomplete="off">
                                        @csrf
                                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                        <div class="add-new-file">
                                            <label class="filelabel">
                                                <i class="fa-solid fa-plus"></i>
                                                <span class="title" onclick="document.querySelector('#file-upload-3').click()">
                                                    Upload New Certificate
                                                </span>
                                                <input class="FileUpload1" name="file[]" type="file" id="file-upload-3" multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/heic,image/bmp,image/tiff,image/svg+xml,image/x-icon,image/avif,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />

                                            </label>
                                        </div>
                                        <div class="error_img">
                                            <div id="fileTypeError" class="error-message" style="display:none; color: red;"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3 col-md-6 delete_btn_3" style="display: none;">
                                    <div class="delete-new-file">
                                        <label class="filelable2">
                                            <i class="fa-solid fa-minus"></i>
                                            <span class="title">
                                                Delete Selected Certificates
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="add-photos-section clearfix">
        <div class="container">

            <div class="accordion add-accordion" id="accordionadd06">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                            Add Photos (<span class="count_total_photo">{{ count($data['photos']) }}</span>)
                            <input type="hidden" style="display: none;" id="totalPics" val="{{ count($data['photos']) }}">
                        </button>
                        <div>
                            <div class="radialProgressBar progress-{{$data['completion_percent']['photo']}}">
                                <div class="overlay">{{$data['completion_percent']['photo']}}%</div>
                            </div>
                        </div>

                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionadd06">
                        <div class="accordion-body">
                            <div class="row g-2 g-md-3">
                                <form action="{{ route('coach.delete.photos.videos') }}" method="post" id="delete_form" autocomplete="off">
                                    @csrf
                                    <input hidden type="text" name="loc_id" id="loc_id_input" value="">
                                    <input hidden type="text" name="name" id="hidden_name_input" value="">
                                    <div class="row g-2 g-md-3 photos-container">
                                        @foreach($data['photos'] as $index => $photo)
                                        <div class="col-lg-3 col-md-6 photo-card">
                                            <div class="add-card">
                                                <div class="make-profile d-flex justify-content-start align-items-start gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input profile-radio" type="radio" name="flexRadioDefault" id="flexRadio{{ $index }}" value="{{ $photo }}">
                                                        <label class="form-check-label" for="flexRadio{{ $index }}">Make Profile Image</label>
                                                    </div>
                                                </div>
                                                <div class="delete">
                                                    <input type="checkbox" class="photos-checkbox" name="selected_images[]" value="{{ $photo }}">
                                                </div>
                                                <figure><img src="{{ $photo }}" alt=""></figure>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </form>

                                @if(count($data['photos']) > 0)
                                <label for="select-all" style="display: flex; align-items: center; cursor: pointer;" class="mb-3">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                    Select all photos
                                </label>
                                @endif

                                <div class="col-lg-3 col-md-6">
                                    <form action="{{ route('coach.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="img_submit" autocomplete="off">
                                        @csrf
                                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                        <div class="add-new-file">
                                            <label class="filelabel">
                                                <i class="fa-solid fa-plus"></i>
                                                <span class="title">Upload New Images</span>
                                                <input class="FileUpload1" name="file[]" type="file" id="file-upload" multiple accept="image/jpeg,image/png,image/gif,image/webp" />
                                            </label>
                                        </div>
                                        <div class="error_img">
                                            <div id="fileTypeError" class="error-message" style="display: none; color: red;"></div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-3 col-md-6 delete_btn" style="display: none;">
                                    <div class="delete-new-file">
                                        <label class="filelable2">
                                            <i class="fa-solid fa-minus"></i>
                                            <span class="title">Delete Selected Images</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="add-videos-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd07">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            Add Videos ({{ count($data['videos']) }})
                        </button>
                        <div class="radialProgressBar progress-{{$data['completion_percent']['video']}}">
                            <div class="overlay">{{$data['completion_percent']['video']}}%</div>
                        </div>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse " aria-labelledby="headingSeven" data-bs-parent="#accordionadd07">
                        <div class="accordion-body">

                            <form action="{{ route('coach.delete.photos.videos') }}" method="post" id="delete_form2" autocomplete="off">
                                @csrf
                                <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                <div class="row g-2 g-md-3 videos-container">
                                    @foreach($data['videos'] as $video)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="add-card">
                                            <figure>
                                                <video controls class="fast_check">
                                                    <source src="{{ $video }}" type="video/mp4">
                                                    <source src="{{ $video }}" type="video/quicktime">
                                                    <source src="{{ $video }}" type="video/ogg">
                                                </video>
                                            </figure>
                                            <div class="delete">
                                                <input type="checkbox" class="video-checkbox" name="selected_videos[]" value="{{ $video }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </form>
                            @if(count($data['videos']) > 0)
                            <label for="select-all-video" style="display: flex; align-items: center; cursor:pointer;" class="mb-3">
                                <input type="checkbox" class="form-check-input" id="select-all-video">
                                Select all Videos
                            </label>
                            @endif

                            <div class="col-lg-3 col-md-6">
                                <form action="{{ route('coach.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="video_submit" autocomplete="off">
                                    @csrf
                                    <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                    <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                    <div class="add-new-file">
                                        <label class="filelabel">
                                            <i class="fa-solid fa-plus"></i>
                                            <span class="title">Upload New Videos</span>
                                            <input class="FileUpload1" name="file[]" type="file" id="file-upload-2" multiple accept="video/mp4,video/webm,video/ogg,video/quicktime" />
                                        </label>
                                    </div>
                                    <div class="error_img">
                                        <div id="fileTypeError" class="error-message" style="display:none; color: red;"></div>
                                    </div>
                                </form>



                            </div>
                            <div class="col-lg-3 col-md-6 delete_btn2" style="display: none;">
                                <div class="delete-new-file">
                                    <label class="filelable2">
                                        <i class="fa-solid fa-minus"></i>
                                        <span class="title">
                                            Delete Selected Videos
                                        </span>
                                    </label>
                                </div>

                                <div class="error_img">
                                    <div id="fileTypeError" class="error-message" style="display:none; color: red;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="add-reviews-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd08">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                            Request Reviews
                        </button>
                        <!-- <div class="radialProgressBar progress-40">
                            <div class="overlay">40%</div>
                        </div> -->
                    </h2>
                    <form action="{{ route('coach.add.reviewrequest') }}" method="post" autocomplete="off">
                        @csrf
                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                        <div id="collapseEight" class="accordion-collapse collapse " aria-labelledby="headingEight" data-bs-parent="#accordionadd08">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3">
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" class="form-control white-bg your-name" name="name" id="" value="" placeholder="Person name">
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <input type="text" class="form-control white-bg your-email" name="email" id="" value="" placeholder="Person’s Email Address">
                                    </div>
                                    <div class="col-lg-3"><button type="submit" class="btn btn-secondary btn-full">Send
                                            Request for Review</button></div>
                                    <div class="col-lg-12">
                                        <div class="divider line one-line">OR</div>
                                    </div>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" class="form-control white-bg" id="linkInput" value="https://www.bookmyplayer.com/coach/add-review/{{$data['d']->id}}">
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <button type="button" class="btn btn-secondary btn-full" id="copy_link">Copy
                                            Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="add-faqs-section clearfix">
        <div class="container">
            <div class="accordion add-accordion" id="accordionadd09">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNine">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                            <!-- Add Frequently Asks Questions ({{count($data['coach_faqs'])}}) -->
                            Frequently Asks Questions
                        </button>
                        <div class="radialProgressBar progress-{{$data['completion_percent']['faqs']}}">
                            <div class="overlay">{{ $data['completion_percent']['faqs'] }}%</div>
                        </div>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionadd09">
                        <div class="accordion-body">
                            <div class="row g-2 g-md-3" id="faq-list">
                                <form action="{{ route('coach.delete.faqs') }}" method="post" id="delete_form4" autocomplete="off">
                                    @csrf
                                    <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                    <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                    <div class="row g-2 g-md-3">
                                        @foreach($data['custom_faqs'] as $index => $custom_faq)
                                        <div class="col-lg-11 col-10 col-md-11" style="pointer-events: none;">
                                            <div class="input-group">
                                                <textarea name="custom_faqs[{{ $index }}][question]" id="question_{{ $index }}" class="form-control top-input red-input">{{ $custom_faq->question }}</textarea>
                                                <textarea name="custom_faqs[{{ $index }}][answer]" id="answer_{{ $index }}" class="form-control bot-input">{{ $custom_faq->answer }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-2 col-md-1 text-end">
                                            <input type="checkbox" class="form-check-input faq-checkbox" name="faq_ids[]" value="{{ $custom_faq->id }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="faq_ids" name="faq_ids" value="">
                                </form>

                                <div class="col-lg-11 col-10 col-md-11">
                                    <form action="{{ route('coach.add.faqs') }}" method="post" id="add_form" autocomplete="off">
                                        @csrf
                                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                                        <div class="input-group">
                                            <input type="text" name="question" class="form-control white-bg top-input red-input" id="" value="" placeholder="Enter Question Here">
                                            <input type="text" name="answer" class="form-control white-bg bot-input" id="" value="" placeholder="Type your answer here...">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-1 col-2 col-md-1 text-end faq-add">
                                    <button type="button" class="btn btn-danger btn-add"><i class="fa-solid fa-plus"></i></button>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-secondary delete_btn4" style="display: none;">Delete</button>
                                    <div id="customConfirmBox" class="confirm-box" style="display: none;">
                                        <div class="confirm-backdrop"></div>
                                        <div class="confirm-content">
                                            <div class="confirm-body">
                                                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/delete.gif" class="img-fluid" alt=""></figure>
                                                <h6>Are you sure you want to delete this item??</h6>
                                            </div>
                                            <div class="confirm-footer">
                                                <button id="confirmOk" class="btn btn-outline-primary">OK</button>
                                                <button id="confirmCancel" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<main id="leads_page" class="hidden">

    <section class="total-leads-section lead_padding clearfix">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center leads_heading">
                <h4>Total Leads ({{$data['leads'] ? count($data['leads']) : "0"}})</h4>
                <aside class="filter-sortby">
                    <input type="text" name="" id="" class="form-control filter" placeholder="Filter">
                    <!-- <select name="" id="" class="form-control sortby">
                        <option value="">Sort by</option>
                    </select> -->
                </aside>
            </div>
            <div class="row mt-3" id="coach-admin-leads">
            </div>
            @if(count($data['leads'])>0)
            <h4>Total Leads ({{$data['leads'] ? count($data['leads']) : "0"}})</h4>
            @endif
        </div>
    </section>

</main>

<main id="boost_page" class="hidden">
    <section class="plan-pricing-section clearfix">
        <div class="container">
            <div class="top_flex">
                <h6 class="fw-bold plan_need">Pick the Perfect Plan for your needs</h6>
                <div class="slider_arrow">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left1" class="lazy" alt="arrow">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right1" class="lazy" alt="arrow">
                </div>
            </div>
            <br />
            <div>
                <span style="font-weight: 700;">Current Plan: </span> <span style="color:#FB5D52; font-weight:700;">
                    {{ $data['current_plan'] == 5 ? 'Basic Plan' : ($data['current_plan'] == 6 ? 'Standard Plan' : ($data['current_plan'] == 7 ? 'Premium Plan' : ($data['current_plan'] == 8 ? 'Leads Plan' : 'Basic Plan'))) }}</span>
            </div>
            <section class="scroll-pricing">
                <div class="row flex-nowrap plan_map">
                </div>
            </section>
        </div>
    </section>
</main>

<main id="upgrade_page" class="hidden mt-3">

    <section class="volume-calculator-section clearfix">
        <div class="container">
            <h6 class="text-center fw-bold">Lead Volume Calculator</h6>
            <section>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control text-capitalize" value="{{$data['sport']}}" style="pointer-events: none;">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control text-capitalize" value="{{$data['address']}}" style="pointer-events: none;">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="Monthly Volume ({{$data['city_leads']->lead_count}})" style="pointer-events: none;">
                    </div>
                </div>
            </section>
        </div>
    </section>

    <section class="plan-pricing-section clearfix">
        <div class="container">
            <h6 class="text-center fw-bold">Our PRICING</h6>
            <p class="text-center">Upgrade to premium to access more features and benefits.</p>
            <section class="scroll-pricing">
                <div class="row flex-nowrap">
                    <div class="col-4 min-width">
                        <div class="package-features">
                            <div class="heading">Package Features</div>
                            <ul>
                                <li>Free Academy Listing</li>
                                <li>Leads</li>
                                <li>Support</li>
                                <li>Social Links</li>
                                <li>No of Photos you can show</li>
                                <li>No of Videos you can show</li>
                                <li>No of Testimonial you can show</li>
                                <li>Customer Reviews</li>
                                <li>Whatsapp Integration</li>
                                <li>Contact form for your leads queries</li>
                                <li>Profile views (you can see who views your academic profile)</li>
                                <li>Monthly Newsletter (Receive a monthly newsletter with tips and updates, which academies from ur location are on top, which sub location have potential market and lots of analysis)</li>
                                <li>Profile Customization</li>
                                <li>Multiple Login to Manage Account</li>
                                <li>Profile Boosting</li>
                                <li>Advanced Profile Customization</li>
                                <li>Success Stories and Case Studies</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-4 min-width">
                        <div class="free-plan">
                            <div class="heading">Free Plan</div>
                            <ul>
                                <li>Free</li>
                                <li>Direct Leads from your Profile</li>
                                <li>Free Support</li>
                                <li>2 Links</li>
                                <li>8 Photos</li>
                                <li>2 Videos</li>
                                <li>8 Testimonial</li>
                                <li>5 Reviews</li>
                                <li class="no">NO</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="no">NO</li>
                                <li class="no">NO</li>
                                <li class="no">NO</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-secondary btn-lg" disabled>Current Plan</button>
                    </div>
                    <div class="col-4 min-width">
                        <div class="premium-plan">
                            <div class="heading">₹ 7080 <span>Premium (Yearly)</span></div>
                            <ul>
                                <li>6000+1080 GST=7080 Rs (Yearly)</li>
                                <li>10 Leads/Month. 120 Yearly Leads *</li>
                                <li>Priority Support</li>
                                <li>6 Links</li>
                                <li>Unlimited Photos</li>
                                <li>Unlimited Videos</li>
                                <li>Unlimited Testimonial</li>
                                <li>Unlimited Reviews</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li class="yes">YES</li>
                                <li>Highlight in Search Results</li>
                                <li>Custom Profile Templates to Standout</li>
                                <li>Feature success stories and case studies to build credibility.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg"><i class="fa-solid fa-crown" aria-hidden="true"></i> Upgrade to Premium</button>
                    </div>
                </div>
            </section>
        </div>
    </section>


    <section class="plan-info-section clearfix">
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-start align-items-center">
                        <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-five-stars.svg" loading="lazy" alt=""></figure>
                        <article>
                            <h6>Rated 4.8/5 stars <span class="d-block">in 10,142+ reviews</span></h6>
                        </article>
                    </div>
                    <div class="col-md-4 d-flex justify-content-start align-items-center">
                        <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-rotate-arrow.svg" loading="lazy" alt=""></figure>
                        <article>
                            <h6>7-day risk <span class="d-block">free cancelation</span></h6>
                        </article>
                    </div>
                    <div class="col-md-4 d-flex justify-content-start align-items-center">
                        <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-award.svg" loading="lazy" alt=""></figure>
                        <article>
                            <h6>Award-winning <span class="d-block">customer support</span></h6>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <section class="plan-faqs-section clearfix">
        <div class="container">
            <h6 class="fw-bold">Frequently Asks Questions</h6>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            What Is Leads?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem quia,
                                nihil ducimus saepe veritatis dolor dignissimos, ut pariatur accusantium
                                distinctio perspiciatis voluptatum labore maiores quo officia ratione minus,
                                suscipit iusto!</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            How Support Team will help me?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Providing details on the application process, required documents, and any specific
                                criteria will help applicants prepare.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            How Social media links will works?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt neque,
                                sequi temporibus perspiciatis unde beatae ipsa rem. Illum odio eligendi
                                nesciunt quae quidem, incidunt maiores, eaque assumenda molestias, non
                                suscipit.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            What is WhatsApp Integration?
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos excepturi ipsa
                                quaerat consequuntur odio vero commodi incidunt enim, odit laudantium fugiat
                                corrupti fuga deserunt beatae! Natus fuga est vel dolorum!</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                            What is Profile Boosting?
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita quasi,
                                aliquam numquam maxime nam ipsum non, est ipsam facilis modi, vero placeat
                                molestias illum. A, omnis ut. Eos, laborum nobis!</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            What is Advanced Profile Customization?
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus odio et
                                voluptatem quod sequi eveniet, doloribus temporibus! Iste cumque facere
                                dolor voluptatum tempora quo nemo itaque impedit vero, enim voluptas?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="plan-terms-section clearfix">
        <div class="container">
            <section>
                <h6 class="fw-bold">Terms & Conditions</h6>
                <ol>
                    <li>
                        <b>Introduction</b>
                        <br>
                        These Terms and Conditions ("Terms") govern the subscription to the Leads Package Service ("Service") provided by BookMyPlayer.com ("Company"). By subscribing to this Service, you agree to comply with and be bound by these Terms.
                    </li>

                    <li>
                        <b>Service Description</b>
                        <br>
                        The Service includes the provision of a fixed number of verified leads per year to Subscribers. The leads will consist of potential clients interested in enrolling in sports training programs.
                    </li>

                    <li>
                        <b>Subscription Plans</b>
                        <br>
                        Annual Subscription: The Service is offered on a yearly basis.<br>
                        Leads Package: Each subscription plan includes a fixed number of verified leads as specified at the time of subscription.
                    </li>

                    <li>
                        <b>Subscription Fee</b>
                        <br>
                        The subscription fee for the Service is outlined at the time of purchase.<br>
                        Payment must be made in full before the commencement of the Service.<br>
                        All fees are non-refundable, except as otherwise provided in these Terms.
                    </li>

                    <li>
                        <b>Verification of Leads</b>
                        <br>
                        The Company ensures that all leads provided are verified through a detailed verification process.<br>
                        Despite rigorous verification, the Company does not guarantee that every lead will result in a successful conversion.
                    </li>

                    <li>
                        <b>Delivery of Leads</b>
                        <br>
                        Leads will be delivered to the Subscriber on a monthly basis or as otherwise specified in the subscription plan.<br>
                        Delivery will be made via email or through a designated online portal.
                    </li>

                    <li>
                        <b>Use of Leads</b>
                        <br>
                        Subscribers are granted a non-exclusive, non-transferable right to use the leads solely for the purpose of marketing their sports training services.<br>
                        Subscribers must not resell, redistribute, or use the leads for any other purpose.
                    </li>

                    <li>
                        <b>Subscriber Obligations</b>
                        <br>
                        Subscribers must provide accurate and complete information during the subscription process.<br>
                        Subscribers are responsible for maintaining the confidentiality of the leads provided.<br>
                        Subscribers agree to use the leads in compliance with all applicable laws and regulations.
                    </li>

                    <li>
                        <b>Limitation of Liability</b>
                        <br>
                        The Company is not liable for any indirect, incidental, special, consequential, or punitive damages arising from the use of the Service.<br>
                        The total liability of the Company for any claim arising out of or relating to the Service is limited to the amount paid by the Subscriber for the subscription.
                    </li>

                    <li>
                        <b>Termination</b>
                        <br>
                        The Company reserves the right to terminate or suspend the Service at any time, with or without cause, and with or without notice.<br>
                        Subscribers may terminate their subscription by providing written notice to the Company. Termination will be effective at the end of the current subscription period.
                    </li>

                    <li>
                        <b>Amendments</b>
                        <br>
                        The Company reserves the right to amend these Terms at any time. Subscribers will be notified of any changes via email or through the Company's website.<br>
                        Continued use of the Service after any such amendments constitutes acceptance of the new Terms.
                    </li>

                    <li>
                        <b>Governing Law</b>
                        <br>
                        These Terms are governed by and construed in accordance with the laws of India. Any disputes arising out of or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts in Gurugram, Haryana, India.
                    </li>

                    <li>
                        <b>Contact Information</b>
                        <br>
                        For any questions or concerns regarding these Terms, please contact us at: care@bookmyplayer.com
                    </li>
                </ol>
            </section>
        </div>
    </section>

</main>


<main id="tournament_page" class="hidden">
    <section class="post-tournament-section clearfix">
        <div class="container mt-5">
            <div class="form-wrapper">
                <h3 class="text-center">Post Tournament</h3>
                <p class="text-center">Post your tournament on our platform.</p>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <input type="hidden" id="sport_name" name="sport" value="">
                        <select name="r" id="tournamentSport">
                            <option value="">Select Sport Type</option>
                            <option value="29">Archery</option>
                            <option value="12">Arts</option>
                            <option value="26">Athletics</option>
                            <option value="6">Badminton</option>
                            <option value="36">Baseball</option>
                            <option value="2">Basketball</option>
                            <option value="20">Billiard</option>
                            <option value="18">Boxing</option>
                            <option value="3">Cricket</option>
                            <option value="38">Carrom</option>
                            <option value="13">Chess</option>
                            <option value="24">Fencing</option>
                            <option value="1">Football</option>
                            <option value="7">Golf</option>
                            <option value="31">Gym</option>
                            <option value="11">Gymnastics</option>
                            <option value="39">Handball</option>
                            <option value="15">Hockey</option>
                            <option value="10">Kabaddi</option>
                            <option value="40">Kalaripayayttu</option>
                            <option value="4">Karate</option>
                            <option value="22">Khokho</option>
                            <option value="19">Motorsports</option>
                            <option value="9">MMA</option>
                            <option value="34">Personal Trainer</option>
                            <option value="30">Rugby</option>
                            <option value="28">Taekwondo</option>
                            <option value="21">Table Tennis</option>
                            <option value="16">Tennis</option>
                            <option value="25">Skating</option>
                            <option value="37">Snooker</option>
                            <option value="8">Shooting</option>
                            <option value="35">Silambam</option>
                            <option value="23">Squash</option>
                            <option value="5">Swimming</option>
                            <option value="27">Volleyball</option>
                            <option value="17">Wrestling</option>
                            <option value="32">Yoga</option>

                        </select>
                    </div>
                    <div class="col-md-6 col-lg-4 location_city">
                        <input type="hidden" name="loc_id_input" id="loc_id_input">
                        <input type="text" placeholder="Please Enter Your City" name="city" class="form-control tour_city" id="locationInput" value="" autocomplete="off">
                        <div id="location-name" class="location-list" style="width:95%;">
                            <!-- Dynamically filled based on input -->
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="text" name="state" id="tournament_state" placeholder="State" disabled>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="text" name="pincode" id="tournament_zipcode" placeholder="Zipcode">
                    </div>
                </div>
                <div class="select-tournament-type" id="main_container">
                    <h6>Select Tournament Type</h6>
                    <div class="row input-row">
                        <div class="col-md-6 col-lg-4">
                            <select name="" class="tournament-type select_type">
                                <option value="">Select Tournament</option>
                                <option value="Junior Tournament">Junior Tournament</option>
                                <option value="Senior Tournament">Senior Tournament</option>
                                <option value="Men Tournament">Men Tournament</option>
                                <option value="Women Tournament">Women Tournament</option>
                                <option value="Open Tournament">Open Tournament</option>
                                <option value="Boys Tournament">Boys Tournament</option>
                                <option value="Girls Tournament">Girls Tournament</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4 custom-tournament-container" style="display:none;">
                            <input type="text" class="custom-tournament" placeholder="Enter Other Tournament Type" />
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <input type="text" class="age_group" placeholder="Enter Age Group">
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex align-items-center justify-content-between">
                            Number of Players
                            <div class="quantity-block">
                                <button class="quantity-arrow-minus-01"><i class="fa-solid fa-minus"></i></button>
                                <input class="quantity-num-01" type="number" value="1" />
                                <button class="quantity-arrow-plus-01"><i class="fa-solid fa-plus"></i></button>
                                <button class="quantity-arrow-minus-01 delete_row" style="margin-left: 1rem; visibility:hidden">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary add-more-btn">Add More</button>
                    </div>
                </div>

                <div class="select-rule-type mt-3" id="rule_box1">
                    <h6>Add Rules</h6>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
                            <input type="text" class="tournament_rules" placeholder="Enter Your Rules" />
                            <button class="quantity-arrow-minus-01 delete_row2" style="margin-left: 1rem; visibility:hidden;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary add-rule-btn">Add More</button>
                    </div>
                </div>

                <div class="select-rule-type mt-3" id="advantage_box">
                    <h6>Add Advantages</h6>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
                            <input type="text" class="tournament_advantage" placeholder="Enter Your Advantages" />
                            <button class="quantity-arrow-minus-01 delete_row3" style="margin-left: 1rem; visibility:hidden;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary add-advantage-btn">Add More</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <input type="text" name="venue" id="" placeholder="Enter Venue">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="datetime-local" id="start_date" name="event_starts_on" class="form-control tour_date" placeholder="Tournament Start Date" class="input-calendar">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="datetime-local" id="end_date" name="event_ends_on" class="form-control tour_date" placeholder="Tournament End Date" class="input-calendar">
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-center justify-content-between">No. of Teams
                        participating
                        <div class="quantity-block">
                            <button class="quantity-arrow-minus-04"> <i class="fa-solid fa-minus"></i> </button>
                            <input class="quantity-num-04" name="no_of_team" id="total_teams" type="number" value="1" />
                            <button class="quantity-arrow-plus-04"> <i class="fa-solid fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="number" name="entry_fee" class="number_type" placeholder="Entry Fee">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="number" name="winning_amount" class="number_type" placeholder="Wining Amount">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <input type="text" name="name" id="tour_name" placeholder="Your Tournament Name">
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <textarea name="intro" id=""
                            placeholder="Your tournament description. (Anything you want to add more about your Tournament)"></textarea>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <textarea name="pathway" id=""
                            placeholder="Enter Pathway"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6"><input type="text" name="sponsored_name" id="" placeholder="Sponsored by"></div>
                    <div class="col-md-6 col-lg-6"><input type="text" name="organised_by" id="" placeholder="Organized by"></div>
                    <div class="col-md-6 col-lg-6"><input type="text" name="phone" id="tour_phone" placeholder="Phone Number"></div>
                    <div class="col-md-6 col-lg-6"><input type="text" name="email" id="tour_email" placeholder="Email Address"></div>
                    <div class="col-md-6 col-lg-6">
                        <div class="input-file">
                            <input type="file" name="file" id="file" class="file" style="display: none;" accept="image/*" multiple>
                            <div class="upload-poster">
                                <input type="text" name="file[]" id="file-name" class="file-name" readonly="readonly" placeholder="Upload tournament banners">
                                <input type="button" class="btn-upload" value="Upload">
                            </div>
                        </div>


                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a href="https://api.whatsapp.com/send?phone=918826450360" target="_blank" class="d-flex align-items-center gap-1" style="cursor:pointer">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-whatsapp.svg" alt="Whatsapp" loading="lazy">
                                <span>Contact Support</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <input type="submit" value="Add Tournament" class="btn btn-secondary btn-lg" id="add_tournament">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
<main id="view_page" class="hidden">
    <section class="view_tournament">
        <div class="accordion" id="tournamentAccordion3">
            <!-- Dynamically generated accordion content will go here -->
        </div>
    </section>
</main>


<main id="notification_page" class="hidden">

    <section class="support-heading-section clearfix">
        <div class="container mt-5 mb-3">
            <h5>Raised Tickets</h5>
        </div>
    </section>

    <section class="ticket_display">
    </section>


    <section class="find-section clearfix">
        <div class="container text-center">
            <h3>Find Help to Resolve your Issue</h3>
            <div class="search mt-3 new_search">
                <input type="search" class="form-control" placeholder="Search players, Coaches etc..">
                <button type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>

    <section class="issue-tabs-section clearfix">
        <div class="container">
            <div class="tabs_wrapper">
                <ul class="tabs">
                    <li class="active" rel="tab1">Account <i class="fa-solid fa-chevron-right"></i></li>
                    <li rel="tab2">Payment <i class="fa-solid fa-chevron-right"></i></li>
                    <li rel="tab3">Review Related <i class="fa-solid fa-chevron-right"></i></li>
                    <li rel="tab5">Coach <i class="fa-solid fa-chevron-right"></i></li>
                    <li rel="tab6">Academy <i class="fa-solid fa-chevron-right"></i></li>
                    <li rel="tab7">Players <i class="fa-solid fa-chevron-right"></i></li>
                </ul>
                <div class="tab_container">
                    <h3 class="d_active tab_drawer_heading" rel="tab1">Account <i class="fa-solid fa-chevron-down"></i>
                    </h3>
                    <div id="tab1" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush01">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading01">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse01" aria-expanded="true" aria-controls="flush-collapse01">
                                        Is my account information secure on BookMyPlayer?
                                    </button>
                                </h2>
                                <div id="flush-collapse01" class="accordion-collapse collapse show" aria-labelledby="flush-heading01" data-bs-parent="#accordionFlush01">
                                    <div class="accordion-body">
                                        <p>Yes, we prioritize your privacy and security. Your account information is protected with robust encryption and is never shared without your consent.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading02">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse02" aria-expanded="false" aria-controls="flush-collapse02">
                                        Can I update my account details after registration?
                                    </button>
                                </h2>
                                <div id="flush-collapse02" class="accordion-collapse collapse" aria-labelledby="flush-heading02" data-bs-parent="#accordionFlush01">
                                    <div class="accordion-body">
                                        <p>Absolutely! Log in to your account and navigate to the dashboard section to update your academy's information.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading05">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse05" aria-expanded="false" aria-controls="flush-collapse05">
                                        Can I access my account on mobile devices?
                                    </button>
                                </h2>
                                <div id="flush-collapse05" class="accordion-collapse collapse" aria-labelledby="flush-heading05" data-bs-parent="#accordionFlush01">
                                    <div class="accordion-body">
                                        <p>Yes, BookMyPlayer is mobile-friendly. You can access your account on any device with an internet connection.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="tab_drawer_heading" rel="tab2">Payment <i class="fa-solid fa-chevron-down"></i></h3>
                    <div id="tab2" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush02">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading201">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse201" aria-expanded="true" aria-controls="flush-collapse201">
                                        How can I pay for premium services on BookMyPlayer?
                                    </button>
                                </h2>
                                <div id="flush-collapse201" class="accordion-collapse collapse show" aria-labelledby="flush-heading201" data-bs-parent="#accordionFlush02">
                                    <div class="accordion-body">
                                        <p> Payments for premium services can be made securely through our online payment gateway. Details will be shared when you opt for a service.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading202">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse202" aria-expanded="false" aria-controls="flush-collapse202">
                                        Do I need to pay for tournament promotions?
                                    </button>
                                </h2>
                                <div id="flush-collapse202" class="accordion-collapse collapse" aria-labelledby="flush-heading202" data-bs-parent="#accordionFlush02">
                                    <div class="accordion-body">
                                        <p>Basic tournament posting is free. However, for advanced promotional features like banners or targeted marketing, there may be nominal charges.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading203">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse203" aria-expanded="false" aria-controls="flush-collapse203">
                                        What payment methods are accepted?
                                    </button>
                                </h2>
                                <div id="flush-collapse203" class="accordion-collapse collapse" aria-labelledby="flush-heading203" data-bs-parent="#accordionFlush02">
                                    <div class="accordion-body">
                                        <p> We accept various payment methods, including credit cards, debit cards, UPI, net banking, and digital wallets for your convenience.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading204">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse204" aria-expanded="false" aria-controls="flush-collapse204">
                                        Will I receive an invoice for payments made?
                                    </button>
                                </h2>
                                <div id="flush-collapse204" class="accordion-collapse collapse" aria-labelledby="flush-heading204" data-bs-parent="#accordionFlush02">
                                    <div class="accordion-body">
                                        <p>Yes, an invoice will be sent to your registered email after every successful transaction.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="tab_drawer_heading" rel="tab3">Review Related <i class="fa-solid fa-chevron-down"></i>
                    </h3>
                    <div id="tab3" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush03">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading301">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse301" aria-expanded="true" aria-controls="flush-collapse301">
                                        How can I leave a review for a sports academy on BookMyPlayer?

                                    </button>
                                </h2>
                                <div id="flush-collapse301" class="accordion-collapse collapse show" aria-labelledby="flush-heading301" data-bs-parent="#accordionFlush03">
                                    <div class="accordion-body">
                                        <p>After attending an event or program at an academy, you can leave a review by logging into your account, searching for the academy, and submitting your feedback on the review section.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading302">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse302" aria-expanded="false" aria-controls="flush-collapse302">
                                        Can I leave a review for a specific coach at an academy?
                                    </button>
                                </h2>
                                <div id="flush-collapse302" class="accordion-collapse collapse" aria-labelledby="flush-heading302" data-bs-parent="#accordionFlush03">
                                    <div class="accordion-body">
                                        <p>Yes, you can leave reviews for individual coaches by visiting their profile page on the academy’s listing and sharing your experience with them.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading303">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse303" aria-expanded="false" aria-controls="flush-collapse303">
                                        How do reviews help sports academies?

                                    </button>
                                </h2>
                                <div id="flush-collapse303" class="accordion-collapse collapse" aria-labelledby="flush-heading303" data-bs-parent="#accordionFlush03">
                                    <div class="accordion-body">
                                        <p>Reviews help academies build trust with prospective players and parents by showcasing their strengths and areas for improvement. Positive reviews also attract more clients and help grow the academy’s reputation.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading304">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse304" aria-expanded="false" aria-controls="flush-collapse304">
                                        Can I report a false or inappropriate review?

                                    </button>
                                </h2>
                                <div id="flush-collapse304" class="accordion-collapse collapse" aria-labelledby="flush-heading304" data-bs-parent="#accordionFlush03">
                                    <div class="accordion-body">
                                        <p> Yes, if you find a review that violates our guidelines, you can report it directly on the platform, and our team will investigate and take appropriate action.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading305">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse305" aria-expanded="false" aria-controls="flush-collapse305">
                                        How can I get more positive reviews?

                                    </button>
                                </h2>
                                <div id="flush-collapse305" class="accordion-collapse collapse" aria-labelledby="flush-heading305" data-bs-parent="#accordionFlush03">
                                    <div class="accordion-body">
                                        <p>As a coach, you can get positive reviews by consistently showcasing professionalism, skill, and a good attitude.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <h3 class="tab_drawer_heading" rel="tab5">Coach <i class="fa-solid fa-chevron-down"></i></h3>
                    <div id="tab5" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush05">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading501">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse501" aria-expanded="true" aria-controls="flush-collapse501">
                                        Can coaches list their profiles on BookMyPlayer?

                                    </button>
                                </h2>
                                <div id="flush-collapse501" class="accordion-collapse collapse show" aria-labelledby="flush-heading501" data-bs-parent="#accordionFlush05">
                                    <div class="accordion-body">
                                        <p>Yes, certified coaches can create and list their profiles on BookMyPlayer, making it easier for academies to find and hire them for training sessions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading502">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse502" aria-expanded="false" aria-controls="flush-collapse502">
                                        How do I update my coach profile on BookMyPlayer?
                                    </button>
                                </h2>
                                <div id="flush-collapse502" class="accordion-collapse collapse" aria-labelledby="flush-heading502" data-bs-parent="#accordionFlush05">
                                    <div class="accordion-body">
                                        <p>Coaches can log in to their profile and update their information, certifications, or availability directly through the platform’s account settings.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading503">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse503" aria-expanded="false" aria-controls="flush-collapse503">
                                        What types of coaches can I find on BookMyPlayer?
                                    </button>
                                </h2>
                                <div id="flush-collapse503" class="accordion-collapse collapse" aria-labelledby="flush-heading503" data-bs-parent="#accordionFlush05">
                                    <div class="accordion-body">
                                        <p>You can find coaches for a wide variety of sports including cricket, football, badminton, tennis and many more. All coaches are highly skilled in their respective fields.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading504">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse504" aria-expanded="false" aria-controls="flush-collapse504">
                                        How do I know if a coach is a good fit for my academy?
                                    </button>
                                </h2>
                                <div id="flush-collapse504" class="accordion-collapse collapse" aria-labelledby="flush-heading504" data-bs-parent="#accordionFlush05">
                                    <div class="accordion-body">
                                        <p>Review their certifications, experience, and client reviews on BookMyPlayer. You can also contact the coach directly to discuss their training approach and availability.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="tab_drawer_heading" rel="tab6">Academy <i class="fa-solid fa-chevron-down"></i></h3>
                    <div id="tab6" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush06">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading601">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse601" aria-expanded="true" aria-controls="flush-collapse601">
                                        What types of sports academies are listed on BookMyPlayer?
                                    </button>
                                </h2>
                                <div id="flush-collapse601" class="accordion-collapse collapse show" aria-labelledby="flush-heading601" data-bs-parent="#accordionFlush06">
                                    <div class="accordion-body">
                                        <p>BookMyPlayer features academies offering training in sports like cricket, football, basketball, tennis, badminton, swimming, martial arts, and more. You can filter academies based on your preferred sport and location.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading602">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse602" aria-expanded="false" aria-controls="flush-collapse602">
                                        How do I find a sports academy near me?
                                    </button>
                                </h2>
                                <div id="flush-collapse602" class="accordion-collapse collapse" aria-labelledby="flush-heading602" data-bs-parent="#accordionFlush06">
                                    <div class="accordion-body">
                                        <p>You can search for academies on BookMyPlayer by entering your location or using the search filters. The platform allows you to view academies within your area and compare their offerings.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading603">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse603" aria-expanded="false" aria-controls="flush-collapse603">
                                        Can I book a free trial?
                                    </button>
                                </h2>
                                <div id="flush-collapse603" class="accordion-collapse collapse" aria-labelledby="flush-heading603" data-bs-parent="#accordionFlush06">
                                    <div class="accordion-body">
                                        <p>Yes, many academies offer free trial sessions. Look for the "Free Trial Available" badge on their profile or contact the academy directly to enquire.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading604">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse604" aria-expanded="false" aria-controls="flush-collapse604">
                                        Are there options for group and individual coaching?
                                    </button>
                                </h2>
                                <div id="flush-collapse604" class="accordion-collapse collapse" aria-labelledby="flush-heading604" data-bs-parent="#accordionFlush06">
                                    <div class="accordion-body">
                                        <p>Yes, most academies offer both group and individual coaching sessions. Details about session types are listed on the academy’s profile.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading605">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse605" aria-expanded="false" aria-controls="flush-collapse605">
                                        What is the refund policy if I cancel my booking?
                                    </button>
                                </h2>
                                <div id="flush-collapse605" class="accordion-collapse collapse" aria-labelledby="flush-heading605" data-bs-parent="#accordionFlush06">
                                    <div class="accordion-body">
                                        <p>Refund policies vary by academy. You can find this information in the academy's terms and conditions or inquire directly with them.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="tab_drawer_heading" rel="tab7">Players <i class="fa-solid fa-chevron-down"></i></h3>
                    <div id="tab7" class="tab_content">
                        <div class="accordion accordion-flush" id="accordionFlush07">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading701">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse701" aria-expanded="true" aria-controls="flush-collapse701">
                                        How can I register as a player?
                                    </button>
                                </h2>
                                <div id="flush-collapse701" class="accordion-collapse collapse show" aria-labelledby="flush-heading701" data-bs-parent="#accordionFlush07">
                                    <div class="accordion-body">
                                        <p>You can register as a player by signing up on the platform from this link: https://www.bookmyplayer.com/register-as-a-player </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading702">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse702" aria-expanded="false" aria-controls="flush-collapse702">
                                        What are the benefits of registering as a player?
                                    </button>
                                </h2>
                                <div id="flush-collapse702" class="accordion-collapse collapse" aria-labelledby="flush-heading702" data-bs-parent="#accordionFlush07">
                                    <div class="accordion-body">
                                        <p>Players can showcase their skills, find sports opportunities, join tournaments, connect with academies and recruiters, and grow their careers.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading703">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse703" aria-expanded="false" aria-controls="flush-collapse703">
                                        How do I create a professional sports profile?
                                    </button>
                                </h2>
                                <div id="flush-collapse703" class="accordion-collapse collapse" aria-labelledby="flush-heading703" data-bs-parent="#accordionFlush07">
                                    <div class="accordion-body">
                                        <p>Your profile can be built by adding personal details, uploading achievements, sharing videos or images of your performances, and updating your current stats.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading704">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse704" aria-expanded="false" aria-controls="flush-collapse704">
                                        How can I get noticed by recruiters?
                                    </button>
                                </h2>
                                <div id="flush-collapse704" class="accordion-collapse collapse" aria-labelledby="flush-heading704" data-bs-parent="#accordionFlush07">
                                    <div class="accordion-body">
                                        <p>Keeping your profile updated with recent achievements and sharing quality videos or stats can help you attract recruiters and coaches.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .tab_container -->
            </div>
        </div>
    </section>

    <section class="contact-support-section clearfix">
        <div class="container">
            <section>
                <div class="content">
                    <h5>Still have questions? Our awesome Customer Support Team is ready to assist you.</h5>
                </div>
                <button class="btn btn-secondary" id="openModalBtn">Create Ticket</button>
            </section>
        </div>
    </section>

    <div class="modal-bg" id="modalBg" style="display: none;">
        <div class="modal-box">
            <span class="close-btn-support" id="closeModalBtn">&times;</span>
            <div>
                <h5 class="text-center">Submit a Request</h5>
                <p class="text-center">Our awesome Customer Support Team is ready to assist you. Fill the form below &
                    get connected.</p>
                <form action="{{ route('admin.create.ticket') }}" method="post" id="" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3">
                        <input type="text" name="name" class="form-control your-name" id="" placeholder="Enter your Full name" value="{{$data['d']->name ? $data['d']->name : '-' }}">
                    </div>
                    <div class="mt-3">
                        <input type="email" name="email" class="form-control your-email" id="" placeholder="Enter your Email" value=" {{$data['d']->email ? $data['d']->email : '-' }}">
                    </div>
                    <div class="mt-3">
                        <input type="tel" name="phone" class="form-control your-phone" id="" placeholder="Enter your Phone Number" value="{{ $data['d']->phone ? $data['d']->phone : '-' }}">
                    </div>
                    <div class="mt-3">
                        <textarea name="description" id="" class="form-control" placeholder="Describe your Issue here.."></textarea>
                    </div>

                    <div class="mt-3" id="fileNameDisplay" style="display: none;">
                        <p class="text-center"><strong>Selected File:</strong> <span id="fileName"></span></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="custom-file-upload add-new-support">
                            <label class="custom-label supportLabel">
                                <span class="title">
                                    Upload Attachments
                                </span>
                                <input class="custom-file-input" id="FileInput" name="attachment" type="file" accept="image/*,application/pdf" />
                            </label>
                        </div>

                        <input type="submit" class="btn btn-secondary btn-lg" value="Submit Now">
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>

<div id="customConfirmBox2" class="confirm-box" style="display: none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/delete.gif" class="img-fluid" alt=""></figure>
            <h6>Are you sure you want to delete this item??</h6>
        </div>
        <div class="confirm-footer">
            <button id="confirmOk2" class="btn btn-outline-primary">OK</button>
            <button id="confirmCancel2" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<div id="customConfirmBox3" class="confirm-box" style="display: none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/delete.gif" class="img-fluid" alt=""></figure>
            <h6>Are you sure you want to delete this item??</h6>
        </div>
        <div class="confirm-footer">
            <button id="confirmOk3" class="btn btn-outline-primary">OK</button>
            <button id="confirmCancel3" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<div id="customConfirmBox4" class="confirm-box" style="display: none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/delete.gif" class="img-fluid" alt=""></figure>
            <h6>Are you sure you want to delete this item??</h6>
        </div>
        <div class="confirm-footer">
            <button id="confirmOk4" class="btn btn-outline-primary">OK</button>
            <button id="confirmCancel4" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<div id="city_error" class="confirm-box" style="display: none;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
            <h6>Please Select Your City</h6>
        </div>
        <div class="confirm-footer">
            <button id="city_back" class="btn btn-secondary">Go Back</button>
        </div>
    </div>
</div>

</div>
<!-- /CONTENT SECTION -->


<div class="confirm-box feedback_modal" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content2">
        <div class="confirm-body">
            <h6 style="font-size: 24px;">Feedback for Lead Id: <span class="lead_id2"></span> (<span class="lead_name"></span>)</h6>

            <div class="feedback_error_box">
                <span class="feedback_error" style="color:red;"></span>
            </div>

            <textarea class="form-control feedback_area" placeholder="Please Enter Your Feedback"></textarea>
        </div>
        <div class="confirm-footer d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <button class="btn feedback-submit">Submit</button>
            <button class="get_back btn feedback-submit-close">Close</button>
        </div>
    </div>
</div>

<div class="confirm-box feedback_modal2" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content2">
        <div class="confirm-body">
            <h6 style="font-size: 24px;">Feedback for Lead Id: <span class="lead_id3"></span> (<span class="lead_name2"></span>)</h6>

            <div style="text-align:left">
                <p class="feedback_view"></p>
            </div>
        </div>
        <div class="confirm-footer">
            <button class="get_back btn feedback-submit-close">Close</button>
        </div>
    </div>
</div>

@endsection