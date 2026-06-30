<!-- Blog right section start -->
<div class="blog_right bd_right">

<div class="blog_right_2">
    <div>
        <h2 class="fb_font blog_top_head">Most Popular</h2>
    </div>

    @foreach($data['blogs']->slice($min, $max) as $blog)
        <div class="recent_blog_middle">
            <div class="blog_side_img">
                <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" target="_blank">
                <img src="{{ (empty($blog->image) || $blog->image == "" || $blog->image == null) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $blog->image }}" loading="lazy" alt="blog">
                </a>
            </div>
            <div class="blog_read blog_read_2">
                <a href="https://www.bookmyplayer.com/blog/{{ $blog->url }}" class="heading" target="_blank">
                    <h3 class="fb_font blog_topic blog_topic_2">
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
<!-- Blog right section end -->
