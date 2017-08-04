@extends('layouts.app')

@section('content')


    <div class="col-sm-6">
        @include('alert.alert')


        <div class="col-xs-12 col-md-offset-6">

            <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="panel panel-success">
                    <div class="panel-heading">Cargar archivo excel</div>

                    <div class="panel-body">


                        <div class="form-group">
                            <label for="file">Archivo</label>
                            <input type="file" id="file" name="file">
                            <p class="help-block">Archivo excell con todos los atletas. Esto se debe realizar una sola vez</p>
                        </div>

                        <button type="submit" class="btn btn-danger">Cargar</button>


                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection