@if (count($evento)>0)
    {!! Form::hidden('status',$status) !!}
    @php ($sust = 'true')
    @php ($no_sust = 'false')
    <table class="table" id="event_list">
        <thead>
        <tr>
            <th>Provincia</th>
            <th>Diciplina</th>
            <th>Residencia</th>
            <th>Tipo</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Generar</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Provincia</th>
            <th>Diciplina</th>
            <th>Residencia</th>
            <th>Tipo</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Generar</th>
        </tr>
        </tfoot>
        <tbody>

        @foreach($evento as $e)
            <tr>
                <td>{{$e->province}}</td>
                <td>{{$e->deporte}}</td>
                <td>{{$e->residencia}}</td>
                <td>
                    @if ($e->tipo=='H')
                        HOSPEDAJE
                    @elseif($e->tipo=='A')
                        ALMUERZO
                    @elseif($e->tipo=='D')
                        DESAYUNO
                    @elseif($e->tipo=='M')
                        MERIENDA
                    @endif
                </td>
                <td>{{$e->date_start}}</td>
                <td>{{$e->date_end}}</td>
                <td>
                    <a href="{{route('events.listPersonasComandas',[$e->id,$status,$no_sust])}}" style="text-decoration-line: none">
                        <button class="btn-xs btn-primary"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></button>
                    </a>
                    <a href="{{route('events.listPersonasComandas',[$e->id,$status,$sust])}}" style="text-decoration-line: none">
                        <button class="btn-xs btn-danger"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></button>
                    </a>
{{--                    {!! Form::checkbox('seleccionar[]',$e->id,true,['id'=>$e->id]) !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    <h4 class="panel-heading">No se encontraron registros para la selección</h4>
@endif
