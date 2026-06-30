@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/sdid_locality_v4.min.css') }}" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('asset/js/sdid_locality.min.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<section class="listing_page">
    @include('layouts.locality.left')
    <div class="row right_main">
        @include('layouts.locality.top')
        <div class="new_list">
            @include('layouts.locality.body.top_list')
        </div>
    </div>
</section>
@endsection