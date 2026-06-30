$(document).ready(function () {
  const base_url = "https://f005.backblazeb2.com/file/bmpcdn90";
  let flag = true;
  let flag2 = true;
  let otpFlag = 1;
  let sportFlag = 1;
  let academyTitle;
  let academyPhoneNumber;
  let academyAddress;
  let similarSport;
  let similarSportId;
  let similarObjectId;
  let similarLocationId;
  let similarUrl;
  let latitude;
  let longitude;
  let academyCount;
  let coachCount;
  let playerCount;
  let locationCount;
  let premiumAcademy = [];
  let url = window.location.href;
  let sportId = $("#sport_id").val();
  let urlId = url.split("/").pop();
  if (urlId.includes("-")) {
    urlId = urlId.split("-").pop();
  }
  urlId = urlId.replace(/(\d+)[#\D].*/, "$1");

  let otpInputs3 = $(".mob_otp_input3");
  let otpBox11 = $("#otp_one");
  let otpBox22 = $("#otp_two");
  let otpBox33 = $("#otp_three");
  let otpBox44 = $("#otp_four");

  //====latitude and longitude js====//

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

  $("#detect-location-academy").click(function () {
    redirectToLocation(latitude, longitude);
  });

  function redirectToLocation(latitude, longitude) {
    window.location.href = `https://www.bookmyplayer.com/sdid-redirect/${sportId}/${latitude}-${longitude}`;
  }
  //====latitude and longitude js ends====//

  //====Academy tab js====//

  premiumList(1);
  countsTab(1);
  backLinks(1);


  function backLinks(page) {

    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "sdid_backlinks",
      },
      success: function (response) {
        if (response.data.details.academy_backlinks.length > 0) {
          $(".other-backlinks-academy").removeClass("hidden")
          const backlinks = response.data.details.academy_backlinks;

          const listItems = backlinks
            .map(
              (link) =>
                `<li class="text-capitalize other_link_li">
                  <a href="${link.url}" class="text-capitalize">
                    ${link.name}
                  </a>
                </li>`
            )
            .join("");
  
          $(".other_academy_links").html(listItems);
        }

        if (response.data.details.coach_backlinks.length > 0) {
          $(".other-backlinks-coach").removeClass("hidden")
          const backlinks = response.data.details.coach_backlinks;

          const listItems = backlinks
            .map(
              (link) =>
                `<li class="text-capitalize other_link_li">
                  <a href="${link.url}" class="text-capitalize">
                    ${link.name}
                  </a>
                </li>`
            )
            .join("");
  
          // Set the inner HTML of .other_links
          $(".other_coach_links").html(listItems);
        }

        if (response.data.details.player_backlinks.length > 0) {
          $(".other-backlinks-player").removeClass("hidden")
          const backlinks = response.data.details.player_backlinks;

          const listItems = backlinks
            .map(
              (link) =>
                `<li class="text-capitalize other_link_li">
                  <a href="${link.url}" class="text-capitalize">
                    ${link.name}
                  </a>
                </li>`
            )
            .join("");
  
          $(".other_player_links").html(listItems);
        }

        if (response.data.details.location_backlinks.length > 0) {
          $(".other-backlinks-location").removeClass("hidden")
          const backlinks = response.data.details.location_backlinks;

          const listItems = backlinks
            .map(
              (link) =>
                `<li class="text-capitalize other_link_li">
                  <a href="${link.url}" class="text-capitalize">
                    ${link.locality_name}
                  </a>
                </li>`
            )
            .join("");
  
          $(".other_location_links").html(listItems);
        }
        

      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }


  function countsTab(page) {

    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "counts",
      },
      success: function (response) {

        let academyCount = response.data.counts.academy;
        let coachCount = response.data.counts.coach;
        let playerCount = response.data.counts.player;
        let locationCount = response.data.counts.location;

        if (
          premiumAcademy.length > 0 &&
          academyCount !== null &&
          academyCount > 0
        ) {
          $("#totalRecords").html(`(${academyCount + premiumAcademy.length})`);
          academyList(1);
        } else if (academyCount !== null && academyCount > 0) {
          $("#totalRecords").html(`(${academyCount})`);
          academyList(1);
        } else {
          $(".academy_tab").hide();
        }

        if (coachCount !== null && coachCount > 0) {
          $("#totalRecords2").html(`(${coachCount})`);
        } else {
          $(".coach_tab").hide();
        }

        if (playerCount !== null && playerCount > 0) {
          $("#totalRecords3").html(`(${playerCount})`);
        } else {
          $(".player_tab").hide();
        }

        if (locationCount !== null && locationCount > 0) {
          $("#totalRecords5").html(`(${locationCount})`);
        } else {
          $(".location_tab").hide();
        }

        if (academyCount === 0 || academyCount === null) {
          if (coachCount === 0 || coachCount === null) {
            if (playerCount === 0 || playerCount === null) {
              if(locationCount ===0 || locationCount === null){
                return;
              }else{
                activateTab("#location-tab-pane");
                locationList(1);
                return;
              }
            } else {
              playerList(1);
              activateTab("#player-tab-pane");
              return;
            }
          } else {
            // If academyCount is 0 or null, but coachCount is not
            coachList(1);
            activateTab("#coach-tab-pane");
            return;
          }
        }
          
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }


  function topTabs() {
    $(".tab_height").append(`
          <ul class="nav nav-tabs top_tabs" id="myTab" role="tablist">
                    <li class="nav-item academy_tab" role="presentation">
                        <button class="nav-link active" id="academy-tab" data-bs-toggle="tab" data-bs-target="#academy-tab-pane" type="button" role="tab" aria-controls="academy-tab-pane" aria-selected="true">Academies<span id="totalRecords"></span></button>
                    </li>
                    <li class="nav-item coach_tab" role="presentation">
                        <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach-tab-pane" type="button" role="tab" aria-controls="coach-tab-pane" aria-selected="false">Coaches<span id="totalRecords2"></span></button>
                    </li>
                    <li class="nav-item player_tab" role="presentation">
                        <button class="nav-link" id="player-tab" data-bs-toggle="tab" data-bs-target="#player-tab-pane" type="button" role="tab" aria-controls="player-tab-pane" aria-selected="false">Players<span id="totalRecords3"></span></button>
                    </li>
                    <li class="nav-item location_tab" role="presentation">
                        <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location-tab-pane" type="button" role="tab" aria-controls="location-tab-pane" aria-selected="false">Location<span id="totalRecords5"></span></button>
                    </li>
                </ul>
      `);
  }

  function activateTab(tabId) {
    $(".tab-pane").removeClass("active show");
    $("[aria-controls]").removeClass("active");
    $(tabId).addClass("active show");
    $('[aria-controls="' + tabId.substring(1) + '"]').addClass("active");
  }

  function premiumList(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "premium_academy",
      },
      success: function (response) {
        premiumAcademy = response.data.details;
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  function academyList(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "academy",
      },
      success: function (response) {
        $("#totalRecords4").html(`(39)`);


        if (premiumAcademy.length > 0) {
          $("#academy-listing").empty();
          if (page == 1) {
            premiumAcademy.forEach(function (academy) {
              const photosArray = academy.photos
                ? academy.photos.split(",")
                : [];

              let photoHTML = '<div class="academy-js">';
              if (photosArray.length > 0) {
                photoHTML += `
                  <div class="item academy_pics">
                    <link rel="preload" as="image" href="${base_url}/academy/${academy.id}/${photosArray[0]}" />
                    <img src="${base_url}/academy/${academy.id}/${photosArray[0]}" alt="Academy Photo"
                         onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-3.jpg';" />
                  </div>`;
              } else {
                photoHTML += `
                  <div class="item academy_pics">
                    <link rel="preload" as="image" href="${base_url}/asset/images/landing-options-item-img-3.jpg" />
                    <img src="${base_url}/asset/images/landing-options-item-img-3.jpg" alt="Default Photo" />
                  </div>`;
              }

              photoHTML += "</div>";

              const academySport = academy.adm_sport
                ? academy.sport_id === 5 || academy.sport_id === 31
                  ? `${academy.adm_sport}` // No "Academy" suffix for sport_id 5 or 31
                  : `${academy.adm_sport} Academy` // Add "Academy" suffix for other sport_ids
                : "Academy"; // Default to "Academy" if adm_sport is not present

              const academyName = academy.name ? academy.name : "-";
              const academyFee = academy.fee
                ? academy.fee
                : academy.default_pricing
                ? academy.default_pricing
                : "";

              let addressParts = [
                academy.address2,
                academy.city,
                academy.loc_state,
              ].filter(Boolean); // Remove any falsy values (null, undefined, empty string)

              let uniqueAddressParts = [...new Set(addressParts)];

              let tagsHTML = `
                <li>Sports</li>
                <li>Fitness</li>
                <li>Core Workout</li>
            `;

              let academyHTML = `
            <a href="${academy.url}">
              <div class="academy-box premium-background">
                <figure>
                  ${photoHTML}
                </figure>
                <aside>
                  <div class="d-flex">
                    <div class="flex-grow-1 sport-name text-capitalize">${academySport}</div>
                    <div class="rating">
                      <img src="${base_url}/asset/images/star-rating.svg" loading="lazy" alt="Star" height="17" width="17">
                      <strong>${
                        academy.rating ? academy.rating : 3.6
                      }</strong> (${academy.reviews ? academy.reviews : 20})
                    </div>
                    <div class="verified">
                      <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Premium
                    </div>
                  </div>
                  <div class="d-flex justify-content-between gap-3">
                    <h6 class="text-capitalize name-trim">${academyName}</h6>
                    <h6 style="white-space: nowrap;">${academyFee}<span></span></h6>
                  </div>
                  <div class="">
                    <div class="content">
                      <p class="name-trim2"><i class="fa-solid fa-academy-dot"></i>${uniqueAddressParts.join(
                        ", "
                      )}</p>
                      <ul class="tags text-capitalize">
                        ${tagsHTML}
                      </ul>
                      <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <p><i class="fa-solid fa-eye"></i> ${
                          academy.views ? academy.views : 0
                        } people viewed since last week
                          <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                          ${academy.views ? academy.views : 0}</span>
                        </p>
                        <div class="button">
                          <button id="whatsapp_btn" data-academy-name="${
                            academy.name
                          }" data-academy-lat="${
                academy.lat
              }" data-academy-lng="${academy.lng}" data-academy-locid="${
                academy.loc_id
              }" data-academy-sport="${
                academy.adm_sport
              }" data-academy-sportid="${
                academy.sport_id
              }" data-academy-address="${
                academy.address1
              }" data-academy-objectid="${academy.id}" data-academy-url="${academy.url}">
                            <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </aside>
              </div>
            </a>
            `;

              window.scrollTo({ top: 0, behavior: "smooth" });
              $("#academy-listing").append(academyHTML);
            });
          }
        }

        if (premiumAcademy.length == 0) {
          $("#academy-listing").empty();
        }

        if (response.data.details.length > 0) {
          response.data.details.forEach(function (academy) {
            const photosArray = academy.photos ? academy.photos.split(",") : [];

            let photoHTML = '<div class="academy-js">';
            if (photosArray.length > 0) {
              photoHTML += `
              <div class="item academy_pics">
                <link rel="preload" as="image" href="${base_url}/academy/${academy.id}/${photosArray[0]}" />
                <img src="${base_url}/academy/${academy.id}/${photosArray[0]}" alt="Academy Photo"
                     onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-3.jpg';" />
              </div>`;
            } else {
              photoHTML += `
                <div class="item academy_pics">
                  <link rel="preload" as="image" href="${base_url}/asset/images/landing-options-item-img-3.jpg" />
                  <img src="${base_url}/asset/images/landing-options-item-img-3.jpg" alt="Default Photo" />
                </div>`;
            }
            photoHTML += "</div>";

            const academySport = academy.adm_sport
              ? academy.sport_id === 5 || academy.sport_id === 31
                ? `${academy.adm_sport}` // No "Academy" suffix for sport_id 5 or 31
                : `${academy.adm_sport} Academy` // Add "Academy" suffix for other sport_ids
              : "Academy"; // Default to "Academy" if adm_sport is not present

            const academyName = academy.name ? academy.name : "-";
            const academyFee = academy.fee
              ? academy.fee
              : academy.default_pricing
              ? academy.default_pricing
              : "";

            let addressParts = [
              academy.address2,
              academy.city,
              academy.loc_state,
            ].filter(Boolean); // Remove any falsy values (null, undefined, empty string)

            let uniqueAddressParts = [...new Set(addressParts)];

            let tagsHTML = `
                <li>Sports</li>
                <li>Fitness</li>
                <li>Core Workout</li>
            `;

            let academyHTML = `
            <a href="${academy.url}">
              <div class="academy-box">
                <figure>
                  ${photoHTML}
                </figure>
                <aside>
                  <div class="d-flex">
                    <div class="flex-grow-1 sport-name text-capitalize">${academySport}</div>
                    <div class="rating">
                      <img src="${base_url}/asset/images/star-rating.svg" loading="lazy" alt="Star" height="17" width="17">
                      <strong>${
                        academy.rating ? academy.rating : 3.6
                      }</strong> (${academy.reviews ? academy.reviews : 20})
                    </div>
                    <div class="verified">
                      <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                    </div>
                  </div>
                  <div class="d-flex justify-content-between gap-3">
                    <h6 class="text-capitalize name-trim">${academyName}</h6>
                    <h6 style="white-space: nowrap;">${academyFee}<span></span></h6>
                  </div>
                  <div class="">
                    <div class="content">
                      <p class="name-trim2"><i class="fa-solid fa-academy-dot"></i>${uniqueAddressParts.join(
                        ", "
                      )}</p>

                      <ul class="tags text-capitalize">
                        ${tagsHTML}
                      </ul>
                      <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <p><i class="fa-solid fa-eye"></i> ${
                          academy.views ? academy.views : 0
                        } people viewed since last week
                          <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                          ${academy.views ? academy.views : 0}</span>
                        </p>
                        <div class="button">
                          <button id="whatsapp_btn" data-academy-name="${
                            academy.name
                          }" data-academy-lat="${
              academy.lat
            }" data-academy-lng="${academy.lng}" data-academy-locid="${
              academy.loc_id
            }" data-academy-sport="${
              academy.adm_sport
            }" data-academy-sportid="${
              academy.sport_id
            }" data-academy-address="${
              academy.address1
            }" data-academy-objectid="${academy.id}" data-academy-url="${academy.url}">
                            <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </aside>
              </div>
            </a>
            `;

            window.scrollTo({ top: 0, behavior: "smooth" });
            $("#academy-listing").append(academyHTML);
          });

          $("#academy-listing").append(`
             <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations">
            <ul class="pagination">
              <li class="page-item" id="prev-page">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span> Previous
                </a>
              </li>
              <li class="page-item active" id="current-page">
                <span class="page-link"></span>
              </li>
              <li class="page-item" id="next-page">
                <a class="page-link" href="#" aria-label="Next">
                  Next <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
            </nav>
          `);

          updatePagination(response.data.pagination);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  setTimeout(function () {
    // filters(1);
    locationList(1);
  }, 3000);

  function filters(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "filters",
      },
      success: function (response) {
        if (response.data.record.location.length > 0) {
          response.data.record.location.forEach(function (location) {
            let localityHtml = `
            <div class="form-check-new mb-2">
              <a href="${location.url}" class="text-capitalize">${location.locality_name}</a>
            </div>
    `;
            $("#localityList").append(localityHtml);
            $("#localityList2").append(localityHtml);
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $(document).on("click", "#prev-page, #next-page", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    if (page === null || ($this.is("#prev-page") && page === 0)) {
      e.preventDefault();
      return;
    }

    academyList(page);
  });

  $("#academy-tab").on("click", function () {
    academyList(1);
  });

  $(document).on("click", "#whatsapp_btn", function (event) {
    event.preventDefault();
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");
    similarUrl = $(this).data("academy-url");
    $("#whatsappModalLabel2").text(`Contact ${academyTitle}`);

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
    $("#formError2").hide();
    $("#whatsappModal2").modal("show");
  });

  function updatePagination(data) {
    var currentPage, previousPage, nextPage, isLast;

    data.forEach(function (item) {
      switch (item.name) {
        case "previous":
          previousPage = item.value;
          break;
        case "current":
          currentPage = parseInt(item.value, 10);
          $("#current-page span").text(currentPage);
          break;
        case "is_last":
          isLast = item.value === true || item.value === "true"; // Ensure boolean handling
          break;
      }
    });

    // Calculate next page if not directly provided
    if (!isLast) {
      nextPage = currentPage + 1;
    } else {
      nextPage = null; // No next page if it's the last one
    }

    $("#prev-page").data("value", previousPage);
    $("#next-page").data("value", nextPage);

    if (currentPage === 1 && isLast) {
      $("#paginations").html(""); // Hide pagination if there's only one page
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

  $(document).on("click", "#similarAcademyFormButton", function () {
    otpFlag = 2;
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name2").val().trim(),
      userEmail = $("#details_email2").val().trim(),
      userPhone = $("#details_phone2").val().trim(),
      userMessage = $("#details_desc2").val().trim();

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
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);

     afterOtp();
    } else {
      $("#formError2").text(errorMessage).show();
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
    let whatsappMessage = `Additional Info\nId: ${similarObjectId}\nName: ${academyTitle}\nUrl: ${similarUrl}\nUsername: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\nDescription: ${userMessage}\n------------------------------\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    // Open the WhatsApp chat window with the pre-filled message
    window.open(
      `https://api.whatsapp.com/send?phone=+918826450360&text=${encodedMessage}`,
      "_blank"
    );
    sessionStorage.clear();
  });

  $(document).on("click", ".get_back", function () {
    $("#formError2").val("");
    $("#formError3").val("");
    $("#formError4").val("");
    $(this).closest(".confirm-box").hide();
  });

  $(document).on("click", ".confirm-backdrop", function () {
    $("#formError2").val("");
    $("#formError3").val("");
    $("#formError4").val("");
    $(this).closest(".confirm-box").hide();
  });

  $("#close_whatsapp2").on("click", function () {
    $("#whatsappModal2").modal("hide");
  });

  //====Academy tab js ends====//

  //====Coach tab js ====//

  function coachList(page) {
    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "coach",
      },
      success: function (response) {
        if (response.data.details.length > 0) {
          $("#coach-listing").empty();
          response.data.details.forEach(function (coach) {
            const skillsArray = coach.skill
              ? coach.skill.split(",")
              : ["Sports", "Fitness", "Workout"];

            // let tagsHTML = skillsArray.map(skill => `<li>${skill}</li>`).join('');
            let tagsHTML = skillsArray
              .slice(0, 3)
              .map((skill) => `<li>${skill}</li>`)
              .join("");

            let photo = coach.profile_img;
            let photoHTML = '<div class="academy-js">';

            if (photo) {
              photoHTML += `
  <div class="item academy_pics">
    <img src="${base_url}/coach/${coach.id}/${photo}" loading="lazy" alt="Academy Image"
         onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-2.jpg';" />
  </div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-2.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const coachSport = coach.sport ? `${coach.sport}` : "Coach";
            const coachName = coach.name ? coach.name : "-";
            const coachFee = coach.fee
              ? coach.fee
              : coach.default_pricing
              ? coach.default_pricing
              : "";

            let uniqueCoachAddressParts = [
              coach.loc_locality_name,
              coach.loc_city,
              coach.loc_state,
            ].filter(Boolean); // Remove any falsy values (null, undefined, empty string)

            uniqueCoachAddressParts = [...new Set(uniqueCoachAddressParts)];

            let academyHTML = `
            <a href="${coach.url}">
                <div class="academy-box">
                    <figure>
                        ${photoHTML}
                    </figure>
                    <aside>
                        <div class="d-flex">
                            <div class="flex-grow-1 sport-name text-capitalize">${coachSport} Coach</div>
                            <div class="rating">
                                <img src="${base_url}/asset/images/star-rating.svg" loading="lazy" alt="Star" height="17" width="17">
                                <strong>${
                                  coach.rating ? coach.rating : 3.6
                                }</strong> (${
              coach.reviews ? coach.reviews : 20
            })
                            </div>
                            <div class="verified">
                                <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <h6 class="text-capitalize name-trim">${coachName}</h6>
                            <h6 style="white-space: nowrap;">${coachFee}<span></span></h6>
                        </div>
                        <div>
                            <div class="content">
                                <p class="name-trim2 text-capitalize"><i class="fa-solid fa-location-dot"></i>${uniqueCoachAddressParts.join(
                                  ", "
                                )}</p>
                                <ul class="tags text-capitalize">
                                    ${tagsHTML}
                                </ul>
                                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <p><i class="fa-solid fa-eye"></i> ${
                                  coach.views ? coach.views : 0
                                } people viewed since last week
                                    <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                                    ${coach.views ? coach.views : 0}</span>
                                </p>
                                 <div class="button">
                                <button id="whatsapp_btn3" data-academy-phone="${
                                  coach.phone
                                }" data-academy-name="${
              coach.name
            }" data-academy-lat="${coach.lat}" data-academy-lng="${
              coach.lng
            }" data-academy-locid="${coach.loc_id}" data-academy-sport="${
              coach.sport
            }" data-academy-sportid="${coach.sport_id}" data-academy-address="${
              coach.city
            }" data-academy-objectid="${coach.id}" data-academy-url="${coach.url}">
                                        <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                                </button>
                            </div>
                                </div>
                            </div>
                           
                        </div>
                    </aside>
                </div>
              </a>
            `;

            window.scrollTo({ top: 0, behavior: "smooth" });
            $("#coach-listing").append(academyHTML);
          });

          $("#coach-listing").append(`
            <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations2">
           <ul class="pagination">
             <li class="page-item" id="prev-page2">
               <a class="page-link" href="#" aria-label="Previous">
                 <span aria-hidden="true">&laquo;</span> Previous
               </a>
             </li>
             <li class="page-item active" id="current-page2">
               <span class="page-link"></span>
             </li>
             <li class="page-item" id="next-page2">
               <a class="page-link" href="#" aria-label="Next">
                 Next <span aria-hidden="true">&raquo;</span>
               </a>
             </li>
           </ul>
           </nav>
         `);

          updatePagination2(response.data.pagination);
        } else {
          $("#no-data-found").removeClass("d-none");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $(document).on("click", "#prev-page2, #next-page2", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    // Prevent action for last page or first page
    if (page === null || ($this.is("#prev-page2") && page === 0)) {
      e.preventDefault();
      return;
    }

    coachList(page);
  });

  function updatePagination2(data) {
    var currentPage, previousPage, nextPage, isLast;

    data.forEach(function (item) {
      switch (item.name) {
        case "previous":
          previousPage = item.value;
          break;
        case "current":
          currentPage = parseInt(item.value, 10);
          $("#current-page2 span").text(currentPage);
          break;
        case "is_last":
          isLast = item.value === true || item.value === "true"; // Ensure boolean handling
          break;
      }
    });

    // Calculate next page if not directly provided
    if (!isLast) {
      nextPage = currentPage + 1;
    } else {
      nextPage = null; // No next page if it's the last one
    }

    $("#prev-page2").data("value", previousPage);
    $("#next-page2").data("value", nextPage);

    if (currentPage === 1 && isLast) {
      $("#paginations2").html(""); // Hide pagination if there's only one page
    } else {
      $("#prev-page2, #next-page2").show();

      if (currentPage === 1) {
        $("#prev-page2").addClass("disabled");
        $("#prev-page2 a").html("No Previous Page");
      } else {
        $("#prev-page2").removeClass("disabled");
        $("#prev-page2 a").html(
          '<span aria-hidden="true">&laquo;</span> Previous'
        );
      }

      if (isLast) {
        $("#next-page2").addClass("disabled");
        $("#next-page2 a").html("No Next Page");
      } else {
        $("#next-page2").removeClass("disabled");
        $("#next-page2 a").html('Next <span aria-hidden="true">&raquo;</span>');
      }
    }
  }

  $("#coach-tab").on("click", function () {
    coachList(1);
  });

  $(document).on("click", "#whatsapp_btn3", function (e) {
    e.preventDefault();
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");
    similarUrl = $(this).data("academy-url");
    academyPhoneNumber = $(this).data("academy-phone");

    $("#whatsappModalLabel3").text(`Contact ${academyTitle}`);

    $("#formError3").hide();
    $("#whatsappModal3").modal("show");
  });

  $("#close_whatsapp3").on("click", function () {
    $("#whatsappModal3").modal("hide");
  });

  $(document).on("click", "#similarAcademyFormButton3", function () {
    otpFlag = 3;
    let isValid = true,
      errorMessage = "",
      userName = $("#details_name3").val().trim(),
      userEmail = $("#details_email3").val().trim(),
      userPhone = $("#details_phone3").val().trim(),
      userMessage = $("#details_desc3").val().trim();

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

      afterOtp();

    } else {
      $("#formError3").text(errorMessage).show();
    }
  });

  //====Coach tab js ends====//

  //====Player tab js====//

  function playerList(page) {
    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "player",
      },
      success: function (response) {
        if (response.data.details.length > 0) {
          $("#player-listing").empty();
          response.data.details.forEach(function (player) {
            const skillsArray = player.skill
              ? player.skill.split(",")
              : ["Sports", "Fitness", "Workout"];

            let tagsHTML = skillsArray
              .slice(0, 3)
              .map((skill) => `<li>${skill}</li>`)
              .join("");

            let uniquePlayerAddressParts = [
              player.loc_locality_name,
              player.loc_city,
              player.loc_state,
            ].filter(Boolean); // Remove any falsy values (null, undefined, empty string)

            uniquePlayerAddressParts = [...new Set(uniquePlayerAddressParts)];

            let photo = player.logo;
            let photoHTML = '<div class="academy-js">';

            if (photo) {
              photoHTML += `
  <div class="item academy_pics">
    <img src="${base_url}/player/${player.id}/${photo}" loading="lazy" alt="Academy Image"
         onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-1.jpg';" />
  </div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-1.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const playerSport = player.sport ? `${player.sport}` : "Player";
            const playerName = player.name ? player.name : "-";
            const playerFee = player.fee
              ? player.fee
              : player.default_pricing
              ? player.default_pricing
              : "";

            let academyHTML = `
            <a href="${player.url}">
                <div class="academy-box">
                    <figure>
                        ${photoHTML}
                    </figure>
                    <aside>
                        <div class="d-flex">
                            <div class="flex-grow-1 sport-name text-capitalize">${playerSport} Player</div>
                            <div class="rating">
                                <img src="${base_url}/asset/images/star-rating.svg" loading="lazy" alt="Star" height="17" width="17">
                                <strong>${
                                  player.rating ? player.rating : 3.6
                                }</strong> (${
              player.reviews ? player.reviews : 20
            })
                            </div>
                            <div class="verified">
                                <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <h6 class="text-capitalize name-trim">${playerName}</h6>
                            <h6 style="white-space: nowrap;">${playerFee}<span></span></h6>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-end">
                            <div class="content">
                                <p class="name-trim2 text-capitalize"><i class="fa-solid fa-location-dot"></i>${uniquePlayerAddressParts.join(
                                  ", "
                                )}</p>
                                <ul class="tags text-capitalize">
                                    ${tagsHTML}
                                </ul>
                                <p><i class="fa-solid fa-eye"></i> ${
                                  player.views ? player.views : 0
                                } people viewed since last week
                                    <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                                    ${player.views ? player.views : 0}</span>
                                </p>
                            </div>
                            <div class="button">
                                <button id="whatsapp_btn4" data-academy-phone="${
                                  player.phone
                                }" data-academy-name="${
              player.name
            }" data-academy-lat="${player.lat}" data-academy-lng="${
              player.lng
            }" data-academy-locid="${player.loc_id}" data-academy-sport="${
              player.sport
            }" data-academy-sportid="${
              player.sport_id
            }" data-academy-address="${player.city}" data-academy-objectid="${
              player.id
            }" data-academy-url="${player.url}">
                                        <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                                </button>
                            </div>
                        </div>
                    </aside>
                </div>
              </a>
            `;

            window.scrollTo({ top: 0, behavior: "smooth" });
            $("#player-listing").append(academyHTML);
          });

          $("#player-listing").append(`
            <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations3">
           <ul class="pagination">
             <li class="page-item" id="prev-page3">
               <a class="page-link" href="#" aria-label="Previous">
                 <span aria-hidden="true">&laquo;</span> Previous
               </a>
             </li>
             <li class="page-item active" id="current-page3">
               <span class="page-link"></span>
             </li>
             <li class="page-item" id="next-page3">
               <a class="page-link" href="#" aria-label="Next">
                 Next <span aria-hidden="true">&raquo;</span>
               </a>
             </li>
           </ul>
           </nav>
         `);

          updatePagination3(response.data.pagination);
        } else {
          $("#no-data-found").removeClass("d-none");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $(document).on("click", "#prev-page3, #next-page3", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    // Prevent action for last page or first page
    if (page === null || ($this.is("#prev-page3") && page === 0)) {
      e.preventDefault();
      return;
    }
    playerList(page);
  });

  function updatePagination3(data) {
    var currentPage, previousPage, nextPage, isLast;

    data.forEach(function (item) {
      switch (item.name) {
        case "previous":
          previousPage = item.value;
          break;
        case "current":
          currentPage = parseInt(item.value, 10);
          $("#current-page3 span").text(currentPage);
          break;
        case "is_last":
          isLast = item.value === true || item.value === "true"; // Ensure boolean handling
          break;
      }
    });

    // Calculate next page if not directly provided
    if (!isLast) {
      nextPage = currentPage + 1;
    } else {
      nextPage = null; // No next page if it's the last one
    }

    $("#prev-page3").data("value", previousPage);
    $("#next-page3").data("value", nextPage);

    if (currentPage === 1 && isLast) {
      $("#paginations3").html(""); // Hide pagination if there's only one page
    } else {
      $("#prev-page3, #next-page3").show();

      if (currentPage === 1) {
        $("#prev-page3").addClass("disabled");
        $("#prev-page3 a").html("No Previous Page");
      } else {
        $("#prev-page3").removeClass("disabled");
        $("#prev-page3 a").html(
          '<span aria-hidden="true">&laquo;</span> Previous'
        );
      }

      if (isLast) {
        $("#next-page3").addClass("disabled");
        $("#next-page3 a").html("No Next Page");
      } else {
        $("#next-page3").removeClass("disabled");
        $("#next-page3 a").html('Next <span aria-hidden="true">&raquo;</span>');
      }
    }
  }

  $("#player-tab").on("click", function () {
    playerList(1);
  });

  $(document).on("click", "#whatsapp_btn4", function (e) {
    e.preventDefault();
    academyTitle = $(this).data("academy-name");
    academyAddress = $(this).data("academy-address");
    similarSport = $(this).data("academy-sport");
    similarSportId = $(this).data("academy-sportid");
    similarLocationId = $(this).data("academy-locid");
    similarObjectId = $(this).data("academy-objectid");
    similarUrl = $(this).data("academy-url");
    academyPhoneNumber = $(this).data("academy-phone");

    $("#whatsappModalLabel4").text(`Contact ${academyTitle}`);

    $("#formError4").hide();
    $("#whatsappModal4").modal("show");
  });

  $("#close_whatsapp4").on("click", function () {
    $("#whatsappModal4").modal("hide");
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
                                    <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                    <h6>${academyTitle}</h6>
                                </div>

                                <div class="d-flex justify-content-start align-items-start gap-1">
                                    <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                    <h6>${academyAddress}</h6>
                                </div>

                                  ${
                                    academyPhoneNumber
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
                            ${
                              academyPhoneNumber
                                ? `
                                <button class="get_back btn btn-success" id="contact_academy">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Academy
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
          // Handle error response
          console.log(error);
          $("#similarAcademyFormButton4").text("Send").prop("disabled", false);
        },
      });
    } else {
      $("#formError4").text(errorMessage).show();
    }
  });
  //====Player tab js ends====//

  //====Location tab js====//

  function locationList(page) {
    $.ajax({
      url: "/api/get-sdid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "location",
      },
      success: function (response) {
        if (response.data.record.length > 0) {
          // Sort the records alphabetically by locality_name
          response.data.record.sort(function (a, b) {
            return a.locality_name.localeCompare(b.locality_name);
          });

          $("#location-listing").empty();
          response.data.record.forEach(function (location) {
            let academyHTML = `
              <a href="${location.url}"><li class="locality_box">${location.locality_name}</li></a>
            `;

            if (flag2) {
              let localityHtml = `
              <div class="form-check-new mb-2">
                <a href="${location.url}" class="text-capitalize">${location.locality_name}</a>
              </div>
      `;
              $("#localityList").append(localityHtml);
              $("#localityList2").append(localityHtml);
            }

            $("#location-listing").append(academyHTML);
          });

          flag2 = false;
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $("#location-tab").on("click", function () {
    locationList(1);
  });

  //====Location tab js ends====//

  //====Side filter js====//

  $(".show-more").click(function () {
    if ($(".show-more-text").hasClass("show-more-height")) {
      $(this).text("Less...");
    } else {
      $(this).text("More...");
    }

    $(".show-more-text").toggleClass("show-more-height");
  });

  $(".show-more2").click(function () {
    if ($(".show-more-text2").hasClass("show-more-height2")) {
      $(this).text("Less...");
    } else {
      $(this).text("More...");
    }
    $(".show-more-text2").toggleClass("show-more-height2");
  });

  $("#searchSport").on("input", function () {
    var filter = $(this).val().toLowerCase();

    $("#sportsList .form-check").each(function () {
      var sportName = $(this).find("label").text().toLowerCase();

      if (sportName.includes(filter)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  $("#searchSport2").on("input", function () {
    var filter = $(this).val().toLowerCase();

    $("#sportsList2 .form-check").each(function () {
      var sportName = $(this).find("label").text().toLowerCase();

      if (sportName.includes(filter)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  $("#searchLocality").on("input", function () {
    var filter = $(this).val().toLowerCase();

    $("#localityList .form-check-new").each(function () {
      var localityName = $(this).find("a").text().toLowerCase();

      if (localityName.includes(filter)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  $("#searchLocality2").on("input", function () {
    var filter = $(this).val().toLowerCase();

    $("#localityList2 .form-check-new").each(function () {
      var localityName = $(this).find("a").text().toLowerCase();

      if (localityName.includes(filter)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  $("#btn-open").click(function (e) {
    $("#filter-content").slideToggle(
      {
        direction: "up",
      },
      300
    );
    $(this).toggleClass("Close");
  });

  $(document).click(function (e) {
    if (
      !$(e.target).closest("#filter-content").length &&
      !$(e.target).is("#btn-open")
    ) {
      $("#filter-content").slideUp(300);
      $("#btn-open").removeClass("Close");
    }
  });

  //====Side filter js ends====//

  //======enquiry js====//

  $("#getOtpBtn").click(function (event) {
    otpFlag = 1;
    sportFlag = 1;
    event.preventDefault();
    const name = $("#enquiry_name").val();
    const email = $("#enquiry_email").val();
    const phone = $("#enquiry_phone").val();
    const message = $("#enquiry_message").val();
    const sport_id = $("#enquiry_sport").val(); // Get selected sport ID

    // Initialize error message
    let errorMessage;
    let valid = true;

    // Validate inputs
    if (name == "") {
      errorMessage = "Please enter your full name.";
      valid = false;
    } else if (email == "" || !/^\S+@\S+\.\S+$/.test(email)) {
      errorMessage = "Please enter a valid email address.";
      valid = false;
    } else if (phone == "" || !/^\d{10}$/.test(phone)) {
      errorMessage = "Please enter a valid 10-digit phone number.";
      valid = false;
    } else if (sport_id == "") {
      errorMessage = "Please select a sport type.";
      valid = false;
    } else if (message == "") {
      errorMessage = "Please enter your message.";
      valid = false;
    }

    if (valid) {
      $("#enquiry_error").text("");
      $(".enquiry_error_box").css("visibility", "hidden");

       afterOtp();

    
    } else {
      $("#enquiry_error").text(errorMessage);
      $(".enquiry_error_box").css("visibility", "visible");
    }
  });
  $("#getOtpBtn2").click(function (event) {
    event.preventDefault();
    otpFlag = 1;
    sportFlag =2;
    const name = $("#enquiry_name2").val();
    const email = $("#enquiry_email2").val();
    const phone = $("#enquiry_phone2").val();
    const message = $("#enquiry_message2").val();
    const sport_id = $("#enquiry_sport2").val(); // Get selected sport ID

    // Initialize error message
    let errorMessage;
    let valid = true;

    // Validate inputs
    if (name == "") {
      errorMessage = "Please enter your full name.";
      valid = false;
    } else if (email == "" || !/^\S+@\S+\.\S+$/.test(email)) {
      errorMessage = "Please enter a valid email address.";
      valid = false;
    } else if (phone == "" || !/^\d{10}$/.test(phone)) {
      errorMessage = "Please enter a valid 10-digit phone number.";
      valid = false;
    } else if (sport_id == "") {
      errorMessage = "Please select a sport type.";
      valid = false;
    } else if (message == "") {
      errorMessage = "Please enter your message.";
      valid = false;
    }

    if (valid) {
      $("#enquiry_error2").text("");
      $(".enquiry_error_box").css("visibility", "hidden");

      afterOtp();
    } else {
      $("#enquiry_error2").text(errorMessage);
      $(".enquiry_error_box").css("visibility", "visible");
    }
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
  $("#otp_one, #otp_two, #otp_three, #otp_four").on("input", function () {
    var e = !0;
    $("#otp_one, #otp_two, #otp_three, #otp_four").each(function () {
      if ("" === $(this).val()) return (e = !1), !1;
    }),
      e
        ? ($("#btn-signup3").prop("disabled", !1),
          $("#btn-signup3").removeClass("disable_btn"),
          $("#btn-signup3").addClass("signup_verify_btn"))
        : ($("#btn-signup3").prop("disabled", !0),
          $("#btn-signup3").addClass("disable_btn"),
          $("#btn-signup3").removeClass("signup_verify_btn"));
  });

  otpBox44.on("input", function () {
    // alert($("#custom_outside_latitude").val())
    // alert($("#custom_outside_longitude").val())
    if (otpBox11.val() && otpBox22.val() && otpBox33.val() && otpBox44.val()) {
      if (otpFlag == 1) {
        let sport_id;
        let name = $("#enquiry_name").val() || $("#enquiry_name2").val();
        let email = $("#enquiry_email").val() || $("#enquiry_email2").val();
        let phone = $("#enquiry_phone").val() || $("#enquiry_phone2").val();
        let locId = $("#loc_id").val();
        let message =
          $("#enquiry_message").val() || $("#enquiry_message2").val();
          if(sportFlag==1){
            sport_id = $("#enquiry_sport").val()
          }else if(sportFlag==2){
            sport_id = $("#enquiry_sport2").val();
          }
        let otp =
          otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

        $.ajax({
          url: "/api/send-enqury-locid",
          type: "POST",
          async: true,
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            name: name,
            email: email,
            phone: phone,
            message: message,
            sport_id: sport_id,
            otp: otp,
            loc_id: locId,
            lat: latitude,
            lng: longitude,
            type: "sdid enquiry",
          },
          success: function (response) {
            $("#modal01").modal("hide");
            $("#error_msg").text("");
            $("#error_msg").hide();
            $("body").append(`
              <div class="confirm-box" style="z-index: 1000;">
                  <div class="confirm-backdrop"></div>
                  <div class="confirm-content">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                          <h6 style="text-align:center;">${response.message}</h6>
                          <div style="text-align:center">
                              <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                          </div>
                      </div>
                  </div>
              </div>
          `);

            // Reset the form fields
            $("#enquiry_name").val("");
            $("#enquiry_email").val("");
            $("#enquiry_phone").val("");
            $("#enquiry_message").val("");
            $("#enquiry_sport").val("");
            $("#enquiry_name2").val("");
            $("#enquiry_email2").val("");
            $("#enquiry_phone2").val("");
            $("#enquiry_message2").val("");
            $("#enquiry_sport2").val("");
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
      } else if (otpFlag == 2) {
        (userName = $("#details_name2").val().trim()),
          (userEmail = $("#details_email2").val().trim()),
          (userPhone = $("#details_phone2").val().trim()),
          (userMessage = $("#details_desc2").val().trim());
        let otp =
          otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

        $.ajax({
          url: $("#similarAcademyForm").attr("action"),
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            source: "whatsapp",
            sport: similarSport,
            sport_id: similarSportId,
            object_id: similarObjectId,
            object_type: "academy",
            loc_id: similarLocationId,
            screen: "message",
            latitude: latitude,
            longitude: longitude,
            name: userName,
            email: userEmail,
            phone: userPhone,
            description: userMessage,
            otp: otp,
          },
          beforeSend: function () {
            $("#similarAcademyFormButton")
              .text("Sending...!!!")
              .prop("disabled", true);
          },
          success: function (response) {
            $("#whatsappModal2").modal("hide");

            if (response.status == 0) {
              $("#error_msg").show();
              $("#error_msg").text(response.message);
            } else {
              $("#modal01").modal("hide");
              $("body").append(`
              <div class="confirm-box" style="z-index: 1000;">
                  <div class="confirm-backdrop"></div>
                  <div class="confirm-content">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                          <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                          <div class="details_msg">

                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                  <h6>${academyTitle}</h6>
                              </div>

                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                  <h6>${academyAddress}</h6>
                              </div>

                                ${
                                  academyPhoneNumber
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
                          ${
                            academyPhoneNumber
                              ? `
                              <button class="get_back btn btn-success" id="contact_academy">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Academy
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
            }

            // Append success message to the body

            // Re-enable the button and reset text
            $("#similarAcademyFormButton").text("Send").prop("disabled", false);
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.log(error);
            $("#similarAcademyFormButton").text("Send").prop("disabled", false);
          },
        });
      } else if (otpFlag == 3) {
        (userName = $("#details_name3").val().trim()),
          (userEmail = $("#details_email3").val().trim()),
          (userPhone = $("#details_phone3").val().trim()),
          (userMessage = $("#details_desc3").val().trim());
        let otp =
          otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

        $.ajax({
          url: $("#similarAcademyForm3").attr("action"),
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            source: "whatsapp",
            sport: similarSport,
            sport_id: similarSportId,
            object_id: similarObjectId,
            object_type: "coach",
            loc_id: similarLocationId,
            screen: "message",
            latitude: latitude,
            longitude: longitude,
            name: userName,
            email: userEmail,
            phone: userPhone,
            description: userMessage,
            otp: otp,
          },
          beforeSend: function () {
            $("#similarAcademyFormButton3")
              .text("Sending...!!!")
              .prop("disabled", true);
          },
          success: function (response) {
            if (response.status == 0) {
              $("#error_msg").show();
              $("#error_msg").text(response.message);
            } else {
              $("#modal01").modal("hide");
              $("#whatsappModal3").modal("hide");
              $("body").append(`
                <div class="confirm-box" style="z-index: 1000;">
                    <div class="confirm-backdrop"></div>
                    <div class="confirm-content">
                        <div class="confirm-body">
                            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                            <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                            <div class="details_msg">

                                <div class="d-flex justify-content-start align-items-start gap-1">
                                    <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                    <h6>${academyTitle}</h6>
                                </div>

                                <div class="d-flex justify-content-start align-items-start gap-1">
                                    <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                    <h6>${academyAddress}</h6>
                                </div>

                                  ${
                                    academyPhoneNumber
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
                            ${
                              academyPhoneNumber
                                ? `
                                <button class="get_back btn btn-success" id="contact_academy">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Coach
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
            }

            // Re-enable the button and reset text
            $("#similarAcademyFormButton3")
              .text("Send")
              .prop("disabled", false);
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.log(error);
            $("#similarAcademyFormButton3")
              .text("Send")
              .prop("disabled", false);
          },
        });
      }
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
        $("#getOtpBtn").prop("disabled", true).text("Sending...");
        $("#getOtpBtn2").prop("disabled", true).text("Sending...");
      },
      success(response) {
        $("#whatsappModal2").modal("hide");
        $("#whatsappModal3").modal("hide");
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
          $("#otp_one").focus();
          $("#modal01").modal("show");
          $("#error_msg").text("");
          $("#error_msg").hide();
        }
        $("#getOtpBtn").prop("disabled", false).text("SUBMIT");
        $("#getOtpBtn2").prop("disabled", false).text("SUBMIT");
      },
      error(response) {
        $("#getOtpBtn").prop("disabled", false).text("SUBMIT");
        $("#getOtpBtn2").prop("disabled", false).text("SUBMIT");
      },
    });
  }

  $("#resend-otp-signup-locid").click(function () {
    let phone = $("#enquiry_phone").val();
    let email = $("#enquiry_email").val();

    if (!phone) {
      phone = $("#enquiry_phone2").val(); // Fallback to enquiry_phone2
    }

    if (!email) {
      email = $("#enquiry_email2").val(); // Fallback to enquiry_email2
    }

    // Call sendOtp with the determined phone and email
    sendOtp(phone, "identity_verification_otp", email);
  });

  $(document).on("click", ".otp_close", function () {
    $("#modal01").modal("hide");
    $("#error_msg").text("");
    $("#error_msg").hide();
  });
  $(document).on("click", ".change_num", function () {
    $("#modal01").modal("hide");
    $("#error_msg").text("");
    $("#error_msg").hide();
  });

  let countdownTimer;

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

  //======enquiry js ends====//

  function afterOtp(){
    if (otpFlag == 1) {
      let sport_id;
      let name = $("#enquiry_name").val() || $("#enquiry_name2").val();
      let email = $("#enquiry_email").val() || $("#enquiry_email2").val();
      let phone = $("#enquiry_phone").val() || $("#enquiry_phone2").val();
      let locId = $("#loc_id").val();
      let message =
        $("#enquiry_message").val() || $("#enquiry_message2").val();
        if(sportFlag==1){
          sport_id = $("#enquiry_sport").val()
        }else if(sportFlag==2){
          sport_id = $("#enquiry_sport2").val();
        }


      $.ajax({
        url: "/api/send-enqury-locid",
        type: "POST",
        async: true,
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          name: name,
          email: email,
          phone: phone,
          message: message,
          sport_id: sport_id,
          loc_id: locId,
          lat: latitude,
          lng: longitude,
          type: "sdid enquiry",
        },
        success: function (response) {
          $("#modal01").modal("hide");
          $("#error_msg").text("");
          $("#error_msg").hide();
          $("body").append(`
            <div class="confirm-box" style="z-index: 1000;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                        <h6 style="text-align:center;">${response.message}</h6>
                        <div style="text-align:center">
                            <button class="get_back btn btn-secondary" id="back_btn">Go Back</button>
                        </div>
                    </div>
                </div>
            </div>
        `);

          // Reset the form fields
          $("#enquiry_name").val("");
          $("#enquiry_email").val("");
          $("#enquiry_phone").val("");
          $("#enquiry_message").val("");
          $("#enquiry_sport").val("");
          $("#enquiry_name2").val("");
          $("#enquiry_email2").val("");
          $("#enquiry_phone2").val("");
          $("#enquiry_message2").val("");
          $("#enquiry_sport2").val("");
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
    } else if (otpFlag == 2) {
      (userName = $("#details_name2").val().trim()),
        (userEmail = $("#details_email2").val().trim()),
        (userPhone = $("#details_phone2").val().trim()),
        (userMessage = $("#details_desc2").val().trim());
      let otp =
        otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

      $.ajax({
        url: $("#similarAcademyForm").attr("action"),
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: "whatsapp",
          sport: similarSport,
          sport_id: similarSportId,
          object_id: similarObjectId,
          object_type: "academy",
          loc_id: similarLocationId,
          screen: "message",
          latitude: latitude,
          longitude: longitude,
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
          otp: otp,
        },
        beforeSend: function () {
          $("#similarAcademyFormButton")
            .text("Sending...!!!")
            .prop("disabled", true);
        },
        success: function (response) {
          $("#whatsappModal2").modal("hide");

          if (response.status == 0) {
            $("#error_msg").show();
            $("#error_msg").text(response.message);
          } else {
            $("#modal01").modal("hide");
            $("body").append(`
            <div class="confirm-box" style="z-index: 1000;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                        <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                        <div class="details_msg">

                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                <h6>${academyTitle}</h6>
                            </div>

                            <div class="d-flex justify-content-start align-items-start gap-1">
                                <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                <h6>${academyAddress}</h6>
                            </div>

                              ${
                                academyPhoneNumber
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
                        ${
                          academyPhoneNumber
                            ? `
                            <button class="get_back btn btn-success" id="contact_academy">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Academy
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
          }

          // Append success message to the body

          // Re-enable the button and reset text
          $("#similarAcademyFormButton").text("Send").prop("disabled", false);
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.log(error);
          $("#similarAcademyFormButton").text("Send").prop("disabled", false);
        },
      });
    }else if (otpFlag == 3) {
      (userName = $("#details_name3").val().trim()),
        (userEmail = $("#details_email3").val().trim()),
        (userPhone = $("#details_phone3").val().trim()),
        (userMessage = $("#details_desc3").val().trim());
      let otp =
        otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val();

      $.ajax({
        url: $("#similarAcademyForm3").attr("action"),
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          source: "whatsapp",
          sport: similarSport,
          sport_id: similarSportId,
          object_id: similarObjectId,
          object_type: "coach",
          loc_id: similarLocationId,
          screen: "message",
          latitude: latitude,
          longitude: longitude,
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
          otp: otp,
        },
        beforeSend: function () {
          $("#similarAcademyFormButton3")
            .text("Sending...!!!")
            .prop("disabled", true);
        },
        success: function (response) {
          if (response.status == 0) {
            $("#error_msg").show();
            $("#error_msg").text(response.message);
          } else {
            $("#modal01").modal("hide");
            $("#whatsappModal3").modal("hide");
            $("body").append(`
              <div class="confirm-box" style="z-index: 1000;">
                  <div class="confirm-backdrop"></div>
                  <div class="confirm-content">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success Icon"></figure>
                          <h6 style="text-align:center;">Your lead has been submitted successfully</h6>
                          <div class="details_msg">

                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Name:</h6>
                                  <h6>${academyTitle}</h6>
                              </div>

                              <div class="d-flex justify-content-start align-items-start gap-1">
                                  <h6 style="color: #FB5D52; min-width: 100px;">Address:</h6>
                                  <h6>${academyAddress}</h6>
                              </div>

                                ${
                                  academyPhoneNumber
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
                          ${
                            academyPhoneNumber
                              ? `
                              <button class="get_back btn btn-success" id="contact_academy">
                                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp Icon" width="20" height="20">Whatsapp Coach
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
          }

          // Re-enable the button and reset text
          $("#similarAcademyFormButton3")
            .text("Send")
            .prop("disabled", false);
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.log(error);
          $("#similarAcademyFormButton3")
            .text("Send")
            .prop("disabled", false);
        },
      });
    }
  }

  $('#report_locid_issue, #report_locid_issue2').click(function () {
    $('#report-overlay').show();
    $(".side_modal").removeClass("side_open");
    $(".hamburger-menu").removeClass("side_cross");
    $(".side_overlay").hide();
    $("#report-name").val("");
    $("#report-email").val("");
    $("#report-phone").val("");
    $("#report-issue").val("");
    $('#error-report-message').text('');
    $(".side_modal").removeClass("side_open");
  });

});
