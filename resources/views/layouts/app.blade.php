<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Games</title>

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Datatables style bootstrap -->
    <link href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{--{{ config('app.name', 'Laravel') }}--}}
                    FDG
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    @if (Auth::check())
                        <li class="active"><a href="{{route('home')}}">Inicio <span
                                        class="sr-only">(current)</span></a></li>


                        @if(Auth::user()->hasRole('admin'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    Participantes <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('athletes.index')}}">Inscritos
                                            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                    </li>
                                    <li><a href="{{route('athletes.create')}}">Crear Participante
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                                    <li><a href="{{route('print_athletes')}}">Credenciales
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
                                    <li><a href="{{route('getImport')}}">Importar base
                                            <span class="glyphicon glyphicon-import" aria-hidden="true"></span></a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    Acreditaciones <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('indexAcreditados')}}">Acreditados
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a></li>
                                    <li><a href="{{route('indexAcreditar')}}">Acreditar
                                            <span class="glyphicon glyphicon-check" aria-hidden="true"></span></a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    Residencias <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('residencias.index')}}">Todas <span
                                                    class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                    </li>
                                    <li><a href="{{route('residencias.create')}}">Crear <span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Eventos <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('events.index')}}">Todos <span class="glyphicon glyphicon-list-alt"
                                                                                    aria-hidden="true"></span></a></li>
                                <li><a href="{{route('events.create')}}">Crear Nuevo <span
                                                class="glyphicon glyphicon-plus"
                                                aria-hidden="true"></span></a>
                                </li>
                                <li><a href="{{route('events.createComanda')}}">Comandas
                                        <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>/
                                        <span class="glyphicon glyphicon-bed" aria-hidden="true"></span></a></li>
                            </ul>
                        </li>
                    @endif

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Entrar</a></li>
                        {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                    @else

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Salir <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')


</div>

<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>

@stack('scripts')

</body>
</html>
