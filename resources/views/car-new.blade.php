@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ingreso de Unidades</h1>
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
                            <form id="unit_create_form" name="unit_create_form" action="{{route('unidad.saveUnit')}}" enctype="multipart/form-data"  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtProviene">Proviene</label>
                                            <input type="text" class="form-control @error('txtProviene') is-invalid @enderror" name="txtProviene" id="txtProviene"
                                                   placeholder="Proviene" required value="{{ old('txtProviene') }}">
                                            @error('txtProviene')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtDatos">Datos</label>
                                            <input type="text" class="form-control @error('txtDatos') is-invalid @enderror" name="txtDatos" id="txtDatos"
                                                   placeholder="Datos" required value="{{ old('txtDatos') }}">
                                            @error('txtDatos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtUnidad">Unidad</label>
                                            <input type="text" class="form-control @error('txtUnidad') is-invalid @enderror" name="txtUnidad" id="txtUnidad"
                                                   placeholder="Unidad" required value="{{ old('txtUnidad') }}">
                                            @error('txtUnidad')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtMarca">Marca</label>
                                            <input type="text" class="form-control @error('txtMarca') is-invalid @enderror" name="txtMarca" id="txtMarca"
                                                   placeholder="Marca" required value="{{ old('txtMarca') }}">
                                            @error('txtMarca')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="txtModelo">Modelo</label>
                                            <input type="text" class="form-control @error('txtModelo') is-invalid @enderror" name="txtModelo" id="txtModelo"
                                                   placeholder="Modelo" required value="{{ old('txtModelo') }}">
                                            @error('txtModelo')
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
                                                   placeholder="Año" required value="{{ old('txtAnio') }}">
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
                                            <label for="txtDetalles">Detalles</label>
                                            <input type="text" class="form-control @error('txtDetalles') is-invalid @enderror" name="txtDetalles" id="txtDetalles"
                                                   placeholder="Detalles" required value="{{ old('txtDetalles') }}">
                                            @error('txtDetalles')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtMotor">Motor</label>
                                            <input type="text" class="form-control @error('txtMotor') is-invalid @enderror" name="txtMotor" id="txtMotor"
                                                   placeholder="Motor" required value="{{ old('txtMotor') }}">
                                            @error('txtMotor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="txtObservaciones">Observaciones</label>
                                            <input type="text" class="form-control @error('txtObservaciones') is-invalid @enderror" name="txtObservaciones" id="txtObservaciones"
                                                   placeholder="Observaciones" required value="{{ old('txtObservaciones') }}">
                                            @error('txtObservaciones')
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
                                            <div class="">
                                                <button type="button" data-toggle="modal" data-target="#multiMediaDropzoneModal" style="width: 600px; padding:3em; border-radius: 5px; border:1px solid #cccccc ">
                                                    Subir Imagenes
                                                </button>
                                            </div>
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

    <div id="multiMediaDropzoneModal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subir Archivos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('upload-media') }}" method="post" id="mediaFormMultipleDropzone" class="dropzone" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input id="submit-dropzone" type="submit" name="submitDropzone" value="Upload Gallery" class="btn btn-primary" />
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        console.log('Hi!');

        /*
    * Dropzone script
    * */
        // disable autodiscover
        Dropzone.autoDiscover = false;

        //const filesize = 5;
        const allowMaxFilesize = 5;
        const allowMaxFiles = 5;

        const myDropzone = new Dropzone("#mediaFormMultipleDropzone", {
            url: "{{ route('upload-media') }}",
            method: "POST",
            paramName: "files",
            autoProcessQueue: false,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            maxFiles: allowMaxFiles,
            maxFilesize: allowMaxFilesize, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
            createImageThumbnails: true,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            addRemoveLinks: true,
            timeout: 180000,
            dictRemoveFileConfirmation: "Desea eliminar esta imagen?", // ask before removing file
            // Language Strings
            dictFileTooBig: `File is to big. Max allowed file size is ${allowMaxFilesize}mb`,
            dictInvalidFileType: "Invalid File Type",
            dictCancelUpload: "Cancel",
            dictRemoveFile: "Remove",
            dictMaxFilesExceeded: `Only ${allowMaxFiles} files are allowed`,
            dictDefaultMessage: "Arrastra o haz click para subir imagenes",
        });

        myDropzone.on("addedfile", function(file) {
            // while file is drag or add in dropzone form maybe you want some other functionality
            // as per file then you can write code in this block
            //console.log(file);
        });

        myDropzone.on("removedfile", function(file) {
            // while file is remove from dropzone form maybe you want some other functionality
            // as per file remove then you can write code in this block
            // console.log(file);
        });

        // Add more data to send along with the file as POST data. (optional)
        // I commented below code why? when the file is send maybe you want to pass some other form input data so, you
        // you can pass it in this block. BUT in this tutorial I'm using dropzone form only for images so, i commented below code block.
        /*myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("dropzone", "1"); // $_POST["dropzone"]
            formData.append("productId", "10"); // $_POST["productId"]
        });*/

        myDropzone.on("error", function(file, response) {
            console.log(response);
        });

        // on success
        myDropzone.on("successmultiple", function(file, response) {
            // get response from successful ajax request
            // response includes what you you return from php side
            console.log('uploading files :) ');
            console.log(response);
            $.each(response, function( key, value ) {
                $('form#unit_create_form').append('<input type="text" name="gallery[]" value="'+value.name+'">')
            });


            /* submit the form after images upload
            (if u want to submit rest of the inputs in the form)
            I have no other inputs so, I commented below line. */
            //document.getElementById("mediaFormMultipleDropzone").submit();
        });

        // button trigger for processingQueue
        const submitDropzone = document.getElementById("submit-dropzone");
        submitDropzone.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();

            if (myDropzone.files !== "") {
                // console.log(myDropzone.files);
                myDropzone.processQueue();
            } else {
                // if no file submit the form
                document.getElementById("dropzone-form").submit();
            }
        });
        // multiple

    </script>

@stop
