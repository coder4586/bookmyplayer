@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/login_v1.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/login.js') }}" defer></script>
@endpush
@extends('layouts.app')

@section('content')
@php
$profile_viewer_uid = 1;

// Check if the cookie is set before accessing it
if (isset($_COOKIE['profile_viewer_uid'])) {
$profile_viewer_uid = $_COOKIE['profile_viewer_uid'];
}

$options = [
1 => "Coach",
3 => "Player",
2 => "Institute/Academy/Team",
];

// Based on the cookie value, rearrange the options
$firstOptionValue = $profile_viewer_uid ?: 1; // Default to 1 (Coach) if cookie is not set or is invalid

// Ensure the first option exists; otherwise, default to "Coach"
if (!isset($options[$firstOptionValue])) {
$firstOptionValue = 1;
}

// Move the selected first option to the beginning of the array
$firstOption = [$firstOptionValue => $options[$firstOptionValue]];
unset($options[$firstOptionValue]);
$options = $firstOption + $options;
@endphp

<!-- loginPopup -->
<div class="custom-modal-login" id="loginPopup">
    <section class="mob_login_container">
        <div class="mob_top_flex">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/logo.svg" loading="lazy" alt="logo" width="25" height="25">
        </div>

        <div class="login_content">
            <div class="mob_login_account_wrapper">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                    <button class="get_pin_btn pin_active" id="loginWithOtpBtn">Login With Otp</button>
                    <button class="get_pin_btn" id="loginWithPinBtn">Login With PIN</button>
                </div>

                <a href="https://www.bookmyplayer.com/register" target="_blank">
                    <span class="mob_login_account">
                        New to BookMyPlayer?<span> <span class=""> Create an Account</span></span>
                    </span>
                </a>
            </div>

            <main class="login_with_otp">
                <div class="mob_login_wrapper">
                    <div class="mob_phone_input individual-fields-2">
                        <div class="mob_phone_select">
                            <select name="">
                                <option value="">+91</option>
                            </select>
                        </div>
                        <input type="number" name="username" id="username" placeholder="Login with Mobile number" class="new_input">
                    </div>
                </div>

                <div id="errorMsgLogin" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>

                <div class="mob_login_check" id="login_check">
                    <label class="mob_login_label_checkbox">
                        <input type="checkbox" checked />
                        <span class="mob_login_checkbox"></span>
                        <p>I agree to<span> Terms & Privacy Policy</span></p>
                    </label>
                </div>

                <div class="mob_btn_wrapper">
                    <div class="mob_login_create_profile" id="loginOtpBtn">
                        <button class="get_otp_btn">Get OTP</button>
                    </div>
                </div>
            </main>

            <main class="login_with_pin">
                <div class="mob_login_wrapper">
                    <div class="mob_phone_input individual-fields-2">
                        <div class="mob_phone_select">
                            <select name="">
                                <option value="">+91</option>
                            </select>
                        </div>
                        <input type="number" name="username" id="username2" placeholder="Login with Mobile number" class="new_input">
                    </div>
                </div>

                <div id="errorMsgLogin4" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>

                <div class="mob_login_check" id="login_check">
                    <label class="mob_login_label_checkbox">
                        <input type="checkbox" checked />
                        <span class="mob_login_checkbox"></span>
                        <p>I agree to<span> Terms & Privacy Policy</span></p>
                    </label>
                </div>

                <div class="mob_btn_wrapper">
                    <div class="mob_login_create_profile" id="loginOtpBtn2">
                        <button class="get_otp_btn">Next</button>
                    </div>
                </div>
            </main>
        </div>

        <div class="authentication_screen2">
            <div class="mob_login_account_wrapper2">
                <p class="mob_login_authenticate2">Authentication Required To Login</p>
                <p class="mob_login_verify2">
                    We have sent the verification code to your mobile number <span id="phoneNumberSpan2">+917412589632</span>
                    <span onClick="changeClick2()"></span>
                </p>
            </div>

            <div class="otp-cards2">
                <div class="otp-container2">
                    <div class="otp-box2">
                        <input type="number" name='otp01' id='otp01' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp02' id='otp02' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp03' id='otp03' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp04' id='otp04' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
            </div>

            <div class="mob_login_otp2">
                <p id='resend-otp_login' style="display:none">Resend Otp</p>
            </div>

            <div class="mob_btn_wrapper2">
                <div id="verifyOtp12345" class="mob_login_create_profile2">
                    <button id="go_back_otp" class="mob_login_create_profile_btn">Go Back</button>
                </div>

                <div id="errorMsgLogin2" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>

                <div class="mob_verify_time2">
                    <span class="mob_login_verify2">Please verify your number within 2 Minutes.</span>
                    <span id="timer2"><span id="time2"></span></span>
                </div>

                <input type="hidden" class="txt_csrfname" name="" value="">
            </div>
        </div>

        <div class="authentication_screen3">
            <div class="mob_login_account_wrapper2">
                <p class="mob_login_authenticate2">Enter Pin To Login</p>
            </div>

            <div class="pin-box">
                <div class="otp-container2">
                    <div class="otp-box2">
                        <input type="number" name='otp01' id='pin1' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp02' id='pin2' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp03' id='pin3' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="otp-box2">
                        <input type="number" name='otp04' id='pin4' class="common-fonts mob_otp_input2" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
            </div>

            <div class="mob_btn_wrapper2">
                <div class="mob_login_create_profile2">
                    <button id="go_back" class="mob_login_create_profile_btn">Go Back</button>
                </div>
                <div id="errorMsgLogin3" class="alert alert-danger error_msg d-none text-center mr-2" role="alert"></div>
                <input type="hidden" class="txt_csrfname" name="" value="">
            </div>
        </div>
    </section>
</div>
<!-- login popup ends -->

<!-- sign up modal -->

<!-- sign up modal ends -->
@endsection