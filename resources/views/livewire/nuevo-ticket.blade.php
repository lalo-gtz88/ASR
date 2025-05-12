<div class="col-6 mt-3">

    <a href="{{route('tickets')}}" class="mr-2"><i class="fa fa-arrow-circle-left"></i> Atras</a>

    <div class="d-flex flex-column">
        <label for="tema">Tema <span><strong>*</strong></span></label>
        <input type="text" id="tema" wire:model="tema" class="form-control" placeholder="Obligatorio (100 caracteres máximo)"
         maxlength="100"
         autofocus>
        @error('tema')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <label for="descripcion">Descripción <span><strong>*</strong></span></label>
    <div id="contentDescripcion" wire:ignore>
        <textarea id="descripcion" wire:model="descripcion"></textarea>
    </div>
    @error('descripcion')
    <small class="text-danger">{{$message}}</small>
    @enderror

    <div class="d-flex flex-column">
        <label for="telefono">Teléfono / EXT<span><strong>*</strong></span></label>
        <input type="tel" id="telefono" wire:model="telefono" class="form-control">
        @error('telefono')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="d-flex flex-column">
        <label for="quien_reporta">Usuario</label>
        <input type="text" id="quien_reporta" wire:model="quien_reporta" class="form-control">
        @error('quien_reporta')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    <div class="d-flex flex-column">
        <label for="edificio">Edificio</label>
        <select class="form-control" id="edificio" wire:model="edificio">
            <option value="">---Selecciona una opción---</option>
            @foreach ($edificios as $item)
            <option>{{Str::upper($item->nombre)}}</option>
            @endforeach
        </select>
        <!-- <input type="text" name="edificio" id="edificio" wire:model.live="edificio" class="form-control"> -->
    </div>

    <div class="d-flex flex-column">
        <label for="departamento">Departamento</label>
        <select class="form-control" id="departamento" wire:model="departamento">
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
        <label for="usuario_red">Usuario de red</label>
        <input type="text" id="usuario_red" wire:model="usuario_red" class="form-control">
    </div>
    <div class="d-flex flex-column">
        <label for="ip">IP</label>
        <input type="text" id="ip" wire:model="direccionIp" class="form-control" maxlength="7">
        @error('ip')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="d-flex flex-column">
        <label for="autoriza">Autoriza</label>
        <input type="text" id="autoriza" wire:model="autoriza" class="form-control">
    </div>

    <div class="d-flex flex-column">
        <label for="categoria">Categoría</label>
        <select type="text" id="categoria" wire:model="categoria" class="form-control">
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
        <select id="asignado" wire:model="asignado" class="form-control">
            <option value=""> ---Selecciona una opción--- </option>
            @foreach ($tecnicos as $item)
            <option value="{{ $item->id }}">{{ $item->name . ' ' . $item->lastname }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="d-flex flex-column">
        <label for="prioridad">Prioridad</label>
        <select id="prioridad" wire:model="prioridad" class="form-control">
            <option>Baja</option>
            <option>Media</option>
            <option>Alta</option>
        </select>
    </div>

    <div>
        <label for="fecha_de_atencion">Fecha de atención</label>
        <input type="date" class="form-control" wire:model="fecha_de_atencion">
    </div>

    <div>
        <label for="unidad"><strong>Unidad</strong></label>
        <select id="unidad" class="form-control field" wire:model="unidad">
            <option value=""> ---Selecciona una opción ---</option>
            <option>1181 [F-150] </option>
            <option>1917 [Hilux] </option>
            <option>2319 [Versa] </option>
        </select>
    </div>

    @error('attachment.*')
    <small class="text-danger">{{ $message }}</small>
    @enderror



    <div class="d-flex align-items-center justify-content-between w-100 mt-3">

        <div>

            <label for="attach">
                <!-- Input para subir archivos -->
                <input type="file" id="attach" wire:model="attachment" multiple class="form-control d-none">
                <span class="btn btn-secondary" wire:loading.remove.attr="disabled"><i class="fa fa-paperclip"></i> Adjuntar archivo</span>
            </label>


        </div>


        <div>
            <button type="button" wire:click="guardar" wire:loading.remove="guardar" class="btn btn-success">
                <i class="fa fa-save"></i> Guardar
            </button>

            <button class="btn btn-success" wire:loading disabled=true wire:target="guardar">
                <img src="{{asset('img/loading.gif')}}" style="height: 16px; width:16px"> Procesando...
            </button>
        </div>

    </div>

    <div wire:loading wire:target="attachment">
        <span><img src="{{asset('img/loading.gif')}}" style="height: 32px; width:32px" alt="cargando archivos"></span>
    </div>

    <div>
        @if($attachment)
        @foreach($attachment as $item => $value)
        @if($value != null)
        <span class="badge">
            {{$value->getClientOriginalName()}} &nbsp; <span wire:click="delFile({{$item}})" style="cursor:pointer"><i class="fa fa-times"></i></span>
        </span>
        @endif
        @endforeach
        @endif
    </div>

    <br><br><br>
    <br><br><br>




    @push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#descripcion').summernote({
                height: 100,
                callbacks: {
                    onChange: function(content, $editable) {
                        @this.set('descripcion', content)
                    }
                }
            })
        })

        $(document).on('copy', function(e) {

            $('#descripcion').summernote({
                height: 100,
                focus: true,
                callbacks: {
                    onChange: function(content, $editable) {
                        @this.set('descripcion', content)
                    }
                }
            })

            $('.note-editable').html(e.detail.descripcion)
            
        })


        //limpiar descripcion con summernote
        $(document).on('limpiarDescripcion', function(){
            $('.note-editable').html('')

        })


        // Enviar telegram
        $(document).on('enviar-notificacion-telegram', function(event) {
            console.log(event.detail)
            fetch(encodeURI(`https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id=${event.detail.destino}&text=${event.detail.msj}`))
        })



    </script>
    @endpush

</div>