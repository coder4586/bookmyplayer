@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/listing_v6.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/listing_sdid_v16.js') }}" defer></script>
@endpush
@php 


@endphp
@extends('layouts.app')
@section('content')

<section class="listing-section clearfix">
    <input type="hidden" id="sport_id" value="{{ $data['sport_id'] }}">
    <input type="hidden" id="loc_id" value="{{ $data['d']->loc_id }}">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-3 d-none d-md-block">
                <div class="filter-group">
                    <div class="heading">
                        <h2 style="font-size:22px;">Filters</h2>
                        <button type="reset">Reset All</button>
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Localities
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="searchLocality" placeholder="Search Localities">
                                        <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                    </div>
                                    <div class="show-more-text show-more-height scrollbar" id="localityList">
                                    </div>

                                    <p><a href="#" class="show-more">More...</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="inquiry-section inquiry-section2 clearfix">
                    <div class="">
                        <section>
                            <h2 style="font-size: 22px;">Connect with top 5 Academies</h2>

                            <div class="enquiry_error_box">
                                <span id="enquiry_error"></span>
                            </div>

                            <form action="">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" name="" id="enquiry_name" placeholder="Name">
                                    </div>
                                    <div class="col-12">
                                        <input type="email" name="" id="enquiry_email" placeholder="Email">
                                    </div>
                                    <div class="col-12">
                                        <input type="tel" name="" id="enquiry_phone" placeholder="Phone">
                                    </div>
                                    <div class="col-12">
                                        <select name="sport" id="enquiry_sport" class="form-control">
                                            <option value="">Sport</option>
                                            <option value="29" {{ $data['d']->sport_id == 29 ? 'selected' : '' }}>Archery</option>
                                            <option value="12" {{ $data['d']->sport_id == 12 ? 'selected' : '' }}>Arts</option>
                                            <option value="26" {{ $data['d']->sport_id == 26 ? 'selected' : '' }}>Athletics</option>
                                            <option value="6" {{ $data['d']->sport_id == 6 ? 'selected' : '' }}>Badminton</option>
                                            <option value="36" {{ $data['d']->sport_id == 36 ? 'selected' : '' }}>Baseball</option>
                                            <option value="2" {{ $data['d']->sport_id == 2 ? 'selected' : '' }}>Basketball</option>
                                            <option value="20" {{ $data['d']->sport_id == 20 ? 'selected' : '' }}>Billiard</option>
                                            <option value="18" {{ $data['d']->sport_id == 18 ? 'selected' : '' }}>Boxing</option>
                                            <option value="3" {{ $data['d']->sport_id == 3 ? 'selected' : '' }}>Cricket</option>
                                            <option value="38" {{ $data['d']->sport_id == 38 ? 'selected' : '' }}>Carrom</option>
                                            <option value="13" {{ $data['d']->sport_id == 13 ? 'selected' : '' }}>Chess</option>
                                            <option value="24" {{ $data['d']->sport_id == 24 ? 'selected' : '' }}>Fencing</option>
                                            <option value="1" {{ $data['d']->sport_id == 1 ? 'selected' : '' }}>Football</option>
                                            <option value="7" {{ $data['d']->sport_id == 7 ? 'selected' : '' }}>Golf</option>
                                            <option value="31" {{ $data['d']->sport_id == 31 ? 'selected' : '' }}>Gym</option>
                                            <option value="11" {{ $data['d']->sport_id == 11 ? 'selected' : '' }}>Gymnastics</option>
                                            <option value="39" {{ $data['d']->sport_id == 39 ? 'selected' : '' }}>Handball</option>
                                            <option value="15" {{ $data['d']->sport_id == 15 ? 'selected' : '' }}>Hockey</option>
                                            <option value="10" {{ $data['d']->sport_id == 10 ? 'selected' : '' }}>Kabaddi</option>
                                            <option value="40" {{ $data['d']->sport_id == 40 ? 'selected' : '' }}>Kalaripayayttu</option>
                                            <option value="4" {{ $data['d']->sport_id == 4 ? 'selected' : '' }}>Karate</option>
                                            <option value="22" {{ $data['d']->sport_id == 22 ? 'selected' : '' }}>Khokho</option>
                                            <option value="19" {{ $data['d']->sport_id == 19 ? 'selected' : '' }}>Motorsports</option>
                                            <option value="9" {{ $data['d']->sport_id == 9 ? 'selected' : '' }}>MMA</option>
                                            <option value="34" {{ $data['d']->sport_id == 34 ? 'selected' : '' }}>Personal Trainer</option>
                                            <option value="30" {{ $data['d']->sport_id == 30 ? 'selected' : '' }}>Rugby</option>
                                            <option value="28" {{ $data['d']->sport_id == 28 ? 'selected' : '' }}>Taekwondo</option>
                                            <option value="21" {{ $data['d']->sport_id == 21 ? 'selected' : '' }}>Table Tennis</option>
                                            <option value="14" {{ $data['d']->sport_id == 14 ? 'selected' : '' }}>Sports</option>
                                            <option value="16" {{ $data['d']->sport_id == 16 ? 'selected' : '' }}>Tennis</option>
                                            <option value="25" {{ $data['d']->sport_id == 25 ? 'selected' : '' }}>Skating</option>
                                            <option value="37" {{ $data['d']->sport_id == 37 ? 'selected' : '' }}>Snooker</option>
                                            <option value="8" {{ $data['d']->sport_id == 8 ? 'selected' : '' }}>Shooting</option>
                                            <option value="35" {{ $data['d']->sport_id == 35 ? 'selected' : '' }}>Silambam</option>
                                            <option value="23" {{ $data['d']->sport_id == 23 ? 'selected' : '' }}>Squash</option>
                                            <option value="5" {{ $data['d']->sport_id == 5 ? 'selected' : '' }}>Swimming</option>
                                            <option value="27" {{ $data['d']->sport_id == 27 ? 'selected' : '' }}>Volleyball</option>
                                            <option value="17" {{ $data['d']->sport_id == 17 ? 'selected' : '' }}>Wrestling</option>
                                            <option value="32" {{ $data['d']->sport_id == 32 ? 'selected' : '' }}>Yoga</option>
                                        </select>

                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="" id="enquiry_message" placeholder="Message"></textarea>
                                    </div>
                                    <div>
                                        <p style="color:#fff; text-align:left;">*Your number will be verified.</p>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-secondary" id="getOtpBtn">SUBMIT</button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </section>


                <div class="register-as-a-academy left-academy">
                    <h2 style="font-size:22px">Register as a Academy</h2>
                    <p>Create your free profile today to start responding to leads and earning a regular income.
                        Stay Ahead of the competition by ranking higher with our platform.</p>
                    <a href="https://www.bookmyplayer.com/register-your-academy" class="btn btn-secondary">Register Now</a>
                </div>
                <div class="register-as-a-academy register-coach left-academy">
                    <h2 style="font-size:22px">Register as a Coach</h2>
                    <p>Create your free profile today to stat responding to leads and earning a regular income. Stay ahead of competition by ranking higher with our platform</p>
                    <a href="https://www.bookmyplayer.com/register-as-a-coach-trainer" class="btn btn-secondary">Register Now</a>
                </div>
                <div class="register-as-a-academy register-player left-academy">
                    <h2 style="font-size:22px">Register as a Player</h2>
                    <p>Participate in professional leagues, gain sponsorships and endorsements, and advance your carrer in sports.</p>
                    <a href="https://www.bookmyplayer.com/register-as-a-player" class="btn btn-secondary">Register Now</a>
                </div>
                <div style="text-align: end; width:100%">
                        <button id="report_locid_issue" class="btn btn-secondary w-100" style="margin-bottom:1rem">Report An Issue</button>
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
                            <label class="label-tab" for="tab-1">Localities <i
                                    class="fa-solid fa-chevron-right"></i></label>
                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="searchLocality2" placeholder="Search Localities">
                                    <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                </div>
                                <div class="show-more-text show-more-height scrollbar" id="localityList2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-9 col-xl-9 academy_main">
                <div class="d-flex justify-content-between align-items-center flex-nowrap d-flex-wrap-change w-100 mt-3 gap-2">
                    <h1 style="font-size:18px;" class="listing-title text-capitalize">{{ $data['listing_title'] }}</h1>
                    <div class="right d-flex justify-content-between align-items-center mb-3">
                        <button type="menu" class="d-block d-md-none" id="btn-open">Filter</button>
                    </div>
                </div>

                <div class="tab_height">
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="academy-tab-pane" role="tabpanel" aria-labelledby="academy-tab" tabindex="0">
                        <div class="academy-list-wrapper" id="academy-listing">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="coach-tab-pane" role="tabpanel" aria-labelledby="coach-tab" tabindex="0">
                        <div class="academy-list-wrapper" id="coach-listing">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="player-tab-pane" role="tabpanel" aria-labelledby="player-tab" tabindex="0">
                        <div class="academy-list-wrapper" id="player-listing">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="sports-tab-pane" role="tabpanel" aria-labelledby="sports-tab" tabindex="0">
                        <div class="academy-list-wrapper" id="sport-listing">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="location-tab-pane" role="tabpanel" aria-labelledby="location-tab" tabindex="0">
                        <div class="academy-list-wrapper">
                            <h2 style="font-size:22px;margin-top:1.5rem;padding:0 15px;" class="fw-bold mb-3 heading_border">Find other {{ ucwords($data['d']->sport ?? 'Sport') }} Academies and Coaches in Nearby Locations
                            </h2>
                            <section class="other-links-section clearfix">
                                <div class="container">
                                    <section>
                                        <ul style="cursor:pointer" id="location-listing">
                                        </ul>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@if($MOBILE)
<section class="inquiry-section clearfix">
    <div class="container">
        <section>
            <h2>Connect with top 5 Academies</h2>

            <div class="enquiry_error_box">
                <span id="enquiry_error2"></span>
            </div>

            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="" id="enquiry_name2" placeholder="Name">
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="" id="enquiry_email2" placeholder="Email">
                    </div>
                    <div class="col-md-6">
                        <input type="tel" name="" id="enquiry_phone2" placeholder="Phone">
                    </div>
                    <div class="col-md-6">
                        <select name="" id="enquiry_sport2" class="form-control">
                            <option value="">Sport</option>
                            <option value="29" {{ $data['d']->sport_id == 29 ? 'selected' : '' }}>Archery</option>
                            <option value="12" {{ $data['d']->sport_id == 12 ? 'selected' : '' }}>Arts</option>
                            <option value="26" {{ $data['d']->sport_id == 26 ? 'selected' : '' }}>Athletics</option>
                            <option value="6" {{ $data['d']->sport_id == 6 ? 'selected' : '' }}>Badminton</option>
                            <option value="36" {{ $data['d']->sport_id == 36 ? 'selected' : '' }}>Baseball</option>
                            <option value="2" {{ $data['d']->sport_id == 2 ? 'selected' : '' }}>Basketball</option>
                            <option value="20" {{ $data['d']->sport_id == 20 ? 'selected' : '' }}>Billiard</option>
                            <option value="18" {{ $data['d']->sport_id == 18 ? 'selected' : '' }}>Boxing</option>
                            <option value="3" {{ $data['d']->sport_id == 3 ? 'selected' : '' }}>Cricket</option>
                            <option value="38" {{ $data['d']->sport_id == 38 ? 'selected' : '' }}>Carrom</option>
                            <option value="13" {{ $data['d']->sport_id == 13 ? 'selected' : '' }}>Chess</option>
                            <option value="24" {{ $data['d']->sport_id == 24 ? 'selected' : '' }}>Fencing</option>
                            <option value="1" {{ $data['d']->sport_id == 1 ? 'selected' : '' }}>Football</option>
                            <option value="7" {{ $data['d']->sport_id == 7 ? 'selected' : '' }}>Golf</option>
                            <option value="31" {{ $data['d']->sport_id == 31 ? 'selected' : '' }}>Gym</option>
                            <option value="11" {{ $data['d']->sport_id == 11 ? 'selected' : '' }}>Gymnastics</option>
                            <option value="39" {{ $data['d']->sport_id == 39 ? 'selected' : '' }}>Handball</option>
                            <option value="15" {{ $data['d']->sport_id == 15 ? 'selected' : '' }}>Hockey</option>
                            <option value="10" {{ $data['d']->sport_id == 10 ? 'selected' : '' }}>Kabaddi</option>
                            <option value="40" {{ $data['d']->sport_id == 40 ? 'selected' : '' }}>Kalaripayayttu</option>
                            <option value="4" {{ $data['d']->sport_id == 4 ? 'selected' : '' }}>Karate</option>
                            <option value="22" {{ $data['d']->sport_id == 22 ? 'selected' : '' }}>Khokho</option>
                            <option value="19" {{ $data['d']->sport_id == 19 ? 'selected' : '' }}>Motorsports</option>
                            <option value="9" {{ $data['d']->sport_id == 9 ? 'selected' : '' }}>MMA</option>
                            <option value="34" {{ $data['d']->sport_id == 34 ? 'selected' : '' }}>Personal Trainer</option>
                            <option value="30" {{ $data['d']->sport_id == 30 ? 'selected' : '' }}>Rugby</option>
                            <option value="28" {{ $data['d']->sport_id == 28 ? 'selected' : '' }}>Taekwondo</option>
                            <option value="21" {{ $data['d']->sport_id == 21 ? 'selected' : '' }}>Table Tennis</option>
                            <option value="14" {{ $data['d']->sport_id == 14 ? 'selected' : '' }}>Sports</option>
                            <option value="16" {{ $data['d']->sport_id == 16 ? 'selected' : '' }}>Tennis</option>
                            <option value="25" {{ $data['d']->sport_id == 25 ? 'selected' : '' }}>Skating</option>
                            <option value="37" {{ $data['d']->sport_id == 37 ? 'selected' : '' }}>Snooker</option>
                            <option value="8" {{ $data['d']->sport_id == 8 ? 'selected' : '' }}>Shooting</option>
                            <option value="35" {{ $data['d']->sport_id == 35 ? 'selected' : '' }}>Silambam</option>
                            <option value="23" {{ $data['d']->sport_id == 23 ? 'selected' : '' }}>Squash</option>
                            <option value="5" {{ $data['d']->sport_id == 5 ? 'selected' : '' }}>Swimming</option>
                            <option value="27" {{ $data['d']->sport_id == 27 ? 'selected' : '' }}>Volleyball</option>
                            <option value="17" {{ $data['d']->sport_id == 17 ? 'selected' : '' }}>Wrestling</option>
                            <option value="32" {{ $data['d']->sport_id == 32 ? 'selected' : '' }}>Yoga</option>
                        </select>

                    </div>
                    <div class="col-md-12">
                        <textarea name="" id="enquiry_message2" placeholder="Message"></textarea>
                    </div>
                    <div>
                        <p style="color:#fff; text-align:left">*Your number will be verified.</p>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-secondary" id="getOtpBtn2">SUBMIT</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</section>
<div class="academy-price-fee">
    <div class="register-as-a-academy">
        <h2 style="font-size:22px">Register as a Academy</h2>
        <p>Create your free profile today to start responding to leads and earning a regular income.
            Stay Ahead of the competition by ranking higher with our platform.</p>
        <a href="https://www.bookmyplayer.com/register-your-academy" class="btn btn-secondary">Register Now</a>
    </div>
    <div class="register-as-a-academy register-coach left-academy">
        <h2 style="font-size:22px">Register as a Coach</h2>
        <p>Create your free profile today to stat responding to leads and earning a regular income. Stay ahead of competition by ranking higher with our platform</p>
        <a href="https://www.bookmyplayer.com/register-as-a-coach-trainer" class="btn btn-secondary">Register Now</a>
    </div>
    <div class="register-as-a-academy register-player left-academy">
        <h2 style="font-size:22px">Register as a Player</h2>
        <p>Participate in professional leagues, gain sponsorships and endorsements, and advance your carrer in sports.</p>
        <a href="https://www.bookmyplayer.com/register-as-a-player" class="btn btn-secondary">Register Now</a>
    </div>
    <div style="text-align: end; width:100%">
     <button id="report_locid_issue2" class="btn btn-secondary w-100">Report An Issue</button>
    </div>
</div>
@endif

<section class="other-backlinks-section other-backlinks-academy hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Academies</h4>
            <ul style="cursor:pointer" class="other_academy_links">
            </ul>
        </section>
    </div>
</section>

<section class="other-backlinks-section other-backlinks-coach hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Coaches</h4>
            <ul style="cursor:pointer" class="other_coach_links">
            </ul>
        </section>
    </div>
</section>

<section class="other-backlinks-section other-backlinks-player hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Players</h4>
            <ul style="cursor:pointer" class="other_player_links">
            </ul>
        </section>
    </div>
</section>

<section class="other-backlinks-section other-backlinks-location hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Locations</h4>
            <ul style="cursor:pointer" class="other_location_links">
            </ul>
        </section>
    </div>
</section>



<div class="modal fade" id="whatsappModal2" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
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
                    <span class="error" id="formError2" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name2" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email2" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone2" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc2" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <div class="mt-3">
                        <p style="color:#FE5C4D;">Your number will be verified</p>
                    </div>
                    <button type="button" id="similarAcademyFormButton" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="whatsappModal3" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel3">Contact</h5>
                <div type="button" class="close" id="close_whatsapp3" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm3" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <span class="error" id="formError3" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name3" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email3" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone3" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc3" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <div class="mt-3">
                        <p style="color:#FE5C4D;">Your number will be verified</p>
                    </div>
                    <button type="button" id="similarAcademyFormButton3" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="whatsappModal4" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel4">Contact</h5>
                <div type="button" class="close" id="close_whatsapp4" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm4" action="{{ route('submit.contact.player') }}" method="post">
                    @csrf
                    <span class="error" id="formError4" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name4" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email4" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone4" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc4" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <button type="button" id="similarAcademyFormButton4" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal01" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
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
                    <input type="text" class="form-control mob_otp_input3" id="otp_one" maxlength="1" placeholder="*">
                    <input type="text" class="form-control mob_otp_input3" id="otp_two" maxlength="1" placeholder="*">
                    <input type="text" class="form-control mob_otp_input3" id="otp_three" maxlength="1" placeholder="*">
                    <input type="text" class="form-control mob_otp_input3" id="otp_four" maxlength="1" placeholder="*">
                </div>
                <p class="m-0" id='resend-otp-signup-locid' style="display:none; cursor:pointer;"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-resend.svg" alt="resend"></p>
                <p class="mb-4">
                    <span class="mob_login_verify">
                        <span id="time">Resend OTP In 1m 16s</span>
                    </span>
                </p>
                <div id="error_msg" class="alert alert-danger error_msg text-center" role="alert"></div>
                <input type="submit" class="btn btn-secondary btn-lg" id="btn-signup3" value="Verify OTP">
            </div>
        </div>
    </div>
</div>


@endsection