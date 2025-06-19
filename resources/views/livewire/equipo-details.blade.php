<div>

    <div class="container-fluid my-4">
        <div class="row mb-3">
            <h4 class="col-md-3">Equipo {{mb_strtoupper($serviceTag)}}</h4>

            <div class="col-12 col-md-2 offset-md-7 text-md-end text-start mt-2 mt-md-0">
                <a href="{{route('editarEquipo', $uniqueId)}}" class="btn btn-primary" style="font-size: 13px;"><i class="fa fa-edit" style="font-size: 13px;"></i> Editar</a>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                @if($this->modelo)
                <img src="{{asset('storage/fotosEquipos/') .'/'. $photo}}" class="img-thumbnail mb-2" style="height:200px; width:200px;">
                @endif
            </div>
            <div class="row">
                <div class="col-md-5">

                    <table class="table table-bordered table-details">
                        <tr>
                            <td class="col-md-4">DSI</td>
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

                <div class="col-md-7">
                    @if(count($this->historial)>0)
                    <h4>Historial de cambios</h4>
                    <table class="table">
                        <thead class="table-primary">
                            <th>Fecha</th>
                            <th>Campo</th>
                            <th>Valor anterior</th>
                            <th>Valor nuevo</th>
                            <th>Usuario</th>
                        </thead>
                        <tbody>
                            @foreach($historial as $key=> $value)
                            <tr>
                                <td>{{Carbon\Carbon::parse($value->created_at)->format('d-M-Y H:i a')}}</td>
                                <td>{{$value->campo}}</td>
                                <td>{{$value->valor_anterior}}</td>
                                <td>{{$value->valor_nuevo}}</td>
                                <td>{{$value->relUser->nombreCompleto}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else

                    <div class="d-flex align-items-center justify-content-center">
                        <p class="text-muted"><i class="fa fa-exclamation-circle text-primary"></i> No se encontró historial</p>
                    </div>

                    @endif
                </div>

            </div>

        </div>
    </div>