<div class="mt-3">

    <style>
        .contenedor {

            padding: 0 45px;
        }

        #btn-nuevo-equipo {

            position: absolute;
            right: 0;
            bottom: 0;
            margin-right: 25px;
            margin-bottom: 25px;
            height: 52px;
            width: 52px;
            border-radius: 50px;
            background: #3074FF;
        }

        #btn-nuevo-equipo i {

            margin-left: 22px;
            margin-top: 19px;
        }
    </style>

    <div>

        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-end">
                <input type="search" wire:model.live="buscar" id="buscar" class="form-control form-control-sm"
                placeholder="Buscar...">
            </div>
        </div>

        <!-- Lista de enlaces -->
        @if(count($enlaces) > 0)
        <table class="table table-sm small table-hover table-striped">
            <thead>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Teléfono</th>
                <th>Nombre de sitio</th>
                <th>Domicilio</th>
                <th>Contacto</th>
                <th>Status</th>
                <th>Tipo</th>
                <th>Servicios</th>
                <th>Proveedor</th>
                <th>Área</th>
                <th>Observaciones</th>
                <!-- <th>Acciones</th> -->
            </thead>
            <tbody>
                @foreach($enlaces as $key => $value)
                <tr>
                    <td><a href="{{route('verEnlace', $value->id)}}">{{$value->referencia}}</a></td>
                    <td>{{$value->descripcion}}</td>
                    <td>{{$value->telefono}}</td>
                    <td>{{$value->relSitio->nombre}}</td>
                    <td>{{$value->domicilio}}</td>
                    <td>{{$value->contacto}}</td>
                    <td>{{$value->status}}</td>
                    <td>{{$value->tipo}}</td>
                    <td>{{$value->servicios}}</td>
                    <td>@if($value->proveedor_id){{$value->relProveedor->nombre }}@endif</td>
                    <td>{{$value->area}}</td>
                    <td>{{Str::limit($value->observaciones, 50)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p><i class="fa fa-exclamation-circle text-primary"></i> No se encontrarón enlaces registrados</p>
        @endif
        <!-- ./ lista de enlaces -->
    </div>

    <!-- Boton para nuevo equipo -->
    <a href="{{route('nuevoEnlace')}}" id="btn-nuevo-equipo" title="Nuevo enlace"><i class="fa fa-plus text-white"></i></a>
    <!-- ./boton nuevo equipo -->


    @push('custom-scripts')
    <script>
        function eliminarEnlace(id)
        {
            if(confirm('Seguro que deseas eliminar el registro?')){
                Livewire.dispatch('eliminar', {id:id})
            }
        }
    </script>
    @endpush

</div>