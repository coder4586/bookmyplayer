var url = `${window.location.origin}/${window.location.pathname}`;
$("img").lazyload({
  effect: "fadeIn",
});

let whatsappNumber;

function showLoadingIndicator() {
  $("#loading-indicator").removeClass("d-none");
}

function hideLoadingIndicator() {
  $("#loading-indicator").addClass("d-none");
}
showLoadingIndicator();
  get_coach_listing(1);


var modal = $("#messageModal");

$(document).on("click", ".coach_message_button", function () {
  var object_id = $(this).data("coach-id");
  var coach_name = $(this).data("coach-name");
  var sport_id = $(this).data("coach-sport_id");
  var sport = $(this).data("coach-sp");

  let message = `Message to ${coach_name}`;
  $("#message-model-title").text(message);
  $("#object_id").val(object_id);
  $("#sport_id").val(sport_id);
  $("#sport").val(sport);

  modal.show();
});

var close = $(".coach_close");
close.on("click", function () {
  modal.hide();
});

$(window).on("click", function (event) {
  if ($(event.target).is(modal)) {
    modal.hide();
  }
});

function get_coach_listing(page) {
  $.ajax({
    url: `${url}`,
    type: "GET",
    async: true,
    data: { page: page },
    success: function (response) {
      let listing = "";

      if (response.coaches.length > 0) {
        console.log(response.coaches)
        response.coaches.forEach(function (coach) {
            const skillsArray = coach.skill ? coach.skill.split(",") : ["coach"];
            const photosArray = coach.photos ? coach.photos.split(",") : [];
            whatsappNumber = response.whatsapp_no;
            let skillhtml = ``;
            let photoHTML = '<div class="carousel">';

            skillsArray.forEach((skill) => {
                skillhtml += `<li>${skill.trim()}</li>`;
            });

            if (photosArray.length == 0) {
                photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/register-image.jpg" loading="lazy" alt=""> </div>`;
            } else {
                photosArray.forEach((item) => {
                    const extension = item.split(".").pop().toLowerCase();
                    if (["jpg", "jpeg", "png", "gif"].includes(extension)) {
                        photoHTML += `<div class="item"> <img src="https://f005.backblazeb2.com/file/bmpcdn90/coach/${coach.id}/${item}" loading="lazy" alt=""> </div>`;
                    }
                });
            }
            photoHTML += "</div>";

            listing += `
                <div class="col-lg-6">
                    <div class="coache-box">
                        <div class="top">
                            <figure>
                                <div class="coaches-js">
                                    ${photoHTML}
                                </div>
                                <span class="recommended">Recommended</span>
                            </figure>
                            <aside>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating">
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/star-rating.svg" loading="lazy" alt="" width="17" height="17">
                                        <strong>${Math.floor(Math.random() * 5) + 1}</strong> (${Math.floor(Math.random() * 25) + 1})
                                    </div>
                                    <div class="verified" title="Verified">
                                        <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/verified.svg" loading="lazy" alt="Verified" width="17" height="17">
                                    </div>

                                </div>
                                <a href="${coach.url}" target="_blank">
                                    <h6 class="text-capitalize">${coach.name ? coach.name : "-"}</h6>
                                </a>
                                <p class="text-capitalize"><strong>${coach.sport == null || coach.sport == "select" || coach.sport == "" ? "sport" : coach.sport}</strong></p>
                                <div class="d-flex justify-content-start align-items-start text-capitalize">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p>${coach.city && coach.city !== "select" ? coach.city : ""}${coach.city && coach.state && coach.city !== "select" && coach.state !== "select" ? ", " : ""}${coach.state && coach.state !== "select" ? coach.state : ""}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <div class="prize">₹ ${coach.package ? coach.package : "-"}</div>
                                </div>
                                 <div class="free">Free Trial Class*</div>
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
                                <div class="viewed">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-viewed.svg" loading="lazy" alt="" width="14" height="14">11 people viewed since last week
                                </div>
                                <div class="graph">
                                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-trending-up.svg" loading="lazy" alt="" width="20" height="20">12%
                                </div>
                            </div>
                        </div>
                        <div class="bot">
                            <button type="button" class="coach_message_button" data-coach-id="${coach.id}" data-coach-sport_id="${coach.sport_id}" data-coach-sp="${coach.sport}" data-coach-name="${coach.name}">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-comment.svg" loading="lazy" alt="" width="20" height="20">Message
                            </button>
                            <button type="button" data-action="whatsapp" data-coach-id="${coach.id}" data-coach-name="${coach.name}">
                                <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-whatsapp.svg" loading="lazy" alt="" width="20" height="20">WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
          $("#coach-listing").html(listing);
          updatePagination(response.pagination);

        $("#coach-listing .carousel").slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            arrows: true,
            dots: true,
        });

        hideLoadingIndicator();
    }
     else {
        $("#no-data-found").removeClass("d-none");
        hideLoadingIndicator();
      }
    },
  });
}

$('#prev-page, #next-page').on('click', function(e) {
  var $this = $(this);
  var page = $this.data('value');

  // Prevent action for last page or first page
  if ((page === null) || ($this.is('#prev-page') && page === 0)) {
    e.preventDefault();
    return;
  }

  get_coach_listing(page);
});

function updatePagination(data) {
  var currentPage, isLast;

  data.forEach(function(item) {
    switch (item.name) {
      case "previous":
        $('#prev-page').data('value', item.value);
        break;
      case "current":
        currentPage = parseInt(item.value);
        $('#current-page span').text(currentPage);
        break;
      case "next":
        $('#next-page').data('value', item.value);
        break;
      case "is_last":
        isLast = item.value;
        break;
    }
  });

  if (currentPage === 1) {
    $('#prev-page').addClass('disabled');
    $('#prev-page a').html('No Previous Page');
  } else {
    $('#prev-page').removeClass('disabled');
    $('#prev-page a').html('<span aria-hidden="true">&laquo;</span> Previous');
  }

  if (isLast) {
    $('#next-page').addClass('disabled');
    $('#next-page a').html('No Next Page');
  } else {
    $('#next-page').removeClass('disabled');
    $('#next-page a').html('Next <span aria-hidden="true">&raquo;</span>');
  }
}


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

var whatsappModal = $("#whatsappModal");
var close = $("#close_whatsapp");

$(document).on("click", 'button[data-action="whatsapp"]', function () {
  var coachName = $(this).data("coach-name");

  $("#whatsappModalLabel").text(`Contact Coach ${coachName}`);
  $("#whatsappForm input[name='name']").val("");
  $("#whatsappForm input[name='email']").val("");
  $("#whatsappForm input[name='phone']").val("");
  $("#whatsappForm textarea[name='description']").val("");

  whatsappModal.modal("show");
});

close.on("click", function () {
  whatsappModal.modal("hide");
});

$(document).on("click", function (event) {
  if ($(event.target).is("#formSubmitButton")) {
    let isValid = true,
        errorMessage = "",
        userName = $("#details_name").val().trim(),
        userEmail = $("#details_email").val().trim(),
        userPhone = $("#details_phone").val().trim(),
        userMessage = $("#details_desc").val().trim();

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
      let whatsappMessage = `Additional Info\nName: ${userName}\nEmail: ${userEmail}\nPhone: ${userPhone}\nDescription: ${userMessage}\n------------------------------\n`;
      let encodedMessage = encodeURIComponent(whatsappMessage);
      window.open(`https://api.whatsapp.com/send/?phone=+91${whatsappNumber}&text=${encodedMessage}`, "_blank");
    } else {
      event.preventDefault();
      $("#formError").text(errorMessage).show();
    }
  }
});


function validateEmail(email) {
  var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePhone(phone) {
  var re = /^\d{10}$/;
  return re.test(phone);
}

$('.verified-icon').hover(
  function() {
      $(this).siblings('.tooltip').css({
          'display': 'inline-block',
          'left': $(this).position().left + $(this).width() / 2,
          'top': $(this).position().top - $(this).height() / 2
      });
  },
  function() {
      $(this).siblings('.tooltip').css('display', 'none');
  }
);
