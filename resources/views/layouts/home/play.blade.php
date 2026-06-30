<section class="select-sport-section clearfix">
    <div class="container">
    <div class="top_flex">
            <h2>We got you covered in 50+ Sports</h2>
            <div class="slider_arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left2" class="lazy" alt="arrow">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right2" class="lazy" alt="arrow">
            </div>
        </div>
        <div class="loader_img mt-3">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader">
        </div>
        <div class="sport-js mt-4">
            @if(isset($data['sports']) && !empty($data['sports']))
                @foreach ($data['sports'] as $index => $sport)
                @php
                // Calculate the image number, cycling from 1 to 6
                $imageNumber = ($index % 6) + 1;
                @endphp
                <div class="item">
                    <div class="sport_card hidden">
                    <a href="{{ $sport->url }}">
                        <div class="color-box01 inner-box sport_box">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/select-sport-img-{{ $imageNumber }}.png" loading="lazy" alt="Sports Image" height="50" width="50">
                            <span>{{ $sport->name }}</span>
                        </div>
                    </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
