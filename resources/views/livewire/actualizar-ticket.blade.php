<div>
    <div class="contenedor-datos">
        <div class="contenedor-body">
            <div class="d-flex flex-column">
                <label for="telefono">Teléfono / EXT<span><strong>*</strong></span></label>
                <input type="tel" id="telefono" wire:model="telefono" wire:change="guardar()" class="form-control">
                @error('telefono')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex flex-column">
                <label for="quien_reporta">Nombre</label>
                <input type="text" id="quien_reporta" wire:model="quien_reporta" class="form-control" wire:change="guardar()">
                @error('quien_reporta')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="d-flex flex-column">
                <label for="edificio">Edificio</label>
                <select class="form-control" id="edificio" wire:model="edificio" wire:change="guardar()">
                    <option value="">---Selecciona una opción---</option>
                    @foreach ($edificios as $item)
                    <option>{{Str::upper($item->nombre)}}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex flex-column">
                <label for="departamento">Departamento</label>
                <select class="form-control" id="departamento" wire:model="departamento" wire:change="guardar()">
                    <option value="">---Selecciona una opción---</option>
                    @foreach ($departamentos as $item)
                    <option>{{Str::upper($item->nombre)}}</option>
                    @endforeach
                </select>

                @error('departamento')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex flex-column">
                <label for="ip">IP</label>
                <div class="input-group">
                    <span class="input-group-text">172.16.</span>
                    <input type="text" id="ip" wire:model="ip" class="form-control"  wire:change="guardar()">
                </div>
                @error('ip')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex flex-column">
                <label for="autoriza">Autoriza</label>
                <input type="text" id="autoriza" wire:model="autoriza" class="form-control" wire:change="guardar()">
            </div>

            <div class="d-flex flex-column">
                <label for="categoria">Categoría</label>
                <select type="text" id="categoria" wire:model="categoria" class="form-control" wire:change="guardar()">
                    <option value="">---Selecciona una opción---</option>
                    @foreach ($categorias as $item)
                    <option>
                        {{ Str::upper($item->name)}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex flex-column">
                <label for="asignado">Asignar a</label>
                <select id="asignado" wire:model="asignado" class="form-control" wire:change="guardar()">
                    <option value=""> ---Selecciona una opción--- </option>
                    @foreach ($tecnicos as $item)
                    <option value="{{ $item->id }}">{{ $item->name . ' ' . $item->lastname }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex flex-column">
                <label for="prioridad">Prioridad</label>
                <select id="prioridad" wire:model="prioridad" class="form-control" wire:change="guardar()">
                    <option>Baja</option>
                    <option>Media</option>
                    <option>Alta</option>
                </select>
            </div>

            <div>
                <label for="fecha_de_atencion">Fecha de atención</label>
                <input type="date" class="form-control" wire:model="fecha_de_atencion" wire:blur="guardar()">
            </div>

            <div>
                <label for="unidad"><strong>Unidad</strong></label>
                <select id="unidad" class="form-control field" wire:model="unidad" wire:change="guardar()">
                    <option value=""> ---Selecciona una opción ---</option>
                    <option>1181 [F-150] </option>
                    <option>1917 [Hilux] </option>
                    <option>2319 [Versa] </option>
                </select>
            </div>
        </div>

    </div>



    @push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#descripcion').summernote({
                height: 100,
                focus: true,
                callbacks: {
                    onChange: function(content, $editable) {
                        @this.set('descripcion', content)
                    }
                }
            })
        })


        $(document).on('enviar-notificacion-telegram', function(event) {
            console.log(event.detail)
            fetch(encodeURI(`https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id=${event.detail.destino}&text=${event.detail.msj}`))
        })
    </script>
    @endpush

</div>