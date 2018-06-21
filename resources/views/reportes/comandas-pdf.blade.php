<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="css/comandaPDF.css">
    <link href="css/bootstrap.css" rel="stylesheet">
</head>


<body>

<header>
    <h1 style="margin-top: -20px;">SECRETARIA NACIONAL DEL DEPORTE</h1>
    <h3>VIII JUEGOS DEPORTIVOS NACIONALES JUVENILES 2018</h3>
    <h4>desde el 26 de Junio al 19 de Julio de 2018</h4>
    <h1 class="tipo">COMANDA DE {{$tipo}}</h1>
    {{--<h4 style="margin-top: 0">PERÍODO DE ALOJAMIENTO: DESDE EL {{$evento->date_start}} AL {{$evento->date_end}}</h4>--}}
    <h4 style="margin-top: 0">PERÍODO DE ALOJAMIENTO: DESDE EL {{($evento->date_start)}} AL {{$evento->date_end}}</h4>
    <h4>DÍA DE ALOJAMIENTO: {{$date}}</h4>
    <h4>NÓMINA DE LA DELEGACIÓN PARTICIPANTE DE LA PROVINCIA DE: &nbsp;&nbsp;&nbsp;&nbsp; <span style="border: 1px solid; margin-right: 0;">{{$provincia->province}}</span> </h4>
</header>

{{--<footer>--}}
    {{--<span class="pagenum"></span>--}}
{{--</footer>--}}
<div class="content">
    <table cellspacing="0" width="40%">
        <tr>
            <th>Residencia u Hotel:</th>
            <th style="border: 1px solid;">{{$residencia->name}}</th>
        </tr>
        <tr>
            <th>Disciplina:</th>
            <th style="border: 1px solid;">{{$deporte->name}}</th>
        </tr>
    </table>
    <br>
    <table width="100%" border="1" cellspacing="0" style="font-size: 10px;">
        <thead>
        <tr style="text-align: center;">
            <th style="width: 30px;">No.</th>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th style="width: 80px;">No. DE CÉDULA</th>
            <th style="width: 50px;">GÉNERO</th>
            <th style="width: 90px;">FUNCIÓN</th>
            <th>FIRMA</th>
        </tr>
        </thead>
        <tbody>
            @foreach($lista as $index=>$l)
                <tr>
                    <th>{{$index+1}}</th>
                    <td>{{$l->last_name}}</td>
                    <td>{{$l->name}}</td>
                    <td style="text-align: center">{{$l->document}}</td>
                    <td style="text-align: center">{{$l->gen}}</td>
                    <td>{{$l->funcion}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{--numero de pagina--}}
<script type='text/php'>
      if ( isset($pdf) ) {
        $x = 740;
        $y = 532;
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("Arial", "bold");
        $size = 12;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

    </script>


</body>
</html>


