<!DOCTYPE html>
<html>

<!-- Header -->
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Favicon-->
    <link rel="icon" href="{{{ asset('images/backend/favicon.ico') }}}" type="image/x-icon">

    <!-- CSS-->
    @include('backend.layouts.partials.styles')

    @yield('extra-css')

    <!-- Custom Css -->
    {{ Html::style('css/backend/style.min.css') }}

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    {{ Html::style('css/backend/themes/all-themes.css') }}

    @yield('custom-css')

</head>
<!-- #ENDS# Header -->

<body class="theme-red main-body">

    <!-- Page Loader -->
    @include('backend.layouts.partials.loader')
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Top Bar -->
    @include('backend.layouts.partials.topbar')
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        @include('backend.layouts.partials.leftsidebar')
        <!-- #END# Left Sidebar -->
    </section>

    <!-- Content Section -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
    </div>
</section>
<!-- #ENDS# Content Section -->

<!-- View Alerts -->
@include('backend.layouts.partials.alerts')
<!-- #END# Alerts -->

<!-- Scroll to top -->
@include('backend.layouts.partials.scrolltotop')
<!-- #END# Scroll to top -->

<!-- Scripts -->
@include('backend.layouts.partials.scripts')

@yield('extra-script')

<!-- Custom Js -->
{{Html::script('js/backend/admin.js')}}

@yield('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/demo.js')}}

<!-- #ENDS# Javascript -->


</body>

</html>
