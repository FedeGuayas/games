<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{asset('css/welcome.css')}}" rel="stylesheet" type="text/css">

    </head>
    <body>




    {{-------------------------------------------}}
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">
                    <div class="masthead clearfix">
                        <div class="inner">
                            {{--<h3 class="masthead-brand">Cover</h3>--}}

                            <ul class="nav masthead-nav">
                                <li class="active">
                                </li>


                                    @if (Route::has('login'))

                                            @auth
                                <li>
                                            <a href="{{ url('/home') }}">Inicio</a>
                                </li>
                                            @else
                                        <li>
                                                <a href="{{ route('login') }}">Entrar</a>
                                        </li>

                                             {{--<li>   <a href="{{ route('register') }}">Registro</a></li>--}}
                                                @endauth

                                    @endif

                                <li>
                                    {{--<a href="#">Contacot</a>--}}
                                </li>
                            </ul>
                        </div>
                    </div>



                    <div class="inner cover">
                        <h1 class="cover-heading">  JUEGOS NACIONALES GUAYAS 2017 </h1>

                        {{--<p class="lead"><a class="btn btn-lg btn-info" href="#">leer mas</a></p>--}}
                    </div>



                    <div class="mastfoot">
                        <div class="inner">
                            <!-- Validation -->
                            <p>© 2017 Fedeguayas ~ <a href="https://www.fedeguayas.com.ec/">FDG</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
