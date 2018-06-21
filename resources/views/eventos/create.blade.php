@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        @include('alert.alert')

        <div class="col-xs-12">
            <h4 class="page-header">Crear evento</h4>
            {!! Form::open (['route' => 'events.store','method' => 'post', 'class'=>'form_noEnter'])!!}

            <div class="panel panel-success">

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="provincia_id">Provincia *</label>
                            {!! Form::select('provincia_id',$list_provincias,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'provincia_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            <label for="deporte_id">Deporte *</label>
                            {!! Form::select('deporte_id',$list_deportes,null,['class'=>'form-control','placeholder'=>'Seleccione ...','id'=>'deporte_id','required']) !!}
                        </div>
                        <div class="form-group col-md-2 has-success">
                            <label for="cantidad_personas">Cantidad de personas</label>
                            {!! Form::number('cantidad_personas',null,['class'=>'form-control','placeholder'=>'0','id'=>'cantidad_personas','readonly']) !!}
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
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="panel-heading bg-success">Lista</div>



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


        $("#provincia_id").change(function () {
            var deporte = $("#deporte_id");
            $("#cantidad_personas").val('');
//            deporte.find("option:gt(0)").remove();

        });


        $("#deporte_id").change(function () {
            var deporte_id = this.value;
            var provincia_id = $("#provincia_id").val();
            var token = $("input[name=_token]").val();
            var route = "{{route('events.countAtletas')}}";
            var cantidad_personas = $("#cantidad_personas");
            var lista_personas = $("#lista_personas");
            $("#cantidad_personas").val('');
            var data = {
                deporte_id: deporte_id,
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
                    cantidad_personas.val(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $("#tipo").change(function () {
            var tipo = this.value;
            var provincia_id = $("#provincia_id").val();
            var deporte_id = $("#deporte_id").val();
            var token = $("input[name=_token]").val();
            var route = "{{route('events.loadAtletas')}}";
            var lista_personas = $("#lista_personas");
            var data = {
                tipo: tipo,
                deporte_id: deporte_id,
                provincia_id: provincia_id
            };
            $.ajax({
                url: route,
                type: "get",
                headers: {'X-CSRF-TOKEN': token},
                //               contentType: 'application/x-www-form-urlencoded',
                //                    dataType: 'json',
                data: data,
                success: function (response) {
                    lista_personas.html(response);
                },
                error: function (response) {
                }
            });
        });

    });

</script>

@endpush