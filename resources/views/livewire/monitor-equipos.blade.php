<div style="margin-top:  65px;">
    <div class="container">

    <div wire:poll.10s="getEquipos()">
            <h5>Monitoreo de equipos en la red</h5>
            <hr>
            <table class="table table-sm small mt-2">
                <thead>
                    <th>IP</th>
                    <th>Dispositivo</th>
                    <th>Tipo</th>
                    <th class="text-center">En Linea</th>
                </thead>
                @foreach($dispositivos as $item)
                <tr>
                    <td>{{$item->direccion_ip}}</td>
                    <td>{{$item->relDispositivo->service_tag}}</td>
                    <td>{{$item->relDispositivo->relTipoEquipo->nombre}}</td>
                    <td class="text-center">
                        @if($item->status== 'online')
                        ✅
                        @endif
                        @if($item->status== 'offline')
                        ❌
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>


        </div>
    </div>
</div>