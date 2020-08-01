@extends('backend.layouts.master')

@section('title')
Add New News
@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">rss_feed</i> News</li>
        <li class="active"><i class="material-icons">playlist_add</i> Add New News</li>
    </ol>
</div>

<!-- Admins Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Add New News
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