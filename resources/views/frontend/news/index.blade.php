@extends('frontend.layouts.master')

@section('title')
News || 
@endsection

@section('meta')
@include('frontend.layouts.partials.meta', ['keywords' => implode($tags, ','), 'description' => strip_tags($all_news->first()->description), 'author' => $all_news->first()->admin->name, 'title' => 'News', 'type' => 'Blog', 'image' => asset($all_news->first()->image_path)])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            @foreach($all_news as $news)
            <a href="{{ route('news.show', $news->id) }}" class="link-unstyled mb-3">
                <h2>{{ $news->title }}</h2>
                <p class="text-secondary">{{ $news->admin->name.', '.$news->created_at->format('d/m/y, h:m a') }}</p>
                <img src="{{ empty($news->image_path) ? 'https://via.placeholder.com/250?text=Image+Missing' : asset($news->image_path) }}" alt="{{ $news->title }}" class="img-fluid mb-3"/>
                <p>{{ substr($news->description, 0, 200).'...' }}</p>
            </a>
            @endforeach
            {{ $all_news->links() }}
        </div>
        <div class="col-sm-4">
            @include('frontend.news.menu', [$archive, $tags])
        </div>
    </div>
</div>
@endsection