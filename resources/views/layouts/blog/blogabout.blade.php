<div class="display_col bd_display">
  @if(!$MOBILE)
   <div class="bd_img"><img src="{{ $data['blogImg'] }}" alt="{{ $data['title'] }}" loading="lazy" width="1093" height="615"></div>
   @else
   <div class="bd_img"><img src="{{ $data['blogImg'] }}" alt="{{ $data['title'] }}" loading="lazy" width="100" height="60"></div>
   @endif
   <div class="bd_para"><p class="fb_font">{{ $data['des'] }}</p></div>
