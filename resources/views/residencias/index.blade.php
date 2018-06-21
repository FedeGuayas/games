@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                @include('alert.alert')

            </div>
        </div>

        <h4 class="page-header">Listado de Residencias</h4>

        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <table class="table table-striped table-bordered table-condensed table-hover table-responsive"
                   id="residencias_table" cellspacing="0"
                   style="display: none;overflow: auto; font-size: 11px; width: auto;"
                   width="100%">
                <thead>
                <tr>
                    <th>Residencia</th>
                    <th width="60">Capacidad</th>
                    <th width="60">Ocupado</th>
                    <th width="60">Disponible</th>
                    <th width="80">Acción</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Residencia</th>
                    <th>Capacidad</th>
                    <th>Ocupado</th>
                    <th>Disponible</th>
                    <th class="non_searchable">Acción</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($residencias as $r)
                    <tr>
                        <td>{{$r->name}}</td>
                        <td>{{$r->capacidad}}</td>
                        <td>{{$r->ocupado}}</td>
                        <td>
                            @if ($r->capacidad>0)
                                @if ((($r->ocupado*100)/$r->capacidad)>=95)
                                    <h5><span class="label label-danger">{{($r->capacidad)-($r->ocupado)}}</span></h5>
                                @elseif ((($r->ocupado*100)/$r->capacidad)>=90)
                                    <h5><span class=" label label-warning">{{($r->capacidad)-($r->ocupado)}}</span></h5>
                                @else
                                    <h5><span class="label label-success">{{($r->capacidad)-($r->ocupado)}}</span></h5>
                                @endif
                            @else
                                <h5><span class="label label-default">{{($r->capacidad)-($r->ocupado)}}</span></h5>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('residencias.edit',$r->id ) }}" style="text-decoration-line: none">
                                <button class="btn-xs btn-success"><span class="glyphicon glyphicon-edit"
                                                                         aria-hidden="true"></span></button>
                            </a>
                            <a href="#!" class="delete" data-id="{{$r->id}}">
                                <button class="btn-xs btn-danger"><span class="glyphicon glyphicon-trash"
                                                                        aria-hidden="true"></span></button>
                            </a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="animationload" id="loading">
            <div class="osahanloading"></div>
        </div>

        {!! Form::open(['route'=>['residencias.destroy',':ID'],'method'=>'DELETE','id'=>'form-delete']) !!}
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

        var table = $('#residencias_table').on('processing.dt', function (e, settings, processing) {
            $('#loading').css('display', processing ? 'block' : 'none');
        }).DataTable({

//                    var table = $('#atletas_table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todo']],
            processing: false,
            stateSave: false,
            serverSide: false,
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

                $('#residencias_table').fadeIn();

            }
        });

    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = $(this).attr('data-id');
        var form = $("#form-delete");
        var data = form.serialize();

//            var token = $("#token").val();
//        var token = $("input[name=_token]").val();
        var route = form.attr('action').replace(':ID', id);

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
                    $.ajax({
                        url: route,
                        data: data,
                        type: 'POST',
                        success: function (response) {
                            swal("Confirmado!", response.resp, "success");
                            row.fadeOut();
                        },
                        error: function (resp) {
                            row.show();
                            console.log(resp);
                            swal("ERROR!", response.resp, "error");
                        }
                    });
                }//isConfirm
                else {
                    swal("Cancelado!", "No elimino a la residencia", "error");
                }
            });
    });

</script>


@endpush
