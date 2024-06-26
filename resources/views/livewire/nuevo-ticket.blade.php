<div>
    <div id="mod-nuevo-ticket" class="modal" tabindex="-1" wire:ignore>
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header  bg-secondary text-white ">
                    <h5 class="modal-title">Nuevo ticket</h5>
                    <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column">
                        <label for="tema">Tema <span><strong>*</strong></span></label>
                        <input type="text" name="tema" id="tema" wire:model="tema" class="form-control" placeholder="Obligatorio">
                        @error('tema')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex flex-column">
                        <label for="descripcion">Descripción <span><strong>*</strong></span></label>
                        <textarea type="text" name="descripcion" id="descripcion" wire:model="descripcion" class="form-control" rows="5" placeholder="Obligatorio"></textarea>
                        @error('descripcion')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                    <div class="d-flex flex-column">
                        <label for="quien_reporta">Quien reporta</label>
                        <input type="text" name="quien_reporta" id="quien_reporta" wire:model="quien_reporta" class="form-control">
                        @error('quien_reporta')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="d-flex flex-column">
                        <label for="telefono">Teléfono / EXT</label>
                        <input type="tel" name="telefono" id="telefono" wire:model="telefono" class="form-control">
                        @error('telefono')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex flex-column">
                        <label for="edificio">Edificio</label>
                        <select class="form-control" name="edificio" id="edificio" wire:model="edificio">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($edificios as $item)
                            <option>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="edificio" id="edificio" wire:model="edificio" class="form-control"> -->
                    </div>

                    <div class="d-flex flex-column">
                        <label for="departamento">Departamento</label>
                        <select class="form-control" name="departamento" id="departamento" wire:model="departamento">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($departamentos as $item)
                            <option>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="departamento" id="departamento" wire:model="departamento" class="form-control"> -->
                        @error('departamento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex flex-column">
                        <label for="usuario_red">Usuario de red</label>
                        <input type="text" name="usuario_red" id="usuario_red" wire:model="usuario_red" class="form-control">
                    </div>
                    <div class="d-flex flex-column">
                        <label for="ip">IP</label>
                        <input type="text" name="ip" id="ip" wire:model="ip" class="form-control">
                        @error('ip')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                    <div class="d-flex flex-column">
                        <label for="autoriza">Autoriza</label>
                        <input type="text" name="autoriza" id="autoriza" wire:model="autoriza" class="form-control">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="categoria">Categoría</label>
                        <select type="text" name="categoria" id="categoria" wire:model="categoria" class="form-control">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($categorias as $item)
                            <option>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column">
                        <label for="asignado">Asignar a</label>
                        <select name="asignado" id="asignado" wire:model="asignado" class="form-control">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($usuarios as $item)
                            <option value="{{ $item->id }}">{{ $item->name . ' ' . $item->lastname }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad" wire:model="prioridad" class="form-control">
                            <option>Baja</option>
                            <option>Media</option>
                            <option>Alta</option>
                        </select>
                    </div>

                    <div>
                        <div class="d-flex flex-row align-items-center">
                            <label for="attach" class="mr-3">Archivo adjunto </label>
                            <div wire:loading wire:target="attachment">
                                <p style="font-size: 11px"><img style="height: 20px; width:20px;" src="{{ asset('img') }}/loading.gif" alt="cargando..."> Cargando...</p>
                            </div>
                        </div>
                        <input type="file" name="attach" id="attach" wire:model="attachment" class="form-control">
                    </div>
                    @error('attachment')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="modal-footer">
                    <div wire:loading.remove wire:target="store">
                        <button class="btn btn-primary mt-2" wire:click="store">Guardar</button>
                    </div>
                    <div wire:loading wire:target="store">
                        <button class="btn btn-primary btn-block mt-2" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Procesando...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>