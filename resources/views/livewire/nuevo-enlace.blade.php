<div>
    <style>
        #map {
            height: 80vh;
        }
    </style>

    <div class="container-fluid mt-3">

        <h4>Nuevo Enlace</h4>
        
        <div class="row">
            <div class="col-lg-4">
                <div>
                    <label for="referencia">Referencia *</label>
                    <input type="text" id="referencia" wire:model="referencia" class="form-control">
                    @error('referencia')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="descripcion">Descripción *</label>
                    <input type="text" id="descripcion" wire:model="descripcion" class="form-control">
                    @error('descripcion')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="sitio">Sitio *</label>
                    <select type="text" id="sitio" wire:model="sitio_id" class="form-control">
                        <option value=""> ---Selecciona una opción--- </option>
                        @foreach($sitios as $key => $value)
                        <option value="{{$value->id}}">{{$value->nombre}}</option>
                        @endforeach
                    </select>
                    @error('sitio_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <div>
                    <label for="telefono">Teléfono *</label>
                    <input type="text" id="telefono" wire:model="telefono" class="form-control">
                    @error('telefono')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="domicilio">Domicilio *</label>
                    <input type="text" id="domicilio" wire:model="domicilio" class="form-control">
                    @error('domicilio')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <livewire:cat-proveedores />

                <div>
                    <label for="contacto">Contacto</label>
                    <input type="text" id="contacto" wire:model="contacto" class="form-control">
                    @error('contacto')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="tipo">Tipo</label>
                    <select type="text" id="tipo" wire:model="tipo" class="form-control">
                        <option value=""> ---Selecciona una opción--- </option>
                        <option>ENLACE TRONCAL</option>
                        <option>LINEA ANALOGICA</option>
                        <option>TRONCALES DIGITALES</option>
                    </select>
                    @error('tipo')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="servicio">Servicios</label>
                    <select type="text" id="servicio" wire:model="servicio" class="form-control">
                        <option value=""> ---Selecciona una opción--- </option>
                        <option>INTERNET</option>
                        <option>DID</option>
                    </select>
                    @error('servicio')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="area">Área</label>
                    <input type="text" id="area" wire:model="area" class="form-control">
                    @error('area')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div>
                    <label for="observaciones">Observaciones</label>
                    <textarea type="text" id="observaciones" wire:model="observaciones" class="form-control" rows="4"></textarea>
                    @error('observaciones')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <input type="hidden" id="lat">
                <input type="hidden" id="lng">

                <button class="btn btn-success mt-2 col-12" wire:click="guardar()"><i class="fa fa-save"></i> Guardar</button>
                
            </div>
            <div class="col-lg-8">
                <div id="map" wire:ignore></div>
            </div>
        </div>
        
    
    </div>



    @push('custom-scripts')
    <script>

        var map = L.map('map', {
            doubleClickZoom: false,
        });
        var marker;

        map.setView([31.7086, -106.454086], 13);

        // Agregar capa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

        
        map.on('dblclick', function(e) {

            //si ya se encuentra un marcador lo elimina
            if (marker) {
                map.removeLayer(marker);
            }

            //agrega el marcador a la posicion por doble click
            marker = L.marker([e.latlng.lat, e.latlng.lng], {
                draggable: true,
            }).addTo(map)

            //manda el evento para setear las propiedades lat y lng 
            Livewire.dispatch('setLatLng', {
                lat: marker.getLatLng().lat,
                lng: marker.getLatLng().lng
            })
        })


        //mueve el marcador de posicion arrastrando
        marker.on('dragend', function(e) {

            marker = e.target;

            //manda el evento para setear las propiedades lat y lng 
            Livewire.dispatch('setLatLng', {
                lat: marker.getLatLng().lat,
                lng: marker.getLatLng().lng
            })

        })


    </script>
    @endpush


</div>