<section class="blog_top">
        <div class="blog_head_new">
            <h1 class="fb_font details_top">
                {{ $data['title'] }}
            </h1>
        </div>
        <div class="blog_details_flex">
      <div>
         <div class="img_section">
            <div class="founder_img">
               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/founder.png" alt="founder">
            </div>
            <div class="written_by written_1">
               <p class="fb_font written_new">By</p>
               <p class="fb_font writer_name">Evan Gupta <span>({{$data['timeToRead']}} minute read)
                  </span>
               </p>
               <p class="fb_font writer_date">
                  Published {{ $data['creationDate'] }}
               </p>
            </div>
         </div>
      </div>
      <div>
         <div class="bd_share">
            <h5 class="fb_font">Share this blog on</h5>
         </div>
         <div class="bd_social">
            <a href="https://www.facebook.com/bookmyplayer.com.in"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/new_fb.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/bookmyplayerofficial/"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/new_insta.png" alt="Instagram"></a>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/new_twitter.png" alt="Twitter">
            <a href="https://www.linkedin.com/company/bookmyplayer/"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/new_linkedin.png" alt="Linkedin"></a>
         </div>
      </div>
   </div>
    </section>
