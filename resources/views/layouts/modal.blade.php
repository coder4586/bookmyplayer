<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="popup_message_model" role="document">
    <div id="popup_content" class="modal-content p-4">
      <div class="modal-header" id="modalHeader">
        <h5 class="modal-title" id="exampleModalLongTitle">Message to <span id="entity"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
          style="background:none; border:none">
          <span aria-hidden="true"> <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" loading="lazy" alt="close"
              width="25" height="25"></span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="objectId" name="object_id">
        <input type="hidden" id="sport" name="sport">
        <input type="hidden" id="object_type" name="object_type">
        <input type="hidden" name="screen" value="popup">
        <div style="position:relative;margin-bottom:20px;">
          <div id="error_popup_msg" style="position:absolute; top:-15px; left:0; display:none; color:red"></div>
        </div>
        <input type="text" name="name" id="popup_username" placeholder="Enter Your Name" class="form-control"
          style="box-shadow:none; margin-bottom:1rem;" required>
        <input name="phone" id="popup_phone" placeholder="Enter Phone Number" class="form-control"
          style="-moz-appearance: textfield; box-shadow:none; margin-bottom:1rem;" required pattern="\S.*"
          title="Please enter a non-empty value">
        <input name="email" id="popup_email" placeholder="Enter Your Email" class="form-control"
          style="-moz-appearance: textfield; box-shadow:none; margin-bottom:1rem;" required pattern="\S.*"
          title="Please enter a non-empty value">
        <textarea rows="5" name="description" id="popup_description" placeholder="Type Your Message"
          class="form-control" style="box-shadow:none; margin-bottom:1rem;" required></textarea>

          <div>
            <span class="check_mail">Please check your email after successful submission.</span>
          </div>
      </div>

      <div class="alert alert-danger mb-0" role="alert" style="display:none;" id="error_div">
        <span id="error_msg" style="color:red;"></span>
      </div>
      <div class="modal-footer">
        <button id="btn_sendmsg" class="btn text-white" style="background-color: tomato;">Send</button>
      </div>
      <div id="loader" style="display:none;">Loading...</div>
    </div>

    <div class="modal-body" id="message_model" style="display: none;">
      <div class="card p-2" id="messageCard">
        <div class="card-body" id="messageCardBody">
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
