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

$(document).ready(function () {
  const base_url = "https://f005.backblazeb2.com/file/bmpcdn90";
  var url = `${window.location.origin}${window.location.pathname}`;
  let html = ``;
  let latitude;
  let longitude;

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

  function showLoadingIndicator() {
    $("#loading-indicator").removeClass("d-none");
  }

  function hideLoadingIndicator() {
    $("#loading-indicator").addClass("d-none");
  }

  function loadPlayers(page) {
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      data: { page: page },
      success: function (response) {
        html = ""; // Reset html variable
        response.d.forEach(function (player) {
          const logo = player.logo ? [player.logo] : [];
          const skillsArray = player.skill
            ? player.skill.split(",")
            : ["player"];
          let skillhtml = ``;
          skillsArray.forEach((skill) => {
            skillhtml += `<li>${skill.trim()}</li>`;
          });

          let photoHTML = '<div class="carousel">';

          if (logo == null || logo == "") {
            photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg" loading="lazy" alt="Profile Image"> </div>`;
          } else {
            photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/player/${player.id}/${logo}" loading="lazy" alt="Profile Image"> </div>`;
          }

          $("#listing-html").html("");

          photoHTML += "</div>";
          html += `                        <div class="col-lg-6">
                            <div class="player-box">
                                <div class="top">
                                    <figure>
                                        <a href="${
                                          player.url ??
                                          "https://www.bookmyplayer.com/"
                                        }" target="_blank">
                                        <div class="coaches-js player-list-img">
                                           ${photoHTML}
                                        </div>
                                        </a>
                                    </figure>
                                    <aside>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="sport text-capitalize">${
                                              player.sport ?? "-"
                                            }</div>
                                            <div class="national-level">National Level</div>
                                        </div>
                                        <h6 class="text-capitalize"><a href="${
                                          player.url ??
                                          "https://www.bookmyplayer.com/"
                                        }" target="_blank"> ${
            player.name ?? "-"
          } </a></h6>
                                        <div class="d-flex justify-content-start align-items-center mt-2">
                                            <i class="fa-regular fa-calendar-days"></i>
                                            <p>${player.dob ?? "-"}</p>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mt-2">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p>${(player.city ?? "India")
                                              .toLowerCase()
                                              .replace(/\b\w/g, (char) =>
                                                char.toUpperCase()
                                              )}</p>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mt-2">
                                            <i class="fa-solid fa-trophy"></i>
                                            <p>25 Achievements</p>
                                        </div>
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
                                        <div class="viewed"><img
                                                src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-viewed.svg"
                                                loading="lazy" alt="">${
                                                  player.views
                                                } people
                                            viewed since last week</div>
                                        <div class="graph"><img
                                                src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-trending-up.svg"
                                                loading="lazy" alt="">${
                                                  Math.floor(
                                                    Math.random() *
                                                      (80 - 20 + 1)
                                                  ) + 20
                                                }%
                                        </div>
                                    </div>
                                </div>
                                <div class="bot">
                              <button type="button" id="whatsapp_btn4" class="player_message_button" data-academy-phone="${
                                player.phone
                              }" data-academy-name="${
            player.name
          }" data-academy-lat="${player.lat}" data-academy-lng="${
            player.lng
          }" data-academy-locid="${player.loc_id}" data-academy-sport="${
            player.sport
          }" data-academy-sportid="${player.sport_id}" data-academy-address="${
            player.city
          }" data-academy-objectid="${player.id}">
                                        <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                                </button>
                                </div>
                                </div>
                            </div>
                        </div>`;
        });

        window.scrollTo({ top: 0, behavior: "smooth" });
        $("#listing-html").html(html);
        hideLoadingIndicator();
        updatePagination(response.pagination);
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $(document).on("click", "#whatsapp_btn4", function (e) {
    e.preventDefault();
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");
    academyPhoneNumber = $(this).data("academy-phone");

    $("#whatsappModalLabel4").text(`Contact ${academyTitle}`);

    $("#formError4").hide();
    $("#whatsappModal4").modal("show");
  });

  $(document).on("click", "#similarAcademyFormButton4", function () {
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name4").val().trim(),
      userEmail = $("#details_email4").val().trim(),
      userPhone = $("#details_phone4").val().trim(),
      userMessage = $("#details_desc4").val().trim();

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
        url: $("#similarAcademyForm4").attr("action"),
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: "whatsapp",
          sport: similarSport,
          sport_id: similarSportId,
          object_id: similarObjectId,
          object_type: "player",
          loc_id: similarLocationId,
          screen: "message",
          latitude: latitude,
          longitude: longitude,
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
        },
        beforeSend: function () {
          $("#similarAcademyFormButton4")
            .text("Sending...!!!")
            .prop("disabled", true);
        },
        success: function (response) {
          $("#whatsappModal4").modal("hide");

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
                                    <h6>${academyTitle}</h6>
                                </div>

                                <div class="d-flex justify-content-start align-items-start gap-1">
                                    <h6 style="color: #FB5D52;">Address:</h6>
                                    <h6>${academyAddress}</h6>
                                </div>

                                  ${
                                    academyPhoneNumber
                                      ? `
                                     <div class="d-flex justify-content-start align-items-start gap-1">
                                     <h6 style="color: #FB5D52;">Phone:</h6>
                                      <h6>${academyPhoneNumber}</h6>
                                     </div>`
                                      : ""
                                  }
                            </div>
                        </div>
                        <div class="confirm-footer flex-wrap">
                            <div class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                            ${
                              academyPhoneNumber
                                ? `
                                <button class="get_back btn btn-success" id="contact_academy">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Player
                                </button>`
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
          $("#similarAcademyFormButton4").text("Send").prop("disabled", false);
        },
        error: function (xhr, status, error) {
          console.log(error);
          $("#similarAcademyFormButton4").text("Send").prop("disabled", false);
        },
      });
    } else {
      $("#formError4").text(errorMessage).show();
    }

    $("#details_name4").val('');
    $("#details_email4").val('');
    $("#details_phone4").val('');
    $("#details_desc4").val('');
  });

  $(document).on("click", ".get_back", function () {
    $("#formError4").val("");
    $(this).closest(".confirm-box").hide();
  });

  $(document).on("click", ".confirm-backdrop", function () {
    $("#formError4").val("");
    $(this).closest(".confirm-box").hide();
  });

  $("#close_whatsapp4").on("click", function () {
    $("#whatsappModal4").modal("hide");
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
    let whatsappMessage = `Additional Info\nName: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\nDescription: ${userMessage}\n------------------------------\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    // Open the WhatsApp chat window with the pre-filled message
    window.open(
      `https://api.whatsapp.com/send?phone=+918826450360&text=${encodedMessage}`,
      "_blank"
    );
    sessionStorage.clear();
  });

  $(document).on("click", ".toggle-skills", function () {
    var $tags = $(this).siblings("ul.tags");

    if ($tags.hasClass("expanded")) {
      $tags.removeClass("expanded");
      $(this).text("More");
    } else {
      $tags.addClass("expanded");
      $(this).text("Less");
    }
  });

  function isElementInViewport(el) {
    if (!el) return false;
    var rect = el.getBoundingClientRect();
    var threshold = 150; // Load earlier when the element is within 100px of the viewport
    return (
      rect.top >= 0 - threshold &&
      rect.left >= 0 - threshold &&
      rect.bottom <=
        (window.innerHeight || document.documentElement.clientHeight) +
          threshold &&
      rect.right <=
        (window.innerWidth || document.documentElement.clientWidth) + threshold
    );
  }

  loadPlayers(1);
  $("#prev-page, #next-page").on("click", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    // Prevent action for last page or first page
    if (page === null || ($this.is("#prev-page") && page === 0)) {
      e.preventDefault();
      return;
    }

    loadPlayers(page);
  });

  function updatePagination(data) {
    var currentPage, isLast;

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

  var modal = $("#messageModal");



  var close = $(".coach_close");
  close.on("click", function () {
    modal.hide();
  });

  $(window).on("click", function (event) {
    if ($(event.target).is(modal)) {
      modal.hide();
    }
  });

  function validatePhone(phone) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phone);
  }

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
});
