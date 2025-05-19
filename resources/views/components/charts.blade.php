<div>

    <div class="chart-container" style="position:relative; height:25vh;">
        <h6 class="p-2">ASIGNADOS</h6>
        <canvas id="chartBars"></canvas>
    </div>
    <br><br>
    <div class="chart-container" style="position:relative; height:25vh;">
        <h6 class="p-2">EDIFICIOS</h6>
        <canvas id="chartPie"></canvas>
    </div>


@push('custom-scripts')
<script>
    $(document).ready(function() {
        Livewire.emit('renderCharts')
    })

    $(document).on('loadCharts', function(e) {

        const labels = e.detail.labels
        const datosOpen = e.detail.datosOpen
        const datosPendientes = e.detail.datosPendientes
        const labelsEdificio = e.detail.labelsEdificio
        const datosEdificios = e.detail.datosEdificios

        const ctb = document.getElementById('chartBars');
        const ctp = document.getElementById('chartPie');

        var colores = [] // matriz de colores
        var edificios = "" // num x edificios en el pie

        // matriz de colores
        $.each(datosEdificios, element => {
            colores.push(`rgba(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},0.2)`)
        })

        // num x edificios en el pie
        $.each(datosEdificios, element => {
            edificios.label = edificios + element.edificio
        })

        //Chart BAR
        new Chart(ctb, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Abiertos',
                        data: datosOpen,
                        borderWidth: 2,
                        borderColor: 'rgba(1, 188, 197)',
                        backgroundColor: 'rgba(1, 188, 197, 0.2)'
                    },
                    {
                        label: 'Pendientes',
                        data: datosPendientes,
                        borderWidth: 2,
                        borderColor: 'rgba(1, 46, 105)',
                        backgroundColor: 'rgba(1, 46, 105, 0.2)'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
            }
        });


        //Chart PIE
        new Chart(ctp, {
            type: 'bar',
            data: {
                labels: labelsEdificio,
                datasets: [{

                    label: edificios,
                    data: datosEdificios,
                    borderWidth: 2,
                    borderColor: "#00BDC6",
                    backgroundColor: colores
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }

        })

    })
</script>
@endpush
</div>