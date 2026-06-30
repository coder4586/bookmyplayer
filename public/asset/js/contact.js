$(document).ready(function () {
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

function showError(error) {
    switch(error.code) {
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
  $(".query_type").change(function () {
    if (this.value === "") {
      $(this).css("color", "#aaa");
    } else {
      $(this).css("color", "#222");
    }
  });

  $("#contactForm").submit(function (event) {
    let isValid = true;
    let name = $("#contactForm [name='name']").val();
    let email = $("#contactForm [name='email']").val();
    let phone = $("#contactForm [name='phone']").val();
    let description = $("#contactForm [name='description']").val();
    let queryType = $(".query_type").val();
    let errorMessage = "This field is required";

    // Clear previous error messages
    $(".error").text("");

    // Validate name
    if (name.length === 0) {
      $("#nameError").text(errorMessage);
      isValid = false;
    }

    // Validate email
    if (email.length === 0) {
      $("#emailError").text(errorMessage);
      isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
      $("#emailError").text("Please enter a valid email address");
      isValid = false;
    }

    // Validate phone
    if (phone.length === 0) {
      $("#phoneError").text(errorMessage);
      isValid = false;
    } else if (!/^\d{10}$/.test(phone)) {
      $("#phoneError").text("Phone number must be exactly 10 digits");
      isValid = false;
    }

    // Validate description
    if (description.length === 0) {
      $("#descriptionError").text(errorMessage);
      isValid = false;
    }

    // Validate query type
    if (!queryType || queryType === "") {
      $("#queryTypeError").text(errorMessage);
      isValid = false;
    }

    // If form is not valid, prevent submission
    if (!isValid) {
      event.preventDefault();
    }else{
      $("#latitude1").val(latitude);
      $("#longitude1").val(longitude);
      $("#contact_submit_btn").text("Sending...!!!").prop("disabled", true);
    }
  });
});
