<div>

    <div class="row g-2">

        <div class="col-md-3 pe-4">
            <livewire:actualizar-ticket :$ticketID />
        </div>

        <div class="col-md-6">
            <livewire:comentarios-ticket :$ticketID />
        </div>

        <div class="col-md-3">
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