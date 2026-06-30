@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/coach_register.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/player_register_v2.js') }}" defer></script>
@endpush
@extends('layouts.app')

@section('content')
<section class="register-form-section clearfix">
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h4>Welcome Player</h4>
                    <p>Hey Player we are glad to see you here.</p>
                    <input type="hidden" id="city_custom" value="">
                    <input type="hidden" id="state_custom" value="">
                    <input type="hidden" id="postcode_custom" value="">
                    <input type="hidden" id="address_custom" value="">
                    <input type="hidden" id="address_one_custom" value="">
                    <input type="hidden" id="custom_outside_latitude" value="">
                    <input type="hidden" id="custom_outside_longitude" value="">
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="coach_name" placeholder="Please Enter Your Full Name">
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3 mb-md-0"">
                            <select name="" id="coach_sport" class="form-control">
                                <option value="">Sports</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-control" id="player_feet">
                                <option value="">Height</option>
                                <!-- 4 Feet -->
                                <option value="4;0">4 Feet 0 Inch</option>
                                <option value="4;1">4 Feet 1 Inch</option>
                                <option value="4;2">4 Feet 2 Inch</option>
                                <option value="4;3">4 Feet 3 Inch</option>
                                <option value="4;4">4 Feet 4 Inch</option>
                                <option value="4;5">4 Feet 5 Inch</option>
                                <option value="4;6">4 Feet 6 Inch</option>
                                <option value="4;7">4 Feet 7 Inch</option>
                                <option value="4;8">4 Feet 8 Inch</option>
                                <option value="4;9">4 Feet 9 Inch</option>
                                <option value="4;10">4 Feet 10 Inch</option>
                                <option value="4;11">4 Feet 11 Inch</option>
                                <!-- 5 Feet -->
                                <option value="5;0">5 Feet 0 Inch</option>
                                <option value="5;1">5 Feet 1 Inch</option>
                                <option value="5;2">5 Feet 2 Inch</option>
                                <option value="5;3">5 Feet 3 Inch</option>
                                <option value="5;4">5 Feet 4 Inch</option>
                                <option value="5;5">5 Feet 5 Inch</option>
                                <option value="5;6">5 Feet 6 Inch</option>
                                <option value="5;7">5 Feet 7 Inch</option>
                                <option value="5;8">5 Feet 8 Inch</option>
                                <option value="5;9">5 Feet 9 Inch</option>
                                <option value="5;10">5 Feet 10 Inch</option>
                                <option value="5;11">5 Feet 11 Inch</option>
                                <!-- 6 Feet -->
                                <option value="6;0">6 Feet 0 Inch</option>
                                <option value="6;1">6 Feet 1 Inch</option>
                                <option value="6;2">6 Feet 2 Inch</option>
                                <option value="6;3">6 Feet 3 Inch</option>
                                <option value="6;4">6 Feet 4 Inch</option>
                                <option value="6;5">6 Feet 5 Inch</option>
                                <option value="6;6">6 Feet 6 Inch</option>
                                <option value="6;7">6 Feet 7 Inch</option>
                                <option value="6;8">6 Feet 8 Inch</option>
                                <option value="6;9">6 Feet 9 Inch</option>
                                <option value="6;10">6 Feet 10 Inch</option>
                                <option value="6;11">6 Feet 11 Inch</option>
                                <!-- 7 Feet -->
                                <option value="7;0">7 Feet 0 Inch</option>
                                <option value="7;1">7 Feet 1 Inch</option>
                                <option value="7;2">7 Feet 2 Inch</option>
                                <option value="7;3">7 Feet 3 Inch</option>
                                <option value="7;4">7 Feet 4 Inch</option>
                                <option value="7;5">7 Feet 5 Inch</option>
                                <option value="7;6">7 Feet 6 Inch</option>
                                <option value="7;7">7 Feet 7 Inch</option>
                                <option value="7;8">7 Feet 8 Inch</option>
                                <option value="7;9">7 Feet 9 Inch</option>
                                <option value="7;10">7 Feet 10 Inch</option>
                                <option value="7;11">7 Feet 11 Inch</option>
                            </select>
                        </div>
                    </div>
                    <div id="subCategoryContainer"></div>
                    <div id="subSubCategoryContainer"></div>
                    <button type="button" id="addCategoryBtn" class="mt-3" style="display:none;">Add Another Category</button>
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="player-heading" placeholder="Add Profile Heading">
                    </div>
                    <!-- <div class="mt-3 location-box">
                        <input type="hidden" name="loc_id" id="loc_id_input" value="">
                        <input type="hidden" name="new_city" id="new_city_input" value="">
                        <input type="text" placeholder="Please Select Your City" name="city" class="form-control text-capitalize" id="locationInput" value="" autocomplete="off">
                        <div id="location-name" class="location-list">
                        </div>
                    </div> -->
                    <div class="mt-3">
                        <input type="email" class="form-control your-email" id="coach_email" placeholder="Please Enter your Email">
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input type="date" class="form-control" id="player_dob">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="player_weight" placeholder="Weight">
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="number" class="form-control your-phone" id="coach_phone" placeholder="Please Enter your Phone Number">
                    </div>
                    <div class="mt-3 d-flex justify-content-start align-items-start gap-3">
                        <div>
                            <span style="font-weight: 500;">You are a:</span>
                        </div>
                        <div>
                        <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_guardian" id="female" value="0" checked>
                                <label class="form-check-label" for="female">Player</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="is_guardian" type="radio" id="male" value="1">
                                <label class="form-check-label" for="male">Parent</label>
                            </div> 
                        </div>

                    </div>
                    <div class="mt-3 add-address">
                        <input type="hidden" name="loc_id" id="loc_id_input" value="">
                        <input type="hidden" name="new_city" id="new_city_input" value="">
                        <input type="text" placeholder="Please Select Your City" name="city" class="form-control text-capitalize" id="locationInput" value="" autocomplete="off"></input>
                        <div id="location-name" class="location-list"></div>
                        <a class="btn btn-primary btn-lg" id="btn-add-your-city">Add <i class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="mt-3">
                        <p>If your city isn't listed, click Add+</p>
                    </div>
                    <div class="upload-button-wrapper">
                        <label for="file-upload" class="custom-file-upload">
                            Upload Profile Image
                        </label>
                        <input id="file-upload" type="file" accept="image/*" />
                        <span id="file-name" class="file-name">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" style="display: none; height:50px; width:50px; border-radius:50%" id="player_loader" alt="">
                        </span>
                    </div>

                    <div id="error-message" class="alert alert-danger mt-3" style="display:none;"></div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms_check" checked>
                            <label class="form-check-label" for="terms_check">I Agree to Terms & Privacy
                                Policy</label>
                        </div>
                        <a href="#" class="btn btn-secondary btn-lg" id="getOtpBtn">Get OTP</a>
                    </div>
                    <div class="mt-4 form-col-info text-center">
                        <p>Already Have an Account? <a href="/login">Login Now</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 order-md-first image-container">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/player_registration.png" class="hero-img img-fluid object-fit" alt="register" width="480" height="470">
            </div>
        </div>

    </section>

    <div class="remodal" data-remodal-id="modal01" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <div>
            <h5>Verify Code</h5>
            <p>We have sent verification code to your mobile number</p>
            <div class="d-flex justify-content-center align-items-center edit-phone-number">
                <h6 id="phoneNumberSpan"></h6> <a href="#"><a href="#" id="close-modal-btn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" alt="edit"></a>
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4">
                <input type="text" class="form-control mob_otp_input5" id="otp51" placeholder="*">
                <input type="text" class="form-control mob_otp_input5" id="otp52" placeholder="*">
                <input type="text" class="form-control mob_otp_input5" id="otp53" placeholder="*">
                <input type="text" class="form-control mob_otp_input5" id="otp54" placeholder="*">
            </div>
            <p class="m-0" id='resend-otp-signup' style="display:none"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-resend.svg" alt="resend"></p>
            <p class="mb-4"><span class="mob_login_verify"><span id="timer"><span id="time"></span></span></span></p>
            <div id="errorMsg2" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>
            <input type="submit" class="btn btn-secondary btn-lg" id="btn-signup3" value="Verify OTP">
        </div>
    </div>

    <div class="how-to-earn-section">
        <h2>Sports Players In India Can Make A Steady Income Through Several Avenues</h2>
        <div class="left-content">
            <figure>01</figure>
            <article>
                <h5>Professional Leagues</h5>
                <p>The establishment of professional sports leagues like the Indian Premier League (IPL), Indian Super League (ISL), and Pro Kabaddi League has created lucrative contracts for players. These leagues offer annual salaries, bonuses, and other incentives, providing a stable income source.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content">
            <figure>02</figure>
            <article>
                <h5>Sponsorship and Endorsements</h5>
                <p>Successful athletes often secure endorsement deals with major brands, which can supplement their income significantly. These deals can range from endorsing sports equipment to lifestyle products, providing a steady revenue stream beyond their sporting career.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content">
            <figure>03</figure>
            <article>
                <h5>Coaching and Training</h5>
                <p>Retired or active sports players can turn to coaching, either individually or in academies. This can be a reliable income stream, especially with the growing demand for specialized coaching and training programs.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content">
            <figure>04</figure>
            <article>
                <h5>Sports Commentary and Media</h5>
                <p>Many athletes transition into roles such as sports commentators, analysts, or writers, working for media outlets or creating their own platforms. This can be a lucrative and steady career, leveraging their expertise and reputation.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content last-coentent">
            <figure>05</figure>
            <article>
                <h5>Sports Academies</h5>
                <p>Some athletes start their own sports academies, training the next generation of talent. This not only provides income from tuition fees but also contributes to the sports ecosystem.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content last-coentent">
            <figure>06</figure>
            <article>
                <h5>Prize Money</h5>
                <p>While less stable than other income sources, prize money from winning tournaments, matches, or competitions can significantly boost an athlete's income.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content last-coentent">
            <figure>07</figure>
            <article>
                <h5>Social Media</h5>
                <p>Athletes can leverage social media platforms to build personal brands, attract followers, and secure sponsorship deals. Additionally, monetizing content through platforms like YouTube or Instagram can contribute to a steady income.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content last-coentent">
            <figure>08</figure>
            <article>
                <h5>Merchandising</h5>
                <p>Selling branded merchandise, such as jerseys, equipment, or other products, can provide additional income, particularly for popular athletes with a strong fan base.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content last-coentent">
            <figure>09</figure>
            <article>
                <h5>Stability</h5>
                <p>By diversifying their income streams and leveraging their skills, sports players in India can achieve financial stability throughout and beyond their careers.</p>
            </article>
        </div>
        <div class="text-center mt-5">
            <a href="#" class="btn btn-secondary btn-lg">Register Now</a>
        </div>
    </div>
</section>

<!-- Custom address popup -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <div>
            <h5>Add your Address</h5>
            <div class="form-section">
                <div id="error-message-cus-address" class="alert alert-danger mt-3" style="display:none;"></div>
                <div class="mt-3 position-relative">
                    <input type="number" class="form-control" id="custome_post" placeholder="Search By Postal Code" autocomplete="off">
                    <div class="search-results" id="pincode-location-results"></div>
                </div>
                <div class="mt-3">
                    <input type="text" class="form-control" id="custome_address" placeholder="Address" autocomplete="off">
                </div>
                <div class="mt-3">
                    <input type="text" class="form-control" id="custome_city" placeholder="City" autocomplete="off">
                </div>
                <div class="mt-3">
                    <input type="text" class="form-control" id="custome_state" placeholder="State" autocomplete="off">
                </div>
                <div class="mt-3 address_one">
                    <input type="text" class="form-control" id="custome_address_1" placeholder="Address 1 (Optional)" autocomplete="off">
                </div>
                <input type="hidden" id="custom_latitude" style="display:none;">
                <input type="hidden" id="custom_longitude" style="display:none;">
                <div class="mt-3">
                    <input type="submit" class="btn btn-secondary btn-lg btn-add-custom-address" id="btn-add-custom-address" value="Add Address">
                </div>


            </div>
        </div>
    </div>
</div>

@endsection