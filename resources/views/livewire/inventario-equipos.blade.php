<div>
    <style>

        .middle td {

            vertical-align: middle;
        }

        #btn-nuevo-equipo {

            position: absolute;
            right: 0;
            bottom: 0;
            margin-right: 25px;
            margin-bottom: 25px;
            height: 52px;
            width: 52px;
        }
    </style>

    <div class="container-fluid mt-3">
        <!-- Filtros -->
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <select wire:model.live="tipoF" id="tipoF" class="form-control" wire:change="getEquipos()">
                    <option value=""> --- TODOS --- </option>
                    @foreach($tiposF as $key => $value)
                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="d-flex align-items-end">
                    <div class="input-group input-group-sm mr-2">
                        <select wire:model.live="param" id="param" class="form-control">
                            <option value="service_tag">SERVICE TAG</option>
                            <option value="inventario">INVENTARIO</option>
                            <option value="user">NOMBRE DE USUARIO</option>
                            <option value="marca">MARCA</option>
                            <option value="modelo">MODELO</option>
                            <option value="direccion_ip">DIRECCION_IP</option>
                            <option value="direccion_mac">DIRECCION_MAC</option>
                        </select>
                        <div class="input-group-append">
                            <input type="search" wire:model.live="buscar" id="buscar" class="form-control form-control-sm" placeholder="Buscar...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./filtros -->

        <!-- Lista de equipos -->
        @if(count($equipos) > 0 )
        <table class="table table-sm small table-hover table-bordered mt-2">
            <thead>
                <th></th>
                <th>Service Tag</th>
                <th>Tipo</th>
                <th>DSI</th>
                <th>Adquisición</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Dirección IP</th>
                <th>Dirección MAC</th>
                <th>Nombre de usuario</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach($equipos as $key => $value)
                <tr class="middle">
                    <td class="text-center">
                        <span><img src="{{asset('storage/fotosEquipos/') .'/'. $value->relModelo->foto}}" height="32px" width="32px"></span>
                    </td>
                    <td>{{$value->service_tag}}</td>
                    <td>{{$value->relTipoEquipo->nombre}}</td>
                    <td>{{$value->inventario}}</td>
                    <td>{{Carbon\Carbon::parse($value->fecha_adquisicion)->format('d/m/Y')}}</td>
                    <td>{{$value->relMarca->nombre}}</td>
                    <td>{{$value->relModelo->nombre}}</td>
                    <td>{{$value->direccion_ip}}</td>
                    <td>{{$value->direccion_mac}}</td>
                    <td>{{$value->nombreUsuario}}</td>
                    <td class="text-center">
                        <a href="{{route('detalleEquipo', $value->id)}}" class="mr-3" title="Ver"><i class="fa fa-eye"></i></a>
                        <a href="#" onclick="borrar({{$value->id}})" title="Eliminar"><i class="fa fa-trash text-danger"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p><i class="fa fa-exclamation-circle text-primary"></i> No hay equipos registrados</p>
        @endif
        <!-- ./ lista de equipos -->

    </div>

    <!-- Boton para nuevo equipo -->
    <button id="btn-nuevo-equipo" title="Nuevo equipo" data-toggle="modal" data-target="#modalEquipo" class="btn btn-primary rounded-circle"><i class="fa fa-plus"></i></button>
    <!-- ./boton nuevo equipo -->


    <!-- Modal equipo -->
    <div class="modal fade" id="modalEquipo" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <livewire:form-equipo />

                    @if($tipo == 1)
                    <livewire:form-pc />
                    @endif

                    @if($tipo == 2)
                    <livewire:form-pc />
                    @endif

                    @if($tipo == 3)
                    <livewire:form-impresora />
                    @endif

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" wire:click="$dispatchTo('form-equipo', 'guardar')"><i class="fa fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- ./modal equipo -->


    <!-- scripts -->
    @push('custom-scripts')
    <script>
        function borrar(id) {
            if (confirm('Estas seguro de eliminar este registro?')) {

                Livewire.dispatchTo('inventario-equipos', 'borrar', {
                    id: id
                })
            }
        }
    </script>
    @endpush

</div>