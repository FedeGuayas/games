@extends('layouts.app')

@section('content')



    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @include('alert.alert')

        </div>
    </div>

    <div class="container">
        <h4>Atletas</h4>
        <div class="row">
            <div class="col-lg-6" id="botones_imprimir"></div>
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
                <th width="80">Acción</th>

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
                <th class="non_searchable">Acción</th>
            </tr>
            </tfoot>
        </table>

    </div>


    <div class="animationload" id="loading">
        <div class="osahanloading"></div>
    </div>

    {!! Form::open(['route'=>['athletes.destroy',':ID'],'method'=>'DELETE','id'=>'form-delete']) !!}
    {!! Form::close() !!}

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
                    {data: 'provincia', name: 'athletes.provincia'},
                    {data: 'sport', name: 'athletes.sport'},
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



        function eliminar(btn) {

            var id = btn.value;
//            var token = $("#token").val();
            var token = $("input[name=_token]").val();
            var form=$("#form-delete");
            var route=form.attr('action').replace(':ID',id);

            swal({
                    title: "Confirme para eliminar al atleta",
                    text: "Esta acción no se podrá deshacer!",
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

        $(document).on('change', '#imp_all', function (event) {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    </script>


@endsection
