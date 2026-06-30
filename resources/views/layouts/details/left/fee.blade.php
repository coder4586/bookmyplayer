<!-- Fee Batch Tab -->
@include('layouts.details.modal')
@php
$object_type = $data['cattype'] == "aid" ? "academy" : "tournament";
if ($data['cattype'] == "certificate") {
$object_type = "certificate";
}
if ($data['cattype'] == "player") {
$object_type = "player";
}
$id = $data['id'];
$sport = $data['d']->sport ? $data['d']->sport : null;
@endphp

<div class="mob_academy_box">
    <div class="mob_academy_fee_box">
        <p class="mob_academy_fee_heading">
            {{ $data['cattype'] == "aid" ? "Fee & Batches" :
    ($data['cattype'] == "tid" ? "Competition Details" :
        ($data['cattype'] == "player" ? "Player Details" :
            ($data['cattype'] == "certificate" ? "Certification Details" :
                ($data['cattype'] == "coach" ? "Coach Details" : "Fee & Batches")))) }}
        </p>


    </div>

    <!-- Player Tab -->
    @if($data['cattype'] == "player")
    <div class="mob_academy_fee_list">
        <ul>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/year.svg" loading="lazy" alt="position" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Position: </span> <span class="text_capital">{{ $data['d']->position }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="club" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Current Club: </span><span class="text_capital">{{ $data['d']->current_club }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/year.svg" loading="lazy" alt="dob" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Date of Birth: </span><span class="text_capital">{{ $data['d']->dob }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="birth" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Place of Birth: </span><span class="text_capital">{{ $data['d']->place_of_birth }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="height" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Height: </span><span class="text_capital">{{ $data['d']->height }}</span>
                    </span>
                </div>
            </li>
        </ul>

    </div>


    <!-- Certification Tab -->
    @elseif($data['cattype'] == "certificate")
    <div class="mob_academy_fee_list">
        <ul>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="certification" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Certification: </span><span class="text_capital">{{ $data['d']->name }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="level" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold"> Level: </span><span class="text_capital">{{ $data['d']->level }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="sport" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Sport: </span><span class="text_capital">{{ $data['d']->sport }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="contact" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Contact: </span><span class="text_capital">{{ $data['d']->contact }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="address" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Address: </span><span class="text_capital">{{ $data['d']->address }}</span>
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="location" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Location: </span><span class="text_capital"></span>
                    </span>
                </div>
            </li>
        </ul>

    </div>

    <!-- Other Tab -->
    @else
    <div class="mob_academy_fee_list">
        <div style="margin-left: 1rem;">
            <div class="stars_up">
                <div class="mob_academy_small_star review_top_span">
                    <div class="review_number">
                        <span class="review_text" style="color:#fff">{!! $data['d']->rating ?? '4' !!}</span>
                    </div>
                    <div class="mobile_academy_stars_small" style="--star_rating: {{$data['d']->rating ?? '4'}}" aria-label="Rating of this product is 3 out of 5."></div>
                    <div>
                        <span class="review_text">{!! $data['d']->reviews ?? '23' !!} Reviews</span>
                    </div>
                </div>
            </div>
        </div>
        <ul>
            @if($data['cattype'] == 'aid')
            @if($data['fee'])
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/weekly.svg" alt="Fees" width="20" height="20" />
                    <span style="margin-left: 5px;"><span class="fee_bold">Fees: </span><span class="text_capital">{{ $data['fee'] }}</span></span>
                </div>
            </li>
            @endif
            @endif
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/weekly.svg" alt="Timings" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        {!! $data['cattype'] == "aid" ? '<span class="fee_bold">Timings: </span><span class="text_capital">' . ($data['d']->timing ?: ": 10AM-7PM") . '</span>' :
                        '<span class="fee_bold">Competition:</span><span class="text_capital">' . ($data['d']->name ?: ": -") . '</span>' !!}
                    </span>
                </div>
            </li>
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/gendar.svg" alt="Closed" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        {!! $data['cattype'] == "aid" ? '<span class="fee_bold">Closed On: </span><span class="text_capital">' . ($data['d']->closed_on ?: "Tuesday") . '</span>' :
                        '<span class="fee_bold">Level:</span><span class="text_capital">' . ($data['d']->level ?: ": -") . '</span>' !!}
                    </span>
                </div>
            </li>

            @if($data['cattype'] == "aid")
            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/batch.svg" alt="Categories" width="20" height="20" />
                    <span style="margin-left: 5px;">
                        <span class="fee_bold">Category:</span> <span class="text_capital">{{ $data['d']->categories ? $data['d']->categories : "Sport" }}</span>
                    </span>
                </div>
            </li>

            @endif
            <li>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/year.svg" loading="lazy" alt="Sport" width="20" height="20" />
                <span class="fee_bold">Sports:</span> <span class="text_capital"><span class="text_capital">{{ $data['d']->sport ? $data['d']->sport : "Sport" }}</span></span>
            </li>

            <li>
                <div style="display: flex; align-items: start;">
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Address" width="20" height="20" />
                    <span style="margin-left: 5px;"><span class="fee_bold">Address:</span> <span class="text_capital">{{ $data['address'] ? $data['address'] : "No Address" }}</span>
                    </span>
                </div>
            </li>
            <li>
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Location" width="20" height="20" />
                <span class="fee_bold">Location:</span> <a target="_blank" href="{{ $data['cattype'] == "aid" ? $data['d']->map : "-" }}">Google
                    Map</a>
            </li>

            <li>
                <!-- <span class="text_capital"><button class="mob_call_btn fb_call whatsapp_contact"> <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mwhtaps.svg" loading="lazy" alt="chat"><a href="https://api.whatsapp.com/send/?phone=%2B91{{env('WHATSAPP_LEAD_MOBILE')}}&text=Please+share+more+details+for+{{ $object_type }}+{{ $data['listingTitle'] }}+({{ $data['d']->id }})" target="_blank">Contact {{ ucwords($object_type) }}</a></button></span> -->
                <span class="text_capital"><button class="mob_call_btn fb_call whatsapp_contact" id="openWhatsappModal">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mwhtaps.svg" loading="lazy" alt="chat">Send WhatsApp Message</button></span>
            </li>

        </ul>
    </div>
    @endif

</div>
<!-- Fee Batch Tab End -->

<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">Contact Us on WhatsApp</h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details" value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details" value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details" value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details" value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}">
                    <input type="hidden" name="loc_id" id="loc_id_details" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details" value="message" required>
                    <input type="hidden" name="latitude" id="latitude2">
                    <input type="hidden" name="longitude" id="longitude2">
                    <span class="error" id="formError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc" placeholder="Enter your description" autocomplete="off">Please share more details for {{ $object_type }} {{ $data['listingTitle'] }} ({{ $data['d']->id }})
                        </textarea>

                    </div>
                    <button type="submit" id="formSubmitButton" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>