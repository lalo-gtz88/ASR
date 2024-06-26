<div class="container mt-2">
    <div>
        <div class="card text-left">

            <div class="card-body">
                <div class="d-flex align-items-end justify-content-between">
                    <h4 class="card-title">Base de conocimiento</h4>
                    <a href="{{route('nuevaBase')}}" class="btn btn-link"><i class="fa fa-plus"></i> Nuevo</a>
                </div>
                <input type="search" wire:model="buscar" id="buscar" class="form-control" placeholder="Buscar...">
                <table class="table table-hover table-striped table-sm small">
                    <thead>
                        <th>Tema</th>
                        <th>Detalles</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th class="text-center">Seleccionar</th>
                    </thead>
                    <tbody>
                        @foreach($articulos as $art)
                        @if($art->private && $art->user_id != Auth::user()->id)
                        <!-- No hagas ni madre -->
                        @else
                        <tr>
                            <td>{{$art->tema}}</td>
                            <td>{{$art->detalles}}</td>
                            <td>{{$art->username->name .' '.$art->username->lastname}}</td>
                            <td>{{Carbon\Carbon::parse($art->created_at)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{route('editarBase', $art->id)}}" data-toggle="tooltip" title="Ver" class="p-0"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
