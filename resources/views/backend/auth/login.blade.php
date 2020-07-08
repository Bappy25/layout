@extends('backend.layouts.auth')

@section('content-class')
login-page
@endsection

@section('content')


<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">{{ __('Login') }}</a>
        <small>MDB Admin Panel</small>
    </div>
    <div class="card">
        <div class="body">
            <form method="POST" action="{{ route('back.login') }}" id="sign_in">
                @csrf
                <div class="msg">Sign in to start your session</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line @error('email') error @enderror">
                        <input type="text" class="form-control" name="email" placeholder="E-Mail Address" autofocus>
                    </div>
                    @error('email')
                    <label id="email-error" class="error" for="email">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line @error('password') error @enderror">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    @error('password')
                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="rememberme" class="filled-in chk-col-pink" {{ old('remember') ? 'checked' : '' }}>
                        <label for="rememberme">Remember Me</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">{{ __('Login') }}</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-6">
                        <a href="{{ route('back.register') }}">Register Now!</a>
                    </div>
                    <div class="col-xs-6 align-right">
                        @if (Route::has('password.request'))
                        <a href="{{ route('back.password.request') }}">Forgot Password?</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-script')

{{Html::script('js/adminbsb/pages/examples/sign-in.js')}}

@endsection
