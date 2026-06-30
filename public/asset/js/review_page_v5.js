$(document).ready(function () {
  let url = window.location.href;
  let reviewId;
  let academyId;
  let replyCount;
  let uploadedPhotoNames = [];
  let urlId = url.split("/").pop();
  if (urlId.includes("-")) {
    urlId = urlId.split("-").pop();
  }
  urlId = urlId.replace(/(\d+)[#\D].*/, "$1");
  let totalReviews = parseInt($("#totalReviews").val());
  let reviewsPerPage = 10;
  let lastPage = Math.ceil(totalReviews / reviewsPerPage);
  let imagesFileId = "";

  $(".reviews-tab-content ul li a").click(function () {
    $(".reviews-tab-content ul li a").removeClass();
    $(this).addClass("reviewsselect");
    var index = $(".reviews-tab-content ul li a").index($(this));
    $(".reviews-tab-details > div").hide();
    $(".reviews-tab-details > div")
      .filter(":eq(" + index + ")")
      .show();
  });

  function generateStarBoxHtml(averageRating) {
    let starsHtml = "";
    const roundedRating =
      Math.floor(averageRating) + (averageRating % 1 >= 0.5 ? 0.5 : 0);

    const fullStars = Math.floor(roundedRating);
    const hasHalfStar = roundedRating % 1 !== 0;
    const totalStars = 5;

    for (let i = 0; i < fullStars; i++) {
      starsHtml += '<li><i class="fa-solid fa-star"></i></li>';
    }

    if (hasHalfStar) {
      starsHtml += '<li><i class="fa-solid fa-star-half-stroke"></i></li>';
    }

    // Add empty stars to make a total of 5
    const remainingStars = totalStars - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < remainingStars; i++) {
      starsHtml += '<li><i class="fa-regular fa-star"></i></li>';
    }

    return starsHtml;
  }

  function publicReview(filterType = "latest", page = 1) {
    $.ajax({
      type: "POST",
      url: "https://www.bookmyplayer.com/api/academy/reviews",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "filter",
        filter: filterType,
        page: page,
      },
      success(response) {
        const reviewsContainer = $(".person_review");
        const reviewsLatest = $(".top_person_review");
        const reviewsLow = $(".low_person_review");
        reviewsContainer.empty();
        reviewsLatest.empty();
        reviewsLow.empty();

        if (response.data.reviews.length > 0) {
          $(".most-useful-reviews").removeClass("hidden");
          $.each(response.data.reviews, function (index, review) {
            const formattedDate = new Date(
              review.creation_date
            ).toLocaleDateString("en-GB", {
              day: "2-digit",
              month: "long",
              year: "numeric",
            });

            let imgGalleryHtml = '<div class="row img-gallery">';
            if (review.photos) {
              const photos = review.photos.split(",");
              const baseUrl = `https://f005.backblazeb2.com/file/bmpcdn90/academy/${urlId}/`;

              $.each(photos, function (i, photoName) {
                const imgSrc = `${baseUrl}${photoName.trim()}`;

                imgGalleryHtml += `
                 <div class="col-3 col-sm-3 col-md-2 mb-3">
  <figure class="img-box">
    <div class="shimmer-card"></div>
    <img
      data-src="${imgSrc}"
      alt="Review Image"
      class="lazy-load actual-image"
      loading="lazy"
      style="display: none;"
    >
  </figure>
</div>
`;
              });
            }
            imgGalleryHtml += "</div>";

            // Parse advance_review JSON data
            let highlightHtml = "";
            let criteriaHtml = "";

            if (review.advance_review) {
              let advanceReviewData = {};
              try {
                advanceReviewData = JSON.parse(review.advance_review);
              } catch (error) {
                advanceReviewData = {}; // Default value or fallback behavior
              }

              if (advanceReviewData.highlight) {
                const highlights = advanceReviewData.highlight.split(",");
                highlightHtml =
                  '<div class="highlight-container d-flex justify-content-start align-item-start gap-1 flex-wrap">';
                highlights.forEach((highlight) => {
                  highlightHtml += `<span class="highlight-box">${highlight.trim()}</span>`;
                });
                highlightHtml += "</div>";
              }

              if (advanceReviewData.criteria) {
                criteriaHtml = '<div class="criteria-container">';
                advanceReviewData.criteria.forEach((criteria) => {
                  let stars = "";
                  for (let i = 0; i < criteria.rating; i++) {
                    stars +=
                      '<i class="fa-solid fa-star" style="color:#F9B53D"></i>';
                  }
                  criteriaHtml += `<div class="criteria-item"><span>${criteria.name}:</span> <span>${stars}</span></div>`;
                });
                criteriaHtml += "</div>";
              }
            }

            const reviewHtml = `
            <div class="review-box" data-review-id="${review.id}">
              <div class="row">
                <div class="col-lg-4">
                  <div class="author-details">
                    <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/logo.svg" alt="Review Image" loading="lazy"></figure>
                    <article>
                      <h2 class="text-capitalize">${review.name}</h2>
                      <p><span>${formattedDate}</span></p>
                    </article>
                  </div>
                   ${criteriaHtml}
                </div>
                <div class="col-lg-8">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="stars">${generateStars(review.rating)}</div>
                    <div class="threedots"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                  </div>
                  <p>${review.comment}</p>
                  ${imgGalleryHtml}
                  ${highlightHtml}
                  <div class="replies-container"></div>
                  <div class="d-flex justify-content-between align-items-center mt-4 botbox comment_ul">
                    <ul class="image-list">
                      <li class="image-like"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/like.svg" alt="Like Icon" loading="lazy" width="28" height="25" class="like_icon"><div class="sparkle-container"></div></li>
                      <li class="image-like"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/thumbsDown.svg" alt="Dislike Icon" loading="lazy" width="28" height="25" class="dislike_icon"><div class="sparkle-container"></div></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>`;

            if (filterType == "latest") reviewsContainer.append(reviewHtml);
            else if (filterType == "top") reviewsLatest.append(reviewHtml);
            else if (filterType == "low") reviewsLow.append(reviewHtml);
          });

          updatePagination(page, lastPage, filterType);

          setTimeout(() => {
            $(".lazy-load").each(function () {
              const img = $(this);
              const src = img.data("src");

              // Hide the shimmer and show the image
              img.attr("src", src).show();
              img.siblings(".shimmer-card").hide();
              img.removeClass("lazy-load");
            });
          }, 2000);
        }
      },
      error(response) {
        console.error(response);
      },
    });
  }

  $(document).on("click", ".image-list li img", function () {
    const $img = $(this);
    const currentSrc = $img.attr("src");
    const $parentReviewBox = $img.closest(".review-box");
    const $likeIcon = $parentReviewBox.find(".like_icon");
    const $thumbsDownIcon = $parentReviewBox.find(".dislike_icon");

    // Toggle "like" icon
    if (currentSrc.endsWith("like.svg")) {
      $likeIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/like2.svg"
      );
      $thumbsDownIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/thumbsDown.svg"
      ); // Reset "dislike" icon
    } else if (currentSrc.endsWith("like2.svg")) {
      $likeIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/like.svg"
      );
    }
    // Toggle "dislike" icon
    else if (currentSrc.endsWith("thumbsDown.svg")) {
      $thumbsDownIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/thumbsDown2.svg"
      );
      $likeIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/like.svg"
      ); // Reset "like" icon
    } else if (currentSrc.endsWith("thumbsDown2.svg")) {
      $thumbsDownIcon.attr(
        "src",
        "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/thumbsDown.svg"
      );
    }

    // Sparkle effect for the selected icon
    const $container = $img.siblings(".sparkle-container");
    const numStars = 50;
    const imageWidth = $img.width();
    const imageHeight = $img.height();

    for (let i = 0; i < numStars; i++) {
      const star = $('<div class="sparkle"></div>');
      const left = Math.random() * imageWidth;
      const top = Math.random() * imageHeight;

      star.css({
        left: left + "px",
        top: top + "px",
      });

      // Append the star to the container
      $container.append(star);

      // Remove star after animation
      star.on("animationend", function () {
        $(this).remove();
      });
    }
  });

  function updatePagination(currentPage, lastPage, filterType) {
    let paginationId = "";

    if (filterType === "latest") {
      paginationId = "#pagination1";
    } else if (filterType === "top") {
      paginationId = "#pagination2";
    } else if (filterType === "low") {
      paginationId = "#pagination3";
    }

    // Clear the current pagination
    $(paginationId).empty();

    // Add "Previous" page link
    let prevPage = currentPage > 1 ? currentPage - 1 : null;
    $(paginationId).append(`
      <li class="page-item ${!prevPage ? "disabled" : ""}">
        <a class="page-link" href="javascript:void(0)" data-page="${prevPage}" aria-label="Previous">
          <span aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
        </a>
      </li>
    `);

    // Show current and next page or current and previous page
    let startPage = currentPage;
    let endPage = currentPage + 1 <= lastPage ? currentPage + 1 : currentPage;

    for (let i = startPage; i <= endPage; i++) {
      $(paginationId).append(`
        <li class="page-item ${currentPage === i ? "active" : ""}">
          <a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a>
        </li>
      `);
    }

    // Add "Next" page link
    let nextPage = currentPage < lastPage ? currentPage + 1 : null;
    $(paginationId).append(`
      <li class="page-item ${!nextPage ? "disabled" : ""}">
        <a class="page-link" href="javascript:void(0)" data-page="${nextPage}" aria-label="Next">
          <span aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
        </a>
      </li>
    `);
    $(`${paginationId} .page-link`).click(function () {
      const selectedPage = $(this).data("page");
      if (selectedPage) {
        publicReview(filterType, selectedPage);

        // Scroll to the top of the review section
        $("html, body").animate(
          {
            scrollTop: $(".reviews-tab-details").offset().top - 100,
          },
          300
        );
      }
    });
  }

  function generateStars(rating) {
    let starsHtml = "";
    for (let i = 1; i <= 5; i++) {
      if (i <= rating) {
        starsHtml += '<i class="fa-solid fa-star"></i>';
      } else if (i - rating < 1) {
        starsHtml += '<i class="fa-solid fa-star-half-stroke"></i>';
      } else {
        starsHtml += '<i class="fa-regular fa-star"></i>';
      }
    }
    return starsHtml;
  }

  publicReview();

  $(".top_review").click(function () {
    $(".top_person_review").html(`
      <div style="text-align: center;">
          <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" loading="lazy" width="40" height="40" alt="loader">
      </div>
  `);
    publicReview("top");
  });
  $(".latest_review").click(function () {
    $(".person_review").html(`
      <div style="text-align: center;">
          <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" loading="lazy" width="40" height="40" alt="loader">
      </div>
  `);
    publicReview("latest");
  });
  $(".low_review").click(function () {
    $(".low_person_review").html(`
      <div style="text-align: center;">
          <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" loading="lazy" width="40" height="40" alt="loader">
      </div>
  `);
    publicReview("low");
  });

  $("#openCustomModal").on("click", function () {
    $("#customModalOverlay").show();
  });

  $(".custom-close-btn").on("click", function () {
    $("#customModalOverlay").hide(); // Hide the modal overlay
  });

  $("#customModalOverlay").on("click", function (e) {
    if ($(e.target).is("#customModalOverlay")) {
      $("#customModalOverlay").hide(); // Hide the modal overlay
    }
  });

  $(document).on("click", ".comment-button", function () {
    reviewId = $(this).data("review-id");
    $("#commentModal").data("review-id", reviewId).show();
  });

  $(".custom-close-btn").on("click", function () {
    $("#commentModal").hide();
  });

  $("#commentModal").on("click", function (e) {
    if ($(e.target).is("#commentModal")) {
      $("#commentModal").hide();
    }
  });

  const headings = {
    1: "What could we improve?",
    2: "What didn’t meet your expectations?",
    3: "What did you like?",
    4: "What did you enjoy most?",
    5: "What made it great?",
  };

  $(".rating__input1").on("change", function () {
    const selectedRating = $(this).val();

    // Make AJAX call with the selected rating
    $.ajax({
      type: "POST",
      url: "https://www.bookmyplayer.com/api/reviews/get-heighlights",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: $("#sportId").val(),
        rating: selectedRating,
      },
      success: function (response) {
        // Clear current highlights and criteria
        const $loveBox = $(".love-box ul");
        $loveBox.empty();
        const $criteriaList = $(".criteria-list");
        $criteriaList.empty();

        // Update heading based on selected rating
        $("h6#love-heading").text(headings[selectedRating]);

        // Append highlights if available
        if (response.data && response.data[0].highlight) {
          $.each(response.data[0].highlight, function (index, highlight) {
            $loveBox.append(`<li>${highlight}</li>`);
          });

          // Set click event for newly appended list items
          $loveBox.find("li").on("click", function () {
            $(this).toggleClass("active_highlight");
          });
        }

        // Append criteria if available
        if (response.data && response.data[0].criteria) {
          $.each(response.data[0].criteria, function (index, criterion) {
            $criteriaList.append(`<li>
            <div class="criteria_name">
              ${criterion}
            </div>
            <div id="criteria_star_box">
              <div class="rating-group">
                <input class="rating__input" name="criteria_star_${selectedRating}_${index}" id="criteria_star-5_${selectedRating}_${index}" value="5" type="radio">
                <label class="rating__label criteria_label" for="criteria_star-5_${selectedRating}_${index}">&#9733;</label>

                <input class="rating__input" name="criteria_star_${selectedRating}_${index}" id="criteria_star-4_${selectedRating}_${index}" value="4" type="radio">
                <label class="rating__label criteria_label" for="criteria_star-4_${selectedRating}_${index}">&#9733;</label>

                <input class="rating__input" name="criteria_star_${selectedRating}_${index}" id="criteria_star-3_${selectedRating}_${index}" value="3" type="radio">
                <label class="rating__label criteria_label" for="criteria_star-3_${selectedRating}_${index}">&#9733;</label>

                <input class="rating__input" name="criteria_star_${selectedRating}_${index}" id="criteria_star-2_${selectedRating}_${index}" value="2" type="radio">
                <label class="rating__label criteria_label" for="criteria_star-2_${selectedRating}_${index}">&#9733;</label>

                <input class="rating__input" name="criteria_star_${selectedRating}_${index}" id="criteria_star-1_${selectedRating}_${index}" value="1" type="radio">
                <label class="rating__label criteria_label" for="criteria_star-1_${selectedRating}_${index}">&#9733;</label>
              </div>
            </div>
          </li>`);
          });
        }
      },
      error: function (response) {
        console.error(response); // Log error data on failure
      },
    });
  });

  $("#reviewFileInput").on("change", function (event) {
    const files = event.target.files;

    if (files.length > 3) {
      let confirmBoxHtml = `
                        <div class="confirm-box" style="z-index: 10;">
                            <div class="confirm-backdrop"></div>
                            <div class="confirm-content">
                                <div class="confirm-body">
                                    <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
                                    <h6>You can upload a maximum of 3 images.</h6>
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
    const baseUrl = "https://f005.backblazeb2.com/file/bmpcdn90/temp/";
    let fileIndex = 0; // To track current file index

    function uploadNextFile() {
      if (fileIndex >= files.length) return; // Stop when all files are uploaded

      let file = files[fileIndex]; // Get the current file
      fileIndex++; // Move to the next file for the next call

      let formData = new FormData();
      formData.append("type", "academy");
      formData.append("typeId", urlId);
      formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
      formData.append("file", file);

      // Show loader for the current image
      let loaderHtml = `
            <div class="col-3 col-sm-3 col-md-2 image-item loader-item">
                <figure class="img-box loader-box">
                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif" alt="Loader Icon" class="loading-img"> 
                </figure>
            </div>
        `;
      let $loaderElement = $(loaderHtml).appendTo(".experienece_img");

      $.ajax({
        url: "/api/upload-temp-photos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.status == 1) {
            let fileName = response.fileName;
            let fileId = response.result.fileId; // Get fileId from response
            imagesFileId += (imagesFileId ? "," : "") + fileId;

            let imageHtml = `
                        <div class="col-3 col-sm-3 col-md-2 image-item" data-filename="${fileName}">
                            <figure class="img-box">
                                <img src="${
                                  baseUrl + fileName
                                }" alt="Uploaded Image" loading="lazy">
                                <i class="fa-solid fa-minus remove-icon" aria-hidden="true"></i>
                            </figure>
                        </div>
                    `;

            $loaderElement.replaceWith(imageHtml);

            uploadNextFile();
          } else {
            $loaderElement.remove();

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
            $("body").append(confirmBoxHtml);
          }
        },
        error: function (xhr, status, error) {
          console.log("Error uploading file:", error);
          $loaderElement.remove(); // Remove loader on failure
        },
      });
    }

    // Start uploading the first file
    uploadNextFile();
  });

  $(document).on("click", ".remove-icon", function () {
    var $imageItem = $(this).closest(".image-item");

    var fileName = $imageItem.data("filename");

    var index = uploadedPhotoNames.indexOf(fileName);

    if (index !== -1) {
      uploadedPhotoNames.splice(index, 1);
    }
    $imageItem.remove();
  });

  $("#review_exp_submit").on("click", function (event) {
    event.preventDefault();
    let isValid = true;
    let errorMessage = "";
    let errorElement = $(".exp_error");

    // Get form field values
    let name = $("#review_exp_name").val().trim();
    let email = $("#review_exp_email").val().trim();
    let phone = $("#review_exp_phone").val().trim();
    let comment = $("#experience_details").val().trim();
    let rating = $('input[name="new_rating"]:checked').val(); // Get the selected rating

    // Validate fields
    if (name === "") {
      isValid = false;
      errorMessage = "Please enter your full name.";
    } else if (phone === "" || !/^\d{10}$/.test(phone)) {
      isValid = false;
      errorMessage = "Please enter a valid 10-digit phone number.";
    } else if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
      isValid = false;
      errorMessage = "Please enter a valid email address.";
    } else if (comment === "") {
      isValid = false;
      errorMessage = "Please enter your experience.";
    } else if (!rating) {
      isValid = false;
      errorMessage = "Please give a rating by clicking on a star.";
    }

    // Show error message if validation fails
    if (!isValid) {
      errorElement.text(errorMessage).show();
      return;
    }

    // Hide error message if validation passes
    errorElement.hide();

    // Collect highlights as a comma-separated string
    let highlights = $(".love-box ul li.active_highlight")
      .map(function () {
        return $(this).text();
      })
      .get()
      .join(", ");

    // Collect criteria as a JSON-style string
    let criteriaArray = [];
    $(".criteria-list li").each(function () {
      let criterionName = $(this).find(".criteria_name").text().trim();
      let criterionRating = $(this).find('input[type="radio"]:checked').val();
      if (criterionRating) {
        criteriaArray.push({
          name: criterionName,
          rating: criterionRating,
        });
      }
    });

    let combinedObject = {};

    if (criteriaArray.length > 0) {
      combinedObject.criteria = criteriaArray;
    }

    if (highlights) {
      combinedObject.highlight = highlights;
    }

    let jsonString = JSON.stringify(combinedObject);

    // Make AJAX call
    $.ajax({
      url: "https://www.bookmyplayer.com/api/add-academy-review",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        rating: rating,
        name: name,
        email: email,
        phone: phone,
        comment: comment,
        object_type: "academy",
        object_id: urlId,
        advance_review: jsonString,
        photos: imagesFileId,
      },
      beforeSend: function () {
        $("#review_exp_submit").prop("disabled", true).text("Sending...");
      },
      success: function (response) {
        $("#review_exp_submit").prop("disabled", false).text("Submit Review");
        let confirmBoxHtml = `
              <div class="confirm-box" style="z-index: 10;">
                  <div class="confirm-backdrop"></div>
                  <div class="confirm-content">
                      <div class="confirm-body">
                          <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${
                            response.status == 1 ? "success" : "error"
                          }.gif" class="img-fluid" alt=""></figure>
                          <h6>${response.message}</h6>
                      </div>
                      <div class="confirm-footer">
                          <button class="get_back btn btn-secondary">Go Back</button>
                      </div>
                  </div>
              </div>`;
        $("body").append(confirmBoxHtml);
        if (response.status == 1) {
          $(".exp_form")[0].reset();
        }
      },
      error: function (response) {
        $("#review_exp_submit").prop("disabled", false).text("Submit Reviews");
        console.log(response);
      },
    });
  });

  const baseUrl = "https://f005.backblazeb2.com/file/bmpcdn90/academy";
  const photosPerPage = 16;
  let currentIndex = 0;
  const $photoContainer = $(".row.g-2.mt-3");
  let photosArray = []; // Declare photosArray globally

  function showPhoto() {
    $.ajax({
      type: "POST",
      url: "https://www.bookmyplayer.com/api/academy/reviews",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "photos",
      },
      success(response) {
        academyId = response.data.ac_id;
        photosArray = response.data.photos
          .map((item) => item.photos.split(","))
          .flat(); // Flatten the array into a single array of photo names

        renderPhotos(academyId); // Render initial photos on success
      },
      error(response) {
        console.error(response); // Log the error on failure
      },
    });
  }

  function renderPhotos(id) {
    $photoContainer.empty();
    if (photosArray.length === 0) {
      $photoContainer.append("<p>No photos available.</p>");
      return;
    }

    addShimmerEffect();

    setTimeout(() => {
      $photoContainer.empty();

      const photoSlice = photosArray.slice(
        currentIndex,
        currentIndex + photosPerPage
      );

      photoSlice.forEach((photoName) => {
        const fullUrl = `${baseUrl}/${id}/${photoName}`;
        const photoHtml = `<div class="col-4 col-lg-2">
                              <figure class="img-box">
                                <img src="${fullUrl}" alt="Image" class="actual-image">
                              </figure>
                           </div>`;
        $photoContainer.append(photoHtml);
      });

      const hasMorePhotos = currentIndex + photosPerPage < photosArray.length;
      const hasPreviousPhotos = currentIndex > 0;

      if (hasMorePhotos) {
        $photoContainer.append(`<div class="col-4 col-lg-2 see-more-container">
                                  <figure class="img-box">
                                    <figcaption>
                                      <div class="see-more-link">show ${
                                        photosArray.length -
                                        (currentIndex + photosPerPage)
                                      } more photos</div>
                                    </figcaption>
                                  </figure>
                                </div>`);
      }

      if (hasPreviousPhotos) {
        const previousCount =
          currentIndex > photosPerPage ? photosPerPage : currentIndex;
        $photoContainer.append(`<div class="col-4 col-lg-2 show-previous-container">
                                  <figure class="img-box">
                                    <figcaption>
                                      <div class="show-previous-link">Show ${previousCount} previous photos</div>
                                    </figcaption>
                                  </figure>
                                </div>`);
      }
    }, 3000); // 3-second delay
  }

  function addShimmerEffect() {
    const shimmerHtml = `<div class="col-4 col-lg-2 shimmer-container">
                            <div class="shimmer-card"></div>
                         </div>`;
    for (let i = 0; i < photosPerPage; i++) {
      $photoContainer.append(shimmerHtml);
    }
  }

  function loadMorePhotos() {
    if (currentIndex + photosPerPage < photosArray.length) {
      currentIndex += photosPerPage;
      renderPhotos(academyId); // Re-render photos
    }
  }

  function showPreviousPhotos() {
    if (currentIndex > 0) {
      currentIndex -= photosPerPage;
      renderPhotos(academyId); // Re-render photos
    }
  }

  $(document).on("click", ".see-more-link", function () {
    loadMorePhotos();
  });

  $(document).on("click", ".show-previous-link", function (event) {
    event.preventDefault(); // Prevent default link behavior
    showPreviousPhotos();
  });

  showPhoto();

  function nearByAcademies() {
    $.ajax({
      type: "POST",
      url: "https://www.bookmyplayer.com/api/academy/reviews",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: urlId,
        type: "footer",
      },
      success(response) {
        const { nearByLocations } = response.data;
        const { topLocations } = response.data;
        const { otherNearbySports } = response.data;

        if (nearByLocations && nearByLocations.length > 0) {
          // Remove the 'hidden' class
          $(".nearby_location").removeClass("hidden");

          const listItems = nearByLocations
            .map((location) => {
              const { locality_name, city, state } = location;
              let displayText = locality_name;
              if (locality_name === city && city === state) {
                displayText = locality_name;
              } else if (locality_name === city) {
                displayText = `${locality_name}, ${state}`;
              } else {
                displayText = `${locality_name}, ${city}`;
              }
              return `
              <li class="other_link_li text-capitalize">
                <a href="${location.url}">
                  ${displayText}
                </a>
              </li>
            `;
            })
            .join(""); // Join all list items into a single string

          // Append the list items to the UL
          $(".other_review_links").html(listItems);
        }
        if (topLocations && topLocations.length > 0) {
          $(".top_location").removeClass("hidden");

          const listItems = topLocations
            .map((location) => {
              const { locality_name, city, state } = location;
              let displayText = locality_name;
              if (locality_name === city && city === state) {
                displayText = locality_name;
              } else if (locality_name === city) {
                displayText = `${locality_name}, ${state}`;
              } else {
                displayText = `${locality_name}, ${city}`;
              }
              return `
              <li class="other_link_li text-capitalize">
                <a href="${location.url}">
                  ${displayText}
                </a>
              </li>
            `;
            })
            .join(""); // Join all list items into a single string

          // Append the list items to the UL
          $(".top_review_links").html(listItems);
        }
        if (otherNearbySports && otherNearbySports.length > 0) {
          $(".other_sport_location").removeClass("hidden");

          const listItems = otherNearbySports
            .map((location) => {
              const { locality_name, city, state } = location;
              let displayText = locality_name;
              if (locality_name === city && city === state) {
                displayText = locality_name;
              } else if (locality_name === city) {
                displayText = `${locality_name}, ${state}`;
              } else {
                displayText = `${locality_name}, ${city}`;
              }
              return `
              <li class="other_link_li text-capitalize">
                <a href="${location.url}">
                  ${displayText}
                </a>
              </li>
            `;
            })
            .join(""); // Join all list items into a single string

          // Append the list items to the UL
          $(".other_sport_review_links").html(listItems);
        }
      },
      error(response) {
        console.error("Error fetching nearby academies:", response);
      },
    });
  }

  // Call the function
  nearByAcademies();
});
