$(document).ready(function () {
  var player_id = window.location.href.split("/").pop();
  let playerName01;
  let playerMobile;
  let playerAddress;

  setTimeout(() => {
    get_player();
  }, 5000);

  let localStorageLatitude = localStorage.getItem('latitude');
  let localStorageLongitude = localStorage.getItem('longitude');
  let latitude;
  let longitude;

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

  function get_player() {
    $.ajax({
      url: `${window.location.origin}/player/details/${player_id}`,
      type: "GET",
      async: true,
      success: function (response) {
        let photos = "";
        let videos = "";
        let reviews = "";
        let players = "";

        // Populate Photos
        if (response.photos.length > 0) {
          response.photos.forEach(function (photo) {
            photos += `<div class="item d-flex">
            <a href="${photo}" data-fancybox="gallery" data-caption="Image">
              <img src="${photo}" loading="lazy" alt="images">
            </a>
         </div>`;

          });
          $("#photos").html(photos);
        } else {
          $("#photos").html("");
        }

        if (response.videos.length > 0) {
          response.videos.forEach(function (video) {
            videos += `<div class="item">
            <a href="${video}" data-fancybox="gallery" data-caption="Video">
              <video src="${video}" class="img-fluid" controls controlsList="nodownload"></video>
            </a>
         </div>`;

          });
          $("#videos").html(videos);
        } else {
          $("#videos").html("");
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
                                    <div class="card-image"><img src="${profile}" class="img-fluid" alt=""></div>
                                     <div class="card-info">
                                        <h6>${review.name}</h6>
                                         <p style="visibility:hidden">.</p>
                                     </div>
                                     <div class="card-rating">
                                     <p>${formattedDate}</p>
                                     <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${Math.round(
                                       review.rating
                                     )}star.png" alt=""></div>
                                    </div>
                                    <div class="card-content">
                                            <p>${review.comment}</p>
                                    </div>
                                </div>`;
          });
          $("#coach-reviews").html(reviews);
        } else {
          $("#coach-reviews").html("");
        }

        if (response.other_players.length > 0) {
          response.other_players.forEach(function (player) {
            let profile = player.player_logo
              ? ` https://f005.backblazeb2.com/file/bmpcdn90/player/${player.id}/${player.player_logo}`
              : "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg";

        
            let locality = player.locality_name ? player.locality_name : "India";

            let ratingImage = player.average_rating !== null
            ? `<img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${player.average_rating}star.png" class="lazy" alt="star">`
            : '';
            
        
            players += `
              <div class="item">
               <a href="${player.player_url}" target="_blank">
                <div class="teacher-box">
                  <figure>
                    <img src="${profile}" class="img-fluid lazy" loading="lazy" alt=""
                      onerror="this.onerror=null;this.src='https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg';">
                  </figure>
                  <article>
                   
                      <h6>${player.player_name}</h6>

                    <p><i class="fa-solid fa-location-dot"></i>${locality}</p>
                    <div class="d-flex align-items-center rating">
                        ${ratingImage}
                    </div>
                  </article>
                </div>
              </a>
              </div>
            `;
          });
          $("#popular_coaches").html(players);
        } else {
          $("#popular_coaches").html("");
        }
        
      },
    });
  }

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

  //==========horizontal nav js===========//

  // JavaScript Document
  function resizeMenu() {
    let wrapW = $("#horizontal-nav .menu-wrap").width(),
      menuW = $("#horizontal-nav .menu-anchor").width();

    let itemsToScroll = 3,
      widthToScroll = 0,
      scrollX = parseFloat(
        $("#horizontal-nav .menu-wrap .menu-anchor").css("left")
      );

    if ($(this).hasClass("btn-prev")) {
      let prevItemIndex,
        prevItemsWidth = 0;

      $("#horizontal-nav .list-item").each((i, el) => {
        if (prevItemIndex !== undefined) return;
        prevItemsWidth += $(el).outerWidth() + 30;
        if (Math.ceil(prevItemsWidth) > Math.abs(scrollX)) prevItemIndex = i;
      });

      for (
        let i = prevItemIndex;
        i >= 0 && i > prevItemIndex - itemsToScroll;
        i--
      )
        prevItemsWidth -=
          $(`#horizontal-nav .list-item:eq(${i})`).outerWidth() + 30;

      widthToScroll = scrollX - prevItemsWidth;
      let newScrollX = Math.abs(scrollX) + widthToScroll;
      $("#horizontal-nav .menu-wrap .menu-anchor").css({ left: newScrollX });

      $(this).toggleClass("hidden", !Math.floor(newScrollX));
      $(".btn-next").removeClass("hidden");
    } else {
      let nextItemIndex,
        prevItemsWidth = 0;

      $("#horizontal-nav .list-item").each((i, el) => {
        if (nextItemIndex !== undefined) return;
        prevItemsWidth += $(el).outerWidth() + 30;
        if (Math.floor(prevItemsWidth - 30) > Math.abs(scrollX) + wrapW)
          nextItemIndex = i;
      });

      if (scrollX + wrapW >= menuW) {
        if (!$(this).hasClass("hidden")) $(this).addClass("hidden");
        return;
      }
      $(this).removeClass("hidden");

      for (
        let i = nextItemIndex + 1;
        i < nextItemIndex + itemsToScroll &&
        nextItemIndex + itemsToScroll <= $("#horizontal-nav .list-item").length;
        i++
      )
        prevItemsWidth +=
          $(`#horizontal-nav .list-item:eq(${i})`).outerWidth() + 30;
      widthToScroll = prevItemsWidth - 30 - (Math.abs(scrollX) + wrapW);
      let newScrollX = scrollX - widthToScroll;
      $("#horizontal-nav .menu-wrap .menu-anchor").css({ left: newScrollX });
      $(this).toggleClass(
        "hidden",
        Math.round(Math.abs(newScrollX) + wrapW) >= Math.round(menuW)
      );
      $(".btn-prev").removeClass("hidden");
    }
  }
  $(() => {
    $("#horizontal-nav .list-item").each(function () {
      if ($(this).find(".sub-menu").length) $(this).addClass("has-submenu");
    });
    $("#horizontal-nav").on("click", ".btn-prev, .btn-next", resizeMenu);

    $(document).on("resize", resizeMenu);
  });

  //==========tabs js==========//

  $(".tabContent").hide();
  $("ul.tabs li:first").addClass("active").show();
  $(".tabContent:first").show();

  $("ul.tabs li").click(function () {
    $("ul.tabs li").removeClass("active");
    $(this).addClass("active");
    $(".tabContent").hide();
    var activeTab = $(this).find("a").attr("href");
    $(activeTab).fadeIn();
    return false;
  });

  //=======modal js=========//

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
  

  function validateEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  }

  function validatePhone(phone) {
    var phonePattern = /^\d{10}$/;
    return phonePattern.test(phone);
  }

  $('[data-remodal-id="modal03"]').on('opening', function () {
    clearForm();
  });

  $("#openWhatsappModal").on("click", function () {
    $("input[name='name'], input[name='email'], input[name='phone'], input[name='description']").val("");
    $('#details_desc').val('');
    $("#formError").hide();
    $("#whatsappModal").modal("show");
  });

  $("#openWhatsappModal2").on("click", function () {
    $("input[name='name'], input[name='email'], input[name='phone'], input[name='description']").val("");
    $('#details_desc').val('');
    $("#formError").hide();
    $("#whatsappModal").modal("show");
  });

  $("#openWhatsappModal3").on("click", function () {
    $("input[name='name'], input[name='email'], input[name='phone'], input[name='description']").val("");
    $('#details_desc').val('');
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
      playerName01 = $("#playerName").val().trim();
      playerMobile = $("#playerPhone").val().trim();
      playerAddress = $("#playerAddress").val().trim();

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
          $("#formSubmitButton").text("Sending...!!!").prop("disabled", true);
        },
        success: function (response) {
          $("#whatsappModal").modal("hide");

          // Append success message to the body
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
                                        <h6>${playerName01}</h6>
                                    </div>

                                    ${playerAddress ? `
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                      <h6>${playerAddress}</h6>
                                  </div>` : ''}
                                   
                                    ${playerMobile ? `
                                  <div class="d-flex justify-content-start align-items-start gap-1">
                                      <h6 style="color: #FB5D52; min-width: 100px;">Phone:</h6>
                                      <h6>${playerMobile}</h6>
                                  </div>` : ''}
                                </div>
                            </div>
                            <div class="confirm-footer flex-wrap">
                                <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                                  ${playerMobile ? `
                                    <button class="get_back btn btn-success" id="contact_academy">
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp">Whatsapp Player
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

  $(document).on("click", "#contact_academy", function () {
    let userName = sessionStorage.getItem("userName");
    let userMessage = sessionStorage.getItem("userMessage");

    let whatsappMessage = `Hello ${playerName01},\n\nI hope this message finds you well.\n\nMy name is ${userName}.\n\n${userMessage}\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    window.open(
      `https://api.whatsapp.com/send?phone=+91${playerMobile}&text=${encodedMessage}`,
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
    $("#details_name").val("");
    $("#details_email").val("");
    $("#details_phone").val("");
    $("#detalis_desc").val("");
    $(this).closest(".confirm-box").hide();
    $("#review_box").hide();
    $("#review_box2").hide();
  });

  $(document).on("click", ".confirm-backdrop", function () {
    $("#details_name").val("");
    $("#details_email").val("");
    $("#details_phone").val("");
    $("#detalis_desc").val("");
    $(this).closest(".confirm-box").hide();
  });

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

  
});
