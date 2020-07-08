@extends('front.layouts.master')

@section('title')
About Us || 
@endsection

@section('meta')

@include('front.layouts.partials.meta', ['keywords' => $contents->keywords, 'description' => $contents->description, 'author' => $contents->author, 'title' => 'About Us', 'type' => $contents->type, 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2 class="text-info"><i class="fas fa-info mr-3"></i>About Us</h2><hr>

  {!! $contents->description !!}
  
</div>
@endsection