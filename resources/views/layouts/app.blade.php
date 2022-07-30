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

    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor2/datatable/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin.dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.demo.css') }}">
    
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  
</head>
<body>
    <div id="loader" class="lds-dual-ring hidden overlay"></div>

    <div class="hidden" id="custom-alert">
        <span class="closebtn">&times;</span>  
        <strong id="alert-msg"></strong>
    </div>
    <!-- <div id="hero"> -->
        @guest
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <a class="navbar-brand df-logo" href="{{ url('/') }}">
                            Filr
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                @else
                <header class="navbar navbar-header navbar-header-fixed">
                <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
                <div class="navbar-brand">
                    <a href="{{ route('home') }}" class="df-logo">Filr</a>
                </div><!-- navbar-brand -->
                <div id="navbarMenu" class="navbar-menu-wrapper">
                    <div class="navbar-menu-header">
                    <a href="{{ route('home') }}" class="df-logo">Filr</a>
                    <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
                    </div><!-- navbar-menu-header -->
                    <ul class="nav navbar-menu">
                    <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
                    </ul>
                </div><!-- navbar-menu-wrapper -->
                
                <div class="navbar-right">
                
                </div>
                
                <div class="navbar-right">
                    <div class="dropdown dropdown-profile">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a><!--dropdown-link -->
                    <div class="dropdown dropdown-menu dropdown-menu-right tx-13">
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i data-feather="log-out"></i>{{ __('Sign Out') }}</a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div><!-- dropdown-menu -->
                    </div><!-- dropdown -->
                </div><!-- navbar-right -->
                </header><!-- navbar -->
                @endguest

        <main class="py-4">
            @yield('content')
        </main>
    <!-- </div> -->

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
    <!-- <script type="text/javascript" src="{{ asset('assets/vendor2/jquery/jquery-ui.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('assets/vendor2/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor2/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/feather-icons/feather.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendor2/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendor2/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendor2/datatable/datatable.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/dashforge.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script> 
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
