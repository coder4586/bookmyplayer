<!-- Add FancyBox3 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

@php
$photoCount = !empty($data['photos']) && !(count($data['photos']) === 1 && $data['photos'][0] === "") ? count($data['photos']) : 0;
$videoCount = !empty($data['videos']) && !(count($data['videos']) === 1 && $data['videos'][0] === "") ? count($data['videos']) : 0;
$totalMedia = $photoCount + $videoCount;
@endphp

@if($totalMedia > 0)
<div class="mob_academy_pic" id="img_section">
    <div class="mob_academy_tab_list_2 mob_academy_all_list_2">
        <div class="nav" id="nav-tab" role="tablist">
            <ul>
               @if($photoCount > 0 && $videoCount>0)
                <li class="mob_list_li" id="photoClick">
                    Videos and Photos({{ $totalMedia }})
                </li>
                @elseif($videoCount > 0 && $photoCount === 0)
                <li class="mob_list_li" id="videoClick">
                    Videos({{ $totalMedia }})
                </li>
                @elseif($photoCount > 0 && $videoCount === 0)
                <li class="mob_list_li" id="photoClick">
                    Photos({{ $totalMedia }})
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div id="profile_photo_div">
        @if($videoCount > 0)
            @foreach($data['videos'] as $video)
            <div class="mob_card_pic">
            <a data-fancybox="media" href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $video }}" class="fancybox" type="video/mp4">
                <video controls class="fast_track">
                    <source src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $video }}" type="video/mp4">
                </video>
            </a>
            </div>
            @endforeach
        @endif
        @if($photoCount>0)
        @foreach($data['photos'] as $photo)
        <div class="mob_card_pic">
        <a href="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $photo }}" data-fancybox="gallery" data-caption="Media">
            <img src="{{ env('AWS_CF_BASE_URL') . '/' . ($data['page'] == 'coach' ? 'coach' : 'academy') . '/' . $data['d']->id . '/' . $photo }}" loading="lazy" alt="images" />
        </a>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });

</script>
