@extends('backend.layouts.master')

@section('title')
All News
@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">rss_feed</i> News</li>
        <li class="active"><i class="material-icons">list</i> All News</li>
    </ol>
</div>

<!-- All News Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All News
                    <small>Here is the list of all news</small>
                </h2>
            </div>
            <div class="body table-responsive">
            </div>
        </div>
    </div>
</div>
<!-- #END# All News Table -->
@endsection

@section('custom-script')

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

@endsection