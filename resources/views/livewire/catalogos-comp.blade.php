<div>
    <div class="container-fluid">

        <h2>Catálogos</h2>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Edificios</h5>
                        <p class="text-muted">Catálogo de edificios o centros de trabajo</p>
                        <a href="{{route('catalogos.tipo', 'edificios')}}" class="btn btn-primary btn-sm">Gestionar </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Departamentos</h5>
                        <p class="text-muted">Catálogo de departamentos</p>
                        <a href="{{route('catalogos.tipo', 'departamentos')}}" class="btn btn-primary btn-sm">Gestionar </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Categorías</h5>
                        <p class="text-muted">Catálogo de categorías para los ticket de servicio</p>
                        <a href="{{route('catalogos.tipo', 'categorias')}}" class=" btn btn-primary btn-sm">Gestionar </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Segmentos de red</h5>
                        <p class="text-muted">Catálogo de segmentos de red para el manejo de ip's</p>
                        <a href="{{route('catalogos.tipo', 'segmentos')}}" class=" btn btn-primary btn-sm">Gestionar </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Marcas y modelos</h5>
                        <p class="text-muted">Catálogo de marcas y modelos</p>
                        <a href="{{route('catalogos.tipo', 'marcas')}}" class=" btn btn-primary btn-sm">Gestionar </a>
                    </div>
                </div>
            </div>


        </div>


    </div>
    @push('custom-scripts')
    <script>
        $(document).on('click', '.editEd, .editDpto, .editCat', function() {
            if (confirm("¿Estas seguro?")) {
                let id = $(this).data('id')

                if ($(this).hasClass('editEd')) {
                    Livewire.dispatchTo('edificios', 'delItem', {
                        id: id
                    })
                }
                if ($(this).hasClass('editDpto')) {
                    Livewire.dispatchTo('departamentos', 'delItem', {
                        id: id
                    })
                }
                if ($(this).hasClass('editCat')) {
                    Livewire.dispatchTo('categorias', 'delItem', {
                        id: id
                    })
                }
            }
        })
    </script>
    @endpush
</div>