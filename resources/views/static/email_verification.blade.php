@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/academy_details.css') }}" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('asset/js/academy_details.min.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')

@if($data['status'] == 1)
<div class="card m-4">
    <div class="card-header text-success">
        <span id="head">Email verified successfully.</span>
    </div>
    <div class="card-body">
        <p class="card-text"> {{$data['message']}}</p>
    </div>
</div>
@else
<div class="card m-4">
    <div class="card-header text-danger" id="head">
        <span id="head">Email verification Failed. </span>
    </div>
    <div class="card-body">
        <p class="card-text"> {{$data['message']}}</p>
    </div>
</div>
@endif


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var countdown = 10;
        var timerElement = document.getElementById('head');

        var timer = setInterval(function () {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = "{{ url('/') }}";
            } else {
                @if ($data['status'] == 1)
                    timerElement.textContent = "Email verified successfully(" + countdown + " s.)";
                @endif
                @if ($data['status'] == 0)
                    timerElement.textContent = "Email verified Failed.(" + countdown + " s.)";
                @endif
            }
        }, 1100);
    });
</script>
@endsection
