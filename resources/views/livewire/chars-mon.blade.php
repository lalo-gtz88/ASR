<div>
    <div class="card mb-2">
        <h2 class="pt-2 pl-2">Asignados</h2>
        <canvas id="chartBars"></canvas>
    </div>

    <div class="card mb-2 chart-container" style="position: relative;">
        <h2 class="pt-2 pl-2">Edificios</h2>
        <canvas style="max-height: 500px;" id="chartPie"></canvas>
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
                    }
                }
            });


            //Chart PIE
            new Chart(ctp, {
                type: 'pie',
                data: {
                    labels: labelsEdificio,
                    datasets: [{

                        label: edificios,
                        data: datosEdificios,
                        borderWidth: 3,
                        backgroundColor: colores
                    }],
                }

            })

        })
    </script>
    @endpush
</div>