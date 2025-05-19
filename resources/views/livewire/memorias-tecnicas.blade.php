<div>
    <div class="container" style="margin-top: 65px;">
        <div class="container">
            
            <h5>Memorias tecnias</h5>

            <div class="row">
                <div class="col-lg-8">
                    <input type="search" wire:model.live="search" id="search" class="form-control col-3 mb-2" placeholder="Buscar...">
                    <!-- Tabla memorias -->
                    @if(count($memorias)>0)
                    <table class="table table-hover table-sm small">
                        <thead>
                            <th>Nombre</th>
                            <th>Creada</th>
                            <th>Autor</th>
                            <th class="text-center">Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach($memorias as $memoria => $value)
                            <tr>
                                <td><a href="#"> {{$value->capitalName}}</a></td>
                                <td>{{$value->relUser->nombreCompleto}}</td>
                                <td>{{$value->fechaDeCreacion}}</td>
                                <td class="text-center">
                                    <a href="#" onclick="borrarMemoria(event, {{$value->id}})"
                                        title="Borrar"><i class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$memorias->links()}}

                    @else
                    <p><i class="fa fa-exclamation-circle text-primary"></i> No se encontrarón memorias registradas</p>
                    @endif

                </div>

                <!-- ---------------------------------------------------------------------------- -->
                <div class="col-lg-4">

                    <div class="card text-left">
                        <div class="card-header">
                            <h5 class="card-title">Nueva </h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div>
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" wire:model="nombre">
                                    @error('nombre')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="mt-2">
                                    <label for="">Documentos</label><br>
                                    <label for="documentos">
                                        <p style="font-size: 11.5px; font-weight: 400; cursor:pointer" class="text-muted"><span class="btn btn-info rounded-circle"><i class="fa fa-paperclip"></i></span> Haz clic para agregar documentos</p>
                                    </label>
                                    <input type="file" class="form-control d-none" id="documentos" wire:model="documentos" multiple>
                                    @error('documentos')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div>
                                    @if(count($documentos)>0)
                                    <ul style="list-style: none;">
                                        @foreach($documentos as $item => $value)
                                        <li><span class="badge badge-info badge-pill">{{$value->getClientOriginalName()}}</span> &nbsp; <span wire:click="delFile({{$item}})" style="cursor:pointer"><i class="fa fa-times text-danger"></i></span></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <label for="compartir">Compartir con...</label>
                                <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                        id="chkAll"
                                        wire:model.live="selectAll" />
                                        <label class="form-check-label" for="chkAll">TODOS</label>
                                    </div>
                                @foreach($users as $user => $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                                value="{{$value->id}}"
                                                wire:model="usuariosCompartidos" 
                                                id="chk{{$value->id}}" 
                                                @if($value->id == auth()->user()->id) disabled @endif />
                                        <label class="form-check-label" for="chk{{$value->id}}"> {{$value->nombreCompleto}} </label>
                                    </div>
                                @endforeach

                                <button class="btn btn-success mt-2 col-12" wire:click.prevent="store()"><i class="fa fa-save"></i> Guardar</button>

                            </form>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
@push('custom-scripts')
<script>

    function borrarMemoria(e,id)
    {
        e.preventDefault()
        var id = id;
        if(confirm("Estas seguro que deseas eliminar el registro?")){

            Livewire.dispatch('deleteMemoria', {id: id})
        }
    }
</script>
@endpush

</div>