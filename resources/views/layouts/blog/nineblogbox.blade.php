<!-- weekend reads section start -->
@php
    $currentcount = 20;
    $bloglen = count($data['blogs']);
@endphp

@foreach($data['ninesectioncat'] as $category)
@if($bloglen > $currentcount && $bloglen > $currentcount + 9)
<div class="complex_design">
   <div class="blog_complex">
      <div>
         <h2 class="fb_font sport_work">{{ $category }}</h2>
      </div>
   </div>
   <div class="blog_down">
      @foreach($data['blogs']->slice($currentcount, 9) as $blog)
      <div class="recent_blog_middle recent_blog_middle_3 new_blog">
         <div class="blog_side_complex_img">
            <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" target="_blank">
            <img src="{{ (empty($blog->image) || $blog->image == "" || $blog->image == null) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $blog->image }}" loading="lazy" alt="blog">
            </a>
         </div>
         <div class="blog_read blog_read_2">
            <a href="">
               <h3 class="fb_font blog_topic blog_topic_3 new_topic">
                  {{ $blog->title }}
               </h3>
            </a>
            <p class="fb_font blog_date blog_date_2">
               {{ \Carbon\Carbon::parse($blog->update_date)->format('F jS, Y g:i A T') }}
            </p>
         </div>
      </div>
      @endforeach
   </div>
</div>
@endif
@php
   $currentcount += 9; // Increment by 9
@endphp
@endforeach

</div>
