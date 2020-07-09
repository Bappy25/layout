@extends('backend.layouts.master')

@section('title')
Privacy Policy
@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">language</i> Web Contents</li>
        <li class="active"><i class="material-icons">edit</i> Privacy Policy</li>
    </ol>
</div>

<!-- Admins Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Privacy Policy
                    <small>Information displayed in <strong>privacy policy</strong> page</small>
                </h2>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<!-- #END# Admins Table -->
@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

@endsection