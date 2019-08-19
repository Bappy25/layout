@extends('backend.layouts.auth')

@section('content-class')
fp-page
@endsection

@section('content')

<div class="fp-box">
    <div class="logo">
        <a href="javascript:void(0);">{{ __('Reset Password') }}</a>
        <small>MDB Admin Panel</small>
    </div>
    <div class="card">
        <div class="body">
            <form id="forgot_password" method="POST" action="{{ route('back.password.email') }}">
                @csrf
                <div class="msg">
                    Enter your email address that you used to register. We'll send you an email with your username and a
                    link to reset your password.
                </div>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line  @error('email') error @enderror">
                        <input type="email" class="form-control" name="email" placeholder="Email" autofocus>
                    </div>
                    @error('email')
                    <label id="email-error" class="error" for="email">{{ $message }}</label>
                    @enderror
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">{{ __('Send Password Reset Link') }}</button>

                <div class="row m-t-20 m-b--5 align-center">
                    <a href="{{ route('back.login') }}">Sign In!</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-script')

{{Html::script('js/adminbsb/pages/examples/forgot-password.js')}}

@endsection
