@extends('front.layouts.master')

@section('title')
Privacy Policy || 
@endsection

@section('meta')

@include('front.layouts.partials.meta', ['keywords' => $contents->keywords, 'description' => $contents->description, 'author' => $contents->author, 'title' => 'Privacy Policy', 'type' => $contents->type, 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2 class="text-info"><i class="fas fa-user-lock mr-3"></i>Privacy Policy</h2><hr>

  {!! $contents->description !!}    
  
</div>
@endsection