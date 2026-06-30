@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/other_service_v1.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/other_service_v2.js') }}" defer></script>
@endpush

@extends('layouts.app')
@section('content')

<section class="other-services-section">
    <div class="container">
        <h2>Buy Our Services</h2>
        <p>with our curated plans for you</p>

        <section class="services-wrapper">
        <div class="service">
                <article>
                    <h6>International Marketing</h6>
                    <p>
                        International marketing involves promoting products globally, adapting strategies, managing global campaigns, analyzing markets, and building brand awareness...</p>
                    <button class="btn btn-primary view-details" data-service="International Marketing">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img02.png" alt="International Marketing"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Post Tournaments</h6>
                    <p>Promote your tournaments with ease! Post detailed event listings to attract participants, engage audiences, and drive registrations...</p>
                    <button class="btn btn-primary view-details" data-service="Post Tournaments">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img05.png" alt="Post Your Tournaments"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Organize Your Events</h6>
                    <p>Organize your events effortlessly with our platform. Manage teams, schedules, and results seamlessly...</p>
                    <button class="btn btn-primary view-details" data-service="Organize Your Events">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img06.png" alt="Organize Events" loading="lazy"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Promote Your Product</h6>
                    <p>Boost your product visibility by featuring it on BookMyPlayer! Connect with top talent and reach a targeted audience effortlessly...</p>
                    <button class="btn btn-primary view-details" data-service="Promote Your Product">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img04.png" alt="Promote Product" loading="lazy"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Bulk Coach Connection Service</h6>
                    <p>Our City & Sports-Specific Bulk Coach Connection Service is designed for organizations
                        looking to connect with multiple coaches...</p>
                    <button class="btn btn-primary view-details" id="openWhatsappModal" data-service="Bulk Coach Connection Service">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img01.png" alt="Bulk Coach Service" loading="lazy"></figure>
            </div>
           
            <div class="service">
                <article>
                    <h6>Banners</h6>
                    <p>Enhance your site with diverse banners! Showcase multiple designs to capture attention, promote various offers, and boost engagement...</p>
                    <button class="btn btn-primary view-details" data-service="Banners">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img03.png" alt="Banners Service" loading="lazy"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Featured Listing</h6>
                    <p>Get noticed with Featured Listings! Highlight your top products or services, gain premium visibility, and attract more attention effortlessly...</p>
                    <button class="btn btn-primary view-details" data-service="Featured Listing">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img04.png" alt="Featured Listing Service" loading="lazy"></figure>
            </div>
           
            <div class="service">
                <article>
                    <h6>Rent Your Sports Venue</h6>
                    <p>Maximize exposure by renting your sports venue! List it on our platform to attract bookings, streamline reservations, and boost revenue...</p>
                    <button class="btn btn-primary view-details" data-service="Rent Your Sports Venue">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img02.png" alt="Rent Venue" loading="lazy"></figure>
            </div>
            <div class="service">
                <article>
                    <h6>Sports Campaign Awareness</h6>
                    <p>A sports campaign awareness strategy includes targeted messaging, social media promotion, community engagement, event sponsorships, influencer partnerships, and multimedia content...</p>
                    <button class="btn btn-primary view-details" data-service="Sports Campaign Awareness">View Details <i class="fa-solid fa-angle-right"></i></button>
                </article>
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/other-service-img01.png" alt="Sports Campaign" loading="lazy"></figure>
            </div>
          
        </section>
    </div>
    <div class="payment-container">
        <div class="payment-info">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/payment_shield.png" alt="Shield Icon" class="shield-icon" loading="lazy">
            <div class="safe_transaction">
                <h6>100% Safe Transactions</h6>
                <p>We support secure payment methods</p>
            </div>
        </div>
        <div class="payment-icons">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/visa.png" alt="Visa" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/upi.png" alt="UPI" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/razorpay.png" alt="Razorpay" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mastercard.png" alt="Mastercard SecureCode" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rupay.png" alt="RuPay" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/norton.png" alt="Norton" loading="lazy">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/maestro.png" alt="Maestro" loading="lazy">
        </div>
    </div>
</section>

<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel"></h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <span class="error" id="formError" style="display:none; color:red;"></span>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="name" id="details_name" placeholder="Enter your name" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="email" id="details_email" placeholder="Enter your email" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <input type="number" class="form-control" name="phone" id="details_phone" placeholder="Enter your phone" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <textarea class="form-control" name="description" rows="3" id="details_desc" placeholder="Enter your description" autocomplete="off">
                        </textarea>
                </div>

                <div class="captcha-container">
                    <label id="mathCaptcha" class="captcha-box"></label>
                    <input type="number" id="captchaInput" class="form-control" placeholder="Answer" required>
                    <div class="captcha-refresh"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/icon-resend.svg" loading="lazy" width="25" height="25" alt="Refresh"></div>
                </div>

                <button type="button" id="formSubmitButton" class="btn btn-primary mt-3">Send</button>
            </div>
        </div>
    </div>
</div>




@endsection