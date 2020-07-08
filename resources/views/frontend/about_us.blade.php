@extends('frontend.layouts.master')

@section('title')
About Us || 
@endsection

@section('meta')

@include('frontend.layouts.partials.meta', ['keywords' => '', 'description' => '', 'author' => '', 'title' => 'About Us', 'type' => '', 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2><i class="fas fa-info mr-3"></i>About Us</h2><hr>
  
</div>
@endsection