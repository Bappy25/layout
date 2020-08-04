@extends('frontend.layouts.master')

@section('title')
{{ Auth::user()->name }} || Messaging || {{ $subject->subject }} || 
@endsection

@section('custom-css')

<style type="text/css">
	.user_search_result {
		position: relative;
		width: 100%;
		visibility: hidden;
	}
	.user-image {
		max-width: 30px;
	}
	.user-image-show {
		max-height: 300px;
	}
</style>

@endsection

@section('content')

<div class="container my-5">

	<h2 class="font-weight-bold">{{ Auth::user()->name }}</h2>
	<h5><i class="fas fa-envelope mr-2"></i>Messaging</h5>
	<h4 class="mt-5">
		{!! Form::open(['method' => 'delete', 'route' => ['messages.users.remove', $subject->id]]) !!}
		<span id="message_subject">{{ $subject->subject }}</span>
		<span id="message_info" data-subject_id="{{ $subject->id }}" data-total="{{ $subject->messages->count() }}" style="display:none"></span>
		<button type="button" class="btn btn-secondary btn-sm btn-rounded ml-5" id="edit_subject_button" data-id="{{ $subject->id }}" data-edit="{{ route('messages.subject.edit', $subject->id) }}" data-update="{{ route('messages.subject.update', $subject->id) }}"><i class="fas fa-edit" aria-hidden="true"></i></button>
		<a href="{{ route('messages.show', $subject->id) }}" class="btn btn-warning btn-sm btn-rounded" data-toggle="tooltip" data-placement="top" title="Refresh Messages."><i class="fas fa-sync"></i></a>
		{!! Form::button('<i class="fas fa-ban"></i>', array('class' => 'btn btn-danger btn-sm btn-rounded form_warning_sweet_alert message_options', 'title'=>'Are you sure', 'text'=>'Your are going to unfollow this conversation!', 'confirmButtonText'=>'Yes, unfollow!', 'type'=>'submit')) !!}
		{!! Form::close() !!} 
	</h4>


	{{ $messages->links() }}

	<div class="row my-3">
		
		<div class="col-sm-9">
			@foreach($messages->reverse() as $message)
			<div class="col-sm-11 rounded shadow-sm py-3 mb-5 message-div {{ $message->user->id == Auth::user()->id ? 'bg-info text-white ml-5'  : 'mr-5' }}" data-message-id="{{ $message->id }}" data-url-edit="{{ route('messages.edit', $message->id) }}" data-url-update="{{ route('messages.update', $message->id) }}">
				<div class="row">
					<div class="col-sm-1">
						<img src="{{ file_exists($message->user->user_detail->avatar) ? asset($message->user->user_detail->avatar) : 'http://via.placeholder.com/50' }}" class="rounded-circle message-user-avatar" width="50px" height="50px">
					</div>
					<div class="col-sm-11">
						<h5 class="{{ $message->user->id == Auth::user()->id ? 'text-light'  : '' }}">
							{{ $message->user->name }}
							@if($message->user->id != Auth::user()->id)
							<span class="get_online_status badge badge-success" data-username="{{ $message->user->username }}"></span>
							@endif
						</h5>
						<h6 class="{{ $message->user->id == Auth::user()->id ? 'text-white-50'  : 'text-muted' }}">{{ $message->created_at->format('l d F Y, h:i A') }}</h6>
					</div>
				</div>

				{!! $message->message_text !!}

				@if($message->user->id == Auth::user()->id && (strtotime($message->created_at) + 3600) > time())
				{!! Form::open(['method' => 'delete', 'route' => ['messages.destroy', $message->id]]) !!}
				<button type="button" class="btn btn-outline-light btn-squared edit_message_button message_options"><i class="fas fa-edit" aria-hidden="true"></i></button>
				{!! Form::button('<i class="fas fa-trash" aria-hidden="true"></i>', array('class' => 'btn btn-outline-light btn-squared form_warning_sweet_alert message_options', 'title'=>'Are you sure', 'text'=>'Your message will be lost!', 'confirmButtonText'=>'Yes, delete the message!', 'type'=>'submit')) !!}
				{!! Form::close() !!} 
				@endIf
			</div>
			@endforeach
			@if($messages->onFirstPage() && $messages->isNotEmpty() && $messages->first()->viewers->isNotEmpty())
			<a href="javascript:void(0);" class="float-right link-unstyled" data-toggle="modal" data-target="#viewers_modal">
				<i class="fas fa-check pr-2"></i>Viewed by
				@foreach($messages->first()->viewers as $viewer)
				{{ $loop->iteration == 1 ? $viewer->user->name : $viewer->user->name.',' }}
				@if($loop->iteration == 2) @php break; @endphp @endif
				@endforeach 
				{{ count($messages->first()->viewers) > 2 ? 'and '.(count($messages->first()->viewers) - 2).' others' : '' }}
			</a>
			<div class="row"></div>
			@endif
			<h5 class="mt-5">Add Message</h5>
			<small class="form-text text-muted mb-3">Click on the image icon to include images in your message.</small>
			{!! Form::open(['method' => 'post', 'route' => ['messages.store'], 'name' => 'check_edit', 'class' => "add_message"]) !!}
			{!! Form::hidden('message_subject_id', $subject->id) !!}
			{!! Form::hidden('user_id', Auth::user()->id) !!}
			{!! Form::textarea('message_text', null, array('class' => 'tinymce')) !!}
			@if ($errors->has('message_text'))
			<p class="text-danger small">
				<strong>{{ $errors->first('message_text') }}</strong>
			</p>
			@endif
			{!! Form::button('Add', ['type' => 'submit', 'class' => 'btn btn-primary my-3'] ) !!}
			{!! Form::close() !!}
		</div>
		<div class="col-sm-3">
			<h5>Add Participant</h5>
			<div class="input-group mb-3">
				<input type="text" id="search_keyword" class="form-control" placeholder="Search Here...">
				<div class="input-group-append">
					<button type="button" class="btn btn-primary" id="search_user" data-id="{{ $subject->id }}"><i class="fas fa-search"></i></button>
				</div>
			</div>
			<small for="search_keyword" class="form-text text-muted">Type name, email etc. and press the search button.</small>
			<div id="user_search_result" class="list-group shadow rounded user_search_result my-3"></div>
			{!! Form::close() !!}
			<h5>Participants</h5>
			<ul class="list-group">
				<ul class="list-inline list-group-flush">
					@foreach($subject->participants as $user)
					<li class="list-group-item">
						<a href="{{-- route('front.user.profile', $user->username) --}}" class="nounderline text-warning font-weight-bold">
							<img src="{{ file_exists($user->user_detail->avatar) ? asset($user->user_detail->avatar) : 'http://via.placeholder.com/20' }}" class="img-fluid rounded-circle mr-2" alt="{{ $user->name }}" width="30px" height="30px"> 
							{{ $user->name }}
							<span class="get_online_status badge badge-success" data-username="{{ $user->username }}"></span>
						</a>
					</li>
					@endforeach
				</ul>
			</ul>
		</div>
	</div>

</div>

@if($messages->isNotEmpty())
<!-- Viewers Modal -->
<div class="modal fade" id="viewers_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title w-100" id="viewDetailsTitle">List of Viewers</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="list-group">
					<ul class="list-inline list-group-flush">
						@foreach($messages->first()->viewers as $viewer)
						<li class="list-group-item">
							<small class="grey-text float-right">{{ $viewer->created_at->format('l d F Y, h:i A') }}</small>
							<img src="{{ file_exists($viewer->user->user_detail->avatar) ? asset($viewer->user->user_detail->avatar) : 'http://via.placeholder.com/50' }}" class="img-fluid rounded-circle mr-2" alt="{{ $viewer->user->name }}" width="30px" height="30px"> 
							{{ $viewer->user->name }}
							<span class="get_online_status badge badge-success" data-username="{{ $viewer->user->username }}"></span>
						</li>
						@endforeach
					</ul>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Viewers Modal -->
@endif 

@endsection

@section('extra-script')

<!-- Autosize Plugin Js -->
{{Html::script('plugins/autosize/autosize.js')}}

<!-- TinyMCE -->
{{Html::script('plugins/tinymce/tinymce.min.js')}}

@endsection

@section('custom-script')
<script>

	$(document).ready(function() {

    // Initialize autosize
    autosize($('textarea.auto-growth'));

	// Initialize tinymce
	setTinyMce();

	// Show User Status
	getUserStatus();
	setInterval(getUserStatus, 60000);

	// Show Message Status
	setInterval(getMessageStatus, 10000);

	// Scroll to new message
	$('html, body').animate({
        scrollTop: $(".add_message").offset().top
    }, 2000);

	// Show Users
	$('#search_user').unbind().click(function(){
		id = $(this).data('id');
		keyword = $('#search_keyword').val();
		if(keyword.length > 2){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
				}
			});
			$.ajax({
				url: '/account/messages/users/search',
				type: 'POST',
				data: {id: id, keyword: keyword},
				dataType: 'JSON',
				context: this,
				beforeSend: function() {
					$("#user_search_result").css('visibility','visible').append('<div class="list-group-item text-center"><i class="fas fa-spinner fa-spin my-3"></i></div>');
				},
				success:function(response){
					if(response.result == true){
						$("#user_search_result").empty();
						$.each(response.data, function( index, value ) {
							html = '<div class="list-group-item list-group-item-action flex-column align-items-start">';
							html += '<form method="post" action="/account/messages/users/add">';
							html += '<input type="hidden" name="_token" value="'+$('meta[name=csrf-token]').attr('content')+'">';
							html += '<input type="hidden" name="id" value="'+value.subject_id+'">';
							html += '<input type="hidden" name="user" value="'+value.user_id+'">';
							html += '<h6 class="mb-1"><img src="'+checkImage(value.avatar)+'" class="img-fluid user-image img-thumbnail mr-2" alt="'+value.name+'">'+value.name;
							html += '<button type="submit" class="btn btn-primary btn-sm btn-rounded mx-1 my-2 form_warning_sweet_alert" title="Are you sure?" text="You are going to add '+value.name+' this user to this conversation!" confirmButtonText="Yes, add this user!" type="submit"><i class="fas fa-check"></i></button></h6></form></div>';
							$("#user_search_result").append(html).hide().fadeIn(200+(index*10)); 
						}); 
					}
					else{
						$('#user_search_result').css('visibility','hidden').empty();
						console.log(response);
					}
				}
			});
		}
		else{
			$("#search_keyword").closest('div').after('<p class="small font-weight-bold text-danger">Input must be greater than 2 characters!</p>');
			$('#user_search_result').empty();
		}
	});

	$('#edit_subject_button').unbind().click(function(){
		if($(this).parent().find('.btn-secondary').length == 1){
			$(this).removeClass("btn-secondary ml-5").addClass("btn-primary").html('<i class="fas fa-check"></i>');
			var url = $(this).data("edit");
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
				}
			});
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'JSON',
				success:function(response){
					if(response.result == true){
						$('#message_subject').html('<div class="form-group"><textarea class="auto-growth form-control" name="subject">'+response.message+'</textarea></div>').fadeIn('slow');
						setAutoSize();
					}
					else{
						console.log(response);
					}
				}
			});	
		}
		else{
			var url = $(this).data("update");
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
				}
			});
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					'subject': $("#message_subject :input").val()
				},
				dataType: 'JSON',
				success:function(response){
					if(response.result == true){
						$('#message_subject').html(response.message).fadeIn('slow');
						$('#edit_subject_button').removeClass("btn-primary").addClass("btn-secondary ml-5").html('<i class="fas fa-edit"></i>');
					}
					else{
						console.log(response);
						if(!jQuery.isEmptyObject(response.details)){
							$.each(response.details, function( index, value ){
								$("#message_subject :input").addClass('is-invalid');
								$("#message_subject :input").after('<span class="invalid-feedback" role="alert"><strong>'+value+'</strong></span>');
							});
						}
					}
				}
			});
		}	
	});

	$(document).on('click', '.edit_message_button', function(){
		var url = $(this).closest('div.message-div').data("url-edit");
		var div = $(this).closest('div.message-div');
		var html = '';
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			}
		});
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'JSON',
			beforeSend: function(){
				div.removeClass( "bg-info text-white" ).html("<center><h1><i class='fas fa-spinner fa-spin'></i></h1></center>");
			},
			success:function(response){
				if(response.result == true){
					div.hide().html('<textarea class="tinymce" name="message_text">'+response.message+'</textarea><button class="btn btn-primary my-3 save_message"><i class="fas fa-check pr-2"></i>Update</button>').fadeIn('slow');
					setTinyMce();
					$(".message_options").hide();
					$(".add_message").hide();
				}
				else{
					console.log(response);
				}
			}
		});
	});

	$(document).on('click', '.save_message', function(){
		var url = $(this).closest('div.message-div').data("url-update");
		var div = $(this).closest('div.message-div');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			}
		});
		$.ajax({
			url: url,
			type: 'PUT',
			data: {
				'message_text': tinyMCE.activeEditor.getContent()
			},
			dataType: 'JSON',
			success:function(response){
				if(response.result == true){
					html = '<div class="row"><div class="col-sm-1">';
					html += '<img src="'+checkImage(response.data.avatar)+'" class="rounded-circle message-user-avatar" width="50px" height="50px"></div>';
					html += '<div class="col-sm-11"><h5 class="text-light">'+response.data.user+'</h5>';
					html += '<h6 class="text-white-50">'+response.data.created_at+'</h6></div></div>'+response.message;
					html += '<form method="POST" action="/account/messages/'+response.data.id+'" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="'+$('meta[name=csrf-token]').attr('content')+'">';
					html += '<button type="button" class="btn btn-outline-light btn-squared edit_message_button message_options mr-1"><i class="fas fa-edit" aria-hidden="true"></i></button>';
					html += '<button class="btn btn-outline-light btn-squared form_warning_sweet_alert message_options" title="Are you sure" text="Your message will be lost!" confirmButtonText="Yes, delete the message!" type="submit"><i class="fas fa-trash" aria-hidden="true"></i></button></form>'; 
					div.addClass( "bg-info text-white" ).html(html);
					$(".message_options").show();
					$(".add_message").show();
				}
				else{
					console.log(response);
					if(!jQuery.isEmptyObject(response.details)){
						$.each(response.details, function( index, value ){
							div.find('.tinymce').after('<p class="text-danger small"><strong>'+value+'</strong></p>');  
						}); 
					}
					
				}
			},
			error: function(request, status, error){
				console.log(request.responseText);
			}
		});
	});

});

function getUserStatus(){

	$('.get_online_status').each(function(i, obj) {
		
		var get_status = $(this);
	
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			}
		});
		$.ajax({
			url: '/users/status',
			type: 'post',
			data: {'username': get_status.data('username')},
			dataType: 'JSON',
			success:function(response){
				get_status.empty();
				if(response.message === 1){
					get_status.text('online');
				}
			}
		});

	});

}

function getMessageStatus(){

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		}
	});
	$.ajax({
		url: '/account/messages/status',
		type: 'post',
		data: {
			'total': $('#message_info').data('total'),
			'subject_id': $('#message_info').data('subject_id')
		},
		dataType: 'JSON',
		success:function(response){
			if(response.result === true && response.data.status === 1){
				$('#message_info').data('total', response.data.total);
				alert(response.message);
			}
			else{
				console.log(response);
			}
		}
	});

}

function checkImage(image){
	var product_image = "http://via.placeholder.com/50";
	$.ajax({
		url: "{{ url('/').'/' }}"+image,
		type:'HEAD',
		async: false,
		success:function(){
			product_image = "{{ url('/').'/' }}"+image; 
		}
	});
	return product_image;
}

function setAutoSize(){
	autosize($('textarea.auto-growth'));
}

function setTinyMce(){

	// Initialize TinyMce
	tinymce.init({

		selector: 'textarea.tinymce',
		setup: function (editor) {
			editor.on('change', function () {
				editor.save();
			});
		},
		height: 300,
		menubar: false,
		plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table paste code help wordcount',
		'emoticons template textpattern imagetools',
		],
		toolbar: 'undo redo | image code | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',

		image_advtab: true,

		images_upload_url: '/add_content_image',

		images_upload_handler: function (blobInfo, success, failure) {

			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;

			xhr.open('POST', '/add_content_image');

			xhr.onload = function() {
				var response;

				if (xhr.status != 200) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}

				response = JSON.parse(xhr.responseText);

				if (!response || typeof response.data.path != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(window.location.origin+'/'+response.data.path);
			};

			formData = new FormData();
			formData.append('upload_image', blobInfo.blob(), blobInfo.filename());
			formData.append('folder','editors');
			formData.append('size','500');
			formData.append('_token', $('meta[name=csrf-token]').attr('content'));

			xhr.send(formData);
		},
		content_css: [
		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		'//www.tiny.cloud/css/codepen.min.css'
		]
	}); 
}

</script>

@endsection