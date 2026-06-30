@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/about.min.css') }}" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('asset/js/about_v1.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<!-- about us banner  -->
<section class="dsktp_about_section">
   <div class="dsktp_banner">
      <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/about.webp" alt="about banner" width="100%" height="450">
      <div>
         <h1 class="fb_font dsktp_about_heading">About <span class="red_color">Us</span></h1>
      </div>
      <!-- 
      <div class="dsktp_text">
         <p class="fb_font dsktp_info">a community of</p>
         <p class="fb_font dsktp_info_2">18000+ players, 1200+</p>
         <p class="fb_font dsktp_info_2">coaches, 2800+ academies</p>
      </div> -->
   </div>
</section>
<!-- about us banner ends -->
<!-- voice of victory section  -->
<!-- <section class="dsktp_voice_victory">
   <h2 class="fb_font">Voices of victory Real Stories from Our Community</h2>
   <div class="victory_wrapper">
      <div class="victory_div">
         <div class="dsktp_reviewer">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/person.jpg" loading="lazy" alt="person">
         </div>
         <div class="dsktp_review">
            <div class="dsktp_para">
               <p class="fb_font dsktp_review_name">Sanjay (Football Player)</p>
               <div class="dsktp_stars">
                  <p>5.0</p>
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white-star.svg" loading="lazy" alt="star">
               </div>
            </div>
            <div class="dskt_review_text">
               <p class="fb_font">
                  Discovering Udaan Academy via BookMyPlayer truly transformed my athletic journey. Exceptional coaching and superb facilities elevated my skills to new levels.
               </p>
            </div>
         </div>
      </div>
      <div class="victory_div">
         <div class="dsktp_reviewer">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/person.jpg" loading="lazy" alt="person">
         </div>
         <div class="dsktp_review">
            <div class="dsktp_para">
               <p class="fb_font dsktp_review_name">Ajay (Football Player)</p>
               <div class="dsktp_stars">
                  <p>5.0</p>
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white-star.svg" loading="lazy" alt="star">
               </div>
            </div>
            <div class="dskt_review_text">
               <p class="fb_font">
                  Joining Rising Star Academy through BookMyPlayer was a turning point in my career. The expert coaching helped me achieve new personal bests.
               </p>
            </div>
         </div>
      </div>
      <div class="victory_div">
         <div class="dsktp_reviewer">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/person.jpg" loading="lazy" alt="star">
         </div>
         <div class="dsktp_review">
            <div class="dsktp_para">
               <p class="fb_font dsktp_review_name">Mahesh (Football Player)</p>
               <div class="dsktp_stars">
                  <p>5.0</p>
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white-star.svg" loading="lazy" alt="star">
               </div>
            </div>
            <div class="dskt_review_text">
               <p class="fb_font">Joining fast Fc Club through BookMyPlayer was a career milestone. Personalized coaching and top-notch facilities significantly boosted my performance.
               </p>
            </div>
         </div>
      </div>
      <div class="victory_div">
         <div class="dsktp_reviewer">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/person.jpg" loading="lazy" alt="person">
         </div>
         <div class="dsktp_review">
            <div class="dsktp_para">
               <p class="fb_font dsktp_review_name">Anant (Football Player)</p>
               <div class="dsktp_stars">
                  <p>5.0</p>
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white-star.svg" loading="lazy" alt="star">
               </div>
            </div>
            <div class="dskt_review_text">
               <p class="fb_font">
                  BookMyPlayer simplifies booking sports facilities and coaches—efficient, user-friendly, and a game-changer for athletes..
               </p>
            </div>
         </div>
      </div>
      <div class="carousel-dots">
         <span class="dot active"></span>
         <span class="dot"></span>
         <span class="dot"></span>
         <span class="dot"></span>
      </div>
   </div>
   <div class="dsktp_badge">
      <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blue_badge.svg" loading="lazy" alt="" width="14" height="14">
      <span class="fb_font">BookMyPlayer is based on the trust of the community</span>
   </div>
</section> -->
<!-- voice of victory section ends -->
<!-- journey section  -->
<section class="our_journey">
   <div class="journey_heading">
      <h2 class="fb_font">Journey of <span>BookMyPlayer</span></h2>
   </div>
   <div class="journey_flex">
      <div class="side_red_point">
         <div class="red_dot"></div>
         <div class="grey_line"></div>
      </div>
      <div class="journey_points">
         <h3 class="the_idea">The Idea</h3>
         <span class="fb_font idea_text"><span>BookMyPlayer's</span> remarkable journey traces back to a young
            and passionate 16-year-old named Evan. As an avid sports enthusiast and aspiring athlete himself, he
            intimately understood the struggles faced by both talented players and sports clubs when it came to
            recruitment.</span>
      </div>
   </div>
   <div class="journey_flex">
      <div class="side_red_point">
         <div class="red_dot"></div>
         <div class="grey_line"></div>
      </div>
      <div class="journey_points">
         <h3 class="the_idea">The Problem</h3>
         <span class="fb_font idea_text">Evan observed the traditional scouting process and realized its
            limitations. Geographic barriers, slow communication, and the reliance on intermediaries often
            hindered talented athletes from gaining the visibility they deserved. At the same time, clubs faced
            challenges in efficiently discovering and connecting with potential players who would enhance their
            teams.</span>
      </div>
   </div>
   <div class="journey_flex">
      <div class="side_red_point">
         <div class="red_dot"></div>
         <div class="grey_line"></div>
      </div>
      <div class="journey_points">
         <h3 class="the_idea">The Solution</h3>
         <span class="fb_font idea_text">Determined to make a difference, Evan formulated a visionary idea to
            create a platform that would revolutionize the sports recruitment landscape. He envisioned a space
            where players could showcase their skills, achievements, and potential directly to interested clubs,
            eliminating the barriers that hindered effective talent discovery.</span>
      </div>
   </div>
   <div class="journey_flex">
      <div class="side_red_point">
         <div class="red_dot"></div>
         <div class="grey_line"></div>
      </div>
      <div class="journey_points">
         <h3 class="the_idea">features</h3>
         <span class="fb_font idea_text">BookMyPlayer's innovation lay in its direct communication capabilities.
            Players could create detailed profiles, upload videos highlighting their talents, and reach out to
            clubs directly. Conversely, clubs gained access to a diverse pool of talent, allowing them to search
            for players who perfectly matched their requirements.</span>
      </div>
   </div>
   <div class="journey_flex">
      <div class="side_red_point">
         <div class="red_dot"></div>
      </div>
      <div class="journey_points">
         <h3 class="the_idea">how it’s going</h3>
         <span class="fb_font idea_text">The journey of BookMyPlayer is ongoing. As it gains momentum and
            recognition, Evan and his team remain dedicated to refining the platform, expanding its reach, and
            fostering a community where talent truly meets opportunity.</span>
      </div>
   </div>
</section>
<!-- journey section ends -->
<!-- founder section  -->
<section class="founder">
   <h2 class="fb_font">Meet The Founder</h2>
   <div class="founder_div">
      <div class="founder_left">
         <div>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/founder.png" loading="lazy" alt="" width="80" height="80">
         </div>
         <div class="founder_details">
            <span class="fb_font">Evan Gupta</span>
            <span class="fb_font">Ceo & Founder</span>
         </div>
      </div>
      <div class="founder_msg">
         <span class="fb_font founder_msg_txt">“Together, let's revolutionize the way talent is discovered and
            nurtured, and pave the way for a new generation of sporting champions.”</span>
      </div>
   </div>
   <h2 class="fb_font">Our Address</h2>
   <div class="about-container">
    <div id="about-address" class="about-address">
      <p><strong>Address:</strong> 91Springboard, Building Number 145, Sector 44 Rd, Sector 44, Gurugram, Haryana 122003</p>
      <p><strong>Nearest Metro:</strong> Huda Metro Station</p>
    </div>
    <div id="about-map" class="about-map">
      <iframe 
        src="https://www.google.com/maps?q=91Springboard,+Building+Number+145,+Sector+44+Rd,+Sector+44,+Gurugram,+Haryana&output=embed" 
        allowfullscreen>
      </iframe>
    </div>
  </div>
 </section>

@endsection

