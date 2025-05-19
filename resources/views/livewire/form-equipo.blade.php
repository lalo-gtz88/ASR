<div>
    <div class="card my-4">
        <div class="card-header bg-primary text-white">
            <h1 class="h5">@if(!$editable)Registrar @else Editar @endif equipo</h1>
        </div>

        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select wire:model.live="tipo" id="tipo" class="form-select">
                        <option value="">Selecciona un tipo</option>
                        @foreach($tipos as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipo') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="serviceTag" class="form-label">Service TAG</label>
                    <input type="text" class="form-control" wire:model="serviceTag" id="serviceTag">
                    @error('serviceTag') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="inventario" class="form-label">DSI</label>
                    <input type="text" class="form-control" wire:model="inventario" id="inventario">
                    @error('inventario') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="marca" class="form-label">Marca</label>
                    <select wire:model="marca" wire:change="listarModelos()" id="marca" class="form-select">
                        <option value="">Selecciona una marca</option>
                        @foreach($marcas as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="modelo" class="form-label">Modelo</label>
                    <select wire:model="modelo" id="modelo" class="form-select">
                        <option value="">Selecciona un modelo</option>
                        @foreach($modelos as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                        @endforeach
                    </select>
                    @error('modelo') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="fecha_adquisicion" class="form-label">Fecha de adquisición</label>
                    <input type="date" wire:model="fechaDeAdquisicion" id="fecha_adquisicion" class="form-control">
                    @error('fechaDeAdquisicion') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="direccionIp" class="form-label">Dirección IP</label>
                    <input type="text" class="form-control" wire:model="direccionIp" id="direccionIp">
                    @error('direccionIp') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="direccionMac" class="form-label">Dirección MAC</label>
                    <input type="text" class="form-control" wire:model="direccionMac" id="direccionMac">
                    @error('direccionMac') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr>

            @if($tipo == 1)
            <livewire:form-pc :equipoId="$uniqueId" />
            @endif

            @if($tipo == 2)
            <livewire:form-pc :equipoId="$uniqueId" />
            @endif

            @if($tipo == 3)
            <livewire:form-impresora :equipoId="$uniqueId" />
            @endif

            <div class="mt-4 text-end">
                <button class="btn btn-success" wire:click="guardar">Guardar</button>
            </div>

        </div>
    </div>
    
</div>
