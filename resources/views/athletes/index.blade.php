@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @include('alert.alert')

        </div>
    </div>

        <h4 class="page-header">Listado de participantes</h4>
        <div class="row">
            <div class="col-lg-6" id="botones_imprimir"></div>
        </div>
        <div class="col-xs-12 col-md-10 col-md-offset-1">
        <table class="table table-striped table-bordered table-condensed table-hover table-responsive"
               id="atletas_table" cellspacing="0" style="display:none; overflow: auto; font-size: 11px;" width="100%">
            <thead>
            <tr>
                <th width="10">No.</th>
                <th>Función</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th style="width: 60px">Cédula</th>
                <th>Provincia</th>
                <th>Deporte</th>
                <th style="width: 50px;">Estado</th>
                <th style="width: 50px;">Acreditado</th>
                <th style="width: 80px;">Acción</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>No.</th>
                <th class="tfoot_search">Función</th>
                <th class="tfoot_search">Nombres</th>
                <th class="tfoot_search">Apellidos</th>
                <th class="tfoot_search">Cédula</th>
                <th class="tfoot_search">Provincia</th>
                <th class="tfoot_search">Deporte</th>
                <th class="tfoot_search">Estado</th>
                <th class="tfoot_search">Acreditado</th>
                <th >Acción</th>
            </tr>
            </tfoot>
        </table>
</div>
    <div class="animationload" id="loading">
        <div class="osahanloading"></div>
    </div>

    {!! Form::open(['route'=>['athletes.destroy',':ID'],'method'=>'DELETE','id'=>'form-delete']) !!}
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

            //texto de input para filtrar
            $('.tfoot_search').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" style="width: 80%" placeholder="' + title + '" />');
            });

            var table = $('#atletas_table').on('processing.dt', function (e, settings, processing) {
                $('#loading').css('display', processing ? 'block' : 'none');
            }).DataTable({

//                    var table = $('#atletas_table').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todo']],
                processing: false,
                stateSave: false,
                serverSide: true,
                ajax: '{{route('getAllAthletes')}}',
                columns: [
                    {data: 'id', name: 'athletes.id'},
                    {data: 'funcion', name: 'athletes.funcion'},
                    {data: 'name', name: 'athletes.name'},
                    {data: 'last_name', name: 'athletes.last_name'},
                    {data: 'document', name: 'athletes.document'},
                    {data: 'provincia', name: 'provincia.province'},
                    {data: 'deporte', name: 'deporte.name'},
                    {data: 'status', name: 'athletes.status'},
                    {data: 'acreditado', name: 'athletes.acreditado',orderable: false, searchable: false},
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
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        //input text
                        if ($(column.footer()).hasClass('tfoot_search')) {
                            //aplicar la busquedad
                            var that = this;
                            $('input', this.footer()).on('keyup change', function () {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });

                        }
                        else if ($(column.footer()).hasClass('tfoot_select')) { //select
                            var column = this;
                            //aplicar la busquedad
                            var select = $('<select style="width: 100%"><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {//keypress keyup change
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        }
                    });
                }

            });
            $("#atletas_table").fadeIn();

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
                        swal("Cancelado!", "No elimino a atleta", "error");
                    }
                });
        }

    </script>


@endpush
