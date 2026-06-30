$(document).ready(function () {
  let selectedLocationIds = [];
  let selectedIdString = "";
  let index = 0;
  let trialData = {};
  let existingTrialData="";
  var url = window.location.href;
  let inputVal = $("#hidden_id_input").val().split(",");
  inputVal.forEach(function (id) {
    selectedLocationIds.push(id.trim()); // trim() removes any extra spaces
  });
  let flag = true;
  handlePageSwitch("#profile_box", "#profile_page");

  var content = $("#profile-about").val();

  // Set the content in the Quill editor
  quill.root.innerHTML = content;

  //====== dashboard tab change js start==========//

  $("#dashboard_box").click(() =>
    handlePageSwitch("#dashboard_box", "#dashboard_page")
  );
  $("#profile_box").click(() =>
    handlePageSwitch("#profile_box", "#profile_page")
  );
  $("#leads_box").click(() => handlePageSwitch("#leads_box", "#leads_page"));
  $("#boost_box").click(() => handlePageSwitch("#boost_box", "#boost_page"));
  $("#order_box").click(() => handlePageSwitch("#order_box", "#order_page"));
  $("#notification_box").click(() =>
    handlePageSwitch("#notification_box", "#notification_page")
  );
  $("#tournament_box").click(() =>
    handlePageSwitch("#tournament_box", "#tournament_page")
  );
  $("#view_box").click(() => handlePageSwitch("#view_box", "#view_page"));
  $("#upgrade_box").click(() => handlePageSwitch("#boost_box", "#boost_page"));

  //======dashboard tab change js End==========//

  //==========add location js Ends=============//

  // handle tab change start //
  function handlePageSwitch(activeBox, activePage) {
    const pages = [
      "#dashboard_page",
      "#leads_page",
      "#boost_page",
      "#notification_page",
      "#profile_page",
      "#upgrade_page",
      "#order_page",
      "#tournament_page",
      "#view_page",
    ];
    const boxes = [
      "#dashboard_box",
      "#leads_box",
      "#boost_box",
      "#notification_box",
      "#profile_box",
      "#order_box",
      "#tournament_box",
      "#view_box",
    ];

    pages.forEach((page) => $(page).hide());
    boxes.forEach((box) => $(box).removeClass("active"));

    $(activePage).show();
    $(activeBox).addClass("active");

    if (activeBox === "#dashboard_box" || activeBox === "#profile_box") {
      $("#dashboard_info").show();
    } else {
      $("#dashboard_info").hide();
    }

    if (activeBox === "#profile_box") {
      $(".dashboard-menu-section .page-menu.active-page .progress-txt").css(
        "color",
        "#fff"
      );
      $(
        ".dashboard-menu-section .page-menu.active-page .progress-bar span"
      ).css("background", "#fff");
      $(".dashboard-menu-section .page-menu.active-page .progress-bar").css(
        "background",
        "#FFFFFF80"
      );
    } else {
      $(".dashboard-menu-section .page-menu.active-page .progress-txt").css(
        "color",
        "#FB5D52"
      );
      $(
        ".dashboard-menu-section .page-menu.active-page .progress-bar span"
      ).css("background", "#fb5d52");
      $(".dashboard-menu-section .page-menu.active-page .progress-bar").css(
        "background",
        "#f5bbb8"
      );
    }

    if (
      activePage === "#dashboard_page" ||
      activePage === "#profile_page" ||
      activePage === "#leads_page" ||
      activePage === "#notification_page"
    ) {
      setTimeout(() => {
        $.ajax({
          url: `${url}`,
          type: "GET",
          async: true,
          success: function (response) {
            let reviews = "";
            let leads = "";
            let notifications = "";

            if (
              activePage === "#dashboard_page" &&
              response.reviews.length > 0
            ) {
              response.reviews.forEach(function (review) {
                let profile =
                  "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/logo.svg";

                reviews += '<div class="card">';
                reviews += '<div class="card-header">';
                reviews += `<div class="card-image review-img"><img src="${profile}" alt="Avatar"></div>`;
                reviews += '<div class="card-info">';
                reviews += `<h6>${review.name ? review.name : "-"}</h6>`;
                reviews += "<p>Kolkata, West Bengal</p>";
                reviews += "</div>";
                reviews += `<div class="card-rating"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${review.rating}star.png" alt=""></div>`;
                reviews += "</div>";
                response += '<div class="card-content">';
                reviews += `<p>${review.comment}</p>`;
                reviews += "</div>";
                reviews += "</div>";
              });
              $("#coach-admin-reviews").html(reviews);
            } else {
              $("#coach-admin-reviews").html("<p>no reviews Found</p>");
            }

            if (activePage === "#leads_page" && response.leads.length > 0) {
              response.leads.sort(function (a, b) {
                const dateA = new Date(a.creation_date.replace(/-/g, "/"));
                const dateB = new Date(b.creation_date.replace(/-/g, "/"));

                // Compare dates first
                if (dateA > dateB) return -1;
                if (dateA < dateB) return 1;

                // If dates are the same, compare times
                const timeA = new Date(a.creation_time || "00:00");
                const timeB = new Date(b.creation_time || "00:00");

                if (timeA > timeB) return -1;
                if (timeA < timeB) return 1;

                return 0;
              });

              let leads = "";
              response.leads.forEach(function (lead) {
                let leadOpen = lead.open;
                const creationDateString = lead.creation_date;
                let creationDate = new Date(
                  creationDateString.replace(/-/g, "/")
                );

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
                  <div class="col-lg-6">
                    <div class="lead-card">
                      <div class="view_details_btn">
                        <figure><img src="${profile}" class="img-fluid" alt=""></figure>
                      </div>
                      <div class="d-flex justify-content-start align-items-start gap-3">
                        <div>
                          <h6 style="margin-bottom:0;">Id: <span class="lead_id">${
                            lead.assignment_id
                          }</span></h6>
                          <!-- Always display the Lead Date -->
                          <p style="white-space:nowrap;margin-top:0;">
                            <span style="font-weight:700">Lead Date:</span> ${formattedDate} @ ${formattedTime}
                          </p>
                          <!-- Conditionally display the Open Date/Time if leadOpen is 1 -->
                          ${
                            leadOpen === 1 &&
                            formattedOpenDate &&
                            formattedOpenTime
                              ? `
                          <p style="white-space:nowrap;margin-top:0;">
                            <span style="font-weight:700">Open Date:</span> ${formattedOpenDate} @ ${formattedOpenTime}
                          </p>
                          `
                              : ""
                          }
                          <h6 class="lead-name">Name: ${
                            lead.name ? lead.name : "-"
                          }</h6>
                          <div class="more-details" style="display:${
                            leadOpen === 1 ? "block" : "none"
                          };">
                            <p class="d-flex justify-content-start align-items-center whatsapp_num gap-1" style="margin-top:-0.5rem">
                              <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> +91 ${
                                lead.phone ? lead.phone : "-"
                              }
                              <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/mwhtaps.svg" alt="whatsapp" class="whatsapp_icon" data-name="${
                                lead.name
                              }" data-phone="${lead.phone}" />
                            </p>
                            <p style="margin-top:0;">
                              <i class="fa-solid fa-location-dot" aria-hidden="true" style="margin-right:5px;"></i>
                              ${
                                lead.locality_name
                                  ? lead.locality_name
                                  : "India"
                              }
                            </p>
                          </div>
                          <button style="display:${
                            leadOpen === 0 ? "block" : "none"
                          };" class="btn btn-primary view-description-btn">View Detail</button>
                        </div>   
                      </div>
                
                      <div class="leads-description" style="display: ${
                        leadOpen === 1 ? "block" : "none"
                      };">
                        <p> <span style="font-weight:700">Description: </span>${
                          lead.description ? lead.description : "-"
                        }</p>
                      </div>
                      <div class="feed_back_box" style="display: ${
                        leadOpen === 1 ? "block" : "none"
                      };">
                        ${
                          lead.feedback == null
                            ? `<button class="btn feedback_btn mt-3 mb-3 w-100" data-lead-name="${lead.name}" data-lead-id="${lead.assignment_id}">Feedback</button>`
                            : `<button class="btn feedback_view_btn mt-3 mb-3 w-100" data-lead-id="${lead.assignment_id}" data-lead-name="${lead.name}" data-feedback="${lead.feedback}">View Feedback</button>`
                        }
                      </div>
                    </div>
                  </div>`;
              });

              $("#coach-admin-leads").html(leads);
            } else {
              $("#coach-admin-leads").html("<p>no lead Found</p>");
            }
          },
        });
      }, 1000);
    }

    if (activePage === "#boost_page") {
      $.ajax({
        url: `/api/getPremiumPlans`,
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          type_id: 2,
        },
        success: async function (response) {
          if (response.data.length > 0) {
            for (let i = response.data.length - 1; i >= 0; i--) {
              let plan = response.data[i];

              // Determine the button HTML based on the plan id
              let buttonHtml;
              if (plan.id === 1) {
                buttonHtml = `<button type="button" class="plan_btn">Choose This Plan</button>`;
              } else {
                buttonHtml = `<button class="plan_btn plan_btn_${plan.id}" onClick="makePayment(${plan.id})" >Choose This Plan</button>`;
              }

              // Split the features string by commas and create <li> items
              let featuresHtml = "";
              if (plan.features) {
                featuresHtml = plan.features
                  .split(",")
                  .map((feature) => `<li>✔ ${feature.trim()}</li>`)
                  .join("");
              }

              // Generate the HTML for the plan
              let planHtml = `
                <div class="col-4 min-width">
                  <div class="free-plan ${
                    plan.id === 2
                      ? "start-plan"
                      : plan.id === 3
                      ? "premium-plan"
                      : plan.id === 4
                      ? "lead-new-plan"
                      : "free-plan"
                  }">
                    <div class="heading">${plan.name}</div>
                    <ul>
                      <li><span class="normal_price">${
                        plan.offer_price == 0
                          ? "Free"
                          : `₹ ${plan.offer_price}</span><span><sub> / ${plan.duration} Months (including GST)</sub></span>`
                      }</li>
                      <li>${buttonHtml}</li>
                      ${featuresHtml}
                    </ul>
                  </div>
                </div>  
              `;

              if (flag) {
                $(".plan_map").html(function (_, currentHtml) {
                  return currentHtml + planHtml;
                });
              }
            }

            flag = false;
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr);
        },
      });
    }
  }

  //==========feedback js==========//
  $(document).on("click", ".feedback_btn", function () {
    const leadName = $(this).data("lead-name");
    leadAssignId = $(this).data("lead-id");
    $(".lead_name").text(leadName);
    $(".lead_id2").text(leadAssignId);
    $(".confirm-box textarea").val("");
    $(".confirm-box.feedback_modal").css("display", "flex");
    $(".confirm-box.feedback_modal").show();
  });

  $(document).on("click", ".feedback_view_btn", function () {
    const leadName = $(this).data("lead-name");
    const leadFeedback = $(this).data("feedback");
    const leadId = $(this).data("lead-id");
    $(".lead_name2").text(leadName);
    $(".lead_id3").text(leadId);
    $(".feedback_view").text(leadFeedback);
    $(".confirm-box.feedback_modal2").css("display", "flex");
    $(".confirm-box.feedback_modal2").show();
  });

  $(".feedback-submit").click(function () {
    let feedbackMessage = $(".feedback_area").val().trim();

    if (feedbackMessage === "") {
      $(".feedback_error").text("Please Enter Your Feedback").show();
    } else {
      $.ajax({
        url: "/modify-lead-status",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          type: "feedback",
          lead_assigned_id: leadAssignId,
          feedback: feedbackMessage,
        },
        beforeSend: function () {
          // Disable the button and change the text to "Sending...!!!"
          $(".feedback-submit").prop("disabled", true).text("Sending...!!!");
        },
        success: function (response) {
          $(".feedback_error").hide();
          $(".confirm-box.feedback_modal").hide();
          let confirmBoxHtml = `
              <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                  <div class="confirm-body">
                    <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                    <h6>${response.message}</h6>
                  </div>
                  <div class="confirm-footer">
                    <button class="get_back btn btn-secondary">Go Back</button>
                  </div>
                </div>
              </div>
            `;
          $("body").append(confirmBoxHtml);
          handlePageSwitch("#leads_box", "#leads_page");
        },
        complete: function () {
          // Re-enable the button and reset the text after the request completes
          $(".feedback-submit").prop("disabled", false).text("Submit Feedback");
        },
        error: function (xhr, status, error) {
          // Code to execute if the request fails
          console.error("Error marking lead as read:", error);
          $(".feedback-submit").prop("disabled", false).text("Submit Feedback"); // Re-enable in case of an error
        },
      });
    }
  });

  //==========feedback js ends==========//

  $(document).on("click", ".view-description-btn", function () {
    // Show the lead description
    const leadId = $(this).closest(".lead-card").find(".lead_id").text().trim();
    $(this).closest(".lead-card").find(".more-details").show();
    $(this).closest(".lead-card").find(".leads-description").show();
    $(this).closest(".lead-card").find(".feed_back_box").show();
    $(this).hide();
    $.ajax({
      url: "/modify-lead-status",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        lead_assigned_id: leadId,
      },
      success: function (response) {
        handlePageSwitch("#leads_box", "#leads_page");
      },
      error: function (xhr, status, error) {
        // code to execute if the request fails
        console.error("Error marking lead as read:", error);
      },
    });
  });

  $(document).on("click", ".whatsapp_num", function (event) {
    event.preventDefault();
    const whatsappIcon = $(this).find(".whatsapp_icon");
    const leadName = whatsappIcon.data("name") || "-";
    const academyName = $("#academy_name").val();
    const userPhone = whatsappIcon.data("phone") || "";

    let whatsappMessage = `Hy ${leadName},\n\nWe are from ${academyName}, and we are verified academy from BookMyPlayer.com. We can connect on a call to discuss your needs and how can we help you to achieve your goals.\n\nLooking forward to speaking with you soon!\n\nBest regards,\n${academyName}\nCertified Bookmyplayer Academy\n\nwww.bookmyplayer.com

`;
    let encodedMessage = encodeURIComponent(whatsappMessage);

    window.open(
      `https://api.whatsapp.com/send?phone=+91${userPhone}&text=${encodedMessage}`,
      "_blank"
    );
  });

  // handle city input start
  let locationList = [];

  $("#locationInput").on("input", async function () {
    let inputVal = $(this).val().toLowerCase();

    if (inputVal.length === 0) {
      $("#location-name").empty();
      $(".location-list").css("display", "none");
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
    updateLocationDropdown(locationList, inputVal);
  });

  $("#nearByInput").on("input", async function () {
    let inputVal = $(this).val().toLowerCase();

    if (inputVal.length === 0) {
      $("#location-name2").empty();
      $(".nearby_list").css("display", "none");
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
    updateLocationDropdown2(locationList, inputVal);
  });

  function updateLocationDropdown(locations, filter) {
    $("#location-name").empty(); // Clear previous options
    $(".location-list").css("display", "block");

    let filteredLocation = locations.filter(
      (location) =>
        location.locality_name.toLowerCase().includes(filter.toLowerCase()) ||
        location.postcode.toString().includes(filter)
    );

    if (filteredLocation.length === 0) {
      $("#location-name").html(
        '<p style="padding-left:1rem;padding-top:1rem">No match found</p>'
      );
    } else {
      filteredLocation.forEach(function (location) {
        $("#location-name").append(`
          <li class="dropdown-item location-item" 
              data-id="${location.id}" 
              data-locality="${location.locality_name}" 
              data-city="${location.city}" 
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

  function updateLocationDropdown2(locations, filter) {
    $("#location-name2").empty(); // Clear previous options
    $(".nearby_list").css("display", "block");

    let filteredLocation = locations.filter((location) =>
      location.locality_name.toLowerCase().includes(filter)
    );

    if (filteredLocation.length === 0) {
      $("#location-name2").html(
        '<p style="padding-left:1rem;padding-top:1rem">No match found</p>'
      );
    } else {
      filteredLocation.forEach(function (location) {
        $("#location-name2").append(`
          <li class="dropdown-item location-item2" 
              data-id="${location.id}" 
              data-locality="${location.locality_name}" 
              data-city="${location.city}" 
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

  function selectFirstLocation() {
    let firstLocation = $("#location-name li:first-child");
    if (firstLocation.length) {
      firstLocation.trigger("click");
    }
  }
  function selectFirstLocation2() {
    let firstLocation = $("#location-name2 li:first-child");
    if (firstLocation.length) {
      firstLocation.trigger("click");
    }
  }

  $("#location-name").on("click", ".location-item", function () {
    let locationId = $(this).data("id");
    let cityName = $(this).data("city");
    let pincode = $(this).data("postcode");
    let locationName = $(this).data("locality");
    $("#locationInput").val(cityName);
    $("#pin_code").val(pincode);
    $("#address2").val(locationName);
    $("#loc_id_input").val(locationId);
    $("#location-name").empty();
    $(".location-list").css("display", "none");
  });

  $("#location-name2").on("click", ".location-item2", function () {
    let locationId2 = $(this).data("id");
    let cityName2 = $(this).data("city");
    let localityName = $(this).data("locality");
    let checkString = selectedLocationIds.join(",");

    // Check if the location ID is already in the array
    if (checkString.includes(locationId2.toString())) {
      $("body").append(`
          <div id="image_box" class="confirm-box" style="z-index: 10;">
              <div class="confirm-backdrop confirm_location"></div>
              <div class="confirm-content">
                  <div class="confirm-body">
                      <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                      <h6>You have already selected this location.</h6>
                  </div>
                  <div class="confirm-footer">
                      <button id="location_back" class=" btn btn-secondary">Go Back</button>
                  </div>
              </div>
          </div>
      `);
    } else {
      // Append city name with a cross button
      $(".nearby_locations").append(`
            <div class="location-item d-flex align-items-center" data-id="${locationId2}" 
                style="background-color:#FFd6F5; border: none; border-radius: 50px; margin: 0.25rem 0;padding:0.1rem 0.5rem; white-space:nowrap">
                <span style="margin-right: 0.5rem;">${localityName}</span>
                <button class="remove-location btn btn-sm" style="background-color: transparent; border: none; color: red;">X</button>
            </div>
        `);

      // Push locationId2 into the array
      selectedLocationIds.push(locationId2);
      selectedIdString = selectedLocationIds.join(",");
      $("#hidden_id_input").val(selectedIdString);
    }

    $("#nearByInput").val("");
    $("#location-name2").empty();
    $(".nearby_list").css("display", "none");
  });

  $(document).on("click", "#location_back", function () {
    $(this).closest(".confirm-box").hide();
  });

  // Hide confirmation box when clicking outside the box
  $(document).on("click", ".confirm_location", function () {
    $(this).closest(".confirm-box").remove();
  });

  // Handle click on cross (remove location)
  $(".nearby_locations").on("click", ".remove-location", function () {
    let parentDiv = $(this).closest(".location-item");
    let locationIdToRemove = parentDiv.data("id").toString(); // Ensure the ID is treated as a string
    parentDiv.remove();

    selectedLocationIds = selectedLocationIds.filter(
      (id) => id.toString() !== locationIdToRemove
    );

    let selectedIdString = selectedLocationIds.join(",");
    $("#hidden_id_input").val(selectedIdString);
  });

  $(document).click(function (event) {
    if (!$(event.target).closest("#location-name, .location-list").length) {
      selectFirstLocation();
      $(".location-list").css("display", "none");
    }
  });
  $(document).click(function (event) {
    if (!$(event.target).closest("#location-name2, .nearby_list").length) {
      selectFirstLocation2();
      $(".nearby_list").css("display", "none");
    }
  });

  $("#locationInput").on("keydown", function (e) {
    if (e.key === "Enter" || e.key === "Tab") {
      selectFirstLocation();
    }
  });

  $("#nearByInput").on("keydown", function (e) {
    if (e.key === "Enter" || e.key === "Tab") {
      selectFirstLocation2();
    }
  });

  // master functions
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

  //==============photo and video upload
  $("#file-upload").change(function () {
    const files = this.files;
    const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
    const fileTypeError = $("#fileTypeError");
    const photosContainer = $(".photos-container");

    if (files.length === 0) {
        fileTypeError.text("Please select at least one file.");
        fileTypeError.show();
        return;
    }

    fileTypeError.hide(); // Hide error messages

    const uploadFile = (index) => {
        if (index >= files.length){
          $("body").append(`
            <div id="video_box" class="confirm-box" style="z-index: 10;">
              <div class="confirm-backdrop-2 confirm-vdeo-backdrop"></div>
              <div class="confirm-content">
                <div class="confirm-body">
                  <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                  <h6>Photos Uploaded</h6>
                </div>
                <div class="confirm-footer">
                  <button id="video_back2" class="btn btn-secondary">Go Back</button>
                </div>
              </div>
            </div>
          `);
        }

        const file = files[index];
        if (!allowedTypes.includes(file.type)) {
            fileTypeError.text("Only image files are allowed.");
            fileTypeError.show();
            uploadFile(index + 1); // Skip invalid file
            return;
        }

        const formData = new FormData();
        formData.append("file", file);
        formData.append("_token", $("input[name='_token']").val());
        formData.append("loc_id", $("#loc_id_input").val());
        formData.append("name", $("#hidden_name_input").val());

        // Add loader to the container
        const loaderTemplate = `
            <div class="col-lg-3 col-md-6 photo-card loader-card">
                <div class="add-card">
                    <div class="d-flex justify-content-center align-items-center" id="photo-loader">
                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" alt="Uploading...">
                    </div>
                </div>
            </div>`;
        const loaderElement = $(loaderTemplate);
        photosContainer.append(loaderElement);

        // Perform AJAX upload
        $.ajax({
            type: "POST",
            url: $("#img_submit").attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 1) {
                    const newImageTemplate = `
                        <div class="col-lg-3 col-md-6 photo-card">
                            <div class="add-card">
                                <div class="make-profile d-flex justify-content-start align-items-start gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input profile-radio" type="radio" name="flexRadioDefault" value="${response.photo}">
                                        <label class="form-check-label">Logo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input profile-radio" type="radio" name="flexRadioBannerDefault" value="${response.photo}">
                                        <label class="form-check-label">Banner</label>
                                    </div>
                                </div>
                                <div class="delete">
                                    <input type="checkbox" class="photos-checkbox" name="selected_images[]" value="${response.photo}">
                                </div>
                                <figure><img src="${response.result.url}" alt="Uploaded Image"></figure>
                            </div>
                        </div>`;
                    loaderElement.replaceWith(newImageTemplate);

                } else {
                    console.error("Upload failed:", response.message);
                    loaderElement.remove();
                }
                uploadFile(index + 1); // Process the next file
            },
            error: function () {
                console.error("Error uploading file:", file.name);
                fileTypeError.text("Error uploading file.");
                fileTypeError.show();
                loaderElement.remove();
                uploadFile(index + 1); // Process the next file
            }
        });
    };

    // Start uploading the first file
    uploadFile(0);
});


let maxFileSize = 120 * 1024 * 1024;
let allowedVideoTypes = ["video/mp4", "video/webm", "video/ogg", "video/quicktime"];
let allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];

// Handle file change and initiate video upload one by one
$("#file-upload-2").change(function () {
  let files = this.files;

  if (files.length > 0) {
    uploadVideo(files, 0); // Start with the first video
  }
});

function uploadVideo(files, index) {
  const videosContainer = $(".videos-container");
  if (index >= files.length) {

    $("body").append(`
      <div id="video_box" class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop-2 confirm-vdeo-backdrop"></div>
        <div class="confirm-content">
          <div class="confirm-body">
            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
            <h6>Videos Uploaded</h6>
          </div>
          <div class="confirm-footer">
            <button id="video_back2" class="btn btn-secondary">Go Back</button>
          </div>
        </div>
      </div>
    `);
  }

  let file = files[index];
  if (
    allowedImageTypes.includes(file.type) ||
    allowedVideoTypes.includes(file.type)
  ) {
    if (file.size <= maxFileSize) {
      let formData = new FormData();
      formData.append('file', file);
      formData.append("_token", $("input[name='_token']").val());
      formData.append("loc_id", $("#loc_id_input").val());
      formData.append("name", $("#hidden_name_input").val());

      // Create a loader for the current video
      const loaderTemplate = `
      <div class="col-lg-3 col-md-6 photo-card loader-card">
          <div class="add-card">
              <div class="d-flex justify-content-center align-items-center" id="video-loader">
                  <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" alt="Uploading...">
              </div>
          </div>
      </div>`;
      const loaderVideoElement = $(loaderTemplate);
      videosContainer.append(loaderVideoElement);

      // Submit the video via AJAX
      $.ajax({
        type: "POST",
        url: $("#video_submit").attr("action"),
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status == 1) {
            let newVideoCard = `
              <div class="col-lg-3 col-md-6">
                <div class="add-card">
                  <figure>
                    <video controls>
                      <source src="${response.result.url}" type="video/mp4">
                      <source src="${response.result.url}" type="video/quicktime">
                      <source src="${response.result.url}" type="video/ogg">
                    </video>
                  </figure>
                  <div class="delete">
                    <input type="checkbox" class="video-checkbox" name="selected_videos[]" value="${response.video_url}">
                  </div>
                </div>
              </div>
            `;
            loaderVideoElement.replaceWith(newVideoCard);
          } else {
            displayError(response.message);
            loaderVideoElement.remove(); // Remove loader on error
          }

          // Proceed to the next video
          uploadVideo(files, index + 1);
        },
        error: function (error) {
          console.error("Form submission error:", error);
          displayError("An error occurred during the upload.");
          loaderVideoElement.remove(); // Remove loader on error

          // Proceed to the next video to avoid a stuck loop
          uploadVideo(files, index + 1);
        },
      });
    } else {
      displayError("Please upload a video that is less than 120 MB in size.");
      // Skip to the next video
      uploadVideo(files, index + 1);
    }
  } else {
    displayError("Only video files are allowed.");
    // Skip to the next video
    uploadVideo(files, index + 1);
  }
}

$(document).on("click", ".confirm-vdeo-backdrop", function () {
  location.reload(); // Reload the page
});

// Function to display error message
function displayError(message) {
  $("body").append(`
    <div id="video_box" class="confirm-box" style="z-index: 10;">
      <div class="confirm-backdrop-2"></div>
      <div class="confirm-content">
        <div class="confirm-body">
          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
          <h6>${message}</h6>
        </div>
        <div class="confirm-footer">
          <button id="video_back" class="btn btn-secondary">Go Back</button>
        </div>
      </div>
    </div>
  `);

  // Close error modal on button click
  $("#video_back").on("click", function () {
    $("#video_box").remove();
  });
}


  

  $(document).on("click", "#video_back", function () {
    $("#video_box").hide();
  });
  $(document).on("click", "#video_back2", function () {
    $("#video_box").hide();
    location.reload();
  });

  $(document).on("click", function (event) {
    if (
      !$(event.target).closest(".confirm-content").length &&
      $("#video_box").is(":visible")
    ) {
      $("#video_box").hide();
    }
  });

  $(".delete_btn").on("click", function () {
    $("#customConfirmBox3").show();
  });

  $("#confirmCancel3").on("click", function () {
    $("#customConfirmBox3").hide();
  });

  $("#confirmOk3").on("click", function () {
    $("#delete_form").submit();
  });

  $(".delete_btn2").on("click", function () {
    $("#customConfirmBox2").show();
  });

  $("#confirmCancel2").on("click", function () {
    $("#customConfirmBox2").hide();
  });

  $("#confirmOk2").on("click", function () {
    $("#delete_form2").submit();
  });

  $(".photos-checkbox").on("change", function () {
    if ($(".photos-checkbox:checked").length > 0) {
      $(".delete_btn").show();
    } else {
      $(".delete_btn").hide();
    }
  });

$('#select-all').on('click', function (e) {
  e.stopPropagation();
  let isChecked = $(this).is(':checked');
  $('.photos-checkbox').prop('checked', isChecked);

  if ($(".photos-checkbox:checked").length > 0) {
    $(".delete_btn").show();
  } else {
    $(".delete_btn").hide();
  }
});
$('#select-all-video').on('click', function (e) {
  e.stopPropagation();
  let isChecked = $(this).is(':checked');
  $('.video-checkbox').prop('checked', isChecked);

  if ($(".video-checkbox:checked").length > 0) {
    $(".delete_btn2").show();
  } else {
    $(".delete_btn2").hide();
  }
});


  $(".video-checkbox").on("change", function () {
    if ($(".video-checkbox:checked").length > 0) {
      $(".delete_btn2").show();
    } else {
      $(".delete_btn2").hide();
    }
  });

  //==========certificate js start==========//

  $("#file-upload-3").change(function () {
    let file = this.files[0];
    if (file) {
      let allowedFileTypes = [
        "image/jpeg",
        "image/png",
        "image/gif",
        "application/pdf",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      ];

      if (allowedFileTypes.includes(file.type)) {
        // Prevent the default form submission
        $("#certificate_submit").on("submit", function (event) {
          event.preventDefault();

          // Create a FormData object
          let formData = new FormData(this);

          // Submit the form via AJAX
          $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              $("body").append(`
                  <div id="cerificates_box" class="confirm-box" style="z-index: 10;">
                      <div class="confirm-backdrop-2"></div>
                      <div class="confirm-content">
                          <div class="confirm-body">
                              <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                              <h6> Certificates Uploaded</h6>
                          </div>
                          <div class="confirm-footer">
                              <button id="certificates_back" class=" btn btn-secondary">Go Back</button>
                          </div>
                      </div>
                  </div>
              `);

              $(document).on("click", "#certificates_back", function () {
                location.reload();
              });

              $(document).on(
                "click",
                "#cerificates_box .confirm-backdrop-2",
                function () {
                  location.reload();
                }
              );
            },
            error: function (error) {
              console.error("Form submission error:", error);
              // Handle error if needed
            },
          });
        });

        // Trigger the form submission
        $("#certificate_submit").submit();
      } else {
        let fileTypeError = $("#fileTypeError");
        fileTypeError.text("Only image, video, and PDF files are allowed.");
        fileTypeError.show();
      }
    }
  });

  $(".delete_btn_3").on("click", function () {
    $("#customConfirmBox4").show();
  });

  $("#confirmCancel4").on("click", function () {
    $("#customConfirmBox4").hide();
  });

  $("#confirmOk4").on("click", function () {
    $("#delete_form3").submit();
  });

  $(".certificate-checkbox").on("change", function () {
    if ($(".certificate-checkbox:checked").length > 0) {
      $(".delete_btn_3").show();
    } else {
      $(".delete_btn_3").hide();
    }
  });

  //==========certificate js end==========//

  //=============profile image===========//
  $('input[name="flexRadioDefault"]').change(function () {
    if ($(this).is(":checked")) {
      let profileImageUrl = $(this).val();
      let profileImage = profileImageUrl.split("/").pop();
      let userName = $("#hidden_name_input").val();
      let locId = $("#loc_id_input").val();
      $.ajax({
        url: `/academy/dashboard/update-profile`,
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          logo: profileImage,
          name: userName,
          loc_id: locId,
        },
        async: true,
        success: async function (response) {
          location.reload();
        },
        error: function (xhr, status, error) {
          console.error(xhr);
        },
      });
    }
  });
  $('input[name="flexRadioBannerDefault"]').change(function () {
    if ($(this).is(":checked")) {
      let profileImageUrl = $(this).val();
      let profileImage = profileImageUrl.split("/").pop();
      let userName = $("#hidden_name_input").val();
      let locId = $("#loc_id_input").val();
      $.ajax({
        url: `/academy/dashboard/update-profile`,
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          banner: profileImage,
          name: userName,
          loc_id: locId,
        },
        async: true,
        success: async function (response) {
          location.reload();
        },
        error: function (xhr, status, error) {
          console.error(xhr);
        },
      });
    }
  });

  //=============profile image end===========//

  function copyToClipboard(inputId) {
    var copyText = $(inputId);
    // Select the text field
    copyText.select();
    copyText[0].setSelectionRange(0, 99999); // For mobile devices
    document.execCommand("copy");
  }

  $("#copy_link").on("click", function () {
    copyToClipboard("#linkInput");
  });

  $("#copy_link_dashboard").on("click", function () {
    copyToClipboard("#linkInputDashboard");
  });

  $("#customConfirmBox .confirm-backdrop").click(function () {
    $("#customConfirmBox").hide();
  });
  $("#customConfirmBox2 .confirm-backdrop").click(function () {
    $("#customConfirmBox2").hide();
  });
  $("#customConfirmBox3 .confirm-backdrop").click(function () {
    $("#customConfirmBox3").hide();
  });
  $("#customConfirmBox4 .confirm-backdrop").click(function () {
    $("#customConfirmBox4").hide();
  });

  $("#profile-name").on("input", function () {
    let nameValue = $(this).val();
    $("#hidden_name_input").val(nameValue);
  });

  // ticket tabs

  // tabbed content
  $(".tab_content").hide();
  $(".tab_content:first").show();

  /* if in tab mode */
  $("ul.tabs li").click(function () {
    $(".tab_content").hide();
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn();

    $("ul.tabs li").removeClass("active");
    $(this).addClass("active");

    $(".tab_drawer_heading").removeClass("d_active");
    $(".tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");

    /*$(".tabs").css("margin-top", function(){
         return ($(".tab_container").outerHeight() - $(".tabs").outerHeight() ) / 2;
      });*/
  });
  $(".tab_container").css("min-height", function () {
    return $(".tabs").outerHeight() + 50;
  });
  /* if in drawer mode */
  $(".tab_drawer_heading").click(function () {
    $(".tab_content").hide();
    var d_activeTab = $(this).attr("rel");
    $("#" + d_activeTab).fadeIn();

    $(".tab_drawer_heading").removeClass("d_active");
    $(this).addClass("d_active");

    $("ul.tabs li").removeClass("active");
    $("ul.tabs li[rel^='" + d_activeTab + "']").addClass("active");
  });

  // support modal

  $("#openModalBtn").click(function () {
    $("#modalBg").show();
  });

  $("#closeModalBtn").click(function () {
    $("#modalBg").hide();
  });

  // Optional: Close the modal when clicking outside the box
  $(window).click(function (event) {
    if ($(event.target).is("#modalBg")) {
      $("#modalBg").hide();
    }
  });

  function tickets() {
    setTimeout(() => {
      $.ajax({
        url: `${url}`,
        type: "GET",
        async: true,
        success: function (response) {
          let ticketsHtml = "";
          response.tickets.forEach((ticket) => {
            let statusClass = ticket.status == 0 ? "pending" : "completed";
            let statusText = ticket.status == 0 ? "Pending" : "Completed";
            ticketsHtml += `<div class="ticket-section clearfix">
            <div class="container">
                <div class="accordion" id="accordionPanelsTicket01">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-heading${ticket.id}">
                            <button class="accordion-button ticket_space" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapse${ticket.id}" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapse${ticket.id}">
                                <div class="ticketID">
                                    Ticket ID <strong>#${ticket.id}</strong>
                                </div>
                                <div class="date">
                                    Created Date <strong>${ticket.created_at}</strong>
                                </div>
                                <div class="status">
                                    Status <strong class="${statusClass}"><i class="fa-regular fa-clock"></i> ${statusText}</strong>
                                </div>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapse${ticket.id}" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-heading${ticket.id}">
                            <div class="accordion-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <p>Description about the tickets<br><strong>${ticket.description}</strong></p>
                                <div class="issue-images">`;
            if (ticket.attachment) {
              ticketsHtml += `<img src="https://f005.backblazeb2.com/file/bmpcdn90/attachments/tickets/${ticket.attachment}" class="ticket_img" loading="lazy" alt="" />`;
            }
            ticketsHtml += `</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
          });

          $(".ticket_display").append(ticketsHtml);
        },
      });
    }, 1000);
  }
  tickets();

  //==========validation for city======//

  $("#btn-save-personal-info").on("click", () => {
    let cityValue = $("#locationInput").val();
    if (
      cityValue == "select" ||
      cityValue == "Select" ||
      cityValue == "" ||
      cityValue == null
    ) {
      $("#city_error").show();
    } else {
      $("#profile-about").val(quill.root.innerHTML);

      let formData = $("#coach_update").serialize(); // Serialize form data

      $.ajax({
        url: $("#coach_update").attr("action"), // Form action URL
        type: "POST", // Form method
        data: formData, // Serialized form data
        success: function (response) {
          let confirmBoxHtml = `
            <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
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
          let errorMessage = xhr.responseJSON
            ? xhr.responseJSON.message
            : "An error occurred";
          let confirmBoxHtml = `
                <div class="confirm-box" style="z-index: 10;">
                    <div class="confirm-backdrop"></div>
                    <div class="confirm-content">
                        <div class="confirm-body">
                            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                            <h6>${errorMessage}</h6>
                        </div>
                        <div class="confirm-footer">
                            <button class="get_back btn btn-secondary">Go Back</button>
                        </div>
                    </div>
                </div>
            `;
          // Append the confirmation box to the body
          $("body").append(confirmBoxHtml);
        },
      });
    }
  });

  $(document).on("click", ".get_back", function () {
    $(this).closest(".confirm-box").remove();
    $(".pin-input").val("");
    $(".pin_error").text("");
  });
  $(document).on("click", ".get_back2", function () {
    $(this).closest(".confirm-box").hide();
    $(".feedback_error").hide();
  });
  $(document).on("click", ".get_back3", function () {
    $(this).closest(".confirm-box").hide();
    $(".feedback_error").hide();
  });
  $(document).on("click", ".get_back4", function () {
    $(this).closest(".confirm-box").hide();
    location.reload();
  });

  // Hide confirmation box when clicking outside the box
  $(document).on("click", ".confirm-backdrop", function () {
    $(this).closest(".confirm-box").remove();
    $(".pin-input").val("");
    $(".pin_error").text("");
  });
  $(document).on("click", ".confirm-backdrop2", function () {
    $(this).closest(".confirm-box").hide();
    $(".feedback_error").hide();
  });
  $(document).on("click", ".confirm-backdrop3", function () {
    $(this).closest(".confirm-box").hide();
    $(".feedback_error").hide();
  });
  $(document).on("click", ".confirm-backdrop4", function () {
    $(this).closest(".confirm-box").hide();
    location.reload();
  });

  $("#city_back").on("click", () => {
    $("#city_error").hide();
  });

  $("#city_error .confirm-backdrop").click(function () {
    $("#city_error").hide();
  });

  $("#locationInput").click(function () {
    $(this).val("");
  });
  $("#nearByInput").click(function () {
    $(this).val("");
  });

  $("#player_dob").on("focus", function () {
    this.showPicker();
  });

  //=======packages=========//

  // update coach pricing start

  function submitPackageForm() {
    let formData = $("#package_update").serialize(); // Serialize form data

    $.ajax({
      url: $("#package_update").attr("action"), // Form action URL
      type: "POST", // Form method
      data: formData, // Serialized form data
      success: function (response) {
        // Construct the confirmation box HTML for success
        let confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                                <h6>${response.message}</h6>
                            </div>
                            <div class="confirm-footer">
                                <button class="get_back btn btn-secondary">Go Back</button>
                            </div>
                        </div>
                    </div>
                `;
        // Append the confirmation box to the body
        $("body").append(confirmBoxHtml);
        updatePackageCount();

        // Get the value of #price_length
let priceLength = $("#packageList .skill-item").length;
let newPercent;

// Determine newPercent based on the value of priceLength
if (priceLength === 0) {
    newPercent = 0;
} else if (priceLength === 1) {
    newPercent = 25;
} else if (priceLength === 2) {
    newPercent = 50;
} else if (priceLength === 3) {
    newPercent = 75;
} else {
    newPercent = 100;
}

// Get the current percentage displayed
let currentPercent = parseInt($('#price_percent .overlay').text().replace('%', ''));

// Update the class and overlay text only if the new percentage is different
if (newPercent !== currentPercent) {
    $('#price_percent').removeClass('progress-' + currentPercent).addClass('progress-' + newPercent);
    $('#price_percent .overlay').text(newPercent + '%');
}

      },
      error: function (xhr, status, error) {
        // Construct the confirmation box HTML for error
        let errorMessage = xhr.responseJSON
          ? xhr.responseJSON.message
          : "An error occurred";
        let confirmBoxHtml = `
                <div class="confirm-box" style="z-index: 10;">
                    <div class="confirm-backdrop"></div>
                    <div class="confirm-content">
                        <div class="confirm-body">
                            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                            <h6>${errorMessage}</h6>
                        </div>
                        <div class="confirm-footer">
                            <button class="get_back btn btn-secondary">Go Back</button>
                        </div>
                    </div>
                </div>
            `;
        // Append the confirmation box to the body
        $("body").append(confirmBoxHtml);
        console.log("Form submission failed", xhr, status, error);
      },
    });
  }

  function updatePackageCount() {
    let packageCount = $("#packageList .skill-item").length;
    $("#package-count").text(packageCount);
  }

  $("#btn-add-pricing").on("click", function () {
    var packageName = $("#packageName").val();
    var packageAmount = $("#packageAmount").val();
    var packageType = $('input[name="packageType"]:checked').val();
    if (packageName && packageAmount) {
      var pt = `for ${packageType} - RS ${packageAmount}`;
      var packageText = decodeURIComponent(pt);
      var newPackage = "";
      newPackage += ' <div class="col-lg-4 col-md-6 skill-item">';
      newPackage +=
        ' <input type="text" class="form-control" value="' +
        packageName +
        " " +
        packageText +
        '">';
      newPackage +=
        ' <div class="remove"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" alt=""></div>';
      newPackage += " </div>";

      $("#packageList").prepend(newPackage);
      $("#packageName").val("");
      $("#packageAmount").val("");

      var values = [];
      $("#packageList .skill-item input[type='text']").each(function () {
        values.push($(this).val());
      });
      var package = values.join(";");
      $("#package_hidden").val(package);

      let cityValue = $("#locationInput").val();
      if (
        cityValue === "select" ||
        cityValue === "Select" ||
        cityValue === "" ||
        cityValue == null
      ) {
        $("#city_error").show();
      } else {
        $("#city_error").hide();
        updatePricingProgressBar();
      }
    }
  });

  $("#packageList").on("click", ".remove", function () {
    $(this).closest(".skill-item").remove();
  });

  $("#btn-save-coach-packages").click(function (e) {
    e.preventDefault();
    const isChecked = $("#free-class-checkbox").is(":checked");
    let trial_class = isChecked ? "1" : "0";
    var values = [];
    $("#packageList .skill-item input[type='text']").each(function () {
      values.push($(this).val());
    });
    var package = values.join(", ");
    $("#package_hidden").val(package);
    $("#trial_hidden").val(trial_class);

    let cityValue = $("#locationInput").val();
    if (
      cityValue == "select" ||
      cityValue == "Select" ||
      cityValue == "" ||
      cityValue == null
    ) {
      $("#city_error").show();
    } else {
      submitPackageForm();
      updatePackageCount();
    }
  });
  // update coach pricing end

  $(".friend_input").change(function () {
    var selectedOptions = [];
    $(".friend_input:checked").each(function () {
      selectedOptions.push($(this).val());
    });
    $("#friendly").val(selectedOptions.join(","));
  });

  $("#FileInput").change(function () {
    var fileInput = $("#FileInput")[0];
    var fileNameDisplay = $("#fileNameDisplay");
    var fileName = $("#fileName");

    if (fileInput.files.length > 0) {
      fileName.text(fileInput.files[0].name);
      fileNameDisplay.show();
    } else {
      fileNameDisplay.hide();
    }
  });

  $(".reply-btn").on("click", function () {
    $(".replies-section").toggle();
  });

  $("#verify-email-button").on("click", function () {
    let name = $("#top-left-card-name").text().trim();
    let email = $("#email-display").text().trim();

    $.ajax({
      url: "/send-verification-email",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        name: name,
        email: email,
      },
      success: function (response) {
        if (response.status == 0) {
          let confirmBoxHtml = `
                      <div class="confirm-box" style="z-index: 10;">
                          <div class="confirm-backdrop"></div>
                          <div class="confirm-content">
                              <div class="confirm-body">
                                  <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                                  <h6>${response.message}</h6>
                              </div>
                              <div class="confirm-footer">
                                  <button class="get_back btn btn-secondary">Go Back</button>
                              </div>
                          </div>
                      </div>
                  `;
          // Append the confirmation box to the body
          $("body").append(confirmBoxHtml);
        } else {
          let confirmBoxHtml = `
          <div class="confirm-box" style="z-index: 10;">
              <div class="confirm-backdrop"></div>
              <div class="confirm-content">
                  <div class="confirm-body">
                      <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                      <h6>${response.message}</h6>
                  </div>
                  <div class="confirm-footer">
                      <button class="get_back btn btn-secondary">Go Back</button>
                  </div>
              </div>
          </div>
      `;
          // Append the confirmation box to the body
          $("body").append(confirmBoxHtml);
        }
      },
      error: function (xhr, status, error) {
        console.log("An error occurred. Please try again.");
        // Handle error actions here
      },
    });
  });

  $(".notification_cross").click(function () {
    $(this).closest(".notifications_box").remove();
  });

  $("#logout_profile").click(function () {
    sessionStorage.clear();
    window.location.href = "/profile/logout";
  });

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
  initializeSlider("#scroll-left1", "#scroll-right1", ".plan_map");

  $(".day-input").on("change", function () {
    let dayBox = $(this).closest(".day-box");
    let openCloseWrapper = dayBox.find(".open-close-wrapper");
    const checkboxId = $(this).attr("id");
    const label = $('label[for="' + checkboxId + '"]');

    if ($(this).is(":checked")) {
      label.text("Open");
      openCloseWrapper.show();

      // Initialize with the first "Open at" and "Close at" row
      openCloseWrapper.html(`
            <div class="row open-close-row">
                <div class="col-5">
                    <select class="form-select open-time">
                        <option value="">Open At</option>
                        ${generateTimeOptions()}
                    </select>
                </div>
                <div class="col-5">
                    <select class="form-select close-time">
                        <option value="">Close At</option>
                        ${generateTimeOptions()}
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger remove-hours">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="add-hours">
                        <i class="fa-solid fa-plus"></i> Add Hours
                    </div>
                </div>
            </div>
        `);
    } else {
      label.text("Closed");
      openCloseWrapper.hide().empty();
    }
  });

  // Handle the click event for the "Add Hours" button
  $(document).on("click", ".add-hours", function () {
    let openCloseWrapper = $(this).closest(".open-close-wrapper");
    let rowsCount = openCloseWrapper.find(".open-close-row").length;

    if (rowsCount < 3) {
      let newHourRow = `
            <div class="row open-close-row">
                <div class="col-5">
                    <select class="form-select open-time">
                        <option value="">Open At</option>
                        ${generateTimeOptions()}
                    </select>
                </div>
                <div class="col-5">
                    <select class="form-select close-time">
                        <option value="">Close At</option>
                        ${generateTimeOptions()}
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger remove-hours">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        `;
      $(newHourRow).insertBefore($(this).closest(".row"));
    }
  });

  // Generate time options for dropdowns
  function generateTimeOptions() {
    return Array.from({ length: 24 }, (_, i) => i)
      .map((hour) => {
        const hourFormatted = hour < 10 ? "0" + hour : hour;
        const period = hour < 12 ? "AM" : "PM";
        const displayHour = hour % 12 === 0 ? 12 : hour % 12;
        return `
            <option value="${hourFormatted}:00">${displayHour}:00 ${period}</option>
            <option value="${hourFormatted}:30">${displayHour}:30 ${period}</option>
        `;
      })
      .join("");
  }

  // Handle changes to the "Open At" time to update "Close At" options
  $(document).on("change", ".open-time", function () {
    let openCloseRow = $(this).closest(".open-close-row");
    let openTime = $(this).val();
    let closeTimeSelect = openCloseRow.find(".close-time");

    let optionsHtml = generateTimeOptions();
    if (openTime) {
      // Remove the selected open time from the options
      optionsHtml = optionsHtml.replace(
        new RegExp(`<option value="${openTime}">.*?</option>`, "g"),
        ""
      );
    }

    // closeTimeSelect.html(`<option value="">Close At</option>${optionsHtml}`);
  });

  // Handle the click event for the "Remove Hours" button
  $(document).on("click", ".remove-hours", function () {
    let openCloseWrapper = $(this).closest(".open-close-wrapper");
    $(this).closest(".row.open-close-row").remove();

    // Show the "Add Hours" button only if there's less than 2 rows
    if (openCloseWrapper.find(".open-close-row").length < 2) {
      openCloseWrapper.find(".add-hours").show();
    }
  });

  $(".day-input").each(function () {
    let dayBox = $(this).closest(".day-box");
    let openCloseWrapper = dayBox.find(".open-close-wrapper");
    let label = $(this).parent().find("label"); // Updated selector

    if ($(this).is(":checked")) {
      openCloseWrapper.show();
    } else if (!$(this).is(":checked")) {
      openCloseWrapper.hide();
    }
  });

  function formatTime(time) {
    if (!time) return "";
    const [hour, minute] = time.split(":");
    const hourInt = parseInt(hour, 10);

    // Determine if it's AM or PM
    const period = hourInt >= 12 ? "PM" : "AM";

    // Adjust hour to 12-hour format (e.g., 13:00 -> 1:00 PM)
    const displayHour = hourInt % 12 === 0 ? 12 : hourInt % 12;
    const formattedMinute = minute || "00";

    return `${displayHour}:${formattedMinute} ${period}`;
  }

  // Function to get the schedule data
  function getScheduleData() {
    const schedule = [];
    let isValid = true;
    let errorMessage = "";

    $(".day-box").each(function () {
      const day = $(this).find(".day-name").text().trim();
      const isOpen = $(this).find(".day-input").is(":checked");
      const hours = [];
      const existingTimes = [];

      if (isOpen) {
        $(this)
          .find(".open-close-wrapper .open-close-row")
          .each(function () {
            const openTime = $(this).find("select").eq(0).val();
            const closeTime = $(this).find("select").eq(1).val();

            if (!openTime || !closeTime) {
              isValid = false;
              errorMessage = "Please enter both open and close time.";
              return false;
            } else if (openTime == closeTime) {
              isValid = false;
              errorMessage = "Open and Close time cannot be the same.";
              return false;
            }

            const formattedOpenTime = formatTime(openTime);
            const formattedCloseTime = formatTime(closeTime);

            if (
              existingTimes.some(
                (time) =>
                  time.open === formattedOpenTime ||
                  time.close === formattedCloseTime
              )
            ) {
              isValid = false;
              errorMessage = `The time ${formattedOpenTime} or ${formattedCloseTime} already exists for ${day}.`;
              return false;
            }

            existingTimes.push({
              open: formattedOpenTime,
              close: formattedCloseTime,
            });

            hours.push({
              open: formattedOpenTime,
              close: formattedCloseTime,
            });
          });
      }

      schedule.push({
        day: day,
        status: isOpen ? "open" : "closed",
        hours: hours,
      });
    });

    return { isValid, errorMessage, schedule };
  }

  // Attach click event to Save & Update button
  $(document).on("click", ".days_btn", function () {
    let { isValid, errorMessage, schedule } = getScheduleData();

    if (!isValid) {
      let confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop"></div>
          <div class="confirm-content">
              <div class="confirm-body">
                  <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                  <h6>${errorMessage}</h6>
              </div>
              <div class="confirm-footer">
                  <button class="get_back btn btn-secondary">Go Back</button>
              </div>
          </div>
      </div>
  `;
      // Append the confirmation box to the body
      $("body").append(confirmBoxHtml);
      return;
    }
    let formData = {
      completion_percentage: JSON.stringify(schedule),
      loc_id: $("#loc_id_input").val(),
      name: $("#hidden_name_input").val(),
      _token: $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
      url: $("#days_update").attr("action"),
      type: "POST",
      data: formData,
      success: function (response) {
        // Construct the confirmation box HTML for success
        let confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                                <h6>${response.message}</h6>
                            </div>
                            <div class="confirm-footer">
                                <button class="get_back btn btn-secondary">Go Back</button>
                            </div>
                        </div>
                    </div>
                `;
        // Append the confirmation box to the body
        $("body").append(confirmBoxHtml);
      },
      error: function (xhr, status, error) {
        // Construct the confirmation box HTML for error
        let errorMessage = xhr.responseJSON
          ? xhr.responseJSON.message
          : "An error occurred";
        let confirmBoxHtml = `
                <div class="confirm-box" style="z-index: 10;">
                    <div class="confirm-backdrop"></div>
                    <div class="confirm-content">
                        <div class="confirm-body">
                            <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                            <h6>${errorMessage}</h6>
                        </div>
                        <div class="confirm-footer">
                            <button class="get_back btn btn-secondary">Go Back</button>
                        </div>
                    </div>
                </div>
            `;
        // Append the confirmation box to the body
        $("body").append(confirmBoxHtml);
        console.log("Form submission failed", xhr, status, error);
      },
    });
  });

  $("#pin_btn").click(function () {
    $("#pin-input1").val("");
    $("#pin-input2").val("");
    $("#pin-input3").val("");
    $("#pin-input4").val("");

    let confirmBoxHtml = `
    <div class="confirm-box" id="pin_box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <h6>Please Set your Pin</h6>
                <p>If you face any problems logging in with the OTP, you can use the PIN you set up to log in instead.</p>
                <p style="color:red" class="pin_error"></p>
            </div>
          <div class="col-lg-4 col-md-6 mx-auto" style="text-align:center;">
             <div class="d-flex justify-content-center pin-inputs">
               <input type="number" class="form-control pin-input mx-1" id="pin-input1" maxlength="1">
               <input type="number" class="form-control pin-input mx-1" id="pin-input2" maxlength="1">
               <input type="number" class="form-control pin-input mx-1" id="pin-input3" maxlength="1">
               <input type="number" class="form-control pin-input mx-1" id="pin-input4" maxlength="1">
             </div>
          </div>
  
            <div class="confirm-footer">
                <button class="btn btn-secondary set_to_update" id="set_pin">Set Pin</button>
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
  `;
    $("body").append(confirmBoxHtml);

    let pinValue = $("#pin_value").val();
    if (pinValue.length === 4) {
      $("#pin-input1").val(pinValue[0]);
      $("#pin-input2").val(pinValue[1]);
      $("#pin-input3").val(pinValue[2]);
      $("#pin-input4").val(pinValue[3]);
      $(".set_to_update").text("Update Pin");
    }
  });

  // Use event delegation for dynamically added inputs
  $(document)
    .on("input", ".pin-input", function () {
      let currentIndex = $(".pin-input").index(this);
      let currentValue = $(this).val();

      if (
        currentValue.length === 1 &&
        currentIndex < $(".pin-input").length - 1
      ) {
        $(".pin-input")
          .eq(currentIndex + 1)
          .focus();
      }
    })
    .on("keydown", ".pin-input", function (e) {
      let currentIndex = $(".pin-input").index(this);

      if (e.key === "Backspace" && $(this).val() === "" && currentIndex > 0) {
        $(".pin-input")
          .eq(currentIndex - 1)
          .focus();
      }
    });

  $(document).on("click", "#set_pin", function () {
    let pinValues = [];

    $(".pin-input").each(function () {
      pinValues.push($(this).val().trim());
    });

    let isValid = pinValues.every((value) => value !== "");

    if (!isValid) {
      $(".pin_error").text("Please fill all four PIN fields.");
    } else {
      $.ajax({
        url: "/api/setpin",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          pin: pinValues.join(""),
        },
        success: function (response) {
          $(".pin_error").text("");
          $(".pin-input").val("");
          $("#pin_box").remove();

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
          $(".pin_error").text("");
          $(".pin-input").val("");
          console.log("Failed to set the PIN. Please try again.", error);
        },
      });
    }
  });

  //order js

  $(".plan_btn").on("click", function () {
    // Get the plan ID from the data attribute
    var orderId = $(".order_id").val();

    // Perform the AJAX request
    $.ajax({
      url: "/api/getOrderDetails", // Replace with your endpoint URL
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        orderId: orderId,
      },
      success: function (response) {
        $(".plan_owner").html(response.data.notes.academy_name);
        $(".plan_amount").html(response.data.amount_paid / 100 + "Rs");
        $(".plan_email").html(response.data.notes.email);
      },
      error: function (xhr, status, error) {
        // Handle any errors
        console.error("AJAX request failed:", status, error);
      },
    });
  });

    let memberships = []; // Array to store all membership plans

    // Get the existing memberships from the Blade template (if available)
    const existingMemberships = $("#membership_hide").val(); // Pass existing memberships from Blade to JS
    memberships = existingMemberships ? JSON.parse(existingMemberships) : []; // Parse JSON string into an array if it's not empty

    // Function to clear all inputs
    function clearInputs() {
        $('#planName, #planDuration, #planOldAmount, #planCurrentAmount, #planTax, #planOffer').val('');
    }

    // Function to construct the display string for the membership plan
    function constructDisplayString(plan) {
        let displayString = '';
        if (plan["Plan"]) displayString += `${plan["Plan"]}, `;
        if (plan["Duration"]) displayString += `${plan["Duration"]}, `;
        if (plan["Price"]) displayString += `₹${plan["Price"]}, `;
        if (plan["Original Price"]) displayString += `₹${plan["Original Price"]}, `;
        if (plan["Taxes & Fees"]) displayString += `${plan["Taxes & Fees"]}, `;
        if (plan["Offers Available"]) displayString += `${plan["Offers Available"]}`;
        
        // Remove the trailing comma and space if present
        return displayString.trim().replace(/,\s*$/, '');
    }

    // Function to update the membership list in the DOM
    function updateMembershipList() {
        const $membershipList = $('#membership-list');
        $membershipList.empty(); // Clear the list

        memberships.forEach((plan, index) => {
            const displayString = constructDisplayString(plan);
            const inputHtml = `
                <div class="col-lg-4 col-md-6 skill-item mt-2" id="membership-${index}">
                    <div class="input-container d-flex align-items-center">
                        <input type="text" class="form-control" value="${displayString}">
                        <div class="remove" data-id="${index}">
                            <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" loading="lazy" alt="Remove">
                        </div>
                    </div>
                </div>
            `;
            $membershipList.append(inputHtml); // Append new item to the list
        });
    }

    function updateMembershipFromInputs() {
      $('#membership-list .skill-item').each(function (index) {
          const planInput = $(this).find('input').val();
          
          // Parse the updated string and map back to the `memberships` array
          const parts = planInput.split(',').map(part => part.trim());
          memberships[index] = {
              "Plan": parts[0] || "",
              "Duration": parts[1] || "",
              "Price": parts[2] ? parts[2].replace('₹', ''): "",
              "Original Price": parts[3] ? parts[3].replace('₹', ''): "",
              "Taxes & Fees": parts[4] == "No Extra Charge" ? "No Extra Charge" : parts[4].replace('₹', ''),
              "Offers Available": parts[5] || "",
          };
      });
  }

  $(document).on('input', '#membership-list .skill-item input', function () {
    updateMembershipFromInputs();
});

    // Event listener for the Add button
    $('#btn-add-membership').on('click', function () {
        // Collect input values
        const planName = $('#planName').val().trim();
        const planDuration = $('#planDuration').val().trim();
        const planOldAmount = $('#planOldAmount').val().trim() || 'N/A';
        const planCurrentAmount = $('#planCurrentAmount').val().trim();
        const planTax = $('#planTax').val().trim() || "No Extra Charge";
        const planOffer = $('#planOffer').val().trim();

        // Validate required fields
        if (!planName || !planDuration || !planCurrentAmount) {
          let confirmBoxHtml = `
            <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt="Error Icon"></figure>
                        <h6>Please Enter Plan Name, Duration, and Current Amount.</h6>
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

        // Build the plan object dynamically, adding only non-empty values
        const planObject = {};
        if (planName) planObject["Plan"] = planName;
        if (planDuration) planObject["Duration"] = planDuration;
        if (planCurrentAmount) planObject["Price"] = planCurrentAmount;
        if (planOldAmount) planObject["Original Price"] = planOldAmount;
        if (planTax) planObject["Taxes & Fees"] = planTax;
        if (planOffer) planObject["Offers Available"] = planOffer;

        // Add the plan to the memberships array
        memberships.push(planObject);

        // Update the membership list in the DOM (append the new item)
        updateMembershipList();

        // Clear input fields
        clearInputs();
    });

    // Event listener for the Remove button
    $(document).on('click', '.remove', function () {
        const index = $(this).data('id'); // Get the index of the plan to remove
        memberships.splice(index, 1); // Remove the plan from the array
        updateMembershipList(); // Update the DOM
    });




    $('#btn-save-memberships').on('click', function () {
        const membershipsString = JSON.stringify(memberships); // Convert to JSON string
        $("#hidden_membership").val(membershipsString); // Set the hidden input value
        let fitnessOptions = [];

        $('input[name="fitness[]"]:checked').each(function () {
            fitnessOptions.push($(this).val());
        });
      
        let premiumOptions = [];
        $('input[name="premium[]"]:checked').each(function () {
            premiumOptions.push($(this).val());
        });
      
        let equipmentOptions = [];
        $('input[name="equipments[]"]:checked').each(function () {
            equipmentOptions.push($(this).val());
        });
      
        let fitnessString = fitnessOptions.join(',');
        let premiumString = premiumOptions.join(',');
        let equipmentString = equipmentOptions.join(',');
      
        $("#fitness").val(fitnessString);
        $("#premium").val(premiumString);
        $("#equipments").val(equipmentString);
      
      
        const fitnessCheckboxes = $('input[name="fitness[]"]');
        const premiumCheckboxes = $('input[name="premium[]"]');
        const equipmentCheckboxes = $('input[name="equipments[]"]');
        fitnessCheckboxes.prop('disabled', true);
        premiumCheckboxes.prop('disabled', true);
        equipmentCheckboxes.prop('disabled', true);

        let gymAreaData = {};
        let errorMessage = '';

        const areas = [
            { name: 'Workout Room', slug: 'workout-room' },
            { name: 'Lowan Functional Training Area', slug: 'lowan-functional-training-area' },
            { name: 'Personal Training Room', slug: 'personal-training-room' },
            { name: 'Locker Changing Room', slug: 'locker-changing-room' },
            { name: 'Restrooms Shower Area', slug: 'restrooms-shower-area' },
            { name: 'Utility Storage Room', slug: 'utility-storage-room' }
        ];

        // Iterate through areas and collect data
        areas.forEach(area => {
            let checkbox = $(`#${area.slug}-checkbox`);
            let input = $(`#${area.slug}-size`);

            if (checkbox.prop('checked')) {
                let size = input.val();
                if (!size) {
                    errorMessage = `Please fill the ${area.name} area.\n`;
                } else {
                    gymAreaData[area.name] = size;
                }
            }
        });


        // Show error if there are any missing fields
        if (errorMessage) {
            let confirmBoxHtml = `
            <div class="confirm-box" style="z-index: 10;">
                <div class="confirm-backdrop"></div>
                <div class="confirm-content">
                    <div class="confirm-body">
                        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt="Error Icon"></figure>
                        <h6>${errorMessage}</h6>
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



        let jsonData = JSON.stringify(gymAreaData);

        $("#hidden_gym").val(jsonData);

        
        $('#trial-list .skill-item').each(function () {
          const trialText = $(this).find('input').val().split(',');
          const trialClass = trialText[0]?.trim(); // Trim to remove extra spaces
          const trialDesc = trialText[1]?.trim(); // Handle undefined safely and trim
      
          // Add to trialData only if both trialClass and trialDesc are valid
          if (trialClass && trialDesc) {
              trialData[trialClass] = trialDesc;
          }
      });
       
       
        const trialJson = JSON.stringify(trialData, null, 4);
        $("#hidden_trial").val(trialJson);
      
        let formData = $("#membership_update").serialize(); 
      
        // Re-enable checkboxes after serialization
        fitnessCheckboxes.prop('disabled', false);
        premiumCheckboxes.prop('disabled', false);
        equipmentCheckboxes.prop('disabled', false);



        $.ajax({
            url: "/academy/dashboard/update-profile",
            type: "POST", // Form method
            data: formData, // Serialized form data
            success: function (response) {
                let confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt="Success Icon"></figure>
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
                let errorMessage = xhr.responseJSON
                    ? xhr.responseJSON.message
                    : "An error occurred";
                let confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt="Error Icon"></figure>
                                <h6>${errorMessage}</h6>
                            </div>
                            <div class="confirm-footer">
                                <button class="get_back btn btn-secondary">Go Back</button>
                            </div>
                        </div>
                    </div>
                `;
                $("body").append(confirmBoxHtml);
                console.log("Form submission failed", xhr, status, error);
            },
        });

        updateMembershipFromInputs();
    });








$('#btn-add-trial').on('click', function () {
    const trialName = $('#trialName').val().trim();
    const trialDescription = $('#trialDescription').val().trim();

    if (trialName && trialDescription) {
        index++; 

        const displayString = `${trialName}, ${trialDescription}`;

        const trialHtml = `
            <div class="col-lg-4 col-md-6 skill-item mt-2" id="trial-${index}">
                <div class="input-container d-flex align-items-center">
                    <input type="text" class="form-control" value="${displayString}">
                    <div class="remove remove-trial" data-id="${index}">
                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" loading="lazy" alt="Remove">
                    </div>
                </div>
            </div>
        `;
        
        // Append the HTML to the trial list
        $('#trial-list').append(trialHtml);

        existingTrialData = $("#hide_trial").val();
        
        if (existingTrialData) {
            // Parse existing trial data if available
            existingTrialData = JSON.parse(existingTrialData);
        
            trialData = {...existingTrialData, ...trialData}; // This combines the old and new data
        }
        $('#trialName').val('');
        $('#trialDescription').val('');
    } else {
      let confirmBoxHtml = `
      <div class="confirm-box" style="z-index: 10;">
          <div class="confirm-backdrop"></div>
          <div class="confirm-content">
              <div class="confirm-body">
                  <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt="Success Icon"></figure>
                  <h6>Please fill in both the fields.</h6>
              </div>
              <div class="confirm-footer">
                  <button class="get_back btn btn-secondary">Go Back</button>
              </div>
          </div>
      </div>
  `;
// Append the confirmation box to the body
$("body").append(confirmBoxHtml);
    }
});

$(document).on('click', '.remove-trial', function () {
  const id = $(this).data('id');
  $(`#trial-${id}`).remove(); // Remove the trial item from the DOM

  trialData = {};

  $('#trial-list .skill-item').each(function () {
    const trialText = $(this).find('input').val().split(',');
    const trialClass = trialText[0]?.trim(); // Trim to remove extra spaces
    const trialDesc = trialText[1]?.trim(); // Handle undefined safely and trim

    // Add to trialData only if both trialClass and trialDesc are valid
    if (trialClass && trialDesc) {
        trialData[trialClass] = trialDesc;
    }
});


  // Update the hidden input field with the updated JSON string
  const trialJson = JSON.stringify(trialData, null, 4);
  $("#hidden_trial").val(trialJson);
});


});


function makePayment(planId) {
  $.ajax({
    url: "/create-order",
    method: "POST",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
      planId: planId,
    },
    success: function (response) {
      var options = {
        key: response.razorpay_key,
        currency: "INR",
        name: "BookMyPlayer",
        description: "Transaction",
        order_id: response.order_id,
        handler: function (response) {
          $.ajax({
            url: "/verify-payment",
            method: "POST",
            data: {
              _token: $('meta[name="csrf-token"]').attr("content"),
              razorpay_order_id: response.razorpay_order_id,
              razorpay_payment_id: response.razorpay_payment_id,
              razorpay_signature: response.razorpay_signature,
              planId: planId,
            },
            success: function (result) {
            },
          });
        },
      };
      var rzp = new Razorpay(options);
      rzp.open();
    },
  });
}

function verifyMsg() {
  let confirmBoxHtml = `
          <div class="confirm-box" style="z-index: 10;">
              <div class="confirm-backdrop"></div>
              <div class="confirm-content">
                  <div class="confirm-body">
                      <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt="Success Icon"></figure>
                      <h6>Please verify your Academy to select this Plan</h6>
                  </div>
                  <div class="confirm-footer">
                      <button class="get_back btn btn-secondary">Go Back</button>
                  </div>
              </div>
          </div>
      `;
  // Append the confirmation box to the body
  $("body").append(confirmBoxHtml);
}
