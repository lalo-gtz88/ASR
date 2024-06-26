<?php

use Carbon\Carbon; ?>
<div>
    @if(count($rpts)>0)
    <marquee behaivor="slide" direction="left" scrollamount="3">

        @foreach($rpts as $item)

        <span style="font-size:2rem; margin-right:50px;">
            @if(Carbon::createMidnightDate(now())->diffInDays(Carbon::createMidnightDate($item->rhalta)) == 0)
            <span><i class="fa fa-circle text-info"></i></span>
            @elseif(Carbon::createMidnightDate(now())->diffInDays(Carbon::createMidnightDate($item->rhalta)) == 1)
            <span><i class="fa fa-circle text-warning"></i></span>
            @elseif(Carbon::createMidnightDate(now())->diffInDays(Carbon::createMidnightDate($item->rhalta)) >= 2)
            <span><i class="fa fa-circle text-danger"></i></span>
            @endif
           <strong>REPORTE {{$item->folio}} .- </strong>{{$item->wsname}}
        </span>


        @endforeach
    </marquee>
    @endif

    <div class="container-fluid">

        <div class="row mb-1">

            <div class="col-lg-3 col-6">
                <div class="card border-circle rounded text-white" style="background-color: rgb(1, 46, 105,0.9);">
                    <div class=" card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h1 style="font-weight: 700;">{{count($totalTickets)}}</h1>
                                <h4>Tickets abiertos</h4>
                            </div>
                            <i class="fa fa-ticket fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="card  border-circle rounded text-white" style="background-color: rgb(40, 167, 69, 0.8 );">
                    <div class=" card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h1 style="font-weight: 700;">{{count($ticketsDone)}}</h1>
                                <h4>Prioridad baja</h4>
                            </div>
                            <i class="fa fa-arrow-down fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="cardborder-circle rounded text-dark" style="background-color: rgb(255, 193, 7, 0.5 );">
                    <div class=" card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h1 style="font-weight: 700;">{{count($ticketsWarning)}}</h1>
                                <h4>Prioridad media</h4>
                            </div>
                            <i class="fa fa-minus fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="card border-circle rounded text-white" style="background-color: rgb(220, 53, 69 , 0.8 );">
                    <div class=" card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h1 style="font-weight: 700;">{{count($ticketsDanger)}}</h1>
                                <h4>Urgentes</h4>
                            </div>
                            <i class="fa fa-arrow-up fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row " style="height: 75vh;">

            @if (count($tickets) > 0)

            <div class="col-lg-8">
                <div class="card h-100" id="card-tickets">

                    <div class="card-body p-2">
                        {{-- Tabla de tickets --}}
                        <div wire:init="loadTickets">
                            @if ($readyToLoad)

                            <h2>TICKETS DE SERVICIO</h2>
                            <div id="content-tickets" style="overflow: auto">
                                <table id="table-tickets" class="table table-sm table-striped small" style="font-size: 13px;">
                                    <thead class="sticky-top text-dark">
                                        <th style="width: 50px;">ID</th>
                                        <th class="text-center" style="width:40px">Prioridad</th>
                                        <th>Tema</th>
                                        <th>Asignado</th>
                                        <th>Categoria</th>
                                        <th>Creado</th>
                                        <th>Edificio</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $item)
                                        <tr>
                                            <td style="width: 50px;">{{$item->id}}</td>
                                            <td class="text-center" style="width:40px">
                                                @switch($item->prioridad)
                                                @case('Media')
                                                <i class="fa fa-circle text-warning" title="Prioridad Media"></i>
                                                @break
                                                @case('Baja')
                                                <i class="fa fa-circle text-success" title="Prioridad Baja"></i>
                                                @break
                                                @case('Alta')
                                                <i class="fa fa-circle text-danger" title="Prioridad Alta"></i>
                                                @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <span data-toggle="tooltip" title="Ver detalles del ticket">{{ Str::upper(substr($item->tema, 0, 50))  }}</span>
                                            </td>
                                            <td>{{ Str::upper($item->asignado) }}</td>
                                            <td>{{ Str::upper($item->categoria) }}</td>
                                            <td>
                                                {{ Carbon::parse($item->created_at)->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ Str::upper($item->edificio) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                            @else

                            <div class="d-flex align-items-center" style="padding: 10px;">
                                <div class="spinner-border text-info" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                &nbsp;&nbsp;
                                <div>Cargando tickets...</div>
                            </div>

                            @endif


                        </div>
                        {{-- ./tabla de tickets --}}
                    </div>
                </div>
            </div>

            @else

            <div class="col-lg-8">
                <hr>
                <h5>NO SE ENCONTRARON TICKETS</h5>
            </div>

            @endif

            <div class="col-lg-4">
                <livewire:charts></livewire:charts>
            </div>
        </div>

    </div>
    @push('custom-scripts')
    <script>
        $(document).ready(function() {
            setInterval(() => {
                window.location.reload()
            }, 300000);
        })
    </script>
    @endpush
</div>