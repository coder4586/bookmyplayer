@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/coach_register.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/other_register_v1.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<section class="register-form-section clearfix">
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h4>Others</h4>
                    <p>We are glad to see you here.</p>
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="coach_name" placeholder="Please Enter your Full name">
                    </div>
                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="other_service" placeholder="Please Enter your Service">
                    </div>

                    <div class="mt-3 location-box">
                        <input type="text" placeholder="Please Enter Your City" name="city" class="form-control text-capitalize" id="locationInput" value="" autocomplete="off">
                        <div id="location-name" class="location-list">
                            <!-- Dynamically filled based on input -->
                        </div>
                    </div>

                    <div class="mt-3">
                        <input type="text" class="form-control your-name" id="coach_description" placeholder="Please Enter your Description">
                    </div>
                    <div class="mt-3">
                        <input type="email" class="form-control your-email" id="coach_email" placeholder="Please Enter your Email">
                    </div>
                    <div class="mt-3">
                        <input type="number" class="form-control your-phone" id="coach_phone" placeholder="Please Enter your Phone Number">
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
                <h6 id="phoneNumberSpan"></h6> <a href="#"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/icon-edit.svg" alt="edit"></a>
            </div>
            <div class="d-flex justify-content-center align-items-center input-number mt-4 mb-4">
                <input type="text" class="form-control mob_otp_input7" id="otp71" placeholder="*">
                <input type="text" class="form-control mob_otp_input7" id="otp72" placeholder="*">
                <input type="text" class="form-control mob_otp_input7" id="otp73" placeholder="*">
                <input type="text" class="form-control mob_otp_input7" id="otp74" placeholder="*">
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

@endsection