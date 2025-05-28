<div>
    <div class="container-fluid">
        <h2>Usuarios</h2>
        <div class="card">
            <div class="card-header bg-primary text-white">
                @if(!$editarRegistro)
                <div class="card-title">Nuevo usuario</div>
                @else
                <div class="card-title">Editar usuario</div>
                @endif
            </div>
            <div class="card-body">
                @error('exist')
                <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="row">
                    <div class="col-md-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre" placeholder="Obligatorio">
                        @error('nombre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="apellido">Apellido</label>
                        <input type="text" wire:model="apellido" class="form-control" name="apellido" id="apellido" placeholder="Obligatorio">
                        @error('apellido')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" wire:model="telefono" class="form-control" name="telefono" id="telefono">
                        @error('telefono')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" wire:model="correo" class="form-control" name="correo" id="correo">
                        @error('correo')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                    <div class="col-md-4">
                        <label for="usuario">Usuario</label>
                        <input type="text" wire:model="usuario" class="form-control" name="usuario" id="usuario" placeholder="Obligatorio">
                        @error('usuario')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="password">Password</label>
                        <input type="password" wire:model="password" class="form-control" name="password" id="password" @if(!$editarRegistro) placeholder="Obligatorio" @else null @endif />
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="confirmaPass">Confirma password</label>
                        <input type="password" wire:model="confirmaPassword" class="form-control" name="confirmaPass" id="confirmaPass" @if(!$editarRegistro) placeholder="Obligatorio" @else null @endif />
                        @error('confirmaPassword')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        @error('nomatch')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                </div>

                @if(!$editarRegistro)
                <button class="btn btn-success mt-4" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                @else
                <button class="btn btn-success mt-4" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-secondary mt-4" wire:click="cancel"><i class="fa fa-times"></i> Cancelar</button>
                @endif
            </div>
        </div>

        <div class="card my-4">
            <div class="card-header bg-secondary text-white">
                <div class="card-title">Usuarios</div>
            </div>
            <div class="card-body">

                <input type="search" id="search" wire:model.live="search" class="form-control mb-2"
                    placeholder="Buscar..."
                    autofocus>
                <div>
                    <div>
                        <table class="table table-sm small">
                            <thead class="table-primary">
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </thead>

                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{$user->nombreCompleto}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>
                                        <a href="#" title="Editar" wire:click.prevent="edit({{$user->id}})"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a href="#" title="Eliminar" class="text-danger delete" data-id="{{$user->id}}"><i class="fa fa-minus-circle"></i></a> &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a href="{{route('roles', $user->id)}}" title="Asignar permisos" class="text-muted"><i class="fa fa-unlock"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                {{$users->links()}}
            </div>

        </div>

    </div>
    @push('custom-scripts')
    <script>
        $(document).on('click', '.delete', function(e) {
            e.preventDefault()
            if (confirm('¿Estas seguro de eliminar el usuario?')) {
                let id = $(this).data('id')
                Livewire.dispatch('delete', {
                    id: id
                })
            }

        })
    </script>
    @endpush
</div>