@if (count($list_atletas)>0)
    <table class="table" id="table_list" >
        <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Funcion</th>
            <th>Selección</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Documento</th>
            <th>Funcion</th>
            <th>Selección</th>
        </tr>
        </tfoot>
        <tbody>

        @foreach($list_atletas as $atleta)
            <tr>
                <td>{{$atleta->name}}</td>
                <td>{{$atleta->last_name}}</td>
                <td>{{$atleta->document}}</td>
                <td>{{$atleta->funcion}}</td>
                <td>
                    {!! Form::checkbox('seleccionar[]',$atleta->id,true,['id'=>$atleta->id]) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table><!--end table-responsive-->

@else
    <h4 class="panel-heading">No se encontraron registros para la selección</h4>
@endif
