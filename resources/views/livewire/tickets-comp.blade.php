<div>

    <div class="d-flex align-items-center justify-content-between">
        <livewire:caja-estadistica etiqueta="Tickets abiertos" metodo="totalTickets" />
        <livewire:caja-estadistica etiqueta="Tickets pendientes" metodo="pendientes" />
        <livewire:caja-estadistica etiqueta="Tickets asignados" metodo="asignados" />
        <livewire:caja-estadistica etiqueta="Prioridad baja" metodo="bajos" />
        <livewire:caja-estadistica etiqueta="Prioridad media" metodo="medios" />
        <livewire:caja-estadistica etiqueta="Prioridad alta" metodo="altos" />
    </div>

    <livewire:tickets-list />
    
</div>