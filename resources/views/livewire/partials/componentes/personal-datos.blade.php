<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_sede" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="sedeBuscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="sedeorigen" readonly required>
            {{-- {{ $codsedeorigen }}-{{ $codsededestino }} --}}
        </div>
        @error('sedeorigen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txt_dependencia" class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="dependenciaBuscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen" readonly required>
            {{-- {{ $coddependenciaorigen }}-{{ $coddependenciadestino }} --}}
        </div>
        @error('dependenciaorigen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_despacho" class="fw-bold fs-6">Despacho</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="despachoBuscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_despacho" class="form-control form-control-xs bg-light" wire:model="despachoorigen" readonly required>
            {{-- {{ $coddespachoorigen }}-{{ $coddespachodestino }} --}}
        </div>
        @error('despachoorigen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="regimen276" class="fw-bold fs-6">Regimen</label>
        <div class="d-flex gap-2">
            <input type="radio" id="regimen276" name="regimen" class="btn-check" value="D.L.276" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen276">D.L.276</label>

            <input type="radio" id="regimen728" name="regimen" class="btn-check" value="D.L.728" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen728">D.L.728</label>

            <input type="radio" id="regimenCAS" name="regimen" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimenCAS">CAS</label>
        </div>
        @error('regimen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-2 col-lg-6 col-sm-12">
        <label for="tiporegimen" class="fw-bold fs-6">Tipo</label>
        <select id="tiporegimen" class="form-select form-select-xs" wire:model.live="tipo_regimen">
            <option value="">Seleccionar...</option>
            <option value="INDETERMINADO">INDETERMINADO</option>
            <option value="TRANSITORIO">TRANSITORIO</option>
            <option value="SUPLENCIA">SUPLENCIA</option>
        </select>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txt_cargo" class="fw-bold fs-6">Cargo</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="cargoBuscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_cargo" class="form-control form-control-xs bg-light" wire:model="cargo" readonly required>
        </div>
        @error('cargo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="cargo_condicion" class="fw-bold fs-6">Condición</label>
        <select id="cargo_condicion" class="form-select form-select-xs" wire:model.live="cargo_condicion">
            <option value="">Seleccionar...</option>
            <option value="TITULAR">TITULAR</option>
            <option value="PROVINCIAL">PROVISIONAL</option>
        </select>
    </div>
</div>