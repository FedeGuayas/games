@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Lista de personas a imprimir en la Comanda</h4>

            {{--<div class="row">--}}
                {{--<div class="form-group col-md-2">--}}
                    {{--<label for="date">Fecha de impresión*</label>--}}
                    {{--{!! Form::date('date',null,['class'=>'form-control', 'id'=>'date']) !!}--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="panel-heading bg-danger">Comanda sustitutiva</div>

                    {{--Personas que no estan en el evento--}}
                    @if (count($lista)>0)
                        {!! Form::open (['route' => 'comandasPDF','method' => 'get', 'class'=>'form_noEnter'])!!}
                        {!! Form::hidden('evento_id',$evento->id,['id'=>'evento_id']) !!}
                        {!! Form::hidden('sustitutiva',$sustitutiva,['id'=>'sustitutiva']) !!}
                        <button type="submit" class="btn btn-danger pull-right">Exportar Comanda Sustitutiva</button>
                        <table class="table" id="table_list2" width="auto" >
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Género</th>
                                <th>Funcion</th>
                                <th>Observaciones</th>
                                <th>Selección</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>id</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Género</th>
                                <th>Funcion</th>
                                <th>Observaciones</th>
                                <th>Selección</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($lista as $la)
                                <tr>
                                    <td>{{$la->id}}</td>
                                    <td>{{$la->name}}</td>
                                    <td>{{$la->last_name}}</td>
                                    <td>{{$la->document}}</td>
                                    <td>{{$la->gen}}</td>
                                    <td>{{$la->funcion}}</td>
                                    <td style="width: 50%">
                                        {!! Form::text('observaciones[]',null,['class'=>'form-control', 'style'=>'width: 100%', 'disabled']) !!}
                                    </td>
                                    <td>
                                        {!! Form::checkbox('seleccionar[]',$la->id,false,['id'=>$la->id]) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <h4 class="panel-heading">No se encontraron registros para la selección</h4>
                    @endif
                    {!! Form::close() !!}

                </div>
            </div>


        </div>

    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('td input[type="checkbox"]').change(function() {

            $(this).closest('tr').find('input[type="text"]').prop('disabled', !this.checked);

            $(this).closest('tr').find('input[type="text"]').val('');

        });
    });

</script>
@endpush