@include('layouts.details.modal')
@php
$object_type = $data['cattype'] == "aid" ? "academy" : "tournament";
if($data['cattype'] == "certificate"){ $object_type = "certificate";}
if($data['cattype'] == "player"){ $object_type = "player";}
$id = $data['id'];
$sport = $data['d']->sport ? $data['d']->sport : null;
@endphp

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mob_academy_training">
                    <p class="fb_font message_head">Message to {{ $data['title'] }}</p>
                    <div class="error_msg_new">
                        <div id="msg_error" style="display: none; color:red;"></div>
                    </div>
                    <div id="msg_form">
                        <form id="message_form" action="{{ route('submit.contact') }}" method="post">
                            @csrf
                            <input type="hidden" name="source" value="academy details">
                            <input type="hidden" name="sport" value="{{ $data['d']->sport }}">
                            <input type="hidden" name="sport_id" value="{{ $data['d']->sport_id }}">
                            <input type="hidden" name="object_id" value="{{ $data['id'] }}">
                            <input type="hidden" name="object_type" value="{{ $data['object_type'] }}">
                            <input type="hidden" name="loc_id" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                            <input type="hidden" name="screen" value="message" required>
                            <input type="hidden" name="latitude" id="latitude4">
                            <input type="hidden" name="longitude" id="longitude4">
                            <input type="text" name="name" class="fb_font message_input" placeholder="Enter Your Name" id="contact_name2">
                            <input type="number" name="phone" class="fb_font message_input" placeholder="Enter Your Phone Number" id="phone2">
                            <input type="email" name="email" class="fb_font message_input" placeholder="Enter Your Email" id="email2">
                            <textarea name="description" class="fb_font message_input" cols="15" rows="5" placeholder="Type Your Message" id="message2"></textarea>
                            <div class="send_btn">
                                <button type="submit" id="msg_send_btn">Send <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/send.svg" alt="send"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="mob_academy_box">

    <div class="mob_academy_fee_box mob_academy_fee_status">
        <p class="mob_academy_fee_heading">Fee & Batches</p>
    </div>
    <div class="">
        <div>
            <p class="mob_academy_class">Contact to book a free class {{$sport}}</p>
        </div>
        <div class="mob_call_msg">
            <button type="button" class="btn btn-primary mob_message_btn trigger-msg" data-toggle="modal" data-target="#exampleModalCenter">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/message.svg" loading="lazy" alt="message" width="14" height="14">Message
            </button>
           <span class="text_capital"><button class="mob_call_btn fb_call whatsapp_contact" id="openWhatsappModal2"> <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mwhtaps.svg" loading="lazy" alt="chat">Chat</button></span>
        </div>
    </div>
</div>
<!-- fee status tab ends -->


<div class="modal fade" id="whatsappModal2" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">Contact Us on WhatsApp</h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm2" action="{{ route('submit.contact') }}" method="POST">
                    @csrf
                    <input type="hidden" name="source" id="source_details2" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details2" value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details2" value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details2" value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details2" value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}">
                    <input type="hidden" name="loc_id" id="loc_id_details2" value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details2" value="message" required>
                    <input type="hidden" name="latitude" id="latitude3">
                    <input type="hidden" name="longitude" id="longitude3">
                    <span class="error" id="formError2" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name2" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email2" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone2" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc2" placeholder="Enter your description" autocomplete="off">Please share more details for {{ $object_type }} {{ $data['listingTitle'] }} ({{ $data['d']->id }})
                        </textarea>

                    </div>
                    <button type="submit" id="formSubmitButton2" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>