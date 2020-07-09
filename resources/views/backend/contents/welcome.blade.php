@extends('backend.layouts.master')

@section('title')
Front Page
@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">language</i> Web Contents</li>
        <li class="active"><i class="material-icons">edit</i> Front Page</li>
    </ol>
</div>

<!-- Admins Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Front Page
                    <small>Information displayed in <strong>front welcome</strong> page</small>
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