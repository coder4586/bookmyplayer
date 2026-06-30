<div class="mob_academy_box">
    <!-- <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>
        Reviews & Ratings 
        </h2>

        <div>
            <div class="stars_up">
                <div class="mob_academy_small_star review_top_span">
                    <div class="review_number">
                        <span class="review_text" style="color:#fff">{!! $data['d']->rating ?? '3.1' !!}</span>
                    </div>
                    <div class="mobile_academy_stars_small" style="--star_rating: {{$data['d']->rating ?? '3.1'}}" aria-label="Rating of this product is 3 out of 5."></div>
                    <div>
                        <span class="review_text">{!! $data['d']->reviews ?? '23' !!} Ratings</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>
            Reviews & Ratings
        </h2>

        <button class="mob_academy_rate_btn trigger-review">Rate this Academy</button>
        <div>
            <div class="stars_up">
                <div class="mob_academy_small_star review_top_span">
                    <div class="review_number">
                        <span class="review_text" style="color:#fff">{!! $data['d']->rating ?? '3.1' !!}</span>
                    </div>
                    <div class="mobile_academy_stars_small" style="--star_rating: {{$data['d']->rating ?? '3.1'}}" aria-label="Rating of this product is 3 out of 5."></div>
                    <div>
                        <span class="review_text">{!! $data['d']->reviews ?? '23' !!} Reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mob_overview_para">
        <form method="POST" action="{{ route('post.academy.comment') }}">
            @csrf
            <div class="give_review" id="review-section">
                <div class="mob_academy_gold_star">
                    <div class="rate-star-modal">
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="Its Ok - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="Very bad - 1 star"></label>
                        </fieldset>
                    </div>
                </div>

                <div class="input_review">
                    <input type="hidden" name="object_type" value="academy">
                    <input type="hidden" name="object_id" value="{{ $data['id'] }}">
                    <input type="text" name="name" placeholder="Enter Your Name" class="mob_academy_msg_input" id="mob_new_name">
                    <textarea name="comment" id="comment" cols="20" rows="5" placeholder="Type your Review Here" class="mob_academy_msg_input mob_desc-2"></textarea>
                    <div class="mob_academy_send_btn">
                        <button type="submit">Send <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/send.svg" loading="lazy" alt="send" width="14" height="14"></button>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="mob_academy_reply_wrapper">

            @foreach($data['reviews'] as $reivew)
            <div class="comment_list">
                <div class="mob_academy_review_name">
                    <div class="mob_academy_review_person">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mob_reply.svg" loading="lazy" alt="reply" width="18" height="18">
                        <p class="mob_academy_person_name">{{ $reivew->name }}</p>
                    </div>
                    <div>
                        <p class="mob_academy_min">{{ (new DateTime($reivew->creation_date))->format('Y-m-d (H:i)') }}</p>
                    </div>
                </div>

                <div class="mob_academy_small_star">
                    <div class="mobile_academy_stars_small" style="--star_rating: {{ $reivew->rating }}" aria-label="Rating of this product is 3 out of 5."></div>
                </div>

                <div class="mob_academy_review_para">
                    <p>{{ $reivew->comment }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>