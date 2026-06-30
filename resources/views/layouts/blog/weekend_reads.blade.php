<!-- weekend reads section start -->
@php
    $currentcount = 40;
    $bloglen = count($data['blogs']);
@endphp

@foreach($data['categories'] as $category)
    @if($bloglen > $currentcount && $bloglen > $currentcount + 7)
        <div class="complex_design">
            <div class="blog_complex">
                <div>
                    <h2 class="fb_font sport_work">{{ $category }}</h2>
                </div>
                <div class="blog_again">
                    <div>
                        <div class="recent_blog_middle_2">
                            <div class="blog_complex_img">
                                <img src="{{ ( empty($data['blogs'][$currentcount+1]->image) || $data['blogs'][$currentcount+1]->image == "" || $data['blogs'][$currentcount+1]->image == null  ) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $data['blogs'][$currentcount+1]->image }}" loading="lazy" alt="blog">
                            </div>
                            <div class="blog_read blog_read_2">
                                <h3 class="fb_font blog_topic blog_topic_3">
                                    <a href="{{ 'https://www.bookmyplayer.com/blog/' . $data['blogs'][$currentcount+1]->url }}" target="_blank">
                                        {{ $data['blogs'][$currentcount+1]->title }}
                                    </a>
                                </h3>
                                <p class="fb_font blog_date blog_date_2">
                                {{ \Carbon\Carbon::parse($data['blogs'][$currentcount+1]->update_date)->format('F jS, Y g:i A T') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="last_complex new_last_complex">
                        @php
                            for ($i = 2; $i < 5; $i++) {
                        @endphp
                        <div class="recent_blog_middle_4">
                            <div class="blog_small_img">
                                <img src="{{ ( empty($data['blogs'][$currentcount+$i]->image) || $data['blogs'][$currentcount+$i]->image == "" || $data['blogs'][$currentcount+$i]->image == null  ) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $data['blogs'][$currentcount+$i]->image }}" loading="lazy" alt="blog">
                            </div>
                            <div class="blog_read blog_read_2">
                                <h3 class="fb_font blog_topic blog_topic_3">
                                    <a href="{{ 'https://www.bookmyplayer.com/blog/' . $data['blogs'][$currentcount+$i]->url }}" target="_blank">
                                        {{ $data['blogs'][$currentcount+$i]->title }}
                                    </a>
                                </h3>
                                <p class="fb_font blog_date blog_date_2">
                                {{ \Carbon\Carbon::parse($data['blogs'][$currentcount+$i]->update_date)->format('F jS, Y g:i A T') }}
                                </p>
                            </div>
                        </div>
                        @php
                            }
                        @endphp
                    </div>
                </div>
            </div>
            <div class="blog_down">
                @php
                    for ($i = 5; $i < 8; $i++) {
                @endphp
                <div class="recent_blog_middle recent_blog_middle_3 new_blog">
                    <div class="blog_side_complex_img">
                        <img src="{{ ( empty($data['blogs'][$currentcount+$i]->image) || $data['blogs'][$currentcount+$i]->image == "" || $data['blogs'][$currentcount+$i]->image == null  ) ? env('AWS_S3_BASE_URL') . '/default/default_blog_image.webp' : env('AWS_S3_BASE_URL') . '/blog/' . $data['blogs'][$currentcount+$i]->image }}" loading="lazy" alt="blog">
                    </div>
                    <div class="blog_read blog_read_2">
                        <h3 class="fb_font blog_topic blog_topic_3 new_topic">
                            <a href="{{ 'https://www.bookmyplayer.com/blog/' . $data['blogs'][$currentcount+$i]->url }}" target="_blank">
                                {{ $data['blogs'][$currentcount+$i]->title }}
                            </a>
                        </h3>
                        <p class="fb_font blog_date blog_date_2">
                        {{ \Carbon\Carbon::parse($data['blogs'][$currentcount+$i]->update_date)->format('F jS, Y g:i A T') }}
                        </p>
                    </div>
                </div>
                @php
                    }
                @endphp
            </div>
        </div>
    @endif
    @php
        $currentcount += 7; // Increment by 7
    @endphp
@endforeach
<!-- weekend reads section end -->
