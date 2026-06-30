<div class="mob_academy_training">

  <p class="fb_font message_head">Message to {{ $data['title'] }}</p>
  <div class="error_msg_new">
    <div id="error_message" style="display: none; color:red;"></div>
  </div>
  <div id="msg_form">
    <form id="contact_form" action="{{ route('submit.contact') }}" method="post">
      @csrf
      <input type="hidden" name="source" value="academy details">
      <input type="hidden" name="sport" value="{{ $data['d']->sport }}">
      <input type="hidden" name="sport_id" value="{{ $data['d']->sport_id }}">
      <input type="hidden" name="object_id" value="{{ $data['id'] }}">
      <input type="hidden" name="object_type" value="{{ $data['object_type'] }}">
      <input type="hidden" name="loc_id" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
      <input type="hidden" name="screen" value="message" required>
      <input type="hidden" name="latitude" id="latitude1">
      <input type="hidden" name="longitude" id="longitude1">
      <input type="text" name="name" class="fb_font message_input" placeholder="Enter Your Name" id="contact_name">
      <input type="number" name="phone" class="fb_font message_input" placeholder="Enter Your Phone Number" id="phone">
      <input type="email" name="email" class="fb_font message_input" placeholder="Enter Your Email" id="email">
      <textarea name="description" class="fb_font message_input" cols="15" rows="5" placeholder="Type Your Message" id="message"></textarea>
      <div class="send_btn">
        <button type="submit" id="message_to_btn" pattern=".*\S+.*" title="Please fill in all required fields">Send <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/send.svg" alt="send"></button>
      </div>
    </form>
  </div>
</div>