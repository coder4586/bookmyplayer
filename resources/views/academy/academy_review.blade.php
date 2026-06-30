@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/review.css') }}" type="text/css">
@endpush

@push('scripts')
<script src="{{ asset('asset/js/review_v2.js') }}" defer></script>
@endpush

@extends('layouts.own_business_app')
@section('content')

<!-- CONTENT SECTION -->
<section class="post-a-review-section clearfix">
    @if(Session::has('success_message_add_review_academy'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/success.gif" class="img-fluid" alt="Success">
                </figure>
                <h6> {{ Session::get('success_message_add_review_academy') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error_message_add_review_academy'))
    <div class="confirm-box" style="z-index: 10;">
        <div class="confirm-backdrop"></div>
        <div class="confirm-content">
            <div class="confirm-body">
                <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/error.gif" class="img-fluid" alt="Error"></figure>
                <h6> {{ Session::get('error_message_add_review_academy') }}</h6>
            </div>
            <div class="confirm-footer">
                <button class="get_back btn btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="profile-box mb-2">
            <figure><img src="{{$data['logo']}}" class="img-fluid" alt="Profile Image"></figure>
            <article>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-capitalize">{{$data['d']->name}}</h6>
                    <h6 class="text-capitalize"><span>{{$data['d']->sport ? $data['d']->sport : "sport"}}</span></h6>
                </div>
                <p><i class="fa-solid fa-location-dot"></i> {{$data['d']->city}}, {{$data['d']->state}}</p>
            </article>
        </div>
        @if(Session::has('comment_error'))
        <div class="alert alert-danger">
            <ul>
                @foreach(Session::get('comment_error') as $error)
                {{ $error }}
                <br>
                @endforeach
            </ul>
        </div>
        @endif

        @if(Session::has('comment_success'))
        <div class="alert alert-success">
            {{ Session::get('comment_success') }}
        </div>
        @endif

        <form method="POST" action="" id="reviewForm">
            @csrf
            <div class="start-reviewing-box">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5>Review {{$data['d']->name}}</h5>
                    <div id="full-stars-example">
                        <div class="rating-group">
                            <input class="rating__input" name="rating" id="rating-5" value="5" type="radio">
                            <label class="rating__label" for="rating-5">&#9733;</label>

                            <input class="rating__input" name="rating" id="rating-4" value="4" type="radio">
                            <label class="rating__label" for="rating-4">&#9733;</label>

                            <input class="rating__input" name="rating" id="rating-3" value="3" type="radio">
                            <label class="rating__label" for="rating-3">&#9733;</label>

                            <input class="rating__input" name="rating" id="rating-2" value="2" type="radio">
                            <label class="rating__label" for="rating-2">&#9733;</label>

                            <input class="rating__input" name="rating" id="rating-1" value="1" type="radio">
                            <label class="rating__label" for="rating-1">&#9733;</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 g-md-3 mt-2">
                    <input type="hidden" name="object_type" value="academy">
                    <input type="hidden" name="object_id" value="{{ $data['d']->id }}">
                    <span id="error-message" style="color: red; display: none;"></span>
                    <div class="col-md-6"><input type="text" name="name" id="review_name" class="form-control your-name" value=""
                            placeholder="Enter Full name"></div>
                    <div class="col-md-6"><input type="text" name="email" id="review_email" class="form-control your-email"
                            value="" placeholder="Enter Email address"></div>
                    <div class="col-12"><input type="number" name="phone" id="review_phone" class="form-control your-phone" value=""
                            placeholder="Phone Number"></div>
                    <div class="col-md-12"><textarea name="comment" id="review_comment" class="form-control"
                            placeholder="Type your Review here..."></textarea></div>
                    <div class="col-md-12 text-center"><button type="button" class="btn btn-secondary" id="review_academy_button">Post
                            Review</button></div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- /CONTENT SECTION -->
@endsection