<!-- overview tab  -->
@foreach($data['abouttitle'] as $index => $abouttitle)
    <div class="mob_academy_box">
        <div class="mob_academy_fee_box mob_academy_fee_status">
            <h2>{{ $abouttitle }}</h2>
        </div>
        <div class="mob_overview_para">
            <span class="mob_overview_msg">{!! $data['aboutdes'][$index] !!}</span>
        </div>
    </div>
@endforeach
<!-- overview tab ends -->
