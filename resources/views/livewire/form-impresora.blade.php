<div>
    <div>
        <label for="ram">Propietario</label>
        <select wire:model="proveedor" id="proveedor" class="form-control">
            <!-- lista de propietarios -->
            <option>JMAS</option>
            <option>CopiLaser</option>
            <option>Sen Integral</option>
        </select>
        @error('proveedor')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="col-lg-6 mt-3">

        <div class="form-check form-check-inline">
            <label class="form-check-label" for="defaultCheck1">
                <input class="form-check-input" type="checkbox" wire:model="aColor" id="defaultCheck1"> A color
            </label>
        </div>

        <div class="form-check form-check-inline">
            <label class="form-check-label" for="defaultCheck2">
                <input class="form-check-input" type="checkbox" wire:model="multifuncional" id="defaultCheck2"> Multifuncional
            </label>
        </div>
    </div>
</div>