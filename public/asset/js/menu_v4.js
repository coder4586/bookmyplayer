$(document).ready(function () {
  let ASSET_URL = $("#asset_url").val();
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

  $("#detect-location-academy2").click(function () {
    redirectToLocation(latitude, longitude);
  });

  function redirectToLocation(latitude, longitude) {
    if(latitude && longitude){
    if (window.location.href.includes('sdid')) {
      let sportId = window.location.href.split('-sdid-')[1];
      sportId = sportId.replace(/(\d+)[#\D].*/, "$1");
      window.location.href = `https://www.bookmyplayer.com/sdid-redirect/${sportId}/${latitude}-${longitude}`;
    }else{
      window.location.href = `https://www.bookmyplayer.com/locid-redirect/${latitude}-${longitude}`;
    }
  }
    
  }

  // $('img.lazy').lazyload({
  //     effect: "fadeIn"
  // });
  // $('img').lazyload({
  //     effect: "fadeIn"
  // });

  // $('.item_card').lazyload({
  //     effect: "fadeIn"
  // });

  $(document).on("click", "#filterBtn", function () {
    $("#filters").show().removeClass("d-none").addClass("col-md-3");
    $("#content").removeClass("col-md-12").addClass("col-md-9");
    $(this).hide();
  });

  $(document).on("click", "#closeFilter", function () {
    $("#filters").addClass("d-none").removeClass("col-md-3");
    $("#content").addClass("col-md-12").removeClass("col-md-9");
    $("#filterBtn").show();
  });

  $(document).on("mouseenter", ".mega_menu", function () {
    let id = $(this).data("id");
    let url = $(this).data("url");

    $.ajax({
      url: url,
      type: "GET",
      data: { id: id },
      success: function (response) {
        $("#categoryModal .modal-body").html(response.data);

        // Remove any previous id-specific classes
        $("#categoryModal").removeClass(function (index, className) {
          return (className.match(/(^|\s)data-id-\S+/g) || []).join(" ");
        });

        // Add the new id-specific class
        $("#categoryModal")
          .addClass("data-id-" + id)
          .modal("show");

        let hasEnteredModal = false;

        $(".modal-body").on("mouseenter", function () {
          hasEnteredModal = true;
        });

        $(".modal-body").on("mouseleave", function () {
          if (hasEnteredModal && $(window).width() > 550) {
            $("#categoryModal").modal("hide");
          }
        });

        if (id == 2 || id == 3) {
          $("#categorySearchInp").on("input", function () {
            let searchValue = $(this).val().toLowerCase();
            $(".categoryList li").each(function () {
              let itemText = $(this)
                .find(".categoryTitle")
                .text()
                .toLowerCase();
              if (itemText.includes(searchValue)) {
                $(this).show();
              } else {
                $(this).hide();
              }
            });
          });
        } else if (id == 1) {
          // Debounce function to limit the rate of function execution
          function debounce(func, delay) {
            let debounceTimer;
            return function () {
              const context = this;
              const args = arguments;
              clearTimeout(debounceTimer);
              debounceTimer = setTimeout(
                () => func.apply(context, args),
                delay
              );
            };
          }

          // Optimized search function with debouncing
          $("#categorySearchInp").on(
            "input",
            debounce(function () {
              let searchValue = $(this).val().toLowerCase();
              $(".city-list li").each(function () {
                let itemText = $(this)
                  .find(".categoryTitle")
                  .text()
                  .toLowerCase();
                if (itemText.includes(searchValue)) {
                  $(this).show();
                } else {
                  $(this).hide();
                }
              });

              if (searchValue) {
                $(".city-list li.hiddenCategoires").removeClass("d-none");
                $("ul.categoryList.city-img-list").hide();
                $(".toggleMore").hide();
              } else {
                $(".city-list li.hiddenCategoires").addClass("d-none");
                $("ul.categoryList.city-img-list").show();
                $(".toggleMore").show();
              }
            }, 300) // 300ms delay for debounce
          );
        }

        $("#closeCityModal, #closeSportModal").on("click", function () {
          $("#categoryModal").modal("hide");
        });
      },
    });
  });

  $(document).on("click", ".toggleMore", function () {
    var value = $(this).data("val");
    $(".city-list li.hiddenCategoires").toggleClass("d-none");
    if ($(".city-list li.hiddenCategoires").hasClass("d-none")) {
      $(this).text("See all " + value);
    } else {
      $(this).text("Hide " + value);
    }
  });

  $(document).on("click", ".locality_tags", function () {
    $('input[name="locality"]').val($(this).text());
  });

  $(document).on("click", ".deleteParam", function () {
    var url = window.location.href;
    url = removeURLParameter(url, $(this).data("name"));
    if (url) {
      window.history.replaceState({}, document.title, url);
      location.reload();
    }
  });

  $(document).on("input", "#searchInput", function () {
    let query = $(this).val().trim();
    let url = $(this).data("url");
    let loader = '<li class="list-group-item text-center">Loading...</li>';

    if (query.length > 0) {
      $("#resultsList").html(loader).show();

      $.ajax({
        url: url,
        type: "GET",
        data: { name: query },
        success: function (response) {
          if (response.status === "success") {
            $("#resultsList").html(response.data);
            $("#resultsList").show();
          }
        },
        error: function (response) {
          $("#resultsList").html("").hide();
        },
      });
    } else {
      $("#resultsList").html("").hide();
    }
  });

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest("#searchResults").length &&
      !$(e.target).is("#searchInput")
    ) {
      $("#resultsList").html("").hide();
    }
  });

  $(document).on("click", "#searchInput", function () {
    if ($("#resultsList").html().trim() !== "") {
      $("#resultsList").show();
    }
  });

  function removeURLParameter(url, parameter) {
    var urlObject = new URL(url);
    urlObject.searchParams.delete(parameter);
    return urlObject.toString();
  }

  $(".search-img").click(function () {
    if ($(".search-width").css("display") === "none") {
      $(".search-width").css("display", "block");
    } else {
      $(".search-width").css("display", "none");
    }
  });

  $("#toggleMenu").on("click", function (event) {
    event.stopPropagation();
    $("#menuBox").css("display", "block");
  });

  $(document).on("click", function (event) {
    if (
      !$(event.target).closest("#menuBox").length &&
      !$(event.target).is("#toggleMenu")
    ) {
      $("#menuBox").css("display", "none");
    }
  });

  $("#menuBox").on("click", function (event) {
    event.stopPropagation();
  });

  $("#subscribeForm").on("submit", function (event) {
    event.preventDefault();
    $(".social-box").show();
    this.submit();
  });

  $("#searchInput2").on("input", function () {
    if ($(this).val().trim() === "") {
      $("#search_result").hide();
    }
    let query = $(this).val();
    let table;
    let selectedCategory = $("#yourSelectId").val();

    if (selectedCategory == "academy") {
      table = "bmp_academy_details";
    } else if (selectedCategory == "coach") {
      table = "bmp_coach_details";
    } else if (selectedCategory == "player") {
      table = "bmp_player_details";
    }

    if (selectedCategory !== "location") {
      if (query.length > 1) {
        $.ajax({
          url: "/bmp-search",
          type: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "basic",
            term: query,
            tbl: table,
          },
          success: function (response) {
            console.log(response);
            let html = "";
            if (response.results && response.results.length === 0) {
              html +=
                '<li class="list-group-item text-center">No data found</li>';
            } else {
              response.results.forEach((entity) => {
                if (
                  selectedCategory === "" ||
                  entity.type.toLowerCase() === selectedCategory.toLowerCase()
                ) {
                  let locationInfo = "";

                  // Build locationInfo based on available data
                  if (entity.city_id === 0) {
                    if (entity.city && entity.state) {
                      locationInfo = `${entity.city}, ${entity.state}`;
                    } else if (entity.city) {
                      locationInfo = entity.city;
                    } else if (entity.state) {
                      locationInfo = entity.state;
                    }
                  } else {
                    if (entity.locality_name && entity.city) {
                      locationInfo = `${entity.locality_name}, ${entity.city}`;
                    } else if (entity.locality_name) {
                      locationInfo = entity.locality_name;
                    } else if (entity.city) {
                      locationInfo = entity.city;
                    }
                  }

                  html += `
                                <a href="${entity.url}">
                                    <li class="list-group-item">
                                        <span class="font-weight-bold text-capitalize">${entity.type}:</span> ${entity.name} - 
                                        <span class="text-primary-custom">${entity.sport_name}</span> - 
                                        <span class="text-primary">${locationInfo}</span>
                                    </li>
                                </a>
                            `;
                }
              });
            }
            $("#search_result").html(html).show();
          },
          error: function (xhr, status, error) {
            console.error(error);
          },
        });
      } else {
        $("#search_result").hide();
      }
    } else if (selectedCategory == "location") {
      if (query.length > 1) {
        $.ajax({
          url: "https://www.bookmyplayer.com/coach/get-location-master",
          type: "GET",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            term: query,
          },
          success: function (response) {
            console.log(response);
            let html = "";
            if (response.locations && response.locations.length === 0) {
              html +=
                '<li class="list-group-item text-center">No data found</li>';
            } else {
              response.locations.forEach((entity) => {
                let locationInfo = '';

                if (entity.city_id === 0) {
                    // When city_id is zero, show locality_name and state
                    if (entity.locality_name && entity.state) {
                        locationInfo = `<span class="text-primary-custom">${entity.locality_name},</span> ${entity.state}`;
                    } else if (entity.locality_name) {
                        locationInfo = entity.locality_name;
                    } else if (entity.state) {
                        locationInfo = entity.state;
                    }
                } else {
                    // When city_id is not zero, show locality_name, city, and state
                    if (entity.locality_name && entity.city && entity.state) {
                        locationInfo = `<span class="text-primary-custom">${entity.locality_name}, ${entity.city},</span> ${entity.state}`;
                    } else if (entity.locality_name && entity.city) {
                        locationInfo = `<span class="text-primary-custom">${entity.locality_name},</span> ${entity.city}`;
                    } else if (entity.locality_name) {
                        locationInfo = entity.locality_name;
                    } else if (entity.city && entity.state) {
                        locationInfo = `<span class="text-primary-custom">${entity.city},</span> ${entity.state}`;
                    } else if (entity.city) {
                        locationInfo = entity.city;
                    } else if (entity.state) {
                        locationInfo = entity.state;
                    }
                }
                

                html += `
                              <a href="${entity.url}">
                                  <li class="list-group-item">
                                      <span class="font-weight-bold text-capitalize">Location:</span>
                                      <span class="text-primary">${locationInfo}</span>
                                  </li>
                              </a>
                          `;
              });
            }
            $("#search_result").html(html).show();
          },
          error: function (xhr, status, error) {
            console.error(error);
          },
        });
      } else {
        $("#search_result").hide();
      }
    }
  });

  $(document).on("click", function (event) {
    if (
      !$(event.target).closest("#searchInput2").length &&
      !$(event.target).closest("#search_result").length
    ) {
      $("#search_result").hide();
      $("#searchInput2").val("");
    }
  });

  $(document).on("click", "#search_result a", function () {
    $("#search_result").hide();
    $("#searchInput2").val("");
  });

  $(".hamburger-menu").on("click", function () {
    $(this).toggleClass("side_cross");
    $(".side_overlay").toggle();
    $(".side_modal").toggleClass("side_open");
  });

  $(".side_overlay").on("click", function () {
    $(".hamburger-menu").removeClass("side_cross");
    $(this).hide();
    $(".side_modal").removeClass("side_open");
  });

  $('#trigger-report').click(function () {
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

  $('#close-report').click(function () {
    $('#report-overlay').hide();
  });

  $('#report-overlay').click(function (e) {
    if (e.target === this) {
      $(this).hide();
    }
  });

  // Form Validation
  $('#report-form').submit(function (e) { 


    let name = $('#report-name').val().trim();
    let email = $('#report-email').val().trim();
    let phone = $('#report-phone').val().trim();
    let issue = $('#report-issue').val().trim();
    let currentPage = window.location.href; // Get the current page URL
    let errorMessage = '';

    let finalIssue = issue + `\n\npage: ${currentPage}`;

    // Validate fields and update the error message
    if (!name) {
        errorMessage = 'Please enter your name.';
    } else if (!email) {
        errorMessage = 'Please enter your email.';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errorMessage = 'Please enter a valid email.';
    } else if (!phone) {
        errorMessage = 'Please enter your phone number.';
    } else if (!/^\d{10}$/.test(phone)) {
        errorMessage = 'Please enter a valid 10-digit phone number.';
    } else if (!issue.trim()) {
        errorMessage = 'Please describe the issue.';
    }

    if (errorMessage) {
      e.preventDefault();
        $('#error-report-message').text(errorMessage);
    } else {
        $('#error-report-message').text('');
        $('#report_latitude').val(latitude);
        $('#report_longitude').val(longitude);
        let finalIssue = issue + `\n\npage: ${currentPage}`;
        $('#report-issue').val(finalIssue);
        $("#report-submit").text("Sending...!!!").prop("disabled", true);
    }
});

$(document).on('click', '.get_back, .confirm-backdrop', function () {
  $('.confirm-box').remove();
});
});
