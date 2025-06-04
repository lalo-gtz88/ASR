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

        @media (max-width: 768px) {

            .ticket-header,
            .ticket-row {
                flex-direction: column;
                align-items: start !important;
            }

            .ticket-row>div {
                width: 100% !important;
                margin-bottom: 5px;
            }

            .ticket-header>div {
                width: 100% !important;
                font-weight: bold;
                border-bottom: 1px solid #ddd;
                padding-bottom: 4px;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Filtros -->
        <div class="row mb-3 g-2">
            <div class="col-md-3">
                <label for="fst" class="form-label">Status</label>
                <select name="fst" id="fst" wire:model.live="fst" class="form-select">
                    <option>ABIERTO</option>
                    <option>CERRADO</option>
                    <option>PENDIENTE</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="usuario" class="form-label">Técnico asignado</label>
                <select name="usuario" id="usuario" class="form-select" @can(!'Mostrar todos los ticiket') disabled @endcan wire:model.live="fu">
                    <option value="">TODOS</option>
                    <option value="0">SIN ASIGNAR</option>
                    @foreach($tecnicos as $item)
                    <option value="{{$item->id}}">{{$item->name.' '.$item->lastname}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <div class="input-group">
                    <select wire:model.live="fs" id="fs" class="form-select">
                        <option value="id">ID</option>
                        <option value="tema">Tema</option>
                        <option value="descripcion">Descripción</option>
                        <option value="categoria">Categoría</option>
                        <option value="reporta">Usuario</option>
                        <option value="edificio">Edificio</option>
                        <option value="unidad">Unidad</option>
                    </select>
                    <input type="search" id="search" wire:model.live="search" class="form-control" placeholder="Buscar...">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{route('nuevoTicket')}}" class="btn btn-primary w-100">
                    <i class="fa fa-plus"></i> Nuevo
                </a>
            </div>
        </div>

        <hr>

        <!-- Lista de Tickets -->
        @if(count($tickets) > 0)
        <div class="bg-light p-2 border rounded mb-2 sticky-top">
            <div class="row ticket-header">
                <div class="col-md-1">Asignado</div>
                <div class="col-md-1">ID</div>
                <div class="col-md-1">Creado</div>
                <div class="col-md-2">Tema</div>
                <div class="col-md-1 text-center">F. de atención</div>
                <div class="col-md-1">Categoría</div>
                <div class="col-md-1">Prioridad</div>
                <div class="col-md-2">Usuario</div>
                <div class="col-md-1">Edificio</div>
                <div class="col-md-1 text-center">Acciones</div>
            </div>
        </div>

        <div id="content-tickets" style="height:65vh; overflow:auto;">
            @foreach($tickets as $key => $value)
            <div class="row ticket-row mb-2 bg-white border rounded shadow-sm p-2">
                <!-- Asignado -->
                <div class="col-md-1">
                    @if($value->asignado != 0)
                    <div class="dropdown">
                        <span class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer; ">
                            @if($value->tecnico->photo != null)
                            <img class="rounded-circle me-1" src="{{asset('storage/perfiles/')}}/{{$value->tecnico->photo }}" alt="Perfil" style="height:30px; width:30px">
                            @else
                            <img class="rounded-circle me-1" src="{{asset('img/user.png')}}" alt="Perfil" style="height:30px; width:30px">
                            @endif
                            {{$value->tecnico->name}}<br>{{$value->tecnico->lastname}}
                        </span>
                        <div class="dropdown-menu">
                            @foreach($tecnicos as $tecnico)
                            <a class="dropdown-item" href="#" wire:click.prevent="asignar({{$value->id}}, {{$tecnico->id}})">{{$tecnico->name}} {{$tecnico->lastname}}</a>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            Asignar
                        </button>
                        <div class="dropdown-menu">
                            @foreach($tecnicos as $tecnico)
                            <a class="dropdown-item" href="#" wire:click.prevent="asignar({{$value->id}}, {{$tecnico->id}})">{{$tecnico->name}} {{$tecnico->lastname}}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- ID -->
                <div class="col-md-1">{{$value->id}}</div>

                <!-- Fecha de creacion -->
                <div class="col-md-1">
                    {{Carbon\Carbon::parse($value->created_at)->format('d-M-Y')}} <br>
                    <span class="text-muted">{{Carbon\Carbon::parse($value->created_at)->format('H:i a')}}</span>
                </div>

                <!-- Tema -->
                <div class="col-md-2">
                    <a href="{{route('editarTicket', $value->id)}}" class="linkticket text-dark">{{$value->tema}}</a>
                    <div class="tipticket shadow border rounded p-2 position-absolute bg-white" style="z-index:1000;">
                        <h6 class="mt-2">
                            <span class="badge bg-{{$value->colorPrioridad}}">{{$value->prioridad}}</span> #{{$value->id}} - {{$value->tema}}
                        </h6>
                        <hr>
                        <p><?php echo strip_tags($value->descripcion) ?></p>
                        <hr>
                        @if(count($value->seguimientos) > 0)
                        <p><strong>ULTIMO COMENTARIO</strong> <br><i>{{Carbon\Carbon::parse($value->seguimientos->last()->created_at)->format('d/m/Y h:i:s')}}</i></p>
                        <p>{{strip_tags($value->seguimientos->last()->notas)}}</p>
                        @endif
                    </div>
                </div>

                <!-- Fecha de atención -->
                <div class="col-md-1 text-center">
                    @if($value->fecha_atencion)
                    <h5><span class="badge bg-info text-dark"> {{Carbon\Carbon::parse($value->fecha_atencion)->format('d-M-Y')}}</span></h5>
                    @else
                    ---
                    @endif
                </div>

                <!-- Categoria -->
                <div class="col-md-1">{{$value->categoria}}</div>

                <!-- Prioridad -->
                <div class="col-md-1">
                    <h5><span class="badge bg-{{$value->colorPrioridad}} ">{{$value->prioridad}}</span></h5>
                </div>

                <!-- Usuario Reporta -->
                <div class="col-md-2">{{ $value->reporta }}</div>

                <!-- Edificio -->
                <div class="col-md-1">{{$value->edificio}}</div>


                <div class="dropdown col-md-1 text-center">
                    <button class="btn btn-link" data-bs-toggle="dropdown">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" wire:click.prevent="$dispatchTo('edit-ticket','editar', {id: {{ $value->id }} })"><i class="fa fa-edit"></i> Editar</a>
                        <a class="dropdown-item" href="{{route('copyTicket',$value->id)}}"><i class="fa fa-copy"></i> Copiar</a>
                        <a class="dropdown-item" href="#" wire:click.prevent="delete({{$value->id}})"><i class="fa fa-trash"></i> Borrar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-2">
            {{$tickets->links()}}
        </div>

        @else
        <p class="text-muted"><i class="fa fa-exclamation-circle text-primary"></i> <strong>No se encontrarón tickets</strong></p>
        @endif

        <!-- Modales -->
        <livewire:edit-ticket />

    </div>

    @push('custom-scripts')
    <script>
        document.addEventListener('disabledFiltro', function() {

            document.querySelector('#usuario').disabled = true
        })
    </script>

    @endpush
</div>