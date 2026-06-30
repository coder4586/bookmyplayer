
@if(count($data['nearbyacademies']) > 0)
<!-- <link href="{{ asset('asset/css/sdid_locality_v4.min.css') }}" rel="stylesheet"> -->
<div class="other_nearby_academy">
  <h2 class="near_by_heading">Other {{$data['d']->sport ? $data['d']->sport : ""}} Academies to consider in {{$data['d']->city ? $data['d']->city : ""}}</h2>

  @foreach($data['nearbyacademies'] as $academy)
  @if($academy->name !== $data['d']->name)
  <div class="col-12 gap list-menu">
   <div class="listing_wrapper">
      <div class="listing_box">
         <div class="listing_img">
            <div class="carousel">
               <div class="carousel_images">
                  <a target="_blank" href="{{$academy->url}}">
                     @if (!empty($academy->photos))
                     @foreach (explode(',', $academy->photos) as $index => $photo)
                     @php
                     $imageUrl = env('AWS_CF_BASE_URL') ."/academy/{$academy->id}/{$photo}";
                     @endphp
                     <img src="{{ $imageUrl }}" loading="lazy" alt="Listing Image" class="list_img{{ $index === 0 ? ' active_img' : '' }}">

                     @endforeach
                     @else
                     <img src="{{ env('AWS_S3_BASE_URL') }}/default/{{ $academy->sport }}_banner.webp" loading="lazy" alt="{{ $academy->name }} photo" class="list_img active_img">
                     @endif
                  </a>
               </div>
               <div class="carousel_dots">
                  @php
                  $photos = !empty($academy->photos) ? explode(',', $academy->photos) : [];
                  @endphp

                  @if (count($photos) > 1)
                  @foreach ($photos as $index => $photo)
                  <span class="dot{{ $index === 0 ? ' active_img' : '' }}"></span>
                  @endforeach
                  @endif
               </div>
               <div class="carousel_contacts">
                  <div><span class="">⭐ {{$academy->views == null ? 0 : $academy->views}} people viewed since last week.</span></div>
                  <div><span class="contact_count">1/3</span></div>
               </div>
            </div>
            <div>
               <div class="verify_flex">
                  <div class="verified_tick">
                     <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white_tick.png" loading="lazy"  alt="verify" height="24" width="24">
                     <span>Verified</span>
                  </div>
                  <div class="coach_sport">
                     <span>Academy</span>
                  </div>
               </div>

               <div class="heart_fav">
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/heart.svg" loading="lazy"  alt="heart">
               </div>
            </div>
         </div>
         <div class="list_down">
            <div class="list_top">
               <a target="_blank" href="{{$academy->url}}">
                  <h2>{{$academy->name}}</h2>
               </a>
            </div>
            <div>
               <div class="fb_star_section fb_flex_version">

               <div class="graph_flex">

               <div class="graph_view">
                     <div class="rating_num">
                        <span class="rating_value">{{$academy->rating ? $academy->rating :"0"}} ★</span>
                     </div>
                     <div class="total_rating_width">
                     <span class="fb_font total_ratings">{{$academy->reviews}} Reviews</span>
                     </div>

                     <div class="line">|</div>
                  </div>
                  <div class="price_month">
                     <span>
                        ₹{{ $academy->fee ? $academy->fee : ($academy->default_pricing ? $academy->default_pricing : 1100) }}
                     </span>
                  </div>
               </div>



                  <div class="coach_academy">
                     <span>{{ ucfirst($academy->sport) }}</span>
                  </div>
               </div>
               <div class="list_location">
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location_mob.svg" loading="lazy" alt="location">
                  <span class="fb_font location_add"><span class="distance_km">({{ number_format($academy->distance, 2, '.', '')}} km)</span>{{implode(', ', array_filter([$academy->address1, $academy->address2, $academy->city, $academy->state, $academy->postcode]))}}</span>
               </div>
               <div class="extra_info">
                  <div class="extra_sport">
                     <span>Kids</span>
                  </div>
                  <div class="extra_sport">
                     <span>Coaching</span>
                  </div>
                  <div class="extra_sport">
                     <span>Women Friendly</span>
                  </div>
                  <div class="extra_sport">
                     <span>Admission Open</span>
                  </div>
               </div>
               <div class="down_menu">
                  <div class="logo_details">
                     <div class="mini_logo">
                        <img src="{{ (is_null($academy->logo) || $academy->logo === "") ? env('AWS_S3_BASE_URL') . '/default/academy_default_logo.webp' : env('AWS_S3_BASE_URL') . '/academy/' . $academy->id . '/' . $academy->logo }}" loading="lazy" alt="logo">
                     </div>
                     <div class="logo_info">
                        <span>1 w ago</span>
                        <span>Featured</span>
                        <span>{{$academy->name}}</span>
                     </div>
                  </div>
                  <div class="list_btn">
                     <div class="white_whatsapp"><a target="_blank" href="https://api.whatsapp.com/send/?phone=%2B918826450360&text=I+need+more+details+for+academy+{{ $academy->name }}+({{ $academy->id }})"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/whatsapp_icon.png" loading="lazy" alt="chat"></a>
                     </div>

                     <a class="blue_btn_bordered_medium mt40" data-toggle="modal" data-target="#instructor_batch_model" href="https://www.bookmyplayer.com/front/formPopup">
                        <div class="white_phone" data-toggle="modal" onclick="openLoginForm(<?= htmlspecialchars($academy->id); ?>, 'academy', '<?= htmlspecialchars($academy->name); ?>','<?= htmlspecialchars($academy->sport); ?>')" data-target="#exampleModalCenter2">
                           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/msg_icon.png" loading="lazy" alt="message" srcset="">
                        </div>
                     </a>
                     <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/graph.svg" loading="lazy" alt="views" height="20" width="20"><span>{{$academy->views == null ? 0 : $academy->views}}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@endforeach
</div>
@endif
