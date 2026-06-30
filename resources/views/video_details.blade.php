@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/academy_detail_v13.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/fancybox.css') }}" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/academy_detail_v26.js') }}" defer></script>
<script src="{{ asset('asset/js/fancybox.umd.js') }}"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>
@endpush
@extends('layouts.app')
@section('content')



<section class="academy-club-section video-details-club clearfix">

    <div class="container">

        <div class="d-flex justify-content-between align-items-start gap-3 w-100 video-detail-wrap">
            <section class="clearfix" style="width: 100%;">
                <div class="academy-slider">
                    <div class="rtl-slider-flex video-detail-flex">
                        <div class="rtl-slider">
                            <div class="rtl-slider-slide1 video_container">
                                <a href="https://f005.backblazeb2.com/file/bmpcdn90/academy/35025/Unlock-Your-Best-Self-with-Our-Exclusive-Gym-Special-Offer----Are-you-ready-to-transform-your-fitness-journey-and-achieve-your-health-goals-There-s-never-been-a-better-time-to-join-our-vibrant-community-of-fitness.mp4"
                                    data-fancybox="photos-gallery" data-caption="">
                                    <video id="myVideo" autoplay loop muted playsinline class="background-clip"
                                        controlsList="nodownload">
                                        <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/35025/Unlock-Your-Best-Self-with-Our-Exclusive-Gym-Special-Offer----Are-you-ready-to-transform-your-fitness-journey-and-achieve-your-health-goals-There-s-never-been-a-better-time-to-join-our-vibrant-community-of-fitness.mp4" type="video/mp4">
                                    </video>
                                </a>


                                <div class="video_controls">
                                    <div class="play_volume" id="playPauseBtn">
                                        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/play_2.png" alt="Play"
                                            style="width:100% !important; height:100% !important">
                                    </div>
                                    <div class="play_volume" id="muteBtn">
                                        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/volume_2.png" alt="Volume"
                                            style="width:100% !important; height:100% !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="white-box video-list-name" style="background: linear-gradient(145deg, #fefefe, #f0f0f0);">
                <div style="font-size:16px;">
                    <div >
                        <p style="margin-bottom: 0;"><strong>Video Title:</strong></p>
                        <p>The Ultimate Training Guide</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 0;"><strong>Video Duration:</strong></p>
                        <p>1 Min 05 Sec</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 0;"><strong>Video Size:</strong></p>
                        <p>5 Mb</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 0;"><strong>Uploaded By:</strong></p>
                        <p>Fast Fc Club</p>
                    </div>
                </div>
            </div>
        </div>

            <div class="videos-box white-box white-box2">
                <div class="slider_flex">
                    <h4 style="font-size:22px">Other Videos (<span class="video_count">5</span>)</h4>
                    <div class="slider_arrow">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_left.png" id="scroll-left4"
                            class="lazy" alt="arrow">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/blog_right.png" id="scroll-right4"
                            class="lazy" alt="arrow">
                    </div>
                </div>
                <div class="videos-slider">
                    <div class="videos-js videos-other-js mt-3">
                        <div class="item academy_img">
                            <div class="sport_card">
                                <video controls controlsList="nodownload" class="fast_track">
                                    <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/3203/Untitled-design--1-.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="item academy_img">
                            <div class="sport_card">
                                <video controls controlsList="nodownload" class="fast_track">
                                    <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/3203/bmp_66e3d31946c3c.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="item academy_img">
                            <div class="sport_card">
                                <video controls controlsList="nodownload" class="fast_track">
                                    <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/3203/bmp_66e27d1e7984e.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="item academy_img">
                            <div class="sport_card">
                                <video controls controlsList="nodownload" class="fast_track">
                                    <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/35025/Unlock-Your-Best-Self-with-Our-Exclusive-Gym-Special-Offer----Are-you-ready-to-transform-your-fitness-journey-and-achieve-your-health-goals-There-s-never-been-a-better-time-to-join-our-vibrant-community-of-fitness.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="item academy_img">
                            <div class="sport_card">
                                <video controls controlsList="nodownload" class="fast_track">
                                    <source src="https://f005.backblazeb2.com/file/bmpcdn90/academy/3203/Untitled-design--1-.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="inquiry-section clearfix">
                <div class="container">
                    <section>
                        <h2>Send your Inquiry Now</h2>
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="" id="" placeholder="Enter your full name">
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" name="" id="" placeholder="Enter your phone number">
                                </div>
                                <div class="col-md-12">
                                    <input type="email" name="" id="" placeholder="Enter your email address">
                                </div>

                                <div class="col-md-12">
                                    <textarea name="" id="" placeholder="Enter Your message"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-secondary" value="SUBMIT">
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </section>
        </div>

</section>


@endsection