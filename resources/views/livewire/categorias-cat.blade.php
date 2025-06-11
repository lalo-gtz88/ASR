<div class="mt-3">


    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Catálogo: Categorias</h5>
        </div>

        <div class="card-body">
            <form wire:submit.prevent='guardar'>
                <div class="row">
                    <div class="col-md-8">

                        <input type="text" class="form-control" wire:model="nombre" id="nombre"
                            placeholder="Nombre de categoria">
                        @error('nombre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success col-12"><i class="fa fa-save"></i> Guardar</button>

                    </div>
                    <div class="col-md-2">
                        @if($editar)
                        <button type="button" class="btn btn-secondary col-12" wire:click='restore'><i class="fa fa-times"></i> Cancelar</button>
                        @endif
                    </div>
                </div>
            </form>

            <hr>

            <div class="row">
                <div class="col-md-3 mt-3">
                    <input type="search" name="search" id="search"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Buscar...">
                </div>
            </div>

            <table class="table table-sm small table-striped mt-3">
                <thead class="table-primary">
                    <th>Nombre</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach($categorias as $categoria)
                    <tr>
                        <td>{{Str::upper($categoria->name)}}</td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="edit({{$categoria->id}})"><i class="fa fa-edit"></i></button>
                            <button class="btn-link btn text-danger editEd" wire:confirm="¿Eliminar este registro?" wire:click="delItem({{$categoria->id}})" title="Eliminar"><i class="fa fa-trash"></i></button>
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