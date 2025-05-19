<div>
    <style>

    .content_equipo{
        overflow-x: auto;
    }

    </style>
    <div class="contenedor">
        <div class="content_datos">
            <div class="mb-3">
                <a href="{{route('tickets')}}"><i class="fa-solid fa-circle-left"></i> Atras</a>
            </div>
            <livewire:actualizar-ticket :$ticketID />
        </div>
        <div class="content_comentarios">
            <livewire:comentarios-ticket :$ticketID />
        </div>
        <div class="content_equipo">
            @if($equipo)
            <div>
                <livewire:equipo-details wire:key="form-equipo-{{ $uniqueId }}" :uniqueId="$equipo->id" />
            </div>
            @else
            <div class="h-100 d-flex align-items-center justify-content-center bg-light">
                <p><i class="fa fa-exclamation-circle text-primary"></i> No se encontró equipo asociado con la IP</p>
            </div>
            @endif
        </div>
    </div>
</div>