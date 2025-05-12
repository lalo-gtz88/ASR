<div>
    <?php

    use Carbon\Carbon; ?>
    <style>
        .tooltip-inner {
            white-space: pre-wrap;
        }
    </style>

    <div class="container mt-2">
        <div class="clearfix mb-2">
            <h4 class="float-left">Actividades</h4>
            @can('Creacion de actividades')
            <div class="float-right"><button id="btnNuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</button></div>
            @endcan
        </div>

        @if(count($listaActividades)>0)
        <ul class="list-group">
            @foreach($listaActividades as $item)
            @if($item->status)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center" style="font-size: 18px;">
                    @can('Creacion de actividades')<span wire:click="checkUnckeck({{$item->id}},0)"><i class="fa fa-circle-o text-info mr-2" style="cursor:pointer; font-size:28px;"></i>@endcan
                    </span><a href="#" wire:click.prevent="showMiembros({{$item->id}})">{{$item->descripcion}}</a>
                </div>
                <div>
                    @if($item->fecha != null)
                    <span class="badge badge-info" data-toggle="tooltip" title="Programada para el día {{Carbon::parse($item->fecha)->format('d-m-Y')}}">{{Carbon::parse($item->fecha)->format('d-m-Y') }}</span>
                    @endif

                    <button class="btn text-secondary" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="btnBorrar" data-id="{{$item->id}}">Borrar</a>
                    </div>
                </div>
            </li>
            @else($item->status)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div wire:click.prevent="checkUnckeck({{$item->id}},1)" class="d-flex flex-row align-items-center" style="font-size: 18px;">
                    @can('Creacion de actividades')<span wire:click="checkUnckeck({{$item->id}},1)"><i class="fa fa-check-circle-o text-primary mr-2" style="cursor:pointer; font-size:28px;"></i>@endcan
                    </span><del>{{$item->descripcion}}</del>
                </div>
                @if($item->fecha != null)
                <span class="badge badge-secondary"><del>{{Carbon::parse($item->fecha)->format('d-m-Y') }}</del></span>
                @endif

            </li>
            @endif

            @endforeach
        </ul>

        @else
        <h5>NO HAY ACTIVIDADES PENDIENTES</h5>
        @endif

        @if($showLimpiarList)
        <button class="btn btn-light mt-2" wire:click="delTodos"><i class="fa fa-eraser"></i> Limpiar</button>
        @endif

    </div>


    <!-- Modal para nueva actividad -->
    <div class="modal fade" id="modalNueva" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @can('Creacion de actividades')
                    <div>
                        <label for="descripcion"><strong>Nueva actividad</strong></label>
                        <input type="text" id="descripcion" wire:model="descripcion" class="form-control" autofocus placeholder="Describe aquí la actividad que deseas registrar...">
                        @error('descripcion')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3">
                            <label for="fecha"><strong>Fecha</strong></label>
                            <input type="date" id="fecha" wire:model="fecha" class="form-control">
                            @error('fecha')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <strong>Seleecciona los usuarios que deseas involucrar en esta actividad</strong>

                    @foreach($usuarios as $user)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="usuariosAdd" value="{{$user->id}}" id="chk{{$user->id}}">
                        <label class="form-check-label" for="chk{{$user->id}}">
                            {{$user->name .' '.$user->lastname}}
                        </label>
                    </div>
                    @endforeach

                    @endcan

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" wire:click="store()"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--  -->


    <!-- Modal para ver los miembros de la actividad -->
    <div class="modal" id="modalMiembros" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalTitleId">{{Str::upper($actividadSelect)}}</h5>
                    <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Miembros involucrados en esta actividad</strong><br>
                    <ul>
                        @foreach($miembros as $miembro)
                        <li>{{$miembro->nombre}}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!--  -->

    @push('custom-scripts')
    <script>
        $(document).on('cerrarModal', function() {
            $('#modalNueva').modal('hide')
        })
        $(document).on('showMembers', function() {
            $('#modalMiembros').modal('show')
        })
        $(document).on('click', '#btnNuevo', function() {
            $('#modalNueva').modal('show')
        })
        $(document).on('click', '#btnBorrar', function(e) {
            e.preventDefault()
            let id = $(this).data('id')
            if (confirm("¿Estas seguro de eliminar la actividad?")) {
                Livewire.emit('delete', id)
            }
        })
    </script>
    @endpush
</div>