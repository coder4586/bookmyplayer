$(document).ready(function () {
  var url = window.location.href;
  let coachId;
  let leadIdNumber;
  let flag = true;

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
  $("#tournament_box").click(() =>
    handlePageSwitch("#tournament_box", "#tournament_page")
  );
  $("#view_box").click(() =>
    handlePageSwitch("#view_box", "#view_page")
  );
  $("#leads_box").click(() => handlePageSwitch("#leads_box", "#leads_page"));
  $("#boost_box").click(() => handlePageSwitch("#boost_box", "#boost_page"));
  $("#performance_box").click(() =>
    handlePageSwitch("#performance_box", "#performance_page")
  );
  $("#notification_box").click(() =>
    handlePageSwitch("#notification_box", "#notification_page")
  );
  $("#upgrade_box").click(() => handlePageSwitch("#boost_box", "#boost_page"));

  // Check session storage for the last active box
  const lastActiveBox = sessionStorage.getItem("activeBox") || "#leads_box";
  const lastActivePage = sessionStorage.getItem("activePage") || "#leads_page";
  handlePageSwitch(lastActiveBox, lastActivePage);

  function handlePageSwitch(activeBox, activePage) {
    // Store the active box and page in session storage
    sessionStorage.setItem("activeBox", activeBox);
    sessionStorage.setItem("activePage", activePage);

    const pages = [
      "#dashboard_page",
      "#leads_page",
      "#boost_page",
      "#notification_page",
      "#performance_page",
      "#profile_page",
      "#upgrade_page",
      "#tournament_page",
      "#view_page"
    ];
    const boxes = [
      "#dashboard_box",
      "#leads_box",
      "#boost_box",
      "#notification_box",
      "#performance_box",
      "#profile_box",
      "#upgrade_box",
      "#tournament_box",
      "#view_box"
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
      $(".progress-txt").css("color", "#fff");
      $(".progress-bar span").css("background", "#fff");
      $(".progress-bar").css("background", "#FFFFFF80");
    } else {
      $(".progress-txt").css("color", "#FB5D52");
      $(".progress-bar span").css("background", "#fb5d52");
      $(".progress-bar").css("background", "#f5bbb8");
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
            coachId = response.d.id;
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
                        <p style="white-space:nowrap;margin-top:0;">
                          <span style="font-weight:700">Lead Date:</span> ${formattedDate} @ ${formattedTime}
                        </p>
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
                            ${lead.locality_name ? lead.locality_name : "India"}
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
          type_id: 1,
        },
        success: async function (response) {
          if (response.data.length > 0) {
            for (let i = response.data.length - 1; i >= 0; i--) {
              let plan = response.data[i];

              // Determine the button HTML based on the plan id
              let buttonHtml;
              if (plan.id === 5) {
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
                    plan.id === 6
                      ? "start-plan"
                      : plan.id === 7
                      ? "premium-plan"
                      : plan.id === 8
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

  //======dashboard tab change js End==========//

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
          console.log(response);
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

  //==========add training and  location js Start=============//

  $("#location-container").on("click", ".remove", function () {
    $(this).closest(".location-item").remove();
  });

  $(".location-save-btn").click(function (e) {
    e.preventDefault();

    var selectedLocations = [];
    $("input[name='checkbox']:checked").each(function () {
      selectedLocations.push($(this).val());
    });

    var inputLocation = $("#new-location").val().trim();
    var locationString = selectedLocations.join(",");
    var finalString;

    if (inputLocation && locationString) {
      finalString = locationString + "||" + inputLocation;
    } else if (inputLocation) {
      finalString = "||" + inputLocation;
    } else if (locationString) {
      finalString = locationString + "||";
    }

    $("#location_place").val(finalString);

    let cityValue = $("#locationInput").val();
    if (
      cityValue == "select" ||
      cityValue == "Select" ||
      cityValue == "" ||
      cityValue == null
    ) {
      $("#city_error").show();
    } else {
      let formData = $("#training_update").serialize(); // Serialize form data

      $.ajax({
        url: $("#training_update").attr("action"), // Form action URL
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
  });

  //==========add location js Ends=============//

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

  function updatePricingProgressBar() {
    let pricingCount = $("#packageList .skill-item").length; // Count the number of items
    let progressPercent;

    // Map the number of items to specific percentages
    switch (pricingCount) {
      case 0:
        progressPercent = 0;
        break;
      case 1:
        progressPercent = 25;
        break;
      case 2:
        progressPercent = 50;
        break;
      case 3:
        progressPercent = 75;
        break;
      case 4:
      default:
        progressPercent = 100;
        break;
    }

    let radialProgressBar = $(".radialProgressBar.progress-package");
    // Add the new progress class
    radialProgressBar.removeClass(`progress-25`);
    radialProgressBar.removeClass(`progress-50`);
    radialProgressBar.removeClass(`progress-75`);
    radialProgressBar.removeClass(`progress-100`);
    radialProgressBar.addClass(`progress-${progressPercent}`);

    // Update the overlay text
    radialProgressBar.find(".overlay").text(`${progressPercent}%`);
  }

  $("#btn-add-pricing").on("click", function () {
    var packageName = $("#packageName").val();
    var packageAmount = $("#packageAmount").val();
    var packageType = $('input[name="packageType"]:checked').val();
    if (packageName && packageAmount) {
      var pt = `${packageAmount},${packageName}-${packageType} `;
      var packageText = decodeURIComponent(pt);
      var newPackage = `
          <div class="col-lg-4 col-md-6 skill-item">
              <input type="text" class="form-control" value="${packageText}">
              <div class="remove"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" alt=""></div>
          </div>
      `;

      $("#packageList").prepend(newPackage);
      $("#packageName").val("");
      $("#packageAmount").val("");
    }
    const isChecked = $("#free-class-checkbox").is(":checked");
    let trial_class = isChecked ? "1" : "0";
    var values = [];
    $("#packageList .skill-item input[type='text']").each(function () {
      values.push($(this).val());
    });
    var package = values.join(";");
    $("#package_hidden").val(package);
    $("#trial_hidden").val(trial_class);

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
      submitPackageForm();
      updatePricingProgressBar();
    }
  });

  $("#packageList").on("click", ".remove", function () {
    $(this).closest(".skill-item").remove();
    updatePricingProgressBar();
  });

  $("#btn-save-coach-packages").click(function () {
    const isChecked = $("#free-class-checkbox").is(":checked");
    let trial_class = isChecked ? "1" : "0";
    var values = [];
    $("#packageList .skill-item input[type='text']").each(function () {
      values.push($(this).val());
    });
    var package = values.join(";");
    $("#package_hidden").val(package);
    $("#trial_hidden").val(trial_class);

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
      submitPackageForm();
      updatePricingProgressBar();
    }
  });
  // update coach pricing end

  // update coach skills start

  function selectFirstSkill() {
    let firstSkill = $("#skill-name li:first-child");
    if (firstSkill.length) {
      firstSkill.trigger("click");
    }
  }

  $("#new-skill").on("input", async function () {
    let inputVal = $(this).val().toLowerCase();
    $("#skill-name").empty();
    $(".skill-list").css("display", "block");

    try {
      let skills = await getSkills();
      let filteredSkill = skills.filter((skill) =>
        skill.skill.toLowerCase().includes(inputVal)
      );

      if (filteredSkill.length === 0) {
        $("#skill-name").html(
          '<p style="padding-left:1rem;padding-top:1rem">No match found</p>'
        );
      } else {
        filteredSkill.forEach(function (skill) {
          $("#skill-name").append(
            '<li class="dropdown-item skill-item" value="' +
              skill.skill +
              '">' +
              skill.skill +
              "</li>"
          );
        });
      }
    } catch (error) {
      console.error("An error occurred:", error);
      $("#skill-name").html(
        '<p style="padding-left:1rem;padding-top:1rem">Error fetching skills</p>'
      );
    }
  });

  $("#skill-name").on("click", ".skill-item", function () {
    let skillValue = $(this).attr("value");
    skillValue = skillValue.toLowerCase();
    $("#new-skill").val(skillValue);
    $("#skill-name").empty();
    $(".skill-list").css("display", "none");
  });

  $("#new-skill").on("keydown", function (e) {
    if (e.key === "Enter" || e.key === "Tab") {
      selectFirstSkill();
    }
  });

  // Handle click outside
  $(document).click(function (event) {
    if (!$(event.target).closest("#skill-name, .skill-list").length) {
      selectFirstSkill();
      $(".skill-list").css("display", "none");
    }
  });

  $("#btn-add-skill").click(function () {
    var newSkill = $("#new-skill").val().trim();
    if (newSkill !== "") {
      var skillItem = "";
      skillItem += '<div class="col-lg-4 col-md-6 skill-item">';
      skillItem +=
        '<input type="text" class="form-control" value="' + newSkill + '">';
      skillItem +=
        '<div class="remove"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" alt=""></div>';
      skillItem += "</div>";
      $("#skills-container").prepend(skillItem);
      $("#new-skill").val("");
    }
  });

  $("#skills-container").on("click", ".remove", function () {
    $(this).closest(".skill-item").remove();
  });

  function updateProgress() {
    let skillCount = $("#skills-container .skill-item").length;
    let totalSkills = 10; // Example total, adjust as needed
    let progressPercent = Math.min(
      Math.round((skillCount / totalSkills) * 100),
      100
    ); // Calculate percentage
    let radialProgressBar = $(".radialProgressBar");

    // Update the progress bar class and overlay text
    radialProgressBar
      .removeClass(function (index, className) {
        return (className.match(/(^|\s)progress-\S+/g) || []).join(" ");
      })
      .addClass(`progress-${progressPercent}`);

    radialProgressBar.find(".overlay").text(`${progressPercent}%`);
  }

  $(".btn-save-coach-skills").click(function () {
    // Collect and format skill values
    var values = [];
    $("#skills-container .skill-item input[type='text']").each(function () {
      values.push($(this).val());
    });
    var skill = values.join(", ");
    $("#skill_hidden").val(skill);

    // Collect other form data
    var formData = $("#skill_update").serialize();

    // AJAX request
    $.ajax({
      url: $("#skill_update").attr("action"), // URL from form action attribute
      type: "POST", // HTTP method
      data: formData, // Form data
      success: function (response) {
        // Handle successful response

        // Construct and display success confirmation box
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
        updateProgress();
      },
      error: function (xhr, status, error) {
        // Handle error response
        let errorMessage = xhr.responseJSON
          ? xhr.responseJSON.message
          : "An error occurred";
        let confirmBoxHtml = `
                <div class="confirm-box" style="z-index: 10;">
                    <div class="confirm-backdrop"></div>
                    <div class="confirm-content">
                        <div class="confirm-body">
                            <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt=""></figure>
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
  });

  // update coach skills end

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
    const userName = whatsappIcon.data("name") || "-";
    const coachName = $("#coach_name").val();
    const userPhone = whatsappIcon.data("phone") || "";

    let whatsappMessage = `Hy ${userName}\n\nMy name is ${coachName}, and I am a verified coach from bookmyplayer.com. We can connect on a call to discuss your needs and how I can help you achieve your goals.\n\nLooking forward to speaking with you soon!\n\nBest regards,\n${coachName}\nCertified bookmyplayer Coach\n\nwww.bookmyplayer.com

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

  function updateLocationDropdown(locations, filter) {
    $("#location-name").empty(); // Clear previous options
    $(".location-list").css("display", "block");

    let filteredLocation = locations.filter((location) => 
      location.locality_name.toLowerCase().includes(filter.toLowerCase()) || 
      location.postcode.toString().includes(filter)
    );
    

    if (filteredLocation.length === 0) {
      $("#location-name").html(
        '<p style="padding-left:1rem;padding-top:1rem">No match found</p>'
      );
    } else {
      filteredLocation.forEach(function (location) {
        $("#location-name").append(
          '<li class="dropdown-item location-item" data-id="' +
            location.id +
            '">' +
            location.locality_name +
            "," +
            (location.city_id == 1
              ? " <span style='color: green;'>" + location.city + "</span>"
              : "") +
            " " +
            location.state +
            " (" +
            (location.city_id == 0
              ? "<span style='color: blue;'>city</span>"
              : "<span style='color: red;'>locality</span>") +
            ")" +
            "</li>"
        );
      });
    }
  }

  function selectFirstLocation() {
    let firstLocation = $("#location-name li:first-child");
    if (firstLocation.length) {
      firstLocation.trigger("click");
    }
  }

  $("#location-name").on("click", ".location-item", function () {
    let locationId = $(this).data("id");
    let localityName = $(this).text();
    $("#locationInput").val(localityName);
    $("#loc_id_input").val(locationId);
    $("#location-name").empty();
    $(".location-list").css("display", "none");
  });

  $(document).click(function (event) {
    if (!$(event.target).closest("#location-name, .location-list").length) {
      selectFirstLocation();
      $(".location-list").css("display", "none");
    }
  });

  $("#locationInput").on("keydown", function (e) {
    if (e.key === "Enter" || e.key === "Tab") {
      selectFirstLocation();
    }
  });

  // master functions
  function getMasterLocalities(term, type) {
    return new Promise((resolve, reject) => {
      let data = type === 1 ? { term: term } : { loc_id: term };
      $.ajax({
        url: "https://www.bookmyplayer.com/coach/get-location-master",
        type: "GET",
        async: true,
        data: data,
        success: function (response) {
          console.log(response.locations);
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

  function getSkills() {
    var sportId = $("#hiddenSportId").data("sport_id");
    return new Promise((resolve, reject) => {
      $.ajax({
        url: "https://www.bookmyplayer.com/coach/get-skills",
        type: "GET",
        async: true,
        data: { sport_id: sportId },
        success: function (response) {
          if (Array.isArray(response.skills)) {
            resolve(response.skills);
          } else {
            resolve([]);
          }
        },
        error: function (xhr, status, error) {
          console.error("An error occurred while fetching skills:", error);
          reject(error);
        },
      });
    });
  }

  //==============photo and video upload

  $("#img_submit").on("submit", function (event) {
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
        // Remove existing popup if any
        $("#image_box").remove();

        // Display the success message
        $("body").append(`
          <div id="image_box" class="confirm-box" style="z-index: 10;">
              <div class="confirm-backdrop-2"></div>
              <div class="confirm-content">
                  <div class="confirm-body">
                      <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
                      <h6>Images Uploaded</h6>
                  </div>
                  <div class="confirm-footer">
                      <button id="image_back" class=" btn btn-secondary">Go Back</button>
                  </div>
              </div>
          </div>
        `);

        $(document).on("click", "#image_back", function () {
          handleImageUpdate();
        });

        // Event handler for confirm-backdrop-2
        $(document).on("click", ".confirm-backdrop-2", function () {
          handleImageUpdate();
        });
      },
      error: function (error) {
        console.error("Form submission error:", error);
        // Handle error if needed
      },
    });
  });

  function handleImageUpdate() {
    const url = window.location.href;

    $.ajax({
      url: url,
      type: "GET",
      async: true,
      success: function (response) {
        const $imageContainer = $(".photos-container");
        $imageContainer.empty(); // Clear existing images

        $.each(response.photos, function (index, photoUrl) {
          const newCol = `
            <div class="col-lg-3 col-md-6">
                <div class="add-card">
                    <div class="make-profile">
                        <div class="form-check">
                            <input class="form-check-input profile-radio" type="radio" name="flexRadioDefault" id="flexRadio${index}" value="${photoUrl}">
                            <label class="form-check-label" for="flexRadio${index}">
                                Make Profile Image
                            </label>
                        </div>
                    </div>
                    <div class="delete">
                        <input type="checkbox" class="photos-checkbox" name="selected_images[]" value="${photoUrl}">
                    </div>
                    <figure><img src="${photoUrl}" alt=""></figure>
                </div>
            </div>
          `;
          $imageContainer.append(newCol);
        });

        $("#image_box").hide();
        const photoCount = response.photos.length;
        $(".count_photo").text(`${photoCount}`);
      },
      error: function (error) {
        console.error("AJAX request error:", error);
      },
    });
  }

  // File upload change event handler
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
                                        <label class="form-check-label">Make Profile Image</label>
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

$("#file-upload-2").change(function () {
  let files = this.files;

  if (files.length > 0) {
    uploadVideo(files, 0);
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
    const form = $("#delete_form");
    const url = form.attr("action"); // Get the action URL from the form

    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(), // Serialize the form data
      success: function (response) {
        const $imageContainer = $(".photos-container");
        $imageContainer.empty(); // Clear existing images

        let totalPhotos = response.photos.length ?? 0; 
        $.each(response.photos, function (index, photoUrl) {
          const newCol = `
                  <div class="col-lg-3 col-md-6">
                      <div class="add-card">
                          <div class="make-profile">
                              <div class="form-check">
                                  <input class="form-check-input profile-radio" type="radio" name="flexRadioDefault" id="flexRadio${index}" value="${photoUrl}">
                                  <label class="form-check-label" for="flexRadio${index}">
                                      Make Profile Image
                                  </label>
                              </div>
                          </div>
                          <div class="delete">
                              <input type="checkbox" class="photos-checkbox" name="selected_images[]" value="${photoUrl}">
                          </div>
                          <figure><img src="${photoUrl}" alt=""></figure>
                      </div>
                  </div>
              `;
          $imageContainer.append(newCol);
          $(".count_total_photo").text(totalPhotos)
        });
        $("#customConfirmBox3").hide();
        $(".delete_btn").hide();
        const photoCount = response.photos.length;
        $(".count_photo").text(`${photoCount}`);
      },
      error: function (xhr, status, error) {
        // Handle the error response
        console.error("Form submission error:", error);
        // Optionally, display an error message to the user
      },
    });
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

  $(document).on("change", ".photos-checkbox", function () {
    if ($(".photos-checkbox:checked").length > 0) {
      $(".delete_btn").show();
    } else {
      $(".delete_btn").hide();
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
        "image/webp",
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
                <div id="certificate_box" class="confirm-box" style="z-index: 10;">
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
                const url = window.location.href;

                $.ajax({
                  url: url,
                  type: "GET",
                  async: true,
                  success: function (response) {
                    console.log(response);
                    const $certificatesContainer = $("#certificateContainer");
                    $certificatesContainer.empty(); // Clear existing images

                    // Assuming response.d.certificates is a comma-separated string of certificates
                    const certificates = response.d.certificate.split(",");
                    console.log(certificates);
                    certificates.forEach(function (certificate) {
                      let extension = certificate
                        .split(".")
                        .pop()
                        .toLowerCase();
                      let certificateHtml = `
                              <div class="col-lg-3 col-md-6">
                                  <div class="add-card">
                                      <div class="delete">
                                          <input type="checkbox" class="certificate-checkbox" name="selected_certificates[]" value="${certificate}">
                                      </div>`;

                      if (["jpg", "jpeg", "png", "gif"].includes(extension)) {
                        certificateHtml += `<figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${certificate}" alt=""></figure>`;
                      } else if (extension === "pdf") {
                        certificateHtml += `
                                  <div class="pdf-container">
                                      <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/pdf_img.png" alt="PDF File"></figure>
                                      <a href="${certificate}" target="_blank" class="view-pdf-link">View PDF</a>
                                  </div>`;
                      } else if (extension === "doc" || extension === "docx") {
                        certificateHtml += `
                                  <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/logo.svg" alt="DOC File"></figure>
                                  <a href="${certificate}" target="_blank">View Document</a>`;
                      } else {
                        certificateHtml += `<p>Unknown file type</p>`;
                      }

                      certificateHtml += `
                                  </div>
                              </div>`;

                      $certificatesContainer.append(certificateHtml);
                    });

                    $("#certificate_box").hide();
                    // const photoCount = response.photos.length;
                    // $(".count_photo").text(`${photoCount}`);
                  },
                  error: function (error) {
                    console.error("AJAX request error:", error);
                  },
                });
              });
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

  $(document).on("change", ".certificate-checkbox", function () {
    if ($(".certificate-checkbox:checked").length > 0) {
      $(".delete_btn_3").show();
    } else {
      $(".delete_btn_3").hide();
    }
  });

  //==========certificate js end==========//

  //=========faq===========//

  $(".delete_btn4").on("click", function () {
    $("#customConfirmBox").show();
  });

  $("#confirmCancel").on("click", function () {
    $("#customConfirmBox").hide();
  });

  $("#confirmOk").on("click", function () {
    $("#delete_form4").submit();
  });

  function updateFaqIds() {
    var selectedFaqIds = $(".faq-checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get()
      .join(",");
    $("#faq_ids").val(selectedFaqIds);
  }

  $(".faq-checkbox").on("change", updateFaqIds);

  updateFaqIds();

  $(".faq-add").click(function () {
    $("#add_form").submit();
  });

  $(".faq-checkbox").on("change", function () {
    if ($(".faq-checkbox:checked").length > 0) {
      $(".delete_btn4").show();
    } else {
      $(".delete_btn4").hide();
    }
  });

  //=========faq ends===========//

  //=============profile image===========//
  $(document).on("change", 'input[name="flexRadioDefault"]', function () {
    if ($(this).is(":checked")) {
      let profileImageUrl = $(this).val();
      let profileImage = profileImageUrl.split("/").pop();
      let userName = $("#hidden_name_input").val();
      let locId = $("#loc_id_input").val();

      $.ajax({
        url: "/coach/dashboard/update-profile",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          profile_img: profileImage,
          name: userName,
          loc_id: locId,
        },
        success: function (response) {
          profilePicUpdate();
        },
        error: function (xhr, status, error) {
          console.error("AJAX request error:", error);
          // Optionally, display an error message to the user
        },
      });
    }
  });

  function profilePicUpdate() {
    const url = window.location.href;

    $.ajax({
      url: url,
      type: "GET",
      async: true,
      success: function (response) {
        console.log(response);

        // Append the image to the element with the class 'profile_top_pic'
        $(".profile_top_pic").html(
          `<img src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${response.d.id}/${response.d.profile_img}" alt="Profile Picture">`
        );
      },
      error: function (xhr, status, error) {
        // Handle errors here
        console.error("AJAX request error:", error);
        // Optionally, display an error message to the user
      },
    });
  }

  //=============profile image end===========//

  //==========update class progress===========//
  function updateProgressBar() {
    var checkboxes = $('input[name="checkbox"]:checked');
    var inputField = $("#new-location").val().trim();
    var progressBar = $("#progress-bar");

    if (checkboxes.length > 0 || inputField !== "") {
      progressBar.removeClass("progress-0").addClass("progress-100");
      progressBar.find(".overlay").text("100%");
    } else {
      progressBar.removeClass("progress-100").addClass("progress-0");
      progressBar.find(".overlay").text("0%");
    }
  }

  $('input[name="checkbox"]').change(updateProgressBar);
  $("#new-location").keyup(updateProgressBar);

  // Initial check on page load
  updateProgressBar();
  //==========update class progress ends===========//

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

  $("#btn-save-personal-info").on("click", function () {
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
    $(".feedback_error").hide();
    $('.pin-input').val('');
    $(".pin_error").text('');
  });

  $(document).on("click", ".get_back4", function () {
    $(this).closest(".confirm-box").hide();
    location.reload();
  });

  // Hide confirmation box when clicking outside the box
  $(document).on("click", ".confirm-backdrop", function () {
    $(this).closest(".confirm-box").remove();
    $(".feedback_error").hide();
    $('.pin-input').val('');
    $(".pin_error").text('');
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
        console.log(response);
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
        alert("An error occurred. Please try again.");
        // Handle error actions here
      },
    });
  });

  $(".notification_cross").click(function () {
    $(this).closest(".notifications_box").remove();
  });
  $("#logout_profile").click(function () {
    sessionStorage.clear();
    window.location.href = "https://www.bookmyplayer.com/profile/logout";
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

document.querySelectorAll('img').forEach((img) => {
  if (img.src.endsWith('.heic')) {
      fetch(img.src)
          .then((response) => response.blob())
          .then((blob) => heic2any({ blob, toType: 'image/jpeg' }))
          .then((convertedBlob) => {
              img.src = URL.createObjectURL(convertedBlob);
          })
          .catch((err) => console.error('HEIC conversion error:', err));
  }
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
      console.log(response);
      console.log("create order");
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
              console.log(result);
            },
          });
        },
      };
      var rzp = new Razorpay(options);
      rzp.open();
    },
  });
}
