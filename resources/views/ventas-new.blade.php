@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Nueva Venta</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulario</h3>
                        </div>
                        <div class="card-body">
                            <form id="stock_create_form" name="stock_create_form" action="{{route('stock.saveUnit')}}"
                                  enctype="multipart/form-data" method="post">
                                @csrf

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtCustomer">Cliente</label>
                                            <x-adminlte-select required
                                                               class="form-control @error('txtCustomer') is-invalid @enderror"
                                                               name="txtCustomer" id="txtCustomer" required>
                                                <option value="">-- Selecciona un Cliente --</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}">[{{$customer->rfc}}]
                                                        - {{$customer->name}}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                            @error('txtPartName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtCustomer">Oficina</label>
                                            <x-adminlte-select required
                                                               class="form-control @error('txtLocation') is-invalid @enderror"
                                                               name="txtLocation" id="txtLocation" required>
                                                <option value="">-- Selecciona una Oficina --</option>
                                                @foreach($locations as $location)
                                                    <option value="{{$location->id}}">{{$location->nombre}}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                            @error('txtLocation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="input-group input-group-lg">
                                                <input type="search" id="txtSearch" name="txtSearch"
                                                       class="form-control form-control-lg"
                                                       placeholder="Buscar producto" value="">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-lg btn-default btn-search">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- /.card-body -->


                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tableSales">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Pieza</th>
                                                <th>Automovil</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th style="text-align:right">Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-6">

                                    </div>

                                    <div class="col-6">
                                        <p class="lead">Desgloce</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td>$250.30</td>
                                                </tr>
                                                <tr>
                                                    <th>IVA (16%)</th>
                                                    <td>$10.34</td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td>$265.24</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="row no-print">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-success float-right"><i
                                                class="far fa-credit-card"></i> Registrar Venta
                                        </button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Coincidencias de <span class="searchedText"
                                                                                         style="font-weight:bold; color:green"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search results will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <style type="text/css">
        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            text-align: left;
            padding: 0 10px;
        }

        tr > td:last-of-type {
            text-align: right;
        }
    </style>
@stop

@section('js')

    <script>
        console.log('Hi!');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /*$('#txtUnidad').change(function(){
            let unidad_id = $(this).val();
            console.log(unidad_id);
            if(unidad_id){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-car-data')}}?unidad_id="+unidad_id,
                    success:function(res){
                        console.log(res);
                        if(res){
                            $("#txtCarBrand").val(res.marca);
                            $("#txtCarModelCompatibility").val(res.modelo);
                            $("#txtAnio").val(res.anio);
                        }else{
                            $("#txtCarBrand").empty();
                            $("#txtCarModelCompatibility").empty();
                            $("#txtAnio").empty();
                        }
                    }
                });
            }else{
                $("#txtCarBrand").empty();
                $("#txtCarModelCompatibility").empty();
                $("#txtAnio").empty();
            }
        });*/


        $('.btn-search').click(function (e) {
            e.preventDefault();
            const searchValue = $('#txtSearch').val();
            $.ajax({
                url: '/search',
                type: 'GET',
                data: {search: searchValue},
                success: function (response) {
                    console.log(searchValue);
                    updateModal(response, searchValue);
                    $('#searchModal').modal('show');
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

        $('body').on('click', '.btnAdd', function (e) {
            const stock_id = $(this).attr("data-add");
            if (stock_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('get-stock-data')}}?stock_id=" + stock_id,
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            //Insert a new row into table "tableSales" with jquery
                            var newRow = $("<tr>");
                            var cols = "";
                            cols += '<td>1</td>';
                            cols += '<td>' + res[0].part_name + '</td>';
                            cols += '<td>' + res[0].marca + '</td>';
                            cols += '<td>' + res[0].modelo + '</td>';
                            cols += '<td>' + res[0].anio + '</td>';
                            cols += '<td style="text-align:right">$' + res[0].selling_price + '</td>';
                            newRow.append(cols);
                            $("#tableSales").append(newRow);

                            // AJAX request to add the item to sale
                            $.ajax({
                                type: "POST",
                                url: "{{url('add-item-to-sale')}}",
                                data: { item_id: res[0].id },
                                success: function (response) {
                                    console.log(response.message);
                                }
                            });

                            //Close the model
                            $('#searchModal').modal('hide');
                        }
                    }
                });
            } else {
                $("#txtCarBrand").empty();
                $("#txtCarModelCompatibility").empty();
                $("#txtAnio").empty();
            }
        });

        function updateModal(data, searchValue) {
            let modalBody = $('#searchModal .modal-body');
            $('.searchedText').text(searchValue)
            modalBody.empty(); // Clear previous results
            if (data.length > 0) {
                var list = $('<ul class="list-group"></ul>');
                data.forEach(function (item) {
                    var listItem = $('<li class="list-group-item"><table class="table-hover"><tr><td>' + item.part_name + '</td><td>' + item.unidad + '</td><td>' + item.modelo + '</td><td>' + item.anio + '</td><td>' + item.motor + '</td><td>$ ' + item.selling_price + '</td><td><button data-add="' + item.id + '" type="button" class="btn btn-block btn-success btnAdd">Agregar</button></td><tr><table></li>');
                    list.append(listItem);
                });
                modalBody.append(list);
            } else {
                modalBody.append('<p>Sin resultados</p>');
            }
        }
    </script>

@stop
