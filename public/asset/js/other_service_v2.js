$(document).ready(function () {
  let service = "";
  $("#details_desc").val("");

  let localStorageLatitude = localStorage.getItem("latitude");
  let localStorageLongitude = localStorage.getItem("longitude");

  if (localStorageLatitude && localStorageLongitude) {
    latitude = localStorageLatitude;
    longitude = localStorageLongitude;
  } else if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    console.error("Geolocation is not supported by this browser.");
  }

  function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
  }

  function showError(error) {
    switch (error.code) {
      case error.PERMISSION_DENIED:
        console.error("User denied the request for Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        console.error("Location information is unavailable.");
        break;
      case error.TIMEOUT:
        console.error("The request to get user location timed out.");
        break;
      case error.UNKNOWN_ERROR:
        console.error("An unknown error occurred.");
        break;
    }
  }

  $(".view-details").on("click", function () {
    service = $(this).data("service");
    $("#whatsappModalLabel").html(`Contact for ${service}`)
    $("#details_desc").val("");
    $(
      "input[name='name'], input[name='email'], input[name='phone'], input[name='description']"
    ).val("");
    $("#formError").hide();
    $("#whatsappModal").modal("show");
  });

  $("#close_whatsapp").on("click", function () {
    $("#whatsappModal").modal("hide");
  });

  $(document).on("click", "#formSubmitButton", function (event) {
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name").val().trim(),
      userEmail = $("#details_email").val().trim(),
      userPhone = $("#details_phone").val().trim(),
      userMessage = $("#details_desc").val().trim();

    userMessage += " (" + service + ")";

    if (!validateCaptcha()) {
      isValid = false;
      errorMessage = "Captcha is invalid. ";
  }

    if (!userMessage) {
      isValid = false;
      errorMessage = "Description is required. ";
    }
    if (!userPhone) {
      isValid = false;
      errorMessage = "Phone number is required. ";
    } else if (!validatePhone(userPhone)) {
      isValid = false;
      errorMessage = "Please enter a valid 10 digit phone number. ";
    }
    if (!userEmail) {
      isValid = false;
      errorMessage = "Email is required. ";
    } else if (!validateEmail(userEmail)) {
      isValid = false;
      errorMessage = "Please enter a valid email address. ";
    }
    if (!userName) {
      isValid = false;
      errorMessage = "Name is required. ";
    }

    if (isValid) {
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);
      $.ajax({
        url: "/api/buy-our-services",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
          service: service,
        },
        beforeSend: function () {
          $("#formSubmitButton").text("Sending...!!!").prop("disabled", true);
        },
        success: function (response) {
          $("#whatsappModal").modal("hide");

          // Append success message to the body
          $("body").append(`
                        <div class="confirm-box" style="z-index: 1000;">
                            <div class="confirm-backdrop"></div> 
                            <div class="confirm-content">
                                <div class="confirm-body">
                                    <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt=""></figure>
                                    <h6>Your enquiry has been submitted successfully</h6>
                                    <div class="details_msg">
                                        <div style="margin-top:-1rem">
                                          <p>We've sent your details to our support team. They will call you back soon.
                                        </div>
                                        <div class="d-flex justify-content-start align-items-start gap-1">
                                           <h6 style="color: #FB5D52;">Name:</h6>
                                           <h6 class="text-capitalize">${userName}</h6>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-start gap-1">
                                           <h6 style="color: #FB5D52;">Email:</h6>
                                           <h6>${userEmail}</h6>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-start gap-1">
                                           <h6 style="color: #FB5D52;">Phone:</h6>
                                           <h6>${userPhone}</h6>
                                        </div>

                                    </div>
                                </div>
                                <div class="confirm-footer flex-wrap">
                                    <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                                        <button class="get_back btn btn-success" id="contact_support">
                                            <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Contact Support Head
                                        </button>
                                    </div>
                                    <div>
                                        <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

          $("#formSubmitButton").text("Send").prop("disabled", false);
        },
        error: function (xhr, status, error) {
          // Handle error response
          $("#formError")
            .text("An error occurred: " + xhr.responseText)
            .show();
          $("#formSubmitButton").text("Send").prop("disabled", false);
        },
      });
    } else {
      $("#formError").text(errorMessage).show();
    }
  });

  function validatePhone(phone) {
    return /^\d{10}$/.test(phone);
  }

  function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(String(email).toLowerCase());
  }

  $(document).on("click", ".get_back", function () {
    $("#detalis_desc").val("");
    $("#details_name").val("");
    $("#details_email").val("");
    $("#details_phone").val("");
    $(this).closest(".confirm-box").hide();
  });

  $(document).on("click", ".confirm-backdrop", function () {
    $("#detalis_desc").val("");
    $("#details_name").val("");
    $("#details_email").val("");
    $("#details_phone").val("");
    $(this).closest(".confirm-box").hide();
  });

  $(document).on("click", "#contact_support", function () {
    let userName = sessionStorage.getItem("userName");
    let userEmail = sessionStorage.getItem("userEmail");
    let userPhone = sessionStorage.getItem("userPhone");
    let userMessage = sessionStorage.getItem("userMessage");

    // Construct the WhatsApp message
    let whatsappMessage = `Additional Info\nName: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\nDescription: ${userMessage}\n------------------------------\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    // Open the WhatsApp chat window with the pre-filled message
    window.open(
      `https://api.whatsapp.com/send?phone=+918826450360&text=${encodedMessage}`,
      "_blank"
    );
    sessionStorage.clear();
  });

  function generateMathCaptcha() {
    const num1 = Math.floor(Math.random() * 10);
    const num2 = Math.floor(Math.random() * 10);
    const question = `${num1} + ${num2} = ?`;
    $('#mathCaptcha').text(question);
    return num1 + num2; // Return the answer for validation
}

let correctAnswer = generateMathCaptcha();

function validateCaptcha() {
    const userAnswer = $('#captchaInput').val();
    if (parseInt(userAnswer) !== correctAnswer) {
        refreshCaptcha();
        return false;
    }
    return true;
}

function refreshCaptcha() {
    correctAnswer = generateMathCaptcha();
    $('#captchaInput').val('');
}

$('.captcha-refresh').on('click', function() {
  refreshCaptcha();
});
});
