@extends('front.layouts.master')

@section('title')
Terms of Use || 
@endsection

@section('meta')

@include('front.layouts.partials.meta', ['keywords' => $contents->keywords, 'description' => $contents->description, 'author' => $contents->author, 'title' => 'Terms of Use', 'type' => $contents->type, 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2 class="text-info"><i class="fas fa-file-contract mr-3"></i>Terms of Use</h2><hr>

  {!! $contents->description !!}

    
  
</div>
@endsection