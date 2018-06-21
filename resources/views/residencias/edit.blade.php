@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">
            <h4 class="page-header">Editar Residencia</h4>
            {!! Form::model($residencia,['route'=>['residencias.update',$residencia->id], 'method'=>'PUT'])  !!}

            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Residencia *</label>
                            {!! Form::text('name',null,['class'=>'form-control','id'=>'name','required','style'=>'text-transform:uppercase'])!!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="capacidad">Capacidad maxima *</label>
                            {!! Form::number('capacidad',null,['class'=>'form-control','id'=>'capacidad','required','min'=>'0', 'step'=>'1'])!!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                            <a href="javascript:history.go(-1)">
                                <button type="button" class="btn btn-flat">Regresar</button>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {!! Form::close() !!}
        </div>

    </div>
@endsection
