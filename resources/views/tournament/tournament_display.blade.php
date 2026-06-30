@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/tournament_display_v3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/fancybox.css') }}" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/tournament_v13.js') }}" defer></script>
<script src="{{ asset('asset/js/fancybox.umd.js') }}"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>
@endpush
@php

$phone = '';

if (isset($data['d']) && isset($data['d']->phone)) {
$phoneParts = explode(',', $data['d']->phone);

if (!empty($phoneParts[0])) {
$firstPhone = trim($phoneParts[0]);
if (strpos($firstPhone, '+91') === 0) {
$firstPhone = substr($firstPhone, 3);
} elseif (strpos($firstPhone, '0') === 0) {
$firstPhone = substr($firstPhone, 1);
}
$phone = $firstPhone;
}
}
@endphp
@extends('layouts.app')
@section('content')


<section class="post-tournament-section clearfix">
    @php
    $photos = !empty($data['d']->photos) ? explode(',', $data['d']->photos) : [];
    $defaultBanner = 'https://f005.backblazeb2.com/file/bmpcdn90/default/football_banner.webp';
    $firstPhoto = !empty($photos) ? env('AWS_CF_BASE_URL') . '/league/' . $data['d']->id . '/' . $photos[0] : $defaultBanner;
    @endphp

    @if(count($photos) <= 1)
        <a href="{{ $firstPhoto }}" data-fancybox="photos-gallery" data-caption="">
        <div class="tournament_banner">
            <img src="{{ $firstPhoto }}" alt="Banner" style="border-radius: 25px;">
        </div>
        </a>
        @else
        <div class="academy-slider">
            <div class="rtl-slider-flex gap-3">
                <!-- Main Slider: Display the First Photo -->
                <a href="{{ $firstPhoto }}" data-fancybox="photos-gallery" data-caption="">
                    <div class="tournament_banner">
                        <img src="{{ $firstPhoto }}" alt="Banner" style="border-radius: 25px;">
                    </div>
                </a>

                <!-- Slider Navigation: Display Photos 2 to 5 -->
                <div class="rtl-slider-nav side_tournament_pic">
                    @foreach(array_slice($photos, 1, 4) as $photo)
                    @php
                    $photoUrl = env('AWS_CF_BASE_URL') . '/league/' . $data['d']->id . '/' . $photo;
                    @endphp
                    <a href="{{ $photoUrl }}" data-fancybox="photos-gallery" data-caption="">
                        <div class="rtl-slider-slide1">
                            <img src="{{ $photoUrl }}" alt="Slider Photo">
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
</section>


<section class="advertisements-section clearfix">
    <div class="container">
        <div class="advertisement-wrapper">
            <div class="bot-content">
                <div class="entry-winning">
                    <h6>
                        <span>Entry Fee:</span>
                        {{ isset($data['d']) && $data['d']->entry_fee ? '₹' . $data['d']->entry_fee : 'n/a' }}
                    </h6>

                    <h6><span>Winning:</span> {{ isset($data['d']) && $data['d']->winning_amount ? '₹' . $data['d']->winning_amount : 'n/a' }}</h6>
                </div>
                <h1 class="text-capitalize tournament_address" style="font-size: 24px;">{{ $data['d']->name ?? "" }}</h1>
                <p class="tournament_address">
                    <i class="fa-solid fa-location-dot"></i>
                    @if(!empty($data['d']->city) || !empty($data['d']->state) || !empty($data['d']->pincode))
                    {{ !empty($data['d']->city) ? $data['d']->city . ', ' : '' }}
                    {{ !empty($data['d']->state) ? $data['d']->state . ', ' : '' }}
                    {{ !empty($data['d']->pincode) ? $data['d']->pincode : '' }}
                    @else
                    <span>India</span>
                    @endif
                    @php
                    $venue = trim($data['d']->venue ?? '');
                    @endphp
                    @if(!empty($venue))
                    <strong>({{ $venue }})</strong>
                    @endif
                </p>

                @php
                function getOrdinalSuffix($number) {
                $suffixes = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
                if (($number % 100) >= 11 && ($number % 100) <= 13) {
                    return $number . 'th' ;
                    } else {
                    return $number . $suffixes[$number % 10];
                    }
                    }

                    $startDateTime=$endDateTime=null;

                    if (isset($data['d'])) {
                    if ($data['d']->event_starts_on) {
                    $startDateTime = new DateTime($data['d']->event_starts_on);
                    }
                    if ($data['d']->event_ends_on) {
                    $endDateTime = new DateTime($data['d']->event_ends_on);
                    }
                    }
                    @endphp

                    <ul>
                        @if($startDateTime)
                        <li><strong>Start Date:</strong> <i class="fa-regular fa-calendar-days"></i>
                            {{ getOrdinalSuffix($startDateTime->format('j')) }} {{ $startDateTime->format('F Y') }}
                        </li>
                        @endif
                        @if($startDateTime)
                        <li><i class="fa-regular fa-clock"></i>
                            {{ $startDateTime->format('h:i A') }}
                        </li>
                        @endif
                    </ul>

                    <ul>
                        @if($endDateTime)
                        <li><strong>End Date:</strong> <i class="fa-regular fa-calendar-days"></i>
                            {{ getOrdinalSuffix($endDateTime->format('j')) }} {{ $endDateTime->format('F Y') }}
                        </li>
                        @endif
                        @if($endDateTime)
                        <li><i class="fa-regular fa-clock"></i>
                            {{ $endDateTime->format('h:i A') }}
                        </li>
                        @endif
                    </ul>


                    @php
                    $subTournaments = json_decode($data['d']->sub_tournament ?? '[]', true);
                    @endphp

                    @if(!empty($subTournaments))
                    <ul>
                        @foreach($subTournaments as $tournament)
                        <li>
                            <i class="fa-solid fa-trophy"></i>
                            {{ $tournament['type'] ?? '' }},
                            <strong>{{ $tournament['ageGroup'] ?? '' }}</strong>,
                            {{ $tournament['numberOfPlayers'] ?? 0 }} Players
                        </li>
                        @endforeach
                    </ul>
                    @endif


                    @if( $data['d']->intro)
                    <hr>
                    <h2 style="font-size: 22px;">About</h2>
                    <p>{!! nl2br(e($data['d']->intro)) !!}</p>
                    @endif
                    @if( $data['d']->pathway)
                    <hr>
                    <h2 style="font-size: 22px;">Pathway</h2>
                    <p>{!! nl2br(e($data['d']->pathway)) !!}</p>
                    @endif

                    @if(!empty($data['advantages']) && count($data['advantages']) > 0 && $data['advantages'][0] !== "")
                    <hr>
                    <h2 style="font-size: 22px;">Advantages</h2>

                    @if (count($data['advantages']) === 1)
                    <!-- If there's only one advantage, display it in a paragraph -->
                    <p>{{ $data['advantages'][0] }}</p>
                    @else
                    <!-- If there are multiple advantages, display them in an ordered list -->
                    <ol>
                        @foreach ($data['advantages'] as $advantage)
                        <li>{{ $advantage }}</li>
                        @endforeach
                    </ol>
                    @endif
                    @endif

                    @if(!empty($data['rules']) && count($data['rules']) > 0 && $data['rules'][0] !== "")
                    <hr>
                    <h2 style="font-size: 22px;">Rules</h2>

                    @if (count($data['rules']) === 1)
                    <p>{{ $data['rules'][0] }}</p>
                    @else
                    <ol>
                        @foreach ($data['rules'] as $rule)
                        <li>{{ $rule }}</li>
                        @endforeach
                    </ol>
                    @endif
                    @endif
                    <hr>
                    <ul class="justify-content-between">
                        <li><strong>Sponsored by: </strong>{{ !empty($data['d']->sponsored_name) ? $data['d']->sponsored_name : "Not Available" }}</li>
                        <li><strong>Organized by: </strong>{{ !empty($data['d']->organised_by) ? $data['d']->organised_by : "Not Available" }}</li>
                        <li><button class="btn btn-secondary btn-lg" id="openWhatsappModal">Message</button></li>
                    </ul>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content whatsapp_modal">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel">Contact</h5>
                <div type="button" class="close" id="close_whatsapp" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" name="source" id="source_details" value="whatsapp" style="display: none;">
                <input type="hidden" name="sport" id="sport_details" value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}" style="display: none;">
                <input type="hidden" name="sport_id" id="sport_id_details" value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}" style="display: none;">
                <input type="hidden" name="object_id" id="object_id_details" value="{{ isset($data['d']->id) ? $data['d']->id : '' }}" style="display: none;">
                <input type="hidden" name="object_type" id="object_type_details" value="tournament" style="display: none;">
                <input type="hidden" name="loc_id" id="loc_id_details" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}" style="display: none;">
                <input type="hidden" id="listing_title" value="{{ isset($data['d']->name) ?  $data['d']->name : '' }}" style="display: none;">
                <input type="hidden" id="academy_address" value="{{ isset($data['d']->city) ?  $data['d']->city : '' }}" style="display: none;">

                <input type="hidden" id="academy_phone" value="{{ $phone }}" style="display: none;">
                <input type="hidden" name="screen" id="screen_details" value="message" style="display: none;">
                <span class="error" id="formError" style="display:none; color:red;"></span>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="name" id="details_name" placeholder="Please enter your name" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="email" id="details_email" placeholder="Please enter your email" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <input type="number" class="form-control" name="phone" id="details_phone" placeholder="Please enter your phone" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="address" id="details_address" placeholder="Please enter your address" autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <textarea class="form-control" name="description" rows="3" id="details_desc" placeholder="Please enter your message" autocomplete="off">
                        </textarea>

                </div>
                <button type="button" id="formSubmitButton" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>

@endsection