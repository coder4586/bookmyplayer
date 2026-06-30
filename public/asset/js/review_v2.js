$(document).ready(function () {
    let url = window.location.href;
    let urlId = url.split("/").pop();
    if (urlId.includes("-")) {
      urlId = urlId.split("-").pop();
    }
    urlId = urlId.replace(/(\d+)[#\D].*/, "$1");

    $(document).on("click", ".get_back", function () {
        $(this).closest(".confirm-box").hide();
      });
    
      $(document).on("click", ".confirm-backdrop", function () {
        $(this).closest(".confirm-box").hide();
      });

      $('#review_button').on('click', function(event) {
        let isValid = true;
        let errorMessage = '';
        let errorElement = $('#error-message');

        // Get form field values
        let name = $('#review_name').val().trim();
        let email = $('#review_email').val().trim();
        let phone = $('#review_phone').val().trim();
        let comment = $('#review_comment').val().trim();

        // Validate Name
        if (name === '') {
            isValid = false;
            errorMessage = 'Please enter your full name.';
        } 
        // Validate Email
        else if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        } 
        // Validate Phone
        else if (phone === '' || !/^\d{10}$/.test(phone)) {
            isValid = false;
            errorMessage = 'Please enter a valid 10-digit phone number.';
        } 
        // Validate Location
        // Validate Comment
        else if (comment === '') {
            isValid = false;
            errorMessage = 'Please enter a review.';
        }else  if (!$('input[name="rating"]:checked').val()) {
            isValid = false;
            errorMessage = 'Please give a rating by clicking on a star.';
        }

        // Show error message if validation fails
        if (!isValid) {
            event.preventDefault();
            errorElement.text(errorMessage).show();
        } else {
            errorElement.hide();
            $('#review_button').prop('disabled', true).text('Sending...');
            $('#reviewForm').submit();
        }
    });

    $('#review_academy_button').on('click', function(event) {
        event.preventDefault();
        let isValid = true;
        let errorMessage = '';
        let errorElement = $('#error-message');
    
        // Get form field values
        let name = $('#review_name').val().trim();
        let email = $('#review_email').val().trim();
        let phone = $('#review_phone').val().trim();
        let comment = $('#review_comment').val().trim();
        let rating = $('input[name="rating"]:checked').val(); // Get the selected rating
    
        // Validate Name
        if (name === '') {
            isValid = false;
            errorMessage = 'Please enter your full name.';
        } 
        // Validate Email
        else if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        } 
        // Validate Phone
        else if (phone === '' || !/^\d{10}$/.test(phone)) {
            isValid = false;
            errorMessage = 'Please enter a valid 10-digit phone number.';
        } 
        // Validate Comment
        else if (comment === '') {
            isValid = false;
            errorMessage = 'Please enter a review.';
        } 
        // Validate Rating
        else if (!rating) {
            isValid = false;
            errorMessage = 'Please give a rating by clicking on a star.';
        }
    
        // Show error message if validation fails
        if (!isValid) {
            errorElement.text(errorMessage).show();
        } else {
            errorElement.hide();        
            $.ajax({
                url: 'https://www.bookmyplayer.com/api/add-academy-review',
                type: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    rating: rating,
                    name: name,
                    email: email,
                    phone: phone,
                    comment: comment,
                    object_type: 'academy',
                    object_id: urlId
                },
                beforeSend: function() {
                    $('#review_academy_button').prop('disabled', true).text('Sending...');
                },
                success: function(response) {
                    $('#review_academy_button').prop('disabled', false).text('Post Review');

                    $("#customModalOverlay").hide("");
                    
                    if (response.status==1) {
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
                        $('#reviewForm')[0].reset();
                    }else{

                        let confirmBoxHtml = `
                        <div class="confirm-box" style="z-index: 1002;">
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
                        $('#reviewForm')[0].reset();

                    }
                },
                error: function(response) {
                    $('#review_academy_button').prop('disabled', false).text('Post Review');
                    console.log(response);
                }
            });
        }
    });


    



});




