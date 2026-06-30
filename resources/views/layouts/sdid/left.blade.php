<div class="filter_left">
   <div class="filter_top">
      <p class="fb_font" id="filter_new_heading">Filters</p>
      <p class="fb_font" id="filter_new_heading_2">Clear All Filters</p>
   </div>
   <div class="search-box">
      <input type="text" id="searchLocality" class="search-input" placeholder="Search Localities">
      <div class="search-icon">
         <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/search2.svg" alt="search">
      </div>
   </div>

   <div id="localitiesData" data-localities='<?php echo json_encode($data['otherLocalities']); ?>' style="display:none"></div>

   @if(count($data['otherLocalities']) > 0)
   <p class="mob_filter_topic">Localities</p>
   <div id="localities_wrapper_desk">
      <div class="filter_check" id="initialLocalities">
         @foreach($data['otherLocalities'] as $index => $locality)
         @if($index <= 5) <a target="_blank" href="{{$locality->url}}" class="sector_tag_desk">
            <button class="sort_btn">
               <span>{{$locality->locality_name}}</span>
            </button>
            </a>
            @endif
            @endforeach
      </div>

      @if(count($data['otherLocalities']) > 6)
      <div class="filter_check">
         <div class="local_relative">
            <div class="more_local">
               <p style="text-align: left; color: #0076d7; font-weight: 600; cursor: pointer;" id="moreBtn">More</p>
            </div>
            <div class="localities_popup">
               <div class="popup_top">
                  <h4>More Popular Localities</h4>
                  <div id="closeBtn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt=""></div>
               </div>
               <div class="more_sectors" id="additionalLocalities">
                  @foreach($data['otherLocalities'] as $index => $locality)
                  @if($index > 5)
                  <a target="_blank" href="{{$locality->url}}" class="sector_tag_desk">
                     <button class="sort_btn">
                        <span>{{$locality->locality_name}}</span>
                     </button>
                  </a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
      </div>
      @endif
   </div>
   @endif


   <p class="mob_filter_topic">Search By</p>
   <div class="filter_check">
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" checked />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">Academy</p>
         </label>
      </div>
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" checked />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">Coach</p>
         </label>
      </div>
   </div>

   @if(count($data['sports']) > 0)
   <p class="mob_filter_topic">Sport</p>
   <div class="filter_check">
      @foreach ($data['sports'] as $index => $sport)
      @if($index <= 5)
      <a target="_blank" href="{{$sport->url}}" class="sector_tag_desk">
         <button class="sort_btn">
            <span>{{$sport->sport}}</span>
         </button>
      </a>
      @endif
      @endforeach
   </div>

   @if(count($data['sports']) > 6)
   <div class="filter_check">
         <div class="local_relative">
            <div class="more_local">
               <p style="text-align: left; color: #0076d7; font-weight: 600; cursor: pointer;" id="moreSportBtn">More</p>
            </div>
            <div class="sports_popup">
               <div class="popup_top">
                  <h4>More Sports</h4>
                  <div id="closeSportBtn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt=""></div>
               </div>
               <div class="more_sectors">
                  @foreach($data['sports'] as $index => $sport)
                  @if($index > 5)
                  <a target="_blank" href="{{$sport->url}}" class="sector_tag_desk">
                     <button class="sort_btn">
                        <span>{{$sport->sport}}</span>
                     </button>
                  </a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   @endif
   @endif
   <p class="mob_filter_topic">Rating</p>
   <div class="filter_check">
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" class="ratingCheckbox" value="3" />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/gold_star.svg" loading="lazy" alt="star" width="14" height="14"> </p>
         </label>
      </div>
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" class="ratingCheckbox" value="4" />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/gold_star.svg" loading="lazy" alt="star" width="14" height="14"></p>
         </label>
      </div>
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" class="ratingCheckbox" value="4.5" />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">4.5 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/gold_star.svg" loading="lazy" alt="star" width="14" height="14"></p>
         </label>
      </div>
      <div class="mobile_login_check">
         <label class="mobile_login_label_checkbox">
            <input type="checkbox" class="ratingCheckbox" value="5" />
            <span class="mobile_login_checkbox"></span>
            <p class="mob_filter_sector">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/gold_star.svg" loading="lazy" alt="star" width="14" height="14"></p>
         </label>

      </div>
   </div>
   <div>
      <p class="mob_filter_topic">More</p>
      <div class="mob_filter_on_off">
         <p class="mob_filter_pic_on">Open Academies</p>
         <label class="mob_filter_switch">
            <input type="checkbox">
            <span class="mob_switch_slider mob_switch_round"></span>
         </label>
      </div>
      <div class="mob_filter_on_off">
         <p class="mob_filter_pic_on">Verified Only</p>
         <label class="mob_filter_switch">
            <input type="checkbox">
            <span class="mob_switch_slider mob_switch_round"></span>
         </label>
      </div>
   </div>
</div>

<div id="sports_popup_content" style="display: none;"> <!-- Initially hidden -->
   <div class="mob_filter_sports">
      <h6>Sports</h6>
   </div>
   <div class="filter_check_mob_sdid">
      @foreach ($data['sports'] as $index => $sport)
      <a target="_blank" href="{{$sport->url}}" class="sector_tag_desk">
         <button class="sort_btn">
            <span>{{$sport->sport}}</span>
         </button>
      </a>
      @endforeach
   </div>
</div>
<div id="popup_overlay"></div> <!-- Overlay for blur effect -->
