<section class="oc_section">
    @foreach($data['coaches'] as $coach)
    @if($data['id'] !== $coach->id)
    <div class="other_coach">
        <div class="oc_flex">
            <div class="other_coach_img">
            @if($coach->profile_img)
                <img src="{{ env('AWS_S3_BASE_URL') }}/coach/{{ $coach->id }}/{{ $coach->profile_img }}" loading="lazy" alt="coach images" >
            @else
                <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/logo.svg" alt="Placeholder Image" loading="lazy" class="grey_border">
            @endif
            </div>
            <div>
                <div class="oc_new_flex">
                    <span class="oc_name">{{ $coach->name }}</span>
                    <span class="oc_message">{{ $coach->sport }}</span>
                </div>
            </div>
        </div>
        <div class="oc_send">
            <a href="{{$coach->url}}" target = "_blank">
            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/send_coach.png" loading="lazy" alt="send icon">
            </a>
        </div>
    </div>
    @endif
    @endforeach
</section>
