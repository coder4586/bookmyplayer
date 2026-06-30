$(document).ready(function () {
  let sub_tournament = [];
  let sub_tournamentString = "";
  let localStorageLatitude = localStorage.getItem("latitude");
  let localStorageLongitude = localStorage.getItem("longitude");
  let latitude;
  let longitude;
  let academyTitle;
  let academyPhoneNumber;
  let tournamentPhotosMap = {};
  let leadArray = [];
  $("#details_desc").val("");

  let url = window.location.href;
  let urlId = url.split("/").pop();
  if (urlId.includes("-")) {
    urlId = urlId.split("-").pop();
  }
  urlId = urlId.replace(/(\d+)[#\D].*/, "$1");

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

  const sportsOptions = [
    { value: "29", label: "Archery" },
    { value: "12", label: "Arts" },
    { value: "26", label: "Athletics" },
    { value: "6", label: "Badminton" },
    { value: "36", label: "Baseball" },
    { value: "2", label: "Basketball" },
    { value: "20", label: "Billiards" },
    { value: "18", label: "Boxing" },
    { value: "3", label: "Cricket" },
    { value: "38", label: "Carrom" },
    { value: "13", label: "Chess" },
    { value: "24", label: "Fencing" },
    { value: "1", label: "Football" },
    { value: "7", label: "Golf" },
    { value: "31", label: "Gym" },
    { value: "11", label: "Gymnastics" },
    { value: "39", label: "Handball" },
    { value: "15", label: "Hockey" },
    { value: "10", label: "Kabaddi" },
    { value: "40", label: "Kalaripayattu" },
    { value: "4", label: "Karate" },
    { value: "22", label: "Kho kho" },
    { value: "19", label: "Motorsports" },
    { value: "9", label: "Mma" },
    { value: "34", label: "Personal Trainer" },
    { value: "30", label: "Rugby" },
    { value: "28", label: "Taekwondo" },
    { value: "21", label: "Table Tennis" },
    { value: "16", label: "Tennis" },
    { value: "25", label: "Skating" },
    { value: "37", label: "Snooker" },
    { value: "8", label: "Shooting" },
    { value: "35", label: "Silambam" },
    { value: "23", label: "Squash" },
    { value: "5", label: "Swimming" },
    { value: "27", label: "Volleyball" },
    { value: "17", label: "Wrestling" },
    { value: "32", label: "Yoga" },
  ];

  $(document).on("click", ".quantity-arrow-minus-04", function (e) {
    var $input = $(this).siblings(".quantity-num-04");
    var currentVal = parseInt($input.val(), 10);
    if (currentVal > 1) {
      $input.val(currentVal - 1);
    }
  });

  // Handle click on the plus button
  $(document).on("click", ".quantity-arrow-plus-04", function (e) {
    var $input = $(this).siblings(".quantity-num-04");
    var currentVal = parseInt($input.val(), 10);
    $input.val(currentVal + 1);
  });

  $(document).on("input", ".location_city #locationInput", async function () {
    let inputVal = $(this).val().toLowerCase();
    let locationContainer = $(this).closest(".location_city");
    let locationName = locationContainer.find("#location-name");

    if (inputVal.length === 0) {
      locationName.empty();
      locationContainer.find(".location-list").css("display", "none");
      return;
    }

    const localities = await getMasterLocalities(inputVal, 1);
    locationList = localities.map(function (locality) {
      return {
        id: locality.id,
        locality_name: locality.locality_name,
        city: locality.city,
        state: locality.state,
        city_id: locality.city_id,
        postcode: locality.postcode,
      };
    });
    updateLocationDropdown(locationList, inputVal, locationContainer);
  });

  // Event delegation for dynamically added location item clicks
  $(document).on("click", "#location-name .location-item", function () {
    let locationId = $(this).data("id");
    let cityName = $(this).data("city");
    let pincode = $(this).data("postcode");
    let state = $(this).data("state");
    let locationContainer = $(this).closest(".location_city");
    let locationWrapper = $(this).closest(".post-tournament-section");
    locationContainer.find("#locationInput").val(cityName);
    locationWrapper.find("#tournament_zipcode").val(pincode);
    locationWrapper.find("#tournament_state").val(state);
    locationContainer.find("#loc_id_input").val(locationId);
    locationWrapper.find("#location-name").empty();
    locationContainer.find(".location-list").css("display", "none");
  });

  // Handle clicks outside the location input
  $(document).click(function (event) {
    if (!$(event.target).closest("#location-name, .location-list").length) {
      $(".location-list").each(function () {
        selectFirstLocation($(this));
      });
      $(".location-list").css("display", "none");
    }
  });

  // Handle Enter or Tab key press
  $(document).on("keydown", ".location_city #locationInput", function (e) {
    if (e.key === "Enter" || e.key === "Tab") {
      selectFirstLocation(
        $(this).closest(".location_city").find("#location-name")
      );
    }
  });

  function selectFirstLocation(locationNameElement) {
    let firstLocation = locationNameElement.find("li:first-child");
    if (firstLocation.length) {
      firstLocation.trigger("click");
    }
  }

  function updateLocationDropdown(locations, filter, locationContainer) {
    let locationName = locationContainer.find("#location-name");
    let locationList = locationContainer.find(".location-list");

    locationName.empty(); // Clear previous options
    locationList.css("display", "block");

    let filteredLocation = locations.filter((location) =>
      location.locality_name.toLowerCase().includes(filter)
    );

    if (filteredLocation.length === 0) {
      locationName.html(
        '<p style="padding-left:1rem;padding-top:1rem">No match found</p>'
      );
    } else {
      filteredLocation.forEach(function (location) {
        locationName.append(`
          <li class="dropdown-item location-item" 
              data-id="${location.id}" 
              data-locality="${location.locality_name}" 
              data-city="${location.city}" 
              data-state="${location.state}" 
              data-postcode="${location.postcode}">
            ${location.locality_name},
            ${
              location.city_id == 1
                ? `<span style="color: green;">${location.city}</span>`
                : ""
            } 
            ${location.state} 
            (${
              location.city_id == 0
                ? '<span style="color: blue;">city</span>'
                : '<span style="color: red;">locality</span>'
            })
          </li>
        `);
      });
    }
  }

  function getMasterLocalities(term, type) {
    return new Promise((resolve, reject) => {
      let data = type === 1 ? { term: term } : { loc_id: term };
      $.ajax({
        url: "/coach/get-location-master",
        type: "GET",
        async: true,
        data: data,
        success: function (response) {
          if (Array.isArray(response.locations)) {
            resolve(response.locations);
          } else {
            resolve([]);
          }
        },
        error: function (xhr, status, error) {
          console.error("An error occurred while fetching localities:", error);
          reject(error);
        },
      });
    });
  }

  $(".btn-upload").click(function () {
    $("#file").click();
  });

  $("#file").change(function () {
    var fileNames = $.map(this.files, function (file) {
      return file.name;
    }).join(", ");

    $("#file-name").val(fileNames || "No file chosen");
  });

  $("#tournamentSport").on("change", function () {
    var selectedSportName = $(this).find("option:selected").text();
    $("#sport_name").val(selectedSportName);
  });

  $("#add_tournament").on("click", function (e) {
    e.preventDefault();

    var hasError = false;
    var errorMsg = "";
    var sub_tournament = []; // Reset the array on each submission attempt

    $(".input-row").each(function () {
      var type = $(this).find(".select_type").val();
      var ageGroup = $(this).find(".age_group").val();
      var numberOfPlayers = parseInt(
        $(this).find(".quantity-num-01").val(),
        10
      );

      if (type == "" || ageGroup == "") {
        hasError = true;
        errorMsg = "Please fill tournament type details.";
        return false; // Break out of the loop
      }

      var tournamentData = {
        type: type,
        ageGroup: ageGroup,
        numberOfPlayers: numberOfPlayers > 0 ? numberOfPlayers : 0, // Ensure valid number
      };

      if (type === "Other") {
        var customTournament = $(this).find(".custom-tournament").val();
        if (customTournament == "") {
          hasError = true;
          errorMsg = "Please fill the other tournament type.";
          return false;
        } else {
          tournamentData.type = customTournament;
        }
      }

      sub_tournament.push(tournamentData);
    });

    // Additional checks for the rest of the form...
    if ($("#sport_name").val() === "") {
      hasError = true;
      errorMsg = "Please Select Sports";
    } else if ($("#locationInput").val() === "") {
      hasError = true;
      errorMsg = "Please Enter City";
    } else if ($('input[name="venue"]').val() === "") {
      hasError = true;
      errorMsg = "Please Enter Venue";
    } else if ($("#tour_name").val() === "") {
      hasError = true;
      errorMsg = "Please Enter Tournament Name";
    } else if ($('textarea[name="intro"]').val() === "") {
      hasError = true;
      errorMsg = "Please Enter Tournament Description";
    } else if ($("#tour_phone").val() === "") {
      hasError = true;
      errorMsg = "Please Enter Your Phone Number";
    }

    if (hasError) {
      showError2(errorMsg);
      return; // Exit if there's an error
    }
    submitForm(sub_tournament);
  });

  // Helper function to display errors
  function showError2(message) {
    let confirmBoxHtml = `
            <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" loading="lazy" alt="Error"></figure>
                        <h6>${message}</h6>
                    </div>
                    <div class="confirm-footer">
                        <button class="get_back btn btn-secondary">Go Back</button>
                    </div>
                </div>
            </div>
        `;
    $("body").append(confirmBoxHtml);
  }

  // Function to handle the form submission
  function submitForm(sub_tournament) {
    var allRules = collectRules();
    var allAdvantages = collectAdvantages();
    let formData = new FormData();

    // Gather input values
    formData.append("sport", $("#sport_name").val());
    formData.append("sport_id", parseInt($("#tournamentSport").val(), 10));
    formData.append("loc_id", $('input[name="loc_id_input"]').val());
    formData.append("state", $("#tournament_state").val());
    formData.append("city", $(".tour_city").val());
    formData.append("venue", $('input[name="venue"]').val());
    formData.append("event_starts_on", $('input[name="event_starts_on"]').val());
    formData.append("event_ends_on", $('input[name="event_ends_on"]').val());
    formData.append("no_of_team", $("#total_teams").val());
    formData.append("entry_fee", $('input[name="entry_fee"]').val());
    formData.append("winning_amount", $('input[name="winning_amount"]').val());
    formData.append("name", $("#tour_name").val());
    formData.append("intro", $('textarea[name="intro"]').val());
    formData.append("pathway", $('textarea[name="pathway"]').val());
    formData.append("sponsored_name", $('input[name="sponsored_name"]').val());
    formData.append("organised_by", $('input[name="organised_by"]').val());
    formData.append("rules", allRules);
    formData.append("advantages", allAdvantages);
    formData.append("phone", $("#tour_phone").val());
    formData.append("email", $("#tour_email").val());
    formData.append("sub_tournament", JSON.stringify(sub_tournament));
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    $("#add_tournament").prop("disabled", true).text("Sending...");

    $.ajax({
        url: "/api/add-tournament",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#add_tournament").prop("disabled", false).text("Add Tournament");
            if (response?.leagueDetails?.id) {
                let tournamentId = response.leagueDetails.id;
                let addMessage= response.message;
                uploadTournamentPhotos(tournamentId, addMessage);
            }else{
              console.error(response?.message);
            }
        },
        error: function (xhr, status, error) {
            $("#add_tournament").prop("disabled", false).text("Add Tournament");
            showError2(error);
        },
    });
}

// Function to handle file uploads one by one
function uploadTournamentPhotos(tournamentId, message) {
    let files = $("#file")[0].files;
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let showFlag = true;
    let showLoaderFlag = false;

    if (files.length === 0) {
      showSuccess(message)
        return;
    }

    let index = 0;

    function uploadNext() {
        if (index < files.length) {
          showLoaderFlag = true;

          if (showLoaderFlag && showFlag) {
              showFlag = false;
              showLoader();
          }
            let file = files[index];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("_token", csrfToken);
            formData.append("tournament_id", tournamentId);

            $.ajax({
                url: "/api/upload-photos-tournaments",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                  if (response.status == 1) {
                    uploadMessage = response?.message;
                    successflag = true;
                } else {
                    uploadMessage = response?.message;
                    successflag = false;
                }
                    index++;
                    uploadNext(); // Call next upload
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  uploadMessage = "Some error occurred";
                  successflag = false;
                  showConfirmBox(uploadMessage, successflag);
                  index++;
                  uploadNext();
                },
            });
        } else {
          showConfirmBox(uploadMessage, successflag);
        }
    }

    uploadNext(); // Start the upload process
}


  // Helper function to display success messages
  function showSuccess(message) {
    let confirmBoxHtml = `
            <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop add_backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
                        <h6>${message}</h6>
                    </div>
                    <div class="confirm-footer">
                        <button class="get_back btn btn-secondary add_back">Go Back</button>
                    </div>
                </div>
            </div>
        `;
    $("body").append(confirmBoxHtml);
  }

  $("#start_date").attr("type", "text").attr("placeholder", "Start Date");

  $("#end_date").attr("type", "text").attr("placeholder", "End Date");

  // Show the date picker on focus and clear the placeholder
  $(".tour_date").on("focus", function () {
    this.type = "datetime-local";
    $(this).attr("value", ""); // Clear the value to show the calendar
    this.showPicker(); // Show date picker
  });

  $(".tour_date").on("blur", function () {
    if ($(this).val() === "") {
      if ($(this).attr("id") === "start_date") {
        $(this).attr("value", "").attr("placeholder", "Start Date");
      } else {
        $(this).attr("value", "").attr("placeholder", "End Date");
      }
    }
  });

  $(document).on("click", ".get_back", function () {
    $(this).closest(".confirm-box").remove();
  });

  $(document).on("click", ".confirm-backdrop", function () {
    $(this).closest(".confirm-box").remove();
  });
  $(document).on("click", ".new_get_back", function () {
    getData();
  });

  $(document).on("click", ".new-confirm-backdrop", function () {
    getData();
  });
  $(document).on("click", ".add_back", function () {
    $(this).closest(".confirm-box").remove();
    // location.reload();
  });

  $(document).on("click", ".add_backdrop", function () {
    $(this).closest(".confirm-box").remove();
    // location.reload();
  });

  $(document).on("click", ".quantity-arrow-minus-01", function () {
    var $input = $(this).siblings(".quantity-num-01");
    var value = parseInt($input.val(), 10);
    if (value > 1) $input.val(value - 1);
  });

  $(document).on("click", ".quantity-arrow-plus-01", function () {
    var $input = $(this).siblings(".quantity-num-01");
    var value = parseInt($input.val(), 10);
    $input.val(value + 1);
  });

  function toggleCustomTournament(selectElement) {
    const container = selectElement.closest(".input-row");
    if (selectElement.val() === "Other") {
      container.find(".custom-tournament-container").show(); // Show custom input
    } else {
      container.find(".custom-tournament-container").hide(); // Hide custom input
    }
  }

  // Handle 'Other' option selection for dynamically added rows
  $(document).on("change", ".tournament-type", function () {
    toggleCustomTournament($(this));
  });

  // Clone row and reset values
  $(".add-more-btn").click(function () {
    var newRow = $(".input-row").first().clone(); // Clone the first row
    newRow.find("input").val(""); // Clear text inputs
    newRow.find('input[type="number"]').val(1); // Reset number input to 1
    newRow.find("select").val(""); // Reset select element
    newRow.find(".custom-tournament-container").hide(); // Hide custom tournament input by default

    // Ensure the delete button in the cloned row is visible
    newRow.find(".delete_row").css("visibility", "visible");

    // Insert the new row before the add-more button and show it with animation
    $(newRow)
      .hide()
      .insertBefore($("#main_container .add-more-btn").parent())
      .slideDown("slow");

    // Ensure the delete button in the first row stays hidden
    $(".input-row").first().find(".delete_row").css("visibility", "hidden");
  });

  $(document).on("click", ".delete_row", function () {
    $(this)
      .closest(".input-row")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the row after the animation completes
      });
  });

  $(document).on("click", ".add-more-btn2", function (e) {
    e.preventDefault(); // Prevent form submission or page reload

    // Create a new tournament type input dynamically with a delete button
    var newTournamentType = `
        <div class="sub-tournament-item">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <input type="text" name="sub_type_new" class="age_group" placeholder="Sub Tournament Type">
                </div>
                <div class="col-md-6 col-lg-4">
                    <input type="text" class="age_group" name="sub_age_group_new" placeholder="Enter Age Group">
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-center justify-content-between">
                    Number of Players
                    <div class="quantity-block">
                        <button class="quantity-arrow-minus-01"><i class="fa-solid fa-minus"></i></button>
                        <input class="quantity-num-01" type="number" name="sub_number_of_players_new" value="1" />
                        <button class="quantity-arrow-plus-01"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <button class="quantity-arrow-minus-01 delete-row7" style="margin-left: 1rem;">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>`;

    // Append the new tournament type before the 'Add More' button and make it slide down
    $(newTournamentType).hide().insertBefore($(this)).slideDown("slow");
  });

  // Delegate event for delete button
  $(document).on("click", ".delete-row7", function () {
    $(this)
      .closest(".sub-tournament-item")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the element after sliding up
      });
  });

  $(".top_tournament").on("click", function () {
    $(".top_tournament").removeClass("active");
    $(this).addClass("active");
    $(".post-tournament-section").hide();
    $(".view_tournament").hide();

    if ($(this).text().trim() === "Add Tournament") {
      $(".post-tournament-section").show();
    } else if ($(this).text().trim() === "View Tournament") {
      getData(); // Fetch data when View Tournament is clicked
      $(".view_tournament").show();
    }
  });

  $(document).on("click", "#view_box", function () {
    getData();
  });

  // Automatically trigger Add Tournament tab on page load
  $(".top_tournament.active").trigger("click");

  function getData() {
    $.ajax({
      url: "/api/get-tournaments", // Replace with your API URL
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        if (
          response &&
          response.tournaments &&
          response.tournaments.length > 0
        ) {
          populateAccordion(response.tournaments);
          populateAccordion2(response.tournaments);
          populateAccordion3(response.tournaments);
        } else {
          $("#tournamentAccordion").html(
            "<p style='margin-left: 1.5rem;'>No tournaments added.</p>"
          );
          $("#tournamentAccordion2").html(
            "<p style='margin-left: 1.5rem;'>No tournaments added.</p>"
          );
          $("#tournamentAccordion3").html(
            "<p style='margin-left: 1.5rem;'>No tournaments added.</p>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
      },
    });
  }

  // Populate the accordion with tournament data
  function populateAccordion(tournaments) {
    populateAccordionHelper(tournaments, "#tournamentAccordion");
  }

  function populateAccordion2(tournaments) {
    populateAccordionHelper(tournaments, "#tournamentAccordion2");
  }

  function populateAccordion3(tournaments) {
    populateAccordionHelper(tournaments, "#tournamentAccordion3");
  }

  function populateAccordionHelper(tournaments, accordionId) {
    let accordionContent = "";
    tournaments.forEach((tournament, index) => {
        getLeads(tournament.id);
        tournamentPhotosMap[tournament.id] = tournament.photos;

        let subTournamentsHTML = "";
        try {
            const subTournaments = JSON.parse(tournament.sub_tournament);
            if (Array.isArray(subTournaments)) {
                subTournamentsHTML = subTournaments
                    .map((sub, subIndex) => `
                        <div class="sub-tournament-item">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <input type="text" name="sub_type_${index}_${subIndex}" value="${sub.type}" class="age_group" placeholder="Sub Tournament Type">
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <input type="text" class="age_group" name="sub_age_group_${index}_${subIndex}" value="${sub.ageGroup}" placeholder="Enter Age Group">
                                </div>
                                <div class="col-md-6 col-lg-4 d-flex align-items-center justify-content-between">
                                    Number of Players
                                    <div class="quantity-block">
                                        <button class="quantity-arrow-minus-01"><i class="fa-solid fa-minus"></i></button>
                                        <input class="quantity-num-01" type="number" name="sub_number_of_players_${index}_${subIndex}" value="${sub.numberOfPlayers}" />
                                        <button class="quantity-arrow-plus-01"><i class="fa-solid fa-plus"></i></button>
                                        <button class="quantity-arrow-minus-01 delete-row7" style="margin-left: 1rem; visibility: ${subIndex === 0 ? "hidden" : "visible"};">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `)
                    .join("");
            }
        } catch (e) {
            console.error("Error parsing sub_tournament JSON:", e);
        }

        const selectedSportOption = sportsOptions.find(option => option.label === tournament.sport);
        const optionsHTML = sportsOptions
            .map(option => `
                <option value="${option.value}" ${option.label === tournament.sport ? "selected" : ""}>
                    ${option.label}
                </option>
            `)
            .join("");

        let photosHTML = "";
        if (tournament.photos) {
            const photoArray = tournament.photos.split(",");
            photosHTML = `
                <div class="photo-container d-flex justify-content-start align-items-center gap-3">
                    ${photoArray
                        .map((photo, photoIndex) => `
                            <div class="photo-item position-relative">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/league/${tournament.id}/${photo}" loading="lazy" alt="Tournament Photo" class="img-fluid photo-img" />
                                <input type="checkbox" class="photo-checkbox" name="delete_photo_${index}_${photoIndex}" value="${photo.trim()}" />
                            </div>
                        `)
                        .join("")}
                </div>
            `;
        }

        accordionContent += `
            <div class="accordion-item">
                <input type="hidden" name="tournament_id" value="${tournament.id}">
                <h2 class="accordion-header2" id="heading${index}">
                    <button class="accordion-button tour_accordian_btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                        ${tournament.name} - ${tournament.sport} (${tournament.city})
                        <div class="url-container">
                            <a href="${tournament.url}" target="_blank" rel="noopener noreferrer"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-viewed.svg" alt="redirect" loading="lazy" height="30" width="30"></img></a>
                        </div>
                    </button>
                </h2>
                <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="${accordionId}">
                    <div class="accordion-body">
                        <section class="post-tournament-section clearfix">
                            <div class="container mt-5">
                                <div class="form-wrapper">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <input type="hidden" class="sport_name2" name="sport" value="${tournament.sport}">
                                            <select name="sport_id" id="tournamentSport">
                                                <option value="">Select Sport Type</option>
                                                ${optionsHTML}
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-lg-4 location_city">
                                            <input type="text" placeholder="Please Enter Your City" name="city" class="form-control" id="locationInput" value="${tournament.city}" autocomplete="off">
                                            <div id="location-name" class="location-list">
                                                <!-- Dynamically filled based on input -->
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="text" name="state" id="tournament_state" placeholder="State" value="${tournament.state}" disabled>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="text" name="pincode" id="tournament_zipcode" value="${tournament.pincode}" placeholder="Zipcode">
                                        </div>
                                    </div>
                                    <div class="select-tournament-type" id="main_container">
                                        <h6>Select Tournament Type</h6>
                                        <div class="row input-row2">
                                            ${subTournamentsHTML}
                                            <div>
                                                <button type="button" class="btn btn-primary add-more-btn2">Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="select-rule-type mt-3" id="rule_box">
                                        <h6>Add Rules</h6>
                                        <div class="row" id="rules_container">
                                            ${tournament.rules
                                                ? tournament.rules.split("$$")
                                                    .map(rule => `
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3 new-rule-row">
                                                            <input type="text" class="tournament_rules1" value="${rule}" placeholder="Enter Your Rules" />
                                                            <button class="quantity-arrow-minus-01 delete_row5" style="margin-left: 1rem;">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    `)
                                                    .join("")
                                                : `
                                                    <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3 new-rule-row">
                                                        <input type="text" class="tournament_rules1" placeholder="Enter Your Rules" />
                                                        <button class="quantity-arrow-minus-01 delete_row5" style="margin-left: 1rem;">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                `
                                            }
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary add-rule-btn2">Add More</button>
                                        </div>
                                    </div>
                                    <div class="select-rule-type mt-3" id="advantage_box">
                                        <h6>Add Advantages</h6>
                                        <div class="row" id="advantages_container">
                                            ${tournament.advantages
                                                ? tournament.advantages.split("$$")
                                                    .map(advantage => `
                                                        <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3 new-advantage-row">
                                                            <input type="text" class="tournament_advantage2" value="${advantage}" placeholder="Enter Your Advantages" />
                                                            <button class="quantity-arrow-minus-01 delete_row4" style="margin-left: 1rem;">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    `)
                                                    .join("")
                                                : `
                                                    <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3 new-advantage-row">
                                                        <input type="text" class="tournament_advantage2" placeholder="Enter Your Advantages" />
                                                        <button class="quantity-arrow-minus-01 delete_row4" style="margin-left: 1rem;">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                `
                                            }
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary add-advantage-btn2">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <input type="text" name="venue" value="${tournament.venue}" placeholder="Enter Venue">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="datetime-local" id="start_date" value="${tournament.event_starts_on}" name="event_starts_on" class="form-control tour_date" placeholder="Tournament Start Date" class="input-calendar">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="datetime-local" id="end_date" value="${tournament.event_ends_on}" name="event_ends_on" class="form-control tour_date" placeholder="Tournament End Date" class="input-calendar">
                                        </div>
                                        <div class="col-md-6 col-lg-4 d-flex align-items-center justify-content-between">No. of Teams participating
                                            <div class="quantity-block">
                                                <button class="quantity-arrow-minus-04"> <i class="fa-solid fa-minus"></i> </button>
                                                <input class="quantity-num-04" name="no_of_team" id="total_teams" type="number" value="${tournament.no_of_team}" />
                                                <button class="quantity-arrow-plus-04"> <i class="fa-solid fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="number" name="entry_fee" class="number_type" value="${tournament.entry_fee}" placeholder="Entry Fee">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <input type="number" name="winning_amount" class="number_type" value="${tournament.winning_amount}" placeholder="Wining Amount">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <input type="text" name="name" id="tour_name" value="${tournament.name}" placeholder="Your Tournament Name">
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <textarea name="intro" placeholder="Your tournament description. (Anything you want to add more about your Tournament)">${tournament.intro}</textarea>
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <textarea name="pathway" placeholder="Enter Pathway">${tournament.pathway == null ? "" : tournament.pathway}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6"><input type="text" name="sponsored_name" value="${tournament.sponsored_name == null ? "" : tournament.sponsored_name}" id="" placeholder="Sponsored by"></div>
                                        <div class="col-md-6 col-lg-6"><input type="text" name="organised_by" value="${tournament.organised_by == null ? "" : tournament.organised_by}" id="" placeholder="Organised by"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <input type="text" name="phone" value="${tournament.phone}" id="tour_phonr" placeholder="Phone">
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <input type="text" name="email" id="tour_email" value="${tournament.email}" placeholder="email address">
                                        </div>
                                    </div>
                                    <div class="upload-container" data-tournament-id="${tournament.id}">
                                        <div class="upload-section">
                                            <input type="file" class="file-input" accept="image/*" multiple style="display:none;">
                                            <div class="upload-controls">
                                                <input type="text" class="fileNamesDisplay btn btn-primary mt-2" readonly placeholder="Upload Banners" style="cursor:pointer;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="photos-section mt-3">
                                        <h6>Uploaded Photos</h6>
                                        ${photosHTML}
                                        <div class="mt-3">
                                            <button data-id="${tournament.id}" class="btn btn-primary btn-lg delete-selected-photos" style="font-size:14px;">Delete Selected Photos</button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center gap-3"></div>
                                    <div class="mt-3 d-flex justify-content-between align-items-center gap-3">
                                        <input type="submit" value="Update Tournament" class="btn btn-secondary btn-lg" id="update_tournament" data-tournament-id="${tournament.id}">
                                        <a href="${tournament.url}" target="_blank">
                                            <button class="btn btn-secondary btn-lg">View Page</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-wrapper mt-3 mb-3">
                                    <div>
                                        <h4>Leads</h4>
                                    </div>
                                    <div class="lead-item" data-id="${tournament.id}"></div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        `;
    });

    $(accordionId).html(accordionContent);
}

  $(document).on('click', '.url-container a', function (event) {
    event.stopPropagation();
    event.preventDefault();
    window.open($(this).attr('href'), '_blank');
});



  function getLeads(id) {
    $.ajax({
      url: "/tournament/get-lead", // Replace with your API URL
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        leagueId: id,
      },
      success: function (response) {

        if (response.leads && response.leads.length > 0) {
          let leads = "";
          response.leads.forEach(function (lead) {
            const creationDateString = lead.creation_date;
            let creationDate = new Date(creationDateString.replace(/-/g, "/"));

            creationDate.setHours(creationDate.getHours() + 5);
            creationDate.setMinutes(creationDate.getMinutes() + 30);

            const optionsDate = {
              day: "numeric",
              month: "short",
              year: "numeric",
            };
            const formattedDate = creationDate
              .toLocaleDateString("en-US", optionsDate)
              .replace(/\b\d{1,2}\b/g, (match) =>
                match < 10 ? "0" + match : match
              );

            const optionsTime = {
              hour: "numeric",
              minute: "numeric",
              hour12: true,
            };
            const formattedTime = creationDate.toLocaleTimeString(
              "en-US",
              optionsTime
            );

            const openDateString = lead.open_date;
            let formattedOpenDate = "";
            let formattedOpenTime = "";

            if (openDateString) {
              let openDateObj = new Date(openDateString.replace(/-/g, "/"));

              // Add 5 hours and 30 minutes to the open date
              openDateObj.setHours(openDateObj.getHours() + 5);
              openDateObj.setMinutes(openDateObj.getMinutes() + 30);

              const optionsOpenDate = {
                day: "numeric",
                month: "short",
                year: "numeric",
              };
              formattedOpenDate = openDateObj
                .toLocaleDateString("en-US", optionsOpenDate)
                .replace(/\b\d{1,2}\b/g, (match) =>
                  match < 10 ? "0" + match : match
                );

              const optionsOpenTime = {
                hour: "numeric",
                minute: "numeric",
                hour12: true,
              };
              formattedOpenTime = openDateObj.toLocaleTimeString(
                "en-US",
                optionsOpenTime
              );
            }

            let profile =
              "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/coach-img.png";

            leads += `
                  <div class="lead-wrapper">
                    <div class="lead-card">
                      <div class="view_details_btn">
                        <figure><img src="${profile}" class="img-fluid" alt=""></figure>
                      </div>
                      <div class="d-flex justify-content-start align-items-start gap-3">
                        <div>
                          <h6 style="margin-bottom:0;">Id: <span class="lead_id">${
                            lead.id
                          }</span></h6>
                          <!-- Always display the Lead Date -->
                          <p class="date_size" style="white-space:nowrap;margin-top:0;">
                            <span style="font-weight:700">Lead Date:</span> ${formattedDate} @ ${formattedTime}
                          </p>
              
                          <h6 class="lead-name">Name: ${
                            lead.name ? lead.name : "-"
                          }</h6>
                          <div class="more-details">
                            <p class="d-flex justify-content-start align-items-center whatsapp_num gap-1" style="margin-top:-0.5rem">
                              <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> +91 ${
                                lead.phone ? lead.phone : "-"
                              }
                              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp" class="whatsapp_icon" data-name="${
                                lead.name
                              }" data-phone="${lead.phone}" />
                            </p>
                          </div>
                        </div>   
                      </div>
                
                      <div class="leads-description">
                        <p> <span style="font-weight:700">Description: </span>${
                          lead.description ? lead.description : "-"
                        }</p>
                      </div>
                      </div>
                    </div>
                  </div>`;
          });

          $(`.lead-item[data-id="${id}"]`).html(leads);
        } else {
          $(`.lead-item[data-id="${id}"]`).html(
            "<p>No leads available for this tournament.</p>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching leads");
      },
    });
  }

  $(document).on("click", ".whatsapp_num", function (event) {
    event.preventDefault();
    const whatsappIcon = $(this).find(".whatsapp_icon");
    const leadName = whatsappIcon.data("name") || "-";
    const academyName = $("#academy_name").val();
    const userPhone = whatsappIcon.data("phone") || "";

    window.open(`https://api.whatsapp.com/send?phone=91${userPhone}`, "_blank");
  });

  // Open file input when clicking the display input
  $(document).on("click", ".fileNamesDisplay", function () {
    const $container = $(this).closest(".upload-container");
    $container.find(".file-input").click();
  });

  // Handle file selection and upload logic
  $(document).on("change", ".file-input", function () {
    const $container = $(this).closest(".upload-container");
    const tournamentId = $container.data("tournament-id");
    const files = $(this).get(0).files;
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    let showFlag = true;
    let showLoaderFlag = false;

    let uploadMessage = '';
    let successflag = false;

    if (files.length > 0) {
        const fileNames = $.map(files, (file) => file.name);
        $container.find(".fileNamesDisplay").val(fileNames.join(", "));
    } else {
        $container.find(".fileNamesDisplay").val("No files selected");
        return;
    }

    let index = 0; // Start from the first image

    function uploadNext() {
        if (index < files.length) {
            showLoaderFlag = true;

            if (showLoaderFlag && showFlag) {
                showFlag = false;
                showLoader();
            }
            const file = files[index];
            const formData = new FormData();
            formData.append("file", file);
            formData.append("_token", csrfToken);
            formData.append("tournament_id", tournamentId);

            $.ajax({
                url: "/api/upload-photos-tournaments",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 1) {
                        uploadMessage = response?.message;
                        successflag = true;
                    } else {
                        uploadMessage = response?.message;
                        successflag = false;
                    }
                    index++;
                    uploadNext();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    uploadMessage = "Some error occurred";
                    successflag = false;
                    showConfirmBox(uploadMessage, successflag);
                    index++;
                    uploadNext();
                },
            });
        } else {
            showConfirmBox(uploadMessage, successflag);
        }
    }

    uploadNext();
});



  // Helper function to show confirm box
  function showConfirmBox(message, isSuccess) {
    const imageUrl = isSuccess
      ? "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif"
      : "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif";

    const confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop new-confirm-backdrop"></div>
          <div class="confirm-content">
              <div class="confirm-body">
                  <figure>
                      <img src="${imageUrl}" class="img-fluid" loading="lazy" alt="${
      isSuccess ? "Success" : "Error"
    }">
                  </figure>
                  <h6>${message}</h6>
              </div>
              <div class="confirm-footer">
                  <button class="get_back btn btn-secondary new_get_back">Go Back</button>
              </div>
          </div>
      </div>
  `;
    $("body").append(confirmBoxHtml);
  }
  function showLoader() {


    const confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop" style="pointer-events:none;"></div>
          <div class="confirm-content">
              <div class="confirm-body">
                  <figure>
                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" class="img-fluid" loading="lazy">
                  </figure>
                  <h6>Loading Images...</h6>
              </div>
          </div>
      </div>
  `;
    $("body").append(confirmBoxHtml);
  }

  $(document).on("click", ".delete-selected-photos", function (e) {
    e.preventDefault();

    const tournamentId = $(this)
      .closest(".accordion-item")
      .find('input[name="tournament_id"]')
      .val();

    let photoString = tournamentPhotosMap[tournamentId];

    // Collect all the selected photos
    let selectedPhotos = [];
    $(this)
      .closest(".photos-section")
      .find(".photo-checkbox:checked")
      .each(function () {
        selectedPhotos.push($(this).val()); // Collect the value of the checkbox (photo URL or identifier)
      });

    if (selectedPhotos.length === 0) {
      let confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
          <div class="confirm-body">
            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" loading="lazy" alt="Error"></figure>
            <h6>Please Select Photos To Delete</h6>
          </div>
          <div class="confirm-footer">
            <button class="get_back btn btn-secondary">Go Back</button>
          </div>
        </div>
      </div>
    `;
      $("body").append(confirmBoxHtml);
      return;
    }

    let photoArray = photoString.split(",");

    // Remove the selected photos from photoArray
    selectedPhotos.forEach((photo) => {
      const index = photoArray.indexOf(photo);
      if (index > -1) {
        photoArray.splice(index, 1); // Remove the photo if found
      }
    });

    // Join the remaining photos back into a comma-separated string
    photoString = photoArray.join(",");

    // Find the tournament ID associated with this delete action

    // Send AJAX request to delete the photos
    $.ajax({
      url: "/api/update-tournaments",
      type: "POST", // Or DELETE, depending on your API
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        photos: photoString, // Pass the updated photoString
        tournament_id: tournamentId,
      },
      success: function (response) {
        // Show success message
        let confirmBoxHtml = `
        <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop"></div>
          <div class="confirm-content">
            <div class="confirm-body">
              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
              <h6>${response.message}</h6>
            </div>
            <div class="confirm-footer">
              <button class="get_back btn btn-secondary">Go Back</button>
            </div>
          </div>
        </div>
      `;
        $("body").append(confirmBoxHtml);

        // Remove selected photos from the DOM
        selectedPhotos.forEach(function (photo) {
          $(`input[value="${photo}"]`).closest(".photo-item").remove();
        });
      },
      error: function (xhr, status, error) {
        // Show error message
        let confirmBoxHtml = `
        <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop"></div>
          <div class="confirm-content">
            <div class="confirm-body">
              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" loading="lazy" alt="Error"></figure>
              <h6>${error}</h6>
            </div>
            <div class="confirm-footer">
              <button class="get_back btn btn-secondary">Go Back</button>
            </div>
          </div>
        </div>
      `;
        $("body").append(confirmBoxHtml);
      },
    });
  });

  $("#openWhatsappModal").on("click", openEnquiryModal);

  function openEnquiryModal() {
    academyTitle = $("#listing_title").val();
    $("#whatsappModalLabel").text(`Contact for ${academyTitle}`);
    academyPhoneNumber = $("#academy_phone").val();
    academyAddress = $("#academy_address").val();
    $("#latitude2").val(latitude);
    $("#longitude2").val(longitude);
    $(
      "input[name='name'], input[name='email'], input[name='phone'], input[name='description']"
    ).val("");
    $("#formError").hide();
    $("#whatsappModal").modal("show");
  }

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
    userAddress = $("#details_address").val().trim();

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

    if (isValid) {
      // Store data in sessionStorage
      sessionStorage.setItem("userName", userName);
      sessionStorage.setItem("userEmail", userEmail);
      sessionStorage.setItem("userPhone", userPhone);
      sessionStorage.setItem("userMessage", userMessage);

      // Perform AJAX request
      $.ajax({
        url: "/tournament/create-lead",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          league_id: urlId,
          name: userName,
          email: userEmail,
          phone: userPhone,
          description: userMessage,
          address: userAddress,
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
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
                                <h6>Your lead has been submitted successfully</h6>
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
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" loading="lazy" alt="Whatsapp">Tournament
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

          // Re-enable the button and reset text
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

    let whatsappMessage = `Hello,\n\nI hope this message finds you well.\n\nMy name is ${userName}.\n\n${userMessage}\n`;
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
    let whatsappMessage = `Additional Info\nName: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\Message: ${userMessage}\n------------------------------\n`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    // Open the WhatsApp chat window with the pre-filled message
    window.open(
      `https://api.whatsapp.com/send?phone=+918826450360&text=${encodedMessage}`,
      "_blank"
    );
    sessionStorage.clear();
  });

  $(".register_btn").on("click", function (e) {
    e.preventDefault();
    $("#customModal").show();
  });

  $(document).on("click", function (e) {
    // Check if the click is outside the modal content and inside the overlay
    if (
      !$(e.target).closest(".form-wrapper").length &&
      $(e.target).closest(".modal-overlay").length
    ) {
      $("#customModal").hide();
    }
  });

  // Close modal on background click

  // Close modal on close button click
  $(".close-modal").on("click", function () {
    $("#customModal").hide(); // Hide the modal
  });

  $(document).on("click", ".add-rule-btn", function (e) {
    e.preventDefault(); // Prevent form submission or page reload

    // Create a new rule input field dynamically with a visible delete button
    var newInputField = `
      <div class="row new-rule-row">
          <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
              <input type="text" class="tournament_rules" placeholder="Enter Your Rules" />
              <button class="quantity-arrow-minus-01 delete_row2" style="margin-left: 1rem;">
                  <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
          </div>
      </div>`;

    // Insert the new input field before the 'Add More' button and slide it down
    $(newInputField).hide().insertBefore($(this).parent()).slideDown("slow");
  });

  // Handle the delete button click for dynamically added rows
  $(document).on("click", ".delete_row2", function () {
    $(this)
      .closest(".new-rule-row")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the row after the animation completes
      });
  });

  $(document).on("click", ".add-rule-btn2", function (e) {
    e.preventDefault(); // Prevent form submission or page reload

    // Create a new input field dynamically with a delete button
    var newInputField = `
        <div class="row new-rule-row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
                <input type="text" class="tournament_rules1" placeholder="Enter Your Rules" />
                <button class="quantity-arrow-minus-01 delete_row5" style="margin-left: 1rem;">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </div>
        </div>`;

    // Append the new input field before the 'Add More' button and make the button slide down
    $(newInputField).hide().insertBefore($(this).parent()).slideDown("slow");
  });

  // Handle the delete button click for dynamically added rule rows
  $(document).on("click", ".delete_row5", function () {
    $(this)
      .closest(".new-rule-row")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the row after the animation completes
      });
  });

  $(document).on("click", ".add-advantage-btn", function (e) {
    e.preventDefault(); // Prevent form submission or page reload

    // Create a new advantage input field dynamically with a delete button
    var newInputField = `
      <div class="row new-advantage-row">
          <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
              <input type="text" class="tournament_advantage" placeholder="Enter Your Advantages" />
              <button class="quantity-arrow-minus-01 delete_row3" style="margin-left: 1rem;">
                  <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
          </div>
      </div>`;

    // Insert the new input field before the 'Add More' button and slide it down
    $(newInputField).hide().insertBefore($(this).parent()).slideDown("slow");
  });

  // Handle the delete button click for dynamically added advantage rows
  $(document).on("click", ".delete_row3", function () {
    $(this)
      .closest(".new-advantage-row")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the row after the animation completes
      });
  });

  $(document).on("click", ".add-advantage-btn2", function (e) {
    e.preventDefault(); // Prevent form submission or page reload

    // Create a new advantage input field with a delete button
    var newInputField = `
        <div class="row new-advantage-row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center gap-3">
                <input type="text" class="tournament_advantage2" placeholder="Enter Your Advantages" />
                <button class="quantity-arrow-minus-01 delete_row4" style="margin-left: 1rem;">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </div>
        </div>`;

    // Insert the new input field before the 'Add More' button and slide it down
    $(newInputField).hide().insertBefore($(this).parent()).slideDown("slow");
  });

  // Handle the delete button click for dynamically added advantage rows
  $(document).on("click", ".delete_row4", function () {
    $(this)
      .closest(".new-advantage-row")
      .slideUp("slow", function () {
        $(this).remove(); // Remove the row after the animation completes
      });
  });

  function collectRules() {
    var ruleValues = [];

    $(".tournament_rules").each(function () {
      ruleValues.push($(this).val());
    });

    var rules = ruleValues.join("$$");

    return rules;
  }
  function collectAdvantages() {
    var advantageValues = [];

    $(".tournament_advantage").each(function () {
      advantageValues.push($(this).val());
    });

    var advantage = advantageValues.join("$$");

    return advantage;
  }

  $(document).on("click", "#update_tournament", function (e) {
    e.preventDefault();
    const $accordionItem = $(this).closest(".accordion-item");
    const tournamentId = $(this).data("tournament-id");
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    // Collect all the updated values from the form
    const sport_id = $accordionItem.find("#tournamentSport").val();
    const selectedSport = sportsOptions.find(
      (sport) => sport.value === sport_id
    );
    const sport = selectedSport.label;
    const city = $accordionItem.find("input[name='city']").val();
    const state = $accordionItem.find("input[name='state']").val();
    const pincode = $accordionItem.find("input[name='pincode']").val();
    const venue = $accordionItem.find("input[name='venue']").val();
    const eventStartsOn = $accordionItem
      .find("input[name='event_starts_on']")
      .val();
    const eventEndsOn = $accordionItem
      .find("input[name='event_ends_on']")
      .val();
    const noOfTeams = $accordionItem.find("input[name='no_of_team']").val();
    const entryFee = $accordionItem.find("input[name='entry_fee']").val();
    const winningAmount = $accordionItem
      .find("input[name='winning_amount']")
      .val();
    const tournamentName = $accordionItem.find("input[name='name']").val();
    const description = $accordionItem.find("textarea[name='intro']").val();
    const pathway = $accordionItem.find("textarea[name='pathway']").val();
    const sponsoredName = $accordionItem
      .find("input[name='sponsored_name']")
      .val();
    const organisedBy = $accordionItem.find("input[name='organised_by']").val();
    const phone = $accordionItem.find("input[name='phone']").val();
    const email = $accordionItem.find("input[name='email']").val();

    // Collect tournament rules and advantages only from the selected accordionItem
    const rules = collectRules2($accordionItem); // Rules joined by $$
    const advantages = collectAdvantages2($accordionItem); // Advantages joined by $$

    // Sub-tournaments data (if applicable)
    const subTournaments = [];
    $accordionItem.find(".sub-tournament-item").each(function () {
      const subType = $(this).find("input[name^='sub_type_']").val();
      const subAgeGroup = $(this).find("input[name^='sub_age_group_']").val();
      const subNumberOfPlayers = $(this)
        .find("input[name^='sub_number_of_players_']")
        .val();

      subTournaments.push({
        type: subType,
        ageGroup: subAgeGroup,
        numberOfPlayers: subNumberOfPlayers,
      });
    });

    // Prepare data for the AJAX call
    const data = {
      tournament_id: tournamentId,
      sport: sport,
      sport_id: sport_id,
      city: city,
      state: state,
      pincode: pincode,
      venue: venue,
      event_starts_on: eventStartsOn,
      event_ends_on: eventEndsOn,
      no_of_team: noOfTeams,
      entry_fee: entryFee,
      winning_amount: winningAmount,
      name: tournamentName,
      intro: description,
      rules: rules,
      advantages: advantages,
      pathway: pathway,
      sponsored_name: sponsoredName,
      organised_by: organisedBy,
      phone: phone,
      email: email,
      rules: rules, // Adding the rules
      advantages: advantages, // Adding the advantages
      sub_tournament: JSON.stringify(subTournaments),
      _token: csrfToken,
    };

    // AJAX request to update the tournament
    $.ajax({
      url: "/api/update-tournaments",
      type: "POST",
      data: data,
      success: function (response) {
        let confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
          <div class="confirm-body">
            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" loading="lazy" alt="Success"></figure>
            <h6>${response.message}</h6>
          </div>
          <div class="confirm-footer">
            <button class="get_back btn btn-secondary">Go Back</button>
          </div>
        </div>
      </div>
    `;
        $("body").append(confirmBoxHtml);
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
        let confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
          <div class="confirm-body">
            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" loading="lazy" alt="Error"></figure>
            <h6>${error}</h6>
          </div>
          <div class="confirm-footer">
            <button class="get_back btn btn-secondary">Go Back</button>
          </div>
        </div>
      </div>
    `;
        $("body").append(confirmBoxHtml);
      },
    });
  });

  // Modify collectRules and collectAdvantages to accept an accordionItem parameter
  function collectRules2($accordionItem) {
    var ruleValues = [];

    $accordionItem.find(".tournament_rules1").each(function () {
      ruleValues.push($(this).val());
    });

    var rules = ruleValues.join("$$");

    return rules;
  }

  function collectAdvantages2($accordionItem) {
    var advantageValues = [];

    $accordionItem.find(".tournament_advantage2").each(function () {
      advantageValues.push($(this).val());
    });

    var advantages = advantageValues.join("$$");

    return advantages;
  }

  $("#pin_btn_tournament").click(function () {
    $("#pin-input-tournament1").val("");
    $("#pin-input-tournament2").val("");
    $("#pin-input-tournament3").val("");
    $("#pin-input-tournament4").val("");

    let confirmBoxHtml = `
    <div class="confirm-box" id="pin_box_tournament" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <h6>Please Set your Pin</h6>
                <p>If you face any problems logging in with the OTP, you can use the PIN you set up to log in instead.</p>
                <p style="color:red" class="pin_error_tournament"></p>
            </div>
          <div class="col-lg-4 col-md-6 mx-auto" style="text-align:center;">
             <div class="d-flex justify-content-center pin-input-tournaments">
               <input type="number" class="form-control pin-input-tournament mx-1" id="pin-input-tournament1" maxlength="1">
               <input type="number" class="form-control pin-input-tournament mx-1" id="pin-input-tournament2" maxlength="1">
               <input type="number" class="form-control pin-input-tournament mx-1" id="pin-input-tournament3" maxlength="1">
               <input type="number" class="form-control pin-input-tournament mx-1" id="pin-input-tournament4" maxlength="1">
             </div>
          </div>
  
            <div class="confirm-footer">
                <button class="btn btn-secondary set_to_update" id="set_pin_tournament">Set Pin</button>
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
  `;
    $("body").append(confirmBoxHtml);

    let pinValue = $("#pin_value_tournament").val();
    if (pinValue.length === 4) {
      $("#pin-input-tournament1").val(pinValue[0]);
      $("#pin-input-tournament2").val(pinValue[1]);
      $("#pin-input-tournament3").val(pinValue[2]);
      $("#pin-input-tournament4").val(pinValue[3]);
      $(".set_to_update").text("Update Pin");
    }
  });

  $(document)
    .on("input", ".pin-input-tournament", function () {
      let currentIndex = $(".pin-input-tournament").index(this);
      let currentValue = $(this).val();

      if (
        currentValue.length === 1 &&
        currentIndex < $(".pin-input-tournament").length - 1
      ) {
        $(".pin-input-tournament")
          .eq(currentIndex + 1)
          .focus();
      }
    })
    .on("keydown", ".pin-input-tournament", function (e) {
      let currentIndex = $(".pin-input-tournament").index(this);

      if (e.key === "Backspace" && $(this).val() === "" && currentIndex > 0) {
        $(".pin-input-tournament")
          .eq(currentIndex - 1)
          .focus();
      }
    });

  $(document).on("click", "#set_pin_tournament", function () {
    let pinValues = [];

    $(".pin-input-tournament").each(function () {
      pinValues.push($(this).val().trim());
    });

    let isValid = pinValues.every((value) => value !== "");

    if (!isValid) {
      $(".pin_error_tournament").text("Please fill all four PIN fields.");
    } else {
      $.ajax({
        url: "/api/setpin",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          pin: pinValues.join(""),
        },
        success: function (response) {
          $(".pin_error_tournament").text("");
          $(".pin-input-tournament").val("");
          $("#pin_box_tournament").remove();

          let confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop4"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt="Success Icon"></figure>
                                <h6>${response.message}</h6>
                            </div>
                            <div class="confirm-footer">
                                <button class="get_back4 btn btn-secondary">Go Back</button>
                            </div>
                        </div>
                    </div>
                `;
          // Append the confirmation box to the body
          $("body").append(confirmBoxHtml);
        },
        error: function (error) {
          // Clear any previous error messages
          $(".pin_error_tournament").text("");
          $(".pin-input-tournament").val("");
          console.error("Failed to set the PIN. Please try again.", error);
        },
      });
    }
  });

  $(document).on("click", ".get_back4", function () {
    $(this).closest(".confirm-box").remove();
    $(".pin-input").val("");
    $(".pin_error").text("");
    location.reload();
  });

  $(document).on("click", ".confirm-backdrop4", function () {
    $(this).closest(".confirm-box").remove();
    $(".pin-input").val("");
    $(".pin_error").text("");
    location.reload();
  });
});
