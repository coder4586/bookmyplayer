<!-- FAQ section -->
@if(count($data['faqs'])>0)
<section class="fb_blogs_section fb_faq">
  <div class="main_faq">
    @foreach ($data['faqs'] as $faq)
      @if ($faq->title == 2)
        <div class="faq_top">
          <h2 class="fb_font">Average Fee for {{ ucfirst($data['d']->sport) }} Coaching in India</h2>
          <p>{!! $faq->question !!}</p>
        </div>
      @endif
    @endforeach

    @foreach ($data['faqs'] as $faq)
      @if ($faq->title == 1)
        <div class="faq_top">
          <h2 class="fb_font">{{ $faq->question }}</h2> 
        </div>
      @endif
    @endforeach

    @php $serial = 0; @endphp
    @foreach($data['faqs'] as $faq)
      @if ($faq->title == 0)
        @php $serial++; @endphp
        <div class="fb_blog_flex">
          <div class="fb_blog_card">
            <div class="faq_content">
              <div class="faq_item">
                <p class="fb_font"><strong>{{ $serial }}. {{ $faq->question }}</strong></p>
                <p class="fb_font">{{ $faq->answer }}</p>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>
</section>
@endif
<!-- FAQ section ends -->
