<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Vendor CSS Files -->
     <!-- vendor css -->
    <link href="{{ asset('assets/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin.dark.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/dashforge.demo.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">



    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  
</head>
<body>

    <div class="content content-fixed content-auth-alt">
      <div class="container d-flex justify-content-center ht-100p">
        <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
          <!-- <div class="wd-80p wd-sm-300 mg-b-15"><img src="https://via.placeholder.com/2083x1466" class="img-fluid" alt=""></div> -->
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                        @csrf
          <p class="tx-color-03 mg-b-30 tx-center">Enter your registered email address and we will send you a link to reset your password.</p>
          <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
            <input type="email" id="email" class="form-control wd-sm-250 flex-fill text-white @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email address">
            <button type="submit" class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">{{ __('Send Link') }}</button>
          </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </form>

        </div>
      </div><!-- container -->
    </div><!-- content -->

    <footer class="footer">
        <div>
        <span><strong><a href="https://planetscale.com/?utm_source=hashnode&utm_medium=hackathon&utm_campaign=announcement_article" target="_blank">PlanetScale</a> & 
        <a href="https://hashnode.com/?source=planetscale_hackathon_announcement" target="_blank">Hashnode</a></strong> July 2022 hackathon</span>
        
      </div>
      <div>
      <span>Created by <a href="https://hashnode.com/@bemuron" target="_blank">@bemuron</a></span>
      </div>
    </footer>

    <script type="text/javascript" src="{{ asset('assets/vendor2/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor2/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor2/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor2/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/feather-icons/feather.min.js') }}"></script>
    
</body>
</html>

