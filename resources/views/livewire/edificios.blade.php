<div>
    <div class="card">
        <div class="card-body">
            <label for="nombre">@if(!$editar)Nuevo @else Editar @endif</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="nombre" wire:model="nombre" placeholder="Nombre">
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
            
            <table class="table table-sm small">
                <thead>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach($edificios as $edificio)
                    <tr>
                        <td>{{Str::upper($edificio->nombre)}}</td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="edit({{$edificio->id}})"><i class="fa fa-pencil"></i></button>
                            <button class="btn-link btn text-danger editEd" data-id="{{$edificio->id}}" title="Eliminar" ><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{$edificios->links()}}
            </div>
        </div>
    </div>
</div>