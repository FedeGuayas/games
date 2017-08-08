@extends('layouts.app')

@section('content')



    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @include('alert.alert')

        </div>
    </div>

    <div class="container">
        <h4>Atletas</h4>
        {!! Form::open (['route' => 'export-credenciales','method' => 'GET', 'class'=>'form_noEnter', 'target'=>'_blank'])!!}
        <div class="row">
            <div class="col-lg-6" id="botones_imprimir"></div>
            <div class="col-md-2 pull-right">
                {!! Form::checkbox('imp_all',null,false,['id'=>'imp_all']) !!}
                {!! Form::label('imp_all','Imp. Página',['class'=>'label-control text-danger']) !!}
                {!! Form::button(' <span class="glyphicon glyphicon-print" aria-hidden="true"></span>',['class'=>'btn-xs btn-primary', 'type'=>'submit','id'=>'imprimir']) !!}
            </div>

        </div>
        <table class="table table-striped table-bordered table-condensed table-hover table-responsive"
               id="atletas_table" cellspacing="0" style="display: none;overflow: auto; font-size: 11px;" width="100%">
            <thead>
            <tr>
                <th width="10">No.</th>
                <th>Función</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th style="width: 60px">Cédula</th>
                <th>Provincia</th>
                <th>Deporte</th>
                <th>Evento</th>
                <th width="80">Imp.</th>

            </tr>
            </thead>
            <tfoot>
            <tr>
                <th class="non_searchable">No.</th>
                <th>Función</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Provincia</th>
                <th>Deporte</th>
                <th>Evento</th>
                <th class="non_searchable">Imp.</th>
            </tr>
            </tfoot>
        </table>
        {!!form::close()!!}
    </div>


    <div class="animationload" id="loading">
        <div class="osahanloading"></div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            $(".form_noEnter").keypress(function (e) {
                if (e.width == 13) {
                    return false;
                }
            });

            var table = $('#atletas_table').on('processing.dt', function (e, settings, processing) {
                $('#loading').css('display', processing ? 'block' : 'none');
            }).DataTable({

//                    var table = $('#atletas_table').DataTable({
                lengthMenu: [[4], [4]],
                processing: false,
                stateSave: true,
                serverSide: true,
                ajax: '{{route('getCredencials')}}',
                columns: [
                    {data: 'id', name: 'athletes.id'},
                    {data: 'funcion', name: 'athletes.funcion'},
                    {data: 'name', name: 'athletes.name'},
                    {data: 'last_name', name: 'athletes.last_name'},
                    {data: 'document', name: 'athletes.document'},
                    {data: 'provincia', name: 'athletes.provincia'},
                    {data: 'sport', name: 'athletes.sport'},
                    {data: 'event', name: 'athletes.event'},
                    {data: 'actions', name: 'opciones', orderable: false, searchable: false}
                ],
                "language": {
                    "decimal": ",",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": " ",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encrontraron coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    },
                    "buttons": {
                        "colvis": "Columnas",
                        "copy": "Copiar",
                        "print": "Imprimir"
                    }
                },
                "fnInitComplete": function () {

                    $('#atletas_table').fadeIn();


                    table.columns().every(function () {
                        var column = this;
                        var columnClass = column.footer().className;
                        if (columnClass !== 'non_searchable') {
                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                                .on('keyup', function () {//keypress keyup change
                                    column.search($(this).val(), false, false, true).draw();
                                });
                        }
                    });

                }
            });

//            table.buttons().container()
//                .appendTo( '#botones_imprimir' );

        });

        $(document).on('change', '#imp_all', function (event) {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on('click', '#imprimir', function (event) {
            console.log('cj');
            $("#imp_all").prop("checked",false);
        });
    </script>


@endsection
