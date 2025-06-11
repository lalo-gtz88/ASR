<div class="mt-3">


    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Catálogo: Segmentos de red</h5>
        </div>

        <div class="card-body">
            <form wire:submit.prevent='store'>
                <div class="row">
                    <div class="col-md-3">

                        <input type="text" class="form-control" wire:model="nombre" id="nombre"
                            placeholder="Nombre del segmento">
                        @error('nombre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>

                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="subred"
                            placeholder="Subred, ejemplo: 172.16.11.0"
                            @if($modoEdicion) disabled @endif>

                        @error('subred')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-1">
                        <div class="input-group">
                            <span class="input-group-text">/</span>
                            <input type="text" class="form-control" wire:model="mascara"
                                placeholder="Mascara"
                                @if($modoEdicion) disabled @endif>
                        </div>
                        @error('mascara')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">

                        <select type="text" class="form-select" wire:model="edificio" id="edificio">
                            <option value="">---Selecciona un edificio---</option>
                            @foreach($edificios as $ed)
                            <option value="{{$ed->id}}">{{$ed->nombre}}</option>
                            @endforeach
                        </select>
                        @error('edificio')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>


                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success col-12"><i class="fa fa-save"></i> Guardar</button>
                    </div>

                    <div class="col-md-2">
                        @if($modoEdicion)
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
                    <th>Subred</th>
                    <th>Edificio</th>
                    <th>Hosts disponibles</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach($segmentos as $seg)
                    <tr>
                        <td>{{Str::upper($seg->nombre)}}</td>
                        <td>{{long2ip($seg->subred_inicio)}}</td>
                        <td>@if($seg->edificio_id) {{$seg->relEdificio->nombre}} @endif</td>
                        <td>{{$seg->hosts_disponibles}}</td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="editar({{$seg->id}})"><i class="fa fa-edit"></i></button>
                            {{-- <button class="btn-link btn text-danger editEd" wire:confirm="¿Eliminar este registro?" wire:click="delItem({{$seg->id}})" title="Eliminar"><i class="fa fa-trash"></i></button> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{$segmentos->links()}}
            </div>

        </div>
    </div>
</div>