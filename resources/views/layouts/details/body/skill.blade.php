
<!-- overview tab -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>Skills</h2>
    </div>
    <div class="mob_overview_para">
        <ul>
            @php
            $skills = $data['d']->skill ? explode(',', $data['d']->skill) : ["Coach"];
            @endphp
            @foreach($skills as $skill)
            <li>{{ $skill }}</li>
            @endforeach
        </ul>
    </div>
</div>
<!-- overview tab ends -->
