@extends('frontend.layouts.master')

@section('title')
Privacy Policy || 
@endsection

@section('meta')

@include('frontend.layouts.partials.meta', ['keywords' => $privacy->keywords, 'description' => strip_tags($privacy->details), 'author' => config('app.name'), 'title' => 'Privacy Policy', 'type' => 'Site Info', 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2><i class="fas fa-user-lock mr-3"></i>Privacy Policy</h2><hr>

  {!! $privacy->details !!}
  
</div>
@endsection