@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Editar evento</h4>

            {!! Form::model($event,['route'=>['events.update',$event->id], 'method'=>'PUT', 'files'=>'true'])  !!}
            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="provincia_id">Provincia *</label>
                            {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'provincia_id','required','readonly']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="deporte_id">Deporte *</label>
                            {!! Form::select('deporte_id',$list_deportes,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'deporte_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="residencia_id">Residencia *</label>
                            {!! Form::select('residencia_id',$list_residencias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'residencia_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tipo">Tipo *</label>
                            {!! Form::select('tipo',['H'=>'HOSPEDAJE','D'=>'DESAYUNO','A'=>'ALMUERZO','M'=>'MERIENDA'],null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'tipo','required']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="date_start">Fecha de Inicio *</label>
                            {!! Form::date('date_start',null,['class'=>'form-control', 'id'=>'date_start','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="date_end">Fecha de Fin *</label>
                            {!! Form::date('date_end',null,['class'=>'form-control', 'id'=>'date_end','required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('notes','Observaciones:') !!}
                            {!! Form::textarea('notes',null,['class'=>'form-control','length'=>'255','style'=>'text-transform:uppercase','placeholder'=>'Observaciones...','rows'=>'1', 'cols'=>'50']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3 pull-right">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="panel-heading bg-success">Personas incluidas en el evento</div>

                    {{--Personas que estan en el evento--}}
                    @if (count($lista)>0)
                        <table class="table" id="table_list" >
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Género</th>
                                <th>Funcion</th>
                                <th>Quitar</th>
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
                                <th>Quitar</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($lista as $atleta)
                                <tr>
                                    <td>{{$atleta->id}}</td>
                                    <td>{{$atleta->name}}</td>
                                    <td>{{$atleta->last_name}}</td>
                                    <td>{{$atleta->document}}</td>
                                    <td>{{$atleta->gen}}</td>
                                    <td>{{$atleta->funcion}}</td>
                                    <td>
                                        {!! Form::checkbox('seleccionar_quitar[]',$atleta->id,false,['id'=>$atleta->id]) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <h4 class="panel-heading">No hay personas incluidas en este evento</h4>
                    @endif

                    <div class="panel-heading bg-danger">Lista de personas que no están incluidas en el evento</div>

                    {{--Personas que no estan en el evento--}}
                    @if (count($listaAll)>0)
                        <table class="table" id="table_list2" >
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Género</th>
                                <th>Funcion</th>
                                <th>Agregar</th>
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
                                <th>Agregar</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($listaAll as $la)
                                <tr>
                                    <td>{{$la->id}}</td>
                                    <td>{{$la->name}}</td>
                                    <td>{{$la->last_name}}</td>
                                    <td>{{$la->document}}</td>
                                    <td>{{$la->gen}}</td>
                                    <td>{{$la->funcion}}</td>
                                    <td>
                                        {!! Form::checkbox('seleccionar_agregar[]',$la->id,false,['id'=>$la->id]) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <h4 class="panel-heading">No hay personas sin incluir para este evento</h4>
                    @endif


                </div>
            </div>


            {!! Form::close() !!}
        </div>

    </div>
@endsection

@push('scripts')

<script>

    $(document).ready(function () {

        $("#deporte_id").prop('disabled', true);
        $("#provincia_id").prop('disabled', true);

    });

</script>

@endpush