@extends('backend.layouts.auth')

@section('content-class')
signup-page
@endsection

@section('content')


<div class="signup-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin<b>BSB</b></a>
        <small>MDB Admin Panel</small>
    </div>
    <div class="card">
        <div class="body">
            <form action="{{ route('back.register') }}" method="POST" id="sign_up">
                @csrf
                <div class="msg">Register a new membership</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line @error('name') error @enderror">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                    </div>
                    @error('name')
                    <label id="name-error" class="error" for="username">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line @error('email') error @enderror">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
                    </div>
                    @error('email')
                    <label id="email-error" class="error" for="username">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line @error('password') error @enderror">
                        <input type="password" class="form-control" name="password" minlength="6" placeholder="Password">
                    </div>
                    @error('password')
                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                    <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                <div class="m-t-25 m-b--5 align-center">
                    <a href="{{ route('back.login') }}">You already have a membership?</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-script')

{{Html::script('js/adminbsb/pages/examples/sign-up.js')}}

@endsection
