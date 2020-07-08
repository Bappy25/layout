@extends('backend.layouts.master')

@section('title')
{{ $admin->exists ? "All Administrators || Edit Administrator" : "Add New Administrator" }}
@endsection

@section('content')

<div class="block-header">
    <h2>ADMINISTRATORS</h2>
</div>

<div class="block-header">
    <div class="block-header">
        <ol class="breadcrumb breadcrumb-col-teal">
            <li><i class="material-icons">verified_user</i> Administrators</li>
            @if($admin->exists)
            <li><a href="{{ route('back.admins.index') }}"><i class="material-icons">list</i> All Administrators</a></li>
            <li class="active"><i class="material-icons">edit</i> Edit Administrator</li>
            @else
            <li class="active"><i class="material-icons">playlist_add</i> Add New Administrator</li>
            @endif
        </ol>
    </div>
</div>

<!-- Admins Form -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $admin->exists ? "Edit Administrator" : "Add New Administrator" }}
                </h2>
            </div>
            <div class="body">
                {!! Form::model($admin, [ 'method' => $admin->exists ? 'put' : 'post', 'route' => $admin->exists ? ['back.admins.update', $admin->id] : ['back.admins.store'], 'name'=>'check_edit']) !!}

                @include('backend.layouts.partials.errors')

                <div class="form-group">
                    {!! Form::label("Name") !!}<span class="caution">*</span>
                    <div class="form-line @error('name') error focused @enderror">
                        {!! Form::text("name", $admin->exists ? $admin->name : null, ['class'=>'form-control '.($errors->has("name") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                    </div>
                    @if($errors->has('name'))
                    <label class="error" for="name">{{ $errors->first('name')}}</label>
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label("Email") !!}<span class="caution">*</span>
                    <div class="form-line @error('email') error focused @enderror">
                        {!! Form::text("email", $admin->exists ? $admin->email : null, ['class'=>'form-control '.($errors->has("email") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                    </div>
                    @if($errors->has('email'))
                    <label class="error" for="email">{{ $errors->first('email')}}</label>
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label("Password") !!}<span class="caution">*</span>
                    <div class="form-line @error('password') error focused @enderror">
                        {!! Form::password("password", ['class'=>'form-control '.($errors->has("password") ? "is-invalid" : "")]) !!}
                    </div>
                    @if($errors->has('password'))
                    <label class="error" for="password">{{ $errors->first('password')}}</label>
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label('Password Confirmation') !!}<span class="caution">*</span>
                    <div class="form-line @error('password_confirmation') error focused @enderror">
                    {!! Form::password('password_confirmation', ['class'=>'form-control'. ($errors->has('password_confirmation') ? ' is-invalid' : '')]) !!}
                    </div>
                    @if($errors->has('password_confirmation'))
                    <label class="error" for="password_confirmation">{{ $errors->first('password_confirmation')}}</label>
                    @endif
                </div>

                {!! Form::submit($admin->exists ? "Update" : "Store", ['class'=>'btn btn-primary waves-effect']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
<!-- #END# Admins Form -->
@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

@endsection