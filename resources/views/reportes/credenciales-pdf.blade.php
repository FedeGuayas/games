<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="css/pdf.css">
    <link href="css/bootstrap.css" rel="stylesheet">
</head>


<body>


{{--@foreach($credenciales->chunk(4) as $creChunck)--}}
<?php $pos = 1;?>
@foreach($credenciales as $c)

    <?php

    if ($pos === 1){
    ?>
    <div class="caja-ti">
        <div class="lt-funcion">{{$c->funcion}}</div>
        <div class="l-foto">
            @if (empty($c->image))
                {{$c->image}}
            @else
                <img src="{{ asset('/uploads/athletes/img/'.$c->image)}}"
                     class="foto_cred">
            @endif
        </div>
        <div class="nombres">{{$c->name}}</div>
        <div class="apellidos">{{$c->last_name}}</div>
        <div class="cedula">{{$c->document}}</div>
        <div class="provincia">
            @if(!is_null($c->provincia))
                {{$c->provincia->province}}
            @else
                -
            @endif
        </div>
        <div class="deporte">
            @if(!is_null($c->deporte))
                {{$c->deporte->name}}
            @else
                -
            @endif

        </div>
    </div>

    <?php

    }

    if ($pos === 2) {

    ?>
    <div class="caja-td">
        <div class="lt-funcion">{{$c->funcion}}</div>
        <div class="l-foto">
            @if (empty($c->image))
                {{$c->image}}
            @else
                <img src="{{ asset('/uploads/athletes/img/'.$c->image)}}"
                     class="foto_cred">
            @endif
        </div>
        <div class="nombres">{{$c->name}}</div>
        <div class="apellidos">{{$c->last_name}}</div>
        <div class="cedula">{{$c->document}}</div>
        <div class="provincia">
            @if(!is_null($c->provincia))
                {{$c->provincia->province}}
            @else
                -
            @endif
        </div>
        <div class="deporte">
            @if(!is_null($c->deporte))
                {{$c->deporte->name}}
            @else
                -
            @endif
        </div>
    </div>

    <?php
    }
    if ($pos === 3) {

    ?>
    <div class="caja-bi">
        <div class="lt-funcion">{{$c->funcion}}</div>
        <div class="l-foto">
            @if (empty($c->image))
                {{$c->image}}
            @else
                <img src="{{ asset('/uploads/athletes/img/'.$c->image)}}"
                     class="foto_cred">
            @endif
        </div>
        <div class="nombres">{{$c->name}}</div>
        <div class="apellidos">{{$c->last_name}}</div>
        <div class="cedula">{{$c->document}}</div>
        <div class="provincia">
            @if(!is_null($c->provincia))
                {{$c->provincia->province}}
            @else
                -
            @endif
        </div>
        <div class="deporte">
            @if(!is_null($c->deporte))
                {{$c->deporte->name}}
            @else
                -
            @endif
        </div>
    </div>
    <?php

    }
    if ($pos === 4) {
    ?>
    <div class="caja-bd">
        <div class="lt-funcion">{{$c->funcion}}</div>
        <div class="l-foto">
            @if (empty($c->image))
                {{$c->image}}
            @else
                <img src="{{ asset('/uploads/athletes/img/'.$c->image)}}"
                     class="foto_cred">
            @endif
        </div>
        <div class="nombres">{{$c->name}}</div>
        <div class="apellidos">{{$c->last_name}}</div>
        <div class="cedula">{{$c->document}}</div>
        <div class="provincia">
            @if(!is_null($c->provincia))
                {{$c->provincia->province}}
            @else
                -
            @endif
        </div>
        <div class="deporte">
            @if(!is_null($c->deporte))
                {{$c->deporte->name}}
            @else
                -
            @endif
        </div>
    </div>
    {{--<div style="page-break-after: always"></div>--}}
    <?php
    $pos = 0;

    }
    $pos++;


    ?>


    {{--@foreach($credenciales as $c)--}}
@endforeach


{{--<div>--}}
{{--<div class="page-break"></div>--}}
{{--@endforeach--}}
{{----}}

{{--<div>--}}

{{--@foreach($credenciales->chunk(4) as $inscChunck)--}}
{{--<div style="width:100%; font-size:0;">--}}

{{--<div class="">--}}
{{--<p></p>--}}
{{--</div>--}}
{{--@endforeach--}}
{{--</div>--}}

{{--<div class="page-break"></div>--}}
{{--@endforeach--}}
{{--</div>--}}


</body>
</html>
