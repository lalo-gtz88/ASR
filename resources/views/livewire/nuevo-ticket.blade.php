<div>

  <h1 class="h2">
    Nuevo ticket
  </h1>

  <form wire:submit.prevent="guardar">
    {{-- Información del Ticket --}}
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">Información del Ticket</div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="tema" class="form-label">Tema *</label>
            <input type="text" wire:model="tema" class="form-control @error('telefono') is-invalid  @enderror" id="tema" maxlength="100">
            @error('tema')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono / EXT *</label>
            <input type="text" wire:model="telefono" class="form-control @error('telefono') is-invalid  @enderror" id="telefono">
            @error('telefono')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div id="editor-container" class="mb-3">

          <label for="descripcion">Descripción <strong>*</strong></label>

          <input id="descripcion" type="hidden" wire:model="descripcion">

          <trix-editor input="descripcion" class="@error('descripcion') is-invalid  @enderror" wire:ignore></trix-editor>

          @error('descripcion')
          <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror

        </div>
      </div>
    </div>

    {{-- Información del Solicitante --}}
    <div class="card mb-4">
      <div class="card-header bg-secondary text-white">Información del Solicitante</div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" wire:model="quien_reporta" class="form-control" id="usuario">
            @error('quien_reporta')
            <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="edificio" class="form-label">Edificio</label>
            <select wire:model="edificio" class="form-select" id="edificio">
              <option value="">-- Selecciona una opción --</option>
              @foreach($edificios as $index => $edificio)
              <option>{{Str::upper($edificio->nombre)}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="departamento" class="form-label">Departamento</label>
            <select wire:model="departamento" class="form-select" id="departamento">
              <option value="">-- Selecciona una opción --</option>
              @foreach($departamentos as $id => $dpto)
              <option>{{Str::upper($dpto->nombre)}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">

          <div class="col-md-4">
            <label for="usuario_red" class="form-label">Usuario de Red</label>
            <input type="text" wire:model="usuario_red" class="form-control" id="usuario_red">
          </div>

          <div class="col-md-4">
            <label for="ip" class="form-label">IP</label>
            <input type="text" wire:model="direccionIp" class="form-control" id="ip">
            @error('direccionIp')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>


          <div class="col-md-4">
            <label for="autoriza" class="form-label">Autoriza</label>
            <input type="text" wire:model="autoriza" class="form-control" id="autoriza">
            @error('autoriza')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
      </div>
    </div>

    {{-- Asignación y Prioridad --}}
    <div class="card mb-4">
      <div class="card-header bg-info text-white">Asignación y Prioridad</div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="categoria" class="form-label">Categoría</label>
            <select wire:model.defer="categoria" class="form-select" id="categoria">
              <option value="">-- Selecciona una opción --</option>
              @foreach($categorias as $index => $cat)
              <option>{{ Str::upper($cat->name)}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="asignado_a" class="form-label">Asignar a</label>
            <select wire:model="asignado" class="form-select" id="asignado_a">
              <option value="">-- Selecciona una opción --</option>
              @foreach($tecnicos as $index => $tec)
              <option value="{{ $tec->id }}">{{ $tec->name .' '. $tec->lastname }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select wire:model="prioridad" class="form-select" id="prioridad">
              <option>Baja</option>
              <option>Media</option>
              <option>Alta</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="fecha_atencion" class="form-label">Fecha de atención</label>
            <input type="date" wire:model="fecha_de_atencion" class="form-control" id="fecha_atencion">
          </div>
          <div class="col-md-8">
            <label for="unidad" class="form-label">Unidad</label>
            <select id="unidad" class="form-control field" wire:model="unidad">
              <option value=""> ---Selecciona una opción ---</option>
              <option>1181 [F-150] </option>
              <option>1917 [Hilux] </option>
              <option>2319 [Versa] </option>
            </select>
          </div>
        </div>
      </div>
    </div>

    @error('attachment.*')
    <small class="text-danger">{{ $message }}</small>
    @enderror

    {{-- Adjuntar archivo --}}

    <div class="d-flex align-items-center justify-content-between">

      <div>

        <label for="attach">
          <!-- Input para subir archivos -->
          <input type="file" id="attach" wire:model="attachment" multiple class="form-control d-none">
          <span class="btn btn-secondary" wire:loading.remove.attr="disabled"><i class="fa fa-paperclip"></i> Adjuntar archivo</span>
        </label>

        <div wire:loading wire:target="attachment">
          <span><img src="{{asset('img/loading.gif')}}" style="height: 32px; width:32px" alt="cargando archivos"></span>
        </div>

        <div class="mt-2">
          @if($attachment)
          <div class="d-flex">
            @foreach($attachment as $item => $value)
            @if($value != null)
            <h4>
              <span class="badge bg-dark text-white">
                {{$value->getClientOriginalName()}}</span>
              <span wire:click="delFile({{$item}})" style="cursor:pointer" class="me-2"><i class="fa fa-times-circle text-danger"></i></span>
            </h4>
            @endif
            @endforeach
          </div>
          @endif
        </div>
      </div>

      {{-- Guardar --}}
      <div>
        <button type="submit" wire:loading.remove="guardar" class="btn btn-success">
          <i class="fa fa-save"></i> Guardar
        </button>

        <button class="btn btn-success" wire:loading disabled=true wire:target="guardar">
          <img src="{{asset('img/loading.gif')}}" style="height: 16px; width:16px"> Procesando...
        </button>
      </div>

    </div>
  </form>

  @push('custom-scripts')
  <script>
    //Sincronizar cambios en descripcion con Trix
    document.addEventListener("trix-change", function(event) {
      const input = document.querySelector("#descripcion");
      input.dispatchEvent(new Event("input", {
        bubbles: true
      }));
    });

    //limpiar contenido del Trix editor
    Livewire.on('limpiarDescripcion', () => {
      document.querySelector("#descripcion").value = "";
      document.querySelector("trix-editor").editor.loadHTML("");
    });

    //Setear contenido en trix editor
    $(document).on('setEditor', function(event) {

      setTimeout(() => {
        const contenido = event.detail.contenido;
        document.querySelector("#descripcion").value = contenido;
        document.querySelector("trix-editor").editor.loadHTML(contenido);
      }, 300);

    })
  </script>
  @endpush
</div>