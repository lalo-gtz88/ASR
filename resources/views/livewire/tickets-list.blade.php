<div>

    <style>
        .tipticket {
            display: none;
        }

        a.linkticket:hover {
            font-size: 14px;
        }

        a.linkticket:hover+div {
            display: block;
        }
    </style>

    <div>
        <!-- Botones de busqueda y filtros -->
        <div class="d-flex align-items-end justify-content-between mb-2">

            <div class="d-flex align-items-end justify-content-between">

                <div>
                    <label for="fst" class="mb-0">Status</label>
                    <select name="fst" id="fst" wire:model.live="fst" class="form-control form-control-sm mr-2">
                        <option>ABIERTO</option>
                        <option>CERRADO</option>
                        <option>PENDIENTE</option>
                    </select>
                </div>

                <div>

                    <label for="usuario" class="mb-0">Técnico asignado</label>
                    <select name="usuario" id="usuario" class="form-control form-control-sm" wire:model.live="fu">
                        <option value="">TODOS</option>
                        <option value="0">SIN ASIGNAR</option>
                        @foreach($tecnicos as $item)
                        <option value="{{$item->id}}">{{$item->name.' '.$item->lastname}}</option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="d-flex align-items-center"
                style="width:20%">
                <div class="input-group">
                    <select wire:model.live="fs" id="fs" class="form-control form-control-sm">
                        <option value="id">ID</option>
                        <option value="tema">Tema</option>
                        <option value="descripcion">Descripción</option>
                        <option value="categoria">Categoría</option>
                        <option value="reporta">Usuario</option>
                        <option value="edificio">Edificio</option>
                        <option value="unidad">Unidad</option>
                    </select>
                    <input type="search" id="search" wire:model.live="search" class="form-control form-control-sm mr-2"
                        placeholder="Buscar...">
                </div>

                <a href="{{route('nuevoTicket')}}" id="btn-nuevo-ticket" class="btn btn-primary rounded-circle" title="Nuevo ticket class="btn btn-primary rounded-circle"><i class="fa fa-plus"></i></a>

            </div>

        </div>
        <!-- ./botones de busqueda y filtros -->



        <!-- Lista de Tickets -->
        @if(count($tickets) > 0)

        <div>
            <div class="sticky-top border border-rounded bg-light" style="padding: 7px;">
                <div class="d-flex align-items-center justify-content-start">
                    <div style="width:8%;"><strong>Asignado</strong></div>
                    <div style="width:3%;"><strong>ID</strong></div>
                    <div style="width:24%;"><strong>Tema</strong></div>
                    <div style="width:7%;"><strong>Categoría</strong></div>
                    <div style="width:9%;" class="text-center"><strong>Prioridad</strong></div>
                    <div style="width:8%;"><strong>Usuario</strong></div>
                    <div style="width:5%;"><strong>Edificio</strong></div>
                    <div style="width:10%;" class="text-center"><strong>Creado</strong></div>
                    <div style="width:10%;"><strong>Fecha de atención</strong></div>
                    <div style="width:10%;"><strong>Unidad</strong></div>
                    <div style="width:3%;" class="text-center"><strong>Acciones</strong></div>

                </div>
            </div>


            <div id="content-tickets" style="height:65vh; overflow:auto;">
                @foreach($tickets as $key => $value)
                <div class="d-flex align-items-center justify-content-start mb-2 bg-white border rounded shadow-sm" style="padding: 7px;">

                    <div style="width:8%;" class="d-flex align-items-center justify-content-start small">
                        @if($value->asignado != 0)
                        <div class="dropdown">
                            <span class="dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="cursor: pointer; font-size:11px;">
                                <img class="rounded-circle mr-1" src="{{asset('storage/perfiles/')}}/{{$value->tecnico->photo }}" alt="Perfil" style="height:30px; width:30px">
                                {{$value->tecnico->name}}<br>
                                {{$value->tecnico->lastname}}
                            </span>

                            <div class="dropdown-menu small">
                                @foreach($tecnicos as $tecnico)
                                <a class="dropdown-item" href="#" wire:click.prevent="asignar({{$value->id}}, {{$tecnico->id}})">
                                    {{$tecnico->name ." ".$tecnico->lastname}}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <button class="btn btn-outline-primary dropdown-toggle badge-pill btn-sm small" data-toggle="dropdown">
                            Asignar
                        </button>
                        <div class="dropdown-menu">
                            @foreach($tecnicos as $tecnico)
                            <a class="dropdown-item" href="#" wire:click.prevent="asignar({{$value->id}}, {{$tecnico->id}})"><i class="fa-solid fa-user"></i> {{$tecnico->name ." ".$tecnico->lastname}}</a>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div style="width:3%;">{{$value->id}}</div>

                    <div style="width:24%; position:relative;">
                        <a href="{{route('editarTicket', $value->id)}}" class="linkticket text-dark">{{$value->tema}}</a>

                        <!-- Tooltip con los datos del ticket -->
                        <div class="tipticket shadow border rounded p-2" style="position: absolute; z-index:1000; background-color:#FFF; ">
                            <h6 class="mt-2">
                                <span class="badge badge-{{$value->colorPrioridad}} badge-pill">{{$value->prioridad}}</span> #{{$value->id. '.- ' . $value->tema}}
                            </h6>
                            <hr>
                            <p style="font-weight: 400;">{{ strip_tags($value->descripcion)}}</p>
                            <hr>
                            <div>
                                @if(count($value->seguimientos) > 0)
                                <p>
                                    <strong>ULTIMO COMENTARIO</strong>
                                    <span style="font-weight:400; font-style:italic">{{Carbon\Carbon::parse($value->seguimientos->last()->created_at)->format('d/m/Y h:i:s')}}</span>
                                </p>
                                <p style="font-weight:400;">{{strip_tags($value->seguimientos->last()->notas)}}</p>
                                @endif
                            </div>
                        </div>
                        <!--  -->

                    </div>

                    

                    <div style="width:7%">{{$value->categoria}}</div>

                    <div style="width:9%;" class="text-center"><span class="badge badge-{{$value->colorPrioridad}}" badge-pill">{{$value->prioridad}}</span></div>

                    <div style="width:8%;"><?php echo str_replace(' ', "</br>", $value->reporta); ?></div>

                    <div style="width:5%;">{{$value->edificio}}</div>

                    <div style="width:10%;" class=" text-center">
                        {{$value->userCreador->name}} <br>
                        <i class="text-muted" style="font-style: italic;">{{Carbon\Carbon::parse($value->created_at)->diffForHumans()}}</i>
                    </div>
                    <div style="width:10%;">@if($value->fecha_atencion) {{Carbon\Carbon::parse($value->fecha_atencion)->format('d/m/Y')}} @endif</div>
                    <div style="width:10%;">{{$value->unidad}}</div>
                    <div style="width:3%;" class="text-center dropdown">
                        <button class="btn btn-link" data-toggle="dropdown">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu">

                            <a class="dropdown-item" href="#" wire:click.prevent="$dispatchTo('edit-ticket','editar', {id: {{ $value->id }} })"><i class="fa fa-edit"></i> Editar</a>
                            <a class="dropdown-item" href="{{route('copyTicket',$value->id)}}" ><i class="fa fa-copy"></i> Copiar</a>
                            <a class="dropdown-item" href="#" wire:click.prevent="delete({{$value->id}})" wire:confirm="Estas seguro que deseas eliminar el ticket?"><i class="fa fa-trash"></i> Borrar</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-2"></div>
        <div>{{$tickets->links()}}</div>

        @else
        <p><i class="fa fa-exclamation-circle text-primary"></i> <strong>NO SE ENCONTRARON TICKETS</strong></p>
        @endif
    </div>
    <!-- ./lista de tickets -->


    <!-- MODALES -->
    <livewire:edit-ticket />
</div>