<div>
    <div>
        <label for="proveedor" class="d-flex align-items-end justify-content-between">Proveedor
            <span class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalProveedores"><i class="fa fa-plus"></i> Nuevo</span>
        </label>
        <select type="text" id="proveedor" wire:model="proveedor" class="form-control" wire:change="enviarProveedor()">
            <option value=""> ---Selecciona una opción--- </option>
            @foreach($lista as $key=> $value)
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endforeach
        </select>

        @error('proveedor')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <!-- Modal Nuevo-->
    <div class="modal fade" id="modalProveedores" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" wire:model.live="nombre">
                            @error('nombre')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <br>

                        <div>
                            <span class="btn btn-link" wire:click="addInputContacto()"><i class="fa fa-plus"></i> Agregar contacto</span>

                            @if(count($contactos) > 0)
                            <table class="table table-bordered table-sm small">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Contacto</th>
                                        <th>Teléfono</th>
                                        <th><i class="fa fa-trash"></i></th>
                                    </tr>
                                </thead>
                                @foreach($contactos as $key => $value)
                                <tr>
                                    <td class="p-1">{{$key + 1 }}</td>
                                    <td class="p-0"><input type="text" class="w-100 form-control form-control-sm" wire:model="contactos.{{$key}}.nombre"></td>
                                    <td class="p-0"><input type="text" class="w-100 form-control form-control-sm" wire:model="contactos.{{$key}}.tel"></td>
                                    <td class="p-0"><a href="#" class="btn btn-danger btn-sm" wire:click.prevent="removeInput({{$key}})"><i class="fa fa-trash"></i></button></td>
                                </tr>
                                @endforeach
                            </table>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" wire:click="guardar()"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script>
        $(document).on('hidden.bs.modal', '#modalProveedores', function() {
            Livewire.dispatch('resetModal')
        })
    </script>
    @endpush

</div>