@extends('backend.layouts.master')

@section('title')
All Users || {{ $user->name }}
@endsection

@section('extra-css')

<!-- Light Gallery Plugin Js -->
{{ Html::style('plugins/light-gallery/css/lightgallery.css') }}

@endsection

@section('content')

<div class="block-header">
    <div class="block-header">
        <ol class="breadcrumb breadcrumb-col-teal">
            <li><i class="material-icons">people</i> Users</li>
            <li><a href="{{ route('back.users.index') }}"><i class="material-icons">list</i> All Users</a></li>
            <li class="active"><i class="material-icons">open_in_browser</i> Show User</li>
        </ol>
    </div>
</div>

<!-- Show User -->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-3">
        <div class="card profile-card">
            <div class="profile-header">&nbsp;</div>
            <div class="profile-body">
                <div class="image-area" id="aniimated-thumbnials">
                    <a href="{{ empty($user->user_detail->avatar) ? 'https://via.placeholder.com/150?text=Image+Missing' : asset($user->user_detail->avatar) }}" data-sub-html="{{ $user->name }}">
                        <img src="{{ empty($user->user_detail->avatar) ? 'https://via.placeholder.com/150?text=Image+Missing' : asset($user->user_detail->avatar) }}" alt="{{ $user->name }}" />
                    </a>
                </div>
                <div class="content-area">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->username }}</p>
                </div>
            </div>
            <div class="profile-footer">
                <ul>
                    <li>
                        <span>Created At</span>
                        <span>{{ $user->created_at->format('d/m/y, h:m a') }}</span>
                    </li>
                    <li>
                        <span>Verified at</span>
                        <span>{{ empty($user->email_verified_at) ? 'Not yet verified!' : $user->email_verified_at->format('d/m/y, h:m a') }}</span>
                    </li>
                </ul>
                <button class="btn btn-primary btn-lg waves-effect btn-block" data-toggle="modal" data-target="#avatar_update_modal">UPDATE PROFILE PICTURE</button>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-9">
        <div class="card card-about-me">
            <div class="header">
                <h2>User Details</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('back.users.edit', $user->id) }}">Edit User</a></li>
                            <li><a href="javascript:void(0);" onclick="deleteUser()">Delete User</a></li>
                            {!! Form::open(['route' => ['back.users.destroy', $user->id], 'method'=>'delete', 'id' => 'delete-user-form', 'style'=>'display: none;']) !!}
                            {!! Form::close() !!}
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <ul>
                    <li>
                        <div class="title">
                            <i class="material-icons">event</i>
                            Date of Birth
                        </div>
                        <div class="content">
                            {{ empty($user->user_detail->dob) ? '' : $user->user_detail->dob->format('d/m/y') }}
                        </div>
                    </li>
                    <li>
                        <div class="title">
                            <i class="material-icons">sentiment_satisfied</i>
                            Gender
                        </div>
                        <div class="content">
                            {{ config('genders.'.$user->user_detail->gender) }}
                        </div>
                    </li>
                    <li>
                        <div class="title">
                            <i class="material-icons">email</i>
                            Email
                        </div>
                        <div class="content">
                            {{ $user->email }}
                        </div>
                    </li>
                    <li>
                        <div class="title">
                            <i class="material-icons">call</i>
                            Contact
                        </div>
                        <div class="content">
                            {{ empty($user->user_detail->contact) ? '' : $user->user_detail->contact }}
                        </div>
                    </li>
                    <li>
                        <div class="title">
                            <i class="material-icons">location_on</i>
                            Address
                        </div>
                        <div class="content">
                            {{ empty($user->user_detail->address) ? '' : $user->user_detail->address }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- #END# Show User -->

<!-- Update User Image -->
<div class="modal fade" id="avatar_update_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Avatar</h4>
            </div>
            <div class="modal-body">
                {!! Form::open([ 'method' => 'put', 'route' => ['back.users.update.image', $user->id], 'id'=>'avatar_update_form', 'enctype' => 'multipart/form-data']) !!}
                    <div class="thumbnail">
                        <img src="http://via.placeholder.com/300x300?text=Preview+Selected+Image" alt="avatar update preview" class="img-responsive preview_input">
                        <div class="caption">
                            <div class="button-demo">
                                <label class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="bottom" title="Click here to select an image">
                                    CHOOSE IMAGE {!! Form::file("image", ['class'=>'input_image', 'accept'=>'image/jpeg', 'style'=>'display: none;']) !!}
                                </label>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button class="btn btn-link waves-effect avatar_update_button" type="submit" form="avatar_update_form" disabled>SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- #END# Update User Image -->

@endsection

@section('extra-script')

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/light-gallery/js/lightgallery-all.js')}}

<!-- Jquery Form Plugin Js -->
{{Html::script('plugins/jquery-form/jquery.form.js')}}

@endsection

@section('custom-script')

{{Html::script('js/backend/pages/medias/image-gallery.js')}}

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

<script>

    //  Show profile image preview
    $('.input_image').change(function() {
        readURL(this, $(this).index());
        $('.avatar_update_button').prop('disabled', false);
    });

        //  Refresh preview on modal close
    $('#avatar_update_modal').on('hidden.bs.modal', function (e) {
        $('.preview_input').attr('src', 'http://via.placeholder.com/250x300?text=Preview+Selected+Image');
        $('.input_image').empty().val('');
        $('.avatar_update_button').prop('disabled', true);
    });

    //  Jquery form for uploading profile image and showing progress
    (function() {
        $('#avatar_update_form').ajaxForm({
          beforeSend: function() {
            $('.avatar_update_button').prop('disabled', true);
          },
          uploadProgress: function() {
            $(".modal-content").empty().append("<div class='modal-body text-center'><h5 class='col-cyan'>The photo is being uploaded</h5><div class='progress'><div class='progress-bar progress-bar-primary progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div></div></div>");
          },
          success: function() {
            $(".modal-content").empty().append("<div class='modal-body text-center'><h5 class='col-cyan'><i class='fa fa-check-circle'></i> The photo has been uploaded</h5><p>Please wait till return message..</p><div class='progress'><div class='progress-bar progress-bar-primary progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div></div></div>").fadeIn("slow");        
          },
          error: function() {
           $(".modal-content").empty().append("<div class='modal-body text-center'><h5 class='col-orange'><i class='fa fa-warning'></i> Problem while uploading image!</h5><p>Please wait till return message..</p><div class='progress'><div class='progress-bar progress-bar-primary progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div></div></div>").fadeIn("slow");        
          },
          complete: function(xhr) {
            location.reload();
          }
        }); 
    })();

    function deleteUser(){
        event.preventDefault();
        swal({
            title: 'Are you sure you want to delete this user？',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#d9534f",
            confirmButtonText: 'Yes, delete user.',
            cancelButtonText: 'Cancel',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm){
            if (isConfirm) {
                document.getElementById('delete-user-form').submit();
            }
        });
    }
</script>

@endsection