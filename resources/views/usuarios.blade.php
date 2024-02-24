@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="row my-1 text-end">
        <div class="col">
            <a href="/usuario-nuevo" class="btn btn-primary">Crear Nuevo Usuario</a>
        </div>
    </div>
    <table class="table table-bordered data-table">

        <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo</th>

            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                order: [[1, 'desc']],
                processing: true,
                serverSide: true,
                ajax: "{{ route('usuarios.index') }}",
                columns: [
                    {data: 'id', name: 'id',
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='/usuario/"+oData.id+"/ver'>"+oData.id+"</a>");
                        }},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'type', name: 'type',
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<span class='badge "+(oData.type==='administrador'?'bg-primary':'bg-success')+"'>"+oData.type+"</span>");
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@stop
