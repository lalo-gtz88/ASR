<div>

    <div class="container-fluid my-4">
        <div class="row mb-3">
            <h4 class="col-md-3">Equipo {{mb_strtoupper($serviceTag)}}</h4>

             <div class="col-12 col-md-2 offset-md-7 text-md-end text-start mt-2 mt-md-0">
                <a href="{{route('editarEquipo', $uniqueId)}}" class="btn btn-primary"  style="font-size: 13px;"><i class="fa fa-edit"  style="font-size: 13px;"></i> Editar</a>
            </div>

        </div>

        <div>
            @if($this->modelo)
            <img src="{{asset('storage/fotosEquipos/') .'/'. $photo}}" class="img-thumbnail mb-2" style="height:200px; width:200px;">
            @endif
            <table class="table table-sm table-bordered mr-2 table-details">
                <tr>
                    <td class="col-md-2 text-right">DSI</td>
                    <td>{{$inventario}}</td>
                </tr>
                <tr>
                    <td class="text-right">Tipo</td>
                    <td>{{$tipoNombre}}</td>
                </tr>
                <tr>
                    <td class="text-right">Marca</td>
                    <td>{{$marca}}</td>
                </tr>
                <tr>
                    <td class="text-right">Modelo</td>
                    <td>{{$modelo}}</td>
                </tr>
                <tr>
                    <td class="text-right">Fecha de adquisición</td>
                    <td>{{Carbon\Carbon::parse($fechaDeAdquisicion)->format('d/ m/ Y')}}</td>
                </tr>
                <tr>
                    <td class="text-right">Dirección IP</td>
                    <td>{{$direccionIp}}</td>
                </tr>
                <tr>
                    <td class="text-right">Dirección MAC</td>
                    <td>{{$direccionMac}}</td>
                </tr>
            </table>

            @if($tipo == 1)
            <livewire:pc-details :uniqueId=" $uniqueId" />
            @endif

            @if($tipo == 2)
            <livewire:pc-details :uniqueId="$uniqueId" />   
            @endif

            @if($tipo == 3)
            <livewire:impresora-details :uniqueId="$uniqueId" />
            @endif

        </div>

    </div>
</div>