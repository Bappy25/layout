@extends('backend.layouts.master')

@section('title')
{{ $user->exists ? "All Users || $user->name || Edit User" : "Add New User" }}
@endsection

@section('extra-css')

<!-- Light Gallery Plugin Js -->
{{ Html::style('plugins/bootstrap-select/css/bootstrap-select.css') }}

@endsection

@section('content')

<div class="block-header">
    <div class="block-header">
        <ol class="breadcrumb breadcrumb-col-teal">
            <li><i class="material-icons">people</i> Users</li>
            @if($user->exists)
            <li><a href="{{ route('back.users.index') }}"><i class="material-icons">list</i> All Users</a></li>
            <li><a href="{{ route('back.users.show', $user->id) }}"><i class="material-icons">open_in_browser</i> {{ $user->name }}</a></li>
            <li class="active"><i class="material-icons">edit</i> Edit User</li>
            @else
            <li class="active"><i class="material-icons">playlist_add</i> Add New User</li>
            @endif
        </ol>
    </div>
</div>

<!-- Users Form -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $user->exists ? "Edit User" : "Add New User" }}
                </h2>
            </div>
            <div class="body">
                {!! Form::model($user, [ 'method' => $user->exists ? 'put' : 'post', 'route' => $user->exists ? ['back.users.update', $user->id] : ['back.users.store'], 'name'=>'check_edit', 'class' => 'demo-masked-input']) !!}

                @include('backend.layouts.partials.errors')


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("Name") !!}<span class="caution">*</span>
                            <div class="form-line @error('name') error focused @enderror">
                                {!! Form::text("name", null, ['class'=>'form-control '.($errors->has("name") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                            </div>
                            @if($errors->has('name'))
                            <label class="error" for="name">{{ $errors->first('name')}}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("Username") !!}<span class="caution">*</span>
                            <div class="form-line @error('username') error focused @enderror">
                                {!! Form::text("username", null, ['class'=>'form-control '.($errors->has("username") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                            </div>
                            @if($errors->has('username'))
                            <label class="error" for="username">{{ $errors->first('username')}}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            {!! Form::label("Email") !!}<span class="caution">*</span>
                            <div class="form-line @error('email') error focused @enderror">
                                {!! Form::text("email", null, ['class'=>'form-control '.($errors->has("email") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                            </div>
                            @if($errors->has('email'))
                            <label class="error" for="email">{{ $errors->first('email')}}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {!! Form::label("Contact") !!}<span class="caution">*</span>
                            <div class="form-line @error('contact') error focused @enderror">
                                {!! Form::text("contact", empty($user->user_detail->contact) ? null : $user->user_detail->contact, ['class'=>'form-control '.($errors->has("contact") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                            </div>
                            @if($errors->has('contact'))
                            <label class="error" for="contact">{{ $errors->first('contact')}}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {!! Form::label("Date Of Birth") !!}<span class="caution">*</span>
                            <div class="form-line @error('contact') error focused @enderror">
                                {!! Form::text("dob", empty($user->user_detail->dob) ? null  : $user->user_detail->dob->format('d/m/yy'), ['class'=>'form-control date '.($errors->has("dob") ? "is-invalid" : ""),'autocomplete'=>'off']) !!}
                            </div>
                            @if($errors->has('contact'))
                            <label class="error" for="contact">{{ $errors->first('contact')}}</label>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::select('gender', config('genders'), empty($user->user_detail->gender) ? null  : $user->user_detail->gender, [ 'class' => 'form-control show-tick', 'placeholder' => '-- Select Gender --']); !!}
                </div>

                <div class="form-group">
                    <div class="form-line">
                        {!! Form::textarea("address", empty($user->user_detail->address) ? null : $user->user_detail->address, ['class'=>'form-control no-resize auto-growth '.($errors->has("dob") ? "is-invalid" : ""), 'rows'=>1, 'autocomplete'=>'off']) !!}
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("Password") !!}<span class="caution">*</span>
                            <div class="form-line @error('password') error focused @enderror">
                                {!! Form::password("password", ['class'=>'form-control '.($errors->has("password") ? "is-invalid" : "")]) !!}
                            </div>
                            @if($errors->has('password'))
                            <label class="error" for="password">{{ $errors->first('password') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('Password Confirmation') !!}<span class="caution">*</span>
                            <div class="form-line @error('password_confirmation') error focused @enderror">
                            {!! Form::password('password_confirmation', ['class'=>'form-control'. ($errors->has('password_confirmation') ? ' is-invalid' : '')]) !!}
                            </div>
                            @if($errors->has('password_confirmation'))
                            <label class="error" for="password_confirmation">{{ $errors->first('password_confirmation')}}</label>
                            @endif
                        </div>
                    </div>
                </div>                

                {!! Form::submit($user->exists ? "Update" : "Store", ['class'=>'btn btn-primary waves-effect']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
<!-- #END# Users Form -->

@endsection

@section('extra-script')

<!-- Demo Js -->
{{Html::script('plugins/autosize/autosize.js')}}

<!-- Input Mask Plugin Js -->
{{Html::script('plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}

@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

        // Initialize Date Input Mask
    var $demoMaskedInput = $('.demo-masked-input');

    $(function () {

        autosize($('textarea.auto-growth'));

        $demoMaskedInput.find('.date').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });

    });

</script>

@endsection