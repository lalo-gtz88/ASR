<div>

    <style>
        #map {
            height: 80vh;
        }

        .table-details td:first-child {
            background-color: #495057;
            color: #FFF;
        }
    </style>

    <div class="container-fluid mt-3">
        <div class="row">

            <div class="d-flex align-items-center justify-content-between col-12 mb-2">
                <div class="d-flex align-items-center">
                    <h4>Enlace {{$referencia}}</h4>
                </div>

                <div>
                    <a href="{{route('editarEnlace', $uniqueId)}}" class="btn btn-secondary mr-2"><i class="fa fa-edit"></i> Editar</a>
                    <button onclick="borrar({{$uniqueId}})" class="btn btn-danger mr-2"><i class="fa fa-trash"></i> Eliminar</button>
                    <button class="btn btn-info mr-2"><i class="fa fa-flag"></i> Nuevo reporte</button>
                </div>º
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4">
                <table class="table-details table table-bordered">
                    <tr>
                        <td>Referencia</td>
                        <td>{{$referencia}}</td>
                    </tr>
                    <tr>
                        <td>Descripción</td>
                        <td>{{$descripcion}}</td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td>{{$telefono}}</td>
                    </tr>
                    <tr>
                        <td>Domicilio</td>
                        <td>{{$domicilio}}</td>
                    </tr>
                    <tr>
                        <td>Sitio</td>
                        <td>{{$sitio}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{$status}}</td>
                    </tr>
                    <tr>
                        <td>Proveedor</td>
                        <td>{{$proveedor}}</td>
                    </tr>
                    <tr>
                        <td>Tipo</td>
                        <td>@if($tipo) {{$tipo}} @else --- @endif </td>
                    </tr>
                    <tr>
                        <td>Servicio</td>
                        <td>@if($servicio) {{$servicio}} @else --- @endif </td>
                    </tr>
                    <tr>
                        <td>Área</td>
                        <td>@if($area) {{$area}} @else --- @endif </td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td>@if($observaciones) {{$observaciones}} @else --- @endif </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-8">

                <div id="map" wire:ignore></div>

            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        var lat = @json($lat);
        var lng = @json($lng);

        var map = L.map('map', {

            doubleClickZoom: false

        });

        setTimeout(() => {
            map.setView([lat, lng], 13)
        }, 200);

        // Agregar capa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);



        //agrega el marcador a la posicion por doble click
        var marker;

        marker = L.marker([lat, lng]).addTo(map)

        $(document).on('volverEnlaces', function() {
            setTimeout(() => {
                location.href = "/enlaces"
            }, 1000);

        })


        function borrar(id) {
            if (confirm('Estas seguro que deseas borrar el enlace?')) {

                Livewire.dispatch('borrar', {
                    id: id
                })
            }
        }


        $(document).on('volverEnlaces', function() {
            setTimeout(() => {
                location.href = "/enlaces"
            }, 1000);

        })
    </script>
    @endpush

</div>