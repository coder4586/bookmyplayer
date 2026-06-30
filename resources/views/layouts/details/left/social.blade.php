<!-- <div class="mob_academy_box mob_social">
    <div class="mob_academy_fee_box">
        <p class="mob_academy_fee_heading">Follow Academy On Social</p>
    </div>
    <div class="mob_academy_social mob_media">
        @if($data['cattype'] == "player")
        <a href="{{ $data['d']->social_profile }}" target="_blank">
        @else
        <a href="{{ $data['cattype'] == "aid" && $data['d']->instagram ? 'https://www.instagram.com/' . str_replace('@', '', $data['d']->instagram) : '#' }}" target="_blank">
        @endif
        <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/instagram.png" loading="lazy" alt="instagram" width="28" height="28">
        </a>
        <a href="{{ $data['cattype'] == "aid" ? $data['d']->facebook : ""}}" target="_blank">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/facebook_mob.png" loading="lazy" alt="facebook" width="28" height="28">
        </a>
    </div>
</div>

 -->
