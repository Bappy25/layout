@extends('backend.layouts.auth')

@section('content-class')
signup-page
@endsection

@section('content')

<div class="signup-box">
    <div class="logo">
        <a href="javascript:void(0);">{{ __('Reset Password') }}</a>
        <small>MDB Admin Panel</small>
    </div>
    <div class="card">
        <div class="body">
            <form action="{{ route('back.password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <div class="msg">{{ __('Reset Password') }}</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line @error('email') error @enderror">
                        <input type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" placeholder="Email Address">
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
                        <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirm Password">
                    </div>
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">{{ __('Reset Password') }}</button>
            </form>
        </div>
    </div>
</div>

@endsection
