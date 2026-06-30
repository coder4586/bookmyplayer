$(document).ready(function () {
  const base_url = "https://f005.backblazeb2.com/file/bmpcdn90";
  let academyTitle;
  let academyPhoneNumber;
  let academyAddress;
  let similarSport;
  let similarSportId;
  let similarObjectId;
  let similarLocationId;
  let checkedSports = [];
  let checkedRating = [];
  let tabType = "academy";
  let url = window.location.href;
  let urlId = url.split("/").pop();
  if (urlId.includes("-")) {
    urlId = urlId.split("-").pop();
  }
  urlId = urlId.replace(/(\d+)[#\D].*/, "$1");
  let latitude;
  let longitude;

  $("img").lazyload({
    effect: "fadeIn",
  });

  function showLoadingIndicator() {
    $("#loading-indicator").removeClass("d-none");
    $("#loading-indicator2").removeClass("d-none");
    $("#loading-indicator3").removeClass("d-none");
    $("#loading-indicator4").removeClass("d-none");
    $("#loading-indicator5").removeClass("d-none");
  }

  function hideLoadingIndicator() {
    $("#loading-indicator").addClass("d-none");
    $("#loading-indicator2").addClass("d-none");
    $("#loading-indicator3").addClass("d-none");
    $("#loading-indicator4").addClass("d-none");
    $("#loading-indicator5").addClass("d-none");
  }

  let localStorageLatitude = localStorage.getItem('latitude');
  let localStorageLongitude = localStorage.getItem('longitude');

  if (localStorageLatitude && localStorageLongitude) {
    latitude=localStorageLatitude;
    longitude=localStorageLongitude;
  }else{
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    }
  }

  function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    localStorage.setItem('latitude', latitude);
    localStorage.setItem('longitude', longitude);
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
      // redirectToLocation(latitude, longitude);
  });


    // Function to handle errors in geolocation
    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }

// Function to redirect to the desired URL
function redirectToLocation(latitude, longitude) {
  window.location.href = `https://www.bookmyplayer.com/sdid/redirect/${latitude}-${longitude}`;
}





  showLoadingIndicator();

  setTimeout(function() {
    get_academy_listing(1);
    get_coach_listing(1);
    get_player_listing(1);
    get_sport_listing(1);
    get_location_listing(1);
  }, 2800);


  //=======academy js start========//

  function get_academy_listing(page) {
    $.ajax({
      url: "/get-entity-byLocation",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: tabType,
      },
      success: function (response) {
        let totalRecord
        if(response.data){
          totalRecord = response.data.count;
        }
        if (totalRecord) {
          $("#totalRecords").text(`(${totalRecord})`);
        } else {
          $("#totalRecords").text("(0)");
          $('.academy_tab').hide();
        }

        if (response.data.locations.length > 0) {
          $("#academy-listing").empty();
          response.data.locations.forEach(function (location) {
            const photosArray = location.photos
              ? location.photos.split(",")
              : [];

            let photoHTML = '<div class="academy-js">';

            if (photosArray.length > 0) {
                photoHTML += `<div class="item academy_pics"><img src="${base_url}/academy/${location.id}/${photosArray[0]}" loading="lazy" alt="Academy Image"></div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-3.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const locationSport = location.sport
              ? `${location.sport} Academy`
              : "Academy";
            const locationName = location.name ? location.name : "-";
            const locationFee = location.fee
              ? location.fee
              : location.default_pricing
              ? location.default_pricing
              : "";

            let tagsHTML = `
                <li>Sports</li>
                <li>Fitness</li>
                <li>Core Workout</li>
            `;

            let academyHTML = `
            <a href="${location.url}" target="_blank">
                <div class="academy-box">
                    <figure>
                        ${photoHTML}
                    </figure>
                    <aside>
                        <div class="d-flex">
                            <div class="flex-grow-1 sport-name text-capitalize">${locationSport}</div>
                            <div class="rating">
                                <img src="${base_url}/asset/images/star-rating.svg" loading="lazy" alt="Star" height="17" width="17">
                                <strong>${
                                  location.rating ? location.rating : 3.6
                                }</strong> (${
              location.reviews ? location.reviews : 20
            })
                            </div>
                            <div class="verified">
                                <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <h6 class="text-capitalize name-trim">${locationName}</h6>
                            <h6 style="white-space: nowrap;">${locationFee}<span></span></h6>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-end">
                            <div class="content">
                                <p class="name-trim2"><i class="fa-solid fa-location-dot"></i>${
                                  location.address1
                                }</p>
                                <ul class="tags">
                                    ${tagsHTML}
                                </ul>
                                <p><i class="fa-solid fa-eye"></i> ${
                                  location.views ? location.views : 0
                                } people viewed since last week
                                    <span class="graph"><img src="${base_url}/asset/images/icon-trending-up.svg" loading="lazy" alt="Trend Icon" width="20" height="20">
                                    ${
                                      location.views ? location.views : 0
                                    }</span>
                                </p>
                            </div>
                            <div class="button">
                                <button id="whatsapp_btn"  data-academy-name="${
                                  location.name
                                }" data-academy-lat="${
              location.lat
            }" data-academy-lng="${location.lng}" data-academy-locid="${
              location.loc_id
            }" data-academy-sport="${location.sport}" data-academy-sportid="${
              location.sport_id
            }" data-academy-address="${
              location.address1
            }" data-academy-objectid="${location.id}">
                                        <img src="${base_url}/asset/images/icon-whatsapp.svg" loading="lazy" alt="Whatsapp Icon" height="20" width="20">WhatsApp
                                </button>
                            </div>
                        </div>
                    </aside>
                </div>
                </a>
            `;

            window.scrollTo({ top: 0, behavior: "smooth" });
            $("#academy-listing").append(academyHTML);
            updatePagination(response.data.pagination);
            hideLoadingIndicator();
          });

          hideLoadingIndicator();
        } else {
          $("#no-data-found").removeClass("d-none");
          hideLoadingIndicator();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle any errors here
      },
    });
  }

  $("#prev-page, #next-page").on("click", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    // Prevent action for last page or first page
    if (page === null || ($this.is("#prev-page") && page === 0)) {
      e.preventDefault();
      return;
    }

    get_academy_listing(page);
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

  $("#academy-tab").on('click', function() {
    get_academy_listing(1);
});

$(document).on("click", "#whatsapp_btn", function (event) {
  event.preventDefault();
  academyTitle = $(this).data("academy-name");
  academyAddress = $(this).data("academy-address");
  similarSport = $(this).data("academy-sport");
  similarSportId = $(this).data("academy-sportid");
  similarLocationId = $(this).data("academy-locid");
  similarObjectId =   $(this).data('academy-objectid');
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
      console.log(response);
      console.log("kkk");
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

//=========academy js ends=========//

  //========coach js start============//

  function get_coach_listing(page) {
    $.ajax({
      url: "/get-entity-byLocation",
      type: "POST",
      async: true,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        page: page,
        id: urlId,
        type: "coach",
      },
      success: function (response) {
        let totalRecord
        if(response.data){
          totalRecord = response.data.count;
        }
        if (totalRecord) {
          $("#totalRecords2").text(`(${totalRecord})`);
        } else {
          $("#totalRecords2").text("(0)");
          $('.coach_tab').hide();
        }

        if (response.data.coaches.length > 0) {
          $("#coach-listing").empty();
          response.data.coaches.forEach(function (coach) {
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
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/coach/${coach.id}/${photo}" loading="lazy" alt="Academy Image" class="zoom-out"></div>`;
            } else {
              photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-2.jpg" loading="lazy" alt="Default Image"></div>`;
            }

            photoHTML += "</div>";

            const coachSport = coach.sport ? `${coach.sport} Coach` : "Coach";
            const coachName = coach.name ? coach.name : "-";
            const coachFee = coach.fee
              ? coach.fee
              : coach.default_pricing
              ? coach.default_pricing
              : "";

            let academyHTML = `
            <a href="${coach.url}" target="_blank">
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
                                <p class="name-trim2"><i class="fa-solid fa-location-dot"></i>${
                                  coach.city
                                }</p>
                                <ul class="tags">
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
                                  coach.phone
                                }" data-academy-name="${
              coach.name
            }" data-academy-lat="${coach.lat}" data-academy-lng="${
              coach.lng
            }" data-academy-locid="${coach.loc_id}" data-academy-sport="${
              coach.sport
            }" data-academy-sportid="${coach.sport_id}" data-academy-address="${
              coach.city
            }" data-academy-objectid="${coach.id}">
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
            updatePagination2(response.data.pagination);
            hideLoadingIndicator();
          });

          hideLoadingIndicator();
        } else {
          $("#no-data-found").removeClass("d-none");
          hideLoadingIndicator();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle any errors here
      },
    });
  }

  $("#prev-page2, #next-page2").on("click", function (e) {
    var $this = $(this);
    var page = $this.data("value");

    // Prevent action for last page or first page
    if (page === null || ($this.is("#prev-page2") && page === 0)) {
      e.preventDefault();
      return;
    }

    get_coach_listing(page);
  });

  function updatePagination2(data) {
    var currentPage, isLast;

    data.forEach(function (item) {
      switch (item.name) {
        case "previous":
          $("#prev-page2").data("value", item.value);
          break;
        case "current":
          currentPage = parseInt(item.value);
          $("#current-page2 span").text(currentPage);
          break;
        case "next":
          $("#next-page2").data("value", item.value);
          break;
        case "is_last":
          isLast = item.value;
          break;
      }
    });

    if (currentPage === 1 && isLast) {
      $("#paginations2").html("");
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

  $("#coach-tab").on('click', function() {
    get_coach_listing(1);
});

$(document).on("click", "#whatsapp_btn3", function (e) {
  e.preventDefault();
  academyTitle = $(this).data("academy-name");
  academyAddress = $(this).data("academy-address");
  similarSport = $(this).data("academy-sport");
  similarSportId = $(this).data("academy-sportid");
  similarLocationId = $(this).data("academy-locid");
  similarObjectId =   $(this).data('academy-objectid');
  academyPhoneNumber = $(this).data("academy-phone");

  $("#whatsappModalLabel3").text(`Contact ${academyTitle}`);

  $("#formError3").hide();
  $("#whatsappModal3").modal("show");
});

//coach js ends

//============player js start===========//

function get_player_listing(page) {
  $.ajax({
    url: "/get-entity-byLocation",
    type: "POST",
    async: true,
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
      page: page,
      id: urlId,
      type: "player",
    },
    success: function (response) {
      let totalRecord
      if(response.data){
        totalRecord = response.data.count;
      }
      if (totalRecord) {
        $("#totalRecords3").text(`(${totalRecord})`);
      } else {
        $("#totalRecords3").text("(0)");
        $('.player_tab').hide();
      }

      if (response.data.player.length > 0) {
        $("#player-listing").empty();
        response.data.player.forEach(function (player) {
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
            photoHTML += `<div class="item academy_pics"><img src="${base_url}/player/${player.id}/${photo}" loading="lazy" alt="Academy Image"></div>`;
          } else {
            photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-1.jpg" loading="lazy" alt="Default Image"></div>`;
          }

          photoHTML += "</div>";

          const playerSport = player.sport ? `${player.sport} Player` : "Player";
          const playerName = player.name ? player.name : "-";
          const playerFee = player.fee
            ? player.fee
            : player.default_pricing
            ? player.default_pricing
            : "";

          let academyHTML = `
          <a href="${player.url}" target="_blank">
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
                              <p class="name-trim2"><i class="fa-solid fa-location-dot"></i>${
                                player.city
                              }</p>
                              <ul class="tags">
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
          }" data-academy-sportid="${player.sport_id}" data-academy-address="${
            player.city
          }" data-academy-objectid="${player.id}">
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
          updatePagination3(response.data.pagination);
          hideLoadingIndicator();
        });

        hideLoadingIndicator();
      } else {
        $("#no-data-found").removeClass("d-none");
        hideLoadingIndicator();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      // Handle any errors here
    },
  });
}

function updatePagination3(data) {
  var currentPage, isLast;

  data.forEach(function (item) {
    switch (item.name) {
      case "previous":
        $("#prev-page3").data("value", item.value);
        break;
      case "current":
        currentPage = parseInt(item.value);
        $("#current-page3 span").text(currentPage);
        break;
      case "next":
        $("#next-page3").data("value", item.value);
        break;
      case "is_last":
        isLast = item.value;
        break;
    }
  });

  if (currentPage === 1 && isLast) {
    $("#paginations3").html("");
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

$("#prev-page3, #next-page3").on("click", function (e) {
  var $this = $(this);
  var page = $this.data("value");

  // Prevent action for last page or first page
  if (page === null || ($this.is("#prev-page3") && page === 0)) {
    e.preventDefault();
    return;
  }

  get_player_listing(page);
});

$("#player-tab").on('click', function() {
  get_player_listing(1);
});

$(document).on("click", "#whatsapp_btn4", function (e) {
  e.preventDefault();
academyTitle = $(this).data("academy-name");
academyAddress = $(this).data("academy-address");
similarSport = $(this).data("academy-sport");
similarSportId = $(this).data("academy-sportid");
similarLocationId = $(this).data("academy-locid");
similarObjectId =   $(this).data('academy-objectid');
academyPhoneNumber = $(this).data("academy-phone");

$("#whatsappModalLabel4").text(`Contact ${academyTitle}`);

$("#formError4").hide();
$("#whatsappModal4").modal("show");
});


//============player js ends===========//

//===========sports tab js============//

function get_sport_listing(page) {
  $.ajax({
    url: "/get-entity-byLocation",
    type: "POST",
    async: true,
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
      page: page,
      id: urlId,
      type: "sports",
    },
    success: function (response) {
      let totalRecord
      if(response.data){
        totalRecord = response.data.length;
      }
      if (totalRecord) {
        $("#totalRecords4").text(`(${totalRecord})`);
      } else {
        $("#totalRecords4").text("(0)");
        $('.sports_tab').hide();
      }

      if (response.data.length > 0) {
        $("#sport-listing").empty();
        response.data.forEach(function (sport) {

          let tagsHTML = `
          <li>Sports</li>
          <li>Fitness</li>
          <li>Core Workout</li>
      `;



          let photoHTML = '<div class="academy-js">';
            photoHTML += `<div class="item academy_pics"><img src="${base_url}/asset/images/landing-options-item-img-1.jpg" loading="lazy" alt="Default Image"></div>`;
          photoHTML += "</div>";

          const playSport = sport.sport ? `${sport.sport}` : "Sport";
          let academyHTML = `
              <div class="academy-box">
                  <figure>
                      ${photoHTML}
                  </figure>
                  <aside>
                      <div class="d-flex">
                          <div class="flex-grow-1 sport-name text-capitalize">${playSport}</div>
                          <div class="rating">
                             <span style="font-weight:700">Id:</span>
                              <strong>${
                                sport.sport_id ? sport.sport_id : ""
                              }</strong>
                          </div>
                          <div class="verified">
                              <img src="${base_url}/asset/images/verified.svg" loading="lazy" alt="Verify Icon" height="17" width="17">Verified
                          </div>
                      </div>
                      <div class="d-flex justify-content-between gap-3">
                          <h6 class="text-capitalize name-trim">${playSport}</h6>
                      </div>
                      <div class="d-flex flex-wrap justify-content-between align-items-end">
                          <div class="content">
                              <a href="${sport.url}" target="_blank"><p><i class="fa-regular fa-clock"></i> ${sport.url}</p></a>
                              <ul class="tags">
                                  ${tagsHTML}
                              </ul>
                          </div>
                      </div>
                  </aside>
              </div>
          `;

          window.scrollTo({ top: 0, behavior: "smooth" });
          $("#sport-listing").append(academyHTML);
          hideLoadingIndicator();
        });

        hideLoadingIndicator();
      } else {
        $("#no-data-found").removeClass("d-none");
        hideLoadingIndicator();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      // Handle any errors here
    },
  });
}


$("#sports-tab").on('click', function() {
  get_sport_listing(1);
});

//===========sports tab js ends============//

//===========Location tab js starts============//

function get_location_listing(page) {
  $.ajax({
    url: "/get-entity-byLocation",
    type: "POST",
    async: true,
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
      page: page,
      id: urlId,
      type: "cities",
    },
    success: function (response) {
      let totalRecord
      if(response.data){
        totalRecord = response.data.length;
      }
      if (totalRecord) {
        $("#totalRecords5").text(`(${totalRecord})`);
      } else {
        $("#totalRecords5").text("(0)");
        $('.location_tab').hide();
      }

      if (response.data.length > 0) {
        $("#location-listing").empty();
        response.data.forEach(function (location) {


          let academyHTML = `
            <a href="${location.url}"><li>${location.locality_name}</li></a>
          `;

          $("#location-listing").append(academyHTML);
          hideLoadingIndicator();
        });

        hideLoadingIndicator();
      } else {
        $("#no-data-found").removeClass("d-none");
        hideLoadingIndicator();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      // Handle any errors here
    },
  });
}


$("#location-tab").on('click', function() {
  get_location_listing(1);
});


//===========Location tab js ends============//


  $("#close_whatsapp2").on("click", function () {
    $("#whatsappModal2").modal("hide");
  });
  $("#close_whatsapp3").on("click", function () {
    $("#whatsappModal3").modal("hide");
  });
  $("#close_whatsapp4").on("click", function () {
    $("#whatsappModal4").modal("hide");
  });

  $(document).on("click", "#similarAcademyFormButton3", function () {
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

      // Perform AJAX request
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
          $("#whatsappModal3").modal("hide");

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
          $("#similarAcademyFormButton3").text("Send").prop("disabled", false);
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.log(error);
          $("#similarAcademyFormButton3").text("Send").prop("disabled", false);
        },
      });
    } else {
      $("#formError3").text(errorMessage).show();
    }
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
  })


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

  $(document).click(function (event) {
    if (
      !$(event.target).closest("#filter-content, #btn-open").length &&
      $("#filter-content").is(":visible")
    ) {
      $("#filter-content").slideUp(300);
      $("#btn-open").addClass("Close");
    }
  });



  $(document).on("click", "#similarAcademyFormButton", function () {
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
      // Store data in sessionStorage
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);

      // Perform AJAX request
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
          $("#similarAcademyFormButton").text("Send").prop("disabled", false);
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.log(error);
          $("#similarAcademyFormButton").text("Send").prop("disabled", false);
        },
      });
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

  function getCheckedSports() {
    let checkedValues = [];
    $(".sport-filter:checked").each(function () {
      checkedValues.push($(this).val());
    });
    return checkedValues;
  }

  // Event listener for checkbox change
  $(".sport-filter").on("change", function () {
    checkedSports = getCheckedSports();
  });

  function getCheckedValues() {
    let checkedValues = [];
    $(".rating-check:checked").each(function () {
      checkedValues.push($(this).val());
    });
    return checkedValues;
  }

  // Event listener for checkbox change
  $(".rating-check").on("change", function () {
    checkedRating = getCheckedValues();
  });
});
