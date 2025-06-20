<div>
    <style>
        #tblEquipos tbody tr td {

            padding: 0.5px;
            font-size: 13px;
        }
    </style>

    <div class="container-fluid">

        <h2>Equipos en stock</h2>

        <div class="row">

            <div class="col-md-4">
                <input type="search" name="search" id="search" class="form-control" placeholder="Buscar..." wire:model.live="search" wire:keypress="getEquipos">
            </div>

            <div class="col-md-4">
                <select name="filtro" id="filtro" class="form-select" wire:model.live="filtroTipo">
                    <option value="">TODOS</option>
                    @foreach($cat_tipos_equipos as $item)
                    <option>{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>


            <div class="dropdown col-md-4">
                <button class="btn btn-primary dropdown-bs-toggle col-12" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-plus"></i> Entrada
                </button>
                <div class="dropdown-menu" style="z-index: 10000;">
                    <button id="btnNuevo" class="dropdown-item" type="button">Manual</button>
                    <button id="importButton" class="dropdown-item" type="button">Importar</button>
                </div>
            </div>

        </div>

        <div style="color:#012E69; width: 100%;" class="text-center mt-4"><i><strong> Mostrando {{count($equipos)}} resultados...</strong></i></div>
        @if(count($equipos) > 0)

        <div class="card">

            <div class="card-body" style="height: 65vh; overflow: auto; padding:0">

                <div class="table-responsive">
                    <table id="tblEquipos" class="table table-sm small">
                        <thead class="sticky-top table-primary" style="z-index: 1;">
                            <th style="cursor:pointer;" wire:click="orderEq('et')">DSI / ST @if($orderField == 'et') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('tip_id')">Tipo de ID @if($orderField == 'tip_id') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('tip')">Equipo @if($orderField == 'tip') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('condicion')">Condición @if($orderField == 'condicion') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('almacen')">Almacén @if($orderField == 'almacen') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('created_at')">Creado @if($orderField == 'created_at') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <th style="cursor:pointer;" wire:click="orderEq('updated_at')">Ultima actualización @if($orderField == 'updated_at') @if($orderTable == 'asc') <i class="fa fa-sort-asc"></i> @else <i class="fa fa-sort-desc"></i> @endif @endif</th>
                            <!-- <th>Cantidad</th> -->
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach($equipos as $item)
                            <tr>
                                <td>{{$item->et}}</td>
                                <td>{{$item->tip_id}}</td>
                                <td>
                                    {{$item->tip}} <br>
                                    <span class="text-muted"><small>{{$item->not}}</small></span>
                                </td>
                                <td>{{$item->condicion}}</td>
                                <td>{{$item->almacen}}</td>
                                <td>
                                    {{Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}
                                    <br>
                                    <span class="text-muted">{{$item->creador}}</span>

                                </td>
                                <td>{{Carbon\Carbon::parse($item->updated_at)->diffForHumans()}}
                                    <br>
                                    <span class="text-muted">{{$item->editor}}</span>
                                </td>
                                <!-- <td>
                            <span><strong>{{$item->cant}}</strong></span>
                            <a href="#" data-toggle="tooltip" title="Stock" class="p-0 mr-3" ><i class="fa fa-archive" ></i></a>
                            </td> -->
                                <td>
                                    <a href="#" data-toggle="tooltip" title="Editar" class="p-0 me-3" wire:click.prevent="edit({{$item->id}})"><i class="fa fa-pencil text-secondary"></i></a>
                                    <a href="#" wire:click.prevent="showModalSalida({{$item->id}})" data-toggle="tooltip" title="Salida de almacén" class="p-0"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <button class="btn-success btn export-btn mt-3"><i class="fa fa-share"></i> Exportar</button>

        @else

        <p class="text-">No se encontrarón resultados</p>

        @endif
    </div>

    <!-- Modal Equipo -->
    <div class="modal" id="modalEq" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@if($editar) Editar @else Nuevo @endif equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="tipoId">Tipo de ID</label>
                    <select name="tipoId" id="tipoId" class="form-control" wire:model="tipoID">
                        <option>DSI</option>
                        <option>ST</option>
                        <option>SN</option>
                    </select>

                    <label for="">DSI / Service Tag / Número de serie</label>
                    <input type="text" class="form-control" wire:model="etiqueta">

                    <label for="tipoEq">Tipo de equipo</label>
                    <select name="tipoEq" id="tipoEq" class="form-control" wire:model.live="tipoEq">
                        @foreach($tiposEquipos as $item)
                        <option>{{$item->nombre}}</option>
                        @endforeach
                    </select>

                    <label for="notas">Descripcion / Notas</label>
                    <textarea name="notas" id="notas" class="form-control" wire:model="notas"></textarea>

                    <label for="condicion">Condición</label>
                    <select name="condicion" id="condicion" wire:model.live="condicion" class="form-control">
                        <option>NUEVO</option>
                        <option>USADO</option>
                    </select>

                    <label for="almacen">Almacén</label>
                    <select name="almacen" id="almacen" class="form-control" wire:model.live="almacenID">
                        <option value="">---Selecciona una opción---</option>
                        @foreach($listAlmacenes as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    @if($editar)
                    <button type="button" class="btn btn-primary" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal salida almacen-->
    <div class="modal" id="modalSalida" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salida de almacén</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="destino">Destino</label>
                    <select name="destino" id="destino" class="form-control" wire:model.live="destino">
                        <option>ASIGNAR EQUIPO</option>
                        <option>DAR DE BAJA</option>
                    </select>

                    @if($destino == 'ASIGNAR EQUIPO')
                    <div>
                        <label for="tecnico">Tecnico que instala</label>
                        <select name="tecnico" id="tecnico" class="form-control" wire:model.live="tecnico">
                            <option value="">---Selecciona una opción---</option>
                            @foreach($tecnicos as $item)
                            <option value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                            @endforeach
                        </select>
                        @error('tecnico')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex flex-column">
                        <label for="quien_reporta">Usuario</label>
                        <input type="text" name="quien_reporta" id="quien_reporta" wire:model="quien_reporta" class="form-control">
                        @error('quien_reporta')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex flex-column">
                        <label for="edificio">Edificio</label>
                        <select class="form-control" name="edificio" id="edificio" wire:model="edificio">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($edificios as $item)
                            <option>{{Str::upper($item->nombre)}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="edificio" id="edificio" wire:model.live="edificio" class="form-control"> -->
                    </div>
                    <div class="d-flex flex-column">
                        <label for="departamento">Departamento</label>
                        <select class="form-control" name="departamento" id="departamento" wire:model.live="departamento">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($departamentos as $item)
                            <option>{{Str::upper($item->nombre)}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="departamento" id="departamento" wire:model.live="departamento" class="form-control"> -->
                        @error('departamento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex flex-column">
                        <label for="autoriza">Autoriza</label>
                        <input type="text" name="autoriza" id="autoriza" wire:model="autoriza" class="form-control">
                    </div>
                    <div class="d-flex flex-column">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad" wire:model.live="prioridad" class="form-control">
                            <option>Baja</option>
                            <option>Media</option>
                            <option>Alta</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_de_atencion">Fecha de atención</label>
                        <input type="date" class="form-control" wire:model="fecha_de_atencion">
                    </div>

                    @endif

                </div>
                <div class="modal-footer">
                    @if($destino == 'DAR DE BAJA')
                    <button type="button" id="btnDelItem" class="btn btn-primary">Aceptar</button>
                    @endif
                    @if($destino == 'ASIGNAR EQUIPO')
                    <button type="button" wire:click="saveSalida" class="btn btn-primary">Aceptar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Importar archivos -->
    <div class="modal fade" id="modalImport" role="dialog" data-backdrop="static" data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Importar equipos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="alert alert-info">
                        <strong>INSTRUCCIONES</strong>
                        <ol>
                            <li>
                                Llenar los valores en un archivo con formato .xlsx en el siguiente orden <br>
                                ID, Tipo, Descripcion, Tipo de ID y Condición
                            </li>
                            <li>
                                Elegir el almacén en el que deseas guardar el stock
                            </li>
                            <li>Seleccionar el archivo</li>
                            <li>
                                Clic en el botón "Importar"
                            </li>
                        </ol>
                    </div> -->
                    <form id="frmImport" action="{{route('uploadEquipos')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="almacenImp">Almacén</label>
                            <select name="almacenImp" id="almacenImp" class="form-control">
                                <option value="">---Selecciona una opción---</option>
                                @foreach($listAlmacenes as $item)
                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                            @error('almacenImp')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="fileXls">Archivo</label>
                            <input type="file" name="fileXls" id="fileXls" class="form-control">
                            @error('fileXls')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="frmImport" class="btn btn-primary"><i class="fa fa-upload"></i> Importar</button>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')

    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tblEquipos');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('Reporte de equipos.' + (type || 'xlsx')));
        }

        $(document).on('click', '#btnNuevo', function() {

            $('#modalEq').modal('show')
        })

        $(document).on('editar', function() {

            $('#modalEq').modal('show')

        })

        $(document).on('hide.bs.modal', '#modalEq, #modalSalida', function() {

            Livewire.dispatch('reload')
        })

        $(document).on('shoModalSalida', function() {


            $('#modalSalida').modal('show')

        })

        $(document).on('click', '#btnDelItem', function() {

            if (confirm("Estas seguro de dar de baja el equipo?"))
                Livewire.dispatch("delete")

        })

        $(document).on('closeModal', function() {


            $('.modal').modal('hide')

        })

        $(document).on('click', '.export-btn', function() {

            ExportToExcel()

        })

        $(document).on('click', '#importButton', function() {

            $('#modalImport').modal('show')
        })
    </script>

    @endpush


</div>