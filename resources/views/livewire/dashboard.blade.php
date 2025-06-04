<div class="container-fluid">
    <h2 class="mb-4">Panel de Tickets</h2>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tickets Abiertos</h5>
                    <h2>{{ $openCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pendientes</h5>
                    <h2>{{ $inProgressCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sin asignar</h5>
                    <h2>{{ $unAssigned }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 my-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tickets por Usuario Asignado</h5>
                    <canvas id="userChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>



        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tickets por Día</h5>
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>



    </div>


    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tickets por Estado</h5>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tickets por Edificio</h5>
                    <canvas id="edificioChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {

            const statusChart = new Chart(document.getElementById('statusChart'), {
                type: 'bar',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        label: 'Tickets',
                        data: @json($statusData),
                        backgroundColor: ['#0d6efd', '#ffc107', '#198754']
                    }]
                }
            });

            const dailyChart = new Chart(document.getElementById('dailyChart'), {
                type: 'line',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [{
                        label: 'Tickets por Día',
                        data: @json($dailyData),
                        fill: true,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.2)'
                    }]
                }
            });


            const userChartCanvas = document.getElementById('userChart');
            if (userChartCanvas) {
                const userChart = new Chart(userChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: @json($userLabels),
                        datasets: [{
                            label: 'Tickets asignados',
                            data: @json($userData),
                            backgroundColor: [
                                '#4e73df', // azul
                                '#1cc88a', // verde
                                '#36b9cc', // cian
                                '#f6c23e', // amarillo
                                '#e74a3b', // rojo
                                '#858796', // gris
                                '#fd7e14', // naranja
                                '#20c997' // verde menta
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.parsed.y} tickets`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            const ctx = document.getElementById('edificioChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($edificioLabels),
                        datasets: [{
                            data: @json($edificioData),
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                                '#e74a3b', '#858796', '#fd7e14', '#20c997',
                                '#6f42c1', '#fd7f6f', '#7eb0d5', '#b2e061'
                            ],
                            borderWidth: 1,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        indexAxis: 'y', // <- Esto es lo que la convierte en horizontal
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        return `${label}: ${value} tickets`;
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })

        document.addEventListener('DOMContentLoaded', function() {

            setInterval(function() {
                location.reload();
            }, 180000)

        })
    </script>
    @endpush
</div>