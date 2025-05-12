<div>
    <div>
        <label for="tipo">Tipo</label>
        <select wire:model.live="tipo" id="tipo" class="form-control">
            @foreach($tipos as $key => $value)
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endforeach
        </select>
        @error('tipo')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="serviceTag">Service TAG</label>
        <input type="text" class="form-control" wire:model="serviceTag">

        @error('serviceTag')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="inventario">DSI</label>
        <input type="text" class="form-control" wire:model="inventario" id="inventario">
        @error('inventario')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="fecha_adquisicion">Marca</label>
        <select type="text" wire:model="marca" wire:change="listarModelos()" id="marca" class="form-control">
            <option value=""> --- Selecciona una opción --- </option>
            @foreach($marcas as $key => $value)
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endforeach
        </select>
        @error('marca')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="modelo">Modelo</label>
        <select type="text" wire:model="modelo" id="modelo" class="form-control">
            @foreach($modelos as $key => $value)
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endforeach
        </select>
        @error('modelo')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="fecha_adquisicion">Fecha de adquisición</label>
        <input type="date" wire:model="fechaDeAdquisicion" id="fecha_adquisicion" class="form-control">
        @error('fechaDeAdquisicion')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="direccionIp">Dirección IP </label>
        <input type="text" class="form-control" wire:model="direccionIp" id="direccionIp">
        @error('direccionIp')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <div>
        <label for="direccionMac">Dirección MAC </label>
        <input type="text" class="form-control" wire:model="direccionMac" id="direccionMac">
        @error('direccionMac')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <br>

</div>