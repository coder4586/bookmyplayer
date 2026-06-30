$(document).ready(function () {
  const base_url = "https://f005.backblazeb2.com/file/bmpcdn90";
  let academyTitle;
  let academyPhoneNumber;
  let academyAddress;
  let similarSport;
  let similarSportId;
  let similarObjectId;
  let similarLatitude;
  let similarLongitude;
  let similarLocationId;
  let localStorageLatitude = localStorage.getItem("latitude");
  let localStorageLongitude = localStorage.getItem("longitude");
  let latitude;
  let longitude;
  let countdownTimer;
  let formType = 1;
  let flag = true;
  $("#details_desc").val("");
  $("#price_desc").val("");
  let url = window.location.href;
  let urlId = url.split("/").pop();
  if (urlId.includes("-")) {
    urlId = urlId.split("-").pop();
  }
  urlId = urlId.replace(/(\d+)[#\D].*/, "$1");

  let myVideo = $("#myVideo")[0];
  if (myVideo) {
    myVideo.playbackRate = 0.7;
  }

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

  //copy js

  $("#copy-button").click(function () {
    // Get the input element
    var input = $("#academy-url-input");
    // Select the input value
    input.select();
    input[0].setSelectionRange(0, 99999);
    document.execCommand("copy");
  });

  $("#copy-button2").click(function () {
    // Get the input element
    var input = $("#academy-url-input2");
    // Select the input value
    input.select();
    input[0].setSelectionRange(0, 99999);
    document.execCommand("copy");
  });

  $("#copy-button3").click(function () {
    // Get the input element
    var input = $("#academy-url-input3");
    // Select the input value
    input.select();
    input[0].setSelectionRange(0, 99999);
    document.execCommand("copy");
  });

  //whatsapp modal

  function openEnquiryModal() {
    academyTitle = $("#listing_title").val();
    $("#whatsappModalLabel").text(`Contact ${academyTitle}`);
    academyPhoneNumber = $("#academy_phone").val();
    academyAddress = $("#academy_address").val();
    $("#latitude2").val(latitude);
    $("#longitude2").val(longitude);
    $(
      "input[name='name'], input[name='email'], input[name='phone'], input[name='description']"
    ).val("");
    $("#details_desc").val("");
    $("#formError").hide();
    $("#whatsappModal").modal("show");
  }

  $("#openWhatsappModal, #openWhatsappModal2").on("click", openEnquiryModal);

  $("#close_whatsapp").on("click", function () {
    $("#whatsappModal").modal("hide");
  });

  $("#otp_modal2").click(function (event) {
    event.preventDefault();
    flag = true;
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name").val().trim(),
      userEmail = $("#details_email").val().trim(),
      userPhone = $("#details_phone").val().trim(),
      userMessage = $("#details_desc").val().trim();

    // Validation checks
    if (!userMessage) {
      isValid = false;
      errorMessage = "Message is required. ";
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
    if (errorMessage) {
      $("#formError").text(errorMessage).show();
    } else {
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);
      $("#formError").hide();

      $.ajax({
        url: "https://www.bookmyplayer.com/submit-contact-static",
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
          name: userName,
          phone: userPhone,
          email: userEmail,
          description: userMessage,
          latitude: latitude,
          longitude: longitude,
        },
        success: function (response) {
          if (response.status == 1) {
            $("#whatsappModal").modal("hide");
            $("body").append(`
                  <div class="confirm-box" style="z-index: 1000;">
                      <div class="confirm-backdrop"></div>
                      <div class="confirm-content-new">
                          <div class="confirm-body">
                              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
                              <h6>Your lead has been submitted successfully</h6>
                              <div class="details_msg">
                                  
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                      <h6>${academyTitle}</h6>
                                  </div>
      
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                      <h6>${academyAddress}</h6>
                                  </div>
                                  ${academyPhoneNumber
                ? `
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                      <h6>${academyPhoneNumber}</h6>
                                  </div>`
                : ""
              }

                              </div>
                          </div>
                          <div class="confirm-footer flex-wrap">
                              <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                              ${academyPhoneNumber
                ? `
                                  <button class="get_back btn btn-success" id="contact_academy">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Whatsapp Academy
                                  </button>`
                : ""
              }
                                  <button class="get_back btn btn-success" id="contact_support">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Contact Support
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

  // Hide confirmation box when clicking outside the box
  $(document).on("click", ".confirm-backdrop", function () {
    $("#contact_name").val("");
    $("#email").val("");
    $("#phone").val("");
    $("#message").val("");
    $("#detalis_desc").val("");
    $("#details_name2").val("");
    $("#details_email2").val("");
    $("#details_phone2").val("");
    $("#details_desc2").val("");
    $(this).closest(".confirm-box").hide();
  });

  $(document).on("click", "#contact_academy", function () {
    let userName = sessionStorage.getItem("userName");
    let userMessage = sessionStorage.getItem("userMessage");

    let whatsappMessage = `Hello ${academyTitle},\n\nI hope this message finds you well.\n\nMy name is ${userName}.\n\n${userMessage}\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    window.open(
      `https://api.whatsapp.com/send?phone=+91${academyPhoneNumber}&text=${encodedMessage}`,
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
    let whatsappMessage = `Additional Info\nAcademy id: ${urlId}\nAcademy Name: ${academyTitle}\nAcademy Url: ${url}\nName: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\nMessage: ${userMessage}\n------------------------------\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    // Open the WhatsApp chat window with the pre-filled message
    window.open(
      `https://api.whatsapp.com/send?phone=+918826450360&text=${encodedMessage}`,
      "_blank"
    );
    sessionStorage.clear();
  });

  function validatePhone(phone) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phone);
  }

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Function to open WhatsApp modal and pre-fill description
  function openWhatsAppModalTwo(title) {
    $("#whatsappModalLabel2").text(`Contact to ${title}`);
    $("#whatsappModal2").modal("show");
  }

  // Event listener for message button click
  $(document).on("click", ".message-button", function () {
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarLatitude = latitude;
    similarLongitude = longitude;
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");
    $("#details_name2").val("");
    $("#details_email2").val("");
    $("#details_phone2").val("");
    $("#details_desc2").val("");

    $.ajax({
      url: "/get-entity-contact",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        object_id: similarObjectId,
        object_type: "academy",
      },
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        academyPhoneNumber = response.phone;
        if (academyPhoneNumber.startsWith("+91")) {
          academyPhoneNumber = academyPhoneNumber.substring(3);
        } else if (academyPhoneNumber.startsWith("0")) {
          academyPhoneNumber = academyPhoneNumber.substring(1);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle any errors here
      },
    });
    openWhatsAppModalTwo(academyTitle);
  });

  $(document).on("click", ".whatsapp-button", function () {
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarLatitude = $(this).data("academy-lat");
    similarLongitude = $(this).data("academy-lng");
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");

    $.ajax({
      url: "/get-entity-contact",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        object_id: similarObjectId,
        object_type: "academy",
      },
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        academyPhoneNumber = response.phone;
        if (academyPhoneNumber.startsWith("+91")) {
          academyPhoneNumber = academyPhoneNumber.substring(3);
        } else if (academyPhoneNumber.startsWith("0")) {
          academyPhoneNumber = academyPhoneNumber.substring(1);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle any errors here
      },
    });
    openWhatsAppModalTwo(academyTitle);
  });

  $("#otp_modal3").click(function (event) {
    event.preventDefault();
    flag = false;
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name2").val().trim(),
      userEmail = $("#details_email2").val().trim(),
      userPhone = $("#details_phone2").val().trim(),
      userMessage = $("#details_desc2").val().trim();

    // Validation checks
    if (!userMessage) {
      isValid = false;
      errorMessage = "Message is required. ";
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
    if (errorMessage) {
      $("#formError2").text(errorMessage).show();
    } else {
      // Store data in sessionStorage
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);
      $("#formError2").hide();

      $.ajax({
        url: "https://www.bookmyplayer.com/submit-contact-static",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: $("#source_details3").val(),
          sport: $("#sport_details3").val(),
          sport_id: $("#sport_id_details3").val(),
          object_id: $("#object_id_details3").val(),
          object_type: $("#object_type_details3").val(),
          loc_id: $("#loc_id_details3").val(),
          screen: $("#screen_details3").val(),
          name: userName,
          phone: userPhone,
          email: userEmail,
          description: userMessage,
          latitude: latitude,
          longitude: longitude,
        },
        success: function (response) {
          if (response.status == 1) {
            $("#whatsappModal2").modal("hide");
            $("body").append(`
                  <div class="confirm-box" style="z-index: 1000;">
                      <div class="confirm-backdrop"></div>
                      <div class="confirm-content-new">
                          <div class="confirm-body">
                              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
                              <h6>Your lead has been submitted successfully</h6>
                              <div class="details_msg">
                                  
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                      <h6>${academyTitle}</h6>
                                  </div>
      
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                      <h6>${academyAddress}</h6>
                                  </div>
                                  ${academyPhoneNumber
                ? `
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                      <h6>${academyPhoneNumber}</h6>
                                  </div>`
                : ""
              }

                              </div>
                          </div>
                          <div class="confirm-footer flex-wrap">
                              <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                              ${academyPhoneNumber
                ? `
                                  <button class="get_back btn btn-success" id="contact_academy">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Whatsapp Academy
                                  </button>`
                : ""
              }
                                  <button class="get_back btn btn-success" id="contact_support">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Contact Support
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

  $("#close_whatsapp2").on("click", function () {
    $("#details_name2").val("");
    $("#details_email2").val("");
    $("#details_phone2").val("");
    $("#details_desc2").val("");
    $("#whatsappModal2").modal("hide");
  });

  //delay

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

  initializeSlider("#scroll-left1", "#scroll-right1", ".photos-js");
  initializeSlider("#scroll-left2", "#scroll-right2", ".videos-js");
  initializeSlider("#scroll-left4", "#scroll-right4", ".videos-other-js");
  initializeSlider("#scroll-left3", "#scroll-right3", ".similar-academies-js");

  function otherLocalities() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "otherLocalities",
      },
      success: function (response) {
        if (response.otherLocalities && response.otherLocalities.length > 0) {
          $(".academy-near-location").removeClass("hidden");
          $(".other-links-section").removeClass("hidden");
          let otherLocalitiesHtml = "";
          response.otherLocalities.forEach(function (locality, index) {
            otherLocalitiesHtml += `
            <div class="location">
              <aside>${index + 1}</aside>
              <div class="info_on_img">
                <img src="${base_url}/asset/images/build_icon_${(index % 8) + 1
              }.png" loading="lazy" alt="Near Locations" class="grey_border">
                <div class="image_text">
                  <span class="sample_hd">Academy</span>
                  <div class="hd">
                    <span>City</span>
                  </div>
                </div>
                <div class="count_local">
                  <span>${locality.views ? locality.views : "0"}</span>
                </div>
              </div>
              <article>
                <h6><a href="${locality.url}">${locality.locality_name ? locality.locality_name : ""
              }</a></h6>
                <p class="text-capitalize">${locality.locality_name ? locality.locality_name : ""
              }${locality.locality_name && locality.city
                ? ", " + locality.city
                : ""
              }</p>
              </article>
            </div>`;
          });
          $(".height500.scrollbar").html(otherLocalitiesHtml);

          let otherLinkHtml = "";

          response.otherLocalities.forEach(function (locality) {
            let locationDisplay =
              locality.locality_name.toLowerCase() ===
                locality.city.toLowerCase()
                ? locality.city
                : `${locality.locality_name}, ${locality.city}`;

            if (
              locality.sport.toLowerCase() === "gym" ||
              locality.sport.toLowerCase() === "personal-trainer"
            ) {
              otherLinkHtml += `
                <li class="text-capitalize other_link_li">
                  <a href="${locality.url}" class="text-capitalize">
                    ${locality.sport} In ${locationDisplay}
                  </a>
                </li>
              `;
            } else {
              otherLinkHtml += `
                <li class="text-capitalize other_link_li">
                  <a href="${locality.url}" class="text-capitalize">
                    ${locationDisplay}
                  </a>
                </li>
              `;
            }
          });

          $(".other_links").html(otherLinkHtml);
        }

        // Hide loader images after content is loaded
        $(".loader_img3").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img3").hide();
      },
    });
  }

  function media() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
      },
      success: function (response) {
        if (
          response.photos &&
          response.photos.length > 0 &&
          response.photos[0] !== ""
        ) {
          $(".photos-box").removeClass("hidden");
          $(".photo_count").html(response.photos.length);
          let htmlContent = "";
          response.photos.forEach(function (photo) {
            htmlContent += `
            <div class="item academy_img">
              <div class="sport_card">
                <a href="${base_url}/academy/${urlId}/${photo}" data-fancybox="photos-gallery" data-caption="">
                  <img src="${base_url}/academy/${urlId}/${photo}" class="img-fluid" loading="lazy" alt="Academy Images"  onerror="this.onerror=null; this.src='${base_url}/asset/images/home-banner.png';">
                </a>
              </div>
            </div>`;
          });
          $(".photos-js").html(htmlContent);
        }

        if (
          response.videos &&
          response.videos.length > 0 &&
          response.videos[0] !== ""
        ) {
          $(".videos-box").removeClass("hidden");
          $(".video_count").html(response.videos.length);
          let videoHtmlContent = "";
          response.videos.forEach(function (video) {
            videoHtmlContent += `
            <div class="item academy_img">
              <div class="sport_card">
                <a data-fancybox="photos-gallery" href="${base_url}/academy/${urlId}/${video}" class="fancybox" type="video/mp4">
                  <video controls controlsList="nodownload" class="fast_track">
                    <source src="${base_url}/academy/${urlId}/${video}" type="video/mp4">
                  </video>
                </a>
              </div>
            </div>`;
          });
          // Append generated HTML to .videos-js container
          $(".videos-js").html(videoHtmlContent);
        }
        // Hide loader images after content is loaded
        $(".loader_img4").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img4").hide();
      },
    });
  }
  function about() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "about",
      },
      success: function (response) {
        if (response.about) {
          $(".about-box").removeClass("hidden");
          $(".about_academy").html(response.about);

          $(".about_academy ul, .about_academy ol").css({
            "list-style": "disc",
            "padding-left": "40px",
            "margin-top": "-12px",
            "margin-bottom": "10px",
          });

          $(".about_academy ul li, .about_academy ol li").css({
            "margin-bottom": "5px",
            "font-size": "16px",
            color: "#555",
          });

          $(".about_academy h3").css({
            "font-size": "20px",
            "margin-bottom": "1rem",
          });
          $(".about_academy h2").css({
            "font-size": "24px",
          });
          $(".about_academy h1").css({
            "font-size": "30px",
          });

          $(
            ".about_academy ul:last-of-type li:last-child, .about_academy ol:last-of-type li:last-child"
          ).css({
            "margin-bottom": "25px",
          });
        }
        $(".loader_img10").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img10").hide();
      },
    });
  }

  function reviews() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "reviews",
      },
      success: function (response) {
        if (response.reviews && response.reviews.length > 0) {
          $(".academy_review_count").text(`(${response.reviewCount})`);
          response.reviews.forEach(function (review) {
            const reviewCard = `
                <div class="card">
                    <div class="card-header">
                        <div class="card-image">
                            <img src="${base_url}/asset/images/mob_reply.svg" class="img-fluid review_img" loading="lazy" alt="Reply Icon">
                        </div>
                        <div class="card-info">
                            <h6 class="text-capitalize">${review.name}</h6>
                        </div>
                        <div class="card-rating">
                             <p>${review.creation_date}</p>
                            <img src="${base_url}/asset/images/${review.rating}star.png" 
     loading="lazy" 
     alt="Stars" 
     width="64" 
     height="12"
     onerror="this.onerror=null; this.src='${base_url}/asset/images/4star.png';">

                        </div>
                    </div>
                    <div class="card-content">
                        <p>${review.comment}</p>
                    </div>
                </div>
            `;
            $(".reviews-box").append(reviewCard); // Assuming the reviews will be appended inside a container with class 'reviews-container'
          });
        }

        // Hide loader images after content is loaded
        $(".loader_img5").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img5").hide();
      },
    });
  }
  function aiReviews() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "ai_reviews",
      },
      success: function (response) {
        if (response.positive && response.positive.length > 0) {
          $(".facilities-box").removeClass("hidden");
          let positiveHtml = "<p><strong>Positive:</strong>";
          let posetiveBanner = "";
          response.positive.forEach(function (positive, index) {
            positiveHtml += `<span class="customer_option text-capitalize">${positive}</span>`;
            posetiveBanner += positive;
            if (index < response.positive.length - 1) {
              posetiveBanner += " | ";
            }
          });

          positiveHtml += "</p>";
          $(".facilities-box").append(positiveHtml);
          $(".banner_posetive").html(posetiveBanner);
        } else {
          $(".banner_posetive").html(
            "Fitness | Well Maintained |  Professional Coaching"
          );
        }

        if (response.negative && response.negative.length > 0) {
          $(".facilities-box").removeClass("hidden");
          let negativeHtml = "<p><strong>Negative:</strong>";
          response.negative.forEach(function (negative) {
            negativeHtml += `<span class="customer_option text-capitalize">${negative}</span>`;
          });
          negativeHtml += "</p>";
          $(".facilities-box").append(negativeHtml);
        }

        // Check if neutral feedback exists and append it
        if (response.neutral && response.neutral.length > 0) {
          $(".facilities-box").removeClass("hidden");
          let neutralHtml = "<p><strong>Neutral:</strong>";
          response.neutral.forEach(function (neutral) {
            neutralHtml += `<span class="customer_option text-capitalize">${neutral}</span>`;
          });
          neutralHtml += "</p>";
          $(".facilities-box").append(neutralHtml);
        }

        $(".loader_img6").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img6").hide();
      },
    });
  }

  aiReviews();

  function similarAcademies() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "nearbyacademies",
      },
      success: function (response) {
        if (response.nearbyacademies && response.nearbyacademies.length > 0) {
          $(".similar-academies-section").removeClass("hidden");
          let nearbyAcademiesHtml = "";
          response.nearbyacademies.forEach(function (academy) {
            if (academy.name !== response.currentAcademyName) {
              // Avoid showing the current academy
              let photosHtml = "";

              // Handle photos for each nearby academy
              if (academy.photos && academy.photos.length > 0) {
                let photoArray = academy.photos.split(",");
                photosHtml = `
                <div class="item near_academy_img">
<img 
    src="${base_url}/academy/${academy.id}/${photoArray[0]}" 
    loading="lazy" 
    alt="Academy Images"
    onerror="this.onerror=null; this.src='${photoArray[1]
                    ? `${base_url}/academy/${academy.id}/${photoArray[1]}`
                    : `${base_url}/default/${academy.sport}_banner.webp`
                  }'; this.onerror=function() { this.src='${base_url}/default/${academy.sport
                  }_banner.webp'; };">

                </div>`;
              } else {
                // Default image if no photos are available
                photosHtml = `
                <div class="item near_academy_img">
                  <img src="${base_url}/default/${academy.sport}_banner.webp" loading="lazy" alt="Academy Images">
                </div>`;
              }

              nearbyAcademiesHtml += `
              <div class="item academyitem">
                <div class="sport_card">
                  
                    <div class="academy-box">
                    <a href="${academy.url}">
                      <div class="top">
                        <figure>
                          <div class="coaches-js">
                            ${photosHtml}
                          </div>
                          <span class="recommended">Recommended</span>
                        </figure>
                        <aside>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="rating">${academy.sport.charAt(0).toUpperCase() +
                academy.sport.slice(1)
                }</div>
                            <div class="verified"><img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verified Icon" width="16" height="17"> Verified</div>
                          </div>
                          <h6 class="trim_name">${academy.name}</h6>
                          <p class="trim_name"><i class="fa-solid fa-location-dot"></i> ${[
                  academy.address1,
                  academy.address2,
                  academy.city,
                  academy.state,
                  academy.postcode,
                ]
                  .filter(Boolean)
                  .join(", ")}</p>
                          <p><i class="fa-regular fa-clock"></i> Monday To Sunday</p>
                          <div class="prize trim_name">
                            ₹${academy.fee || academy.default_pricing || "-"}
                          </div>
                        </aside>
                      </div>
                      <div class="mid">
                        <ul class="tags">
                          <span class="read-more-content">
                            <ul class="tags">
                              <li>Kids</li>
                              <li>Coaching</li>
                              <li>Women Friendly</li>
                            </ul>
                          </span>
                        </ul>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="viewed"><img src="${base_url}/asset/images/icon-viewed.svg" loading="lazy" alt="View Icon" width="14" height="14"> ${academy.views || 0
                } people viewed since last week</div>
                          <div class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trending Icon" width="14" height="14"> ${academy.views || 0
                }%</div>
                        </div>
                      </div>
                      </a>
                      <div class="bot">
                        <button type="button" class="message-button" data-academy-name="${academy.name
                }" data-academy-phone="${academy.phone
                }" data-academy-lat="${academy.lat}" data-academy-lng="${academy.lng
                }" data-academy-locid="${academy.loc_id}" data-academy-sport="${academy.sport
                }" data-academy-sportid="${academy.sport_id
                }" data-academy-address="${academy.address1
                }" data-academy-objectid="${academy.id}">
                          <img src="${base_url}/asset/images/icon-comment.svg" loading="lazy" alt="Message Icon" width="20" height="20">Message
                        </button>
                        <button type="button" class="whatsapp-button" data-academy-name="${academy.name
                }" data-academy-phone="${academy.phone
                }" data-academy-lat="${academy.lat}" data-academy-lng="${academy.lng
                }" data-academy-locid="${academy.loc_id}" data-academy-sport="${academy.sport
                }" data-academy-sportid="${academy.sport_id
                }" data-academy-address="${academy.address1
                }" data-academy-objectid="${academy.id}">
                          <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20"> WhatsApp
                        </button>
                      </div>
                    </div>
                </div>
              </div>`;
            }
          });

          // Append generated HTML to .similar-academies-js container
          $(".similar-academies-js").html(nearbyAcademiesHtml);
        }

        // Hide loader images after content is loaded
        $(".loader_img7").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img7").hide();
      },
    });
  }
  function tablesData() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "tables",
      },
      success: function (response) {
        if (response.certificates && response.certificates.length > 0) {
          $(".certifications-box").removeClass("hidden");
          $(".certificate_count").html(response.certificates.length);
          $(".certificate_sport").html(
            response.certificates[0].sport ? response.certificates[0].sport : ""
          );
          let certificateRows = "";
          response.certificates.forEach((certificate, index) => {
            certificateRows += `
                <tr class="text-capitalize">
                    <th scope="row">${index + 1}</th>
                    <td>${certificate.name}</td>
                    <td>${certificate.authority}</td>
                    <td>${certificate.level}</td>
                </tr>
            `;
          });
          // Append the generated rows to the certificate table body
          $(".certificate-table").append(certificateRows);
        }

        if (response.tournaments && response.tournaments.length > 0) {
          $(".tournaments-box").removeClass("hidden");
          $(".tournament_count").html(response.tournaments.length);
          $(".tournament_sport").html(
            response.tournaments[0].sport ? response.tournaments[0].sport : ""
          );
          let tournamentRows = "";
          response.tournaments.forEach((tournament, index) => {
            tournamentRows += `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td class="text-capitalize">${tournament.name}</td>
                    <td class="text-capitalize">${tournament.level ? tournament.level : ""
              }</td>
                </tr>
            `;
          });
          // Append the generated rows to the tournament table body
          $(".tournament-table").append(tournamentRows);
        }

        if (response.schools && response.schools.length > 0) {
          $(".nearby-box").removeClass("hidden");
          $(".school_count").text(response.schools.length);
          let schoolRows = "";
          response.schools.forEach((school, index) => {
            const location = [school.cluster, school.block, school.district]
              .filter((item) => item) // Remove any empty values
              .join(", "); // Join the non-empty values with a comma

            schoolRows += `
              <tr>
                  <th scope="row">${index + 1}</th>
                  <td>${school.school_name}</td>
                  <td>${location}</td>
              </tr>
          `;
          });
          // Append the generated rows to the school table body
          $(".school-table").append(schoolRows);
        }

        $(".loader_img8").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img8").hide();
      },
    });
  }

  function faqs() {
    $.ajax({
      url: "/academy/get-additonal-info",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "faqs",
      },
      success: function (response) {
        if (response.faqs && response.faqs.length > 0) {
          $(".faqs-box").removeClass("hidden");
          let faqItems = "";
          response.faqs.forEach((faq, index) => {
            if (index > 0) {
              faqItems += `
                    <div class="accordion-item grey-line">
                        <h4 class="accordion-header" id="flush-heading${index}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${index}" aria-expanded="false" aria-controls="flush-collapse${index}">
                                ${faq.question}
                            </button>
                        </h4>
                        <div id="flush-collapse${index}" class="accordion-collapse collapse" aria-labelledby="flush-heading${index}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>${faq.answer}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
          });
          // Append the generated FAQ items to the accordion container
          $("#accordionFlushExample").append(faqItems);
        }

        $(".loader_img9").hide();
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        $(".loader_img9").hide();
      },
    });
  }

  let triggered = false;
  let triggeredReviews = false;
  let triggeredMedia = false;
  let triggeredAbout = false;
  let triggeredSimilarAcademy = false;
  let triggeredTable = false;
  let triggeredFaqs = false;
  let triggeredAiReviews = false;

  function debounce(func, delay) {
    let timer;
    return function () {
      clearTimeout(timer);
      timer = setTimeout(() => {
        func.apply(this, arguments);
      }, delay);
    };
  }

  const handleScroll = debounce(function () {
    const scrollTop = $(this).scrollTop();

    // if (!triggeredAiReviews && scrollTop >= 100) {
    //   triggeredAiReviews = true;
    //   aiReviews();
    // }
    if (!triggeredReviews && scrollTop >= 200) {
      triggeredReviews = true;
      reviews();
    }
    if (!triggered && scrollTop >= 300) {
      triggered = true;
      otherLocalities();
    }
    if (!triggeredAbout && scrollTop >= 400) {
      triggeredAbout = true;
      about();
    }
    if (!triggeredMedia && scrollTop >= 600) {
      triggeredMedia = true;
      media();
    }
    if (!triggeredTable && scrollTop >= 800) {
      triggeredTable = true;
      tablesData();
    }
    if (!triggeredFaqs && scrollTop >= 1000) {
      triggeredFaqs = true;
      faqs();
    }
    if (!triggeredSimilarAcademy && scrollTop >= 1500) {
      triggeredSimilarAcademy = true;
      similarAcademies();
    }
  }, 50); // Adjust the delay (e.g., 50ms) as needed

  $(window).on("scroll", handleScroll);

  $(document).on("click", ".get_back", function () {
    $("#contact_name").val("");
    $("#email").val("");
    $("#phone").val("");
    $("#message").val("");
    $("#detalis_desc").val("");
    $("#details_name2").val("");
    $("#details_email2").val("");
    $("#details_phone2").val("");
    $("#details_desc2").val("");
    $(this).closest(".confirm-box").hide();
  });

  var video = $("#myVideo")[0];
  $("#playPauseBtn").click(function () {
    if (video.paused) {
      video.play();
      $("#playPauseBtn img").attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/play_2.png"
      ); // Change to pause image
    } else {
      video.pause();
      $("#playPauseBtn img").attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/play_1.png"
      ); // Change to play image
    }
  });

  $("#muteBtn").click(function () {
    if (video.muted) {
      video.muted = false;
      $("#muteBtn img").attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/volume_1.png"
      ); // Change to volume on image
    } else {
      video.muted = true;
      $("#muteBtn img").attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/volume_2.png"
      ); // Change to mute image
    }
  });

  $(document).on("click", ".confirm-backdrop-review", function () {
    location.reload();
  });

  $(document).on("click", ".review_box", function () {
    location.reload();
  });

  $("#openCustomModal").on("click", function () {
    $("#customModalOverlay").show();
  });

  // Close modal when X is clicked
  $(".custom-close-btn").on("click", function () {
    $("#customModalOverlay").hide(); // Hide the modal overlay
  });

  // Close modal when clicking outside the modal box
  $("#customModalOverlay").on("click", function (e) {
    if ($(e.target).is("#customModalOverlay")) {
      $("#customModalOverlay").hide(); // Hide the modal overlay
    }
  });

  $("#otp_modal").click(function (event) {
    event.preventDefault();
    flag = true;
    academyTitle = $("#listing_title2").val();
    academyPhoneNumber = $("#academy_phone2").val();
    academyAddress = $("#academy_address2").val();
    let errorMessage = "";
    const contactName = $("#contact_name").val().trim();
    const phone = $("#phone").val().trim();
    const email = $("#email").val().trim();
    const message = $("#message").val().trim();

    // Validation checks
    if (!contactName) {
      errorMessage = "Name is required. ";
    } else if (!email) {
      errorMessage = "Email is required. ";
    } else if (!validateEmail(email)) {
      errorMessage = "Please enter a valid email address. ";
    } else if (!phone) {
      errorMessage = "Phone is required. ";
    } else if (!validatePhone(phone)) {
      errorMessage = "Phone number must be 10 digits. ";
    } else if (!message) {
      errorMessage = "Message is required. ";
    }

    if (errorMessage) {
      $("#error_message").text(errorMessage).show();
    } else {
      // Store data in sessionStorage
      sessionStorage.setItem("userName", contactName);
      sessionStorage.setItem("userEmail", email);
      sessionStorage.setItem("userPhone", phone);
      sessionStorage.setItem("userMessage", message);
      $("#error_message").hide();

      $.ajax({
        url: "https://www.bookmyplayer.com/submit-contact-static",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: $("#source_details2").val(),
          sport: $("#sport_details2").val(),
          sport_id: $("#sport_id_details2").val(),
          object_id: $("#object_id_details2").val(),
          object_type: $("#object_type_details2").val(),
          loc_id: $("#loc_id_details2").val(),
          screen: $("#screen_details2").val(),
          name: contactName,
          phone: phone,
          email: email,
          description: message,
          latitude: latitude,
          longitude: longitude,
        },
        success: function (response) {
          if (response.status == 1) {
            $("body").append(`
                  <div class="confirm-box" style="z-index: 1000;">
                      <div class="confirm-backdrop"></div>
                      <div class="confirm-content-new">
                          <div class="confirm-body">
                              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
                              <h6>Your lead has been submitted successfully</h6>
                              <div class="details_msg">
                                  
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                      <h6>${academyTitle}</h6>
                                  </div>
      
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                      <h6>${academyAddress}</h6>
                                  </div>
                                  ${academyPhoneNumber
                ? `
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                      <h6>${academyPhoneNumber}</h6>
                                  </div>`
                : ""
              }

                              </div>
                          </div>
                          <div class="confirm-footer flex-wrap">
                              <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                              ${academyPhoneNumber
                ? `
                                  <button class="get_back btn btn-success" id="contact_academy">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Whatsapp Academy
                                  </button>`
                : ""
              }
                                  <button class="get_back btn btn-success" id="contact_support">
                                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Contact Support
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

  function getDefaultSportPricing() {
    $.ajax({
      url: "/api/getDefaultSportPricing",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        loc_id: $("#loc_id_value").val(),
      },
      success: function (response) {
        $(".sport_estimate_price").empty();

        const selectedSport = $("#sport_value")?.val()?.toLowerCase() || "";
        let isSportMatched = false;

        if (response?.data[0]?.pricing?.length > 0) {
          response.data[0].pricing.forEach(function (item) {
            if (selectedSport === item.sport.toLowerCase()) {
              isSportMatched = true;
              let sportHTML = `<div class="sport_item text-capitalize">
                                 <div class="sport_name"><strong>${item.sport}</strong></div>`;

              if (typeof item.pricing === "object") {
                sportHTML += `<div class="pricing_container">
                                <div class="tab_tags mb-1">
                                  <div class="tag">Individual:</div><span class="tag_price">₹${item.pricing.individual}/month</span>
                                </div>
                                <div class="tab_tags">
                                  <div class="tag">Group:</div><span class="tag_price">₹${item.pricing.group}/month</span>
                                </div>
                              </div>`;
              } else {
                sportHTML += `₹${item.pricing}/month`;
              }

              sportHTML += `</div>`;
              // Append only the matched sport's HTML
              $(".sport_estimate_price").append(sportHTML);
            }
          });
        } else {
          $(".estimate_text").hide();
          $(".sport_estimate_price").html("Please Contact Academy");
        }

        if (isSportMatched == false) {
          $(".estimate_text").hide();
          $(".sport_estimate_price").html("Please Contact Academy");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle any errors here
      },
    });
  }

  getDefaultSportPricing();

  $(".price_change").hover(
    function () {
      $(this).siblings(".tooltip-box").fadeIn(); // Show the tooltip
    },
    function () {
      $(this).siblings(".tooltip-box").fadeOut(); // Hide the tooltip
    }
  );

  $(".price_change").on("click", function () {
    $("#priceChangeModal").modal("show");
    $("#price_name").val("");
    $("#price_phone").val("");
    $("#price_email").val("");
    $("#price_desc").val("");
  });

  $("#close_price").on("click", function () {
    $("#priceChangeModal").modal("hide");
  });

  $("#price_send").on("click", function () {
    let isValid = true;
    let errorMessage = "";

    const description = $("#price_desc").val().trim();
    if (description === "") {
      errorMessage = "Message is required.<br>";
      isValid = false;
    }

    const phone = $("#price_phone").val().trim();
    if (phone === "" || phone.length < 10) {
      errorMessage = "Valid phone number is required.<br>";
      isValid = false;
    }

    const email = $("#price_email").val().trim();
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email === "" || !emailPattern.test(email)) {
      errorMessage = "Valid email is required.<br>";
      isValid = false;
    }

    const name = $("#price_name").val().trim();
    if (name === "") {
      errorMessage = "Name is required.<br>";
      isValid = false;
    }

    // Display error messages or proceed with WhatsApp API call
    if (!isValid) {
      $("#priceError").html(errorMessage).show();
    } else {
      let currentPageLink = window.location.href;
      $("#priceError").hide();

      // Prepare the message for WhatsApp
      const contactNumber = "8826450360";
      const encodedMessage = encodeURIComponent(
        `Name: ${name}\nEmail: ${email}\nMobile: ${phone}\nUrl: ${currentPageLink}\nMessage: ${description}`
      );

      // Open WhatsApp with the pre-filled message
      window.open(
        `https://api.whatsapp.com/send?phone=+91${contactNumber}&text=${encodedMessage}`,
        "_blank"
      );

      // Hide modal after successful submission
      $("#priceChangeModal").modal("hide");
    }
  });

  function gymData() {
    $.ajax({
      url: "/api/gym/get-data",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
      },
      success: function (response) {
        if (
          response.data &&
          response.data.equipment !== undefined &&
          response.data.equipment !== null
        ) {
          $("#Equipment").removeClass("hidden");
          const equipmentList = response?.data?.equipment?.split(",");
          const iconContainer = $(".gym_equipment");
          iconContainer.empty(); // Clear existing icons

          const icons = [
            "equipment-icon01.png",
            "equipment-icon02.png",
            "equipment-icon03.png",
            "equipment-icon07.png",
            "equipment-icon04.png",
            "equipment-icon05.png",
            "equipment-icon06.png",
          ];

          let iconIndex = 0; // Track current icon index

          equipmentList?.forEach((equipment, index) => {
            const icon = icons[iconIndex]; // Select the current icon
            iconIndex = (iconIndex + 1) % icons.length; // Move to the next icon, repeat after the last one

            const html = `
            <a href="javascript:void(0)" class="icons-list-box__col">
              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${icon}" class="img-fluid" alt="${equipment.replace(
              /-/g,
              " "
            )}" loading="lazy">
              <span>${equipment.replace(/-/g, " ")}</span>
            </a>
          `;
            iconContainer.append(html); // Append each equipment icon
          });
        }

        if (
          response.data &&
          response.data.fitness_options !== undefined &&
          response.data.fitness_options !== null
        ) {
          $("#Fitness-options").removeClass("hidden");
          const fitnessOptions = response?.data?.fitness_options?.split(","); // Split into an array
          const fitnessContainer = $("#Fitness-options .icons-list-box__wrap");
          fitnessContainer.empty(); // Clear existing content

          const icons = [
            "equipment-icon14.png",
            "equipment-icon15.png",
            "equipment-icon16.png",
            "equipment-icon17.png",
          ];

          let iconIndex = 0; // Start with the first icon

          fitnessOptions?.forEach((option) => {
            const icon = icons[iconIndex]; // Get current icon
            iconIndex = (iconIndex + 1) % icons.length; // Loop through icons if list exceeds available

            const html = `
            <a href="javascript:void(0)" class="icons-list-box__col">
              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${icon}" class="img-fluid" alt="${option}" loading="lazy">
              <span>${option}</span>
            </a>
          `;
            fitnessContainer.append(html); // Append fitness option dynamically
          });
        }

        if (
          response.data &&
          response.data.premium_facilities !== undefined &&
          response.data.premium_facilities !== null
        ) {
          $("#Premium-Facilities").removeClass("hidden");
          const premiumFacilities =
            response?.data?.premium_facilities?.split(","); // Split into an array
          const premiumContainer = $(
            "#Premium-Facilities .icons-list-box__wrap"
          );
          premiumContainer.empty();

          const icons = [
            "equipment-icon10.png",
            "equipment-icon11.png",
            "equipment-icon12.png",
            "equipment-icon13.png",
          ];

          let iconIndex = 0;

          premiumFacilities?.forEach((facility) => {
            const icon = icons[iconIndex]; // Get the current icon
            iconIndex = (iconIndex + 1) % icons.length; // Loop through icons if list exceeds available

            const html = `
            <a href="javascript:void(0)" class="icons-list-box__col">
              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${icon}" class="img-fluid" alt="${facility}" loading="lazy">
              <span>${facility.charAt(0).toUpperCase() + facility.slice(1)
              }</span>
            </a>
          `;
            premiumContainer.append(html); // Append premium facility dynamically
          });
        }

        if (response.data && response.data.gym_area !== "{}") {
          $("#Gym-Area").removeClass("hidden");
          const gymAreaData = JSON.parse(response.data.gym_area);
          const gymAreaContainer = $(".gym_area");
          gymAreaContainer.empty();

          for (const [key, value] of Object.entries(gymAreaData)) {
            const html = `
            <div class="gym-area-box__col">
              <p>${key}:<span>${value}</span></p>
            </div>
          `;
            gymAreaContainer.append(html);
          }
        }

        if (response.data && response.data.trial_classes !== "{}") {
          $("#Trial-Classes").removeClass("hidden");
          try {
            // Parse the JSON string if it is not already an object
            const trialClassesData =
              typeof response.data.trial_classes === "string"
                ? JSON.parse(response.data.trial_classes)
                : response.data.trial_classes;

            const $ul = $(".trial_list");

            $ul.find(".loader_img7").remove();

            let $ul_list = "";

            $.each(trialClassesData, function (key, value) {
              $ul_list += `<li><strong>${key}:</strong> ${value}</li>`;
            });

            $ul.append($ul_list);
          } catch (error) {
            console.error("Failed to parse trial_classes data:", error);
          }
        }

        if (response.data && response.data.memberships !== "[]") {
          console.log(response.data.memberships);
          console.log("response.data.memberships");
          $("#Membership-Plans").removeClass("hidden");
          const membershipData = JSON.parse(response.data.memberships); // Parse the JSON data
          const membershipContainer = $(
            "#Membership-Plans .membersip-plans-wrap"
          );
          membershipContainer.empty(); // Clear existing content

          membershipData.forEach((plan) => {
            const duration = plan?.Duration?.match(/\d+/)?.[0] || "";
            const html = `
          <div class="membersip-plans-col mb-3">
            <div class="membersip-plans-inner-box ${plan.Plan.toLowerCase().replace(
              / /g,
              "-"
            )}-plans">
              <h5 class="text-capitalize">${plan.Plan}</h5>
              <div class="membersip-plans-details">
                <div class="date-prices-wrap">
                  <div class="date-item-box">
                    <h2>${duration}</h2>
<p>${plan?.Duration?.match(/[a-zA-Z]+/g)
                ? plan?.Duration?.match(/[a-zA-Z]+/g).join(" ")
                : ""
              }</p>

                  </div>
                 <div class="price-item-box">
                 
<h2>
    ₹${plan.Price ? plan.Price.toLocaleString() : "N/A"} 
    ${plan["Original Price"] &&
                plan["Original Price"] !== "MRP" &&
                plan["Original Price"] !== "N/A"
                ? `<del>₹${plan["Original Price"].toLocaleString()}</del>`
                : ""
              }
</h2>

 
<h4>
${plan["Taxes & Fees"]
                ? /^\d/.test(plan["Taxes & Fees"])
                  ? `${plan["Taxes & Fees"].toLocaleString()}`
                  : `${plan["Taxes & Fees"]}`
                : "No Extra Charges"
              }

</h4>

</div>

                </div>
                <div class="offers-and-btn">
                  <p>${plan["Offers Available"]
                ? plan["Offers Available"]
                : "No Offer Available"
              }</p>
                </div>
                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/plans-details-bg-shape.png" alt="Plan details shape" loading="lazy" class="plans-details-shape">
              </div>
            </div>
          </div>
        `;
            membershipContainer.append(html); // Append the plan dynamically
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
      },
    });
  }

  gymData();

  $("#report_academy_issue, #report_icon").click(function () {
    $("#report-overlay").show();
    $(".side_modal").removeClass("side_open");
    $(".hamburger-menu").removeClass("side_cross");
    $(".side_overlay").hide();
    $("#report-name").val("");
    $("#report-email").val("");
    $("#report-phone").val("");
    $("#report-issue").val("");
    $("#error-report-message").text("");
    $(".side_modal").removeClass("side_open");
  });

  $("#report_icon").hover(
    function () {
      $(this).siblings(".tooltip-box2").fadeIn(); // Show the tooltip
    },
    function () {
      $(this).siblings(".tooltip-box2").fadeOut(); // Hide the tooltip
    }
  );
});
