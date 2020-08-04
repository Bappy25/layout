@extends('frontend.layouts.master')

@section('title')
News || {{ $news->title }}
@endsection

@section('meta')
@include('frontend.layouts.partials.meta', ['keywords' => $news->tags, 'description' => strip_tags($news->description), 'author' => $news->admin->name, 'title' => 'News', 'type' => 'Blog', 'image' => asset($news->image_path)])
@endsection

@section('extra-css')

<!-- Social Sharing -->
{{ Html::style('plugins/jssocials/jssocials.css') }}
{{ Html::style('plugins/jssocials/jssocials-theme-classic.css') }}

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h2>{{ $news->title }}</h2>
            <p class="text-secondary">{{ $news->admin->name.', '.$news->created_at->format('d/m/y, h:m a') }}</p>
            <img src="{{ empty($news->image_path) ? 'https://via.placeholder.com/250?text=Image+Missing' : asset($news->image_path) }}" alt="{{ $news->title }}" class="img-fluid mb-3"/>
            <p>{!! $news->description !!}</p>
            <div id="social_share" class="my-3"></div>
        </div>
        <div class="col-sm-4">
            @include('frontend.news.menu')
        </div>
    </div>
</div>
@endsection

@section('extra-script')

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/jssocials/jssocials.min.js')}}

@endsection

@section('custom-script')

<script>

    $(document).ready(function() {

        // Initialize Social Share
        $("#social_share").jsSocials({
            shares: [
            {
                share: "facebook",
                logo: "fab fa-facebook-f",
                label: "Share",
            },
            ],
        }); 
        
    });

</script>

@endsection