<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_sede" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-sedes-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="sedeorigen2" readonly required>
        </div>
        @error('sedeorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txt_dependencia" class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-dependencias-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen2" readonly required>
        </div>
        @error('dependenciaorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_despacho" class="fw-bold fs-6">Despacho</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-despachos-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_despacho" class="form-control form-control-xs bg-light" wire:model="despachoorigen2" readonly required>
        </div>
        @error('despachoorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
        <input type="text" id="txtcelular_institucional" class="form-control form-control-xs" wire:model="celinstitucional2">
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txtcorreo_institucional" class="fw-bold fs-6">Correo institucional</label>
        <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase" wire:model="correoinstitucional2">
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="regimen2762" class="fw-bold fs-6">Regimen</label>
        <div class="d-flex gap-2">
            <input type="radio" id="regimen2762" name="regimen2" class="btn-check" value="D.L.276" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen2762">D.L.276</label>

            <input type="radio" id="regimen7282" name="regimen2" class="btn-check" value="D.L.728" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen7282">D.L.728</label>

            <input type="radio" id="regimenCAS2" name="regimen2" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimenCAS2">CAS</label>
        </div>
        @error('regimen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-2 col-lg-6 col-sm-12">
        <label for="tiporegimen" class="fw-bold fs-6">Tipo</label>
        <select id="tiporegimen" class="form-select form-select-xs" wire:model.live="tipo_regimen2">
            <option value="">Seleccionar...</option>
            <option value="INDETERMINADO">INDETERMINADO</option>
            <option value="TRANSITORIO">TRANSITORIO</option>
            <option value="SUPLENCIA">SUPLENCIA</option>
        </select>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txt_cargo" class="fw-bold fs-6">Cargo</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-cargos-component">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_cargo" class="form-control form-control-xs bg-light" wire:model="cargo2" readonly required>
        </div>
        @error('cargo2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="cargo_condicion" class="fw-bold fs-6">Condición</label>
        <select id="cargo_condicion" class="form-select form-select-xs" wire:model.live="cargo_condicion2">
            <option value="">Seleccionar...</option>
            <option value="TITULAR">TITULAR</option>
            <option value="PROVINCIAL">PROVISIONAL</option>
        </select>
    </div>
</div>