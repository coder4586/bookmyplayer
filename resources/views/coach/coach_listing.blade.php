@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/coach_listing.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/coach_listing_v2.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')

<section class="listing-section clearfix mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xl-4 d-none d-md-block">
                <div class="filter-group">
                    <div class="heading">
                        <h6>Filters</h6>
                        <button type="reset">Reset All</button>
                    </div>

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Localities in {{ $data['location']->city ?? "India" }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="" placeholder="Search Localities">
                                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div id="locationContainer" class="show-more-text show-more-height scrollbar">
                                    @foreach ($data['nearbylocations'] as $location)
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="location-{{ $location->id }}">
                                        <label class="form-check-label" for="location-{{ $location->id }}">
                                            <a href="{{ $location->url }}">{{ ucwords($location->location) }}</a>
                                        </label>
                                    </div>
                                    @endforeach
                                    </div>
                                    <p class="show-more" style="visibility:hidden;"><a href="#" id="showMoreLink" class="show-more">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                    Search By
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="11">
                                        <label class="form-check-label" for="11">Academy (857)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="12">
                                        <label class="form-check-label" for="12">Coach (8578)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                                    Rating
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="31">
                                        <label class="form-check-label d-flex align-items-center" for="31">2.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/2star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="32">
                                        <label class="form-check-label d-flex align-items-center" for="32">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/3star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="33">
                                        <label class="form-check-label d-flex align-items-center" for="33">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/4star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="34">
                                        <label class="form-check-label d-flex align-items-center" for="34">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                                    More
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFive">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="41">
                                        <label class="form-check-label" for="41">Open Academies</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="42">
                                        <label class="form-check-label" for="42">Verified Only</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="filter-content">
                <div class="filter-tab">
                    <div class="heading">
                        <h6>Filters</h6>
                        <button type="reset">Reset All</button>
                    </div>
                    <div class="season_tabs">
                        <div class="season_tab">
                            <input type="radio" id="tab-1" name="tab-group-1" checked>
                            <label class="label-tab" for="tab-1">Localities <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="" placeholder="Search Localities">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                <div class="show-more-text show-more-height scrollbar">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="101">
                                        <label class="form-check-label" for="101">Prayagraj</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="102">
                                        <label class="form-check-label" for="102">Jamshedpur</label>
                                    </div>
                                </div>
                                <p><a href="#" class="show-more">More...</a></p>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-2" name="tab-group-1">
                            <label class="label-tab" for="tab-2">Search By <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="11">
                                    <label class="form-check-label" for="11">Academy (857)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="12">
                                    <label class="form-check-label" for="12">Coach (8578)</label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-3" name="tab-group-1">
                            <label class="label-tab" for="tab-3">Sports <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="21">
                                    <label class="form-check-label" for="21">Football</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="22">
                                    <label class="form-check-label" for="22">Basketball</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="23">
                                    <label class="form-check-label" for="23">Cricket</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="24">
                                    <label class="form-check-label" for="24">Swimming</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="25">
                                    <label class="form-check-label" for="25">Badminton</label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-4" name="tab-group-1">
                            <label class="label-tab" for="tab-4">Ratings <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="31">
                                    <label class="form-check-label d-flex align-items-center" for="31">2.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/2star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="32">
                                    <label class="form-check-label d-flex align-items-center" for="32">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/3star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="33">
                                    <label class="form-check-label d-flex align-items-center" for="33">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/4star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="34">
                                    <label class="form-check-label d-flex align-items-center" for="34">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" loading="lazy" alt="Star"></label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-5" name="tab-group-1">
                            <label class="label-tab" for="tab-5">More <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="41">
                                    <label class="form-check-label" for="41">Open Academies</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="42">
                                    <label class="form-check-label" for="42">Verified Only</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xl-8">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    @if ($data['d']->sport_id == 34)
                    <h1 style="font-size: 22px;" class="listing-title">{{$data['totalcoaches']}} {{ $data['sport']->name }} in {{ $data['location']->locality_name }}</h1>
                    @else
                    <h1 style="font-size:22px;" class="listing-title">
                        {{ $data['totalcoaches'] ?? '0' }}
                        {{ $data['sport']->name ?? 'Sports' }} Coaches in
                        {{ $data['location']->locality_name ?? '' }}@if(isset($data['location']->locality_name, $data['location']->city, $data['location']->state)){{ $data['location']->locality_name === $data['location']->city
                            ? ', ' . $data['location']->state
                            : ', ' . $data['location']->city }}@endif
                    </h1>
                    @endif
                    <!-- <div class="right d-flex justify-content-between align-items-center flex-wrap">
                        <div class="detect-location" id="detect-location-coach"><button type="button"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/detect2.svg" alt="location" width="24" height="24" /></button>
                        </div>
                    </div> -->
                </div>
                <div class="coaches-list-wrapper">
                    <div class="row" id="coach-listing">
                    </div>
                    <div id="loading-indicator">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader">
                    </div>
                    <div id="no-data-found" class="d-none">
                        <h4>No More Data Show.</h4>
                    </div>
                    <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations">
                      <ul class="pagination">
                        <li class="page-item" id="prev-page">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span> Previous
                          </a>
                        </li>
                        <li class="page-item active" id="current-page"><span class="page-link"></span></li>
                        <li class="page-item" id="next-page">
                          <a class="page-link" href="#" aria-label="Next">
                            Next <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      </ul>
                    </nav>                                  
                </div>
                <div class="image-container register_img">    
                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/Register_as_coach.webp" loading="lazy" alt="Coach Register" class="img-fluid mt-4">
                        <div class="overlay-text">
                            <div style="font-weight: 700;">Register as a Coach</div>
                            <p>Create your free profile today to stat responding to leads and earning a regular income. Stay ahead of competition by ranking higher with our platform</p>
                            <a href="/register-as-a-coach-trainer" target="_blank">  <button>Register now</button></a>
                        </div>
                    </div>      
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel"></h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details"
                        value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details"
                        value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details"
                        value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details"
                        value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}">
                    <input type="hidden" name="loc_id" id="loc_id_details"
                        value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details" value="message" required>
                    <span class="error" id="formError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name"
                            placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email"
                            placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone"
                            placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc"
                            placeholder="Enter your description" autocomplete="off"></textarea>
                    </div>
                    <div class="mb-3">
                      <p style="color:#FE5C4D;">Your number will be verified</p>
                    </div>
                    <!-- <button type="button" id="formSubmitButton" class="btn btn-primary">Send</button> -->
                    <button type="button" id="otp_modal" class="btn btn-primary">Send</button>
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
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" class="otp_close" alt="cross" height="24" width="24">
        </div>
        <div class="modal-body">
            <p>We have sent a verification code to your mobile number/email.</p>
            <div class="d-flex justify-content-center align-items-center edit-phone-number">
                <h6 id="phoneNumberSpan"></h6>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" class="change_num" alt="edit">
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4 gap-3">
                <input type="text" class="form-control mob_otp_input3" id="otp100" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp200" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp300" maxlength="1" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp400" maxlength="1" placeholder="*">
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

@endsection
