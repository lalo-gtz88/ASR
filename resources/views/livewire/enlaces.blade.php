<div>
    <h1 class="h2">Enlaces</h1>
    <div class="row mb-2">

        <div class="col-md-3">
            <input type="search" wire:model.live="buscar" id="buscar" class="form-control"
                placeholder="Buscar...">
        </div>

        <!-- Boton para nuevo equipo -->

        <a href="{{route('nuevoEnlace')}}" id="btn-nuevo" title="Nuevo enlace" class="btn btn-primary col-md-2"><i class="fa fa-plus text-white"></i> Nuevo</a>
        <!-- ./boton nuevo equipo -->


    </div>

    <!-- Lista de enlaces -->
    @if(count($enlaces) > 0)
    <table class="table table-sm small table-hover table-striped">
        <thead class="table-primary">
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
    <p class="text-muted"><i class="fa fa-exclamation-circle text-primary"></i> No se encontrarón enlaces registrados</p>
    @endif
    <!-- ./ lista de enlaces -->




    @push('custom-scripts')
    <script>
        function eliminarEnlace(id) {
            if (confirm('Seguro que deseas eliminar el registro?')) {
                Livewire.dispatch('eliminar', {
                    id: id
                })
            }
        }
    </script>
    @endpush

</div>