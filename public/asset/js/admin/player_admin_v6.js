$(document).ready(function () {
  var url = window.location.href;
  handlePageSwitch("#profile_box", "#profile_page");

  var content = $('#profile-about').val();

  // Set the content in the Quill editor
  quill.root.innerHTML = content;

  // Function to show the confirmation box
function showConfirmationBox(message) {
  $('#confirm-message').text(message);
  $('#confirm-box').fadeIn();
}

// Function to hide the confirmation box
function hideConfirmationBox() {
  $('#confirm-box').fadeOut();
}

// Event listener for the close button
$('#confirm-close').on('click', function() {
  hideConfirmationBox();
});

  //====== dashboard tab change js start==========//

  $("#dashboard_box").click(() =>
    handlePageSwitch("#dashboard_box", "#dashboard_page")
  );
  $("#profile_box").click(() =>
    handlePageSwitch("#profile_box", "#profile_page")
  );
  $("#leads_box").click(() => handlePageSwitch("#leads_box", "#leads_page"));
  $("#boost_box").click(() => handlePageSwitch("#boost_box", "#boost_page"));
  $("#performance_box").click(() =>
    handlePageSwitch("#performance_box", "#performance_page")
  );
  $("#notification_box").click(() =>
    handlePageSwitch("#notification_box", "#notification_page")
  );
  $("#upgrade_box").click(() =>
    handlePageSwitch("#upgrade_box", "#upgrade_page")
  );

  //======dashboard tab change js End==========//

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
      $("#training_update").submit();
    }
  });

  //==========add location js Ends=============//

  // handle tab change start //
  function handlePageSwitch(activeBox, activePage) {
    const pages = [
      "#dashboard_page",
      "#leads_page",
      "#boost_page",
      "#notification_page",
      "#performance_page",
      "#profile_page",
      "#upgrade_page",
    ];
    const boxes = [
      "#dashboard_box",
      "#leads_box",
      "#boost_box",
      "#notification_box",
      "#performance_box",
      "#profile_box",
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
              response.leads.forEach(function (lead) {
                const creationDateString = lead.creation_date;
                const creationDate = new Date(
                  creationDateString.replace(/-/g, "/")
                );
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

                let profile =
                  "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/coach-img.png";

                leads += `<div class="col-lg-6">`;
                leads += `    <div class="lead-card">`;
                leads += `        <div class="d-flex justify-content-between align-items-start">`;
                leads += `            <figure><img src="${profile}" class="img-fluid" alt=""></figure>`;
                leads += `            <article>`;
                leads += `                <div class="left text-start">`;
                leads += `                    <h6 class="lead-name">${
                  lead.name ? lead.name : "-"
                }</h6>`;
                leads += `                    <p><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> +91 ${
                  lead.phone ? lead.phone : "-"
                }</p>`;
                leads += `                </div>`;
                leads += `                <div class="right text-end">`;
                leads += `                    <h6>Id: ${lead.id}</h6>`;
                leads += `                    <p>${formattedDate}</p>`;
                leads += `                    <p>@${formattedTime}</p>`;
                leads += `                </div>`;
                leads += `            </article>`;
                leads += `        </div>`;
                leads += `       <div class="leads-description"><p>${
                  lead.description ? lead.description : "-"
                }</p></div>`;
                leads += `    </div>`;
                leads += `</div>`;
              });
              $("#coach-admin-leads").html(leads);
            } else {
              $("#coach-admin-leads").html("<p>no lead Found</p>");
            }
          },
        });
      }, 1000);
    }
  }

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
      // if ($("#location-name").html().includes("No match found")) {
      //   $("#locationInput").val("");
      // }
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

  $(document).on("click", function (event) {
    if (!$(event.target).closest(".confirm-content").length && $("#video_box").is(":visible")) {
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
        url: `/player/dashboard/update-profile`,
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
          console.log(response.tickets);
          console.log("hii");
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
      $('#profile-about').val(quill.root.innerHTML);
      let formData = $("#player_update").serialize(); // Serialize form data

      $.ajax({
        url: $("#player_update").attr("action"), // Form action URL
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
  })

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

  $("#player_dob").on("focus", function () {
    this.showPicker();
  });

  //=============scroll js============//
  // const scrollPositionKey = "scrollPosition";
  // const accordionStateKey = "accordionState";

  // // Restore the scroll position and the state of the open accordion
  // const savedScrollPosition = localStorage.getItem(scrollPositionKey);
  // const savedAccordionState = localStorage.getItem(accordionStateKey);

  // if (savedScrollPosition !== null) {
  //   $('html, body').animate({ scrollTop: parseInt(savedScrollPosition, 10) }, 'smooth');
  //   localStorage.removeItem(scrollPositionKey);
  // }

  // if (savedAccordionState !== null) {
  //   $(`#${savedAccordionState}`).addClass("show");
  //   localStorage.removeItem(accordionStateKey);
  // }

  // // Save the scroll position and the state of the open accordion before unloading the page
  // $(window).on("beforeunload", function () {
  //   localStorage.setItem(scrollPositionKey, $(window).scrollTop());

  //   const openAccordion = $(".accordion-collapse.show").attr("id");
  //   if (openAccordion) {
  //     localStorage.setItem(accordionStateKey, openAccordion);
  //   }
  // });

  // // Toggle the state of the accordion
  // $(".accordion-button").click(function () {
  //   const currentAccordion = $(this).attr("data-bs-target").substring(1);
  //   $(".accordion-collapse").each(function () {
  //     const id = $(this).attr("id");
  //     if (id !== currentAccordion) {
  //       $(this).removeClass("show");
  //     }
  //   });
  // });


  //=============scroll js ends============//

  //==========experience js start============//

  $(".dateofbirth").on("focus", function () {
    this.showPicker();
  });


  let experienceCount = $(".experience-entry").length; // Initialize count based on existing entries

  $(".add-experience").click(function () {
      var playedFor = $("#played_for").val();
      var expDate = $("#exp_date").val();
      var experienceDesc = $("#experience_desc").val();

      // Check if inputs contain the forbidden characters ';' or ','
      if (
        playedFor.includes(";") ||
        playedFor.includes(",") ||
        experienceDesc.includes(";") ||
        experienceDesc.includes(",")
      ) {
          alert(
              "Semicolons (;) and commas (,) are not allowed in the input fields."
          );
          return;
      }

      if (playedFor && expDate && experienceDesc) {
          experienceCount++;
          var experienceHTML = `
              <div class="row g-2 g-md-3 experience-entry" id="experience_${experienceCount}">
                  <div class="col-lg-6 col-md-6">
                      <input type="text" class="form-control" value="${playedFor}">
                  </div>
                  <div class="col-lg-6 col-md-6">
                      <input type="date" class="form-control dateofbirth" id="exp_date_${experienceCount}" value="${expDate}">
                  </div>
                  <div class="col-lg-12 col-md-12">
                      <input type="text" class="form-control" value="${experienceDesc}">
                  </div>
                  <div class="col-lg-12">
                      <div class="remove-experience" data-experience-id="experience_${experienceCount}"><i class="fa-solid fa-minus"></i> Remove Experience</div>
                  </div>
              </div>`;

          $("#experience-container").append(experienceHTML);

          // Clear the input fields
          $("#played_for").val("");
          $("#exp_date").val("");
          $("#experience_desc").val("");

          updateHiddenExperienceField();
      } else {
        showConfirmationBox("Please fill out all fields.");
      }
  });

  $(document).on("click", ".remove-experience", function () {
      var experienceId = $(this).data("experience-id");
      $("#" + experienceId).remove();

      updateHiddenExperienceField();
  });

  $("#exp_save_btn").click(function (event) {
    event.preventDefault(); // Prevent the form from submitting

    updateHiddenExperienceField(); // Call your existing function to update the hidden field

    let formData = $("#player_experience").serialize(); // Serialize form data

    $.ajax({
        url: $("#player_experience").attr("action"), // Form action URL
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
        }
    });
});


  function updateHiddenExperienceField() {
      var experiences = [];
      $(".experience-entry").each(function () {
          var playedFor = $(this).find('input[type="text"]').eq(0).val();
          var expDate = $(this).find('input[type="date"]').val();
          var experienceDesc = $(this).find('input[type="text"]').eq(1).val();
          experiences.push(`${playedFor};${expDate};${experienceDesc}`);
      });

      var combinedExperiences = experiences.join(",");
      $("#experience").val(combinedExperiences);
  }


  //==========experience js ends============//

  //=============educatio js start=============//
  let educationCount = $(".education-entry").length; // Initialize count based on existing entries

$(".add-education").click(function () {
    var educationDegree = $("#education_degree").val();
    var educationFrom = $("#education_from").val();

    // Check if inputs contain the forbidden characters ';' or ','
    if (
      educationDegree.includes(";") ||
      educationDegree.includes(",") ||
      educationFrom.includes(";") ||
      educationFrom.includes(",")
    ) {
        alert(
            "Semicolons (;) and commas (,) are not allowed in the input fields."
        );
        return;
    }

    if (educationDegree && educationFrom) {
        educationCount++;
        var educationHTML = `
            <div class="row g-2 g-md-3 education-entry" id="education_${educationCount}">
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control" value="${educationDegree}">
                </div>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control" value="${educationFrom}">
                </div>
                <div class="col-lg-12">
                    <div class="remove-education" data-education-id="education_${educationCount}"><i class="fa-solid fa-minus"></i> Remove Education</div>
                </div>
            </div>`;

        $(".education-container").append(educationHTML);

        // Clear the input fields
        $("#education_degree").val("");
        $("#education_from").val("");

        updateHiddenEducationField();
    } else {
      showConfirmationBox("Please fill out all fields.");
    }
});

$(document).on("click", ".remove-education", function () {
    var educationId = $(this).data("education-id");
    $("#" + educationId).remove();

    updateHiddenEducationField();
});

$("#edu_save_btn").click(function (event) {
  event.preventDefault(); // Prevent the form from submitting

  updateHiddenEducationField(); // Call your existing function to update the hidden field

  let formData = $("#player_education").serialize(); // Serialize form data

  $.ajax({
      url: $("#player_education").attr("action"), // Form action URL
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
      }
  });
});


function updateHiddenEducationField() {
    var educations = [];
    $(".education-entry").each(function () {
        var educationDegree = $(this).find('input[type="text"]').eq(0).val();
        var educationFrom = $(this).find('input[type="text"]').eq(1).val();
        educations.push(`${educationDegree};${educationFrom}`);
    });

    var combinedEducations = educations.join(",");
    $("#education").val(combinedEducations);
}



  //=============educatio js ends=============//



  // skills section

  let skillCount = $(".skill-item").length; // Initialize count based on existing entries

  $(".add-skill").click(function () {
      var skillValue = $("#skill_input").val();

      // Check if input contains the forbidden characters ';'
      if (skillValue.includes(";")) {
          alert("Semicolons (;) are not allowed in the input field.");
          return;
      }

      if (skillValue) {
          skillCount++;
          var skillHTML = `
              <div class="col-lg-4 col-md-6 skill-item" id="skill_${skillCount}">
                  <input type="text" class="form-control" value="${skillValue}">
                  <div class="remove" data-skill-id="skill_${skillCount}">
                      <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" alt="Remove Skill">
                  </div>
              </div>`;

          $(".skills-container").append(skillHTML);

          // Clear the input field
          $("#skill_input").val("");

          updateHiddenSkillField();
      } else {
        showConfirmationBox("Please Enter Your Skills.");;
      }
  });

  $(document).on("click", ".remove", function () {
      var skillId = $(this).data("skill-id");
      $("#" + skillId).remove();

      updateHiddenSkillField();
  });

  $("#skills_save_btn").click(function (event) {
    event.preventDefault(); // Prevent the form from submitting

    updateHiddenSkillField(); // Call your existing function to update the hidden field

    let formData = $("#player_skills").serialize(); // Serialize form data

    $.ajax({
        url: $("#player_skills").attr("action"), // Form action URL
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
        }
    });
});


  function updateHiddenSkillField() {
      var skills = [];
      $('.skill-item input[type="text"]').each(function () {
          var skillValue = $(this).val();
          skills.push(skillValue);
      });

      var combinedSkills = skills.join(",");
      $("#skill_hidden").val(combinedSkills);
  }

  // skills section ends

  // awards section

  let awardCount = $(".award-item").length; // Initialize count based on existing entries

$(".add-award").click(function () {
    var awardValue = $("#award_input").val();

    // Check if input contains the forbidden characters ';'
    if (awardValue.includes(";")) {
        alert("Semicolons (;) are not allowed in the input field.");
        return;
    }

    if (awardValue) {
        awardCount++;
        var awardHTML = `
            <div class="col-lg-4 col-md-6 award-item" id="award_${awardCount}">
                <input type="text" class="form-control" value="${awardValue}">
                <div class="remove" data-award-id="award_${awardCount}">
                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/remove.svg" alt="Remove Award">
                </div>
            </div>`;

        $(".awards-container").append(awardHTML);

        // Clear the input field
        $("#award_input").val("");

        updateHiddenAwardField();
    } else {
      showConfirmationBox("Please Enter An Award.");
    }
});

$(document).on("click", ".remove", function () {
    var awardId = $(this).data("award-id");
    $("#" + awardId).remove();

    updateHiddenAwardField();
});

$("#awards_save_btn").click(function (event) {
  event.preventDefault(); // Prevent the form from submitting

  updateHiddenAwardField(); // Call your existing function to update the hidden field

  let formData = $("#player_awards").serialize(); // Serialize form data

  $.ajax({
      url: $("#player_awards").attr("action"), // Form action URL
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
      }
  });
});


function updateHiddenAwardField() {
    var awards = [];
    $('.award-item input[type="text"]').each(function () {
        var awardValue = $(this).val();
        awards.push(awardValue);
    });

    var combinedAwards = awards.join(",");
    $("#awards_hidden").val(combinedAwards);
}


  // awards section ends

  var heightValue = $('#height').val();
  if (heightValue) {
      var parts = heightValue.split(';');
      if (parts.length === 2) {
          $('#height_ft').val(parts[0]);
          $('#height_inch').val(parts[1]);
      }
  }

  $('#FileInput').change(function() {
    var fileInput = $('#FileInput')[0];
    var fileNameDisplay = $('#fileNameDisplay');
    var fileName = $('#fileName');

    if (fileInput.files.length > 0) {
        fileName.text(fileInput.files[0].name);
        fileNameDisplay.show();
    } else {
        fileNameDisplay.hide();
    }
});

$('#height_ft, #height_inch').on('input', function() {
  var ft = $('#height_ft').val() || 0; // Default to 0 if empty
  var inch = $('#height_inch').val() || 0; // Default to 0 if empty

  var heightValue = ft + ';' + inch;

  // Update hidden input 'height' value
  $('#height').val(heightValue);
});

//verify email js

$('#verify-email-button').on('click', function() {
  let name = $('#top-left-card-name').text().trim();
  let email = $('#email-display').text().trim();

  $.ajax({
      url: '/send-verification-email',
      type: 'POST',
      data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          name: name,
          email: email
      },
      success: function(response) {
        console.log(response)
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
        }else{
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
      error: function(xhr, status, error) {
          alert('An error occurred. Please try again.');
          // Handle error actions here
      }
  });
});

$(".notification_cross").click(function () {
  $(this).closest(".notifications_box").remove();
});

$("#logout_profile").click(function () {
  sessionStorage.clear();
  window.location.href = 'https://www.bookmyplayer.com/profile/logout';
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

});






