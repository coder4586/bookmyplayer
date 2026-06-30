@php
session()->put([
'business_verification_mobile' => $data["d"]->phone,
'business_verification_aid' => $data["d"]->id,
]);
session()->save();
@endphp

@push('scripts')
<link rel="stylesheet" href="{{ asset('asset/css/menu_v3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/common_v2.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/own_buiseness.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
@endpush
@push('scripts')
<script src="{{ asset('asset/js/admin/buiseness.min.js') }}" defer></script>
@endpush
@extends('layouts.own_business_app')
@section('content')

<!-- main section  -->
<section class="own_buiseness_2">
   <div class="buiseness_left">
      <div class="academy_pic">
         <img src="{{$data["banner"]}}" alt="" class="academy_banner">
         <div class="club_logo">
            <img src="{{$data["logo"]}}" alt="logo">
         </div>
      </div>
      <div class="buiseness_heading">
         <p class="fb_font">{{$data["d"]->name}}</p>
      </div>
      <div class="star_academy">
         <span class="total_star">{{$data["d"]->rating ? $data["d"]->rating : "0"}}</span>
         <div class="owner_stars" style="--star_rating: {{ $data["d"]->reviews ? $data["d"]->reviews : "0" }}"></div>
         <span class="total_review">({{$data["d"]->reviews ? $data["d"]->reviews : "0"}} Reviews {{session("business_verification_otp")}})</span>
      </div>
      <div class="buiseness_address">
         <p class="fb_font">{{$data['address']}}</p>
      </div>
   </div>
   <div class="buiseness_right">
      <div class="buiseness_top">
         <p class="fb_font verify_buisenss">Manage this business to reply to reviews, update info and more</p>
      </div>
      <div>
         <p class="fb_font" style="font-size: 1.2rem; "> <span style="font-weight: 600;text-transform:capitalize">{{$data["d"]->name}}</span> Is Currently Owned By</p>
      </div>
      <div class="email_box">
         <div class="email_img">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/phone_coach.svg" alt="phone" width="28" height="28">
         </div>
         <div class="email_text">
            <p class="fb_font">{{ $data["d"]->phone ? "******" . substr($data["d"]->phone, -4) : "no mobile"}}</p>
         </div>
      </div>
      <div class="email_box">
         <div class="email_img">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/email_coach.svg" alt="email" width="28" height="28">
         </div>
         <div class="email_text">
            <p class="fb_font">
               {{ $data["d"]->email ? substr($data["d"]->email, 0, 2) . '******' . substr($data["d"]->email, strpos($data["d"]->email, '@') - 2) : "no email" }}
            </p>
         </div>
      </div>
      <div class="buiseness_top">
         <p class="fb_font verify_otp">By continuing, you’re agreeing to the <span><a href="/terms" target="_blank">Terms of Service</a></span> and
            <span><a href="/privacy" target="_blank">Privacy Policy</a></span>
         </p>
      </div>
      <div class="btn_verify">
         @if($data["d"]->phone)
         <a href="/register-your-academy"><button class="fb_font verify_btn al_manage">Manage Now</button></a>
         @endif
      </div>
      <div class="buiseness_top">
         <span style="color:#fe5c4d; cursor:pointer" id="hp_contact"> <a href="/contact" target="_blank"> Contact Support </a></span> <span class="fb_font verify_otp">To Update Your Register Details.
         </span>
      </div>
   </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- main section ends -->
@endsection
