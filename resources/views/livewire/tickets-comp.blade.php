<?php

use Carbon\Carbon; ?>
<div>
    <style>
        @media(min-width:992px) {

            .contenedorTickets {
                
                height: 70vh;
                max-height: 70vh;
                overflow: auto;
            }

        }
    </style>
    <div class="row m-0">

        <div class="col-lg-9" style="z-index:100;">

            <!-- Carga de tickets -->
            <div wire:init="$set('readyToLoad', true)">

                @if($readyToLoad)

                <div class="order-md-1 d-flex align-items-end justify-content-between mb-1">

                    <div class="d-flex align-items-end justify-content-between">
                        <div>
                            <label for="filtro_status" class="mb-0">Status</label>
                            <select name="filtro_status" id="filtro_status" wire:model="filtro_status" class="form-control form-control-sm mr-2">
                                <option>ABIERTO</option>
                                <option>CERRADO</option>
                                <option>PENDIENTE</option>
                            </select>
                        </div>
                        <div>

                            <label for="usuario" class="mb-0">Usuario</label>
                            <select name="usuario" id="usuario" class="form-control form-control-sm" wire:model="userFilter">
                                <option value="">TODOS</option>
                                <option value="0">SIN ASIGNAR</option>
                                @foreach($usuarios as $item)
                                <option value="{{$item->id}}">{{$item->name.' '. $item->lastname}}</option>
                                @endforeach
                            </select>

                        </div>

                    </div>

                    <div class="d-flex align-items-end">

                        <input type="search" id="search" name="search" wire:model="search" class="form-control form-control-sm mr-2" placeholder="Buscar...">
                        <button id="btn-nuevo-ticket" style="width:150px;" class="btn btn-primary btn-sm order-md-2"><i class="fa fa-plus"></i> Nuevo</button>

                    </div>

                </div>

                <!-- Tickets -->
                @if(count($tickets) > 0)
                <hr>

                <div class="small" style="color:#012E69"><i><strong> {{count($totalTickets)}} TICKETS {{$filtro_status}}S</strong></i></div>

                <div class="card contenedorTickets" id="card-tickets">

                    <div class="alert d-flex py-2 m-0" style="font-size:12px; color:#FFF; background-color:#012E69">
                        <table>
                            <tr>
                                <td style="width:77px; max-width:77px;"><strong>Acciones</strong></td>
                                <td style="width:80px; max-width:80px;"><strong>ID</strong></td>
                                <td style="width:80px; max-width:35px;"></td>
                                <td style="width:700px; max-width:700px;"><strong>TEMA / CATEGORIA</strong></td>
                                <td class="text-center" style="width:200px; max-width:200px;"><strong>UNIDAD</strong></td>
                                <td style="width:170px; max-width:170px;"><strong>USUARIO / EDIFICIO</strong></td>
                                <td style="width:200px; max-width:200px;"><strong>CREADO / CREADO POR</strong></td>
                                <td style="width:120px; max-width:120px;"><strong>ASIGNADO</strong></td>
                            </tr>
                        </table>
                    </div>

                    @foreach($tickets as $item)

                    <div class="alert d-flex p-0 mb-2" style="background-color: #F8F9FA; box-shadow: 1px 1px 3px gray; position: relative">

                        <table style="font-size: 12px;">
                            <tr>
                                <td style="width:7px; max-width:7px;">
                                    @switch($item->prioridad)
                                    @case('Media')
                                    <span class="h-100" style="border-left: 7px solid #FFC107; left:0; top:0; position:absolute;" data-toggle="tooltip" title="Prioridad Media"></span>
                                    @break
                                    @case('Baja')
                                    <span class="h-100" style="border-left: 7px solid #28A745; left:0; top:0; position:absolute;" data-toggle="tooltip" title="Prioridad Baja"></span>
                                    @break
                                    @case('Alta')
                                    <span class="h-100" style="border-left: 7px solid #DC3545; left:0; top:0; position:absolute;" data-toggle="tooltip" title="Prioridad Alta"></span>
                                    @break
                                    @endswitch
                                </td>

                                <td style="width:69px; max-width:69px;">
                                    <button class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" wire:click.prevent="copy({{$item->id}})">Copiar</a>
                                        <a class="dropdown-item" href="#" wire:click.prevent="openModalMerge({{$item->id}})">Unir</a>
                                        <a class="dropdown-item" href="#" id="btnBorrar" data-id="{{$item->id}}">Borrar</a>
                                    </div>
                                </td>

                                <td style="width:80px; max-width:80px;"><strong>{{$item->id}}</strong></td>

                                <td>
                                    @if($item->fecha_atencion)
                                    <span title="Programada para el {{Carbon::parse($item->fecha_atencion)->format('d/m/Y')}}" data-toggle="tooltip"><i class="fa fa-calendar"></i></span>
                                    @else
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp; </span>
                                    @endif
                                </td>

                                <td style="width:700px; max-width:700px;">

                                    <a class="tooltipTicket" href="{{route('tickets.editar', $item->id)}}" style="text-decoration: none !important;"><strong>{{ $item->tema }}</strong>

                                        <!-- Información del ticket en hvoer -->
                                        <span class="tiptext">
                                            <div style="height: 10%;">
                                                @if($item->prioridad == 'Baja')
                                                <span class="badge badge-success">{{$item->prioridad}}</span>
                                                @elseif($item->prioridad == 'Media')
                                                <span class="badge badge-warning">{{$item->prioridad}}</span>
                                                @elseif($item->prioridad == '_Alta')
                                                <span class="badge badge-danger">{{$item->prioridad}}</span>
                                                @endif
                                                <strong># {{$item->id}} .- {{$item->tema}}</strong>
                                            </div>
                                            <hr>
                                            <div style="max-height: 65%;">
                                                <?php echo str_replace(['style', '<li>', '</li>'], ['', '> ', '<br>'],  $item->descripcion) ?>
                                            </div>
                                            <hr>
                                            @if($item->last_coment)
                                            <div style="height: 25%;">
                                                <i style="font-weight: 500;">ULTIMO COMENTARIO</i>
                                                <br><br>
                                                <div>
                                                    <strong>{{$item->user_coment}}</strong> .- <span class="text-muted">{{Carbon::parse($item->date_coment)->format('d/m/Y H:i:s')}}</span><br>
                                                    <?php echo str_replace(['style', '<li>', '</li>'], ['', '> ', '<br>'], $item->last_coment) ?>
                                                </div>
                                            </div>
                                            @endif
                                        </span>
                                        <!-- ./informacion del ticket en hover -->

                                    </a>
                                    <br>
                                    <span>{{$item->categoria}}</span>

                                </td>

                                <td style="width:200px; max-width:200px;">
                                    {{$item->unidad}}
                                </td>

                                <td style="width:170px; max-width:170px;">
                                    <strong>{{ Str::upper($item->reporta) }}</strong>
                                    <br>
                                    {{$item->edificio}}
                                </td>

                                <td style="width:200px; max-width:200px;">
                                    <span><strong> {{ Carbon::parse($item->created_at)->diffForHumans() }}</strong></span>
                                    <br>
                                    {{$item->creador}}
                                </td>

                                <td style="width: 120px; max-width:120px">
                                    @if($item->asignado)

                                    @if($item->photo)
                                    <img src="{{asset('storage/perfiles').'/'.$item->photo}}" alt="Foto" style="height: 35px; border-radius:50px" data-toggle="tooltip" title="{{$item->asignadoName.' '.$item->asignadoLastname}}">
                                    @else
                                    <div style="height: 35px; width:35px;" class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" data-toggle="tooltip" title="{{$item->asignadoName.' '.$item->asignadoLastname}}"><strong>{{substr($item->asignadoName, 0, 1) . substr($item->asignadoLastname, 0, 1)}}</strong></div>
                                    {{-- <img src="{{asset('img/user.png')}}" alt="Foto" style="height: 35px; border-radius:50px" data-toggle="tooltip" title="{{$item->asignado}}" > --}}
                                    @endif

                                    @else
                                    <span><strong>NO ASIGNADO</strong></span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                    </div>

                    @endforeach

                </div>

                <div class="mt-2">

                    <div>{{ $tickets->links() }}</div>

                </div>

                @else

                <div class="d-flex align-items-end justify-content-between mt-3">
                    <h6 class="text-dark">NO SE ENCONTRARON TICKETS</h6>
                </div>

                @endif

                @else

                <div class="d-flex align-items-center" style="padding: 10px;">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    &nbsp;&nbsp;
                    <div>Cargando información...</div>
                </div>

                @endif

            </div>

        </div>

        <!-- Gráficas y actividades -->
        <div class="col-lg-3 p-3 overflow-auto shadow" style="height: 94vh; border:1px solid #DEE2E6; background-color: #F8F9FA;">

            @can('Mostrar todos los tickets')
            <div class="bg-white" m-0>

                <livewire:charts></livewire:charts>

            </div>
            @endcan

            <br><br>

            @if($actividades)

            <h6>ACTIVIDADES</h6>

            <div class="list-group">
                @foreach($actividades as $item)

                <li class="list-group-item clearfix">
                    <span class="float-left">{{$item->descripcion}}</span>
                    <span class="float-right badge badge-primary">{{Carbon::parse($item->fecha)->format('d/m/Y')}}</span>
                </li>

                @endforeach
            </div>

            @else

            <h6>NO HAY ACTIVIDADES</h6>

            @endif

        </div>

    </div>




    <!-- Modal para nuevos tickets -->
    <div id="mod-nuevo-ticket" class="modal" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo ticket</h5>
                    <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column">
                        <label for="tema">Tema <span><strong>*</strong></span></label>
                        <input type="text" name="tema" id="tema" wire:model.defer="tema" class="form-control" placeholder="Obligatorio (100 caracteres máximo)" maxlength="100">
                        @error('tema')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <label for="descripcion">Descripción <span><strong>*</strong></span></label>
                    <div wire:ignore>
                        <textarea name="descripcion" id="descripcion" wire:model.defer="descripcion"></textarea>
                    </div>
                    @error('descripcion')
                    <small class="text-danger">{{$message}}</small>
                    @enderror

                    <!-- Input para subir archivos -->
                    <input type="file" name="attach" id="attach" wire:model.defer="attachment" multiple class="form-control d-none">


                    <!-- <a data-toggle="collapse" href="#collapseFields"> Mostrar más campos...</a> -->

                    <!-- <div class="collapse" id="collapseFields" wire:ignore.self> -->

                    <div class="d-flex flex-column">
                        <label for="quien_reporta">Usuario</label>
                        <input type="text" name="quien_reporta" id="quien_reporta" wire:model.defer="quien_reporta" class="form-control">
                        @error('quien_reporta')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="d-flex flex-column">
                        <label for="telefono">Teléfono / EXT</label>
                        <input type="tel" name="telefono" id="telefono" wire:model.defer="telefono" class="form-control">
                        @error('telefono')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex flex-column">
                        <label for="edificio">Edificio</label>
                        <select class="form-control" name="edificio" id="edificio" wire:model.defer="edificio">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($edificios as $item)
                            <option>{{Str::upper($item->nombre)}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="edificio" id="edificio" wire:model="edificio" class="form-control"> -->
                    </div>

                    <div class="d-flex flex-column">
                        <label for="departamento">Departamento</label>
                        <select class="form-control" name="departamento" id="departamento" wire:model.defer="departamento">
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
                        <label for="usuario_red">Usuario de red</label>
                        <input type="text" name="usuario_red" id="usuario_red" wire:model.defer="usuario_red" class="form-control">
                    </div>
                    <div class="d-flex flex-column">
                        <label for="ip">IP</label>
                        <input type="text" name="ip" id="ip" wire:model.defer="ip" class="form-control">
                        @error('ip')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                    <div class="d-flex flex-column">
                        <label for="autoriza">Autoriza</label>
                        <input type="text" name="autoriza" id="autoriza" wire:model.defer="autoriza" class="form-control">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="categoria">Categoría</label>
                        <select type="text" name="categoria" id="categoria" wire:model.defer="categoria" class="form-control">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($categorias as $item)
                            <option>
                                {{ Str::upper($item->name)}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column">
                        <label for="asignado">Asignar a</label>
                        <select name="asignado" id="asignado" wire:model.defer="asignado" class="form-control">
                            <option value=""> ---Selecciona una opción--- </option>
                            @foreach ($usuarios as $item)
                            <option value="{{ $item->id }}">{{ $item->name . ' ' . $item->lastname }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad" wire:model.defer="prioridad" class="form-control">
                            <option>Baja</option>
                            <option>Media</option>
                            <option>Alta</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_de_atencion">Fecha de atención</label>
                        <input type="date" class="form-control" wire:model.defer="fecha_de_atencion">
                    </div>

                    @error('attachment.*')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <!-- </div> -->

                </div>

                <div class="modal-footer d-flex align-items-center justify-content-between">
                    <div>
                        <div wire:loading wire:target="attachment">
                            <p style="font-size: 11px"><img style="height: 20px; width:20px;" src="{{ asset('img') }}/loading.gif" alt="cargando..."> Cargando...</p>
                        </div>

                        @if($attachment)
                        @foreach($attachment as $item => $value)
                        @if($value != null)
                        <span class="badge">
                            {{$value->getClientOriginalName()}} &nbsp; <span wire:click="delFile({{$item}})" style="cursor:pointer"><i class="fa fa-times"></i></span>
                        </span>
                        @endif
                        @endforeach
                        @endif
                    </div>

                    <div>
                        <div wire:loading.remove wire:target="store">
                            <button class="btn btn-primary mt-2" wire:click="store">Guardar</button>
                        </div>

                        <div wire:loading wire:target="store">
                            <button class="btn btn-primary btn-block mt-2" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Procesando...
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Modal  para hacer merge con otro ticket-->
    <div class="modal" id="modalMerge" wire:ignore.self>
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unir ticket #{{$ticketMerge1}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="buscaTicketMerge" placeholder="# de ticket que deseas unir" list="optionsMerge" autocomplete="off" wire:model.defer="ticketUnir">
                    <datalist id="optionsMerge">
                        @foreach($ticketsToMerge as $item)
                        <option value="{{$item->id}}">{{$item->tema}} [{{$item->status}}]</option>
                        @endforeach
                    </datalist>
                    @error('ticketUnir')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                    @error('noExiste')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="mergeTicket" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '#btn-nuevo-ticket', function() {
                $(".note-editable").html('')
                $('#mod-nuevo-ticket').modal('show')
                setTimeout(() => {
                    $("#tema").focus()
                }, 200);
            })

            $(document).on('copied', function(e) {

                let descr = e.detail.descripcion
                $(".note-editable").html(descr)
                $('#mod-nuevo-ticket').modal('show')

            })

            $(document).on('click', '.btnClose', function() {
                $('#mod-nuevo-ticket').modal('hide')
            })


            $('#descripcion').summernote({
                height: 200,
                disableDragAndDrop: true,
                callbacks: {
                    onBlur: function() {
                        var content = $(".note-editable").html()
                        @this.set('descripcion', content)
                    }
                }
            });


            //agregamos botones personalizados
            $(".note-toolbar.card-header").append("<div class='note-btn-group btn-group'><label for='attach' style='cursor: pointer; margin-top:7px;' title='Adjuntar archivo' data-toggle='tooltip' data-placement='bottom'><span class='note-btn btn btn-light btn-sm' tabindex='-1' title='' data-original-title='Full Screen'><i class='fa fa-paperclip'></i></span></label></div>");

        })

        document.addEventListener('closeModal', function() {
            $('#mod-nuevo-ticket').modal('hide')
        })

        $('#mod-nuevo-ticket').on('hidden.bs.modal', function() {
            Livewire.emit('restore')
        })

        $(document).on('reload', function() {
            window.location.reload()
        })

        $(document).on('sendTelegram', function(event) {
            fetch(encodeURI(`https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id=${event.detail.destino}&text=${event.detail.mensaje}`))
        })

        $(document).on('openModalMerge', function() {
            setTimeout(() => {
                $('#buscaTicketMerge').focus()
            }, 100);

            $('#modalMerge').modal('show')
        })

        $(document).on('click', '#btnBorrar', function(e) {
            e.preventDefault()
            let id = $(this).data('id')
            if (confirm("¿Estas seguro de eliminar el ticket?")) {
                Livewire.emit('delete', id)
            }
        })

        $(document).on('disabledFiltro', function() {

            $('#usuario').attr('disabled', 'disabled')
        })
    </script>

    @endpush


</div>
</div>