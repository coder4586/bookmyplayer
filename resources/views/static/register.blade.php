@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('asset/css/register.css') }}" type="text/css">
@endpush
@extends('layouts.app')
@section('content')
<section class="landing-options">
    <div class="landing-options-list">
        <div class="landing-options-list-flex">
            <div class="landing-options-list-wrapper">
                <div class="landing-options-item">
                    <a href="https://www.bookmyplayer.com/register-as-a-player" class="landing-options-link">
                        <div class="landing-options-img">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-item-img-1.jpg"
                                alt="" class="object-fit lazy">
                            <div class="landing-options-icon"><img
                                    src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-icon-1.png"
                                    alt="Register as a Player" class="lazy">
                            </div>
                        </div>
                        <div class="landing-options-content">
                            <h3>Register as a Player</h3>
                            <p>Participate in professional leagues, gain sponsorships and endorsements, and advance your
                                career in sports</p>
                            <button><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </a>
                </div>
                <div class="landing-options-item">
                    <a href="https://www.bookmyplayer.com/register-as-a-coach-trainer" class="landing-options-link">
                        <div class="landing-options-img">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-item-img-2.jpg"
                                alt="" class="object-fit lazy">
                            <div class="landing-options-icon"><img
                                    src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-icon-2.png"
                                    alt="Register as a Coach" class="lazy">
                            </div>
                        </div>
                        <div class="landing-options-content">
                            <h3>Register as a Coach</h3>
                            <p>Create your free profile today to start responding to leads and earning a regular income.
                                Stay ahead of the competition by ranking higher with our platform.
                            </p>
                            <button><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </a>
                </div>
                <div class="landing-options-item">
                    <a href="https://www.bookmyplayer.com/register-your-academy" class="landing-options-link">
                        <div class="landing-options-img">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-item-img-3.jpg"
                                alt="" class="object-fit lazy">
                            <div class="landing-options-icon"><img
                                    src="{{env('AWS_CF_BASE_URL')}}/asset/images/landing-options-icon-3.png"
                                    alt="Register as a Academy" class="lazy">
                            </div>
                        </div>
                        <div class="landing-options-content">
                            <h3>Register as a Academy</h3>
                            <p>Launch and grow your academy across India. Get discovered, respond to leads, and
                                participate in competitions.</p>
                            <button><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </a>
                </div>
            </div>
            <a href="https://www.bookmyplayer.com/register-as-other" target="_blank" class="btn-border">Register as Others <i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</section>
@endsection