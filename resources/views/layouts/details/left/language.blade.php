<!-- language spoken tab -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box">
        <p class="mob_academy_fee_heading">Language Spoken</p>
    </div>
    <div class="mob_academy_language">
        @php
            $spokenLanguages = !empty($data['d']->spoken_languages) ? explode(',', $data['d']->spoken_languages) : ['Hindi', 'English'];
        @endphp

        @foreach($spokenLanguages as $language)
            <p class="mob_language_list">{{ trim($language) }}</p>
        @endforeach
    </div>
</div>
<!-- language spoken tab ends -->
