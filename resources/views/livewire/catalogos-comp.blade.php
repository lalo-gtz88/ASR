<div>
    <div class="container-fluid pt-3">

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne">
                        Edificios
                    </button>
                </h2>
                <div
                    id="collapseOne"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample"> 
                    <div class="accordion-body">
                        <livewire:edificios />
                    </div>
                </div>
            </div>


            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="true"
                        aria-controls="collapseTwo">
                        Departamentos
                    </button>
                </h2>
                <div
                    id="collapseTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <livewire:departamentos />
                    </div>
                </div>
            </div>


            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="true"
                        aria-controls="collapseThree">
                        Categorias para los tickets
                    </button>
                </h2>
                <div
                    id="collapseThree"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <livewire:categorias />
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
                    Livewire.emitTo('edificios', 'delItem', id)
                }
                if ($(this).hasClass('editDpto')) {
                    Livewire.emitTo('departamentos', 'delItem', id)
                }
                if ($(this).hasClass('editCat')) {
                    Livewire.emitTo('categorias', 'delItem', id)
                }
            }
        })
    </script>
    @endpush
</div>