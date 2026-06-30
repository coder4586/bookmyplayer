@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/review_page_v4.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/review.css') }}" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/review_page_v5.js') }}" defer></script>
<script src="{{ asset('asset/js/review_v2.js') }}" defer></script>
@endpush
@php
$arrowImgUrl = env('AWS_CF_BASE_URL') . '/asset/images/breadcrumb_arrow.svg';
$review_stats= $data['review_stats'];
$totalReview = $review_stats['total_review'];
$averageRating = $review_stats['average_rating'];
$percentage = $review_stats['percentages'];
$variables = [];

$fullStars = floor($averageRating);
$halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
$emptyStars = 5 - $fullStars - $halfStar;
$address = $data['address'] ?? 'India';
$postcode = $data['d']->postcode ?? '';
@endphp
@foreach($percentage as $key => $value)
@php
$variables[$key] = $value;
@endphp
@endforeach
@extends('layouts.app')
@section('content')

<section class="academy-club-rating clearfix">
    <input type="hidden" style="display: none;" value="{{ $data['d']->sport_id }}" id="sportId">
    <input type="hidden" style="display: none;" value="{{ $totalReview }}" id="totalReviews">
    @if(Session::has('success_message_add_review_academy'))
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
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
    <div class="confirm-box review_box" style="z-index: 10;">
        <div class="confirm-backdrop confirm-backdrop-review"></div>
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
        <section>
            <div class="row">
                <div class="col-md-5 col-lg-4">
                    <div class="ratings-reviews">
                        <h1>{{ $data['d']->name }}</h1>
                        <p class="review_top_address text-capitalize">
                            {{ $address }}
                            @if($postcode && !str_contains($address, $postcode))
                            , {{ $postcode }}
                            @endif
                        </p>
                        <div class="rating">
                            <div class="stars">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa-regular fa-star"></i>
                                        @endfor
                            </div>
                            <div class="outof">{{ $averageRating }} out of 5</div>
                        </div>
                        <p><span class="toal_count_review"></span> ratings across the web</p>
                        <div class="star-percentage">
                            <div class="star">5 <i class="fa-solid fa-star"></i></div>
                            <div class="progress">
                                <div class="review_bar review_bar5" style="width: {{ $variables[5] ?? 0 }}%; background-color: #068743;"></div>
                            </div>
                            <div class="percentage" id="percentage_5"> {{ $variables[5] ?? 0 }}%</div>
                        </div>
                        <div class="star-percentage">
                            <div class="star">4 <i class="fa-solid fa-star"></i></div>
                            <div class="progress">
                                <div class="review_bar review_bar4" style="width: {{ $variables[4] ?? 0 }}%; background-color: #64CE23;"></div>
                            </div>
                            <div class="percentage" id="percentage_4"> {{ $variables[4] ?? 0 }}%</div>
                        </div>
                        <div class="star-percentage">
                            <div class="star">3 <i class="fa-solid fa-star"></i></div>
                            <div class="progress">
                                <div class="review_bar review_bar3" style="width: {{ $variables[3] ?? 0 }}%; background-color: #F9B53D;"></div>
                            </div>
                            <div class="percentage" id="percentage_3"> {{ $variables[3] ?? 0 }}%</div>
                        </div>
                        <div class="star-percentage">
                            <div class="star">2 <i class="fa-solid fa-star"></i></div>
                            <div class="progress">
                                <div class="review_bar review_bar2" style="width: {{ $variables[2] ?? 0 }}%; background-color: #EC803D;"></div>
                            </div>
                            <div class="percentage" id="percentage_2"> {{ $variables[2] ?? 0 }}%</div>
                        </div>
                        <div class="star-percentage">
                            <div class="star">1 <i class="fa-solid fa-star"></i></div>
                            <div class="progress">
                                <div class="review_bar review_bar1" style="width: {{ $variables[1] ?? 0 }}%; background-color: #F52833;"></div>
                            </div>
                            <div class="percentage" id="percentage_1"> {{ $variables[1] ?? 0 }}%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="ratings-wrapper">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ratings">
                                    <div class="box">{{ $averageRating }}</div>
                                    <h2>{{ $totalReview }} Ratings</h2>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <p>BookMyPlayer rating index based on {{ $totalReview }} ratings across the web</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="star-box">
                                        <ul class="star-box2">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <li><i class="fa-solid fa-star"></i></li>
                                                @endfor
                                                @if ($halfStar)
                                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                @endif
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <li><i class="fa-solid fa-star opacity40"></i></li>
                                                    @endfor
                                        </ul>
                                    </div>
                                    <button class="btn btn-secondary" id="openCustomModal">Review Now</button>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<section class="most-useful-reviews clearfix">
    <div class="container">
        <section>
            <h2 class="visibility_hidden">Rating & Reviews</h2>
            <div class="reviews-tab-content visibility_hidden">
                <ul>
                    <li class="latest_review"><a href="javascript:void(0)" class="reviewsselect">Latest</a></li>
                    <li class="top_review"><a href="javascript:void(0)">High to Low</a></li>
                    <li class="low_review"><a href="javascript:void(0)">Low to High</a></li>
                </ul>
            </div>
            <div class="reviews-tab-details">
                <div>
                    <div class="person_review">
                        <div style="text-align: center;">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" width="40" height="40" alt="loader">
                        </div>

                    </div>


                    <div class="pagination-section clearfix">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination1">
                            </ul>
                        </nav>
                    </div>
                </div>



                <div style="display:none;">

                    <div class="top_person_review">
                    </div>


                    <div class="pagination-section clearfix">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination2">
                            </ul>
                        </nav>
                    </div>
                </div>


                <div style="display:none;">

                    <div class="low_person_review">
                    </div>


                    <div class="pagination-section clearfix">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination3">
                            </ul>
                        </nav>
                    </div>
                </div>
        </section>
    </div>
    </div>
</section>

<section class="rate-us-form clearfix">
    <div class="container">
        <section class="clearfix">
            <form action="" class="exp_form">
                @csrf
                <h3>How would you rate your experience?</h3>
                <div id="new_star">
                    <div class="rating-group">
                        <input class="rating__input rating__input1" name="new_rating" id="new_rating-5" value="5" type="radio">
                        <label class="rating__label" for="new_rating-5">&#9733;</label>

                        <input class="rating__input rating__input1" name="new_rating" id="new_rating-4" value="4" type="radio">
                        <label class="rating__label" for="new_rating-4">&#9733;</label>

                        <input class="rating__input rating__input1" name="new_rating" id="new_rating-3" value="3" type="radio">
                        <label class="rating__label" for="new_rating-3">&#9733;</label>

                        <input class="rating__input rating__input1" name="new_rating" id="new_rating-2" value="2" type="radio">
                        <label class="rating__label" for="new_rating-2">&#9733;</label>

                        <input class="rating__input rating__input1" name="new_rating" id="new_rating-1" value="1" type="radio">
                        <label class="rating__label" for="new_rating-1">&#9733;</label>
                    </div>
                </div>
                <h6 id="love-heading"></h6>
                <div class="love-box mb-4">
                    <ul>
                    </ul>
                </div>
                <ul class="criteria-list"></ul>
                <div class="row g-2 g-md-3 mb-3">
                    <div class="col-md-6"><input type="text" name="name" id="review_exp_name" class="form-control your-name" value=""
                            placeholder="Enter Full name"></div>
                    <div class="col-md-6"><input type="number" name="phone" id="review_exp_phone" class="form-control your-phone" value=""
                            placeholder="Enter Your Phone_number"></div>
                    <div class="col-12"><input type="text" name="email" id="review_exp_email" class="form-control your-email"
                            value="" placeholder="Enter Email address"></div>

                </div>
                <h3>Tell us about your experience</h3>
                <textarea name="" id="experience_details"
                    placeholder="Please share your experience."></textarea>
                <div class="review-box experienece_review">
                    <div class="row img-gallery experienece_img"></div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="add-new-file">
                            <label class="filelabel">
                                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/upload-photo.svg" alt="Images" loading="lazy" width="31" height="31">
                                <span class="title">
                                    Upload Photos
                                </span>
                                <input class="FileUpload1" id="reviewFileInput" name="booking_attachment[]" type="file" multiple accept="image/*" />
                            </label>
                        </div>

                    </div>
                </div>
                <div>
                    <span class="exp_error" style="color:red; display:none;"></span>
                </div>
                <button type="button" class="btn btn-secondary mt-3" id="review_exp_submit">Submit Review</button>
            </form>
            <div class="breadcrumbs_review mt-3 text-capitalize">

                @if(!empty($data['breadcrumbs_review']))
                @foreach($data['breadcrumbs_review'] as $key => $breadcrumb)
                @if(!empty($breadcrumb->link))
                <a href="{{ $breadcrumb->link }}">{{ $breadcrumb->name }}</a>
                @else
                <span>{{ $breadcrumb->name }}</span>
                @endif

                @if($key < count($data['breadcrumbs_review']) - 1)
                    <img src="{{ $arrowImgUrl }}" alt="Arrow" loading="lazy">
                    @endif
                    @endforeach
                    @endif

            </div>

        </section>

    </div>
</section>

<section class="rate-us-form clearfix">
    <div class="container">
        <section class="disclaimer clearfix mt-3 mb-3">
            <h4 style="font-size: 18px;" class="fw-bold">Check Out Reviews for {{ $data['d']->name }} on BookMYPlayer
                <h4>
                    <p>Before signing up for any academy or sports program, it’s always a good idea to explore reviews and feedback from others who have been there. Reviews offer valuable perspectives, allowing you to learn from the experiences of others. While every individual may have unique preferences and expectations, reviews provide an overview of what you can look forward to—or watch out for.
                    </p>
                    <p>
                        On BookMYPlayer, you’ll find reviews for {{ $data['d']->name }} organized by relevance, posting date, and ratings. You can filter and browse these reviews to suit your needs. Every opinion shared here comes directly from users, making them honest and unbiased. By reading these first-hand accounts, you’ll gain clarity about what {{ $data['d']->name }} has to offer and whether it matches your goals.
                    </p>
                    <p>
                        In today’s world, detailed reviews have become an essential tool for decision-making. They give a realistic picture of how well an academy meets the needs of its players. Feedback from users doesn’t just help others; it also provides valuable input to academies, encouraging them to improve their services and adapt to evolving expectations. This creates a win-win situation for both trainees and the academy.
                    </p>
                    <p>
                        We invite you to share your experience with {{ $data['d']->name }} here on BookMYPlayer. Your insights could be the deciding factor for someone else looking to make the right choice. Whether it’s about the facilities, coaching quality, or overall experience, your honest opinion matters and helps foster a more informed and supportive sports community.
                    </p>
                    <p>
                        Take a moment to explore what others have said about {{ $data['d']->name }} here on BookMYPlayer. Their experiences will help you make a confident, informed choice and ensure that you pick the academy best suited to your needs.
                    </p>
        </section>
        <section class="other-links-section nearby_location mb-3 hidden">
            <h4 style="font-size:18px" class="fw-bold mb-3 heading_border text-capitalize">
                <span class="text-capitalize">
                    {{ $data['d']->sport ? $data['d']->sport : "Sport" }}
                </span>
                Training in
                @if($data['d']->address2 && $data['d']->address2 !== $data['d']->city)
                {{ $data['d']->address2 }}
                @endif
                @if($data['d']->city && $data['d']->state && $data['d']->city === $data['d']->state)
                {{ $data['d']->city }}
                @else
                {{ $data['d']->city ? $data['d']->city : "" }}{{ $data['d']->city && $data['d']->state ? ", " : "" }}{{ $data['d']->state ? $data['d']->state : "" }}
                @endif
            </h4>


            <ul style="cursor:pointer" class="other_review_links">
            </ul>
        </section>
        <section class="other-links-section other_sport_location mt-3 mb-3 hidden">
            <h4 style="font-size:18px" class="fw-bold mb-3 heading_border text-capitalize">Play <span class="text-capitalize">Sports</span> In
                @if($data['d']->city && $data['d']->state && $data['d']->city === $data['d']->state)
                {{ $data['d']->city }}
                @else
                {{ $data['d']->city ? $data['d']->city : "" }}{{ $data['d']->city && $data['d']->state ? ", " : "" }}{{ $data['d']->state ? $data['d']->state : "" }}
                @endif
            </h4>
            <ul style="cursor:pointer" class="other_sport_review_links">
            </ul>
        </section>
        <section class="other-links-section top_location mt-3 mb-3 hidden">
            <h4 style="font-size:18px" class="fw-bold mb-3 heading_border"><span class="text-capitalize">{{ $data['d']->sport ? $data['d']->sport : "Sport" }}</span> Training In Popular Cities</h4>
            <ul style="cursor:pointer" class="top_review_links">
            </ul>
        </section>
    </div>

</section>


<div id="customModalOverlay" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <span class="custom-close-btn"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt="Cross" width="24" height="24"></span>
        <div class="custom-modal-content">
            <section class="post-a-review-section clearfix">
                <div class="container">
                    <div class="profile-box mb-2">
                        <figure><img src="{{$data['logo']}}" class="img-fluid" alt="Profile Image"></figure>
                        <article>
                            <div class="d-flex justify-content-between align-items-start">
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

                    <form method="POST" action="{{ route('add.academy.review') }}" id="reviewForm">
                        @csrf
                        <div class="start-reviewing-box">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <h5>Review {{$data['d']->name}}</h5>
                                <div id="full-stars-example">
                                    <div class="rating-group">
                                        <input class="rating__input rating__input2 modal_rating_input" name="rating" id="rating-5" value="5" type="radio">
                                        <label class="rating__label" for="rating-5">&#9733;</label>

                                        <input class="rating__input rating__input2 modal_rating_input" name="rating" id="rating-4" value="4" type="radio">
                                        <label class="rating__label" for="rating-4">&#9733;</label>

                                        <input class="rating__input rating__input2 modal_rating_input" name="rating" id="rating-3" value="3" type="radio">
                                        <label class="rating__label" for="rating-3">&#9733;</label>

                                        <input class="rating__input rating__input2 modal_rating_input" name="rating" id="rating-2" value="2" type="radio">
                                        <label class="rating__label" for="rating-2">&#9733;</label>

                                        <input class="rating__input rating__input2 modal_rating_input" name="rating" id="rating-1" value="1" type="radio">
                                        <label class="rating__label" for="rating-1">&#9733;</label>
                                    </div>
                                </div>
                                <h6 id="love-heading2"></h6>
                                <div class="love-box2 mb-4">
                                    <ul>
                                    </ul>
                                </div>
                                <ul class="criteria-list2"></ul>
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
        </div>
    </div>
</div>

@endsection