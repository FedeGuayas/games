@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">
            <h4 class="page-header">Crear participante</h4>
            <form action="{{route('athletes.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="panel panel-success">

                    <div class="panel-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Nombres *</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombres"
                                       autofocus style="text-transform:uppercase" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">Apellidos *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       placeholder="Apellidos" style="text-transform:uppercase" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="document">CI *</label>
                                <input type="text" class="form-control" id="document" name="document"
                                       placeholder="Documento de Identidad" style="text-transform:uppercase" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="provincia">Provincia *</label>
                                {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'provincia_id','value'=>"{{ old('provincia_id') }}",'required']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="funcion">Función *</label>
                                <input type="text" class="form-control" id="funcion" name="funcion"
                                       placeholder="Función" style="text-transform:uppercase" aria-describedby="helpFuncion" required>
                                <span id="helpFuncionk" class="help-block">Ejemplo: Deportista, Entrenador, etc.</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="deporte_id">Deporte *</label>
                                {!! Form::select('deporte_id',$list_deportes,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'deporte_id','value'=>"{{ old('deporte_id') }}",'required']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="gen">Sexo *</label>
                                {!! Form::select('gen',['M'=>'Masculino','F'=>'Femenino'],null,['class'=>'form-control','placeholder'=>'Sexo ...','id'=>'gen','required']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birth_date">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date"
                                       style="text-transform:uppercase">
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="form-group col-md-6">--}}
                                {{--<label for="event">Evento</label>--}}
                                {{--{!! Form::select('event',['VIII JUEGOS DEPORTIVOS NACIONALES JUVENILES 2018'=>'VIII JUEGOS DEPORTIVOS NACIONALES JUVENILES 2018'],null,['class'=>'form-control','placeholder'=>'Evento ...','id'=>'event']) !!}--}}
                                {{--<input type="select" class="form-control" id="funcion"  name="funcion" placeholder="provincia" style="text-transform:uppercase">--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-6">--}}
                                {{--<label for="date_ins">Fecha de Inscripción</label>--}}
                                {{--<input type="date" class="form-control" id="date_ins" name="date_ins"--}}
                                       {{--style="text-transform:uppercase">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="form-group col-md-6">--}}
                                {{--<label for="procedencia">Procedencia</label>--}}
                                {{--<input type="text" class="form-control" id="procedencia" name="procedencia"--}}
                                       {{--placeholder="Institución que representa" style="text-transform:uppercase">--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-6">--}}
                                {{--<label for="provincia">Provincia</label>--}}
                                {{--<input type="text" class="form-control" id="provincia" name="provincia"--}}
                                       {{--placeholder="Provincia" style="text-transform:uppercase">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('notes','Observaciones:') !!}
                                {!! Form::textarea('notes',null,['class'=>'form-control','length'=>'255','style'=>'text-transform:uppercase','placeholder'=>'Observaciones...','rows'=>'3', 'cols'=>'50']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image">Foto</label>
                                <input type="file" id="image" name="image">
                                <p class="help-block">Foto del Participante.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label>
                                    <input type="checkbox" name="acreditar" id="acreditar" > Acreditar
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button type="reset" class="btn btn-danger">Cancelar</button>
                                <a href="javascript:history.go(-1)">
                                    <button type="button" class="btn btn-flat">Regresar</button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection