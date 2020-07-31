@extends('backend.layouts.master')

@section('title')
Front Page
@endsection

@section('extra-css')

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}

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

                @php
                $welcome = json_decode($content->web_contents);
                @endphp

                {!! Form::open(['method' => 'put', 'route' => ['back.contents.update', $content->id], 'name'=>'check_edit', 'class' => 'demo-masked-input', 'id' => 'form_validation']) !!}

                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Form::text("slogan", empty($welcome->slogan) ? null : $welcome->slogan, ['class'=>'form-control', 'autocomplete'=>'off', 'required' => 'required']) !!}
                        {!! Form::label("slogan", 'slogan', ['class' => 'form-label']) !!}
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Form::text("keywords", empty($welcome->keywords) ? null : $welcome->keywords, ['class'=>'form-control', 'data-role' => 'tagsinput', 'placeholder' => 'SEO Keywords']) !!}
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Form::textarea("description", empty($welcome->description) ? null : $welcome->description, ['class'=>'form-control no-resize auto-growth', 'rows'=>3, 'autocomplete'=>'off', 'required' => 'required']) !!}
                        {!! Form::label("description", 'Description', ['class' => 'form-label']) !!}
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                {!! Form::text("contact", empty($welcome->contact) ? null : $welcome->contact, ['class'=>'form-control mobile-phone-number', 'autocomplete'=>'off', 'required' => 'required']) !!}
                                {!! Form::label("contact", 'Contact', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                {!! Form::email("email", empty($welcome->email) ? null : $welcome->email, ['class'=>'form-control', 'autocomplete'=>'off', 'required' => 'required']) !!}
                                {!! Form::label("email", 'Email', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                {!! Form::url("facebook", empty($welcome->facebook) ? null : $welcome->facebook, ['class'=>'form-control', 'autocomplete'=>'off', 'required' => 'required']) !!}
                                {!! Form::label("facebook", 'Facebook', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                {!! Form::url("twitter", empty($welcome->twitter) ? null : $welcome->twitter, ['class'=>'form-control', 'autocomplete'=>'off', 'required' => 'required']) !!}
                                {!! Form::label("twitter", 'Twitter', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                {!! Form::url("youtube", empty($welcome->youtube) ? null : $welcome->youtube, ['class'=>'form-control', 'autocomplete'=>'off', 'required' => 'required']) !!}
                                {!! Form::label("youtube", 'Youtube', ['class' => 'form-label']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Form::textarea("address", empty($welcome->address) ? null : $welcome->address, ['class'=>'form-control no-resize auto-growth', 'rows'=>1, 'autocomplete'=>'off', 'required' => 'required']) !!}
                        {!! Form::label("address", 'Address', ['class' => 'form-label']) !!}
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

<!-- Autosize Js -->
{{Html::script('plugins/autosize/autosize.js')}}

<!-- Input Mask Plugin Js -->
{{Html::script('plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}

<!-- Bootstrap Tags Input Plugin Js -->
{{Html::script('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}

<!-- Jquery Validation Plugin Css -->
{{Html::script('plugins/jquery-validation/jquery.validate.js')}}

@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

        // Initialize Date Input Mask
    var $demoMaskedInput = $('.demo-masked-input');

    $(function () {

        autosize($('textarea.auto-growth'));

        //Mobile Phone Number
        $demoMaskedInput.find('.mobile-phone-number').inputmask('+99 (999) 999-99-99', { placeholder: '+__ (___) ___-__-__' });

    });

</script>

<!-- Form Validation Js -->
{{Html::script('js/backend/pages/forms/form-validation.js')}}

@endsection