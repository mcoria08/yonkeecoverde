@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ver/Editar Stock</h1>
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
                            <form id="stock_update_form" name="stock_update_form" action="{{route('stock.saveUnit')}}" enctype="multipart/form-data"  method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $stock['id'] }}">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtUnidad">Unidad</label>
                                            <x-adminlte-select required
                                                               class="form-control @error('txtUnidad') is-invalid @enderror"
                                                               name="txtUnidad" id="txtUnidad" required>
                                                <option value="">-- Selecciona una Unidad --</option>
                                                @foreach($unidades as $unidad)
                                                    <option {{ ($unidad->id===$stock->id_unidad?'selected':'') }} value="{{$unidad->id}}">[{{$unidad->id}}] - {{$unidad->unidad}} {{$unidad->marca}} ({{$unidad->anio}})</option>
                                                @endforeach
                                            </x-adminlte-select>
                                            @error('txtUnidad')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        {{--<div class="form-group">
                                            <label for="txtPartName">Nombre de la pieza</label>
                                            <input type="text" class="form-control @error('txtPartName') is-invalid @enderror" name="txtPartName" id="txtPartName"
                                                   placeholder="Nombre de la pieza" required value="{{ old('txtPartName') }}">
                                            @error('txtPartName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>--}}
                                        <div class="form-group">
                                            <label for="txtPartName">Nombre de la pieza</label>
                                            <x-adminlte-select required
                                                               class="form-control @error('txtPartName') is-invalid @enderror"
                                                               name="txtPartName" id="txtPartName" required>
                                                <option value="">-- Selecciona una Pieza --</option>
                                                @foreach($piezas as $pieza)
                                                    <option {{ ($pieza->id===$stock->id_pieza?'selected':'') }} value="{{$pieza->id}}">[{{$pieza->id}}] - {{$pieza->name}}</option>
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
                                            <label for="txtPartNumber"># de Parte</label>
                                            <input type="text" class="form-control @error('txtPartNumber') is-invalid @enderror" name="txtPartNumber" id="txtPartNumber"
                                                   placeholder="# de Parte" required value="{{ $stock['part_number'] }}">
                                            @error('txtPartNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtCarBrand">Auto Compatible</label>
                                            <input type="text" disabled class="form-control" name="txtCarBrand" id="txtCarBrand" placeholder="" value="{{ $auto['marca'] }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtCarModelCompatibility">Modelo</label>
                                            <input type="text" disabled class="form-control" name="txtCarModelCompatibility" id="txtCarModelCompatibility" placeholder="" value="{{ $auto['modelo'] }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtAnio">Año</label>
                                            <input type="text" disabled class="form-control" name="txtAnio" id="txtAnio" placeholder="" value="{{ $auto['anio'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtVenta">Precio de Venta</label>
                                            <input type="text" class="form-control @error('txtVenta') is-invalid @enderror" name="txtVenta" id="txtVenta"
                                                   placeholder="Precio de Venta" required value="{{ $stock['selling_price'] }}">
                                            @error('txtVenta')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtCondition">Especificaciones</label>
                                            <input type="text" class="form-control @error('txtCondition') is-invalid @enderror" name="txtCondition" id="txtCondition"
                                                   placeholder="Especificaciones" required value="{{ $stock['condition'] }}">
                                            @error('txtCondition')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtManufacturer">Fabricante</label>
                                            <input type="text" class="form-control @error('txtManufacturer') is-invalid @enderror" name="txtManufacturer" id="txtManufacturer"
                                                   placeholder="Fabricante" required value="{{ $stock['manufacturer'] }}">
                                            @error('txtManufacturer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtCarBrand">Auto Compatible</label>
                                            <input type="text" class="form-control @error('txtCarBrand') is-invalid @enderror" name="txtCarBrand" id="txtCarBrand"
                                                   placeholder="Auto Compatible" required value="{{ $stock['car_brand'] }}">
                                            @error('txtCarBrand')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtCarModelCompatibility">Modelo</label>
                                            <input type="text" class="form-control @error('txtCarModelCompatibility') is-invalid @enderror" name="txtCarModelCompatibility" id="txtCarModelCompatibility"
                                                   placeholder="Modelo" required value="{{ $stock['car_model_compatibility'] }}">
                                            @error('txtCarModelCompatibility')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtAnio">Año</label>
                                            <input type="text" class="form-control @error('txtAnio') is-invalid @enderror" name="txtAnio" id="txtAnio"
                                                   placeholder="Año" required value="{{ $stock['year_of_manufacture'] }}">
                                            @error('txtAnio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtCompra">Precio de Compra</label>
                                            <input type="text" class="form-control @error('txtCompra') is-invalid @enderror" name="txtCompra" id="txtCompra"
                                                   placeholder="Precio de Compra" required value="{{ $stock['purchase_price'] }}">
                                            @error('txtCompra')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtVenta">Precio de Venta</label>
                                            <input type="text" class="form-control @error('txtVenta') is-invalid @enderror" name="txtVenta" id="txtVenta"
                                                   placeholder="Precio de Venta" required value="{{ $stock['selling_price'] }}">
                                            @error('txtVenta')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtLocationStock">Ubicación Stock</label>
                                            <input type="text" class="form-control @error('txtLocationStock') is-invalid @enderror" name="txtLocationStock" id="txtLocationStock"
                                                   placeholder="Ubicación Stock" required value="{{ $stock['location_in_stock'] }}">
                                            @error('txtLocationStock')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtCondition">Condición</label>
                                            <input type="text" class="form-control @error('txtCondition') is-invalid @enderror" name="txtCondition" id="txtCondition"
                                                   placeholder="Condición" required value="{{ $stock['condition'] }}">
                                            @error('txtCondition')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtObservaciones">Notas</label>
                                            <input type="text" class="form-control @error('txtObservaciones') is-invalid @enderror" name="txtObservaciones" id="txtObservaciones"
                                                   placeholder="Notas" required value="{{ $stock['notes'] }}">
                                            @error('txtObservaciones')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>--}}

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
@stop

@section('js')


    <script>
        console.log('Hi!');
    </script>

@stop
