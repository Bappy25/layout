@extends('backend.layouts.master')

@section('title')
MDB Admin Panel
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in, {{ Auth::guard('admin')->user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/adminbsb/script.js')}}

@endsection
