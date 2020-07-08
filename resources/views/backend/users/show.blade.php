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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $user->name }}
                    <small>
                        <strong>Created At:</strong> {{ $user->created_at->format('d/m/y, h:m a') }}
                        <strong class="p-l-10">Verified at: </strong> {{ empty($user->email_verified_at) ? 'Not yet verified!' : $user->email_verified_at->format('d/m/y, h:m a') }}
                    </small>
                </h2>
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
                <div id="aniimated-thumbnials">
                    <a href="{{ empty($user->user_detail->avatar) ? 'https://via.placeholder.com/150?text=Image+Missing' : asset($user->user_detail->avatar) }}" data-sub-html="{{ $user->name }}">
                        <img class="img-responsive thumbnail" src="{{ empty($user->user_detail->avatar) ? 'https://via.placeholder.com/150?text=Image+Missing' : asset($user->user_detail->avatar) }}" alt="{{ $user->name }}">
                    </a>
                </div>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Date of Birth:</strong> {{ empty($user->user_detail->dob) ? '' : $user->user_detail->dob->format('d/m/y') }}</p>
                <p><strong>Contact:</strong> {{ empty($user->user_detail->contact) ? '' : $user->user_detail->contact }}</p>
                <p><strong>Gender:</strong> {{ config('genders.'.$user->user_detail->gender) }}</p>
                <p><strong>Address:</strong> {{ empty($user->user_detail->address) ? '' : $user->user_detail->address }}</p>
            </div>
        </div>
    </div>
</div>
<!-- Show User -->

@endsection

@section('extra-script')

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/light-gallery/js/lightgallery-all.js')}}

@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/pages/medias/image-gallery.js')}}
{{Html::script('js/backend/script.js')}}

<script>
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