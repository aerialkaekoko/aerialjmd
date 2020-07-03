{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{AppSettings::get('app_name')}}-{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><!-- Seaech Jquery -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/52c54abd13.js" crossorigin="anonymous"></script>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script>


    @stack('styles')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md fixed-top">
            <div class="container">

                <p class="logo"><a href="/" title="LOGO"><img class="f_logo" src="/storage/{{AppSettings::get('logo')}}"
                            alt="LOGO JMD" title="LOGO JMD"></a></p>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    MENU
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('news') }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user_voice') }}">User Voice</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('hospitals') }}">Hospitals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user_guide') }}">User guide</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('company_profile') }}">Company Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact_us') }}">Contact</a>
                        </li>

                        <!-- Right Side Of Navbar -->

                        <!-- Authentication Links -->
                        @guest

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span
                                    class="fas fa-user"></span><span class="caret"></span></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="nav-link " href="{{ url('login') }}"><span class="fas fa-user"></span>
                                    {{ __('Login') }}</a>

                                <a class="nav-link " href="{{ url('register') }}"><span
                                        class="fas fa-sign-in-alt"></span> {{ __('Register') }}</a>
                            </div>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="far fa-bell"></i>
                                <span class="badge badge-warning navbar-badge">15</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <span class="dropdown-item dropdown-header">15 Notifications</span>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                                    <span class="float-right text-muted text-sm">3 mins</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-users mr-2"></i> 8 friend requests
                                    <span class="float-right text-muted text-sm">12 hours</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-file mr-2"></i> 3 new reports
                                    <span class="float-right text-muted text-sm">2 days</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="/profile" class="dropdown-item">profile</a>
                                <a class="dropdown-item" href="{{ url('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="content">
            @yield('content')
        </main>
    </div>

</body>
<!-- Footer -->
<footer class="page-footer font-small unique-color-dark">
    <div class="footer_inner">

        <!-- footer logo -->
        <div id="footer_logo">
            <div class="logo_area">
                <p class="logo"><a href="/" title="LOGO"><img class="f_logo" src="/storage/{{AppSettings::get('logo')}}"
                            alt="LOGO JMD" title="LOGO JMD"></a></p>
            </div>
        </div>

        <p id="footer_address">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">
                    {{AppSettings::get('address')}} </font>
            </font><span class="ml10">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">TEL.{{AppSettings::get('phone')}}</font>
                </font>
            </span>
        </p>



    </div>
    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="/"> JMD</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->

</html> --}}


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminltev3.css') }}" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    @yield('styles')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    @yield('content')
    @yield('scripts')
</body>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  
</html>
