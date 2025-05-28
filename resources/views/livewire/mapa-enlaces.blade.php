<div>
    <style>
        #map {
            height: 85vh;
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h2>Mapa completo</h2>
            <div class="d-flex align-items-center">
                <label class="me-2" for="sitio">Sitio</label>
                <select wire:model="sitio" id="sitio" wire:change="getEnlaces()" class="form-control">
                    <option value="">---TODOS---</option>
                    @foreach($sitios as $key => $value)
                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="map" wire:ignore></div>

    </div>

    @push('custom-scripts')
    <script>
        var map = L.map('map', {
            doubleClickZoom: false,
        });

        var marker;
        var markerGroup = L.layerGroup().addTo(map); //declaramos un markerGroup para guardar los marker ahi

        map.setView([31.7086, -106.454086], 11);

        // Agregar capa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        $(document).ready(function() {

            Livewire.dispatch('obtenerEnlaces')
        })

        $(document).on('enviarEnlaces', function(e) {
            //obtenemos los enlaces desde el controller
            var enlaces = e.detail.enlaces
            markerGroup.clearLayers();

            $.each(enlaces, function(index, valor) {
                //console.log(valor.lat)

                marker = L.marker([valor.lat, valor.lng]).addTo(markerGroup)
            })

            map.add(markerGroup)
        })
    </script>
    @endpush
</div>