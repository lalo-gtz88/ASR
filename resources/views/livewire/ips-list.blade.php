<div>
    <style>
        .middle td {

            vertical-align: middle;
        }
    </style>

    <div class="container-fluid">

        <h1 class="h2">Lista de IP´s</h1>

        <!-- Filtros -->
        <div class="row">
            <div class="col-md-3 mb-2">
                <select wire:model.live="segmento" id="segmento" class="form-select" wire:change="getIps()">
                    <option value=""> --- TODOS --- </option>
                    @foreach($segmentos as $key => $value)
                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-2">
                <input type="search" wire:model.live="search"
                    wire:change="getIps()" id="search" class="form-control" placeholder="Buscar...">
            </div>
            <div class="col-md-3 mb-2">
                <button class="btn btn-secondary col-12"
                    wire:click="buscarIpDisponible"><i class="fa fa-search"></i> Próxima disponible</button>
            </div>
            <div class="col-md-3 mb-2">
                <a href="{{route('catalogos.tipo', 'segmentos')}}" class="btn btn-primary col-12"><i class="fa fa-plus"></i> Nuevo segmento</a>
            </div>

        </div>
        <!-- ./filtros -->

        <!-- Lista de ips -->
        @if(count($ips) > 0 )
        <table class="table table-sm small table-hover table-bordered mt-2">
            <thead class="table-primary">
                <th>Dirección IP</th>
                <th class="text-center">Disponible</th>
                <th>Segmento</th>
                <th>Edificio</th>
                <th>Observaciones</th>
            </thead>
            <tbody>
                @foreach($ips as $key => $value)
                <tr class="middle">
                    <td><a href="#">{{long2ip($value->ip)}}</a></td>
                    <td class="text-center">
                        @if($value->icon_uso == '❌')
                        <a href="#" wire:click="liberarIp('{{long2ip($value->ip)}}')" wire:confirm="¿Liberar esta IP?" style="text-decoration: none;">
                            {{$value->icon_uso}}
                        </a>
                        @else
                        <a href="#" wire:click.prevent="showModalAsignarIp('{{long2ip($value->ip)}}')" style="text-decoration: none;">
                            {{$value->icon_uso}}
                        </a>
                        @endif
                    </td>
                    <td>{{$value->relSegmento->nombre}}</td>
                    <td>@if($value->relSegmento->relEdificio) {{ $value->relSegmento->relEdificio->nombre }} @endif</td>
                    <td>{{$value->observaciones}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $ips->links() }}
        @else
        <p class="text-muted"><i class="fa fa-exclamation-circle text-primary"></i> No hay ips registradas</p>
        @endif
        <!-- ./ lista de ips -->

    </div>



    <!-- Modal asignar ip -->
    <div
        class="modal fade"
        id="modalAsignarIp"
        data-bs-backdrop="static"
        data-bs-keyboard="false"

        role="dialog"
        aria-labelledby="modalTitleId"
        aria-hidden="true"
        wire:ignore.self>
        <div
            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Asignar IP
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="row">
                            <div class="col-12">
                                <label for="ip">Dirección IP</label>
                                <input type="text" class="form-control" wire:model="ipAsignar" readonly>
                            </div>

                            <div class="col-12">
                                <label for="buscarEquipo">Equipo</label>
                                <input type="hidden" name="" wire:model="">
                                <input type="search" name="buscarEquipo" id="buscarEquipo"
                                    class="form-control" wire:model="busEq"
                                    wire:keydown="buscarEquipo"
                                    placeholder="Buscar..."
                                    autocomplete="off"
                                    autosave="off">
                                @if(count($equipos_encontrados)>0)
                                <ul class="list-group mt-1">
                                    @foreach($equipos_encontrados as $key => $equipo)
                                    <li class="list-group-item list-group-item-action"
                                        style="cursor:pointer"
                                        wire:click="selectEquipo('{{$equipo->id}}')">
                                        {{$equipo->service_tag}}
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <a href="{{route('equipo.create', $ipAsignar)}}"
                        class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo equipo</a>
                    <button type="button"
                        wire:click="asginarIp"
                        class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        document.addEventListener('showModal', function() {
            const myModal = new bootstrap.Modal(
                document.getElementById("modalAsignarIp"),
            );
            myModal.show()
        })
    </script>
    @endpush
</div>