<h3>Search</h3>
{!! Form::open(['url' => route('news.index'), 'method'=>'get']) !!}
<div class="form-group">
    <div class="form-line">
        {!! Form::text("search", request()->search, ['class'=>'form-control', 'placeholder'=>'Enter Keyword']) !!}
    </div>
</div>
{!! Form::close() !!}
<h3>Tags</h3>
@php $parameters = request()->input(); @endphp
@foreach($tags as $tag)
@php $parameters['search'] = $tag;  @endphp
<a href="{{ route('news.index', $parameters) }}">{{ $tag }}</a>
@endforeach
<h3>Archive</h3>
@php $parameters = request()->input(); @endphp
@foreach($archive as $state)
@php $parameters['month'] = $state->month; $parameters['year'] = $state->year;  @endphp
<a href="{{ route('news.index', $parameters) }}">{{ $state->month.' '.$state->year }}</a>
@endforeach