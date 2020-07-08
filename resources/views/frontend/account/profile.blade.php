@extends('frontend.layouts.master')

@section('title')
{{ $user->name }}
@endsection


@section('extra-css')

<!-- Light Gallery Plugin Js -->
{{ Html::style('plugins/light-gallery/css/lightgallery.css') }}

<!-- Dropify Css -->
{{ Html::style('plugins/dropify/css/dropify.min.css') }}

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h4>Welcome {{ $user->name }}!</h4><hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div id="aniimated-thumbnials">
                                <a href="{{ file_exists($user->user_detail->avatar) ? asset($user->user_detail->avatar) : 'http://via.placeholder.com/200x200' }}" data-sub-html="{{ $user->name }}">
                                    <img src="{{ file_exists($user->user_detail->avatar) ? asset($user->user_detail->avatar) : 'http://via.placeholder.com/200x200' }}" class="img-fluid rounded-circle mr-2" alt="Responsive image" width="200" height="200">
                                </a>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm my-3" data-toggle="modal" data-target="#updateimage">Update Profile Picture</button>
                        </div>
                        <div class="col-sm-8">
                            <p><strong>Username:</strong> {{ $user->username }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Date of Birth:</strong> {{ empty($user->user_detail->dob) ? '' : $user->user_detail->dob->format('d/m/y') }}</p>
                            <p><strong>Contact:</strong> {{ empty($user->user_detail->contact) ? '' : $user->user_detail->contact }}</p>
                            <p><strong>Gender:</strong> {{ config('genders.'.$user->user_detail->gender) }}</p>
                            <p><strong>Address:</strong> {{ empty($user->user_detail->address) ? '' : $user->user_detail->address }}</p>
                            <a href="{{ route('account.edit') }}" class="btn btn-warning btn-sm mb-3">Update Information</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="updateimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body image_modal">
                {!! Form::open(['class'=>'upload_image', 'method' => 'put', 'route' => ['account.update.image'], 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('user_id', $user->user_detail->id) !!}
                {!! Form::file("image", ['class'=>'input_image']) !!}
                {{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary my-3'] ) }}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Image Modal -->

@endsection

@section('extra-script')

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/light-gallery/js/lightgallery-all.js')}}

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/dropify/js/dropify.min.js')}}

<!-- Jquery Form Plugin Js -->
{{Html::script('plugins/jquery-form/jquery.form.js')}}

@endsection

@section('custom-script')

<script>

    $(document).ready(function() {

        $('.input_image').dropify();

        $('#updateimage').on('hidden.bs.modal', function () {
            $(".dropify-clear").click(); 
        });

        $('#aniimated-thumbnials').lightGallery({
            thumbnail: true,
            selector: 'a'
        });

        // Update Profile Image
        $('.upload_image').ajaxForm({
            beforeSend: function() {
                $(".image_modal").empty().append("<div class='modal-body text-center mb-1'><p class='mt-1 mb-2 text-info'>Please Wait..</p><div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div></div></div>");  
            },
            uploadProgress: function() {
                $(".image_modal").empty().append("<div class='modal-body text-center mb-1'><h5 class='mt-1 mb-2'>Uploading Image</h5><div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div></div></div>");
            },
            success: function() {
                $(".image_modal").empty().append("<div class='modal-body text-center mb-1'><h5 class='mt-1 mb-2 text-success'><i class='fas fa-check-circle mr-2'></i>Image Upload Complete!</h5><p class='mt-1 mb-2 text-warning'>Please refresh the page to view image!</p>").fadeIn("slow");        
            },
            error: function(xhr, status, error) {
                $(".image_modal").empty().append("<div class='modal-body text-center mb-1'><h5 class='mt-1 mb-2 text-danger'><i class='fas fa-exclamation-triangle mr-2'></i>"+status+": Image can't be Uploaded!</h5><p class='mt-1 mb-2 text-warning'>"+error+"</p>").fadeIn("slow");        
            },
            complete: function(xhr) {
                $(".image_modal").append('<a href="'+window.location.href+'" class="btn btn-info mx-auto d-block"><i class="fas fa-sync-alt mr-2"></i>Refresh Page</a>').fadeIn("slow"); 
            }
        }); 

    });

</script>

@endsection