<!-- review section  -->

<section class="review_wrapper">
    <div class="mob_academy_review">
        @if(session('comment_success'))
        <div class="alert alert-success text-center">
            {{ session('comment_success') }}
        </div>
        @endif
        <div class="mob_academy_rating_top">
            <h3 class="mob_acacdemy_review_heading">{!! $data['d']->rating ?? '4' !!} Rating of {!! $data['d']->reviews ?? '23' !!} Review's</h3>
            <button class="mob_academy_rate_btn trigger-review">Rate this Academy</button>
        </div>



        <!-- start  -->
        <div class="mob_academy_reply_wrapper">

            @foreach($data['reviews'] as $reivew)
            <div class="comment_list">
                <div class="mob_academy_review_name">
                    <div class="mob_academy_review_person">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mob_reply.svg" loading="lazy" alt="reply" width="18"
                            height="18">
                        <p class="mob_academy_person_name">{{ $reivew->name }}</p>
                    </div>
                    <div>
                    <p class="mob_academy_min">{{ (new DateTime($reivew->creation_date))->format('Y-m-d (H:i)') }}</p>
                    </div>
                </div>

                <div class="mob_academy_small_star">
                    <div class="mobile_academy_stars_small" style="--star_rating: {{ $reivew->rating }}"
                        aria-label="Rating of this product is 3 out of 5."></div>
                </div>

                <div class="mob_academy_review_para">
                    <p>{{ $reivew->comment }}</p>
                </div>
            </div>
            @endforeach

        </div>


        <!-- end -->
    </div>
</section>


<!-- review section ends -->
