<div class="container mt-2">
    <div class="mx-auto col-lg-8">
        <div class="card text-start">
            <div class="card-header">
                <h4 class="card-title">Nuevo árticulo</h4>
            </div>
            <div class="card-body">

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="privado" id="privadoCheck" />
                    <label class="form-check-label" for="privadoCheck">Visualizarlo en Privado </label>
                </div>
                    
                <hr>

                <div>
                    <label for="tema">Tema</label>
                    <input type="text" class="form-control @error('detalles') is-invalid @enderror"" wire:model="tema" id="tema">
                    @error('tema')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="tema">Detalles</label>
                    <textarea type="text" class="form-control @error('detalles') is-invalid @enderror" wire:model="detalles" id="detalles" rows="10" ></textarea>
                    @error('detalles')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <div class="mt-2">
                        <label for="documento">
                            <input type="file" class="d-none" id="documento" wire:model="documento" multiple>
                            <span class="btn btn-secondary"><i class="fa fa-paperclip text-white"></i> Subir archivos</span>
                        </label>
                    </div>

                    <div wire:loading wire:target="documento">
                        <div class="spinner-border" role="status"></div> Cargando...    
                    </div>
                    
                    <div>
                        @if($documento)
                        @foreach($documento as $doc => $value)
                        @if($value != null)
                        <span class="badge" style="color:#012E69;"><strong>{{$value->getClientOriginalName()}}</strong>
                            <span style="cursor: pointer;" class="text-secondary" title="Eliminar archivo" wire:click="borrarDoc({{$doc}})"><i class="fa fa-times"></i></span>
                        </span>
                        @endif
                        @endforeach
                        @endif

                        @error('documento.*')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>
                </div>


            </div>

            <div class="card-footer">
                <button class="btn btn-primary" wire:click="guardar"><i class="fa fa-save"></i> Guardar</button>
            </div>

        </div>
    </div>

</div>