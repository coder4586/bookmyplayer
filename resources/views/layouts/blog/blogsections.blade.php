<div class="privacy_table">
   <div class="bd_content">
      <h3 class="fb_font privacy_content">In this blog we’ll cover</h3>
   </div>
   <div class="privacy_list">
      <ol type="number">
         @foreach($data['blogDetails'] as $blogDetail)
         <li><a href="#{{ $blogDetail->section }}">{{ $blogDetail->heading }}</a></li>
         @endforeach
      </ol>
   </div>
</div>
<div>
   @foreach($data['blogDetails'] as $blogDetail)
   <div id="incident">
      <div class="bd_incident_heading">
         <h3 class="fb_font bd_incident">{{ $blogDetail->heading }}</h3>
      </div>
      @if($blogDetail->image)
      <img src="{{ env('AWS_S3_BASE_URL') }}/blog/{{ $blogDetail->image }}"
         loading="lazy" alt="Blog images" class="img-fluid rounded">
      @endif
      <div class="dbd_desc_top">
         <p class="fb_font bd_desc">{!! $blogDetail->section !!}</p>
      </div>
   </div>
   @endforeach
</div>