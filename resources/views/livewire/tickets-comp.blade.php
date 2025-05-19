<div>

    <div class="row my-3">
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Tickets abiertos" metodo="totalTickets" color="bg-primary" icon="fa fa-bar-chart fa-lg" />
        </div>
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Tickets pendientes" metodo="pendientes" color="bg-secondary" icon="fa-solid fa-hourglass-half" />
        </div>
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Tickets asignados" metodo="asignados" color="bg-info" icon="fa-solid fa-users-gear" />
        </div>
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Prioridad baja" metodo="bajos" color="bg-success" icon="fa-solid fa-arrow-down"  />
        </div>
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Prioridad media" metodo="medios" color="bg-warning" icon="fa-solid fa-minus"  />
        </div>
        <div class="col-md-2">
            <livewire:caja-estadistica etiqueta="Prioridad alta" metodo="altos" color="bg-danger" icon="fa-solid fa-arrow-up"  />
        </div>
    </div>

    <livewire:tickets-list />
    
</div>