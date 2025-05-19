<div>
    <style>

        .middle td {

            vertical-align: middle;
        }
    </style>

    <div class="container-fluid my-4">

        <h1 class="h4">Equipos</h1>

        <!-- Filtros -->
        <div class="row">
            <div class="col-md-3 mb-2">
                <select wire:model.live="tipoF" id="tipoF" class="form-select" wire:change="getEquipos()">
                    <option value=""> --- TODOS --- </option>
                    @foreach($tiposF as $key => $value)
                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-7 mb-2">
                <div class="input-group">
                    <select wire:model.live="param" id="param" class="form-select">
                        <option value="service_tag">SERVICE TAG</option>
                        <option value="inventario">INVENTARIO</option>
                        <option value="user">NOMBRE DE USUARIO</option>
                        <option value="marca">MARCA</option>
                        <option value="modelo">MODELO</option>
                        <option value="direccion_ip">DIRECCION_IP</option>
                        <option value="direccion_mac">DIRECCION_MAC</option>
                    </select>
                    <input type="search" wire:model.live="buscar" id="buscar" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>
            
            <!-- Boton para nuevo equipo -->
            <a href="{{route('equipo.create')}}"  title="Nuevo equipo" class="btn btn-primary col-md-2 mb-2">
                <i class="fa fa-plus"></i> Nuevo
            </a>
            <!-- ./boton nuevo equipo -->
            
        </div>
        <!-- ./filtros -->

        <!-- Lista de equipos -->
        @if(count($equipos) > 0 )
        <table class="table table-sm small table-hover table-bordered mt-2">
            <thead class="table-primary">
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
                        @if($value->modelo)
                        <span><img src="{{asset('storage/fotosEquipos/') .'/'. $value->relModelo->foto}}" height="32px" width="32px"></span>
                        @endif
                    </td>
                    <td>{{$value->service_tag}}</td>
                    <td>{{$value->relTipoEquipo->nombre}}</td>
                    <td>{{$value->inventario}}</td>
                    <td>{{Carbon\Carbon::parse($value->fecha_adquisicion)->format('d/m/Y')}}</td>
                    <td>@if($value->modelo) {{$value->relMarca->nombre}} @endif </td>
                    <td>@if($value->modelo) {{$value->relModelo->nombre}} @endif </td>
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
        <p class="text-muted"><i class="fa fa-exclamation-circle text-primary"></i> No hay equipos registrados</p>
        @endif
        <!-- ./ lista de equipos -->

    </div>



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