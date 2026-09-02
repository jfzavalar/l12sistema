<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_sede2" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <button type="button" class="btn btn-dark btn-xs" wire:click=sedeBuscar2>
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_sede2" class="form-control form-control-xs bg-light" wire:model="sedeorigen2" readonly required>
            {{-- {{ $codsedeorigen }}-{{ $codsededestino }} --}}
        </div>
        @error('sedeorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txt_dependencia"2 class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-dark btn-xs" wire:click=dependenciaBuscar2>
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dependencia2" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen2" readonly required>
            {{-- {{ $coddependenciaorigen }}-{{ $coddependenciadestino }} --}}
        </div>
        @error('dependenciaorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="txt_despacho2" class="fw-bold fs-6">Despacho</label>
        <div class="input-group position-relative">
            <button type="button" class="btn btn-dark btn-xs" wire:click=despachoBuscar2>
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_despacho2" class="form-control form-control-xs bg-light" wire:model="despachoorigen2" readonly required>
            {{-- {{ $coddespachoorigen }}-{{ $coddespachodestino }} --}}
        </div>
        @error('despachoorigen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="regimen2762" class="fw-bold fs-6">Regimen</label>
        <div class="d-flex gap-2">
            <input type="radio" id="regimen2762" name="regimen2" class="btn-check" value="D.L.276" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-dark btn-xs flex-fill" for="regimen2762">D.L.276</label>

            <input type="radio" id="regimen7282" name="regimen2" class="btn-check" value="D.L.728" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-dark btn-xs flex-fill" for="regimen7282">D.L.728</label>

            <input type="radio" id="regimenCAS2" name="regimen2" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen2">
            <label class="btn btn-outline-dark btn-xs flex-fill" for="regimenCAS2">CAS</label>
        </div>
        @error('regimen2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-2 col-lg-6 col-sm-12">
        <label for="tiporegimen2" class="fw-bold fs-6">Tipo</label>
        <select id="tiporegimen2" class="form-select form-select-xs" wire:model.live="tipo_regimen2">
            <option value="">Seleccionar...</option>
            <option value="INDETERMINADO">INDETERMINADO</option>
            <option value="TRANSITORIO">TRANSITORIO</option>
            <option value="SUPLENCIA">SUPLENCIA</option>
        </select>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txt_cargo"2 class="fw-bold fs-6">Cargo</label>
        <div class="input-group">
            <button type="button" class="btn btn-dark btn-xs" wire:click=cargoBuscar2>
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_cargo2" class="form-control form-control-xs bg-light" wire:model="cargo2" readonly required>
        </div>
        @error('cargo2')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="cargo_condicion2" class="fw-bold fs-6">Condición</label>
        <select id="cargo_condicion2" class="form-select form-select-xs" wire:model.live="cargo_condicion2">
            <option value="">Seleccionar...</option>
            <option value="TITULAR">TITULAR</option>
            <option value="PROVINCIAL">PROVISIONAL</option>
        </select>
    </div>
</div>