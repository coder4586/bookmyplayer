<!-- overview tab -->
@if($data['d']->education)
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>Education</h2>
    </div>
    <div class="mob_overview_para">
        <p>{{ $data['d']->education }}</p>
    </div>
</div>
@endif
<!-- overview tab ends -->