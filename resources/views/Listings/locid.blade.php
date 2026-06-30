@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/listing_v6.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/listing_v23.js') }}" defer></script>
@endpush

@php
$url = request()->url();
$locid = last(explode('-', $url));
@endphp

@extends('layouts.app')
@section('content')

<section class="listing-section clearfix">
    <input type="hidden" style="display: none;" value="{{ $locid }}" id="locValue">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-3 d-none d-md-block" style="margin-top: 15px;">
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
                                    Nearby Localities
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

                                    <p><a href="#" class="show-more d-none">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Sport
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="searchSport" placeholder="Search Sport">
                                    </div>
                                    <div class="show-more-text2 show-more-height2 scrollbar" id="sportsList">
                                    </div>


                                    <p><a href="javascript:void(0)" class="show-more2 d-none">More...</a></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <section class="inquiry-section inquiry-section2 clearfix">
                    <div class="">
                        <section>
                            <h2 style="font-size: 22px;">Submit your enquiries for {{ $data['record']->locality_name }}</h2>

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
                                        <select name="" id="enquiry_sport" class="form-control">
                                            <option value="">Sport</option>
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
                                    <div class="col-md-12">
                                        <textarea name="" id="enquiry_message" placeholder="Message"></textarea>
                                    </div>
                                    <div>
                                        <p style="color:#fff">Your number will be verified.</p>
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
                        <button id="report_locid_issue" class="btn btn-secondary w-100">Report An Issue</button>
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
                            <label class="label-tab" for="tab-1">Nearby Localities <i
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
                        <div class="season_tab">
                            <input type="radio" id="tab-3" name="tab-group-1">
                            <label class="label-tab" for="tab-3">Sports <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="searchSport2" placeholder="Search Sports">
                                    <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                </div>
                                <div class="show-more-text show-more-height2 scrollbar" id="sportsList2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-9 col-xl-9 academy_main">
                <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mt-3">
                    <input type="hidden" id="loc_city" value="{{ $data['record']->city }}">
                    <input type="hidden" id="loc_state" value="{{ $data['record']->state }}">
                    <h1 style="font-size:22px;" class="listing-title text-capitalize">Play Sports In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}
                    </h1>
                    <div class="right d-flex justify-content-between align-items-center mb-3">
                        <button type="menu" class="d-block d-md-none" id="btn-open">Filter</button>
                    </div>
                </div>
                <div class="tab_height">
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
                        <div class="academy-list-wrapper" id="about-listing">
                            <div class="listing_banner">
                            </div>

                            <section class="sport_container">

                            </section>




                            <section class="tabs-content mt-3 mb-3 review_wrapper hidden" id="anchor5">
                                <div class="d-flex justify-content-between align-items-center mb-3" style="margin-top:60px;">
                                    <h6>Sports Review about {{ $data['record']->locality_name }}</h6>
                                </div>
                                <div class="reviews-box scrollbar">
                                    <div id="coach-reviews">
                                    </div>
                                </div>
                            </section>




                            <!-- Modal for Uploading Photos and Captions -->
                            <div class="modal fade" id="photoUploadModal" tabindex="-1" role="dialog" aria-labelledby="photoUploadModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="photoUploadModalLabel">Upload Photos and Add Captions</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="imagePreviewContainer" class="row">
                                                <!-- Dynamically added image previews and captions will go here -->
                                            </div>

                                            <!-- Personal Information Section -->
                                            <div class="mt-4">
                                                <h6>Personal Information</h6>
                                                <div class="form-group">
                                                    <label for="name">Name:</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Enter your name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone:</label>
                                                    <input type="text" id="phone" class="form-control" placeholder="Enter your phone number" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="uploadPhotos">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="listing_banner2">
                            </div>

                            <section class="top-cities-section hidden clearfix">
                                <div class="">
                                    <div class="col-12 text-start">
                                        <div class="top_flex mb-3" style="margin-top: 30px;">
                                            <h6>Explore Nearby Locations To {{ $data['record']->locality_name }}</h6>
                                        </div>
                                    </div>
                                    <div class="top-cities row">
                                    </div>
                                </div>
                            </section>

                            <section class="popular-sports-academies-section overview-box about_box white-box clearfix hidden" style="margin-top: 60px;">
                                <div class="">
                                    <div class="top_flex">
                                        <div>
                                            <h6>
                                                @php
                                                $location = $data['record']->locality_name === $data['record']->city
                                                ? $data['record']->city
                                                : "{$data['record']->locality_name}, {$data['record']->city}";
                                                @endphp

                                                About {{ $location }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="about_description">
                                    </div>
                                </div>
                            </section>

                            <section class="white-box sport_price_box hidden">
                                <div>
                                    <h6>Sports Coaching Charges In {{ $data['record']->locality_name }}</h6>
                                </div>
                                <table class="table table-fixed table-lock-height table-custom-width01">
                                    <thead class="table-light scrollbar">
                                        <tr>
                                            <th scope="col s_no">S No.</th>
                                            <th scope="col">Sport</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scrollbar sport-price-table">
                                    </tbody>
                                </table>

                            </section>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="academy-tab-pane" role="tabpanel" aria-labelledby="academy-tab" tabindex="0">
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
                            <section class="other-links-section clearfix">
                                <div class="container">
                                    <section>
                                        <h2 style="font-size:22px;" class="fw-bold mb-3 heading_border">Location Links</h2>
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
            <h2>Submit your enquiries for {{ $data['record']->locality_name }}</h2>

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
                    <div class="col-md-12">
                        <textarea name="" id="enquiry_message2" placeholder="Message"></textarea>
                    </div>
                    <div>
                        <p style="color:#fff">Your number will be verified.</p>
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
                    class="text-capitalize"></span>Academies In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}</h4>
            <ul style="cursor:pointer" class="other_academy_links">
            </ul>
        </section>
    </div>
</section>

<section class="other-backlinks-section other-backlinks-coach hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Coaches In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}</h4>
            <ul style="cursor:pointer" class="other_coach_links">
            </ul>
        </section>
    </div>
</section>
<section class="other-backlinks-section other-backlinks-player hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Players In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}</h4>
            <ul style="cursor:pointer" class="other_player_links">
            </ul>
        </section>
    </div>
</section>
<section class="other-backlinks-section other-backlinks-sports hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Sports In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}</h4>
            <ul style="cursor:pointer" class="other_sports_links">
            </ul>
        </section>
    </div>
</section>
<section class="other-backlinks-section other-backlinks-location hidden">
    <div class="container">
        <section>
            <h4 style="font-size:22px" class="fw-bold mb-3 heading_border"><span
                    class="text-capitalize"></span>Locations In {{ $data['record']->locality_name }}, {{ $data['record']->city_id == 0 ? $data['record']->state : $data['record']->city . ', ' . $data['record']->state }}</h4>
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

<!-- Modal Structure -->
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