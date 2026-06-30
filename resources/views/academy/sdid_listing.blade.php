@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/sdid_locality_v4.min.css') }}" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('asset/js/sdid_locality.min.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<section class="listing_page">
    @include('layouts.sdid.left')
    <div class="row right_main">
        @include('layouts.sdid.top')
        <div class="new_list">
            @include('layouts.sdid.body.top_list')
        </div>
    </div>
</section>
@endsection