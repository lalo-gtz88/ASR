<div>
<style>
        .resultadosEncontrados {

            overflow-x: auto;
            height: 150px;
            padding: 0px 10px;
            border: 1px solid gray;
            border-radius: 5px;
            box-shadow: 1px 1px 1px gray;
            z-index: 10000 !important;
            position: absolute;
            background-color: #FFF;

        }

        .result {
            background: #FFF;
        }

        .result:hover {
            background: #00BDC6;
            color: #FFF;
            cursor: pointer;
        }

    </style>

    <div class="container pt-2">

        <div class="col-10 mx-auto">
            <a href="{{route('diagnosticos')}}"><i class="fa fa-arrow-circle-left"></i> Atras</a>
            <div class="card">
                <div class="card-header">
                    <h5>Nuevo diagnostico</h5>
                </div>

                <div class="card-body">

                    <h6>SOLICITANTE</h6>

                    <div class="row">

                        <div class="col-lg-5">
                            <label for="nombre_del_solicitante">Nombre</label>
                            <input type="text" name="nombre_del_solicitante" id="nombre_del_solicitante" wire:model.defer="nombre_del_solicitante" class="form-control" placeholder="Obligatorio">
                            @error('nombre_del_solicitante')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-5">
                            <label for="cargo_del_solicitante">Cargo</label>
                            <input type="text" name="cargo_del_solicitante" id="cargo_del_solicitante" wire:model.defer="cargo_del_solicitante" class="form-control" placeholder="Obligatorio">
                            @error('cargo_del_solicitante')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-2">
                            <label for="extension_del_solicitante">Ext</label>
                            <input type="text" name="extension_del_solicitante" id="extension_del_solicitante" wire:model.defer="extension_del_solicitante" class="form-control">
                            @error('extension_del_solicitante')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                    </div>

                    <hr>

                    <h6>BUSCAR EQUIPO</h6>

                    <div class="row">
                        <div class="col-lg-4">
                            <input type="buscar" class="form-control" id="buscar" wire:model="buscar" wire:keyup="searchEquipo()" placeholder="Buscar DSI, Service Tag">
                        </div>
                    </div>

                    <div class="row" style="position:relative">
                        @if(count($encontrados)>0)
                        <div class="col-lg-12 resultadosEncontrados">
                            @foreach($encontrados as $item)
                            <div data-id="{{$item->id}}" class="result">{{'DSI' . $item->dsi . ' [ '. $item->descr.' ] '}}</div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <label for="st">Service Tag</label>
                            <input type="text" class="form-control" id="st" wire:model.defer="service_tag" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="dsi">DSI</label>
                            <input type="text" class="form-control" id="dsi" wire:model.defer="DSI" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <label for="descr">Descripción</label>
                            <input type="text" class="form-control" id="descr" wire:model.defer="descripcion" readonly>
                        </div>
                        <div class="col-lg-5">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control" id="marca" wire:model.defer="marca" readonly>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="responsable">Responsable</label>
                            <input type="text" class="form-control" id="responsable" wire:model.defer="responsable" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="diagnostico">Diagnóstico</label>
                            <input type="text" class="form-control" id="diagnostico" wire:model.defer="diagnostico">
                        </div>
                    </div>

                    <button class="btn btn-secondary mt-2 btn-sm" wire:click="agregar"><i class="fa fa-plus"></i> Agregar</button>

                    @error('noAgregados')
                    <br>
                    <small class="text-danger">{{$message}}</small>
                    @enderror

                    @if(count($agregados)>0)
                    <hr>

                    <h6>EQUIPOS A SOLICITAR DIAGNÓSTICO</h6>

                    <div class="table-responsive">
                        
                        <table class="table table-sm table-striped small">
                            
                        <thead>
                                <tr>
                                    <th>DSI / Service Tag</th>
                                    <th>Descripción / Diagnóstico</th>
                                    <th>Marca</th>
                                    <th>Responsable</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($agregados as $item => $value)
                                <tr>
                                    <td>
                                        DSI {{$value['dsi']}} <br>
                                        <span class="text-muted">{{$value['st']}}</span>
                                    </td>
                                    <td>
                                        {{$value['descripcion']}} <br>
                                        <span class="text-muted">{{$value['desc_diagnostico']}}</span>
                                    </td>
                                    <td>{{$value['marca']}}</td>
                                    <td>
                                        {{$value['responsable']}}
                                    </td>
                                    <td class="text-center">
                                        <span wire:click="delItem({{$item}})" style="cursor:pointer"><i class="fa fa-minus text-danger"></i></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                    <div class="d-flex align-items-end justify-content-between">
                        <label for="dictamen">Dictamen general</label>
                        <span class="text-primary" wire:click="$set('dictamen', '')" title="Limpiar contentido de dictamen" data-toggle="tooltip"><i class="fa fa-eraser"></i></span>
                    </div>

                    <textarea name="dictamen" id="dictamen" rows="5" class="form-control" wire:model.defer="dictamen"></textarea>

                    <br>

                    <h6>ASOCIAR TICKET</h6>
                    <input type="number" name="numTicket" id="numTicket" class="form-control col-6" wire:model.defer="numTicket" placeholder="Número de ticket que deseas asociar">
                    @endif

                </div>

                <div class="card-footer">
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
    @push('custom-scripts')
    <script>
        $(document).on('click', '.result', function() {
            let id = $(this).data('id')
            Livewire.emit('setEquipo', id);
        })

        $(document).on('focusDiagnostico', function() {
            $("#diagnostico").focus()
        })

        $(document).on('focusBuscar', function() {
            $("#search").focus()
        })

        $(document).on('click', '#btnShowNuevo', function() {
            $("#mod-nuevo-ticket").modal('show')
        })

        $(document).on('click', '.btnDel', function(e) {
            e.preventDefault()
            if (confirm('Estas seguro?')) {
                let id = $(this).data('id')
                Livewire.emit('delDiagnostico', id)
            }

        })

        $(document).on('printDoc', function(e) {
            let id = e.detail.id
            setTimeout(() => {
                window.open('/diagnosticos/document/' + id)
            }, 700);
        })
    </script>
    @endpush
</div>