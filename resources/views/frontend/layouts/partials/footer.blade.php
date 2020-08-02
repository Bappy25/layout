@php
$content = App\Models\Content::where('headline', 'welcome')->firstOrFail();
$footer = json_decode($content->web_contents);
@endphp
<footer class="font-small grey lighten-5 pt-4">

  <div class="container">

    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

      <!-- Grid row -->
      <div class="row">

        <!-- Grid column -->
        <div class="col-md-6 mt-md-0 mt-3">

          <!-- Content -->
          <h5 class="text-uppercase">{{ config('app.name', 'Laravel') }}</h5>
          <p>{{ empty($footer->slogan) ? null : $footer->slogan }}</p>
          <!-- Facebook -->
          <a class="fb-ic" href="{{ empty($footer->facebook) ? null : $footer->facebook }}">
            <i class="fab fa-facebook-f fa-lg mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!-- Twitter -->
          <a class="tw-ic" href="{{ empty($footer->twitter) ? null : $footer->twitter }}">
            <i class="fab fa-twitter fa-lg mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!--Youtube-->
          <a class="yt-ic" href="{{ empty($footer->youtube) ? null : $footer->youtube }}">
            <i class="fab fa-youtube fa-lg fa-2x"> </i>
          </a>

        </div>
        <!-- Grid column -->

        <hr class="clearfix w-100 d-md-none pb-3">

        <!-- Grid column -->
        <div class="col-md-3 mb-md-0 mb-3">

          <!-- Links -->
          <h5 class="text-uppercase">Links</h5>

          <ul class="list-unstyled">
            <li>
              <a href="{{ route('news.index') }}">News</a>
            </li>
            <li>
              <a href="{{ route('about_us') }}">About Us</a>
            </li>
            <li>
              <a href="{{ route('terms_of_use') }}">Terms of Use</a>
            </li>
            <li>
              <a href="{{ route('privacy_policy') }}">Privacy Policy</a>
            </li>
          </ul>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 mb-md-0 mb-3">

          <!-- Links -->
          <h5 class="text-uppercase">Contact</h5>

          <p><i class="fas fa-envelope pr-2"></i>{{ empty($footer->email) ? null : $footer->email }}</p>
          <p><i class="fas fa-phone pr-2"></i>{{ empty($footer->contact) ? null : $footer->contact }}</p>
          <p><i class="fas fa-location-arrow pr-2"></i>{{ empty($footer->address) ? null : $footer->address }}</p>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
    <!-- Footer Links -->

  </div>

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© {{ date('Y') }} Copyright:
    <a href="http://mhasan.amrameghnabasi.org"> Mahadi Hasan</a>
  </div>
  <!-- Copyright -->

</footer>