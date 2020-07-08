@extends('backend.layouts.master')

@section('title')
All Users || {{ $user->name }}
@endsection

@section('content')
<div class="block-header">
    <h2>USERS</h2>
</div>
<!-- Basic Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $user->name }}
                    <small><strong>Craeted At:</strong> {{ $user->created_at->format('d/m/y, h:m a') }}</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('back.users.edit', $user->id) }}">Edit User</a></li>
                            <li><a href="javascript:void(0);" onclick="deleteUser()">Delete User</a></li>
                            {!! Form::open(['route' => ['back.users.destroy', $user->id], 'method'=>'delete', 'style'=>'display: none;']) !!}
                            {!! Form::close() !!}
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<!-- #END# Basic Table -->
@endsection

@section('custom-script')

<!-- Demo Js -->
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