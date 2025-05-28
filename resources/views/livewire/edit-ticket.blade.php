<div>

    <div class="modal fade" id="modal-edit-ticket" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div>
                        <label for="tema">Tema <span><strong>*</strong></span></label>
                        <input type="text" id="tema" wire:model="tema" class="form-control" placeholder="Obligatorio (100 caracteres máximo)" maxlength="100">
                        @error('tema')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div id="editor-container" wire:ignore class="mb-3">

                        <label for="descripcion">Descripción <strong>*</strong></label>
                        <input id="descripcion" type="hidden" wire:model="descripcion">

                        <trix-editor input="descripcion" class="@error('descripcion') is-invalid  @enderror" ></trix-editor>

                        @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="save()" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>

       //Sincronizar cambios en descripcion con Trix
        document.addEventListener("trix-change", function (event) {
            const input = document.querySelector("#descripcion");
            input.dispatchEvent(new Event("input", { bubbles: true }));
        });
        
        //mostramos el contenido en el trix editor cuando hacemos click en editar y nos abre el modal
         $(document).on('showEditTicket', function(e) {

             const contenido = e.detail.descripcion ?? '';
             console.log(e.detail.descripcion)

            // Seleccionamos el input y el editor
            const input = document.querySelector('#descripcion');
            const editor = document.querySelector("trix-editor");

            // Establecer valor en el input y forzar render en Trix
            input.value = contenido;
            editor.editor.loadHTML(contenido);

            // Abre el modal
            $('#modal-edit-ticket').modal('show');

        })
    </script>
    @endpush


</div>