<div class="container mt-2">
    <div class="row">
        <div class="col-lg-8">
            <div class="card text-start">
                <div class="card-header">
                    <h5 class="card-title">{{$tema}}</h5>
                </div>
                <div class="card-body">

                    <div>
                        <label for="tema">Tema</label>
                        <input type="text" class="form-control @error('tema') is-invalid @enderror"" wire:model="tema" id="tema">
                        @error('tema')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="tema">Detalles</label>
                        <textarea type="text" class="form-control @error('detalles') is-invalid @enderror" wire:model="detalles" id="detalles" rows="10"></textarea>
                        @error('detalles')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div>

                        <div class="mt-2">
                            <label for="documento">
                                <input type="file" class="d-none" id="documento" wire:model="documento">
                                <span class="btn btn-secondary"><i class="fa fa-paperclip text-white"></i> Subir archivos</span>
                            </label>
                        </div>

                        <div wire:loading wire:target="documento">
                            <div class="spinner-border" role="status"></div> Cargando...
                        </div>

                        <div>
                            @if($documento)
                            <span class="badge badge-secondary">{{$documento->getClientOriginalName()}}</span>
                            @endif
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" wire:click="guardarCambios"><i class="fa fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card text-start">
                <div class="card-header">
                    <h4 class="card-title">Documentos</h4>
                </div>
                <div class="card-body" style="height: 58vh; overflow:auto; ">
                @if(count($docs) > 0)
                    @foreach($docs as $doc)
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center">
                                @if(explode('.',$doc->path)[1] == 'jpg')
                                <img src="{{asset('img\jpg.png')}}">
                                @elseif(explode('.',$doc->path)[1] == 'pdf')
                                <img src="{{asset('img\pdf.png')}}">
                                @elseif(explode('.',$doc->path)[1] == 'docx' || explode('.',$doc->path)[1] == 'doc')
                                <img src="{{asset('img\word.png')}}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-title"><strong>{{$doc->name}}</strong></p>
                                    <button wire:click="descargar('{{$doc->path}}', '{{$doc->name}}')"  class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Descargar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <p class="text-info"><strong>* No hay documentos cargados</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>