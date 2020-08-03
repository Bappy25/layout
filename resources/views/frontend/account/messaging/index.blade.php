@extends('frontend.layouts.master')

@section('title')
{{ Auth::user()->name }} || Messaging ||
@endsection

@section('content')

<div class="container my-5">
	<h2 class="font-weight-bold">{{ Auth::user()->name }}</h2>
	<h5><i class="fas fa-envelope mr-2"></i>Messaging</h5>
	@if(count($_GET))
	<a href="{{ route('messages.index') }}" class="btn btn-primary btn-pill" data-toggle="tooltip" data-placement="right" title="Refresh Messages."><i class="fas fa-redo"></i></a>
	@endif
	{!! Form::open(['route' => ['messages.index'], 'method'=>'get']) !!}
	<div class="input-group my-5">
		{!! Form::text('keyword', $keyword, array('class' => 'form-control', 'placeholder' => 'Type Your Search Criteria...')) !!}
		<div class="input-group-append">
			{!! Form::button('<i class="fas fa-search"></i>', array('class' => 'btn btn-primary', 'type'=>'submit')) !!}
		</div>
	</div>
	{!! Form::close() !!}
	@foreach($messages as $message)
	<a href="{{ route('messages.show', $message->id) }}" class="link-unstyled">
	  <div class="row mb-5">
	    <div class="col-md-1">
	     <img src="{{ file_exists($message->messages->last()->user->user_detail->avatar) ? asset($message->messages->last()->user->user_detail->avatar) : 'http://via.placeholder.com/60' }}" class="img-fluid rounded-circle my-3" width="60px" height="60px">
	    </div>
	    <div class="col-md-11">
	        <div class="rounded shadow-sm py-3 px-3 {{ $message->messages->last()->viewers->contains('user_id', Auth::user()->id) ? ''  : 'bg-info text-white' }}"> 
				<h5 class="{{ $message->messages->last()->viewers->contains('user_id', Auth::user()->id) ? ''  : 'text-light' }}">{{ $message->subject }}</h5>
				<h6 class="{{ $message->messages->last()->viewers->contains('user_id', Auth::user()->id) ? ''  : 'text-white-50' }}">{{ $message->messages->last()->user->name }}<small class="mx-3">{{ $message->created_at->format('l d F Y, h:i A') }}</small></h6>
				{{ substr(strip_tags($message->messages->last()->message_text), 0, 50) }}...
	        </div>
	    </div>
	  </div>
	</a>
	@endforeach
	{{ $messages->appends(request()->input())->links() }}
</div>

@endsection