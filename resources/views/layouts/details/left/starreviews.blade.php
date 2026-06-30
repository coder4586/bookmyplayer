<!-- progress bar tab  -->
<div class="mobile_academy_review">
    <div>
        <div class="mobile_academy_review_call">
            <span class="icon-container">5</span>
            <div class="mobile_academy_progress">
                <div class="mobile_academy_progress_done" data-done=""></div>
            </div>
            <span class="mobile_academy_percent"></span>
        </div>
        <div class="mobile_academy_review_call">
            <span class="icon-container">4</span>
            <div class="mobile_academy_progress">
                <div class="mobile_academy_progress_done" data-done=""></div>
            </div>
            <span class="mobile_academy_percent"></span>
        </div>
        <div class="mobile_academy_review_call">
            <span class="icon-container">3</span>
            <div class="mobile_academy_progress">
                <div class="mobile_academy_progress_done" data-done=""></div>
            </div>
            <span class="mobile_academy_percent"></span>
        </div>
        <div class="mobile_academy_review_call">
            <span class="icon-container">2</span>
            <div class="mobile_academy_progress">
                <div class="mobile_academy_progress_done" data-done=""></div>
            </div>
            <span class="mobile_academy_percent"></span>
        </div>
        <div class="mobile_academy_review_call">
            <span class="icon-container">1</span>
            <div class="mobile_academy_progress">
                <div class="mobile_academy_progress_done" data-done=""></div>
            </div>
            <span class="mobile_academy_percent"></span>
        </div>
    </div>
    <div class="star-mobile_academy_review_calls">
        <span>
            @if($data['cattype'] == "aid")
            {{ $data['d']->rating ? $data['d']->rating : "0" }}
            @elseif($data['cattype'] == "tild")
            "2.8"
            @elseif($data['cattype'] == "certificate")
            3.8
            @endif
        </span>
        <div class="mobile_academy_stars" style="--star_rating: 4" aria-label="Rating of this product is 4 out of 5.">
        </div>
        <p>
            @if($data['cattype'] == "aid")
            {{ $data['d']->reviews ? $data['d']->reviews : "0" }}
            @elseif($data['cattype'] == "tild")
            21
            @elseif($data['cattype'] == "certificate")
            30
            @endif
            Reviews</p>
    </div>
</div>
<!-- progress bar tab ends -->