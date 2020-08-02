<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <title>@yield('title') {{ config('app.name', 'Laravel') }}</title>

    <!-- System icon -->
    <link rel="icon" href="{{{ asset('images/frontend/favicon.ico') }}}" type="image/x-icon">

    <!-- CSS-->
    @include('frontend.layouts.partials.styles')

    @yield('extra-css')

    <!-- System-wide Custom styles -->
    {{ Html::style('css/frontend/style.css') }}

    @yield('custom-css')

</head>
<body>

    <!-- Page Loader -->
    @include('frontend.layouts.partials.loader')
    <!-- #Page Loader -->

    <div id="app">

        <!-- Navigation Bar -->
        @include('frontend.layouts.partials.navigation')
        <!-- #Navigation Bar -->

        <!-- Scroll to top -->
        @include('frontend.layouts.partials.alerts')
        <!-- #Scroll to top -->

        <!-- Content-->
        <main class="py-4">
            @yield('content')
        </main>
        <!-- Content-->

        <!-- Scroll to top -->
        @include('frontend.layouts.partials.scrolltotop')
        <!-- #Scroll to top -->

        <!-- Footer -->
        @include('frontend.layouts.partials.footer')
        <!-- #Footer -->

    </div>

    <!-- Scripts -->
    @include('frontend.layouts.partials.scripts')

    @yield('extra-script')

    <!-- System-wide custom script -->
    {{Html::script('js/frontend/script.js')}}

    @yield('custom-script')

</body>
</html>
