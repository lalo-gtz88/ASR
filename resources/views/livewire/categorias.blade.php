<div>
    <div class="card">
        <div class="card-body">
            <label for="nombre">@if(!$editar)Nuevo @else Editar @endif categoría</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="nombre" wire:model.defer="nombre" placeholder="Nombre">
                <div class="input-group-append">
                    @if(!$editar)
                    <button class="btn btn-secondary" wire:click="store()"><i class="fa fa-save"></i> Guardar</button>
                    @endif
                    @if($editar)
                    <button class="btn btn-secondary" wire:click="update()"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-light" wire:click='restore()'><i class="fa fa-times"></i> Cancelar</button>
                    @endif
                </div>
            </div>
            @error('nombre')
            <small class="text-danger">{{$message}}</small>
            @enderror
            <hr>
            <label for="">Categorias registrados</label>
            <table class="table table-sm small">
                <thead>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach($categorias as $categoria)
                    <tr>
                        <td>{{Str::upper($categoria->name)}}</td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="edit({{$categoria->id}})"><i class="fa fa-pencil"></i></button> |
                            <button class="btn-link btn text-danger editCat" data-id="{{$categoria->id}}" title="Eliminar"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{$categorias->links()}}
            </div>
        </div>
    </div>
</div>