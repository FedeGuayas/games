@extends('layouts.app')

@section('content')


    <div class="col-sm-6">

        @include('alert.alert')

        <div class="col-xs-12 col-md-offset-6">

            <div class="panel panel-success">
                <div class="panel-heading">Editar Atleta</div>

                <div class="panel-body">

                    {!! Form::model($athlete,['route'=>['athletes.update',$athlete->id], 'method'=>'PUT', 'files'=>'true'])  !!}

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Nombres</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$athlete->name}}"
                                   placeholder="Nombres" autofocus style="text-transform:uppercase">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Apellidos</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                   value="{{$athlete->last_name}}" placeholder="Apellidos"
                                   style="text-transform:uppercase">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="document">CI</label>
                            <input type="text" class="form-control" id="document" name="document"
                                   value="{{$athlete->document}}" placeholder="Documento de Identidad"
                                   style="text-transform:uppercase">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provincia">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia"
                                   value="{{$athlete->provincia}}" placeholder="provincia"
                                   style="text-transform:uppercase">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="funcion">Función</label>
                            <input type="text" class="form-control" id="funcion" name="funcion"
                                   value="{{$athlete->funcion}}" placeholder="provincia"
                                   style="text-transform:uppercase">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sport">Deporte</label>
                            <input type="text" class="form-control" id="sport" name="sport" value="{{$athlete->sport}}"
                                   placeholder="Deporte" style="text-transform:uppercase">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="gen">Sexo</label>
                            {!! Form::select('gen',['M'=>'Masculino','F'=>'Femenino'],$athlete->gen,['class'=>'form-control','placeholder'=>'Sexo ...','id'=>'gen']) !!}
                            {{--<input type="select" class="form-control" id="funcion"  name="funcion" placeholder="provincia" style="text-transform:uppercase">--}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="birth_date">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{$athlete->birth_date}}"
                                   style="text-transform:uppercase">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="event">Evento</label>
                            {!! Form::select('event',['IX JUEGOS DEPORTIVOS NACIONALES PREJUVENILES GUAYAS 2017'=>'IX JUEGOS DEPORTIVOS NACIONALES PREJUVENILES GUAYAS 2017','I JUEGOS DEPORTIVOS NACIONALES SUB-23 GUAYAS 2017'=>'I JUEGOS DEPORTIVOS NACIONALES SUB-23 GUAYAS 2017'],$athlete->event,['class'=>'form-control','placeholder'=>'Evento ...','id'=>'event']) !!}
                            {{--<input type="select" class="form-control" id="funcion"  name="funcion" placeholder="provincia" style="text-transform:uppercase">--}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_ins">Fecha de Inscripción</label>
                            <input type="date" class="form-control" id="date_ins" name="date_ins" value="{{$athlete->date_ins}}"
                                   style="text-transform:uppercase">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="procedencia">Procedencia</label>
                            <input type="text" class="form-control" id="procedencia" name="procedencia" value="{{$athlete->procedencia}}"
                                   placeholder="Institución que representa" style="text-transform:uppercase">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provincia">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia" value="{{$athlete->provincia}}"
                                   placeholder="Provincia" style="text-transform:uppercase">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('notes','Observaciones:') !!}
                            {!! Form::textarea('notes',$athlete->notes,['class'=>'form-control','length'=>'255','style'=>'text-transform:uppercase','placeholder'=>'Observaciones...','rows'=>'3', 'cols'=>'50']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image">Foto</label>
                            <input type="file" id="image" name="image" value="">
                            @if (empty($athlete->image))
                                <img src="" alt="" style='height: auto; width: 100px;'
                                     class="img-thumbnail img-responsive">
                            @else
                                <img src="{{ asset('/uploads/athletes/img/'.$athlete->image)}}"
                                     style='width: 100px; height: 100px;' class="img-thumbnail img-responsive">
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="place">Lugar</label>
                            <input type="text" class="form-control" id="place" name="place" value="{{$athlete->place}}"
                                   placeholder="Lugar de procedencia" style="text-transform:uppercase">
                        </div>
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                            <a href="javascript:history.go(-1)">
                                <button type="button" class="btn btn-flat">Regresar</button>
                            </a>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection