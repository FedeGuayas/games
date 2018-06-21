@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Generar Comanda</h4>
            {!! Form::open (['route' => 'comandasPDF','method' => 'get', 'class'=>'form_noEnter'])!!}

            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="provincia_id">Provincia *</label>
                            {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'provincia_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="deporte_id">Disciplina *</label>
                            {!! Form::select('deporte_id',$list_deportes,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'deporte_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="residencia_id">Residencia *</label>
                            {!! Form::select('residencia_id',$list_residencias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'residencia_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="date">Fecha *</label>
                            {!! Form::date('date',null,['class'=>'form-control', 'id'=>'date','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tipo">Tipo *</label>
                            {!! Form::select('tipo',['H'=>'HOSPEDAJE','D'=>'DESAYUNO','A'=>'ALMUERZO','M'=>'MERIENDA'],null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'tipo','required']) !!}
                        </div>
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
                    <h4 >Lista para Comanda</h4>

                    <div id="lista_personas"></div>

                </div>
            </div>


            {!! Form::close() !!}
        </div>

    </div>
@endsection

@push('scripts')

<script>

    $(document).ready(function () {

        $("#tipo").change(function () {
            var date = $("#date").val();
            var deporte_id = $("#deporte_id").val();
            var provincia_id = $("#provincia_id").val();
            var residencia_id = $("#residencia_id").val();
            var tipo = $("#tipo").val();
            var token = $("input[name=_token]").val();
            var route = "{{route('events.listPersonasComandas')}}";
            var lista_personas = $("#lista_personas");
            var data = {
                deporte_id: deporte_id,
                provincia_id: provincia_id,
                residencia_id: residencia_id,
                tipo:tipo,
                date:date
            };
            $.ajax({
                url: route,
                type: "GET",
                headers: {'X-CSRF-TOKEN': token},
//               contentType: 'application/x-www-form-urlencoded',
//                dataType: 'json',
                data: data,
                success: function (response) {
                    console.log(response)
                    lista_personas.html(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });


    });

</script>

@endpush