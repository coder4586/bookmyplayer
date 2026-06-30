<!-- overview tab  -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box mob_academy_fee_status">
        <h2>
            {{
                            $data['cattype'] == "aid" ? "About " . $data['d']->name:
                            ($data['cattype'] == "tid" ? "About " . $data['title'] :
                            ($data['page'] == "player" ? "About " . $data['listingTitle'] : "Reviews"))
                        }}
        </h2>
    </div>
    <div class="mob_overview_para">
        @if( $data['cattype'] == "aid")
        <span class="mob_overview_msg">{!! nl2br($data['about']) !!}</span>
        @endif
        @if( $data['cattype'] == "tid")
        <span class="mob_overview_msg">{!! nl2br($data['des']) !!}</span>
        @endif
        @if( $data['page'] == "player")
        <span class="mob_overview_msg">{!! $data['about'] ? $data['about'] : "-" !!}</span>
        @endif
    </div>
</div>
<!-- overview tab ends -->
