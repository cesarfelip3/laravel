<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script>
        window.Slc = {!! json_encode(array_merge(Slc::scriptVariables(), [])) !!};
    </script>
</head>
<body class="top-navigation">
<div id="app">
    <notification
            :type="'{{ session('notification') }}'"
            :message="'{{ addslashes(session('message')) }}'"
    ></notification>

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar"
                                data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                            <i class="fa fa-reorder"></i>
                        </button>
                        <a href="#" class="navbar-brand">{{env('APP_NAME')}}</a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav">
                            @include('layouts._menu')
                        </ul>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                {{ auth()->user()->name }}
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="wrapper wrapper-content">
                @yield('content')
            </div>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> Slc DevShop &copy; 2014-2017
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
