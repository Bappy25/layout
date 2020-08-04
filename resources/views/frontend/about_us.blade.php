@extends('frontend.layouts.master')

@section('title')
About Us || 
@endsection

@if(!empty($about))

@section('meta')

@include('frontend.layouts.partials.meta', ['keywords' => $about->keywords, 'description' => strip_tags($about->details), 'author' => config('app.name'), 'title' => 'About Us', 'type' => 'Site Info', 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2><i class="fas fa-info mr-3"></i>About Us</h2><hr>

  {!! $about->details !!}
  
</div>
@endsection

@endif