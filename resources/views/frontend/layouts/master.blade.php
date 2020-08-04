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
    <script type="text/javascript">
        $( window ).resize(function() {
            // Align footer on windows resize
            footerAlign();
        });
        $(document).ready(function(){
            // Align footer on windows resize
            footerAlign();
            // Set when the loading screen will stop
            setTimeout(function(){ 
              $('.page-loader-wrapper').fadeOut(); 
            }, 50);
            // hide button to scroll to top  
            $("#scrollToTopButton").hide();
          
            //  Check to see if the window is top if not then display button
            $(window).scroll(function(){
              if ($(this).scrollTop() > 200) {
                $("#scrollToTopButton").fadeIn();
              } else {
                $("#scrollToTopButton").fadeOut();
              }
            });
            //  Click event to scroll to top
            $("#scrollToTopButton").click(function(){
              $('html, body').animate({scrollTop : 0},800);
              return false;
            });
            // Declare Popover
            $(function () {
              $('[data-toggle="popover"]').popover()
            });
        });
        // Function for aligning footer
        function footerAlign() {
            $('footer').css('display', 'block');
            $('footer').css('height', 'auto');
            var footerHeight = $('footer').outerHeight();
            $('body').css('padding-bottom', footerHeight);
            $('footer').css('height', footerHeight);
        }
    </script>

    @auth
    <!-- Notifications and Messages -->
    {{Html::script('js/frontend/notifications.js')}}
    @endauth

    @yield('custom-script')

</body>
</html>
