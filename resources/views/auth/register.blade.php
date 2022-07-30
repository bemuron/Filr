<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Your online file folder</title>

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

    <div class="content content-fixed content-auth">
      <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p">
          <div class="sign-wrapper mg-lg-r-50 mg-xl-r-60">
            <div class="wd-100p">
              <h4 class="tx-color-01 mg-b-5">Create New Account ... </h4>
              <p class="tx-color-03 tx-16 mg-b-40">... and enjoy free small file storage using Filr</p>

              <form method="POST" action="{{ route('register') }}">
                        @csrf
              <div class="form-group">
                <label>Email address</label>
                <input id="email" type="email" class="form-control text-white @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address" autofocus>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between mg-b-5">
                  <label class="mg-b-0-f">Password</label>
                </div>
                <input id="password" type="password" class="form-control text-white @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your password">
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between mg-b-5">
                  <label class="mg-b-0-f">Password Confirm</label>
                </div>
                <input id="password-confirm" type="password" class="form-control text-white" name="password_confirmation" required autocomplete="new-password">
              </div>
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" id="name" class="form-control text-white @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Enter your full name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <button type="submit" class="btn btn-brand-02 btn-block">Create Account</button>
              </form>
              <div class="tx-13 mg-t-20 tx-center">Already have an account? <a href="{{ route('login') }}">Sign In</a></div>
            </div>
          </div><!-- sign-wrapper -->
          <div class="media-body pd-y-30 pd-lg-x-50 pd-xl-x-60 align-items-center d-none d-lg-flex pos-relative">
            <div class="mx-lg-wd-500 mx-xl-wd-550">
              <img src="assets/img/reg-img.png" class="img-fluid" alt="">
            </div>
          </div><!-- media-body -->
        </div><!-- media -->
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
