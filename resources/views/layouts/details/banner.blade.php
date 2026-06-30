<!-- top banner section  -->

@php
$videoCount = 0;

if (!empty ($data['videos']) && count($data['videos']) === 1 && $data['videos'][0] === "") {
$videoCount = 0;
} else {
$videoCount = count($data['videos']);
}


$photoCount = !empty($data['photos']) && !(count($data['photos']) === 1 && $data['photos'][0] === "") ? count($data['photos']) : 0;


if($data['logo']== env('AWS_S3_BASE_URL') ."/asset/images/logo.svg"){
$img_class = "logo_banner";
}else{
$img_class = "";
}

@endphp

<div class="mobile_bannner_section">
    <div class="mobile_academy_banner">
        <div class="top_relative">
            <div class="image_slider">
                @if($data['page'] == "coach" || $data['page'] == "academy_details")
                @if ($videoCount > 0 && $photoCount >0)
                @if(!$MOBILE && $photoCount>=1)
                @php
                $firstPhotoUrl = $data['photos'][0];
                $secondPhotoUrl="";
                $thirdPhotoUrl="";
                $fourthPhotoUrl="";
                if($photoCount >= 2) {
                $secondPhotoUrl = $data['photos'][1];
                }
                if($photoCount >= 3) {
                $thirdPhotoUrl = $data['photos'][2];
                }
                if($photoCount >= 4) {
                $fourthPhotoUrl = $data['photos'][3];
                }
                @endphp
                <div class="split_banner">
                    <div class="split_banner_left">
                        @php $firstVideoUrl = $data['videos'][0];@endphp
                        <!-- Example with a simple HTML5 video player for direct video URLs -->
                        <video id="videoPlayer" controls loop class="banner_img video_banner card">
                            <source id="videoSource" src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstVideoUrl }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="imageDisplay" class="banner_img" style="display: none;" />
                        <div id="prevVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/left_arrow.svg" alt=""></div>
                        <div id="nextVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/right_arrow.svg" alt=""></div>

                    </div>

                    <div class="split_banner_right">
                        @if( $firstPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if( $secondPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $secondPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $secondPhotoUrl }}" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if($thirdPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $thirdPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $thirdPhotoUrl }}" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if($fourthPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $fourthPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $fourthPhotoUrl }}" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                @php $firstVideoUrl = $data['videos'][0];@endphp
                <!-- Example with a simple HTML5 video player for direct video URLs -->
                <video id="videoPlayer" controls loop class="banner_img video_banner card">
                    <source id="videoSource" src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstVideoUrl }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="imageDisplay" class="banner_img" style="display: none;" />
                <div id="prevVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/left_arrow.svg" alt=""></div>
                <div id="nextVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/right_arrow.svg" alt=""></div>
                @endif
                <!-- Display the first video if there is at least one video -->

                @elseif($photoCount >0 && $videoCount===0)

                @if(!$MOBILE && $photoCount>=1)
                @php
                $firstPhotoUrl = $data['photos'][0];
                $secondPhotoUrl="";
                $thirdPhotoUrl="";
                $fourthPhotoUrl="";
                if($photoCount >= 2) {
                $secondPhotoUrl = $data['photos'][1];
                }
                if($photoCount >= 3) {
                $thirdPhotoUrl = $data['photos'][2];
                }
                if($photoCount >= 4) {
                $fourthPhotoUrl = $data['photos'][3];
                }
                @endphp
                <div class="split_banner">
                    <div class="split_banner_left">
                        @if($photoCount==1)
                        <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" loading="lazy" alt="" id="bannerImg" class="banner_img" />
                        @else
                        @if($data['page'] == "coach")
                        <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="imageDisplay" class="banner_img" style="display: none;" />
                        @else
                        <div class="image_star">
                            @if($data['page'] == "academy_details" && count($data['banners']) > 0)
                            <img src="{{env('AWS_S3_BASE_URL_70')}}/<?= $data['page'] == 'coach' ? 'coach' : 'academy' ?>/<?= $data['d']->id ?>/<?= $data['banners'][0] ?>" loading="lazy" alt="" id="bannerImg" class="banner_img" />
                            @else
                            <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="bannerImg" class="banner_img" />
                            @endif
                            <div class="image_description">
                                <div class="review_number">
                                    <span class="review_text" style="color:#fff">{!! $data['d']->rating ?? '4' !!}</span>
                                </div>
                                <div class="mobile_academy_stars_small" style="--star_rating: {{$data['d']->rating ?? '4'}}" aria-label="Rating of this product is 3 out of 5."></div>
                                <span class="review_text" style="color:#fff">{!! $data['d']->reviews ?? '23' !!} Reviews</span>
                            </div>
                        </div>
                        <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="imageDisplay" class="banner_img" style="display: none;" />
                        @endif
                        <div id="prevVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/left_arrow.svg" alt=""></div>
                        <div id="nextVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/right_arrow.svg" alt=""></div>
                        @endif

                    </div>

                    <div class="split_banner_right">
                        @if( $firstPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" loading="lazy" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if( $secondPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $secondPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $secondPhotoUrl }}" loading="lazy" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if($thirdPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $thirdPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $thirdPhotoUrl }}" loading="lazy" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                        @if($fourthPhotoUrl)
                        <div class="sp_img">
                            <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $fourthPhotoUrl }}" data-fancybox="gallery" data-caption="Media">
                                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $fourthPhotoUrl }}" loading="lazy" alt="" class="banner_img" />
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                @if($photoCount==1)
                @php
                $firstPhotoUrl = $data['photos'][0];
                @endphp
                <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $firstPhotoUrl }}" loading="lazy" alt="Academy Details Banner" class="banner_img" />
                @else

                @if($data['page'] == "academy_details" && count($data['banners']) > 0)
                <img src="{{env('AWS_S3_BASE_URL_70')}}/<?= $data['page'] == 'coach' ? 'coach' : 'academy' ?>/<?= $data['d']->id ?>/<?= $data['banners'][0] ?>" alt="Academy Details Banner" id="bannerImg" class="banner_img" />
                @else
                <img src="{{ $data['banner'] }}" alt="Academy Details Banner" id="bannerImg" class="banner_img" />
                @endif
                <img src="{{ $data['banner'] }}" alt="Academy Details Banner" id="imageDisplay" class="banner_img" style="display: none;" />
                <div id="prevVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/left_arrow.svg" loading="lazy" alt=""></div>
                <div id="nextVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/right_arrow.svg" loading="lazy" alt=""></div>
                @endif
                @endif


                @elseif($photoCount ===0 && $videoCount>0)
                @php $firstVideoUrl = $data['videos'][0];@endphp
                <video id="videoPlayer" controls loop class="banner_img video_banner card" style="display: none;">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="imageDisplay" class="banner_img" style="display: none;" />

                <div id="prevVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/left_arrow.svg" alt=""></div>
                <div id="nextVideo"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/right_arrow.svg" alt=""></div>
                @else
                <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="bannerImg" class="banner_img" />
                @endif
                @else
                <img src="{{ $data['banner'] }}" loading="lazy" alt="" id="bannerImg" class="banner_img" />
                @endif



                <div class="mobile_academy_wrapper">
                    @if($data['page'] == "coach")
                    <div class="mobile_academy_coach">
                        <img src="{{ $data['logo'] }}" class="{{ $img_class }}" loading="lazy" alt="Academy Details Logo" srcset="" onerror="this.onerror=null;this.src='{{ env('AWS_CF_BASE_URL') }}/asset/images/logo.svg'; this.style.cssText='margin-top:-0.8rem;background-color:#fff;'">
                    </div>

                    @elseif($data['page'] == "player")
                    <div class="mobile_academy_coach"><img src="{{ $data['logo'] }}" class="{{ $img_class }}" loading="lazy" alt="Player Logo" srcset=""></div>
                    @else
                    <div class="mobile_academy_logo"><img src="{{ $data['logo'] }}" class="{{ $img_class }}" loading="lazy" alt="Academy Details Logo" srcset=""></div>
                    @endif
                </div>

                <div class="mob_academy_info">
                    @if(count($data['photos']) === 1 && $data['photos'][0] === "")
                    @elseif(count($data['photos']) >= 1)
                    <a href="#img_section">
                        <p class="mob_academy_photo">Photos({{ count($data['photos']) }})</p>
                    </a>
                    @endif

                    @if(count($data['videos']) === 1 && $data['videos'][0] === "")
                    @elseif(count($data['videos']) >= 1)
                    <a href="#img_section">
                        <p class="mob_academy_photo">Videos({{ count($data['videos']) }})</p>
                    </a>
                    @endif
                    <div>
                        <div class="share_icon">
                            <div class="mob_academy_star_heart">
                                <!-- <div class="share_icon">
                                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mob_share.svg" loading="lazy" alt="share" class="mob_share trigger" width="18" height="18">
                                    </div> -->
                            </div>
                            <!-- social media modal  -->
                            <div class="social-modal">
                                <div class="modal-content">
                                    <span class="close-button"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" loading="lazy" alt="close" width="18" height="18"></span>
                                    <div class="share-modal--content">
                                        <h3>share academy profile</h3>
                                        <div class="social-icons">
                                            <a id="facebookShare">
                                                <div class="icons new_icon">
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mfb.svg" loading="lazy" alt="facebook" width="30" height="30" />
                                                    <span>facebook</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="icons new_icon">
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/minsta.svg" loading="lazy" alt="instagram" width="30" height="30" />
                                                    <span>instagram</span>
                                                </div>
                                            </a>
                                            <a id="whatsappShare">
                                                <div class="icons new_icon">
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mwhtaps.svg" loading="lazy" alt="whatsapp" width="30" height="30" />
                                                    <span>whatsapp</span>
                                                </div>
                                            </a>
                                            <a id="linkedinShare">
                                                <div class="icons new_icon">
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mlinkd.svg" loading="lazy" alt="linkedin" width="30" height="30" />
                                                    <span>linkedIn</span>
                                                </div>
                                            </a>
                                            <a id="copyUrl">
                                                <div class="icons new_icon">
                                                    <!-- <i class="bi bi-check"></i> -->
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mcopy.svg" loading="lazy" alt="copy" width="30" height="30" />
                                                    <span id="copy-text">copy link</span>
                                                    <span id="copy-text-success" class="text-success">copied</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- social media modal ends -->
                        </div>
                    </div>
                </div>


            </div>

            <div class="mob_academy_star">
                <div class="name_heading">
                    <h1 class="mob_academy_name full_title">{{ $data['listingTitle'] }}</h1>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/star_tick.svg" alt="Verified" width="20" height="20">
                </div>
                <div class="academy_add_wrap"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location2.svg" loading="lazy" alt="Address Details" width="16" height="20">
                    @if($data['page'] == "coach")
                    <span class="fb_font academy_new_add">{{ $data['d']->state }} - {{ $data['d']->city }}</span>
                    @elseif($data['page'] == "player")
                    <span class="fb_font academy_new_add">{{ $data['d']->sport }} - {{ $data['d']->position }}</span>
                    @else
                    <span class="fb_font academy_new_add">{{ strlen($data['address']) > 120 ? substr($data['address'], 0, 120) . '...' : $data['address'] }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- top banner section ends -->

<?php if (!empty($data['videos']) || !empty($data['photos'])) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Unified content array
            const bannerImage = document.querySelector("#bannerImg")
            <?php if (isset($data['banners']) && isset($data['videos']) && !empty($data['videos'])) : ?>

                var videos = [
                    <?php foreach ($data['videos'] as $videoUrl) : ?> {
                            type: 'video',
                            url: "<?= env('AWS_CF_BASE_URL') ?>/<?= $data['page'] == 'coach' ? 'coach' : 'academy' ?>/<?= $data['d']->id ?>/<?= $videoUrl ?>"
                        },
                    <?php endforeach; ?>
                ];

            <?php endif; ?>


            <?php if (isset($data['banners']) && $data['page'] == "academy_details" && count($data['banners']) > 0) : ?>
                <?php if (empty($data['banners']) || (count($data['banners']) === 1 && $data['banners'][0] === "")) : ?>
                    var photos = [{
                        type: 'photo',
                        url: "<?= $data['banner'] ?>"
                    }];
                <?php else : ?>
                    var photos = [
                        <?php foreach ($data['banners'] as $photo) : ?> {
                                type: 'photo',
                                url: "{{env('AWS_S3_BASE_URL_70')}}/<?= $data['page'] == 'coach' ? 'coach' : 'academy' ?>/<?= $data['d']->id ?>/<?= $photo ?>"
                            },
                        <?php endforeach; ?>
                    ];
                <?php endif; ?>

            <?php else : ?>

                <?php if (empty($data['photos']) || (count($data['photos']) === 1 && $data['photos'][0] === "")) : ?>
                    var photos = [{
                        type: 'photo',
                        url: "<?= $data['banner'] ?>"
                    }];
                <?php else : ?>
                    var photos = [
                        <?php foreach ($data['photos'] as $photo) : ?> {
                                type: 'photo',
                                url: "{{env('AWS_CF_BASE_URL')}}/<?= $data['page'] == 'coach' ? 'coach' : 'academy' ?>/<?= $data['d']->id ?>/<?= $photo ?>"
                            },
                        <?php endforeach; ?>
                    ];
                <?php endif; ?>
            <?php endif; ?>



            // Concatenate videos and photos into a single content array
            <?php if (empty($data['videos']) || (count($data['videos']) === 1 && $data['videos'][0] === "")) : ?>
                var content = [...videos, ...photos];
            <?php else : ?>
                var content = [...photos, ...videos];
            <?php endif; ?>

            let currentIndex = 0; // Start with the first content item

            function updateContent(index) {
                const currentItem = content[index];
                const videoPlayer = document.getElementById('videoPlayer');
                const videoSource = document.getElementById('videoSource');
                const imageDisplay = document.getElementById('imageDisplay'); // Ensure this element exists for photos

                if (currentItem.type === 'video') {
                    if (videoPlayer && videoSource) {
                        videoPlayer.style.display = 'block';
                        videoSource.src = currentItem.url;
                        videoPlayer.load();
                        videoPlayer.play();
                    }
                    if (imageDisplay) imageDisplay.style.display = 'none';
                } else if (currentItem.type === 'photo') {
                    if (videoPlayer) {
                        videoPlayer.style.display = 'none';
                        videoPlayer.pause();
                    }
                    if (imageDisplay) {
                        imageDisplay.style.display = 'block';
                        imageDisplay.src = currentItem.url;
                    }
                }
            }

            // Previous content button
            document.getElementById('prevVideo')?.addEventListener('click', function() {
                if (bannerImage)
                    bannerImage.style.display = "none";
                if (currentIndex > 0) {
                    currentIndex--;
                    if (currentIndex === 0) {
                        if (bannerImage)
                            bannerImage.style.display = "block";
                    } else {
                        if (bannerImage)
                            bannerImage.style.display = "none";
                    }
                } else {
                    currentIndex = content.length - 1; // Loop back to the last item
                }
                updateContent(currentIndex);
                if (currentIndex !== 0) {
                    document.querySelector('.image_star').style.display = "none"
                } else {
                    document.querySelector('.image_star').style.display = "block"
                }
            });

            // Next content button
            document.getElementById('nextVideo')?.addEventListener('click', function() {
                if (bannerImage)
                    bannerImage.style.display = "none";
                if (currentIndex < content.length - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0; // Loop back to the first item
                    if (bannerImage)
                        bannerImage.style.display = "block";
                }
                updateContent(currentIndex);
                if (currentIndex !== 0) {
                    document.querySelector('.image_star').style.display = "none"
                } else {
                    document.querySelector('.image_star').style.display = "block"
                }
            });

            // Initialize the first content display
            if (content.length > 0) {
                updateContent(0);
            }
        });
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>