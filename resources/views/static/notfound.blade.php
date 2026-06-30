@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/404.min.css') }}" type="text/css">
@endpush
@extends('layouts.app')
@section('content')
<section class="error_section">
    <div class="error_img">
        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/404_new.webp" alt="error">

        <div class="error_text">
            <p class="fb_font sorry_page">We are sorry the page you requested could not be found Please go back to
                homepage</p>
            <p class="fb_font no_page">No page found</p>
        </div>
    </div>
</section>
@endsection

