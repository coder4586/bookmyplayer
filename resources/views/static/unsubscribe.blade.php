@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/unsubscribe.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/unsubscribe.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')

<div class="unsubscribe_section">
    <div class="unsubscribe_wrapper">
        <div class="unsubscribe_header">
            {!! $data['message'] !!}
        </div>
        <div class="unsubscribe_body">
            @if($data['status'] == 1)
            <p>Thank you for being a part of our journey, and we hope to see you again in the future!</p>
            @endif
            <p id="redirectMessage">
                Redirecting to home page in <span id="countdown">5</span> seconds.
            </p>
        </div>
        <div class="unsubscribe_footer">
            &copy; 2025 BookMyPlayer. All rights reserved.
        </div>
    </div>
</div>

@endsection