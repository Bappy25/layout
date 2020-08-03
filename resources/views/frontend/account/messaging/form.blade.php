@extends('frontend.layouts.master')

@section('title')
{{ Auth::user()->name }} || Messaging || Create Message || 
@endsection

@section('content')

<div class="container my-5">

	<h2 class="font-weight-bold">{{ Auth::user()->name }}</h2>
	<h5><i class="fas fa-envelope mr-2"></i>Messaging</h5>
	<h4 class="mt-5">Create Message</h4>
	<p class="small text-muted font-weight-bold">Complete the below fields to send message to <span class="text-warning">{{ $recipient->name }}</span>.</p>


	{!! Form::open(['method' => 'post', 'route' => ['messages.add.subject'], 'id'=>'add_product_form']) !!}


	{!! Form::hidden('receipent', $recipient->id) !!}

	<div class="form-group row">
		{!! Form::label('subject', 'Message Subject', ['class'=>"col-md-2 col-form-label text-md-right"]) !!}
		<div class="col-md-10">
			{!! Form::textarea('subject', null, array('class' => 'no-resize auto-growth form-control '.($errors->has('subject') ? 'is-invalid' : ''), 'rows' => '1', 'id'=>'subject')) !!}
			@if ($errors->has('subject'))
			<span class="invalid-feedback" role="alert">
				<strong>{{ $errors->first('subject') }}</strong>
			</span>
			@endif
		</div>
	</div>


	<div class="form-group row">
		{!! Form::label('message_text', 'Message', ['class'=>"col-md-2 col-form-label text-md-right"]) !!}
		<div class="col-md-10">
			{!! Form::textarea('message_text', null, array('class' => 'tinymce', 'id'=>'message_text')) !!}
			@if ($errors->has('message_text'))
			<p class="text-danger small">
				<strong>{{ $errors->first('message_text') }}</strong>
			</p>
			@endif
		</div>
	</div>

	<div class="form-group row mb-0">
		<div class="col-md-10 offset-md-2">
			{{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-primary my-3'] ) }}
		</div>
	</div>


	{!! Form::close() !!}

</div>

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

});

</script>

@endsection