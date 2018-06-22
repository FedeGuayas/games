@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @include('alert.alert')
        <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">

            <h4 class="page-header">Editar participante</h4>
            <div class="panel panel-success">

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
                            <label for="provincia_id">Provincia *</label>
                            {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'provinca_id','required']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="funcion">Función *</label>
                            <input type="text" class="form-control" id="funcion" name="funcion"
                                   value="{{$athlete->funcion}}"
                                   placeholder="Función" style="text-transform:uppercase" aria-describedby="helpFuncion"
                                   required>
                            <span id="helpFuncionk" class="help-block">Ejemplo: Deportista, Entrenador, etc.</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="deporte_id">Deporte</label>
                            {!! Form::select('deporte_id',$list_deportes,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'deporte_id','required']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="gen">Sexo *</label>
                            {!! Form::select('gen',['M'=>'Masculino','F'=>'Femenino'],$athlete->sexo,['class'=>'form-control','id'=>'gen','required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="birth_date">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date"
                                   value="{{$athlete->birth_date}}"
                                   style="text-transform:uppercase">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('notes','Observaciones:') !!}
                            {!! Form::textarea('notes',null,['class'=>'form-control','length'=>'255','style'=>'text-transform:uppercase','placeholder'=>'Observaciones...','rows'=>'3', 'cols'=>'50']) !!}
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
                        <div class="form-group col-md-3">
                            {!! Form::label('status', 'Estado') !!}
                            {!! Form::select('status',['A'=>'ACTIVO','S'=>'SUPLENTE'],$athlete->status,['class'=>'form-control','id'=>'status','required']) !!}
                        </div>
                        <div class="form-group col-md-3 ">
                            <label>
                                {!! Form::checkbox('acreditar',null,$athlete->acreditado,['id'=>'acreditar']) !!}
                                {!! Form::label('acreditar', 'Acreditar') !!}
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

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection