
<section class="subscription-section clearfix">
    <div class="container">
        <div class="newsletter-section">
            <div class="row d-flex align-items-center">
              @if(session('sub_success'))
              <div class="alert alert-success">
                 {{ session('sub_success') }}
              </div>
              @endif
              @if(session('sub_error'))
              <div class="alert alert-danger">
                 {{ session('sub_error') }}
              </div>
              @endif
                <div class="col-lg-6">
                    <h3>Join BookMyPlayer Now</h3>
                    <p>Join Us now if you are a player and need a boost in your career</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('bmp.subscribe') }}" method="post">
                        @csrf
                        <div class="form-box">
                            <input type="email" name="email" id="" placeholder="Enter Your email address">
                            <input type="submit" class="btn btn-secondary" value="Subscribe">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
<section class="social_box">
    <p class="new_fonts">{{ session('success') }}</p>
    <div class="img_flex">
        <a href="https://www.instagram.com/bookmyplayer/">
            <img src="{{env('AWS_S3_BASE_URL')}}/asset/images/Group 49 (1).svg" loading="lazy" alt="instagram">
        </a>
        <a href="https://www.linkedin.com/company/bookmyplayer/">
            <img src="{{env('AWS_S3_BASE_URL')}}/asset/images/Group 50.svg" loading="lazy" alt="linkedin">
        </a>
    </div>
</section>
@endif

<!-- FOOTER SECTION -->
<footer class="footer-section clearfix">
    <div class="container">
        <div class="top-section d-none d-md-block">
            <figure><img src="{{env('AWS_S3_BASE_URL')}}/asset/images/logo 1.svg" loading="lazy" width="130" height="20" alt="logo"></figure>
            <p>Unleash your potential. Connect with sports world. Start your athletic journey today!</p>
        </div>
        <div class="mid-section">
            <div class="row">
                <div class="col-lg-2 col-md-3 d-none d-lg-block d-md-block">
                    <h6>Quick Links</h6>
                    <ul class="links">
                        <li><a href="/" >Home</a></li>
                        <li><a href="/about" >About</a></li>
                        <li><a href="/blogs" >Blogs</a></li>
                        <li><a href="/contact" >Contact</a></li>
                        <li><a href="/contact" >Support</a></li>
                        <li><a href="/buy-our-services" >Buy Our Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 d-none d-lg-block d-md-block">
                    <h6>Top Sports</h6>
                    <ul class="links">
                        <li><a href="https://www.bookmyplayer.com/cricket-sdid-3" >Cricket</a></li>
                        <li><a href="https://www.bookmyplayer.com/football-sdid-1" >Football</a></li>
                        <li><a href="https://www.bookmyplayer.com/basketball-sdid-2" >Basketball</a></li>
                        <li><a href="https://www.bookmyplayer.com/badminton-sdid-6" >Badminton</a></li>
                        <li><a href="https://www.bookmyplayer.com/kabaddi-sdid-10" >Kabaddi</a></li>
                        <li><a href="https://www.bookmyplayer.com/mma-sdid-9" >MMA</a></li>
                        <li><a href="https://www.syntraflow.cloud" >AI Process Automation Tool</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 d-none d-lg-block d-md-block">
                    <h6>Top Cities</h6>
                    <ul class="links two-columns">
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-delhi-delhi-locid-1" >Delhi</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-mumbai-maharashtra-locid-2" >Mumbai</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-bangalore-karnataka-locid-4" >Bengaluru</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-gurgaon-haryana-locid-60" >Gurgaon</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-noida-uttar-pradesh-locid-82" >Noida</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-hyderabad-telangana-locid-6" >Hyderabad</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-chennai-tamil-nadu-locid-5" >Chennai</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-pune-maharashtra-locid-7" >Pune</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-kochi-kerala-locid-75" >Kochi</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-chandigarh-chandigarh-locid-49" >Chandigarh</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-jaipur-rajasthan-locid-12" >Jaipur</a></li>
                        <li><a href="https://www.bookmyplayer.com/sports-training-in-kolkata-west-bengal-locid-3" >Kolkata</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-12 get-in-touch">
                <h6>Get In Touch</h6>
                    <ul class="links">
                    <li><i class="fa-regular fa-envelope"></i>
                    care@bookmyplayer.com</a></li>
                    </ul>
                    <ul class="socials">
                        <li><a href="https://www.facebook.com/bookmyplayerofficial"  rel="noopener noreferrer"><img src="{{env('AWS_S3_BASE_URL')}}/asset/images/footer_fb.png" loading="lazy" alt="Facebook" width="10" height="19"></a></li>
                        <li><a href="https://www.youtube.com/@bookmyplayer"  rel="noopener noreferrer"><img src="{{env('AWS_S3_BASE_URL')}}/asset/images/footer_youtube.png" loading="lazy" alt="Youtube" width="28" height="28"></a></li>
                        <li><a href="https://www.instagram.com/bookmyplayer/"  rel="noopener noreferrer"><img src="{{env('AWS_S3_BASE_URL')}}/asset/images/footer_insta.png" loading="lazy" alt="Instagram" width="16" height="16"></a></li>
                        <li><a href="https://www.linkedin.com/company/bookmyplayer"  rel="noopener noreferrer"><img src="{{env('AWS_S3_BASE_URL')}}/asset/images/footer_linkedin.png" loading="lazy" alt="Linkedin" width="16" height="16"></a></li>
                    </ul>
                     <div>
                        <p style="color:fff; font-size:10px; margin-top:1rem;">BookMyPlayer does not charge any fees or commissions for connecting players with academies or coaches. Please independently verify all details and exercise caution when dealing with academies and coaches to ensure legitimacy and avoid potential disputes.</p>
                     </div>
                </div>
            </div>
        </div>
        <div class="bot-section">
            <div class="row">
                <div class="col-lg-6 col-md-5">
                    <ul>
                        <li><a href="/privacy">Privacy</a></li>
                        <li><a href="/terms">Terms</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-7">
                    <p>© 2025 by <a href="/"><strong>BookMyPlayer.com</strong></a> All Rights and Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /FOOTER SECTION -->
