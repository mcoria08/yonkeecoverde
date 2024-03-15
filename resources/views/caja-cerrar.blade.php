@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cerrar Caja</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">

                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Detalle:</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <address class="address">
                                    Cajero: <strong>{{$user->name}}</strong> [{{$user->email}}]<br/>
                                </address>
                            </div>
                            <div class="col-sm-4">
                                <address class="address">
                                    Fecha: <strong>{{ today() }}</strong><br/>
                                </address>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>

                    </div>

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detalle de Ventas</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="tableTasks">
                                <thead>
                                <tr>
                                    <th style="width:20px">#</th>
                                    <th>Concepto</th>
                                    <th style="text-align: center">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Monto de Apertura</td>
                                        <td>$ {{number_format($data['openingAmount'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Venta en Efectivo</td>
                                        <td>$ {{number_format($data['cashPaymentAmount'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Venta con Tarjeta</td>
                                        <td>$ {{number_format($data['creditCardPaymentAmount'],2)}}</td>
                                    </tr>
                                    <tr style="border-right:none; border-left:none">
                                        <td style="border-right:none; border-left:none"></td>
                                        <td style="border-right:none; border-left:none"></td>
                                        <td style="border-right:none; border-left:none"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>Venta Total</strong></td>
                                        <td>$ {{number_format($data['totalSalesAmount'],2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br/>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtNotas">Notas</label>
                                        <textarea class="form-control" rows="4" placeholder="Agregar alguna nota ..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-info float-right" id="cerrar">Cerrar Caja</button>
                            <button type="button" class="btn btn-default" id="cancelar">Cancelar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop


@section('css')
    <style>
        td{
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
        $(document).ready(function() {
            console.log('Hi!');

            // Click event handler for buttons with class "btn-info"
            $('body').on('click', '.btn-default', function(e) {
                console.log('click');
                // Redirect to '/dashboard'
                window.location.href = "{{ url('/dashboard') }}";
            });


            $('#cerrar').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('cash-box.close') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        window.location.href = "{{ url('/dashboard') }}";
                    },
                    error: function(xhr) {
                        console.error('Error creating sale:', xhr.responseText);
                        // Handle error, such as displaying an error message
                    }
                });
            });

        });
    </script>

@stop
