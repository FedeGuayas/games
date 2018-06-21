@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                @include('alert.alert')

            </div>
        </div>

        <h4 class="page-header">Participantes Acreditados</h4>
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <table class="table table-striped table-bordered table-condensed table-hover table-responsive"
                   id="atletas_table" cellspacing="0" style="display: none;overflow: auto; font-size: 11px;"
                   width="100%">
                <thead>
                <tr>
                    <th width="10">No.</th>
                    <th>Función</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th style="width: 60px">Cédula</th>
                    <th>Provincia</th>
                    <th>Deporte</th>
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
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="animationload" id="loading">
            <div class="osahanloading"></div>
        </div>



    </div>
@endsection


@push('scripts')

<script>
    $(document).ready(function () {

        $(".form_noEnter").keypress(function (e) {
            if (e.which === 13) {
                return false;
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

        var table = $('#atletas_table').on('processing.dt', function (e, settings, processing) {
            $('#loading').css('display', processing ? 'block' : 'none');
        }).DataTable({

//                    var table = $('#atletas_table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todo']],
            processing: false,
            stateSave: false,
            serverSide: true,
            ajax: '{{route('getAllAcreditados')}}',
            columns: [
                {data: 'id', name: 'athletes.id'},
                {data: 'funcion', name: 'athletes.funcion'},
                {data: 'name', name: 'athletes.name'},
                {data: 'last_name', name: 'athletes.last_name'},
                {data: 'document', name: 'athletes.document'},
                {data: 'provincia', name: 'provincia.province'},
                {data: 'deporte', name: 'deporte.name'}
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
                            .on('change', function () {//keypress keyup change
                                column.search($(this).val(), false, false, true).draw();
                            });
                    }
                });

            }
        });

    });


</script>


@endpush
