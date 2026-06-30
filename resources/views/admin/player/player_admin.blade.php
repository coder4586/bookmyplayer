@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/pricing.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/coach_admin_v7.css') }}" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/admin/player_admin_v6.js') }}" defer></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>
@endpush
@extends('layouts.admin_app')
@section('content')



@if(Session::has('success_update_player'))
<div class="confirm-box" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt=""></figure>
            <h6> {{ Session::get('success_update_player') }}</h6>
        </div>
        <div class="confirm-footer">
            <button class="get_back btn btn-secondary">Go Back</button>
        </div>
    </div>
</div>
@endif
@if(Session::has('error_update_player'))
<div class="confirm-box" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
            <h6> {{ Session::get('error_update_player') }}</h6>
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
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt=""></figure>
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
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt=""></figure>
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

@if(Session::has('success_message_create_ticket'))
<div class="confirm-box" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt=""></figure>
            <h6> {{ Session::get('success_message_create_ticket') }}</h6>
        </div>
        <div class="confirm-footer">
            <button class="get_back btn btn-secondary">OK</button>
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
<!-- CONTENT SECTION -->
<section class="dashboard-menu-section clearfix">
    <input type="hidden" id="hiddenSportId" data-sport_id="" />

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
                <div class="page-menu active-page">
                    <div class="profile-progress">
                        <div class="progress-bar"><span style="width: {{$data['overall_percent']}}%;"></span></div>
                        <div class="progress-txt">{{$data['overall_percent']}}%</div>
                    </div>
                    <div class="top_menu" id="profile_box"><span class="icon-icon-02"></span>Edit Profile</div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="lead_count_box">
                        <span class="leads_count">0</span>
                    </div>
                    <div class="top_menu" id="leads_box"><span class="icon-icon-03"></span>Leads</div>
                </div>
            </div>
            @if(!$MOBILE)
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="boost_box"><span class="icon-icon-04"></span>Boost</div>
                </div>
            </div>
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="performance_box"><span class="icon-icon-05"></span>Performance</div>
                </div>
            </div>
            @endif
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="lead_count_box">
                        <span class="leads_count">0</span>
                    </div>
                    <div class="top_menu" id="notification_box"><span class="icon-icon-06"></span>Contact Support</div>
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
                    <figure>
                        <img src="{{  $data['logo'] }}" alt="logo">
                    </figure>

                    <article>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 id="top-left-card-name">{{$data['d']->name ? $data['d']->name : '-'}}</h6>
                            <h6><span>{{$data['sport']}} Player</span></h6>
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
                            <a href="{{ $data['d']->url }}" target="_blank"><button class="btn btn-success">View Profile</button></a>
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
            @if(!$MOBILE)
            <div class="col-md-6">
                <div class="upgrade-box">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-premium.svg" alt="" width="80" height="80"></figure>

                    @if($data['premium_pkg']['purchase_date'] && $data['premium_pkg']['expiration_date'])
                    <h5>Premium Account</h5>
                    <p>You are a VIP member with premium features</p>
                    <div class="premium-info">
                        <p><strong>Purchased on:</strong> {{ $data['premium_pkg']['purchase_date'] }}</p>
                        <p><strong>Expires on:</strong> {{ $data['premium_pkg']['expiration_date'] }}</p>
                    </div>
                    @else
                    <h5>Upgrade to Premium</h5>
                    <p>Become a VIP member to get more features</p>
                    <div class="upgradebutton" id="upgrade_box">
                        <button class="btn btn-secondary btn-lg"><i class="fa-solid fa-crown"></i> Upgrade Now</button>
                    </div>
                    @endif
                </div>
            </div>
            @endif
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
                        <figure><img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/icon-03.svg" class="img-fluid" loading="lazy" alt=""></figure>
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
                <h6>Reviews & Ratings (0)</h6>
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
                        <div class="col-sm-8"><input type="text" class="form-control" id="linkInputDashboard" value="https://www.bookmyplayer.com/player/add-review/{{$data['d']->id}}"></div>
                        <div class="col-sm-4"><button type="button" class="btn btn-secondary btn-lg" id="copy_link_dashboard">Copy Link</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="reviews-box">
                <div class="text-end mt-3 mb-3">
                    <a href="#" class="btn btn-outline-primary">See all Reviews</a>
                </div>
            </div> -->
        </div>
    </section>
</main>

<main id="profile_page" class="hidden">
    <section class="complete-profile-section clearfix mt-3">
        <div class="container">
            <section class="notifications_box" style="display: flex; justify-content: space-between; align-items:start; gap:1rem; text-align:start; flex-wrap:nowrap;">
                <h5>Complete your profile to 80% or more to Get more Searches.</h5>
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
                            <div class="overlay">90%</div>
                        </div>
                    </h2>
                    <form action="{{ route('player.update') }}" method="post" id="player_update" autocomplete="off">
                        @csrf
                        <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
                        <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionadd01">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3">
                                    <div class="col-lg-12 col-md-6">
                                        <label for="profile-heading" class="form-label">Add Summary Heading</label>
                                        <input type="text" name="heighlight" class="form-control your-name" id="profile-heading" value="{{$data['d']->heighlight ? $data['d']->heighlight : ''}}">
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
                                    <div class="col-lg-8 col-md-4">
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
                                    <div class="col-lg-12 position_margin">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="" class="form-label">About Yourself</label>
                                            <label for="" class="form-label"><span>0 - 300 Words</span></label>
                                        </div>
                                        <textarea name="about" id="profile-about" class="form-control" style="display: none;">{{$data['d']->about ? $data['d']->about : ''}}</textarea>
                                        <div id="editor" class="mb-4"></div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" name="position" placeholder="Please Enter Your Position" class="form-control your-name" id="position" value="{{$data['d']->position ? $data['d']->position : ''}}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="" class="form-label">Weight</label>
                                        <input type="text" name="weight" placeholder="Please Enter Your Weight" class="form-control your-name" id="" value="{{$data['d']->weight ? $data['d']->weight : ''}}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="" class="form-label">Birth Date</label>
                                        <input type="text" name="dob" placeholder="Please Enter Your Birth date" class="form-control your-name" id="player_dob" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{$data['d']->dob ? $data['d']->dob : ''}}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="height_ft" class="form-label">Height (ft)</label>
                                        <input type="number" name="height_ft" placeholder="Feet" class="form-control" id="height_ft" value="{{ $data['d']->height_ft ? $data['d']->height_ft : '' }}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="height_inch" class="form-label">Height (inch)</label>
                                        <input type="number" name="height_inch" placeholder="Inches" class="form-control" id="height_inch" value="{{ $data['d']->height_inch ? $data['d']->height_inch : '' }}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="" class="form-label">Instagram Id</label>
                                        <input type="text" name="instagram" placeholder="Please Enter Your Instagram Id" class="form-control your-name" id="" value="{{$data['d']->instagram ? $data['d']->instagram : ''}}">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label for="" class="form-label">Facebook Id</label>
                                        <input type="text" name="facebook" placeholder="Please Enter Your Facebook Id" class="form-control your-name" id="" value="{{$data['d']->facebook ? $data['d']->facebook : ''}}">
                                    </div>
                                    <input type="hidden" name="height" id="height" value="{{ $data['d']->height ? $data['d']->height : '' }}">
                                    <div class="col-lg-12 text-end">
                                        <button type="button" id="btn-save-personal-info" class="btn btn-secondary">Save
                                            &
                                            Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="add-experience-section clearfix">
        <form action="{{ route('player.update') }}" method="post" id="player_experience" autocomplete="off">
            @csrf
            <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
            <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">

            <div class="container">
                <div class="accordion add-accordion" id="accordionadd02">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Add Experience
                            </button>
                            <div class="radialProgressBar progress-{{$data['completion_percent']['experience']}}">
                                <div class="overlay">{{$data['completion_percent']['experience']}}%</div>
                            </div>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionadd02">
                            <div class="accordion-body">
                                @foreach ($data['experience'] as $index => $experience)
                                @php
                                $parts = explode(';', $experience);
                                $name = isset($parts[0]) ? $parts[0] : '';
                                $date = isset($parts[1]) ? $parts[1] : '';
                                $description = isset($parts[2]) ? $parts[2] : '';
                                @endphp
                                <div class="row g-2 g-md-3 experience-entry" id="experience_{{ $index + 1 }}">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control" value="{{ $name }}">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="date" class="form-control dateofbirth" id="exp_date_{{ $index + 1 }}" value="{{ $date }}">
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <input type="text" class="form-control" value="{{ $description }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="remove-experience" data-experience-id="experience_{{ $index + 1 }}">
                                            <i class="fa-solid fa-minus"></i> Remove Experience
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="row g-2 g-md-3" id="experience-container">
                                    <!-- Dynamic experience fields will be appended here -->
                                </div>
                                <input type="hidden" id="experience" name="experience" value="{{$data['d']->experience}}">
                                <div class="row g-2 g-md-3 mt-3">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control white-bg" id="played_for" value="" placeholder="Played for">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="date" class="form-control white-bg dateofbirth" id="exp_date" value="" placeholder="Date">
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <input type="text" class="form-control white-bg" id="experience_desc" value="" placeholder="Describe your Experience..">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="add-experience"><i class="fa-solid fa-plus"></i> Add Experience
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="button" class="btn btn-secondary" id="exp_save_btn">Save &
                                        Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="add-education-section clearfix">
        <form action="{{ route('player.update') }}" method="post" id="player_education" autocomplete="off">
            @csrf
            <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
            <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd03">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNine">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                Add Education
                            </button>
                            <div class="radialProgressBar progress-{{$data['completion_percent']['education']}}">
                                <div class="overlay">{{$data['completion_percent']['education']}}%</div>
                            </div>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionadd03">
                            <div class="accordion-body">
                                @foreach ($data['education'] as $index => $education)
                                @php
                                $parts = explode(';', $education);
                                $degree = isset($parts[0]) ? $parts[0] : '';
                                $from = isset($parts[1]) ? $parts[1] : '';
                                @endphp
                                <div class="row g-2 g-md-3 education-entry" id="education_{{ $index + 1 }}">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control" value="{{ $degree }}">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control" value="{{ $from }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="remove-education" data-education-id="education_{{ $index + 1 }}"><i class="fa-solid fa-minus"></i> Remove Education</div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="row g-2 g-md-3 education-container">
                                    <!-- Dynamic education fields will be appended here -->
                                </div>
                                <div class="row g-2 g-md-3 mt-3">
                                    <input type="hidden" name="education" id="education" value="{{$data['d']->education}}">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control white-bg text-capitalize" id="education_degree" value="" placeholder="Education Degree eg (BCA (2015-2019)">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control white-bg text-capitalize" id="education_from" value="" placeholder="From Which Institute?">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="add-education"><i class="fa-solid fa-plus"></i> Add Education</div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="button" class="btn btn-secondary" id="edu_save_btn">Save &
                                        Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="skills-section clearfix">
        <form action="{{ route('player.update') }}" method="post" id="player_skills" autocomplete="off">
            @csrf
            <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
            <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd04">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEleven">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                Add Skills
                            </button>
                            <div class="radialProgressBar progress-{{$data['completion_percent']['skills']}}">
                                <div class="overlay">{{$data['completion_percent']['skills']}}%</div>
                            </div>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionadd04">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3 skills-container">
                                    @foreach ($data['skills'] as $index => $skill)
                                    <div class="col-lg-4 col-md-6 skill-item" id="skill_{{ $index + 1 }}">
                                        <input type="text" class="form-control" value="{{ $skill }}">
                                        <div class="remove" data-skill-id="skill_{{ $index + 1 }}">
                                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/remove.svg" alt="Remove Skill">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="row g-2 g-md-3 mt-3">
                                    <input type="hidden" name="skill" id="skill_hidden" value="{{ $data['d']->skill }}">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control white-bg" id="skill_input" value="" placeholder="Enter Skill">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="add-skill"><i class="fa-solid fa-plus"></i> Add Skills</div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="button" class="btn btn-secondary" id="skills_save_btn">Save &
                                        Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="awards-section clearfix">
        <form action="{{ route('player.update') }}" method="post" id="player_awards" autocomplete="off">
            <input hidden type="text" name="loc_id" id="loc_id_input" value="{{$data['d']->loc_id}}">
            <input hidden type="text" name="name" id="hidden_name_input" value="{{$data['d']->name}}">
            @csrf
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd05">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwelve">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                Awards
                            </button>
                            <div class="radialProgressBar progress-{{$data['completion_percent']['awards']}}">
                                <div class="overlay">{{$data['completion_percent']['awards']}}%</div>
                            </div>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#accordionadd05">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3 awards-container">
                                    @foreach ($data['awards'] as $index => $award)
                                    <div class="col-lg-4 col-md-6 award-item" id="award_{{ $index + 1 }}">
                                        <input type="text" class="form-control" value="{{ $award }}">
                                        <div class="remove" data-award-id="award_{{ $index + 1 }}">
                                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/remove.svg" alt="Remove Award">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="row g-2 g-md-3 mt-3">
                                    <input type="hidden" name="awards" id="awards_hidden" value="{{ $data['d']->awards }}">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control white-bg" id="award_input" value="" placeholder="Enter Award">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="add-award"><i class="fa-solid fa-plus"></i> Add Award</div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="button" class="btn btn-secondary" id="awards_save_btn">Save &
                                        Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                                <form action="{{ route('player.delete.photos.videos') }}" method="post" id="delete_form" autocomplete="off">
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
                                    <form action="{{ route('player.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="img_submit" autocomplete="off">
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

                            <form action="{{ route('player.delete.photos.videos') }}" method="post" id="delete_form2" autocomplete="off">
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
                                <form action="{{ route('player.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="video_submit" autocomplete="off">
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


</main>


<main id="leads_page" class="hidden">

    <section class="total-leads-section clearfix">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Total Leads (0)</h4>
                <aside class="filter-sortby">
                    <input type="text" name="" id="" class="form-control filter" placeholder="Filter">
                    <select name="" id="" class="form-control sortby">
                        <option value="">Sort by</option>
                    </select>
                </aside>
            </div>
            <div class="row mt-3" id="coach-admin-leads">
            </div>
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


<main id="performance_page" class="hidden"></main>


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
                                        <p>As a player, you can get positive reviews by consistently showcasing professionalism, skill, and a good attitude.</p>
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
                    <img src="assets/img/icon-support.svg" alt="">
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
                <p class="text-center">Our awesome Customer Support Team is ready to assist you. Fill the form below & get connected.</p>
                <form action="{{ route('admin.create.ticket') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="mt-3">
                        <input type="text" name="name" class="form-control your-name" placeholder="Enter your Full name" value="{{ $data['d']->name ? $data['d']->name : '-' }}">
                    </div>
                    <div class="mt-3">
                        <input type="email" name="email" class="form-control your-email" placeholder="Enter your Email" value="{{ $data['d']->email ? $data['d']->email : '-' }}">
                    </div>
                    <div class="mt-3">
                        <input type="tel" name="phone" class="form-control your-phone" placeholder="Enter your Phone Number" value="{{ $data['d']->phone ? $data['d']->phone : '-' }}">
                    </div>
                    <div class="mt-3">
                        <textarea name="description" class="form-control" placeholder="Describe your Issue here.." style="height: 100px;"></textarea>
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

<div id="confirm-box" class="confirm-box" style="display: none; z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
        <div class="confirm-body">
            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
            <h6 id="confirm-message">Please fill out all fields.</h6>
        </div>
        <div class="confirm-footer">
            <button id="confirm-close" class="get_back btn btn-secondary">Go Back</button>
        </div>
    </div>
</div>

</div>
<!-- /CONTENT SECTION -->

@endsection