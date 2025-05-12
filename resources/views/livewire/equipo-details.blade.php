<div>

    <div class="container-fluid mt-3">
        @if(!str_contains(url()->previous(),'ticket'))
        <a href="{{route('equipos')}}" class=" mr-2"><i class="fa fa-arrow-circle-left"  style="font-size: 13px;"></i> Atras</a>
        @endif
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <h5>{{mb_strtoupper($serviceTag)}}</h5>
            </div>
            <div>
                <a href="{{route('editarEquipo', $uniqueId)}}" class="btn btn-primary"  style="font-size: 13px;"><i class="fa fa-edit"  style="font-size: 13px;"></i> Editar</a>
            </div>
        </div>

        <div>

            <img src="{{asset('storage/fotosEquipos/') .'/'. $photo}}" class="img-thumbnail mb-2" style="height:200px; width:200px;">

            <table class="table table-sm table-bordered mr-2 table-details">
                <tr>
                    <td style="width:10%" class="text-right">DSI</td>
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