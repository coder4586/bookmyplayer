let url = `${window.location.origin}/${window.location.pathname}`;
let latitude;
let longitude;
let countdownTimer;
let otpInputs3 = $(".mob_otp_input3");
let otpBox11 = $("#otp100");
let otpBox22 = $("#otp200");
let otpBox33 = $("#otp300");
let otpBox44 = $("#otp400");

let localStorageLatitude = localStorage.getItem("latitude");
let localStorageLongitude = localStorage.getItem("longitude");

if (localStorageLatitude && localStorageLongitude) {
  latitude = localStorageLatitude;
  longitude = localStorageLongitude;
} else {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  }
}

function showPosition(position) {
  latitude = position.coords.latitude;
  longitude = position.coords.longitude;

  localStorage.setItem("latitude", latitude);
  localStorage.setItem("longitude", longitude);
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      console.log("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      console.log("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      console.log("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      console.log("An unknown error occurred.");
      break;
  }
}

let whatsappNumber;

function showLoadingIndicator() {
  $("#loading-indicator").removeClass("d-none");
}

function hideLoadingIndicator() {
  $("#loading-indicator").addClass("d-none");
}

$("#detect-location-coach").click(function () {
  if (!("geolocation" in navigator)) {
    console.error("Geolocation is not supported by this browser.");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    function (position) {
      const { latitude, longitude } = position.coords;
      // Redirect to the desired URL with lat and lng as parameters
      window.location.href = `/nearby-coaches/${latitude}/${longitude}`;
    },
    function (error) {
      const messages = {
        1: "Permission denied. Please allow location access.",
        2: "Location information is unavailable.",
        3: "The request to get user location timed out.",
      };
      alert(messages[error.code] || "An unknown error occurred.");
    },
    {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0,
    }
  );
});

showLoadingIndicator();
get_coach_listing(1);

// $(window).on("click", function (event) {
//   if ($(event.target).is(modal)) {
//     modal.hide();
//   }
// });

function get_coach_listing(page) {
  $.ajax({
    url: `${url}`,
    type: "GET",
    async: true,
    data: { page: page },
    success: function (response) {
      let listing = "";

      if (response.coaches.length > 0) {
        response.coaches.forEach(function (coach) {
          const skillsArray = coach.skill ? coach.skill.split(",") : ["coach"];
          const photosArray = coach.photos ? coach.photos.split(",") : [];
          whatsappNumber = response.whatsapp_no;
          let skillhtml = ``;
          let photoHTML = '<div class="carousel">';
          let profileImage = coach.profile_img;

          skillsArray.forEach((skill) => {
            skillhtml += `<li>${skill.trim()}</li>`;
          });

          if (profileImage) {
            photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${coach.id}/${profileImage}" loading="lazy" alt="Profile Image"> </div>`;
          } else {
            photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg" loading="lazy" alt="Profile Image"> </div>`;
          }

          photoHTML += "</div>";

          listing += `
                <div class="col-lg-6">
                    <div class="coache-box">
                          <a href="${coach.url}" target="_blank">
                        <div class="top">
                            <figure>
                                <div class="coaches-js">
                                    ${photoHTML}
                                </div>
                                <span class="recommended">Recommended</span>
                            </figure>
                            <aside>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating">
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/star-rating.svg" loading="lazy" alt="Star" width="17" height="17">
                                        <strong>${
                                          Math.floor(Math.random() * 5) + 1
                                        }</strong> (${
            Math.floor(Math.random() * 25) + 1
          })
                                    </div>
                                    <div class="verified" title="Verified">
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/verified.svg" loading="lazy" alt="Verified Icon" width="17" height="17">
                                    </div>

                                </div>
                                    <div style="font-weight:700" class="text-capitalize">${
                                      coach.name ? coach.name : "-"
                                    }</div>
                                <p class="text-capitalize"><strong>${
                                  coach.sport == null ||
                                  coach.sport == "select" ||
                                  coach.sport == ""
                                    ? "sport"
                                    : coach.sport
                                }</strong></p>
                                <div class="d-flex justify-content-start align-items-start text-capitalize">
                                    <p>${
                                      coach.city && coach.city !== "select"
                                        ? coach.city
                                        : ""
                                    }${
            coach.city &&
            coach.state &&
            coach.city !== "select" &&
            coach.state !== "select"
              ? ", "
              : ""
          }${coach.state && coach.state !== "select" ? coach.state : ""}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <div class="prize">₹ ${
                                      coach.package ? coach.package : "-"
                                    }</div>
                                </div>
                                 <div class="free">Free Trial Class*</div>
                            </aside>
                        </div>
                        <div class="mid">
                            <div class="tags-container">
                                <ul class="tags">
                                    ${skillhtml}
                                </ul>
                                <button class="toggle-skills">More</button>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="viewed">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-viewed.svg" loading="lazy" alt="View Icon" width="14" height="14">${
                                      coach.views
                                    } people viewed since last week
                                </div>
                                <div class="graph">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-trending-up.svg" loading="lazy" alt="Trending Icon" width="20" height="20">${
                                      Math.floor(
                                        Math.random() * (80 - 20 + 1)
                                      ) + 20
                                    }%
                                </div>
                            </div>
                        </div>
                        <div class="bot">
                            <button type="button" data-action="whatsapp" data-coach-id="${
                              coach.id
                            }" data-coach-name="${
            coach.name
          }" data-coach-phone="${coach.phone}" data-coach-address="${
            coach.address1
          }" data-coach-loc="${coach.loc_id}"">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-comment.svg" loading="lazy" alt="Message Icon" width="20" height="20">Message
                            </button>
                            <button type="button" data-action="whatsapp" data-coach-id="${
                              coach.id
                            }" data-coach-name="${
            coach.name
          }" data-coach-phone="${coach.phone}" data-coach-address="${
            coach.address1
          }" data-coach-loc="${coach.loc_id}">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">WhatsApp
                            </button>
                        </div>
                    </a>
                    </div>
                </div>
            `;
        });
        window.scrollTo({ top: 0, behavior: "smooth" });
        $("#coach-listing").html(listing);
        updatePagination(response.pagination);

        hideLoadingIndicator();
      } else {
        $("#no-data-found").removeClass("d-none");
        hideLoadingIndicator();
      }
    },
  });
}

$("#prev-page, #next-page").on("click", function (e) {
  $("#coach-listing").animate({ scrollTop: 0 }, "smooth");
  let $this = $(this);
  let page = $this.data("value");

  // Prevent action for last page or first page
  if (page === null || ($this.is("#prev-page") && page === 0)) {
    e.preventDefault();
    return;
  }

  get_coach_listing(page);
});

function updatePagination(data) {
  let currentPage, isLast;

  data.forEach(function (item) {
    switch (item.name) {
      case "previous":
        $("#prev-page").data("value", item.value);
        break;
      case "current":
        currentPage = parseInt(item.value);
        $("#current-page span").text(currentPage);
        break;
      case "next":
        $("#next-page").data("value", item.value);
        break;
      case "is_last":
        isLast = item.value;
        break;
    }
  });

  if (currentPage === 1 && isLast) {
    $("#paginations").html("");
  } else {
    $("#prev-page, #next-page").show();

    if (currentPage === 1) {
      $("#prev-page").addClass("disabled");
      $("#prev-page a").html("No Previous Page");
    } else {
      $("#prev-page").removeClass("disabled");
      $("#prev-page a").html(
        '<span aria-hidden="true">&laquo;</span> Previous'
      );
    }

    if (isLast) {
      $("#next-page").addClass("disabled");
      $("#next-page a").html("No Next Page");
    } else {
      $("#next-page").removeClass("disabled");
      $("#next-page a").html('Next <span aria-hidden="true">&raquo;</span>');
    }
  }
}

$(document).on("click", ".toggle-skills", function () {
  let $tags = $(this).siblings("ul.tags");

  if ($tags.hasClass("expanded")) {
    $tags.removeClass("expanded");
    $(this).text("More");
  } else {
    $tags.addClass("expanded");
    $(this).text("Less");
  }
});

let whatsappModal = $("#whatsappModal");
let close = $("#close_whatsapp");
let coachName;
let coachLocId;
let coachPhone;
let coachAddress;
let coachObjectId;

$(document).on("click", 'button[data-action="whatsapp"]', function (e) {
  e.preventDefault();
  coachName = $(this).data("coach-name");
  coachLocId = $(this).data("coach-loc");
  coachPhone = $(this).data("coach-phone");
  coachAddress = $(this).data("coach-address");
  coachObjectId = $(this).data("coach-id");

  $("#whatsappModalLabel").text(`Contact Coach ${coachName}`);
  $("#newForm input[name='name']").val("");
  $("#newForm input[name='email']").val("");
  $("#newForm input[name='phone']").val("");
  $("#newForm textarea[name='description']").val("");

  whatsappModal.modal("show");
});

close.on("click", function () {
  whatsappModal.modal("hide");
});

$(document).on("click", "#formSubmitButton", function () {
  let isValid = true,
    errorMessage = "",
    userName = $("#details_name").val().trim(),
    userEmail = $("#details_email").val().trim(),
    userPhone = $("#details_phone").val().trim(),
    userMessage = $("#details_desc").val().trim();

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

  if (isValid) {
    // Store data in sessionStorage
    sessionStorage.setItem("userName", userName);
    sessionStorage.setItem("userEmail", userEmail);
    sessionStorage.setItem("userPhone", userPhone);
    sessionStorage.setItem("userMessage", userMessage);

    // Perform AJAX request
    $.ajax({
      url: $("#newForm").attr("action"),
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        source: "whatsapp",
        sport: $("#sport_details").val(),
        sport_id: $("#sport_id_details").val(),
        object_id: coachObjectId,
        object_type: "coach",
        loc_id: coachLocId,
        screen: "message",
        latitude: latitude,
        longitude: longitude,
        name: userName,
        email: userEmail,
        phone: userPhone,
        description: userMessage,
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
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                          <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                          <div class="details_msg">

                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52;">Name:</h6>
                                  <h6>${coachName}</h6>
                              </div>

                               ${
                                 coachAddress
                                   ? `
                                                                 <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52;">Address:</h6>
                                  <h6>${coachAddress}</h6>
                              </div>
                                `
                                   : ""
                               }



                                  ${
                                    coachPhone
                                      ? `
                                                                       <div class="d-flex justify-content-start align-items-start gap-1">
                                   <h6 style="color: #FB5D52;">Phone:</h6>
                                    <h6>${coachPhone}</h6>
                                   </div>
                                    `
                                      : ""
                                  }

                          </div>
                      </div>
                      <div class="confirm-footer flex-wrap">
                          <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                             
                          ${
                            coachPhone
                              ? `
                                                          <button class="get_back btn btn-success" id="contact_academy">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Coach
                              </button>
                            `
                              : ""
                          }

                              
                              <button class="get_back btn btn-success" id="contact_support">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Contact Support
                              </button>
                          </div>
                          <div>
                              <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                          </div>
                      </div>
                  </div>
              </div>
          `);

        // Re-enable the button and reset text
        $("#formSubmitButton").text("Send").prop("disabled", false);
        $("#details_name").val("");
        $("#details_email").val("");
        $("#details_phone").val("");
        $("#details_desc").val("");
      },
      error: function (xhr, status, error) {
        $("#formSubmitButton").text("Send").prop("disabled", false);
        $("#details_name").val("");
        $("#details_email").val("");
        $("#details_phone").val("");
        $("#details_desc").val("");
      },
    });
  } else {
    $("#formError").text(errorMessage).show();
  }
});

$("#otp_modal").click(function (event) {
  event.preventDefault();
  let isValid = true,
    errorMessage = "",
    userName = $("#details_name").val().trim(),
    userEmail = $("#details_email").val().trim(),
    userPhone = $("#details_phone").val().trim(),
    userMessage = $("#details_desc").val().trim();

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
        source: "whatsapp",
        sport: $("#sport_details").val(),
        sport_id: $("#sport_id_details").val(),
        object_id: coachObjectId,
        object_type: "coach",
        loc_id: coachLocId,
        screen: "message",
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
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                        <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                        <div class="details_msg">

                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52;">Name:</h6>
                                <h6>${coachName}</h6>
                            </div>

                             ${
                               coachAddress
                                 ? `
                                                               <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52;">Address:</h6>
                                <h6>${coachAddress}</h6>
                            </div>
                              `
                                 : ""
                             }



                                ${
                                  coachPhone
                                    ? `
                                                                     <div class="d-flex justify-content-start align-items-start gap-1">
                                 <h6 style="color: #FB5D52;">Phone:</h6>
                                  <h6>${coachPhone}</h6>
                                 </div>
                                  `
                                    : ""
                                }

                        </div>
                    </div>
                    <div class="confirm-footer flex-wrap">
                        <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                           
                        ${
                          coachPhone
                            ? `
                                                        <button class="get_back btn btn-success" id="contact_academy">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Coach
                            </button>
                          `
                            : ""
                        }

                            
                            <button class="get_back btn btn-success" id="contact_support">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Contact Support
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
        $("#otp100").focus();
        $("#modal01").show();
        $("#error_msg").text("");
        $("#error_msg").hide();
      }
      $("#otp_modal").prop("disabled", false).text("Send");
    },
    error(response) {
      $("#whatsappModal").modal("hide");
      $("#otp_modal").prop("disabled", false).text("Send");
    },
  });
}

$("#resend-otp-signup-locid").click(function () {
  let email = $("#details_email").val();
  let phone = $("#details_phone").val();
  sendOtp(phone, "identity_verification_otp", email);
});

function validateEmail(email) {
  let re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePhone(phone) {
  let re = /^\d{10}$/;
  return re.test(phone);
}

$(".verified-icon").hover(
  function () {
    $(this)
      .siblings(".tooltip")
      .css({
        display: "inline-block",
        left: $(this).position().left + $(this).width() / 2,
        top: $(this).position().top - $(this).height() / 2,
      });
  },
  function () {
    $(this).siblings(".tooltip").css("display", "none");
  }
);
document
  .getElementById("showMoreLink")
  .addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default link behavior
    document
      .getElementById("locationContainer")
      .classList.remove("show-more-height");
    document.getElementById("locationContainer").classList.add("new-height");
    this.style.display = "none"; // Hide the "More..." link
  });

$(document).on("click", ".get_back", function () {
  $("#formError").val("");
  $(this).closest(".confirm-box").hide();
});

$(document).on("click", ".confirm-backdrop", function () {
  $("#formError").val("");
  $(this).closest(".confirm-box").hide();
});

$(document).on("click", "#contact_academy", function () {
  let userName = sessionStorage.getItem("userName");
  let userMessage = sessionStorage.getItem("userMessage");

  let whatsappMessage = `Hello ${coachName},\n\nI hope this message finds you well.\n\nMy name is ${userName}.\n\n${userMessage}\n`;
  let encodedMessage = encodeURIComponent(whatsappMessage);

  window.open(
    `https://api.whatsapp.com/send?phone=+91${coachPhone}&text=${encodedMessage}`,
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

function startCountdown() {
  let timeLeft = 62;
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
$("#otp100, #otp200, #otp300, #otp400").on("input", function () {
  var e = !0;
  $("#otp100, #otp200, #otp300, #otp400").each(function () {
    if ("" === $(this).val()) return (e = !1), !1;
  }),
    e
      ? ($("#btn-signup6").prop("disabled", !1),
        $("#btn-signup6").removeClass("disable_btn"),
        $("#btn-signup6").addClass("signup_verify_btn"))
      : ($("#btn-signup6").prop("disabled", !0),
        $("#btn-signup6").addClass("disable_btn"),
        $("#btn-signup6").removeClass("signup_verify_btn"));
});

otpBox44.on("input", function () {
  // alert($("#custom_outside_latitude").val())
  // alert($("#custom_outside_longitude").val())

  if (otpBox11.val() && otpBox22.val() && otpBox33.val() && otpBox44.val()) {
    let otp = otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

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
        source: "whatsapp",
        sport: $("#sport_details").val(),
        sport_id: $("#sport_id_details").val(),
        object_id: coachObjectId,
        object_type: "coach",
        loc_id: coachLocId,
        screen: "message",
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
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                        <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                        <div class="details_msg">

                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52;">Name:</h6>
                                <h6>${coachName}</h6>
                            </div>

                             ${
                               coachAddress
                                 ? `
                                                               <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52;">Address:</h6>
                                <h6>${coachAddress}</h6>
                            </div>
                              `
                                 : ""
                             }



                                ${
                                  coachPhone
                                    ? `
                                                                     <div class="d-flex justify-content-start align-items-start gap-1">
                                 <h6 style="color: #FB5D52;">Phone:</h6>
                                  <h6>${coachPhone}</h6>
                                 </div>
                                  `
                                    : ""
                                }

                        </div>
                    </div>
                    <div class="confirm-footer flex-wrap">
                        <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                           
                        ${
                          coachPhone
                            ? `
                                                        <button class="get_back btn btn-success" id="contact_academy">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Coach
                            </button>
                          `
                            : ""
                        }

                            
                            <button class="get_back btn btn-success" id="contact_support">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Contact Support
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
