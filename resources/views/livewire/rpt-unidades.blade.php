<div>
    <h2 class="card-title">Reporte de unidades</h2>
    <div class="card text-left">
        <div class="card-body">

            <label for="periodo"><strong>Parámetros</strong></label>


            <div class="d-flex align-items-end justify-content-start">
                <div class="me-2">
                    <label for="inicio">Inicio</label>
                    <input type="date" name="inicio" id="inicio" class="form-control @error('inicio') is-invalid @enderror" wire:model="inicio">
                    @error('inicio')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="me-2">
                    <label for="termina">Termina</label>
                    <input type="date" name="termina" id="termina" class="form-control mr-2  @error('termina') is-invalid @enderror" wire:model="termina">
                    @error('termina')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="me-2">
                    <label for="unidad" class="mr-2">Unidad</label>
                    <select name="unidad" id="unidad" class="form-control mr-2" wire:model="unidad">
                        <option value="">---TODAS---</option>
                        <option>0992 [Ranger]</option>
                        <option>1181 [F-150]</option>
                        <option>1917 [Hilux]</option>
                    </select>
                </div>

                <button class="btn btn-primary" wire:click="getResults"><i class="fa fa-check"></i> Aceptar</button>

            </div>

            <hr>
            @if($submitted)
            @if(count($results) > 0 )
            <div class="table-responsive" style="max-height: 50vh; overflow-y:auto;">
                <table id="tableReporte" class="table table-bordered table-striped table-sm small">
                    <thead class="sticky-top">
                        <th>ID</th>
                        <th>Abierto</th>
                        <th>Cerrado</th>
                        <th>Departamento</th>
                        <th>Categoría</th>
                        <th>Status</th>
                        <th>Unidad</th>
                        <th>Edificio</th>
                        <th>Usuario</th>
                    </thead>
                    <tbody>
                        @foreach($results as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{Carbon\Carbon::parse($item->abierto)->format('d/m/Y H:i')}}</td>
                            <td>{{Carbon\Carbon::parse($item->cerrado)->format('d/m/Y H:i')}}</td>
                            <td>{{$item->departamento}}</td>
                            <td>{{$item->categoria}}</td>
                            <td>{{Str::upper($item->status)}}</td>
                            <td>{{$item->unidad}}</td>
                            <td>{{$item->edificio}}</td>
                            <td>{{$item->usuario}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-dark">No se encontrarón resultados</p>
            @endif
            @endif

        </div>
        @if(count($results) > 0 )
        <div class="card-footer">
            <button class="btn-success btn export-btn"><i class="fa fa-share"></i> Exportar</button>
        </div>
        @endif
    </div>

    @push('custom-scripts')

    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tableReporte');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('Reporte de unidades.' + (type || 'xlsx')));
        }

        $(document).on('click', '.export-btn', function() {

            ExportToExcel()

        })
    </script>

    @endpush

</div>