@extends('backend.layouts.master')

@section('title')
About Us
@endsection

@section('extra-css')

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}

@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">language</i> Web Contents</li>
        <li class="active"><i class="material-icons">edit</i> About Us</li>
    </ol>
</div>

<!-- Admins Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    About Us
                    <small>Information displayed in <strong>about us</strong> page</small>
                </h2>
            </div>
            <div class="body">
                @php
                $about = json_decode($content->web_contents);
                @endphp

                {!! Form::open(['method' => 'put', 'route' => ['back.contents.update', $content->id], 'name'=>'check_edit', 'class' => 'demo-masked-input', 'id' => 'form_validation']) !!}

                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Form::text("keywords", empty($about->keywords) ? null : $about->keywords, ['class'=>'form-control', 'data-role' => 'tagsinput', 'placeholder' => 'SEO Keywords']) !!}
                    </div>
                </div>


                {!! Form::submit("Update", ['class'=>'btn btn-primary waves-effect']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- #END# Admins Table -->
@endsection

@section('extra-script')

<!-- Bootstrap Tags Input Plugin Js -->
{{Html::script('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}

<!-- Jquery Validation Plugin Css -->
{{Html::script('plugins/jquery-validation/jquery.validate.js')}}

@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

<!-- Form Validation Js -->
{{Html::script('js/backend/pages/forms/form-validation.js')}}

@endsection