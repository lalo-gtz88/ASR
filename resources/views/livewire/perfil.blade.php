<div>
    <div class="container">
        <div class="card">

            <div class="card-body">

                @if($archivo != '')
                <div style="position:relative; height: 130px; width: 130px; ">
                    <img style="border-radius: 100px;height: 130px; width: 130px;" 
                    title="Subir foto de pérfil" src="{{asset('/storage/perfiles').'/'. $archivo}}" 
                    wire:click="changePhoto">
                    <span style="position: absolute; top:0; right: 0; cursor:pointer;" 
                    title="Eliminar foto" data-toggle="tooltip" data-placement="right" wire:click="deletePhoto">
                    <i class="fa fa-times"></i></span>
                </div>
                @else
                <span class="text-info"><i class="fa fa-user fa-4x"></i></span>
                @endif
                <hr>

                <h4 class="card-title">{{Auth()->user()->name.' '.Auth()->user()->lastname}}</h4>
                <h6>Privilegios</h6>
                <ul>
                    @foreach($privilegios as $priv)
                    <li>{{$priv}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="btnNuevoPass"><i class="fa fa-key"></i> Cambiar password</button>
                <button class="btn btn-secondary" id="btnNuevaPicture"><i class="fa fa-picture-o"></i> Cambiar foto de pérfil</button>
            </div>
        </div>
    </div>

    <!-- Modal nuevo password-->
    <div class="modal fade" id="modalChangePass" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Password nuevo</label>
                        <input type="password" class="form-control" wire:model.defer="password" name="password" id="password">
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        @error('nomatch')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Confirma password</label>
                        <input type="password" class="form-control" wire:model.defer="confirmaPassword" name="confirma_password" id="confirma_password">
                        @error('confirmaPassword')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="update" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal nuevo password-->

    <!-- Modal change picture-->
    <div class="modal fade" id="modalChangePicture" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Foto de pérfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    @if($foto == null)
                    <label for="photo">
                        <input type="file" name="photo" id="photo" wire:model="foto" class="d-none">
                        <span style="cursor:pointer; background-color:#9FA5AA; color:#FFF;" class="btn"> <i class="fa fa-paperclip"></i> 
                        Subir archivo...</span>
                    </label>
                    @else
                    <label for="photo">
                        <input type="file" name="photo" id="photo" wire:model="foto" class="d-none">
                        <img style="cursor:pointer; border-radius: 100px; height: 130px; width: 130px;" title="Subir foto de pérfil" src="{{ $foto->temporaryUrl() }}">
                        <!-- <div class="d-flex justify-content-around">
                            <button class="btn btn-link" wire:click="storePhoto"><i class="fa fa-check"></i> Aceptar</button>
                            <button class="btn btn-link text-danger" wire:click="$set('photo', null)"><i class="fa fa-times"></i> Cancelar</button>
                        </div> -->
                    </label>
                    @error('foto')<small class="text-danger">{{$message}}</small>@enderror
                    @endif
                    <br>
                    <div wire:loading wire:target="foto">
                        <p style="font-size: 11px"><img style="height: 20px; width:20px;" src="{{ asset('img') }}/loading.gif" alt="cargando..."> Cargando...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="storePhoto"><i class="fa fa-save"></i> Guardar</button>
                    @if($foto != null)<button type="button" class="btn btn-light" wire:click="$set('foto', null)"><i class="fa fa-times"></i> Cancelar</button>@endif
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal change picture-->

    @push('custom-scripts')
    <script>
        $(document).on('click', '#btnNuevoPass', function() {
            $('#modalChangePass').modal('show')
            setTimeout(() => {
                $('#password').focus()
            }, 200);

        })

        $(document).on('hideModal', function() {
            $('#modalChangePass').modal('hide')
        })

        $(document).on('hide.bs.modal', function() {
            Livewire.emit('clearModal')
        })

        $(document).on('click', '#btnNuevaPicture', function(){
            $('#modalChangePicture').modal('show')
        })

        $(document).on('closeModalPhoto', function() {
            $('#modalChangePicture').modal('hide')
        })

        // $(document).on('reload', function() {
        //     setTimeout(() => {
        //         window.location.reload()    
        //     }, 300);
            
        // })
        
    </script>
    @endpush
</div>