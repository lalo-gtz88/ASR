<div>
    <?php

    use Carbon\Carbon; ?>

    <div class="container pt-2">

        <h4>Diagnósticos</h4>
        
        <div class="d-flex align-items-end justify-content-between mb-3">
            <input type="search" name="search" id="search" wire:model="search" class="form-control form-control-sm col-lg-3" placeholder="Buscar...">
            <a href="{{route('nuevo.diagnostico')}}"  class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nuevo</a>
        </div>

        @if(count($diagnosticos) > 0)
        <div class="card">
            <div class="card-body p-0" >

                <div class="table-responsive" style="max-height:650px;">
                    <table id="table-diagnosticos" class="table table-sm small" style="font-size: 12px;">
                        <thead class="sticky-top">
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th>Cargo</th>
                            <th>Dictamen</th>
                            <th># de elementos</th>
                            <th>Realizado por</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach($diagnosticos as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    {{$item->nombre_sol}}
                                    @if($item->ext_sol != null) <br>
                                    <span class="text-muted">EXT {{$item->ext_sol}}</span>
                                    @endif
                                </td>
                                <td>{{$item->cargo_sol}}</td>
                                <td>{{$item->dictamen}}</td>
                                <td>{{$item->numElementos}}</td>
                                <td>{{$item->realizado}}</td>
                                <td>{{Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                <td>
                                    <a href="{{route('docDiagnostico', $item->id)}}" target="_blank" style="font-size: larger;"><i class="fa fa-file text-primary" title="Ver documento"></i></a> &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('editar.diagnostico', $item->id)}}" style="font-size: larger;"><i class="fa fa-pencil text-info" title="Editar"></i></a> &nbsp;&nbsp;&nbsp;
                                    <a href="#" data-id="{{$item->id}}" class="btnDel" style="font-size: larger;"><i class="fa fa-minus text-danger" title="Eliminar"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{$diagnosticos->links()}}
            </div>
        </div>

        @else
        <h4>NO SE ENCONTRARÓN DIAGNÓSTICOS</h4>
        @endif
    </div>

    <br><br>



    <!-- ******************************************************************************************************************************************************************************************************************************************************* -->


    <!-- Modal para nuevos diagnosticos -->

    <!-- ./modal para nuevos diagnostico -->


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