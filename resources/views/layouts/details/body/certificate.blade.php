<!-- overview tab -->
@if($data['d']->certificate)
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>Certificates</h2>
    </div>
    <div class="mob_overview_para">
        <p>{{ $data['d']->certificate }}</p>
    </div>
</div>
@endif
<!-- overview tab ends -->