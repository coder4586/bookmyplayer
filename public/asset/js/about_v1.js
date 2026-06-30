document.addEventListener("DOMContentLoaded", function () {

  let localStorageLatitude = localStorage.getItem('latitude');
  let localStorageLongitude = localStorage.getItem('longitude');
  let latitude;
  let longitude;

  if(localStorageLatitude && localStorageLongitude ){
    latitude = localStorageLatitude;
    longitude = localStorageLongitude;
  }else if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
} else {
    console.error("Geolocation is not supported by this browser.");
}

function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
}


  var e = -1,
    t = document.querySelectorAll(".victory_div"),
    n = document.querySelectorAll(".carousel-dots .dot");
  function c(e) {
    t.forEach(function (e) {
      e.style.display = "none";
    }),
      n.forEach(function (e) {
        e.classList.remove("active");
      }),
      (t[e].style.display = "flex"),
      n[e].classList.add("active");
  }
  function o() {
    c((e = (e + 1) % t.length));
  }
  setInterval(o, 5e3),
    o(),
    n.forEach(function (t, n) {
      t.addEventListener("click", function () {
        c((e = n));
      });
    });


    $('#trigger-report').click(function () {
        $('#report-overlay').show();
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
            $('#error-message').text(errorMessage);
        } else {
            $('#error-message').text('');
            $('#report_latitude').val(latitude);
            $('#report_longitude').val(longitude);
            let finalIssue = issue + `\n\npage: ${currentPage}`;
            $('#report-issue').val(finalIssue);
            $("#report-submit").text("Sending...!!!").prop("disabled", true);
        }
    });

    $(document).on('click', '.get_back, .confirm-backdrop', function () {
      $('.confirm-box').remove(); // Remove the confirmation box from the DOM
  });
    
    
    
      });
      
