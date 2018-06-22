@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Generar Comanda</h4>

            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="provincia_id">Provincia *</label>
                            {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione provincia...','id'=>'provincia_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="deporte_id">Disciplina *</label>
                            {!! Form::select('deporte_id',['placeholder'=>'Seleccione deporte...'],null,['class'=>'form-control','id'=>'deporte_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="residencia_id">Residencia *</label>
                            {!! Form::select('residencia_id',['placeholder'=>'Seleccione residencia...'],null,['class'=>'form-control','id'=>'residencia_id','required']) !!}
                        </div>
                        {{--<div class="form-group col-md-2">--}}
                            {{--<label for="tipo">Tipo *</label>--}}
                            {{--{!! Form::select('tipo',['H'=>'HOSPEDAJE','D'=>'DESAYUNO','A'=>'ALMUERZO','M'=>'MERIENDA'],null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'tipo','required']) !!}--}}
                        {{--</div>--}}
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-body">
                    <h4 >Lista de Eventos para Comandas</h4>
                    <div id="lista_eventos"></div>
                </div>
            </div>


            {{--{!! Form::close() !!}--}}
        </div>

    </div>
@endsection

@push('scripts')

<script>

    $(document).ready(function () {

        //al seleccionar provincia mostrar los deportes
        $("#provincia_id").change(function () {
            var id = this.value;
            var token = $("input[name=_token]").val();
            var route = "{{route('events.getDeportes')}}";
            var deportes = $("#deporte_id");
            var residencia = $("#residencia_id");
            var date = $("#date");
            var data = {
                provincia_id: id
            };
            $.ajax({
                url: route,
                type: "GET",
                headers: {'X-CSRF-TOKEN': token},
//               contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                data: data,
                success: function (response) {
                    date.val('');
                    deportes.find("option:gt(0)").remove();
                    residencia.find("option:gt(0)").remove();
                    for (i = 0; i < response.length; i++) {
                        deportes.append('<option value="' + response[i].id + '">' + response[i].name+ '</option>');
                    }
                },
                error: function (response) {
                    deportes.find("option:gt(0)").remove();
                    residencia.find("option:gt(0)").remove();
                    date.val('');
                }
            });
        });

        //al seleccionar deportes mostrar residencias
        $("#deporte_id").change(function () {
            var id = this.value; //id deportes
            var provincia_id=$("#provincia_id").val();
            var token = $("input[name=_token]").val();
            var route = "{{route('events.getResidencia')}}";
            var residencia = $("#residencia_id");
            var date = $("#date");
            var data = {
                deporte_id: id,
                provincia_id: provincia_id
            };
            $.ajax({
                url: route,
                type: "GET",
                headers: {'X-CSRF-TOKEN': token},
//               contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                data: data,
                success: function (response) {
                    date.val('');
                    residencia.find("option:gt(0)").remove();
                    for (i = 0; i < response.length; i++) {
                        residencia.append('<option value="' + response[i].id + '">' + response[i].name+ '</option>');
                    }
                },
                error: function (response) {
                    residencia.find("option:gt(0)").remove();
                    date.val('');
                }
            });
        });

        //al seleccionar residencia mostrar los eventos
        $("#residencia_id").change(function () {
            var id = this.value; //id residencia
            var provincia_id=$("#provincia_id").val();
            var deporte_id=$("#deporte_id").val();
            var lista_eventos = $("#lista_eventos");
            var token = $("input[name=_token]").val();
            var route = "{{route('events.getEventos')}}";
//            var date = $("#date");
            var data = {
                residencia_id: id,
                provincia_id: provincia_id,
                deporte_id: deporte_id
            };
            $.ajax({
                url: route,
                type: "GET",
                headers: {'X-CSRF-TOKEN': token},
//               contentType: 'application/x-www-form-urlencoded',
//                dataType: 'json',
                data: data,
                success: function (response) {
//                    date.val('');
                    lista_eventos.html(response);
//                    residencia.find("option:gt(0)").remove();
//                    for (i = 0; i < response.length; i++) {
//                        residencia.append('<option value="' + response[i].id + '">' + response[i].name+ '</option>');
//                    }
                },
                error: function (response) {
//                    residencia.find("option:gt(0)").remove();
//                    date.val('');
                }
            });
        });




        {{--$("#tipo").change(function () {--}}
            {{--var date = $("#date").val();--}}
            {{--var deporte_id = $("#deporte_id").val();--}}
            {{--var provincia_id = $("#provincia_id").val();--}}
            {{--var residencia_id = $("#residencia_id").val();--}}
            {{--var tipo = $("#tipo").val();--}}
            {{--var token = $("input[name=_token]").val();--}}
            {{--var route = "{{route('events.listPersonasComandas')}}";--}}
            {{--var lista_personas = $("#lista_personas");--}}
            {{--var data = {--}}
                {{--deporte_id: deporte_id,--}}
                {{--provincia_id: provincia_id,--}}
                {{--residencia_id: residencia_id,--}}
                {{--tipo:tipo,--}}
                {{--date:date--}}
            {{--};--}}
            {{--$.ajax({--}}
                {{--url: route,--}}
                {{--type: "GET",--}}
                {{--headers: {'X-CSRF-TOKEN': token},--}}
{{--//               contentType: 'application/x-www-form-urlencoded',--}}
{{--//                dataType: 'json',--}}
                {{--data: data,--}}
                {{--success: function (response) {--}}
                    {{--console.log(response);--}}
                    {{--lista_personas.html(response);--}}
                {{--},--}}
                {{--error: function (response) {--}}
                    {{--console.log(response);--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}


    });

</script>

@endpush