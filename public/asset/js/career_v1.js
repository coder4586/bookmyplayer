$(document).ready(function () {

    function validateForm(positionId) {
        let isValid = true;
        const name = $(`#name-${positionId}`).val();
        const email = $(`#email-${positionId}`).val();
        const phone = $(`#phone-${positionId}`).val();
        const linkedinUrl = $(`#linkedin-${positionId}`).val();
        const resume = $(`#resume-upload-${positionId}`)[0].files[0];
        

        if (!name) {
            isValid = false;
            showError("Full Name is required.", positionId);
        }

        else if (!email) {
            isValid = false;
            showError("Email is required.", positionId);
        } else if (!validateEmail(email)) {
            isValid = false;
            showError("Please enter a valid email.", positionId);
        }

        else if (!phone) {
            isValid = false;
            showError("Phone Number is required.", positionId);
        } else if (!validatePhone(phone)) {
            isValid = false;
            showError("Please enter a valid phone number.", positionId);
        }

        else if (!resume) {
            isValid = false;
            showError("Resume is required.", positionId);
        }else {
            clearError();
        }
        
        return isValid;
    }

    // Validate Email Format
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return emailPattern.test(email);
    }

    // Validate Phone Format
    function validatePhone(phone) {
        const phonePattern = /^[0-9]{10}$/;
        return phonePattern.test(phone);
    }

    // Show Error Message
    function showError(message, positionId) {
        $(`#error-message-${positionId}`).text(message).show();
    }

    // Clear Error Message
    function clearError() {
        $(".error-message").hide();
    }

    // Display file name after upload
    function displayFileName(input, fileNameId) {
        const file = input.files[0];
        if (file) {
            $(`#${fileNameId}`).text(file.name);
        }
    }

    // Handle form submission
    $(".apply-job-button").on("click", function () {
        const positionId = $(this).data("id");
        const resume = $(`#resume-upload-${positionId}`)[0].files[0];

        if (!validateForm(positionId)) {
            return;
        }

        const formData = new FormData();
        formData.append('position_id', positionId);
        formData.append('name', $(`#name-${positionId}`).val());
        formData.append('email', $(`#email-${positionId}`).val());
        formData.append('phone', $(`#phone-${positionId}`).val());
        formData.append('resume', resume);
        formData.append('linkedin_url', $(`#linkedin-${positionId}`).val());
        formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: '/api/apply-job',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // Disable the button and change text to "Sending..."
                $(".career_btn button").prop("disabled", true).text("Sending...");
            },
            success: function (response) {
                let confirmBoxHtml = "";
                const statusImage = response.status === 1 ? "success.gif" : "error.gif";

                confirmBoxHtml = `
                    <div class="confirm-box" style="z-index: 10;">
                        <div class="confirm-backdrop"></div>
                        <div class="confirm-content">
                            <div class="confirm-body">
                                <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/${statusImage}" class="img-fluid" alt=""></figure>
                                <h6>${response.message}</h6>
                            </div>
                            <div class="confirm-footer">
                                <button class="get_back btn btn-secondary">Go Back</button>
                            </div>
                        </div>
                    </div>
                `;
                $("body").append(confirmBoxHtml);
        
                $(".career_btn button").prop("disabled", false).text("Submit");
                
                    resetForm(positionId);
            },
            error: function (error) {
                console.error(error);
                $(".career_btn button").prop("disabled", false).text("Submit");
            }
        });
        
    });


    $(".apply-button").on("click", function () {
        const id = $(this).data("id");
        const detailsRow = $(`#details-${id}`);

        $(".career-details-row").not(detailsRow).hide();

        if (detailsRow.is(":visible")) {
            detailsRow.hide();
        } else {
            detailsRow.show();
        }
    });


    function resetForm(positionId) {
        $(`#name-${positionId}`).val('');
        $(`#email-${positionId}`).val('');
        $(`#phone-${positionId}`).val('');
        $(`#linkedin-${positionId}`).val('');
        $(`#file-name-${positionId}`).text('');
        $(`#resume-upload-${positionId}`).val('');
        $("#error-message-" + positionId).text('').hide();
    }

    function displayFileName(input, spanId) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            $("#" + spanId).text(fileName);
        } else {
            $("#" + spanId).text("");
        }
    }

    $("[id^=resume-upload-]").on("change", function () {
        const positionId = $(this).attr("id").split("-").pop();
        displayFileName(this, "file-name-" + positionId);
    });

});


