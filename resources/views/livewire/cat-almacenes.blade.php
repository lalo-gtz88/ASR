<div>
    <div class="card">
        <div class="card-body">
        <label> <strong>Nuevo Almacén</strong></label>
        <div class="input-group mb-2">
            <input type="text" class="form-control" wire:model.live="nameAlmacen">
            <div class="input-group-append">
                @if(!$editar)
                <button class="btn btn-secondary" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                @else
                <button class="btn btn-secondary" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-light" wire:click="cancelar"><i class="fa fa-times"></i> Cancelar</button>
                @endif
            </div>
        </div>

            <label> <strong>Almacenes registrados</strong></label>
            <table class="table table-sm small">
                <thead>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    
                    @foreach($almacenes as $item)
            
                    <tr>
                        <td>{{Str::upper($item->nombre)}}</td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="edit({{$item->id}})" ><i class="fa fa-pencil"></i></button> |
                            <button class="btn-link btn text-danger"  title="Eliminar"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{$almacenes->links()}}
            </div>
        </div>

    </div>

</div>