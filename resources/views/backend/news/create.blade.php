@extends('backend.layouts.master')

@section('title')
Add New News
@endsection

@section('extra-css')

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}

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
                {!! Form::open(['method' => 'post', 'route' => 'back.news.store', 'name'=>'check_edit', 'id' => 'form_validation']) !!}

                <div class="form-group">
                    {!! Form::label("title") !!}
                    <div class="form-line">
                        {!! Form::textarea("title", null, ['class'=>'form-control no-resize auto-growth', 'rows'=>1, 'autocomplete'=>'off', 'required' => 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label("tags") !!}
                    <div class="form-line">
                        {!! Form::text("tags", null, ['class'=>'form-control', 'data-role' => 'tagsinput']) !!}
                    </div>
                </div>

                {!! Form::button('<span>Next</span><i class="material-icons">skip_next</i>', ['class'=>'btn bg-green waves-effect', 'type' => 'submit']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- #END# Admins Table -->
@endsection

@section('extra-script')

<!-- Autosize Js -->
{{Html::script('plugins/autosize/autosize.js')}}

<!-- Bootstrap Tags Input Plugin Js -->
{{Html::script('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}

<!-- Jquery Validation Plugin Css -->
{{Html::script('plugins/jquery-validation/jquery.validate.js')}}

@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

    $(function () {

        autosize($('textarea.auto-growth'));

    });

</script>

<!-- Form Validation Js -->
{{Html::script('js/backend/pages/forms/form-validation.js')}}

@endsection