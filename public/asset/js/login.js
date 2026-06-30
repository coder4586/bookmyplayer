// Element references
const otpInputs2 = $(".mob_otp_input2"),
      otpBox01 = $("#otp01"),
      otpBox02 = $("#otp02"),
      otpBox03 = $("#otp03"),
      otpBox04 = $("#otp04"),
      pinBox01 = $("#pin1"),
      pinBox02 = $("#pin2"),
      pinBox03 = $("#pin3"),
      pinBox04 = $("#pin4"),
      errorMsgLogin = $("#errorMsgLogin"),
      errorMsgLogin2 = $("#errorMsgLogin2"),
      errorMsgLogin3 = $("#errorMsgLogin3"),
      errorMsgLogin4 = $("#errorMsgLogin4"),
      numberValidation = $("#username"),
      numberValidation2 = $("#username2"),
      termsCheckboxLogin = $('#login_check input[type="checkbox"]'),
      loginPopup = $("#loginPopup"),
      openLoginPopup2 = $("#openLoginPopup2"),
      closeLoginPopupBtn = $(".loginPopupClose"),
      authenticationScreen2 = $(".authentication_screen2"),
      authenticationScreen3 = $(".authentication_screen3"),
      loginContent = $(".login_content");

// Function to send OTP for login
function sendOtpForLogin(phone, type) {
    $.ajax({
        type: "POST",
        url: "/otp/send",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            phone: phone,
            type: type,
        },
        dataType: "json",
        success: (response) => {
            if (response.status === 0 && type === "login_otp") {
                errorMsgLogin.text(response.message).removeClass("d-none");
            } else if (response.status === 1 && type === "resend_login_otp") {
                $("#resend-otp_login").hide();
                $("#time2").show();
                countdown2();
            } else {
                errorMsgLogin2.addClass("d-none");
                loginContent.hide();
                authenticationScreen2.show();
                otpBox01.focus();
                countdown2();
            }
        },
        error: (response) => {
            errorMsgLogin2.text(response).removeClass("d-none");
        }
    });
}


// Countdown function for OTP resend
function countdown2() {
    let timeLeft = 120;
    const timer = setInterval(function () {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        if (timeLeft <= 0) {
            clearInterval(timer);
            $("#resend-otp_login").show();
            $("#time2").hide();
        } else {
            $("#time2").text(`RESENT OTP IN ${minutes}m ${seconds}s`);
            timeLeft--;
        }
    }, 1000);
}

// OTP input field handling
otpInputs2.on("input", function (event) {
    const index = otpInputs2.index(this);
    if (event.target.value.length === 1) {
        if (index < otpInputs2.length - 1) {
            otpInputs2.eq(index + 1).focus();
        }
    } else if (event.target.value.length === 0) {
        if (index > 0) {
            otpInputs2.eq(index - 1).focus();
        }
    }
});

otpInputs2.on("keydown", function (event) {
    const index = otpInputs2.index(this);
    if (event.key === "Backspace" && event.target.value.length === 0 && index > 0) {
        otpInputs2.eq(index - 1).focus();
    }
});

otpInputs2.on("keypress", function (event) {
    if ($(this).val().length >= 1) {
        event.preventDefault();
    }
});

// Event to handle OTP submission
otpBox04.on("input", function () {
    if (otpBox01.val() && otpBox02.val() && otpBox03.val() && otpBox04.val()) {
        const phone = numberValidation.val();
        const otp = otpBox01.val() + otpBox02.val() + otpBox03.val() + otpBox04.val();
        $.ajax({
            type: "POST",
            url: "/login/validate",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                mobile: phone,
                otp: otp,
            },
            dataType: "json",
            success: (response) => {
                if (response.status === 1) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else {
                        location.reload();
                    }
                } else {
                    errorMsgLogin2.text(response.message).removeClass("d-none");
                }
            },
            error: (response) => {
                errorMsgLogin2.text(JSON.stringify(response)).removeClass("d-none");
            }
        });
    }
});

pinBox04.on("input", function () {
    if (pinBox01.val() && pinBox02.val() && pinBox03.val() && pinBox04.val()) {
        const phone = numberValidation2.val();
        const pin = pinBox01.val() + pinBox02.val() + pinBox03.val() + pinBox04.val();
        $.ajax({
            type: "POST",
            url: "/login/validate",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                mobile: phone,
                userPin: pin,
                type:2
            },
            dataType: "json",
            success: (response) => {
                if (response.status === 1) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else {
                        location.reload();
                    }
                } else {
                    errorMsgLogin3.text(response.message).removeClass("d-none");
                }
            },
            error: (response) => {
                errorMsgLogin3.text(JSON.stringify(response)).removeClass("d-none");
            }
        });
    }
});

// Resend OTP button functionality
$("#resend-otp_login").click(() => {
    sendOtpForLogin(numberValidation.val(), "resend_login_otp");
});

// Login button functionality
$("#loginOtpBtn").on("click", function () {
    const phoneNumber = numberValidation.val();
    if (phoneNumber.length === 0) {
        errorMsgLogin.text("Please Enter Mobile Number").removeClass("d-none");
    } else if (phoneNumber.length !== 10) {
        errorMsgLogin.text("Please Enter only 10 digits").removeClass("d-none");
    } else if (termsCheckboxLogin.prop("checked")) {
        $.ajax({
            type: "POST",
            url: "/api/check-user-exist",
            data: {
                phone: phoneNumber,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: (response) => {
                if (response.status === 0) {
                    errorMsgLogin.text("User Not Exists.").removeClass("d-none");
                } else {
                    sendOtpForLogin(phoneNumber, "login_otp");
                }
            },
            error: (response) => {
                errorMsgLogin.text(response).removeClass("d-none");
            }
        });
        $("#phoneNumberSpan2").text("+91" + phoneNumber);
    } else {
        errorMsgLogin.text("Please accept the Terms and Privacy Policy").removeClass("d-none");
    }
});

$("#loginOtpBtn2").on("click", function () {
    const phoneNumber = numberValidation2.val();
    if (phoneNumber.length === 0) {
        errorMsgLogin4.text("Please Enter Mobile Number").removeClass("d-none");
    } else if (phoneNumber.length !== 10) {
        errorMsgLogin4.text("Please Enter only 10 digits").removeClass("d-none");
    } else if (termsCheckboxLogin.prop("checked")) {
        $.ajax({
            type: "POST",
            url: "/api/check-user-exist",
            data: {
                phone: phoneNumber,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: (response) => {
                if (response.status === 0) {
                    errorMsgLogin4.text("User Not Exists.").removeClass("d-none");
                } else {
                    loginContent.hide();
                    authenticationScreen3.show();
                    
                }
            },
            error: (response) => {
                errorMsgLogin4.text(response).removeClass("d-none");
            }
        });
        $("#phoneNumberSpan2").text("+91" + phoneNumber);
    } else {
        errorMsgLogin4.text("Please accept the Terms and Privacy Policy").removeClass("d-none");
    }
});

// Open and close login popup functionality
function openPopup(popupElement, openButton, closeButton) {
    if (openButton) {
        openButton.on("click", function () {
            popupElement.css("display", "block");
            loginContent.show();
            authenticationScreen2.hide();
            otpBox01.val("");
            otpBox02.val("");
            otpBox03.val("");
            otpBox04.val("");
            errorMsgLogin.addClass("d-none");
            errorMsgLogin2.addClass("d-none");
        });
    }

    if (closeButton) {
        closeButton.on("click", function () {
            popupElement.css("display", "none");
        });
    }

    $(document).on("click", function (event) {
        if ($(event.target).is(popupElement)) {
            closePopup(popupElement);
        }
    });

    $(document).on("keydown", function (event) {
        if (event.key === "Escape") {
            closePopup(popupElement);
        }
    });
}

function closePopup(popupElement) {
    popupElement.css("display", "none");
}

openPopup(loginPopup, openLoginPopup2, closeLoginPopupBtn);

// Handle profile modal and search icon
$(document).ready(function () {
    $('#loginWithOtpBtn').addClass('pin_active').removeClass('pin_inactive');
    $('#loginWithPinBtn').addClass('pin_inactive').removeClass('pin_active');

    $(".profile_wrapper").click(function (event) {
        if (event.target === this) {
            $(".profile_modal").hide();
            $(this).hide();
            $("#helpButton").show();
            $(".scroll_icon").show();
        }
    });

    $(".profile_modal").click(function (event) {
        event.stopPropagation();
    });

    $("#search_icon").on("click", function () {
        $("#mob_search_display").toggle();
    });

    $('#loginWithOtpBtn').on("click", () => {
        $('.login_with_otp').show();
        $('.login_with_pin').hide();
        $('#loginWithOtpBtn').addClass('pin_active').removeClass('pin_inactive');
        $('#loginWithPinBtn').addClass('pin_inactive').removeClass('pin_active');
    });

    $('#loginWithPinBtn').on("click", () => {
        $('.login_with_otp').hide();
        $('.login_with_pin').show();
        $('#loginWithPinBtn').addClass('pin_active').removeClass('pin_inactive');
        $('#loginWithOtpBtn').addClass('pin_inactive').removeClass('pin_active');
    });

    $("#go_back").click(function(){
        $(".authentication_screen3").hide();
        loginContent.show();
        $('.login_with_pin').show();
    })

    $("#go_back_otp").click(function(){
        $(".authentication_screen2").hide();
        loginContent.show();
        $('.login_with_otp').show();
    })
});

// Geolocation
$("#btn-location").click(function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const coordinates = `${latitude},${longitude}`;
                alert(coordinates);
            },
            function (error) {
                console.log(error);
            }
        );
    } else {
        console.error("Geolocation is not supported by this browser.");
    }

});
