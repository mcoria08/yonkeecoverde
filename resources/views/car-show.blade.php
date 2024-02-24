@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ver/Editar Unidad</h1>
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
                            <form id="unit_update_form" name="unit_update_form" action="{{route('unidad.saveUnit')}}"
                                  enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $unidad['id'] }}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtProviene">Proviene</label>
                                            <input type="text"
                                                   class="form-control @error('txtProviene') is-invalid @enderror"
                                                   name="txtProviene" id="txtProviene"
                                                   placeholder="Proviene" required value="{{ $unidad['proviene'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtDatos') is-invalid @enderror"
                                                   name="txtDatos" id="txtDatos"
                                                   placeholder="Datos" required value="{{ $unidad['datos'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtUnidad') is-invalid @enderror"
                                                   name="txtUnidad" id="txtUnidad"
                                                   placeholder="Unidad" required value="{{  $unidad['unidad'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtMarca') is-invalid @enderror"
                                                   name="txtMarca" id="txtMarca"
                                                   placeholder="Marca" required value="{{  $unidad['marca'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtModelo') is-invalid @enderror"
                                                   name="txtModelo" id="txtModelo"
                                                   placeholder="Modelo" required value="{{ $unidad['modelo'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtAnio') is-invalid @enderror"
                                                   name="txtAnio" id="txtAnio"
                                                   placeholder="Año" required value="{{ $unidad['anio'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtDetalles') is-invalid @enderror"
                                                   name="txtDetalles" id="txtDetalles"
                                                   placeholder="Detalles" required value="{{ $unidad['detalles'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtMotor') is-invalid @enderror"
                                                   name="txtMotor" id="txtMotor"
                                                   placeholder="Motor" required value="{{ $unidad['motor'] }}">
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
                                            <input type="text"
                                                   class="form-control @error('txtObservaciones') is-invalid @enderror"
                                                   name="txtObservaciones" id="txtObservaciones"
                                                   placeholder="Observaciones" required
                                                   value="{{ $unidad['observaciones'] }}">
                                            @error('txtObservaciones')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                @if(count((array)$images))
                                    <div class="row pb-2">
                                        <div class="row justify-content-md-left">
                                            @foreach ($images as $image)
                                                @php
                                                    // Extract ID from the image link
                                                    $imageId = explode('/', $image)[0];
                                                @endphp
                                                <div class="col">
                                                    <div class="col mx-1 my-0 py-0">
                                                        <div class="row my-0 py-0">
                                                            <a href="#" class="thumbnail my-0 py-0" data-toggle="modal"
                                                               data-target="#lightbox">
                                                                <img src="<?php echo asset("storage/$image")?>"
                                                                     style="width:150px; height:150px">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="row">
                                                            <a href="#" class="delete-image mx-2"
                                                               data-image-id="{{ $imageId }}" class=" mx-1 px-1 py-1">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div id="lightbox" class="modal fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="">
                                                <button type="button" data-toggle="modal"
                                                        data-target="#multiMediaDropzoneModal"
                                                        style="width: 600px; padding:3em; border-radius: 5px; border:1px solid #cccccc ">
                                                    Subir Imagenes
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Lista de Piezas</h3>
                                    </div>

                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th># de Parte</th>
                                                <th>Nombre de la Pieza</th>
                                                <th>Precio</th>
                                                <th style="width: 40px">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($stock as $pieza)
                                                <tr>
                                                    <td>{{$pieza->id}}</td>
                                                    <td>{{$pieza->part_number}}</td>
                                                    <td>{{$pieza->part_name}}</td>
                                                    <td>$ {{number_format($pieza->selling_price, 2)}}</td>
                                                    <td><span class="badge bg-danger">Eliminar</span></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer clearfix">
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
                    <form action="{{ route('upload-media') }}" method="post" id="mediaFormMultipleDropzone"
                          class="dropzone" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input id="submit-dropzone" type="submit" name="submitDropzone" value="Upload Gallery"
                           class="btn btn-primary"/>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <style>

        #lightbox .modal-content {
            display: inline-block;
            text-align: center;
        }

        #lightbox .close {
            opacity: 1;
            color: rgb(255, 255, 255);
            background-color: rgb(25, 25, 25);
            padding: 5px 8px;
            border-radius: 30px;
            border: 2px solid rgb(255, 255, 255);
            position: absolute;
            top: -15px;
            right: -55px;

            z-index: 1032;
        }

        .thumbnail {
            display: block;
            padding: 4px;
            margin-bottom: 20px;
            line-height: 1.428571429;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            -webkit-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;

        }

        .modal-content {
            width: auto !important;
        }
    </style>
@stop

@section('js')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        console.log('Hi!');

        $('.delete-image').on('click', function (e) {
            e.preventDefault();

            const imageId = $(this).data('image-id');
            console.log(imageId);

            // Confirm before deletion (optional)
            if (confirm('Are you sure you want to delete this image?')) {
                // Send AJAX request to delete image
                $.ajax({
                    url: "{{ route('delete.image', ['id' => '__image_id__']) }}".replace('__image_id__', imageId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                    },
                    success: function (data) {
                        // Handle success, e.g., remove the image element from the DOM
                        console.log('Image deleted successfully');
                        // Remove the image element or perform any other necessary updates.
                        // Reload the page
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting image', error);
                    }
                });
            }
        });


        var $lightbox = $('#lightbox');

        $('[data-target="#lightbox"]').on('click', function (event) {
            var $img = $(this).find('img'),
                src = $img.attr('src'),
                alt = $img.attr('alt'),
                css = {
                    'maxWidth': $(window).width() - 100,
                    'maxHeight': $(window).height() - 100
                };

            $lightbox.find('.close').addClass('hidden');
            $lightbox.find('img').attr('src', src);
            $lightbox.find('img').attr('alt', alt);
            $lightbox.find('img').css(css);
        });

        $lightbox.on('shown.bs.modal', function (e) {
            var $img = $lightbox.find('img');

            // $lightbox.find('.modal-dialog').css({'width': $img.width()});
            $lightbox.find('.close').removeClass('hidden');

            $lightbox.find('.modal-dialog').css({'width': document.getElementById($img.attr('id')).naturalWidth});
            $lightbox.find('.modal-dialog').css({'max-width': '100%'});

        });

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

        myDropzone.on("addedfile", function (file) {
            // while file is drag or add in dropzone form maybe you want some other functionality
            // as per file then you can write code in this block
            //console.log(file);
        });

        myDropzone.on("removedfile", function (file) {
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

        myDropzone.on("error", function (file, response) {
            console.log(response);
        });

        // on success
        myDropzone.on("successmultiple", function (file, response) {
            // get response from successful ajax request
            // response includes what you you return from php side
            console.log('uploading files :) ');
            console.log(response);
            $.each(response, function (key, value) {
                $('form#unit_update_form').append('<input type="text" name="gallery[]" value="' + value.name + '">')
            });


            /* submit the form after images upload
            (if u want to submit rest of the inputs in the form)
            I have no other inputs so, I commented below line. */
            //document.getElementById("mediaFormMultipleDropzone").submit();
        });

        // button trigger for processingQueue
        const submitDropzone = document.getElementById("submit-dropzone");
        submitDropzone.addEventListener("click", function (e) {
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
