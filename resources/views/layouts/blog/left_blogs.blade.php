<!-- left blog section start -->
<div class="blogs_on_left">
               @foreach($data['blogs']->slice(26, 14) as $blog)
               <div class="blog_read">
               <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" target="_blank">
                     <h3 class="fb_font blog_topic">{{ $blog->title }}</h3>
                     <p class="fb_font blog_date">{{ \Carbon\Carbon::parse($blog->update_date)->format('F jS, Y g:i A T') }}</p>
                     <p class="fb_font blog_para">{{ $blog->description }}</p>
                  </a>
               </div>
               @endforeach
            </div>
</div>
<!-- left blog section end -->
