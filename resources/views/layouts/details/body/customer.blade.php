@if ($data['d']->review_summary || !empty($data['positive']) || !empty($data['negative']) || !empty($data['neutral']))
    <div class="mob_academy_box">
        <div class="mob_academy_fee_box">
            <p class="mob_academy_fee_heading">Review of {{ $data['title'] }}</p>
        </div>
        <div class="mob_academy_location_2 customer_box">
            @if($data['d']->review_summary)
            <p class="fb_fonts customer_para">
                {{$data['d']->review_summary}}
            </p>
            @endif
            <p class="fb_font customer_message">AI-generated from the text of student reviews. BookMyPlayer</p>

            @if (!empty($data['positive']))
                <p class="fb_font customer_posetive">
                    <span>Positive:</span>
                    @foreach ($data['positive'] as $pos)
                        <span class="customer_option">{{ ucwords($pos) }}</span>
                        @if (!$loop->last)<span>|</span>@endif
                    @endforeach
                </p>
            @endif

            @if (!empty($data['negative']))
                <p class="fb_font customer_posetive">
                    <span>Negative:</span>
                    @foreach ($data['negative'] as $neg)
                        <span class="customer_option">{{ ucwords($neg) }}</span>
                        @if (!$loop->last)<span>|</span>@endif
                    @endforeach
                </p>
            @endif

            @if (!empty($data['neutral']))
                <p class="fb_font customer_posetive">
                    <span>Neutral:</span>
                    @foreach ($data['neutral'] as $neut)
                        <span class="customer_option">{{ ucwords($neut) }}</span>
                        @if (!$loop->last)<span>|</span>@endif
                    @endforeach
                </p>
            @endif

        </div>
    </div>
@endif
