<?php

use Carbon\Carbon; ?>
<div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-9 mt-2">

                <div class="card direct-chat" style="height: 90vh;">
                    <div class="alert {{$colorPrio}} clearfix" data-toggle="tooltip" title="Prioridad {{$ticketEdit->prioridad}}">

                        <h6 class="float-left"><a href="{{$backUrl}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a> Ticket #{{ $ticketEdit->id }} .- {{ $ticketEdit->tema }}</h6>
                        <div class="float-right">
                            <a href="#" id="btnEditTicket"><i class="fa fa-pencil" style="color:#525659"></i></a>
                            <button class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" style="color:#525659"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" target="_blank" href="{{route('ticketDocument', $ticketEdit->id)}}">Imprimir ticket</a>
                                <a class="dropdown-item" id="btnSendMail" href="#">Enviar ticket por correo</a>
                                <a class="dropdown-item" id="btnBorrar" href="#">Borrar</a>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div id="body-messages" class="px-3" style="height:60vh; overflow-y:scroll;">

                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages">

                            @if (count($seguimientos) > 0)
                            @foreach ($seguimientos as $item)
                            <!-- Message. Default to the left -->
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix small">
                                    <div class="float-left d-flex">
                                        @if($item->photo != null)
                                        <span><img class="rounded-circle" wire:click="showFoto('{{$item->photo}}')" style="width: 30px; height: 30px; cursor:pointer" src="{{asset('storage/perfiles') .'/'. $item->photo }}" alt="message user image">
                                        </span>
                                        @else
                                        @endif
                                        <span class="direct-chat-name ml-1"><strong>{{$item->nombre_usuario.' '.$item->apellido_usuario}}</strong></span>
                                    </div>
                                    @if($item->created_at != null)
                                    <span class="direct-chat-timestamp float-right small text-muted">
                                        {{Carbon::parse($item->created_at)->format('d/m/Y h:i:s A');}}
                                    </span>
                                    @endif
                                </div>

                                @if($item->file != "")
                                <div>
                                    <div style="position: relative;">
                                        @if(explode('.',$item->file)[1] == "jpg")
                                        <span class="btnDelAdjunto" data-id="{{$item->id}}" data-file="{{$item->file}}" data-toggle="tooltip" style="position: absolute; top:0; left:0; font-size: 17px;" title="Eliminar adjunto" index="1000">

                                            <i class="fa fa-minus-circle text-danger"></i>

                                        </span>
                                        <a href="{{asset('/storage/documents').'/'. $item->file}}" target="_blank">
                                            <img class="img-thumbnail" src="{{asset('/storage/documents').'/'. $item->file}}" alt="Archivo adjunto">
                                        </a>
                                        @elseif(explode('.',$item->file)[1] == "pdf")
                                        <a href="{{asset('/storage/documents').'/'. $item->file}}" target="_blank"><i class="fa fa-file"></i> <?php echo $item->notas; ?></a>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                @else
                                @if($item->unido)
                                <div class="small alert alert-info my-2" style="white-space:pre-wrap;"><strong><?php echo $item->notas; ?></strong></div>
                                @else
                                @if($item->id_diagnostico != null)
                                <div class="small" style="white-space:pre-wrap;"><?php echo $item->notas; ?> <br><a target="_blank" href="{{ route('docDiagnostico', $item->id_diagnostico)}}">Diagnóstico {{$item->id_diagnostico}}</a></div>
                                @else
                                <div class="small" style="white-space:pre-wrap;"><?php echo $item->notas; ?></div>
                                @endif
                                @endif

                                <br>
                                <hr>
                                @endif
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->

                            @endforeach
                            @endif


                        </div>
                        <!--/.direct-chat-messages-->
                        <br>
                        <!-- /.direct-chat-pane -->
                    </div>
                    <!-- /.card-body -->


                    <div class="align-items-center">

                        <div wire:ignore>
                            <div name="message" id="message" wire:model="message"></div>
                        </div>

                        <div class="float-left">
                                    <span style="font-size: 12px" wire:loading wire:target='archivoAdjunto'>
                                    <img src="{{asset('img')}}/loading.gif" alt="cargando..." style="height: 25px; width:25px;"> Cargando...
                        </span>

                        <!-- Mostrar archivos -->
                        @if($archivoAdjunto)
                        @foreach($archivoAdjunto as $item => $value)
                        @if($value != null)
                        <span class="badge" style="color:#012E69;"><strong>{{$value->getClientOriginalName()}}</strong>
                            <span style="cursor: pointer;" class="text-secondary" title="Eliminar archivo" wire:click="clearAtt({{$item}})"><i class="fa fa-times"></i></span>
                        </span>
                        @endif
                        @endforeach
                        @endif
                        @error('archivoAdjunto.*')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <br>

                    <div class=" m-2 d-flex align-items-end">

                        <div class="mr-2" style="width: 92%;">
                            <label for="plantilla"><strong> Plantillas</strong>
                                <span class="badge" style="cursor:pointer;" id="btnShowAddPlantilla" title="Agregar plantilla" data-toggle="tooltip"><i class="fa fa-plus-circle text-info" style="font-size:16px"></i></span></label>
                            <select name="plantilla" id="plantilla" class="form-control" wire:change="pastePlantilla" wire:model.live="plantilla">
                                <option value="">---Selecciona una opción---</option>
                                @foreach($plantillas as $item)
                                <option title="{{strip_tags($item->descripcion)}}" value="{{$item->descripcion}}" data-toggle="tooltip">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" wire:click="storeNotas">Enviar</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false"></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" wire:click.prevent="closeAndSend('Abierto')"><span><i class="fa fa-circle" style="color: #00BDC6;"></i></span> Enviar como Abierto</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="closeAndSend('Pendiente')"><span><i class="fa fa-circle" style="color: #CCD5E1"></i></span> Enviar como Pendiente</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="closeAndSend('Cerrado')"><span><i class="fa fa-circle" style="color:#212529"></i></span> Enviar como Cerrado</a>
                            </div>
                        </div>

                    </div>



                    <input type='file' class='d-none' name='archivoAdjunto' id='archivoAdjunto' wire:model='archivoAdjunto' multiple>


                </div>

                <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
        </div>


        <div class="col-lg-3 shadow p-0">
            <!-- Formulario para editar -->
            <div>
                <div style="height:94vh;" class="py-5 px-4 overflow-auto">
                    <div wire:init="$set('readyToLoad', true)">
                        @if($readyToLoad)

                        <div class="d-flex flex-column">
                            <label for="quien_reporta"><strong> Usuario </strong></label>
                            <input type="text" name="quien_reporta" id="quien_reporta" wire:model="quien_reporta" class="form-control field">
                            @error('quien_reporta')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex flex-column">
                            <label for="telefono"><strong> Teléfono </strong></label>
                            <input type="tel" name="telefono" id="telefono" wire:model="telefono" class="form-control field">
                            @error('telefono')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex flex-column">
                            <label for="edificio"><strong> Centro de trabajo </strong></label>
                            <select class="form-control field" name="edificio" id="edificio" wire:model="edificio">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($edificios as $item)
                                <option>{{Str::upper($item->nombre)}}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" name="edificio" id="edificio" wire:model="edificio" class="form-control"> -->
                        </div>

                        <div class="d-flex flex-column">
                            <label for="departamento"><strong>Departamento</strong></label>
                            <select class="form-control field" name="departamento" id="departamento" wire:model="departamento">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($departamentos as $item)
                                <option>{{Str::upper($item->nombre)}}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" name="departamento" id="departamento" wire:model="departamento" class="form-control"> -->
                            @error('departamento')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="d-flex flex-column">
                            <label for="usuario_red"><strong>Usuario de red</strong></label>
                            <input type="text" name="usuario_red" id="usuario_red" wire:model="usuario_red" class="form-control field">
                        </div>
                        <div class="d-flex flex-column">
                            <label for="ip"><strong>IP</strong></label>
                            <input type="text" name="ip" id="ip" wire:model="ip" class="form-control field">
                            @error('ip')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex flex-column">
                            <label for="autoriza"><strong>Autoriza</strong></label>
                            <input type="text" name="autoriza" id="autoriza" wire:model="autoriza" class="form-control field">
                        </div>

                        <div class="d-flex flex-column">
                            <label for="categoria"><strong>Categoría</strong></label>
                            <select type="text" name="categoria" id="categoria" wire:model="categoria" class="form-control field">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($categorias as $item)
                                <option>
                                    {{ Str::upper($item->name) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-column">
                            <label for="asignado"><strong>Asignar a</strong></label>
                            <select name="asignado" id="asignado" wire:model="asignado" class="form-control field">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($usuarios as $item)
                                <option value="{{ $item->id }}">{{ $item->name .' '. $item->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-column">
                            <label for="prioridad"><strong>Prioridad</strong></label>
                            <select name="prioridad" id="prioridad" wire:model="prioridad" class="form-control field">
                                <option>Baja</option>
                                <option>Media</option>
                                <option>Alta</option>
                            </select>
                        </div>

                        <div>
                            <label for="fecha_de_atencion"><strong>Fecha de atención</strong></label>
                            <input type="date" class="form-control field-date" wire:model="fecha_de_atencion">
                        </div>

                        <div>
                            <label for="unidad"><strong>Unidad</strong></label>
                            <select name="unidad" id="unidad" class="form-control field" wire:model.live="unidad">
                                <option value=""> ---Selecciona una opción ---</option>
                                <option>1181 [F-150] </option>
                                <option>1917 [Hilux] </option>
                                <option>0992 [Ranger] </option>
                            </select>
                        </div>

                        @else
                        <div class="d-flex align-items-center" style="padding:10px;">
                            <div class="spinner-border text-info" role="status"></div>&nbsp;&nbsp;
                            <div> Cargando información...</div>
                        </div>
                        @endif
                    </div>
                </div>


            </div>

        </div>
        {{-- ./formulario para editar ticket --}}
    </div>





    <!-- Modal enviar correo -->
    <div class="modal fade" id="modalSendMail" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Enviar ticket por correo electrónico</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session('correoNoEnviado'))
                    <div class="alert alert-danger alert-dismissible text-center">
                        <i class="fa fa-exclamation-circle"></i> <strong>Ups!, algo salió mal. </strong>{{ session('correoNoEnviado') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="mb-2">
                        <input type="text" name="para" id="para" wire:model="para" class="form-control" placeholder="Para" data-toggle="tooltip" title="Ingresa la lista de destinatarios separados por comas (,)" data-placement="left">
                        @error('para')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <label for="mensaje">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" rows="10" class="form-control" wire:model="mensaje"></textarea>

                </div>
                <div class="modal-footer">
                    <div wire:loading.remove>
                        <button type="button" class="btn btn-primary" wire:click="sendByMail"><i class="fa fa-paper-plane"></i> Enviar</button>
                    </div>
                    <div wire:loading wire:target="sendByMail">
                        <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Enviando correo...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal enviar correo -->

    <!-- Modal ver foto de usuario-->
    <div class="modal" id="modalShowFoto">
        <div class="modal-dialog modal-xl d-flex align-items-center justify-content-center" role="document" style="height: 85vh;">
            <img src="{{ asset('storage/perfiles').'/'. $photoShow }}" class="img-thumbnail" style="height:500px; width:500px">
        </div>
    </div>

    <!-- Modal para agregar plantilla -->
    <div class="modal fade" id="modalAddPlantilla" data-backdrop="static" data-keyboard="false" wire:ignore.self>

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar plantilla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <label for="nombreDePlantilla">Nombre</label>
                    <input type="text" id="nombreDePlantilla" name="nombreDePlantilla" class="form-control" wire:model="nombreDePlantilla">
                    @error('complete')
                    <small class="text-danger">{{$message}}</small>
                    @enderror

                    <div wire:ignore>
                        <label for="descripcionDePlantilla">Descripción</label>
                        <textarea name="descripcionDePlantilla" id="descripcionDePlantilla" class="form-control" wire:model="descrpcionDePlantilla"></textarea>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="storePlantilla">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar el tema y la descripcion del ticket-->
    <div class="modal fade" id="modalEditTicket" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div>
                        <label for="tema">Tema</label>
                        <input type="text" class="form-control" id="temaTicket" name="temaTicket" wire:model="tema">
                        @error('tema')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div wire:ignore>
                        <label for="descripcion">Descripción</label>
                        <textarea type="text" class="form-control" id="descrTicket" name="descrTicket" wire:model="descripcion"></textarea>
                        @error('descripcion')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="updateTema    ">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script>
        var scrolltop;

        $(document).ready(function() {

            var offsetHeight = document.getElementById('body-messages').scrollHeight;
            document.getElementById("body-messages").scrollTop = offsetHeight
            scrolltop = document.getElementById("body-messages").scrollTop

            $('#message').summernote({
                height: 100,
                disableDragAndDrop: true,
                callbacks: {
                    onBlur: function() {
                        var content = $(".note-editable").html()
                        @this.set('message', content)
                    }
                }
            });


            $('#descripcionDePlantilla').summernote({
                height: 200,
                disableDragAndDrop: true,
                callbacks: {
                    onBlur: function() {
                        var content = $(".note-editable:eq(1)").html() //seleccionar el segundo elemento de note-editable
                        @this.set('descripcionDePlantilla', content)
                    }
                }

            });

            $('#descrTicket').summernote({
                height: 200,
                disableDragAndDrop: true,
                callbacks: {
                    onBlur: function() {
                        var content = $(".note-editable:eq(2)").html() //seleccionar el tercer elemento de note-editable
                        @this.set('descripcion', content)
                    }
                }

            });


            //agregamos boton personalizado para hacer attachment si es que no se ha agregado antes (esto por que el DOM se rendereiza en cada cambio)
            $(".note-toolbar:eq(0).card-header").append("<div class='note-btn-group btn-group'><label for='archivoAdjunto' style='cursor: pointer; margin-top:7px;' title='Adjuntar archivo' data-toggle='tooltip' data-placement='bottom'><span class='note-btn btn btn-light btn-sm contentAttachment' tabindex='-1' title='' data-original-title='Full Screen'><i class='fa fa-paperclip'></i></span></label></div>");


            $(document).on('clearSummerEditor', function() {
                $(".note-editable:eq(1)").html('')
            })




        })

        $('#body-messages').scroll(function() {
            if (document.getElementById("body-messages").scrollTop < scrolltop) {

                $("#btnScrollingBottom").removeClass('d-none')

            } else {

                $("#btnScrollingBottom").addClass('d-none')
            }
        })

        document.addEventListener('scrollingBottom', function() {

            var offsetHeight = document.getElementById('body-messages').scrollHeight;

            document.getElementById("body-messages").scrollTop = offsetHeight

            scrolltop = document.getElementById("body-messages").scrollTop

            //reset editor de nota
            $('#message').summernote('reset')
            $(".note-toolbar:eq(0).card-header").append("<div class='note-btn-group btn-group'><label for='archivoAdjunto' style='cursor: pointer; margin-top:7px;' title='Adjuntar archivo' data-toggle='tooltip' data-placement='bottom'><span class='note-btn btn btn-light btn-sm' tabindex='-1' title='' data-original-title='Full Screen'><i class='fa fa-paperclip'></i></span></label></div>");

        })

        $(document).on('click', '#btnScrollingBottom', function() {
            var offsetHeight = document.getElementById('body-messages').scrollHeight;
            document.getElementById("body-messages").scrollTop = offsetHeight

        })

        $(document).on('sendTelegram', function(event) {
            fetch(encodeURI(`https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id=${event.detail.destino}&text=${event.detail.mensaje}`))
        })

        $(document).on('click', '.btnDelAdjunto', function() {

            if (confirm('¿Estás seguro que deseas eliminar el adjunto?')) {
                let id = $(this).data('id')
                let file = $(this).data('file')

                Livewire.emit('delAttachment', id, file)
            }
        })

        document.addEventListener('deletedAtt', function() {

            var offsetHeight = document.getElementById('body-messages').scrollHeight;
            document.getElementById("body-messages").scrollTop = offsetHeight
            scrolltop = document.getElementById("body-messages").scrollTop
        })

        $(document).on('click', '#btnSendMail', function(e) {
            e.preventDefault()
            $('#modalSendMail').modal('show')
        })

        $(document).on('showFoto', function() {
            $('#modalShowFoto').modal('show')
        })

        $(document).on('click', '#btnShowAddPlantilla', function(e) {
            e.preventDefault()
            $('#modalAddPlantilla').modal('show')
        })

        $(document).on('showMessage', function(e) {
            $(".note-editable:eq(0)").html(e.detail.msg)

        })

        $(document).on('click', '#btnEditTicket', function(e) {

            e.preventDefault()
            $('#modalEditTicket').modal('show')
        })

        $(document).on('clearModalEdit', function() {
            $('#modalEditTicket').modal('hide')
        })

        $(document).on('change', '.field', function() {
            Livewire.emit('update')
        })

        $(document).on('blur', '.field-date', function() {
            Livewire.emit('update')
        })

        $(document).on('click', '#btnBorrar', function(e) {
        
            e.preventDefault()
            if (confirm("¿Estas seguro de eliminar el ticket?")) {
                Livewire.emit('delete')
            }
        })

        $(document).on('closeModalMail', function() {
            
            $('.modal').modal('hide')
        })
    </script>
    @endpush


</div>