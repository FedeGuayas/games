@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Lista de personas a imprimir en la Comanda</h4>
            {!! Form::open (['route' => 'comandasPDF','method' => 'get', 'class'=>'form_noEnter'])!!}
            {!! Form::hidden('evento_id',$evento->id,['id'=>'evento_id']) !!}

            {{--<div class="row">--}}
                {{--<div class="form-group col-md-2">--}}
                    {{--<label for="date">Fecha de impresión*</label>--}}
                    {{--{!! Form::date('date',null,['class'=>'form-control', 'id'=>'date']) !!}--}}
                {{--</div>--}}
            {{--</div>--}}


            <div class="panel panel-success">

                <div class="panel-body">

                    @if (count($lista)>0)
                        <button type="submit" class="btn btn-primary pull-right">Exportar Comanda</button>
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



                </div>
            </div>

            {!! Form::close() !!}
        </div>

    </div>
@endsection