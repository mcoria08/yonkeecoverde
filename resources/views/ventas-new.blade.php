@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Nueva Venta</h1>
@stop

@section('content')

    @if (!$cashBox)
        <div class="alert red-custom" role="alert">
            <h4 class="alert-heading">Caja no abierta</h4>
            <p>Para poder realizar una venta, es necesario abrir la caja.</p>
            <hr>
            <form id="openCashBoxForm" method="post"  autocomplete="off" autocorrect="off" autocapitalize="off">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="txtAmount">Cantidad</label>
                            <input type="number" class="form-control @error('txtAmount') is-invalid @enderror" name="txtAmount" id="txtAmount" placeholder="Cantidad" required value="{{ old('txtAmount') }}">
                            @error('txtAmount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <button type="button" id="openCashBoxBtn" class="btn btn-success">Abrir Caja</button>
                    </div>
                </div>
            </form>
        </div>
    @else
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
                                <form id="sales_create_form" name="sales_create_form" enctype="multipart/form-data" method="post">
                                    @csrf

                                    <div class="row">

                                        <div class="col-sm-4">
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

                                        <div class="col-sm-4">
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

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="txtName">Persona que recibe</label>
                                                <input type="text" class="form-control @error('txtName') is-invalid @enderror" name="txtName" id="txtName"
                                                       placeholder="Persona que recibe" required value="{{ old('txtName') }}">
                                                @error('txtName')
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
                                                    <th style="text-align:center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if ($cartContent->isNotEmpty())
                                                    @foreach($cartContent as $item)
                                                        <tr class="sales-row" data-rowId="{{$item->rowId}}">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->options->marca}}</td>
                                                            <td>{{$item->options->modelo}}</td>
                                                            <td>{{$item->options->anio}}</td>
                                                            <td style="text-align:right">$ {{number_format($item->price,2)}}</td>
                                                            <td style="text-align:center">
                                                                <div class="btn-group">
                                                                    <a href="{{ url('delete-article') }}" data-delete-rowId="{{$item->rowId}}" title="Borrar Artículo" class="delete-article tip btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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
                                                        <td class="subTotal"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>IVA (16%)</th>
                                                        <td class="iva"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td class="total"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row no-print">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success float-right btn-register-sale"><i
                                                    class="far fa-credit-card"></i> Registrar Venta
                                            </button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="typePayment" id="typePayment" value="efectivo">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Tipo de Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary btn-payment" data-payment="efectivo">Efectivo</button>
                    <button class="btn btn-primary btn-payment" data-payment="tarjeta">Tarjeta de Débito/Crédito</button>

                    <div id="creditCardInput" style="display: none; padding-bottom:10px">
                        <label for="creditCardNumber"></label>
                        <input type="text" class="form-control" id="creditCardNumber" placeholder="# Referencia">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="submitPayment">Enviar</button>
                </div>
            </div>
        </div>
    </div>

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

        .btn-group>.btn:last-child:not(:first-child), .btn-group>.dropdown-toggle:not(:first-child){
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .btn, .btn-app{
            border-radius: 3px;
        }

        .red-custom{
            background-color: #e35d6a;
            color: white;
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

        function checkDropdowns() {
            let customerSelected = $('#txtCustomer').val();
            let locationSelected = $('#txtLocation').val();
            let txtName = $('#txtName').val();

            // If both dropdowns have selected values, enable the button
            if (customerSelected && locationSelected && txtName) {
                $('.btn-register-sale').prop('disabled', false);
            } else {
                // Otherwise, disable the button
                $('.btn-register-sale').prop('disabled', true);
            }
        }

        // Call checkDropdowns initially
        checkDropdowns();

        // Listen for changes in the dropdowns
        $('#txtCustomer, #txtLocation').change(function() {
            // Call checkDropdowns whenever a change occurs
            checkDropdowns();
        });

        //Enable/disable in txtName is empty or not
        $('#txtName').on('input', function() {
            checkDropdowns();
        });


        // Function to calculate the total amount
        function calculateSubTotalAmount() {
            let subtotal = 0;
            let iva = 0;
            let total = 0;
            $.ajax({
                type: "GET",
                url: "{{url('get-sub-total')}}",
                success: function (response) {
                    console.log(response.subtotal);
                    if (response.subtotal) {
                        subtotal = response.subtotal;
                        iva = response.iva;
                        total = response.total;

                        // Format subtotal, iva, and total as currency
                        var formatter = new Intl.NumberFormat('es-MX', {
                            style: 'currency',
                            currency: 'MXN'
                        });

                        // Set formatted values to the corresponding elements
                        $('.subTotal').text(formatter.format(subtotal));
                        $('.iva').text(formatter.format(iva));
                        $('.total').text(formatter.format(total));
                    }
                }
            });
        }

        // Call calculateTotalAmount initially
        calculateSubTotalAmount();


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
                    success: function (resStockData) {
                        console.log(resStockData);
                        if (resStockData === "duplicated"){
                            alert("El producto ya ha sido agregado a la venta");
                        }else {
                            // AJAX request to add the item to sale
                            $.ajax({
                                type: "POST",
                                url: "{{url('add-item-to-sale')}}",
                                data: {item_id: resStockData[0].id},
                                success: function (resAddedItem) {
                                    console.log(resAddedItem.message.rowId);

                                    //Insert a new row into table "tableSales" with jquery
                                    let newRow = $("<tr class='sales-row' data-rowId='"+resAddedItem.message.rowId+"'>");
                                    let cols = "";
                                    let index = $(".sales-row").length;

                                    cols += '<td>' + (index + 1) + '</td>';
                                    cols += '<td>' + resStockData[0].part_name + '</td>';
                                    cols += '<td>' + resStockData[0].marca + '</td>';
                                    cols += '<td>' + resStockData[0].modelo + '</td>';
                                    cols += '<td>' + resStockData[0].anio + '</td>';
                                    cols += '<td style="text-align:right">$' + resStockData[0].selling_price + '</td>';
                                    cols += '<td style="text-align:center"><div class="btn-group">';
                                    cols += '<a href="' + "{{ url('delete-article') }}" + '" data-delete-rowId='+ resAddedItem.message.rowId + '  title="Borrar Artículo" class="delete-article tip btn btn-danger btn-xs">';
                                    cols += '<i class="fas fa-trash-alt"></i></a></div></td>';
                                    newRow.append(cols);
                                    $("#tableSales").append(newRow);
                                }
                            });

                            //Close the model
                            $('#searchModal').modal('hide');

                            // Recalculate the total amount
                            calculateSubTotalAmount();
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

        $('body').on('click', '.delete-article', function(e) {
            e.preventDefault();
            let rowId = $(this).attr('data-delete-rowId');
            console.log(rowId);
            if (confirm('Vas a borrar el artículo, presiona ok para borrar.')) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('delete-article') }}",
                    data: {rowId: rowId},
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // Assuming you want to remove the row from the table upon successful deletion
                        $('tr[data-rowId="' + rowId + '"]').remove();
                        // Recalculate the total amount
                        calculateSubTotalAmount();
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
            }
        });


        $('.btn-register-sale').click(function (e) {
            e.preventDefault();
            $('#paymentModal').modal('show');
        });

        $('.btn-payment').click(function() {
            let paymentType = $(this).data('payment');
            $('#typePayment').val(paymentType);
            if (paymentType === 'tarjeta') {
                $('#creditCardInput').show();
            } else {
                $('#creditCardInput').hide();
            }

        });

        $('#submitPayment').click(function() {
            let paymentType = $('#typePayment').val();
            let creditCardNumber = $('#creditCardNumber').val();
            let formData = $("#sales_create_form").serialize();

            $.ajax({
                type: 'POST',
                url: "{{ url('registerSale') }}",
                data: {data: formData, paymentType: paymentType, creditCardNumber: creditCardNumber},
                success: function(response) {
                    console.log('Sale created successfully:', response.message);
                    // Handle success, such as displaying a success message
                    // $('#paymentModal').modal('hide');
                    // // Clear the table
                    // $('#tableSales tbody').empty();
                    // redirect to ventas route with the receipt ID as parameter
                    window.location.href = "{{ url('recibo') }}/" + response.message + "/ver";
                },
                error: function(xhr) {
                    console.error('Error creating sale:', xhr.responseText);
                    // Handle error, such as displaying an error message
                }
            });
        });

        $('#openCashBoxForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            submitForm();
        });

        $('#openCashBoxBtn').click(function() {
            submitForm();
        });

        function submitForm() {
            $.ajax({
                url: "{{ route('cash-box.open') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: $('#txtAmount').val()
                },
                success: function(response, status, xhr) {
                    console.log(response)
                    if (xhr.status === 200) {
                        window.location.href = "{{ url('/ventas') }}";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle error scenario
                }
            });
        }
    </script>

@stop
