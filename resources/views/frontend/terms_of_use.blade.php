@extends('frontend.layouts.master')

@section('title')
Terms of Use || 
@endsection

@if(!empty($terms))

@section('meta')

@include('frontend.layouts.partials.meta', ['keywords' => $terms->keywords, 'description' => strip_tags($terms->details), 'author' => config('app.name'), 'title' => 'Terms of Use', 'type' => 'Site Info', 'image' => asset('favicon.png')])

@endsection

@section('content')

<div class="container my-5">

  <h2><i class="fas fa-file-contract mr-3"></i>Terms of Use</h2><hr>

  {!! $terms->details !!}
 
</div>
@endsection

@endif