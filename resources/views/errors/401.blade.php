<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- System icon -->
  <link rel="icon" href="{{{ asset('images/frontend/favicon.ico') }}}" type="image/x-icon">

  <!-- CSS-->
  @include('frontend.layouts.partials.styles')

  <!-- System-wide Custom styles -->
  {{ Html::style('css/frontend/style.css') }}

</head>
<body>

  <!-- Error Message-->  
  <div style="height: 100vh">
    <div class="flex-center flex-column">
      <h1 class="text-muted animated fadeIn mb-4"><i class="far fa-frown mr-1"></i>ops..</h1>
      <h2 class="animated fadeIn mb-3">Error 401!</h2>
      <h3 class="animated fadeIn text-muted">You are not authorized to visit this page!</h3>
      <p><a href="{{ route('welcome') }}" class="animated fadeIn btn btn-primary"><i class="fas fa-home mr-3"></i>Go to homepage</a></p>
    </div>
  </div>
  <!-- Error Message-->

</body>
</html>
