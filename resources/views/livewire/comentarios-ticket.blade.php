<div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center justify-content-start">
            <h5 class="me-2">Ticket # {{$ticketID}}</h5>
            <h5 class="title-tema"> {{$ticket->tema}}  <spanv class="badge badge-pill bg-{{$ticket->colorPrioridad}} text-white">{{$ticket->prioridad}}</span></h5>
        </div>
        <input type="text" class="form-control input-tema d-none" style="width: 85%;" wire:model="tema" wire:change="actualizarTema()" />
        <a href="#" class="editarTema" title="Editar tema"><i class="fa fa-pencil" style="font-size: 15px;"></i></a>
        <a href="#" class="cancelarEdicionTema d-none" title="Editar tema"><i class="fa fa-times text-secondary" style="font-size: 15px;"></i></a>
    </div>
    <hr>

    <div class="lineatemp">
        <div class="fila">
            <div class="disco">
                <div><img class="rounded-circle" style="height:36px;" src="{{asset('storage/perfiles')}}/{{$ticket->userCreador->photo}}"></div>
            </div>
            <div class="d-flex flex-column">{{Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y')}}
                <span class="text-muted" style="font-weight: 400; font-style:italic">{{$ticket->userCreador->name .' '.$ticket->userCreador->lastname}}</span>
            </div>
            <div class="clear-fix border rounded p-4 mb-2">
                <div class="float-left caja-descripcion" style="width: 85%;"><?php echo $ticket->descripcion; ?></div>
                <span class="float-right text-muted" style="font-weight: 400; font-style:italic">{{Carbon\Carbon::parse($ticket->created_at)->diffForHumans()}}</span>
            </div>
        </div>

        @foreach($ticket->seguimientos as $comentario)
        <div class="fila">
            <div class="disco">
                <div>
                    @if($comentario->userComment->photo != null)
                    <img class="rounded-circle" style="height:36px;" src="{{asset('storage/perfiles')}}/{{$comentario->userComment->photo}}">
                    @else
                    <img class="rounded-circle" style="height:36px;" src="{{asset('img/user.png')}}">
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column">{{Carbon\Carbon::parse($comentario->created_at)->format('d/m/Y')}}
                <span class="text-muted" style="font-weight: 400; font-style:italic">{{$comentario->userComment->name .' '.$comentario->userComment->lastname}}</span>
            </div>
            <div class="clear-fix rounded p-4 mb-2 globo">
                <div class="float-left w-75 " data-id="{{$comentario->id}}"><?php echo $comentario->notas; ?></div>
                <span class="float-right text-dark" style="font-weight: 400; font-style:italic">{{Carbon\Carbon::parse($comentario->created_at)->diffForHumans()}}</span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex align-items-center">
        
        <div id="editor-container" style="width: 100%;" wire:ignore class="my-4">

            <input id="mensaje" type="hidden" wire:model.live="mensaje">
            <trix-editor input="mensaje"></trix-editor>

            @error('mensaje')
            <small class="text-danger">{{$message}}</small>
            @enderror

      </div>
        
        <div class="d-flex flex-column ">
            <div class="contenedor-btn-enviar">
                <span class="btn btn-link" id="btnEnviar" style="cursor: pointer;" wire:click="guardar()"><i class="fa fa-paper-plane"></i></span>
                <div class="submenu-hover text-secondary" style="width:100px;">
                    <a href="#" style="color:#182533" wire:click.prevent="guardar('Abierto')"><i class="fa fa-unlock"></i> Abierto</a>
                    <a href="#" style="color:#182533" wire:click.prevent="guardar('Cerrado')"><i class="fa fa-lock"></i> Cerrado</a>
                    <a href="#" style="color:#182533" wire:click.prevent="guardar('Pendiente')"><i class="fa fa-clock-o"></i> Pendiente</a>
                </div>
            </div>
            <label for="attach">
                <!-- Input para subir archivos -->
                <input type="file" id="attach" wire:model="attachments" multiple class="form-control d-none">
                <span class="btn btn-link" style="cursor: pointer;"><i class="fa fa-paperclip text-dark" style="font-size: 16px;"></i></span>
            </label>
        </div>
    </div>

    <div>
        <!-- Mostrar archivos adjuntos-->
        @if($attachments)
        @foreach($attachments as $item => $value)
        @if($value != null)
        <span class="badge" style="color:#012E69;"><strong>{{$value->getClientOriginalName()}}</strong>
            <span style="cursor: pointer;" class="text-secondary" title="Eliminar archivo" wire:click="deleteAttachment({{$item}})"><i class="fa fa-times"></i></span>
        </span>
        @endif
        @endforeach
        @endif

    </div>
    
    <div>
        @error('attachments.*')
        <small class="text-danger m-2"><strong>*{{$message}}</strong></small>
        @enderror
    </div>

    <span style="font-size: 12px" wire:loading wire:target='attachments'>
        <img src="{{asset('img')}}/loading.gif" alt="cargando..." style="height: 25px; width:25px;"> Cargando...
    </span>

    @push('custom-scripts')
    <script>
        //Sincronizar cambios en descripcion con Trix
        document.addEventListener("trix-change", function (event) {
            const input = document.querySelector("#mensaje");
            input.dispatchEvent(new Event("input", { bubbles: true }));
        });

        $(document).on('setScroll', function() {

            setTimeout(() => {
                let content = document.querySelector('.lineatemp')
                content.scrollTop = content.scrollHeight;
            }, 150);

        })

        $(document).on('click', '.deleteAttachment', function() {

            let el = $(this).parent()
            let id = el.data('id')

            if (confirm("Estas seguro(a) de eliminar el archivo adjunto?")) {

                Livewire.dispatch('borrarArchivo', {
                    id: id
                })
            }
        })

        $(document).on('click', '.editarTema', function() {

            $('.input-tema').removeClass('d-none')
            $('.title-tema').addClass('d-none')
            $('.cancelarEdicionTema').removeClass('d-none')
            $('.editarTema').addClass('d-none')

        })

        $(document).on('click', '.cancelarEdicionTema', function() {

            $('.input-tema').addClass('d-none')
            $('.title-tema').removeClass('d-none')
            $('.cancelarEdicionTema').addClass('d-none')
            $('.editarTema').removeClass('d-none')
        })

        function editarDesc(){

            $('.caja-edit-desc').removeClass('d-none')
            $('.editarDesc').addClass('d-none')
            $('.caja-descripcion').addClass('d-none')
        }


        $(document).on('editarDesc', function(){

           editarDesc()
        })

        $(document).on('cancelEditarDesc', function(){
            $('.caja-edit-desc').addClass('d-none')
            $('.editarDesc').removeClass('d-none')
            $('.caja-descripcion').removeClass('d-none')
        })

    </script>
    @endpush

</div>