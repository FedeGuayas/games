@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">
            <h4 class="page-header">Crear Residencia</h4>
            {!! Form::open (['route' => 'residencias.store','method' => 'post', 'class'=>'form_noEnter'])!!}

                <div class="panel panel-success">

                    <div class="panel-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Residencia *</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la Residencia"
                                       autofocus style="text-transform:uppercase" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="capacidad">Capacidad maxima *</label>
                                <input type="number" id="capacidad" name="capacidad" min="0" step="1" class="form-control"  placeholder="Capacidad de la Residencia" required>
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

            {!! Form::close() !!}
        </div>

    </div>
@endsection