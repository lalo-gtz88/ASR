<div class="mt-3">


    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Catálogo: Marcas y modelos</h5>
        </div>

        <div class="card-body">
            <form wire:submit.prevent='guardar'>
                <div class="row">
                    <div class="col-md-8">

                        <input type="text" class="form-control" wire:model="nombre" id="nombre"
                            placeholder="Nombre de marca">
                        @error('nombre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success col-12"><i class="fa fa-save"></i> Guardar</button>

                    </div>
                    <div class="col-md-2">
                        @if($modoEditar)
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
                    <th>Ver modelos</th>
                    <th>Acciones</th>
                </thead>

                <tbody>

                    @foreach($marcas as $marca)
                    <tr wire:key="marca-{{$marca->id}}">
                        <td>{{Str::upper($marca->nombre)}}</td>
                        <td>
                            <button class="btn btn-outline-primary"
                                wire:click="nuevoModelo({{$marca->id}})"
                                title="Agregar modelo"> Modelos</button>
                        </td>
                        <td>
                            <button class="btn-link btn" title="Editar" wire:click="edit({{$marca->id}})"><i class="fa fa-edit"></i></button>
                            <button class="btn-link btn text-danger editEd" wire:confirm="¿Eliminar este registro?" wire:click="delItem({{$marca->id}})" title="Eliminar"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <div>
                {{$marcas->links()}}
            </div>

        </div>
    </div>

    <!-- Modal modelos -->
    <div
        class="modal fade"
        id="modalModelos"
        role="dialog"
        aria-labelledby="modaModelos"
        aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Modelos
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-12">
                                <input type="text" class="form-control" wire:model="marcaSeleccionada" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-9">
                                <input type="text" class="form-control" placeholder="Nombre del modelo" wire:model="modelo">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success" wire:click="createModelo"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-primary">
                                        <th>Modelo</th>
                                        <th>Eliminar</th>
                                    </thead>
                                    <tbody>
                                        @foreach($modelos as $modelo)
                                        <tr wire:key="modelo-{{$modelo->id}}">
                                            <td>{{$modelo->nombre}}</td>
                                            <td><i class="fa fa-trash"></i></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        $(document).on('showModalModelos', function() {

            $('#modalModelos').modal('show')

        })

        // modal.addEventListener('show.bs.modal', function(event) {

        // });
    </script>
    @endpush

</div>