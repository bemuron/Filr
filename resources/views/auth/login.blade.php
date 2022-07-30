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

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
          <div class="media-body align-items-center d-none d-lg-flex">
            <div class="mx-wd-600">
                <img src="assets/img/login-img.png" class="img-fluid" alt="">
            </div>
          </div>
          <!-- media-body -->
          <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
            <div class="wd-100p">
            <!-- <div class="avatar avatar-xxl"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div> -->
                <h3 class="tx-color-01 mg-b-5">Filr - Your online file folder</h3>
                <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>

                <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="form-group">
                        <label>Email address</label>
                        <!-- <input type="email" id="email" class="form-control" placeholder="Your domain username"> -->
                        <input id="email" type="text" class="form-control text-white @error('email') is-invalid @enderror" placeholder="Your email address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mg-b-5">
                        <label class="mg-b-0-f">Password</label>
                        
                        </div>
                        <input id="password" type="password" placeholder="Your password" class="form-control text-white @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                    @endif

                    <div class="tx-13 mg-t-20 tx-center">Don't have an account? <a href="{{ route('register') }}">Create an Account</a></div>
                </form>
            </div>
          </div><!-- sign-wrapper -->
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
