@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/tournament_v3.css') }}" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/tournament_v13.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')

<section class="dashboard-menu-section clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-4 ">
                <div class="page-menu">
                    <div class="top_menu top_tournament active" id="top_add_tournament"><span class="icon-icon-04"></span>Add Tournament</div>
                </div>
            </div>
            <div class="col-md-2 col-4 hidden">
                <div class="page-menu">
                    <div class="top_menu top_tournament" id=""><span class="icon-icon-04"></span>View Tournament</div>
                </div>
            </div>
            @if($data['pin']==null)
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="pin_btn_tournament"><span class="icon-icon-04"></span>Set Pin</div>
                </div>
            </div>
            @else
            <input type="hidden" id="pin_value_tournament" value="{{ $data['pin'] }}">
            <div class="col-md-2 col-4">
                <div class="page-menu">
                    <div class="top_menu" id="pin_btn_tournament"><span class="icon-icon-04"></span>Update Pin</div>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>


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

<section class="view_tournament">
    <div class="accordion" id="tournamentAccordion">
        <!-- Dynamically generated accordion content will go here -->
    </div>
</section>

@endsection