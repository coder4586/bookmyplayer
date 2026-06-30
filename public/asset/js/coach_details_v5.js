$(document).ready(function () {
$("#details_desc").val("");
  var coach_id = window.location.href.split('/').pop();
  let coachName01;
  let coachMobile;
  let coachAddress;
  let latitude;
  let longitude;
  let countdownTimer;
  let otpInputs3 = $(".mob_otp_input3");
  let otpBox11 = $("#otp10");
  let otpBox22 = $("#otp20");
  let otpBox33 = $("#otp30");
  let otpBox44 = $("#otp40");

  setTimeout(() => {
    get_coach();
  }, 5000);

  let localStorageLatitude = localStorage.getItem('latitude');
  let localStorageLongitude = localStorage.getItem('longitude');


  if(localStorageLatitude && localStorageLongitude ){
    latitude = localStorageLatitude;
    longitude = localStorageLongitude;
  }else if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
} else {
    console.error("Geolocation is not supported by this browser.");
}

function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
}

function showError(error) {
    switch(error.code) {
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

  function get_coach() {
    $.ajax({
      url: `${window.location.origin}/${coach_id}`,
      type: "GET",
      async: true,
      success: function (response) {
        let faqs = "";
        let photos = "";
        let videos = "";
        let popular_coaches = "";
        let reviews = "";

        if (response.faqs.length > 0) {
          response.faqs.forEach(function (faq, index) {
            faqs += `<div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading${index + 1
              }">
                                    <button class="accordion-button ${index === 0 ? "" : "collapsed"
              }" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapse${index + 1
              }"
                                        aria-expanded="${index === 0 ? "true" : "false"
              }"
                                        aria-controls="flush-collapse${index + 1
              }">
                                        ${index + 1}. ${faq.question}
                                    </button>
                                </h2>
                                <div id="flush-collapse${index + 1
              }" class="accordion-collapse collapse ${index === 0 ? "show" : ""
              }"
                                    aria-labelledby="flush-heading${index + 1
              }" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        ${faq.answer}
                                    </div>
                                </div>
                            </div>`;
          });
          $("#faqs").html(faqs);
        } else {
          $("#faqs").html("");
        }

        // Populate Photos
        if (response.photos.length > 0) {
          response.photos.forEach(function (photo) {
            photos += `<div class="item d-flex">
            <a href="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${photo}" 
               data-fancybox="gallery" 
               data-caption="Image ${photo}">
              <img src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${photo}" 
                   class="lazy" 
                   alt="images">
            </a>
         </div>`;

          });
          $("#photos").html(photos);
        } else {
          $("#photos").html("");
        }

        // Populate Videos
        if (response.videos.length > 0) {
          response.videos.forEach(function (video) {
            videos += `<div class="item">
            <a href="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${video}" 
               data-fancybox="gallery" 
               data-caption="Video ${video}">
              <video src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${video}" 
                     class="img-fluid" 
                     controls controlsList="nodownload">
              </video>
            </a>
         </div>`;

          });
          $("#videos").html(videos);
        } else {
          $("#videos").html("");
        }

        // Populate Popular Coaches
        if (response.popularcoaches.length > 0) {
          response.popularcoaches.forEach(function (popularcoaches) {
            let profile = popularcoaches.profile_img
              ? `https://f005.backblazeb2.com/file/bmpcdn90/coach/${popularcoaches.id}/${popularcoaches.profile_img}`
              : "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg";

            popular_coaches += `<div class="item">
                                       <a href="${popularcoaches.url}">
                                            <div class="teacher-box">
                                                <figure><img src="${profile}"  class="img-fluid" class="lazy" alt=""></figure>
                                                <article>
                                                    <h6>${popularcoaches.name}</h6>
                                                    <p><i class="fa-solid fa-location-dot"></i> ${popularcoaches.state==null ? '' : popularcoaches.state+'-' }  ${popularcoaches.city==null ? '' : popularcoaches.city}</p>
                                                    <div class="d-flex align-items-center rating"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/5star.png" class="lazy" alt="star">  </div>
                                                </article>
                                            </div>
                                          </a>
                                        </div>`;
          });
          $("#popular_coaches").html(popular_coaches);
        } else {
          $("#popular_coaches").html("");
        }

        // Populate Reviews
        if (response.reviews.length > 0) {
          response.reviews.forEach(function (review) {
            const date = new Date(review.creation_date);
            date.setHours(date.getHours() + 5);
            date.setMinutes(date.getMinutes() + 30);
            
            // Format date to "29 September 2024"
            const day = date.getDate();
            const monthNames = [
              'January', 'February', 'March', 'April', 'May', 'June',
              'July', 'August', 'September', 'October', 'November', 'December'
            ];
            const month = monthNames[date.getMonth()]; // Get month name
            const year = date.getFullYear();
            
            const formattedDate = `${day} ${month} ${year}`;
            let profile =
              "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/logo.svg";

            reviews += `<div class="card">
                                    <div class="card-header">
                                        <div class="card-image"><img src="${profile}" class="img-fluid lazy" alt="images" width="50" height="50"></div>
                                        <div class="card-info">
                                            <h6 class="text-capitalize">${review.name}</h6>
                                            <p style="visibility:hidden">.</p>
                                        </div>
                                            <div class="card-rating">
                                             <p>${formattedDate}</p>
                                            <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${Math.round(review.rating)}star.png" class="lazy" alt="star"></div>                                    </div>
                                    <div class="card-content">
                                        <p>${review.comment}</p>
                                    </div>
                                </div>`;
          });
          $("#coach-reviews").html(reviews);
        } else {
          $("#coach-reviews").html("");
        }
      },
    });

    function initializeSlider(
      scrollLeftSelector,
      scrollRightSelector,
      sliderSelector
    ) {
      let $scrollLeft = $(scrollLeftSelector);
      let $scrollRight = $(scrollRightSelector);
      let $slider = $(sliderSelector);

      $scrollLeft.click(function () {
        $slider.animate({ scrollLeft: "-=300" }, "smooth");
      });

      $scrollRight.click(function () {
        $slider.animate({ scrollLeft: "+=300" }, "smooth");
      });
    }

    initializeSlider("#scroll-left", "#scroll-right", ".certificates-js");
    initializeSlider("#scroll-left1", "#scroll-right1", "#photos");
    initializeSlider("#scroll-left2", "#scroll-right2", "#videos");
    initializeSlider("#scroll-left3", "#scroll-right3", "#popular_coaches");

  }


  $('#contact_form').on('submit', function (event) {
    var isValid = true;
    var errorMsg = '';

    $('#error-msg').text('');

    if ($('#name').val().trim() === '') {
      errorMsg = 'Please enter your Full Name.';
      isValid = false;
    } else if ($('#phone').val().trim() === '') {
      errorMsg = 'Please enter your Phone Number.';
      isValid = false;
    } else if (!validatePhone($('#phone').val().trim())) {
      errorMsg = 'Please enter a valid 10-digit Phone Number.';
      isValid = false;
    } else if ($('#email').val().trim() === '') {
      errorMsg = 'Please enter your Email.';
      isValid = false;
    } else if (!validateEmail($('#email').val().trim())) {
      errorMsg = 'Please enter a valid Email.';
      isValid = false;
    }
    else if ($('#description').val().trim() === '') {
      errorMsg = 'Please enter your Message.';
      isValid = false;
    }

    if (!isValid) {
      $('#error-msg').text(errorMsg);
      event.preventDefault();
    }else{
      $("#latitude1").val(latitude);
      $("#longitude1").val(longitude);
      $("#message_to_btn").text("Sending...!!!").prop("disabled", true);
    }
  });

  function clearForm() {
    $('#name').val('');
    $('#email').val('');
    $('#phone').val('');
    $('#error-msg').text('');
    $('#review_name').val('');
    $('#review_email').val('');
    $('#review_phone').val('');
    $('#error-msg2').text('');
  }

  $('[data-remodal-id="modal03"]').on('opening', function () {
    clearForm();
  });
  $('[data-remodal-id="modal02"]').on('opening', function () {
    clearForm();
  });

  $('#review_form').on('submit', function (event) {
    var isValid = true;
    var errorMsg = '';

    $('#error-msg2').text('');

    // Validate fields
    if ($('#review_name').val().trim() === '') {
      errorMsg = 'Please enter your full name.';
      isValid = false;
    } else if ($('#review_email').val().trim() === '') {
      errorMsg = 'Please enter your Email.';
      isValid = false;
    } else if (!validateEmail($('#review_email').val().trim())) {
      errorMsg = 'Please enter a valid Email.';
      isValid = false;
    } else if ($('#review_phone').val().trim() === '') {
      errorMsg = 'Please enter your Phone Number.';
      isValid = false;
    } else if (!validatePhone($('#review_phone').val().trim())) {
      errorMsg = 'Please enter a valid 10-digit Phone Number.';
      isValid = false;
    }

    if (!isValid) {
      $('#error-msg2').text(errorMsg);
      event.preventDefault();
    }
  });

  function validateEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  }

  function validatePhone(phone) {
    var phonePattern = /^\d{10}$/;
    return phonePattern.test(phone);
  }

  $("#copy_link_details").on("click", ()=>{
    var copyText = $('#linkInputDetails');
    
    // Select the text field
    copyText.select();
    copyText[0].setSelectionRange(0, 99999);    
    document.execCommand("copy");

    });

  
    // Open and close WhatsApp modal
    $("#openWhatsappModal").on("click", function () {
      $("input[name='name'], input[name='email'], input[name='phone']").val("");
      $("#details_desc").val("");
      $("#formError").hide();
      $("#whatsappModal").modal("show");
    });
    $("#close_whatsapp").on("click", function () {
      $("#whatsappModal").modal("hide");
    });
    $("#openWhatsappModal2").on("click", function () {
      $("input[name='name'], input[name='email'], input[name='phone']").val("");
      $("#details_desc").val("");
      $("#formError").hide();
      $("#whatsappModal").modal("show");
    });
    $("#close_whatsapp").on("click", function () {
      $("#whatsappModal").modal("hide");
    });
  
    $("#otp_modal").click(function (event) {
      event.preventDefault();
      academyTitle = $("#listing_title2").val();
      academyPhoneNumber = $("#academy_phone2").val();
      academyAddress = $("#academy_address2").val();
      $("#latitude1").val(latitude);
      $("#longitude1").val(longitude);
  
      let isValid = true,
      errorMessage = "",
      userName = $("#details_name").val().trim(),
      userEmail = $("#details_email").val().trim(),
      userPhone = $("#details_phone").val().trim(),
      userMessage = $("#details_desc").val().trim();
      coachName01 = $("#coachName").val().trim();
      coachMobile = $("#coachPhone").val().trim();
      coachAddress = $("#coachAddress").val().trim();

    // Validation checks
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
  
      if (!isValid) {
        $("#formError").text(errorMessage).show();
      } else {
        // Store data in sessionStorage
        sessionStorage.setItem("userName", userName);
        sessionStorage.setItem("userEmail", userEmail);
        sessionStorage.setItem("userPhone", userPhone);
        sessionStorage.setItem("userMessage", userMessage);
        $("#formError").text(errorMessage).show();


        academyTitle = $("#listing_title2").val();
        academyPhoneNumber = $("#academy_phone2").val();
        academyAddress = $("#academy_address2").val();
        $("#latitude1").val(latitude);
        $("#longitude1").val(longitude);
      $("#error_message").hide();

      $.ajax({
        url: $("#newForm").attr("action"),
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: $("#source_details").val(),
          sport: $("#sport_details").val(),
          sport_id: $("#sport_id_details").val(),
          object_id: $("#object_id_details").val(),
          object_type: $("#object_type_details").val(),
          loc_id: $("#loc_id_details").val(),
          screen: $("#screen_details").val(),
          latitude: latitude,
          longitude: longitude,
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
        },
        beforeSend: function () {
          // Disable the button and change text
          $("#otp_modal").prop("disabled", true).text("Sending...");
        },
        success: function (response) {
          // Re-enable the button and change text back
          $("#otp_modal").prop("disabled", false).text("Send");
      
          $("#whatsappModal").modal("hide");
          if (response.status == 0) {
            $("#error_msg").show();
            $("#error_msg").text(response.message);
          } else {
            $("#modal01").hide();
            $("body").append(`
              <div class="confirm-box" style="z-index: 1000;">
                  <div class="confirm-backdrop"></div> 
                  <div class="confirm-content-new">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt=""></figure>
                          <h6>Your lead has been submitted successfully</h6>
                          <div class="details_msg">
                              
                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                  <h6>${coachName01}</h6>
                              </div>
      
                              ${coachAddress ? `
                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                <h6>${coachAddress}</h6>
                            </div>` : ''}
                             
                              ${coachMobile ? `
                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                <h6>${coachMobile}</h6>
                            </div>` : ''}
                          </div>
                      </div>
                      <div class="confirm-footer flex-wrap">
                          <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                            ${coachMobile ? `
                              <button class="get_back btn btn-success" id="contact_academy">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Whatsapp Coach
                              </button>` : ''}
                              <button class="get_back btn btn-success" id="contact_support">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Contact Support
                              </button>
                          </div>
                          <div>
                              <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                          </div>
                      </div>
                  </div>
              </div>
            `);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
          console.error("XHR Status:", xhr.status); // HTTP status code (e.g., 404, 500)
      
          try {
            var response = JSON.parse(xhr.responseText);
            if (response.status == 0) {
              $("#error_msg").show();
              $("#error_msg").text(response.message);
            }
          } catch (e) {
            console.error("Parsing error:", e);
            console.error("Response Text:", xhr.responseText); // In case the response is not JSON
          }
      
          // Re-enable the button and change text back on error
          $("#otp_modal").prop("disabled", false).text("Send");
        },
      });
      
  

      }
    });

    function sendOtp(phone, type, email) {
      $.ajax({
        type: "POST",
        url: "https://www.bookmyplayer.com/otp/send",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          phone: phone,
          type: type,
          email: email,
        },
        dataType: "json",
        beforeSend: function () {
          $("#otp_modal").prop("disabled", true).text("Sending...");
        },
        success(response) {
          $("#whatsappModal").modal("hide");
          if (response.status === 0 && type === "identity_verification_otp") {
            $("body").append(`
            <div class="confirm-box" style="z-index: 1000;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                        <h6 style="text-align:center;">${response.message}</h6>
                        <div style="text-align:center">
                            <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
          } else {
            $("#time").show();
            $("#resend-otp-signup-locid").hide();
            startCountdown();
            $("#otp10").focus();
            $("#modal01").show();
            $("#error_msg").text("");
            $("#error_msg").hide();
          }
          $("#otp_modal").prop("disabled", false).text("Send");
        },
        error(response) {
          $("#whatsappModal").modal("hide");
          $("#otp_modal").prop("disabled", false).text("Send");
          console.log(response);
        },
      });
    }

    $("#resend-otp-signup-locid").click(function () {
      let email = $("#details_email").val();
      let phone = $("#details_phone").val(); 
        sendOtp(phone, "identity_verification_otp", email);
  });



    $(document).on("click", "#contact_academy", function () {
      let userName = sessionStorage.getItem("userName");
      let userMessage = sessionStorage.getItem("userMessage");
  
      let whatsappMessage = `Hello ${coachName01},\n\nI hope this message finds you well.\n\nMy name is ${userName}.\n\n${userMessage}\n`;
      let encodedMessage = encodeURIComponent(whatsappMessage);
  
      window.open(
        `https://api.whatsapp.com/send?phone=+91${coachMobile}&text=${encodedMessage}`,
        "_blank"
      );
      sessionStorage.clear();
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

    $(document).on("click", ".get_back", function () {
      $("#contact_name").val("");
      $("#email").val("");
      $("#phone").val("");
      $("#message").val("");
      $("#detalis_desc").val("");
      $('#details_name2').val('');
      $('#details_email2').val('');
      $('#details_phone2').val('');
      $('#details_desc2').val('');
      $(this).closest(".confirm-box").hide();
    });

    $(document).on("click", ".confirm-backdrop", function () {
      $("#contact_name").val("");
      $("#email").val("");
      $("#phone").val("");
      $("#message").val("");
      $("#detalis_desc").val("");
      $('#details_name2').val('');
      $('#details_email2').val('');
      $('#details_phone2').val('');
      $('#details_desc2').val('');
      $(this).closest(".confirm-box").hide();
    });

    
    // Validation functions (assuming they are defined elsewhere)
    function validatePhone(phone) {
      // Your phone validation logic here
      return /^\d{10}$/.test(phone);
    }
    
    function validateEmail(email) {
      // Your email validation logic here
      const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return re.test(String(email).toLowerCase());
    }

    $(document).on("click", ".confirm-backdrop-review", function () {
      location.reload();
    });
  
    $(document).on("click", ".review_box", function () {
      location.reload();
    });
  
    $('#openCustomModal').on('click', function() {
      $('#customModalOverlay').show();
  });
  
  
  // Close modal when X is clicked
  $('.custom-close-btn').on('click', function() {
      $('#customModalOverlay').hide(); // Hide the modal overlay
  });
  
  // Close modal when clicking outside the modal box
  $('#customModalOverlay').on('click', function(e) {
      if ($(e.target).is('#customModalOverlay')) {
          $('#customModalOverlay').hide(); // Hide the modal overlay
      }
  });

  function startCountdown() {
    let timeLeft =120;
    const endTime = Date.now() + timeLeft * 1000; // Calculate the end time

    if (countdownTimer) {
      clearInterval(countdownTimer); // Clear any existing interval
    }

    countdownTimer = setInterval(function () {
      const now = Date.now();
      const timeDiff = Math.max(0, endTime - now); // Calculate remaining time in ms
      const minutes = Math.floor(timeDiff / 60000);
      const seconds = Math.floor((timeDiff % 60000) / 1000);

      if (timeDiff <= 0) {
        clearInterval(countdownTimer);
        countdownTimer = null; // Clear the interval ID
        $("#resend-otp-signup-locid").show();
        $("#time").hide();
      } else {
        $("#time").text(`Resend OTP In ${minutes}m ${seconds}s`);
      }
    }, 1000);
  }

  $(document).on("click", ".otp_close", function () {
    $("#modal01").hide();
    $("#error_msg").text("");
    $("#error_msg").hide();
  });
  $(document).on("click", ".change_num", function () {
    $("#modal01").hide();
    $("#error_msg").text("");
    $("#error_msg").hide();
  });

  otpInputs3.on("input", function (e) {
    let o = $(".mob_otp_input3").index(this);
    1 === e.target.value.length
      ? o < $(".mob_otp_input3").length - 1 &&
        $(".mob_otp_input3")
          .eq(o + 1)
          .focus()
      : 0 === e.target.value.length &&
        o > 0 &&
        $(".mob_otp_input3")
          .eq(o - 1)
          .focus();
  });
  otpInputs3.on("keydown", function (e) {
    let o = $(".mob_otp_input3").index(this);
    "Backspace" === e.key &&
      0 === e.target.value.length &&
      o > 0 &&
      $(".mob_otp_input3")
        .eq(o - 1)
        .focus();
  });
  otpInputs3.on("keypress", function (e) {
    $(this).val().length >= 1 && e.preventDefault();
  });
  $("#otp10, #otp20, #otp30, #otp40").on("input", function () {
    var e = !0;
    $("#otp10, #otp20, #otp30, #otp40").each(function () {
      if ("" === $(this).val()) return (e = !1), !1;
    }),
      e
        ? ($("#btn-signup5").prop("disabled", !1),
          $("#btn-signup5").removeClass("disable_btn"),
          $("#btn-signup5").addClass("signup_verify_btn"))
        : ($("#btn-signup5").prop("disabled", !0),
          $("#btn-signup5").addClass("disable_btn"),
          $("#btn-signup5").removeClass("signup_verify_btn"));
  });

  otpBox44.on("input", function () {
    // alert($("#custom_outside_latitude").val())
    // alert($("#custom_outside_longitude").val())

    if (otpBox11.val() && otpBox22.val() && otpBox33.val() && otpBox44.val()) {
      let otp =
        otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();


        academyTitle = $("#listing_title2").val();
        academyPhoneNumber = $("#academy_phone2").val();
        academyAddress = $("#academy_address2").val();
        $("#latitude1").val(latitude);
        $("#longitude1").val(longitude);
     
      const contactName = $("#details_name").val().trim();
      const phone = $("#details_phone").val().trim();
      const email = $("#details_email").val().trim();
      const message = $("#details_desc").val().trim();

      sessionStorage.setItem("userName", contactName);
      sessionStorage.setItem("userEmail", email);
      sessionStorage.setItem("userPhone", phone);
      sessionStorage.setItem("userMessage", message);
      $("#error_message").hide();

      // Perform AJAX request
      $.ajax({
        url: $("#newForm").attr("action"),
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: $("#source_details").val(),
          sport: $("#sport_details").val(),
          sport_id: $("#sport_id_details").val(),
          object_id: $("#object_id_details").val(),
          object_type: $("#object_type_details").val(),
          loc_id: $("#loc_id_details").val(),
          screen: $("#screen_details").val(),
          latitude: latitude,
          longitude: longitude,
          name: contactName,
          email: email,
          phone: phone,
          description: message,
          otp:otp
        },
        success: function (response) {
          if (response.status == 0) {
            $("#error_msg").show();
            $("#error_msg").text(response.message);
          } else {
            $("#modal01").hide();
            $("body").append(`
              <div class="confirm-box" style="z-index: 1000;">
                  <div class="confirm-backdrop"></div> 
                  <div class="confirm-content-new">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt=""></figure>
                          <h6>Your lead has been submitted successfully</h6>
                          <div class="details_msg">
                              
                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                  <h6>${coachName01}</h6>
                              </div>

                              ${coachAddress ? `
                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                <h6>${coachAddress}</h6>
                            </div>` : ''}
                             
                              ${coachMobile ? `
                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                <h6>${coachMobile}</h6>
                            </div>` : ''}
                          </div>
                      </div>
                      <div class="confirm-footer flex-wrap">
                          <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                            ${coachMobile ? `
                              <button class="get_back btn btn-success" id="contact_academy">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Whatsapp Coach
                              </button>` : ''}
                              <button class="get_back btn btn-success" id="contact_support">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Contact Support
                              </button>
                          </div>
                          <div>
                              <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                          </div>
                      </div>
                  </div>
              </div>
          `);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
          console.error("XHR Status:", xhr.status); // HTTP status code (e.g., 404, 500)

          try {
            var response = JSON.parse(xhr.responseText);
            if (response.status == 0) {
              $("#error_msg").show();
              $("#error_msg").text(response.message);
            }
          } catch (e) {
            console.error("Parsing error:", e);
            console.error("Response Text:", xhr.responseText); // In case the response is not JSON
          }
        },
      });
    }
  });
  



});


