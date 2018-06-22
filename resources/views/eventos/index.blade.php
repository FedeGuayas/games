@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @include('alert.alert')

        </div>
    </div>

        <h4 class="page-header">Lista de eventos</h4>
        <div class="col-xs-12 col-md-10 col-md-offset-1">
        <table class="table table-striped table-bordered table-condensed table-hover table-responsive"
               id="eventos_table" cellspacing="0" style="display: none;overflow: auto; font-size: 11px;" width="100%">
            <thead>
            <tr>
                <th width="10">No.</th>
                <th>Disciplina</th>
                <th>Provincia</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Accción</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th width="10">No.</th>
                <th>Disciplina</th>
                <th>Provincia</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th class="non_searchable">Acción</th>
            </tr>
            </tfoot>
        </table>
</div>
    <div class="animationload" id="loading">
        <div class="osahanloading"></div>
    </div>

    {!! Form::open(['route'=>['events.destroy',':ID'],'method'=>'DELETE','id'=>'form-delete']) !!}
    {!! Form::close() !!}

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

            var table = $('#events_table').on('processing.dt', function (e, settings, processing) {
                $('#loading').css('display', processing ? 'block' : 'none');
            }).DataTable({

//                    var table = $('#atletas_table').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todo']],
                processing: false,
                stateSave: false,
                serverSide: true,
                ajax: '{{route('getAllEvents')}}',
                columns: [
                    {data: 'id', name: 'events.id'},
                    {data: 'deporte', name: 'deportes.name'},
                    {data: 'provincia', name: 'provincias.province'},
                    {data: 'date_start', name: 'events.date_start'},
                    {data: 'date_end', name: 'events.date_end'},
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
                                .on('change', function () {//keypress keyup change
                                    column.search($(this).val(), false, false, true).draw();
                                });
                        }
                    });

                }
            });

//            table.buttons().container()
//                .appendTo( '#botones_imprimir' );

        });

        function eliminar(btn) {

            var id = btn.value;
//            var token = $("#token").val();
            var token = $("input[name=_token]").val();
            var form=$("#form-delete");
            var route=form.attr('action').replace(':ID',id);

            swal({
                    title: "Confirme para eliminar",
                    text: "El registro pasara a un estado inactivo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "SI!",
                    cancelButtonText: " NO!",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        setTimeout(function ()
                        {
                            $.ajax({
                                url: route,
                                type: "DELETE",
                                headers: {'X-CSRF-TOKEN': token},
                                contentType: 'application/x-www-form-urlencoded',
                                dataType:'json',
                                success: function (response) {
                                    console.log(response);
                                    swal("Confirmado!", response.resp,"success");
                                    $('#atletas_table').DataTable().draw();
                                },
                                error: function (resp) {
                                    console.log('Error al eliminar con ajax');
                                }
                            });
//                        swal("Respuesta ajax");
                        },2000);
                    }//isConfirm
                    else {
                        swal("Cancelado!", "No elimino el evento", "error");
                    }
                });
        }

    </script>


@endpush
