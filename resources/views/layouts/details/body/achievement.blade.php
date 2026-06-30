<!-- overview tab -->
@if($data['d']->achievement)
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>Achievements</h2>
    </div>
    <div class="mob_overview_para">
        <p>{{ $data['d']->achievement }}</p>
    </div>
</div>
@endif
<!-- overview tab ends -->