@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/contact.min.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/contact.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<header class="contact_header">
<img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/contact.webp" alt="Contact US" class="contact_banner_image" />
</header>
<!--  section ends -->

<!-- main section  -->
<main class="contact_body">
   <h3 class="contact_message">Send a Message</h3>
   <form id="contactForm" class="contact_form" action="{{ route('submit.contact.ticket') }}" method="post">
      @csrf
      <input type="hidden" name="req_type" value="contact_support">
      <input type="hidden" name="latitude" id="latitude1">
      <input type="hidden" name="longitude" id="longitude1">
      <input type="text" name="name" class="contact_input name_input" placeholder="Full Name *">
      <span id="nameError" class="error"></span>

      <input type="text" name="email" class="contact_input" placeholder="Email *">
      <span id="emailError" class="error"></span>

      <input type="number" name="phone" class="contact_input" placeholder="Phone *">
      <span id="phoneError" class="error"></span>

      <select name="category" id="" class="query_type contact_input">
      <option value="" disabled selected style="display:none;">Type Of Query *</option>
         <option value="registration_issue">Registration Issue (Academy/Coach/Player).</option>
         <option value="login_issue">Login to my account Issue.</option>
         <option value="more_information">I want to join the academy. Need more information. (Please mention Academy name, your address and Sport).</option>
         <option value="owner_profile_manage">I am owner of Academy, need to login and manage my academy profile.</option>
         <option value="bmp_register">I want to Register on BookmyPlayer. (Please share your details in message box below and we will contact you).</option>
      </select>
      <span id="queryTypeError" class="error"></span>

      <textarea rows="4" cols="50" name="description" class="contact_input" placeholder="How can we help you? *"></textarea>
      <span id="descriptionError" class="error"></span>

      <button id="contact_submit_btn" type="submit" class="contact_submit_btn">Send</button>
   </form>

</main>

<!-- main section ends -->
<!-- contact bottom  -->
<section class="contact-bottom">
   <div class="contact-bottom-div">
      <div class="contact-bottom-img">
         <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/fi_2024074.svg" loading="lazy" alt="speed" class="speed-img" />
      </div>
      <h3 class="speed-title">Speed</h3>
      <span class="speed-text-container">
         <p class="speed-text">
            We’ll answer you within a day, as fast as lightning
         </p>
      </span>
   </div>
   <div class="contact-bottom-div">
      <div class="contact-bottom-img">
         <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/fi_9131566.svg" loading="lazy" alt="trust" class="speed-img" />
      </div>
      <h3 class="speed-title">Trust</h3>
      <span class="speed-text-container">
         <p class="speed-text">
            We’ll answer you within a day, as fast as lightning
         </p>
      </span>
   </div>
   <div class="contact-bottom-div">
      <div class="contact-bottom-img">
         <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/fi_6878320.svg" loading="lazy" alt="availibility" class="speed-img" />
      </div>
      <h3 class="speed-title">Availibility</h3>
      <span class="speed-text-container">
         <p class="speed-text">
            We’ll answer you within a day, as fast as lightning
         </p>
      </span>
   </div>
</section>


@endsection
