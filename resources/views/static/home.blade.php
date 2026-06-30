@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/new_home_v2.css') }}" type="text/css"> 
@endpush
@push('scripts')
<script src="{{ asset('asset/js/new_home_v2.js') }}"></script>
@endpush
@extends('layouts.app')
@section('content')
@include('layouts.home.banner')
@include('layouts.home.popular_coach')
@include('layouts.home.body')
@include('layouts.home.play')
@include('layouts.home.popular_cities')
@include('layouts.home.popular_academy')
@include('layouts.home.whatIsBmp')
@include('layouts.home.user')
@endsection