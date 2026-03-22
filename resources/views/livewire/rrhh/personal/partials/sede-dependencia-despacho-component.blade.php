<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_sede2" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#2buscar-sedes-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_sede2" class="form-control form-control-xs bg-light" wire:model="sededestino" readonly required>
        </div>
        @error('sededestino')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txt_dependencia2" class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#2buscar-dependencias-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dependencia2" class="form-control form-control-xs bg-light" wire:model="dependenciadestino" readonly required>
        </div>
        @error('dependenciadestino')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_despacho2" class="fw-bold fs-6">Despacho</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#2buscar-despachos-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_despacho2" class="form-control form-control-xs bg-light" wire:model="despachodestino" readonly required>
        </div>
        @error('despachodestino')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>