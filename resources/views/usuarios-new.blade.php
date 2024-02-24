@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
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
                            <form id="stock_create_form" name="stock_create_form" action="{{route('usuarios.saveUser')}}" enctype="multipart/form-data"  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtName">Nombre del Usuario</label>
                                            <input type="text" class="form-control @error('txtName') is-invalid @enderror" name="txtName" id="txtName"
                                                   placeholder="Nombre del Usuario" required value="{{ old('txtName') }}">
                                            @error('txtName')
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
                                        <div class="form-group">
                                            <label for="txtName">Correo</label>
                                            <input type="text" class="form-control @error('txtEmail') is-invalid @enderror" name="txtEmail" id="txtEmail"
                                                   placeholder="Correo" required value="{{ old('txtEmail') }}">
                                            @error('txtEmail')
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
                                        <div class="form-group">
                                            <label for="txtPassword">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control @error('txtPassword') is-invalid @enderror"
                                                       name="txtPassword" id="txtPassword" placeholder="Contraseña"
                                                       required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                            id="generatePassword">Generar
                                                    </button>
                                                </div>
                                            </div>
                                            @error('txtPassword')
                                            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>

                                <div class="row">                                <!-- /.card-body -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtTypeUSer">Tipo de Usuario</label>
                                            <x-adminlte-select required
                                                               class="form-control @error('txtTypeUSer') is-invalid @enderror"
                                                               name="txtTypeUSer" id="txtTypeUSer" required>
                                                <option value="vendedor">Vendedor</option>
                                                <option value="administrador">Administrador</option>
                                            </x-adminlte-select>
                                            @error('txtTypeUSer')
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
        $(document).ready(function () {
            $('#generatePassword').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('generate.password') }}', // Update the route name based on your routes
                    success: function (response) {
                        $('#txtPassword').val(response.password);
                    },
                    error: function (error) {
                        console.error('Error generating password:', error);
                    }
                });
            });
        });
    </script>

@stop
