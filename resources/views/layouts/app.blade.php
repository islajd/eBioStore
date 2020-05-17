<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Bio Store') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        a:hover{
            text-decoration: none;
        }
        footer {
            position: relative;
            height: 100px;
            width: 100%;
        }
        #app{
            min-height: 100vh;
        }
        .icon{
            color:#38c172 !important;
        }

        /*=================*/
        .search_input{
            border: 0;
            outline: 0;
            background: none;
            width: 0;
            caret-color:transparent;
            line-height: 40px;
            transition: width 0.4s linear;
            color: #38c172 !important;
        }

        .searchbar:hover{
            border-bottom: 1px solid #ccc!important;
        }

        .searchbar:hover > .search_input{
            padding-left: 10px;
            width: 250px;
            caret-color:#38c172 !important;
            transition: width 0.4s linear;
        }

        .searchbar:hover > .search_icon{
            background: white;
            color: #e74c3c;
        }

        .search_icon{
            height: 40px;
            width: 40px;
            float: right;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            text-decoration:none;
        }
    </style>
</head>
<body style="background-color: white">
    <div id="app">
        <div class="bg-success">
            <div class="container">
                <div class="row px-md-0">
                    <div class="col-lg-12 d-block">
                        <div class="row d-flex" style="color: white">
                            <div class="col-md pr-4 d-flex topper align-items-center">
                                <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="fa fa-phone"></span></div>
                                <span class="text">+35569 3435 333</span>
                            </div>
                            <div class="col-md pr-4 d-flex topper align-items-center">
                                <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="fa fa-paper-plane"></span></div>
                                <span class="text">ebiostoresupp@gmail.com</span>
                            </div>
                            <div class="pr-4 d-flex topper align-items-center text-lg-right">
                                <span class="text">3-5 Business days delivery &amp; Free Returns</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{route("Home")}}">
                    {{ config('app.name', 'E-Bio Store') }}
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
                        @if(Route::current()->getName() == 'Home'
                         || Route::current()->getName() == 'Category'
                         || Route::current()->getName() == 'Search' )
                            <li class="nav-item dropdown">
                                <form action="{{route("Search")}}" method="POST" id="search">
                                    {{ csrf_field() }}
                                    <div class="d-flex justify-content-center">
                                        <div class="searchbar">
                                                <input class="search_input" type="text" name="product" placeholder="Search..." @isset($searched) value="{{$searched}}"@endisset>
                                                <a class="search_icon" onclick="document.getElementById('search').submit();"><i class="fa fa-search icon"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route("Home")}}"><i class="fa fa-home icon"></i> Home </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route("Support")}}"><i class="fa fa-support icon"></i> Support</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" style="color: #38c172 !important" data-toggle="modal" data-target="#modalLoginForm">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color: #38c172 !important" data-toggle="modal" data-target="#modalRegisterForm">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{route("Cart")}}"><i class="fa fa-shopping-cart icon"></i> Cart</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fa fa-user-circle"></i> {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @guest
            @include('auth.login')
            @include('auth.register')
        @endguest
{{--            {{$errors}}--}}
        @yield('home')
        @yield('product')
        @yield('cart')
        @yield('profile')
        @yield('order_details')
        @yield('support')
        @yield('checkout')
        @yield('content')  {{-- For Auth Routes --}}
    </div>
    @include('layouts.footer')
</body>
</html>
