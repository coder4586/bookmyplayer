@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/coach_register.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/coach_register_v2.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<section class="register-form-section clearfix">
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h4>Welcome Coach</h4>
                    <p>Hey Coach we are glad to see you here.</p>
                    <input type="hidden" id="city_custom" value="">
                    <input type="hidden" id="state_custom" value="">
                    <input type="hidden" id="postcode_custom" value="">
                    <input type="hidden" id="address_custom" value="">
                    <input type="hidden" id="address_one_custom" value="">
                    <input type="hidden" id="custom_outside_latitude" value="">
                    <input type="hidden" id="custom_outside_longitude" value="">
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="coach_name" placeholder="Please Enter your Full name">
                    </div>
                    <div class="mt-3">
                        <select name="" id="coach_sport" class="form-control">
                            <option value="">Please Select Your Sports</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <input type="email" class="form-control your-email" id="coach_email" placeholder="Please Enter your Email">
                    </div>
                    <div class="mt-3">
                        <input type="number" class="form-control your-phone" id="coach_phone" placeholder="Please Enter your Phone Number">
                    </div>
                    <div class="mt-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gender" type="radio" id="male" value="male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="mt-3 add-address">
                        <input type="text" placeholder="Please Select Your City" name="city" class="form-control text-capitalize" id="locationInput" value="" autocomplete="off"></input>
                        <a class="btn btn-primary btn-lg" id="btn-add-your-city">Add <i class="fa-solid fa-plus"></i></a>
                        <div id="location-name" class="location-list"></div>
                    </div>
                    <div class="mt-3">
                        <p>If your city isn't listed, click Add+</p>
                    </div>
                    <div class="upload-button-wrapper">
                        <label for="file-upload" class="custom-file-upload">
                            Upload Profile Images
                        </label>
                        <input id="file-upload" type="file" accept="image/*" />
                        <span id="file-name" class="file-name">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" style="display: none; height:50px; width:50px; border-radius:50%" id="coach_loader" alt="">
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
            <div class="col-md-6 order-md-first">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/register-image.jpg" class="hero-img img-fluid object-fit" alt="register" width="480" height="470">
            </div>
        </div>
    </section>

    <div class="remodal" data-remodal-id="modal01" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <div>
            <h5>Verify Code</h5>
            <p>We have sent verification code to your mobile number</p>
            <div class="d-flex justify-content-center align-items-center edit-phone-number">
                <h6 id="phoneNumberSpan"></h6> <a href="#" id="close-modal-btn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" alt="edit"></a>
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4">
                <input type="text" class="form-control mob_otp_input3" id="otp11" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp22" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp33" placeholder="*">
                <input type="text" class="form-control mob_otp_input3" id="otp44" placeholder="*">
            </div>
            <p class="m-0" id='resend-otp-signup' style="display:none"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-resend.svg" alt="resend"></p>
            <p class="mb-4"><span class="mob_login_verify"><span id="timer"><span id="time"></span></span></span></p>
            <div id="errorMsg2" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>
            <input type="submit" class="btn btn-secondary btn-lg" id="btn-signup3" value="Verify OTP">
        </div>
    </div>

    <div class="how-to-earn-section">
        <h2>Let’s See how you can Earn</h2>
        <div class="left-content">
            <figure>01</figure>
            <article>
                <h5>Create Free Profile</h5>
                <p>Complete your profile with Videos, Pictures, Reviews of your clients, detailed descriptions of
                    your coaching philosophy, experience, and unique offerings.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content">
            <figure>02</figure>
            <article>
                <h5>Get Discovered</h5>
                <p>Include testimonials from previous clients, before-and-after scenarios, and success rates to
                    build trust and demonstrate your effectiveness as a coach.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content">
            <figure>03</figure>
            <article>
                <h5>Respond to Leads</h5>
                <p>Stay active on the platform and check your notifications for any inquiries or booking requests
                    from potential clients.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content">
            <figure>04</figure>
            <article>
                <h5>Rank Ahead of Competition</h5>
                <p>Consider providing a free or discounted initial consultation to discuss the client's goals and
                    showcase your coaching approach.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-right.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="left-content">
            <figure>05</figure>
            <article>
                <h5>Earn Regular Income</h5>
                <p>Research what other coaches with similar qualifications are charging and set competitive rates
                    for your services. Create coaching packages, seasonal discounts, or loyalty programs to
                    encourage long-term commitments and repeat business.</p>
            </article>
        </div>
        <div class="divider">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/arrow-left.png" class="lazy" alt="connection" width="672" height="134">
        </div>
        <div class="right-content last-coentent">
            <figure>06</figure>
            <article>
                <h5>Innovative Tools and Resources</h5>
                <p>Participate in the platform's community by sharing insights, joining discussions, and offering
                    free tips. This can enhance your visibility and attract more clients.</p>
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