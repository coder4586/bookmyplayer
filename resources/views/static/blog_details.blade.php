@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/blog.min.css') }}" type="text/css">
@endpush
@extends('layouts.app')
@section('content')
@include('layouts.blog.blogdetails_header')
<section class="main_blogs">
   @include('layouts.blog.blogabout')
   @include('layouts.blog.blogsections')
   @include('layouts.blog.blogtags')
   @include('layouts.blog.leavecomment')
   @include('layouts.blog.comments')
   @include('layouts.blog.nineblogbox')
   @include('layouts.blog.blog_right', ['min' => 1, 'max' => 19])
</section>
@endsection

