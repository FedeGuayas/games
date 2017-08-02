@extends('layouts.app')

@section('content')

    <div class="col-sm-6">

        <div class="col-xs-12 col-md-offset-6">
            <form action="{{route('athletes.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" id="name" placeholder="Nombres" autofocus>
                </div>
                <div class="form-group">
                    <label for="last_name">Apellidos</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Apellidos">
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="document">CI</label>
                        <input type="text" class="form-control" id="document" placeholder="Documento de Identidad">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sport">Deporte</label>
                        <input type="text" class="form-control" id="sport" placeholder="Deporte">
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label for="image">Foto</label>--}}
                    {{--<input type="file" id="image">--}}
                    {{--<p class="help-block">Foto del Atleta.</p>--}}
                {{--</div>--}}

                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>

    </div>
@endsection