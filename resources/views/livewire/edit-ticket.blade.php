<div>

    <div class="modal fade" id="modal-edit-ticket" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div>
                        <label for="tema">Tema <span><strong>*</strong></span></label>
                        <input type="text" id="tema" wire:model="tema" class="form-control" placeholder="Obligatorio (100 caracteres máximo)" maxlength="100">
                        @error('tema')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="descripcionEdit">Descripción <span><strong>*</strong></span></label>
                        <div wire:ignore>
                            <textarea id="descripcionEdit" class="form-control"
                            wire:model="descripcion"></textarea>
                        </div>
                        @error('descEmpty')
                        <small class="text-danger">{{$message}}</small>
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
         $(document).on('showEditTicket', function(e) {
            
            //integramos summernote
            setTimeout(() => {
                $('#descripcionEdit').summernote({
                    height:100,
                    focus: true,
                    callbacks: {
                        onChange: function(content, $editable){
                            @this.set('descripcionEdit', content);
                        }
                    }
                });

                $('.note-editable').html(e.detail.descripcion)
                //abrimos modal
                $('#modal-edit-ticket').modal('show')

            }, 10);  
        })
    </script>
    @endpush


</div>