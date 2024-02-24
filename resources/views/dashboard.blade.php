@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row my-1 text-end">
        <div class="col">
            <a href="/new" class="btn btn-primary">Crear Nueva Unidad</a>
        </div>
    </div>
    <table class="table table-bordered data-table">

        <thead>
        <tr>
            <th>No</th>
            <th>Proviene</th>
            <th>Datos</th>
            <th>Unidad</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th>No</th>
            <th>Proviene</th>
            <th>Datos</th>
            <th>unidad</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th></th>
        </tr>
        </tfoot>
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
                ajax: "{{ route('unidad.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        render: function (data, type, row) {
                            return "<a href='/unidad/" + row.id + "/ver'>" + data + "</a>";
                        }
                    },
                    {data: 'proviene', name: 'proviene'},
                    {data: 'datos', name: 'datos'},
                    {data: 'unidad', name: 'unidad'},
                    {data: 'marca', name: 'marca'},
                    {data: 'modelo', name: 'modelo'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.footer().textContent;

                            // Create input element
                            let input = document.createElement('input');
                            input.placeholder = title;
                            column.footer().replaceChildren(input);

                            // Event listener for user input
                            input.addEventListener('keyup', () => {
                                if (column.search() !== this.value) {
                                    column.search(input.value).draw();
                                }
                            });
                        });
                }
            });
        });
    </script>
@stop
