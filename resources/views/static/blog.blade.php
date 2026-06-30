@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/blog.min.css') }}" type="text/css">
@endpush
@extends('layouts.app')
@section('content')
<section class="main_blogs">
   <div class="display_col">
      <div class="left_middle">
         <div class="blog_left">
            @include('layouts.blog.categories')
            @include('layouts.blog.left_blogs')
            @include('layouts.blog.middle_blogs')
            @include('layouts.blog.weekend_reads')
         </div>
         @include('layouts.blog.blog_right', ['min' => 7, 'max' => 19] )
      </div>
   </div>
</section>
@endsection

