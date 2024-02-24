@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ver/Editar Pieza</h1>
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
                            <form id="stock_update_form" name="stock_update_form" action="{{route('piezas.savePiece')}}" enctype="multipart/form-data"  method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $pieza['id'] }}">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtName">Nombre de la pieza</label>
                                            <input type="text" class="form-control @error('txtName') is-invalid @enderror" name="txtName" id="txtName"
                                                   placeholder="Nombre de la pieza" required value="{{ $pieza['name'] }}">
                                            @error('txtPartName')
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
