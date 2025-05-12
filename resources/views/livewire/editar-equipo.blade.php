<div>
    <div class="container-fluid mt-3">
        
        <div class="d-flex flex-column">
            @if(str_contains(url()->previous(),'ticket'))
            <a href="{{url()->previous()}}" class="mr-2"><i class="fa-solid fa-circle-left" style="font-size: 13px;" title="Atras"></i> Atras</a>
            @else
            <a href="{{route('detalleEquipo', $uniqueId)}}" class="mr-2"><i class="fa-solid fa-circle-left" style="font-size: 13px;" title="Atras"></i> Atras</a>
            @endif
            <h5>{{mb_strtoupper($serviceTag)}}</h5>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <livewire:form-equipo :$uniqueId :editable=true />
                            </div>
                            <div class="col-lg-6">
                                @if($tipo == 1 || $tipo == 2)
                                <livewire:form-pc :equipoId="$uniqueId" :editable=true />
                                @endif
                                @if($tipo == 3)
                                <livewire:form-impresora :equipoId="$uniqueId" :editable=true />
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-success" wire:click="$dispatchTo('form-equipo', 'guardar')"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <br><br>
    </div>
</div>