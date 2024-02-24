@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Agregar a Stock</h1>
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
                            <form id="stock_create_form" name="stock_create_form" action="{{route('stock.saveUnit')}}" enctype="multipart/form-data"  method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtUnidad">Unidad</label>
                                            <x-adminlte-select required
                                                class="form-control @error('txtUnidad') is-invalid @enderror"
                                                name="txtUnidad" id="txtUnidad" required>
                                                <option value="">-- Selecciona una Unidad --</option>
                                                @foreach($unidades as $unidad)
                                                    <option value="{{$unidad->id}}">[{{$unidad->id}}] - {{$unidad->unidad}} {{$unidad->marca}} ({{$unidad->anio}})</option>
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
                                                    <option value="{{$pieza->id}}">[{{$pieza->id}}] - {{$pieza->name}}</option>
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
                                                   placeholder="# de Parte" required value="{{ old('txtPartNumber') }}">
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
                                            <input type="text" disabled class="form-control" name="txtCarBrand" id="txtCarBrand" placeholder=""  value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtCarModelCompatibility">Modelo</label>
                                            <input type="text" disabled class="form-control" name="txtCarModelCompatibility" id="txtCarModelCompatibility" placeholder=""  value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtAnio">Año</label>
                                            <input type="text" disabled class="form-control" name="txtAnio" id="txtAnio" placeholder=""  value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtVenta">Precio de Venta</label>
                                            <input type="text" class="form-control @error('txtVenta') is-invalid @enderror" name="txtVenta" id="txtVenta"
                                                   placeholder="Precio de Venta" required value="{{ old('txtVenta') }}">
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
                                                   placeholder="Especificaciones" required value="{{ old('txtCondition') }}">
                                            @error('txtCondition')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

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

        $('#txtUnidad').change(function(){
            var unidad_id = $(this).val();
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
        });
    </script>

@stop
