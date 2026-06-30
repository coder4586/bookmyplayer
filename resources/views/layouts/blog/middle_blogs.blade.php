<!-- middle blog section start -->

<div class="blog_middle">
            <div><h1 class="fb_font blog_top_head">Recent Blogs</h1></div>

    @foreach($data['blogs']->slice(0, 7) as $blog)
    <div class="recent_blog_middle">

   <div class="blog_recent_img">
   <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" target="_blank">
                     <img src="{{ (empty($blog->image) || $blog->image == "" || $blog->image == null) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $blog->image }}" loading="lazy" alt="blog">
                  </a>
               </div>
               <div class="blog_read blog_read_2">
                  <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" class="heading" target="_blank">
                     <h3 class="fb_font blog_topic blog_topic_new">{{ $blog->title }}</h3>
                  </a>
                  <p class="fb_font blog_date blog_date_2">{{ \Carbon\Carbon::parse($blog->update_date)->format('F jS, Y g:i A T') }}</p>
                  <p class="fb_font blog_para_2">{{ $blog->description }}</p>
               </div>
               </div>
    @endforeach


         </div>
</div>

<!-- middle blog section end -->
