<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    {{ Html::style('plugins/bootstrap/css/bootstrap.css') }}

    <!-- Waves Effect Css -->
    {{ Html::style('plugins/node-waves/waves.css') }}

    <!-- Animation Css -->
    {{ Html::style('plugins/animate-css/animate.css') }}

    <!-- Custom Css -->
    {{ Html::style('css/adminbsb/style.min.css') }}
</head>

<body class="@yield('content-class')">
    @yield('content')

    <!-- Jquery Core Js -->
    {{Html::script('plugins/jquery/jquery.min.js')}}

    <!-- Bootstrap Core Js -->
    {{Html::script('plugins/bootstrap/js/bootstrap.js')}}

    <!-- Waves Effect Plugin Js -->
    {{Html::script('plugins/node-waves/waves.js')}}

    <!-- Validation Plugin Js -->
    {{Html::script('plugins/jquery-validation/jquery.validate.js')}}

    <!-- Custom Js -->
    {{Html::script('js/adminbsb/admin.js')}}

    @yield('custom-script')
</body>

</html>
