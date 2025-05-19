<div>
    <?php

    use Carbon\Carbon; ?>
    <div class="container">
        <div class="row">

            <div class="col-lg-9 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('usuarios')}}">Usuarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permisos</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-9 mx-auto">
                <div class="card">
                    <div class="card-header  bg-secondary text-white">
                        <div class="card-title">Asignación de permisos</div>
                    </div>
                    <div class="card-body">
                        <div><strong>Nombre: </strong>{{$user->name.' '.$user->lastname}}</div>
                        <div><strong>Usuario: </strong>{{$user->username}}</div>
                        <div><strong>Usuario desde: </strong>{{Carbon::parse($user->created_at)->diffForHumans() }}</div>
                        <div><strong>Ultima actualización: </strong>{{Carbon::parse($user->updated_at)->diffForHumans() }}</div>
                        <hr>
			<div wire:init="$set('readyToLoad', true)">
			@if($readyToLoad)
                        <h6>Permisos de usuario</h6>
		
                        @foreach($permisos as $item)
                        <div class="form-check">
                            <label class="form-check-label" for="chk{{$item->id}}">
                                <input class="form-check-input" wire:model.live="permisosAsignados" id="chk{{$item->id}}" type="checkbox" value="{{$item->name}}">
                                {{$item->name}}
                            </label>
                        </div>
                        @endforeach

                        <button class="btn btn-primary mt-4" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
			@else
			<div class="d-flex align-items-center" style="padding:10px;">
				<div class="spinner-border text-info" role="status"></div>&nbsp;&nbsp;
			<div> Cargando información...</div>
			</div>
			@endif
			</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>