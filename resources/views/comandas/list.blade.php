@if (count($lista)>0)
    <button type="submit" class="btn btn-primary pull-right">Exportar Comanda</button>
    {!! Form::hidden('evento_id',$evento->id) !!}
    <table class="table" id="table_list" >
        <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Género</th>
            <th>Funcion</th>
            <th>Selección</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Género</th>
            <th>Funcion</th>
            <th>Selección</th>
        </tr>
        </tfoot>
        <tbody>

        @foreach($lista as $atleta)
            <tr>
                <td>{{$atleta->name}}</td>
                <td>{{$atleta->last_name}}</td>
                <td>{{$atleta->document}}</td>
                <td>{{$atleta->gen}}</td>
                <td>{{$atleta->funcion}}</td>
                <td>
                    {!! Form::checkbox('seleccionar[]',$atleta->id,true,['id'=>$atleta->id]) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    <h4 class="panel-heading">No se encontraron registros para la selección</h4>
@endif
