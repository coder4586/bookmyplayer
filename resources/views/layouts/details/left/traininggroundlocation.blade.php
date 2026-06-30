<!-- training ground tab  -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box">
        <p class="mob_academy_fee_heading">Training Ground Location</p>
    </div>
    <div class="mob_academy_location_2">
        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/location_mob.svg" loading="lazy" alt="location" width="14" height="14">
        @if (empty($data['address']))
        <p class="mob_language_list">No location found</p>
        @else
        <p class="mob_language_list">{{ $data['address'] }}</p>
        @endif
    </div>
</div>
<!-- training ground tab ends -->
