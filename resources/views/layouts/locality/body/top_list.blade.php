@php $object_type = "academy"; $record_count = 0; @endphp @include('layouts.modal')
<div id="academies-list" class="row"></div>
<div id="loader" style="display: none;">Loading...</div>

<script>
    let offset = 20;
    const limit = 20;
    const academiesList = document.getElementById('academies-list');
    const loader = document.getElementById('loader');
    let loading = false;

    document.querySelectorAll('.sportCheckbox').forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });

    document.querySelectorAll('.ratingCheckbox').forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });

    function handleCheckboxChange() {
        academiesList.innerHTML = '';
        offset = 0;
        loading = false;
        fetchData();

        if (window.removeEventListener) {
            window.removeEventListener('scroll', handleScroll);
        }
        window.addEventListener('scroll', handleScroll);
    }



    function getSelectedSports() {
        return Array.from(document.querySelectorAll('.sportCheckbox:checked')).map(checkbox => checkbox.value);
    }

    function getSelectedRating() {
        const checkboxes = document.querySelectorAll('.ratingCheckbox:checked');
        // Convert checkbox values to floats and sort them
        const ratings = Array.from(checkboxes).map(checkbox => parseFloat(checkbox.value)).sort((a, b) => a - b);
        return ratings.length > 0 ? ratings : null; // Return null if no ratings are selected
    }



    function fetchData() {
        const selectedSports = getSelectedSports();
        const selectedRating = getSelectedRating();
        loader.style.display = 'block';
        loader.textContent = 'Loading...';
        let itemsLoaded = 0;
        let academies = @json($data['d']);

        if (academies.length <= offset) {
            offset = 0;
        }


        setTimeout(function() {


            if (selectedSports && selectedSports.length > 0) {
                academies = academies.filter(academy => selectedSports.includes(academy.sport));
            }

            if (selectedRating && selectedRating.length > 0) {
                const minRating = selectedRating[0]; // Get the minimum rating as a float

                // Filter academies by converting rating strings to float and comparing
                academies = academies.filter(academy => {
                    return academy.rating !== null && parseFloat(academy.rating) >= minRating;
                });
            }

            for (let i = offset; i < Math.min(offset + limit, academies.length); i++) {
                const academy = academies[i];
                let fee = academy.fee ? academy.fee : (academy.default_pricing ? academy.default_pricing : 1100);
                let photoarr = academy.photos != null && academy.photos != "" ? academy.photos.split(',') : [];
                let dotsHtml = photoarr.length > 1 ? photoarr.map((_, index) => `
                    <span class="dot ${index === 0 ? ' active' : ''}"></span>
                    `).join('') : '';
                const academyHtml = `
               <div class="col-12 gap list-menu">
       <div class="listing_wrapper">
           <div class="listing_box">
               <div class="listing_img">
                   <div class="carousel">
                   <div class="carousel_images">
                   <a target="_blank" href="${academy.url}">
    ${photoarr.length > 0 ?
        photoarr.map((photo, index) => `
            <img src="{{env('AWS_CF_BASE_URL')}}/academy/${academy.id}/${photo}" alt="Listing Image ${index + 1}" class="list_img${index === 0 ? ' active' : ''}">
        `).join('') :
        `<img src="{{ env('AWS_CF_BASE_URL') }}/default/${academy.sport}_banner.webp" alt="Image" class="list_img active">`
    }
</a>

   </div>


                       <div class="carousel_dots">
                       ${dotsHtml}
                       </div>
                       <div class="carousel_contacts">
                           <div><span class="">⭐ ${academy.views ? academy.views : "0"} people viewed since last week.</span></div>
                           <div><span class="contact_count">1/3</span></div>
                       </div>
                   </div>

                   <div>
                       <div class="verify_flex">
                           <div class="verified_tick">
                               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/white_tick.png" alt="" height="24" width="24">
                               <span>Verified</span>
                           </div>
                           <div class="coach_sport">
                               <span>Academy</span>
                           </div>
                       </div>

                       <div class="heart_fav">
                           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/heart.svg" alt="">
                       </div>
                   </div>
               </div>
               <div class="list_down">
                   <div class="list_top">
                       <a target="_blank" href="${academy.url}">
                           <h2>${academy.name}</h2>
                       </a>
                   </div>
                   <div>
                       <div class="fb_star_section fb_flex_version">

                         <div class="graph_flex">

               <div class="graph_view">
                     <div class="rating_num">
                        <span class="rating_value">${academy.rating ? academy.rating : "0"} ★</span>
                     </div>
                     <div class="total_rating_width">
                     <span class="fb_font total_ratings">${academy.reviews ? academy.reviews : "0"} Reviews</span>
                     </div>

                     <div class="line">|</div>
                  </div>
                  <div class="price_month">
                     <span>
                        ₹ ${fee}
                     </span>
                  </div>
               </div>

                  <div class="coach_academy">
                     <span>${academy.sport}</span>
                  </div>
               </div>
            </div>
                       <div class="list_location">
                           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location_mob.svg" alt="">
                           <span class="fb_font location_add"><span class="distance_km">(${academy.distance.toFixed(2)} km)</span>${[academy.address1, academy.address2, academy.city, academy.state, academy.postcode].filter(Boolean).join(', ')}</span>                        </div>
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
                               <img src="${academy.logo == null || academy.logo == "" ? '{{env('AWS_CF_BASE_URL')}}/default/academy_default_logo.webp' : '{{env('AWS_CF_BASE_URL')}}/academy/' + academy.id + '/' + academy.logo}" alt="">
                               </div>
                               <div class="logo_info">
                                   <span>1 w ago</span>
                                   <span>Featured</span>
                                   <span>${academy.name}</span>
                               </div>
                           </div>
                           <div class="list_btn">
                           <div class="white_whatsapp">
   <a target="_blank" href="https://api.whatsapp.com/send/?phone=%2B91{{env('WHATSAPP_LEAD_MOBILE')}}&text=I+need+more+details+for+academy+${academy.name}+(${academy.id})">
       <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/whatsapp_icon.png" alt="" srcset="">
   </a>
   </div>

   <a class="blue_btn_bordered_medium mt40" data-toggle="modal" data-target="#instructor_batch_model" href="https://www.bookmyplayer.com/front/formPopup">
   <div class="white_phone" data-toggle="modal" onclick="openLoginForm('${academy.id}', 'academy', '${academy.name}', '${academy.sport}')" data-target="#exampleModalCenter2">
           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/msg_icon.png" alt="" srcset="">
   </div>
   </a>

                               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/graph.svg" alt="" height="20" width="20"><span>${academy.views ? academy.views : "0"}</span>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
               `

                academiesList.innerHTML += academyHtml;

                itemsLoaded++;


                if ((offset + itemsLoaded) % 40 === 0) {
                    academiesList.innerHTML += getPopularLayoutHtml();

                } else if ((offset + itemsLoaded) % 20 === 0) {
                    academiesList.innerHTML += getExploreLayoutHtml();
                }
            }

            loader.style.display = 'none';

            offset += limit;

            if (offset >= academies.length) {
                window.removeEventListener('scroll', handleScroll);
            }
            loading = false;
        }, 500);

        setTimeout(function() {
            const academies = <?= json_encode($data['d']); ?>;

            const carouselElements = document.querySelectorAll('.carousel');
            carouselElements.forEach(carouselElement => {
                initializeCarouselForElement(carouselElement);
            });
        }, 500);
    }

    function handleScroll() {
        const scrollPercentage = (window.scrollY + window.innerHeight) / document.body.offsetHeight;
        if (scrollPercentage >= 0.80 && !loading) {
            loading = true;
            fetchData();
        }
    }

    window.addEventListener('scroll', handleScroll);

    function initializeCarouselForElement(carouselElement) {
        let slides = carouselElement.querySelectorAll(".list_img");
        let dots = carouselElement.querySelectorAll(".dot");
        let contactInfo = carouselElement.querySelector(".contact_count");
        let slideIndex = 0;

        function showSlides() {
            Array.from(slides).forEach(slide => slide.style.display = 'none');
            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].style.display = 'block';

            if (dots.length > 0) {
                Array.from(dots).forEach(dot => dot.classList.remove('active'));
                if (dots[slideIndex]) {
                    dots[slideIndex].classList.add('active'); // Add 'active' class to the current dot
                }
            }

            if (contactInfo) {
                contactInfo.textContent = `${slideIndex + 1}/${slides.length}`; // Update contact info
            }

            setTimeout(showSlides, 2000);
        }

        showSlides();
    }


    function getExploreLayoutHtml() {
        return `
        <div class="col-12 gap top_add_one explore-section">
   <div class="listing_wrapper">
      <div class="popup_explore">
         <h3>Explore {{$data['city']}}</h3>
      </div>
      <div class="popup_localieties">
         <div>
            <div class="top_explore_flex">
               <span class="popup_name_top">Popular Localities</span>
               <span class="popup_info_top">Most searched by students in {{$data['city']}}</span>
            </div>
            <div class="popup_details top_locals">
               @if($data['otherLocalities'])
               <div class="local_flex">
                  @foreach($data['otherLocalities'] as $index => $locality)
                  @if($index < 6) <div class="popup_box_up">
                     <div class="city_new_img_up">
                        <div class="display_flex">
                           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/property.jpeg" alt="image" loading="lazy">
                           <span class="popup_name"><a target="_blank" href="{{$locality->url}}">{{$locality->locality_name}}</a></span>
                        </div>
                     </div>
                     <div class="popup_details">
                        <span class="popup_info">₹2k - 20k /mo.</span>
                        <div class="rating_flex">
                           <div class="rating_num">
                              <span>4.6 ★</span>
                           </div>
                           <span class="popup_info_review">150+ reviews</span>
                        </div>
                        <div class="popup_academy"><a target="_blank" href="{{$locality->url}}"> view academy</a></div>
                     </div>
               </div>
               @endif
               @endforeach
            </div>
            @endif
         </div>
      </div>

      @if(count($data['otherLocalities'])>6)
      <div>
            <div class="top_explore_flex">
               <span class="popup_name_top">Top Rated Localities</span>
               <span class="popup_info_top">Based on overall nation reviews</span>
            </div>
            <div class="popup_details top_locals">
               @if($data['otherLocalities'])
               <div class="local_flex">
                  @foreach($data['otherLocalities'] as $index => $locality)
                  @if($index >= 6 && $index < 12)
                  <div class="popup_box_up">
                     <div class="city_new_img_up">
                        <div class="display_flex">
                           <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/property.jpeg" alt="image" loading="lazy">
                           <span class="popup_name"><a target="_blank" href="{{$locality->url}}">{{$locality->locality_name}}</a></span>
                        </div>
                     </div>
                     <div class="popup_details">
                        <span class="popup_info">₹2k - 20k /mo.</span>
                        <div class="rating_flex">
                           <div class="rating_num">
                              <span>4.6 ★</span>
                           </div>
                           <span class="popup_info_review">150+ reviews</span>
                        </div>
                        <div class="popup_academy"><a target="_blank" href="{{$locality->url}}"> view academy</a></div>
                     </div>
               </div>
               @endif
               @endforeach
            </div>
            @endif
         </div>
      </div>

   @endif

   <div>
            <div class="top_explore_flex">
               <span class="popup_name_top">Famous Sport Academy</span>
               <span class="popup_info_top">Most searched Academies by students in {{$data['city']}}</span>
            </div>
            <div class="popup_details top_locals">
               @if($data['otherLocalities'])
               <div class="local_flex">
                  @foreach($data['topAcademies'] as $index => $academy)
                  @if($index < 6) <div class="popup_box_up">
                     <div class="city_new_img_up">
                        <div class="display_flex">
                        <img src="{{ (is_null($academy->logo) || $academy->logo === "") ? env('AWS_CF_BASE_URL') . '/default/academy_default_logo.webp' : env('AWS_CF_BASE_URL') . '/academy/' . $academy->id . '/' . $academy->logo }}" alt="logo" loading="lazy">
                        <span class="popup_name"><a target="_blank"  href="{{$academy->url}}">{{$academy->name}}</a></span>
                        </div>
                     </div>
                     <div class="popup_details">
                        <span class="popup_info">₹2k - 20k /mo.</span>
                        <div class="rating_flex">
                           <div class="rating_num">
                              <span>{{$academy->rating? $academy->rating : 0}} ★</span>
                           </div>
                           <span class="popup_info_review">{{$academy->reviews? $academy->reviews : 0}}  reviews</span>
                        </div>
                        <div class="popup_academy"><a target="_blank" href="{{$academy->url}}"> view academy</a></div>
                     </div>
               </div>
               @endif
               @endforeach
            </div>
            @endif
         </div>
</div>
</div>
</div>
</div>
        `;
    }

    function getPopularLayoutHtml() {
        return `
        <div class="col-12  top_add_one popular-section">
         <div class="listing_wrapper">
            <div class="listing_box popup_add">
               <div class="popup_add_top">
                  <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location_mob.svg" alt="location" loading="lazy" class="popup_icon">
                  <div>
                     <h3>Popular Academies in {{$data['city']}}</h3>
                     <p class="fb_font popup_msg">Get to know about popular academies in  {{$data['city']}}</p>
                  </div>
               </div>
               <div class="popup_wrap">

                @foreach($data['topAcademies'] as $index => $academy)
                @if($index <= 2)
                  <div class="popup_box">
                     <div class="city_new_img">
                     <a target="_blank" href="{{$academy->url}}"><img src="{{ (is_null($academy->logo) || $academy->logo === "") ? env('AWS_CF_BASE_URL') . '/default/academy_default_logo.webp' : env('AWS_CF_BASE_URL') . '/academy/' . $academy->id . '/' . $academy->logo }}" alt="logo" loading="lazy"></a>
                     </div>
                     <div class="popup_details">
                        <span class="popup_name"><a target="_blank" href="{{$academy->url}}">{{$academy->name}}</a></span>
                        <span class="popup_info popup_popular_info">{{implode(', ', array_filter([$academy->address1, $academy->address2, $academy->city, $academy->state, $academy->postcode]))}}</span>
                     </div>
                  </div>
                  @endif
                  @endforeach

               </div>
            </div>
         </div>
      </div>
        `;
    }

    function uncheckAllCheckboxes() {
        document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    function removeActiveFilterClass(classNames) {
        classNames.forEach(className => {
            document.querySelectorAll('.' + className).forEach(item => {
                item.classList.remove('active_filter');
            });
        });
    }

    document.getElementById('filter_new_heading_2').addEventListener('click', function() {
        uncheckAllCheckboxes();
        handleCheckboxChange();
    });


    document.getElementById('clear_mob_filter').addEventListener('click', function() {
        uncheckAllCheckboxes();
        removeActiveFilterClass(['sport_sort', 'rate_sort']);
        handleCheckboxChange();
    });


    fetchData();
</script>
