@extends('backend.layouts.auth')

@section('content-class')
login-page
@endsection

@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">{{ __('Verify Your Email Address') }}</a>
        <small>MDB Admin Panel</small>
    </div>
    <div class="card">
        <div class="body">
            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a href="{{ route('back.verification.resend') }}">{{ __('click here to request another') }}</a>.
        </div>
    </div>
</div>
@endsection
