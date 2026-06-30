$(document).ready(function () {
  const base_url = "https://f005.backblazeb2.com/file/bmpcdn90";
  let defaultCity = $("#loc_city").val() || "India";
  let flag = true;
  let sportFlag = true;
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
  let sportCount;
  let sportId;
  let otpFlag = 1;
  let url = window.location.href;
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

  // Array of 8 different strings
  let textArray = [];

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
    window.location.href = `https://www.bookmyplayer.com/locid-redirect/${latitude}-${longitude}`;
  }
  //====latitude and longitude js ends====//

  //====Academy tab js====//
  countList(1);
  aboutList(1);
  aboutNearByLocation(1);
  backLinks(1);

  $("#about-tab").on("click", function () {
    $("#about-tab-pane").show();
    $("#about-listing").show();
  });

  function topTabs() {
    $(".tab_height").append(`
          <ul class="nav nav-tabs top_tabs" id="myTab" role="tablist">
           <li class="nav-item about_tab" role="presentation" style="width:auto">
                <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab" aria-controls="about-tab-pane" aria-selected="true">About</button>
            </li>
             <li class="nav-item academy_tab" role="presentation">
                        <button class="nav-link" id="academy-tab" data-bs-toggle="tab" data-bs-target="#academy-tab-pane" type="button" role="tab" aria-controls="academy-tab-pane" aria-selected="true">Academies<span id="totalRecords"></span></button>
                    </li>
                   
                    <li class="nav-item coach_tab" role="presentation">
                        <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach-tab-pane" type="button" role="tab" aria-controls="coach-tab-pane" aria-selected="false">Coaches<span id="totalRecords2"></span></button>
                    </li>
                    <li class="nav-item player_tab" role="presentation">
                        <button class="nav-link" id="player-tab" data-bs-toggle="tab" data-bs-target="#player-tab-pane" type="button" role="tab" aria-controls="player-tab-pane" aria-selected="false">Players<span id="totalRecords3"></span></button>
                    </li>
                    <li class="nav-item sports_tab" role="presentation">
                        <button class="nav-link" id="sports-tab" data-bs-toggle="tab" data-bs-target="#sports-tab-pane" type="button" role="tab" aria-controls="sports-tab-pane" aria-selected="false">Sports<span id="totalRecords4"></span></button>
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

  function academyList(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "academy",
      },
      success: function (response) {

        $("#totalRecords4").html(`(${sportCount})`);

        if (academyCount !== null && academyCount > 0) {
          $("#totalRecords").html(`(${academyCount})`);
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

        if (sportCount !== null && sportCount > 0) {
          $("#totalRecords4").html(`(${sportCount})`);
        } else {
          $(".sports_tab").hide();
        }

        if (locationCount !== null && locationCount > 0) {
          $("#totalRecords5").html(`(${locationCount})`);
        } else {
          $(".location_tab").hide();
        }

        if (academyCount === 0 || academyCount === null) {
          if (coachCount === 0 || coachCount === null) {
            if (playerCount === 0 || playerCount === null) {
            if (sportCount === 0 || sportCount === null) {
              if(locationCount === 0 || locationCount === null ) {
                return;
              }else{
                locationList(1);
                activateTab("#location-tab-pane");
                return;
              }
            }else{
              sportsList(1);
              activateTab("#sports-tab-pane");
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

        if (response.data.details.length > 0) {
          $("#academy-listing").empty();
          $("#about-listing").hide();
          response.data.details.forEach(function (academy) {
            const photosArray = academy.photos ? academy.photos.split(",") : [];

            let photoHTML = '<div class="academy-js">';
            if (photosArray.length > 0) {
              photoHTML += `
              <div class="item academy_pics">
                <link rel="preload" as="image" href="${base_url}/academy/${academy.id}/${photosArray[0]}" />
                <img src="${base_url}/academy/${academy.id}/${photosArray[0]}" alt="Academy Photo" loading="lazy"
                     onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-3.jpg';" />
              </div>`;
            } else {
              photoHTML += `
                <div class="item academy_pics">
                  <link rel="preload" as="image" href="${base_url}/asset/images/landing-options-item-img-3.jpg" />
                  <img src="${base_url}/asset/images/landing-options-item-img-3.jpg" alt="Default Photo" loading="lazy" />
                </div>`;
            }
            photoHTML += "</div>";

            const academySport = academy.adm_sport
              ? `${academy.adm_sport} Academy`
              : "Academy";
            const academyName = academy.name ? academy.name : "-";
            const academyFee = academy.fee
              ? academy.fee
              : academy.default_pricing
              ? academy.default_pricing
              : "";

            let feeHTML =
              academyFee && academyFee.trim() !== ""
                ? `<div class="d-flex justify-content-between gap-3">
        <p>${academyFee}</p>
     </div>`
                : "";

            let tagsHTML = `
                <li>Sports</li>
                <li>Fitness</li>
                <li>Core Workout</li>
            `;

            let academyHTML = `
            <a href="${academy.url}">
                <div class="academy-box new_academy_box">
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
                                }</strong> (${
              academy.reviews ? academy.reviews : 20
            })
                            </div>
                            <div class="verified">
                                <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <h6 class="text-capitalize name-trim">${academyName}</h6>
                        </div>
                       ${feeHTML}
                        <div class="d-flex flex-wrap justify-content-between align-items-end">
                            <div class="content">
                                <p class="name-trim2"><i class="fa-solid fa-academy-dot"></i>${
                                  academy.address1
                                }</p>
                                <p><i class="fa-regular fa-clock"></i> ${
                                  academy.timing
                                    ? academy.timing
                                    : ""
                                }</p>
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

  function backLinks(page) {
    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "about_entity_backlinks",
      },
      success: function (response) {
        if (response.data.record.academy_backlinks.length > 0) {
          $(".other-backlinks-academy").removeClass("hidden")
          const backlinks = response.data.record.academy_backlinks;

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
          $(".other_academy_links").html(listItems);
        }

        if (response.data.record.coach_backlinks.length > 0) {
          $(".other-backlinks-coach").removeClass("hidden")
          const backlinks = response.data.record.coach_backlinks;

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

        if (response.data.record.player_backlinks.length > 0) {
          $(".other-backlinks-player").removeClass("hidden")
          const backlinks = response.data.record.player_backlinks;

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
        if (response.data.record.sport_backlinks.length > 0) {
          const backlinks = response.data.record.sport_backlinks;


          $(".other-backlinks-sports").removeClass("hidden");
          
        
          const listItems = backlinks
          .map((link) => {
            let locationDisplay;
            if (
              link.locality_name &&
              link.city &&
              link.locality_name.toLowerCase() === link.city.toLowerCase()
            ) {
              locationDisplay = link.city;
            } else if (!link.locality_name) {
              locationDisplay = link.city || "";
            } else if (!link.city) {
              locationDisplay = link.locality_name;
            } else {
              locationDisplay = `${link.locality_name}, ${link.city}`;
            }
        
            // Construct the list item
            return `<li class="text-capitalize other_link_li">
                      <a href="${link.url}" class="text-capitalize">
                        Learn ${link.sport} in ${locationDisplay}
                      </a>
                    </li>`;
          })
          .join("");   
        
          $(".other_sports_links").html(listItems);
        }
        if (response.data.record.location_backlinks.length > 0) {
          $(".other-backlinks-location").removeClass("hidden")
          const backlinks = response.data.record.location_backlinks;

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
        console.error("about error:");
      },
    });
  }
  function countList(page) {
    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "counts",
      },
      success: function (response) {
        academyCount = response.data.counts.academy;
        coachCount = response.data.counts.coach;
        playerCount = response.data.counts.player;
        locationCount = response.data.counts.location;
        sportCount = response.data.counts.sport;
        
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        console.error("about error:");
      },
    });
  }


  function aboutList(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "about",
      },
      success: function (response) {
        $("#totalRecords4").html(`(${sportCount})`);

        if (response.data.record.location_ai_info.length == 0) {
          $(".about_tab").hide();
          academyList(1);
          if (academyCount > 0) {
            activateTab("#academy-tab-pane");
          } else if (coachCount > 0) {
            activateTab("#coach-tab-pane");
          } else if (playerCount > 0) {
            activateTab("#player-tab-pane");
          } else {
            activateTab("#sports-tab-pane");
          }
          return;
        } else {
          $(".about_tab").show();
        }
        if (academyCount !== null && academyCount > 0) {
          $("#totalRecords").html(`(${academyCount})`);
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

        if (sportCount !== null && sportCount > 0) {
          $("#totalRecords4").html(`(${sportCount})`);
        } else {
          $(".sports_tab").hide();
        }

        if (locationCount !== null && locationCount > 0) {
          $("#totalRecords5").html(`(${locationCount})`);
        } else {
          $(".location_tab").hide();
        }

        let fullDesc;

        if (response.data.record.location_ai_info.length > 0) {
          fullDesc = response.data.record.location_ai_info[0].description;
        }

        if (fullDesc != null) {
          $(".about_box").removeClass("hidden");
        }

        $(".about_description").html(`<p>${fullDesc}</p>`);

        let reviewsHtml = "";
        if (response.data.record.reviews.length > 0) {
          $(".review_wrapper").removeClass("hidden");

          response.data.record.reviews.slice(0, 5).forEach(function (review) {
            const starsImage = `<img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${review.rating}star.png" loading="lazy" alt="Star" height="12" width="64">`;

            reviewsHtml += `
        <div class="card">
          <div class="card-header">
            <div class="card-image">
              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mob_reply.svg" class="img-fluid" loading="lazy" alt="Images" width="50" height="50">
            </div>
            <div class="card-info">
              <h6 class="text-capitalize">${review.name}</h6>
            </div>
            <div class="card-rating">
              ${starsImage}
            </div>
          </div>
          <div class="card-content">
            <p>${review.comment}</p>
          </div>
        </div>
      `;
          });

          // Append the generated HTML to the coach-reviews class
          $("#coach-reviews").html(reviewsHtml);
        }

        let photos = response.data.record.location_ai_info[0].photos;

        if (!photos) {
          photos = "";
        }
        const first = photos.split(",");
        const firstPhotoUrl = first[0]
          ? first[0]
          : "https://f005.backblazeb2.com/file/bmpcdn90/default/football_banner.webp";
        const secondPhotoUrl = first[1]
          ? first[1]
          : "https://f005.backblazeb2.com/file/bmpcdn90/default/football_banner.webp";

        $(".listing_banner").html(`
          <img src="${firstPhotoUrl}" alt="Academy Image" class="academy_image">
        `);

          $(".listing_banner").append(`
            <div class="banner_text">
              <div class="animated_text"></div>
            </div>
          `);


        $(".listing_banner2").html(`
          <img src="${secondPhotoUrl}" loading="lazy" alt="Academy Image" class="academy_image">
        `);


        const locationAIInfo = response.data.record.location_ai_info;
        const filterAcademies = response.data.record.filter_academies;
        const sortedSports = Object.keys(filterAcademies).sort((a, b) => {
            return a.toLowerCase().localeCompare(b.toLowerCase());
        });
        
        for (const sport of sortedSports) {
            if (filterAcademies[sport].length > 0) {
                const sportContainer = $('.sport_container'); // The container where sports will be appended
        
                // Initialize heading text
                let headingText = sport === 'gym'
                    ? `Join <span class="text-capitalize">${sport}</span>`
                    : `Get <span class="text-capitalize">${sport}</span> Training`;
        
                // Add pricing information if available
                locationAIInfo?.forEach(location => {
                    location?.pricing?.forEach(pricing => {
                        if (pricing?.sport?.toLowerCase() === sport?.toLowerCase()) {
                            const priceText = typeof pricing?.pricing === 'object'
                                ? `Starting at ₹${pricing.pricing.individual}`
                                : `Starting at ₹${pricing.pricing}`;
                            headingText += ` (${priceText})`; // Append pricing information
                        }
                    });
                });
        
                // Create the section for the sport
                const sportSection = $(`
                    <section class="popular-sports-academies-section white-box clearfix" style="margin-top:30px; margin-bottom:30px;">
                        <div>
                            <div class="top_flex mb-3">
                                <h6>${headingText}</h6>
                                <div class="slider_arrow">
                                    <button class="btn custom-view-all sport_view_all" 
                                        data-sport-id="${filterAcademies[sport][0]?.data?.sport_id}">
                                        View All
                                    </button>
                                </div>
                            </div>
                            <div class="js-popular-sports-academies sport_box d-flex"></div>
                        </div>
                    </section>
                `);
        
                const sportContent = sportSection.find(".sport_box");
        
                // Append all academies/coaches for the sport
                filterAcademies[sport].forEach(item => {
                    const data = item.data;
                    const entityType = item.type;
                    const photo = data.photos 
                    ? data.photos.split(",")[0] 
                    : (data.profile_img || data.logo || "");
                

    let imgUrl;
    if (photo) {
        switch (entityType) {
            case "academy":
                imgUrl = `https://f005.backblazeb2.com/file/bmpcdn90/academy/${data.id}/${photo}`;
                break;
            case "coach":
                imgUrl = `https://f005.backblazeb2.com/file/bmpcdn90/coach/${data.id}/${photo}`;
                break;
            case "player":
                imgUrl = `https://f005.backblazeb2.com/file/bmpcdn90/player/${data.id}/${photo}`;
                break;
        }
    } else {
        switch (entityType) {
            case "academy":
                imgUrl = "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-3.jpg";
                break;
            case "coach":
                imgUrl = "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-2.jpg";
                break;
            case "player":
                imgUrl = "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-2.jpg";
                break;
            default:
                imgUrl = "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-3.jpg";
                break;
        }
    }

        
                    const cardHtml = `
                        <div class="popular-sports-academies-item col-4" style="padding: 10px; box-sizing: border-box;">
                            <a href="${data.url}">
                                <div class="academy_card">
                                    <div class="popular-sports-academies-inner">
                                        <div class="image-wrapper" style="position: relative;">
    <img src="${imgUrl}" loading="lazy" alt="Image" class="academy_image" 
         onerror="this.onerror=null; this.src='https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-3.jpg';">
    <!-- Entity Type Tag -->
    <div class="entity-tag text-capitalize">
        ${entityType}
    </div>
</div>

                                        <div class="popular-sports-content">
                                            <p class="academy_name mt-2">
                                                <a href="${data.url}">${data.name}</a>
                                            </p>
                                            <p class="academy_name mt-2 mb-2 text-capitalize">
                                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/location2.svg" 
                                                     alt="location" loading="lazy" width="14" height="14" style="margin-right:0.2rem;">
                                                 ${(data.address?.trim() || defaultCity)}
                                            </p>
                                            <p class="mt-2 mb-2 academy_name">
                                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/clock.png" 
                                                     alt="clock" loading="lazy" height="14" width="14" style="margin-right: 0.2rem;">
                                                ${data.timing || ""}
                                            </p>
                                            <p class="mt-2 mb-2 academy_name text-capitalize">${data.sport || "Sport"}</p>
                                            <div class="sport-logo-text">
                                                <div class="left-box">
                                                    <span>
                                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/single-star.png" 
                                                             loading="lazy" alt="Star Icon" width="17" height="17"> 
                                                        <b>${data.rating || "4"}</b> (${data.reviews || "25"})
                                                    </span>
                                                </div>
                                                <span>
                                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/verified-icon-svg.svg" 
                                                         loading="lazy" alt="Verify Icon" width="17" height="17"> Verified
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
        
                    sportContent.append(cardHtml);
                });
        
                // Append the sport section to the sport_container
                sportContainer.append(sportSection);
            }
        }
        
        

// Variables for animation
let animations = ["slideFromLeft"];
let index = 0;
let textArray = [];

function animateText() {
  let $bannerText = $(".banner_text");
  let $textElement = $(`<h6 class="animated_text text-capitalize"></h6>`);

  $textElement.text(textArray[index % textArray.length]);
  $textElement.addClass(animations[0]);

  $bannerText.append($textElement);

  // Increment index
  index++;

  // Stop when all texts are displayed
  if (index < textArray.length) {
    setTimeout(animateText, 2500); // 2.5 seconds interval
  }
}


        // Pricing Data Logic with Animation Integration
        if (response.data.record.location_ai_info[0].pricing.length > 0) {
          $(".sport_price_box").removeClass("hidden");

          response.data.record.location_ai_info[0].pricing.sort((a, b) =>
            a.sport.localeCompare(b.sport)
          );

          response.data.record.location_ai_info[0].pricing.forEach(
            (item, index) => {
              let pricing = item.pricing;

              // Generate pricing text for both individual and group
              let pricingText =
                typeof pricing === "object"
                  ? `
        <div class="tag_flex">
          <div class="tab_tags">
            <div class="tag">Individual:</div><span class="tag_price">₹${pricing.individual}</span>
          </div>
          <div class="tab_tags">
            <div class="tag">Group:</div> <span class="tag_price"> ₹${pricing.group}</span>
          </div>
        </div>
      `
                  : `₹${pricing}`;

                  let textEntry = `${item.sport} Training Starting at ₹${
                    typeof pricing === "object" ? pricing.group : pricing
                  }`;
            

              // Push the text entry to the text array for animation
              textArray.push(textEntry);

              // Generate the table row HTML
              let row = `
      <tr class="text-capitalize">
        <th scope="row">${index + 1}</th>
        <td class="text-left">${item.sport}</td>
        <td class="text-left">${pricingText}</td>
      </tr>
    `;

              // Append the row to the sport price table
              $(".sport-price-table").append(row);
            }
          );

          // Start the animation if text entries exist
          if (textArray.length > 0) {
            animateText();
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        console.error("about error:");
      },
    });
  }

  function aboutNearByLocation(page){
    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "about_nearby_locations",
      },
      success: function (response) {

        let nearbyLocationsHtml = "";
        if (response.data.record.nearby_locations.length > 0) {
          $(".top-cities-section").removeClass("hidden");
          response.data.record.nearby_locations
            .slice(0, 10)
            .forEach(function (location, index) {
              // Default sports array when sport_names is null or empty
              let sports = ["Sports", "Fitness"];

              // If sport_names is not null, split and get the sports names
              if (location.sport_names) {
                sports = location.sport_names.split(",").map((s) => s.trim());
              }

              // Sort the sports array alphabetically
              sports.sort();

              // Create HTML for the initial sports list (first 3 or less)
              let displayedSports = sports
                .slice(0, 3)
                .map((s) => `<li>${s}</li>`)
                .join("");

              // Create the "More" and "Less" button behavior
              let moreButton = "";
              let fullSportsList = "";

              if (sports.length > 3) {
                // If there are more than 3 sports, add the "More" button
                moreButton = `<li class="show-more-btn" id="moreBtn-${index}">More</li>`;
                fullSportsList = sports.map((s) => `<li>${s}</li>`).join("");
              }

              // Generate the location HTML
              nearbyLocationsHtml += `
                <a href="${location.url}" class="col-lg-6">
                  <div>
                    <div class="location-card">
                      <img src="https://cdn90.s3.ap-south-1.amazonaws.com/asset/images/menu/ahmedabad.png" loading="lazy" alt="Location Image" class="location-img">
                      <div class="location-info">
                        <h6>${location.locality_name}</h6>
                        <div class="d-flex align-items-center">
                          <div class="rating-stars">
                            <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/5star.png" loading="lazy" alt="Star Icon" height="12" width="64">
                          </div>
                          <span class="rating-count">(${location.total_academies})</span>
                        </div>
                        <div class="new_tags">
                          <ul class="tags text-capitalize" id="sportsList-${index}">
                            ${displayedSports}
                            ${moreButton}
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              `;
            });

          // Append the generated HTML to a container
          $("#container").html(nearbyLocationsHtml);

          // Use jQuery to handle the "More" and "Less" functionality after the HTML is rendered
          $(document).on("click", ".show-more-btn", function (event) {
            event.stopPropagation();
            event.preventDefault();

            const index = $(this).attr("id").split("-")[1]; // Extract the index from the button's ID
            const sportsList = $(`#sportsList-${index}`);
            let sports = response.data.record.nearby_locations[index]
              .sport_names
              ? response.data.record.nearby_locations[index].sport_names
                  .split(",")
                  .map((s) => s.trim())
              : ["Sports", "Fitness", "Core Workout"];

            // Sort the sports array alphabetically
            sports.sort();

            if ($(this).text() === "More") {
              // Display full sports list and add "Less" button
              sportsList.html(
                sports.map((s) => `<li>${s}</li>`).join("") +
                  `<li class="show-more-btn" id="moreBtn-${index}">Less</li>`
              );
            } else {
              // Display only first 3 sports and add "More" button
              sportsList.html(
                sports
                  .slice(0, 3)
                  .map((s) => `<li>${s}</li>`)
                  .join("") +
                  `<li class="show-more-btn" id="moreBtn-${index}">More</li>`
              );
            }
          });

          // Append the generated HTML to the top-cities class
          $(".top-cities").html(nearbyLocationsHtml);
        }

      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        console.error("about error:");
      },
    });
  }

  $(document).on("click", ".sport_view_all", function () {
    const $this = $(this);
    const sportNewId = $(this).data("sport-id");
    $.ajax({
      url: "https://www.bookmyplayer.com/api/get-sdid-url",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        loc_id: urlId,
        sport_id: sportNewId,
      },
      success: function (response) {
        if (response.status == 0) {
          $this.prop("disabled", true);
        } else if (response.status == 1) {
          window.open(response.url, "_self");
        }
      },
      error: function () {
        console.log("Failed to load more sports. Please try again.");
      },
    });
  });

  setTimeout(function () {
    filters(1);
    sportsList(1);
  }, 0);

  function filters(page) {
    if (flag) {
      topTabs();
      flag = false;
    }

    $.ajax({
      url: "/api/get-locid",
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
            if (response.data.record.location.length > 5) {
              $(".show-more").removeClass("d-none");
            }
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
      url: "/api/get-locid",
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
          $("#about-listing").hide();
          response.data.details.forEach(function (coach) {
            let locationArray = [
              coach.loc_locality_name,
              coach.loc_city,
              coach.loc_state,
            ];
            let uniqueLocationSet = new Set(locationArray);
            let uniqueLocations = Array.from(uniqueLocationSet);
            let locationString = uniqueLocations.join(", ");
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
    <img src="${base_url}/coach/${coach.id}/${photo}" loading="lazy" alt="Coach Image"
         onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-2.jpg';" />
  </div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-2.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const coachSport = coach.adm_sport
              ? `${coach.adm_sport} Coach`
              : "Coach";
            const coachName = coach.name ? coach.name : "-";
            const coachFee = coach.fee
              ? coach.fee
              : coach.default_pricing
              ? coach.default_pricing
              : "";

            let academyHTML = `
            <a href="${coach.url}">
                <div class="academy-box">
                    <figure>
                        ${photoHTML}
                    </figure>
                    <aside>
                        <div class="d-flex">
                            <div class="flex-grow-1 sport-name text-capitalize">${coachSport}</div>
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
                        <div class="d-flex flex-wrap justify-content-between align-items-end">
                            <div class="content">
                                <p class="name-trim2 text-capitalize"><i class="fa-solid fa-location-dot"></i>${locationString}</p>
                                <ul class="tags text-capitalize">
                                    ${tagsHTML}
                                </ul>
                                <p><i class="fa-solid fa-eye"></i> ${
                                  coach.views ? coach.views : 0
                                } people viewed since last week
                                    <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                                    ${coach.views ? coach.views : 0}</span>
                                </p>
                            </div>
                            <div class="button">
                                <button id="whatsapp_btn3" data-academy-phone="${
                                  coach.phone ? coach.phone : ""
                                }" data-academy-name="${
              coach.name
            }" data-academy-lat="${coach.lat}" data-academy-lng="${
              coach.lng
            }" data-academy-locid="${coach.loc_id}" data-academy-sport="${
              coach.sport
            }" data-academy-sportid="${coach.sport_id}" data-academy-address="${
              coach.loc_locality_name ? coach.loc_locality_name : ""
            }" data-academy-objectid="${coach.id}" data-academy-url="${coach.url}">
                                        <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                                </button>
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

    $.ajax({
      url: "/get-entity-contact",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        object_id: similarObjectId,
        object_type: "coach",
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
      url: "/api/get-locid",
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
          $("#about-listing").hide();
          response.data.details.forEach(function (player) {
            let locationArray = [
              player.loc_locality_name,
              player.loc_city,
              player.loc_state,
            ];
            let uniqueLocationSet = new Set(locationArray);
            let uniqueLocations = Array.from(uniqueLocationSet);
            let locationString = uniqueLocations.join(", ");
            const skillsArray = player.skill
              ? player.skill.split(",")
              : ["Sports", "Fitness", "Workout"];

            let tagsHTML = skillsArray
              .slice(0, 3)
              .map((skill) => `<li>${skill}</li>`)
              .join("");

            let photo = player.logo;
            let photoHTML = '<div class="academy-js">';

            if (photo) {
              photoHTML += `
  <div class="item academy_pics">
    <img src="${base_url}/player/${player.id}/${photo}" loading="lazy" alt="Player Image"
         onerror="this.onerror=null;this.src='${base_url}/asset/images/landing-options-item-img-1.jpg';" />
  </div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-1.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const playerSport = player.adm_sport
              ? `${player.adm_sport} Player`
              : "Player";
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
                            <div class="flex-grow-1 sport-name text-capitalize">${playerSport}</div>
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
                                <p class="name-trim2 text-capitalize"><i class="fa-solid fa-location-dot"></i>${locationString}</p>
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

  //====Sports tab js ====//

  function sportsList(page) {
    $.ajax({
      url: "/api/get-locid",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "sport",
      },
      success: function (response) {
        if (response.data.record.length > 0) {
          $("#sport-listing").empty();
          response.data.record.forEach(function (sport) {
            let tagsHTML = `
            <li>Sports</li>
            <li>Fitness</li>
            <li>Core Workout</li>
        `;

            let photoHTML = '<div class="academy-js sport_js">';
            photoHTML += `<div class="item academy_pics">

            <img src="https://f005.backblazeb2.com/file/bmpcdn90/default/${sport.sport}_banner.webp" loading="lazy" alt="Default Image" onerror="this.onerror=null;this.src='https://f005.backblazeb2.com/file/bmpcdn90/asset/images/landing-options-item-img-1.jpg';">

`;
            photoHTML += "</div>";

            const playSport = sport.sport ? `${sport.sport}` : "Sport";

            let locationDisplay;
            if (
              sport.locality_name &&
              sport.city &&
              sport.locality_name.toLowerCase() === sport.city.toLowerCase()
            ) {
              locationDisplay = sport.city;
            } else if (!sport.locality_name) {
              locationDisplay = sport.city || defaultCity;
            } else if (!sport.city) {
              locationDisplay = sport.locality_name;
            } else {
              locationDisplay = `${sport.locality_name}, ${sport.city}`;
            }

            let academyHTML = `
                            <a href="${sport.url}">
                <div class="academy-box">

                    <figure>
                        ${photoHTML}
                    </figure>
                    <aside>
                        <div class="d-flex">
                            <div class="flex-grow-1 sport-name text-capitalize">${playSport}</div>
                            <div class="verified">
                                <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <h6 class="text-capitalize name-trim">Learn ${playSport} in ${locationDisplay} </h6>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-end">
                            <div class="content">
                                <ul class="tags">
                                    ${tagsHTML}
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                                  </a>
            `;

            let sportFilter = `
            <a href="${sport.url}" style="cursor:pointer;">
               <div class="form-check mb-2" style="padding-left:0;">
                    <label class="form-check-label text-capitalize" for="sport">${playSport}</label>
               </div>
              </a>
            `;

            window.scrollTo({ top: 0, behavior: "smooth" });
            $("#sport-listing").append(academyHTML);

            if (sportFlag) {
              if (response.data.record.length > 5) {
                $(".show-more2").removeClass("d-none");
              }
              $("#sportsList").append(sportFilter);

              $("#sportsList2").append(sportFilter);
            }
          });
          sportFlag = false;
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  }

  $("#sports-tab").on("click", function () {
    $("#about-listing").hide();
    sportsList(1);
  });

  //====Sports tab js ends====//

  //====Location tab js====//

  function locationList(page) {
    $.ajax({
      url: "/api/get-locid",
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

          $("#location-listing").empty();
          $("#about-listing").hide();
          response.data.record.forEach(function (location) {
            let academyHTML = `
              <a href="${location.url}"><li class="locality_box">${location.locality_name}</li></a>
            `;
            $("#location-listing").append(academyHTML);
          });
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

  $("#btn-open").click(function () {
    $("#filter-content").slideToggle(
      {
        direction: "up",
      },
      300
    );
    $(this).toggleClass("Close");
  });

  //====Side filter js ends====//

  //======enquiry js====//

  $("#getOtpBtn").click(function (event) {
    otpFlag = 1;
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
    if (otpBox11.val() && otpBox22.val() && otpBox33.val() && otpBox44.val()) {
      if (otpFlag == 1) {
        let name = $("#enquiry_name").val() || $("#enquiry_name2").val();
        let email = $("#enquiry_email").val() || $("#enquiry_email2").val();
        let phone = $("#enquiry_phone").val() || $("#enquiry_phone2").val();
        let message =
          $("#enquiry_message").val() || $("#enquiry_message2").val();
        let sport_id = $("#enquiry_sport").val() || $("#enquiry_sport2").val();
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
            loc_id: urlId,
            lat: latitude,
            lng: longitude,
            city: $("#loc_city").val(),
            state: $("#loc_state").val(),
            type: "loc-id enquiry",
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

  //======enquiry js ends====//

  function initializeSlider(
    scrollLeftSelector,
    scrollRightSelector,
    sliderSelector
  ) {
    let $scrollLeft = $(scrollLeftSelector);
    let $scrollRight = $(scrollRightSelector);
    let $slider = $(sliderSelector);

    function getScrollAmount() {
      return $(window).width() >= 1100 ? 400 : 275;
    }

    $scrollLeft.click(function () {
      $slider.animate({ scrollLeft: `-=${getScrollAmount()}` }, "smooth");
    });

    $scrollRight.click(function () {
      $slider.animate({ scrollLeft: `+=${getScrollAmount()}` }, "smooth");
    });
  }

  // Initialize the slider with the specified selectors
  initializeSlider("#scroll-left-one", "#scroll-right-one", ".academies_box");
  initializeSlider("#scroll-left-two", "#scroll-right-two", ".stay_active");

  // Open file input dialog when Upload Photos button is clicked
  // Open file input when clicking "Upload Photos" button
  $("#customUploadButton").on("click", function () {
    $("#photoUpload").click(); // Trigger file input click
  });

  // Handle file selection and show modal with image previews and captions
  $("#photoUpload").on("change", function (event) {
    const files = event.target.files;
    const imagePreviewContainer = $("#imagePreviewContainer");
    imagePreviewContainer.empty(); // Clear previous images if any

    // Loop through selected files and generate preview with caption inputs
    $.each(files, function (i, file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const imageBox = `
              <div class="col-12 col-md-6 image-box-new mb-4 position-relative">
                  <img src="${e.target.result}" alt="Uploaded Image" loading="lazy" class="img-thumbnail">
                  <div class="caption-input mt-2">
                      <textarea class="form-control" placeholder="Enter caption" required></textarea>
                  </div>
                  <button class="remove-image-btn btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;">Remove</button>
              </div>
          `;
        imagePreviewContainer.append(imageBox);

        // Set the height of the textarea to match the image after it's appended
        const img = imagePreviewContainer.find(".img-thumbnail").last();
        const textarea = imagePreviewContainer.find("textarea").last();
        textarea.height(img.height());
      };
      reader.readAsDataURL(file);
    });

    $("#photoUploadModal").modal("show"); // Show modal when images are selected
  });

  // Handle removing an image from the preview
  $(document).on("click", ".remove-image-btn", function () {
    $(this).closest(".image-box-new").remove(); // Remove the entire image box
  });

  // Handle the "Post Review" button click
  $("#postReview").on("click", function () {
    const name = $("#name").val();
    const phone = $("#phone").val();
    const email = $("#email").val();

    if (name === "" || phone === "" || email === "") {
      return;
    }

    // Post review logic can go here
    $("#photoUploadModal").modal("hide");
  });

  // Handle the "Upload Photos" button click
  $("#uploadPhotos").on("click", function () {
    const captions = [];
    let valid = true;
    $("#imagePreviewContainer .image-box-new").each(function () {
      const caption = $(this).find("textarea").val();
      if (caption === "") {
        valid = false;
        return false; // Break out of the loop if validation fails
      }
      captions.push(caption);
    });

    if (!valid) return; // Stop if caption validation failed

    $("#photoUploadModal").modal("hide");
  });

  // Handle modal close on cross icon click
  $("#closeModal").on("click", function () {
    $("#photoUploadModal").modal("hide");
  });

  let countdownTimer;

  function startCountdown() {
    let timeLeft = 120;
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

  function afterOtp(){
    if (otpFlag == 1) {
      let name = $("#enquiry_name").val() || $("#enquiry_name2").val();
      let email = $("#enquiry_email").val() || $("#enquiry_email2").val();
      let phone = $("#enquiry_phone").val() || $("#enquiry_phone2").val();
      let message =
        $("#enquiry_message").val() || $("#enquiry_message2").val();
      let sport_id = $("#enquiry_sport").val() || $("#enquiry_sport2").val();


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
          loc_id: urlId,
          lat: latitude,
          lng: longitude,
          city: $("#loc_city").val(),
          state: $("#loc_state").val(),
          type: "loc-id enquiry",
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
            $("#whatsappModal3").modal("hide");
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
