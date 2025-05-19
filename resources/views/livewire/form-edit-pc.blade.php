<div>
    <div>

        <div>
            <label for="nombreDeEquipo">Nombre de equipo</label>
            <input type="text" class="form-control" wire:model="nombreDeEquipo" id="nombreDeEquipo">
            @error('nombreDeEquipo')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div>
            <label for="ram">Memoria RAM</label>
            <input type="text" class="form-control" wire:model="ram" id="ram">
            @error('ram')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div>
            <label for="hdd">HDD</label>
            <input type="text" class="form-control" wire:model="hdd" id="hdd">
            @error('hdd')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div>
            <label for="sdd">SDD</label>
            <input type="text" class="form-control" wire:model="sdd" id="sdd">
            @error('sdd')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div>
            <label for="sistemaOperativo">Sistema operativo</label>
            <select class="form-control" wire:model="sistemaOperativo" id="sistemaOperativo">
                <option>Windows 10 Profesional</option>
                <option>Windows 11 Profesional</option>
                <option>Windows 7 Profesional</option>
                <option>Windows Centos Profesional</option>
                <option>Apple IOS</option>
                <option>Android</option>
                <option>IOS Cisco</option>
            </select>
            @error('sistemaOperativo')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div>
            <label for="usuario">Nombre de usuario</label>
            <input type="text" class="form-control" wire:model="usuario" id="usuario">
            @error('usuario')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div>
            <label for="usuarioRed">Usuario de red</label>
            <input type="text" class="form-control" wire:model="usuarioRed" id="usuarioRed">
            @error('usuarioRed')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div>
            <label for="monitores">Monitores</label>
            <input type="text" class="form-control" wire:model="monitores" id="monitores">
            @error('monitores')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>