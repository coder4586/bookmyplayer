<!-- verified info section  -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <div class="mob_academy_verify">
            <p class="mob_academy_verified">Verified Info</p> <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/star_tick.svg"
                loading="lazy" alt="verified" width="20" height="20">
        </div>
    </div>
    <div class="mob_academy_verify_content">
        @if($data['cattype'] !== "certificate" && $data['d']->email)
        <!-- <div class="mob_academy_grey_tick">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/grey_tick.svg') }}" loading="lazy" alt="tick" width="16" height="16">
            <p class="mob_academy_grey_email">{{ $data['d']->email }}</p>
        </div> -->
        @endif

        @if($data['cattype'] == "certificate")
        <div class="mob_academy_grey_tick">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/grey_tick.svg" loading="lazy" alt="tick" width="16" height="16">
            <p class="mob_academy_grey_email">{{ $data['d']->contact }}</p>
        </div>
        @else
        <div class="mob_academy_grey_tick">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/grey_tick.svg" loading="lazy" alt="tick" width="16" height="16">
            <p class="mob_academy_grey_email">+91 {{ $data['d']->phone }}</p>
        </div>
        @endif


        @if($data['d']->website)
        <div class="mob_academy_grey_tick">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/grey_tick.svg" loading="lazy" alt="tick" width="16" height="16">
            <p class="mob_academy_grey_email"><a href="{{ $data['d']->website }}" target="_blank">{{ $data['d']->website }}</a></p>
        </div>
        @endif

        @if($data['cattype'] == "aid")
        @if($data['d']->map)
        <div class="mob_academy_grey_tick">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/grey_tick.svg" loading="lazy" alt="tick" width="16" height="16">
            <p class="mob_academy_grey_email"><a href="{{ $data['d']->map }}">Google Location</a></p>
        </div>
        @endif
        @endif
    </div>

</div>
 <!-- verified info section ends -->