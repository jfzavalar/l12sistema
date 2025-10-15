<div class="row">
    <div class="col-xl-4 col-sm-12">
        <label for="txtfecha_inicio" class="fw-bold fs-6">Fecha de inicio</label>
        <input type="date" id="txtfecha_inicio" class="form-control form-control-sm" wire:model="fecha_inicio" required>
    </div>
    <div class="col-xl-4 col-sm-12">
        <label for="txtfecha_fin" class="fw-bold fs-6">Fecha de fin</label>
        <input type="date" id="txtfecha_fin" class="form-control form-control-sm" wire:model="fecha_fin" required>
    </div>
    <div class="col-xl-4 col-sm-12">
        <label for="txtcausal" class="fw-bold fs-6">Causal</label>
        <select id="cmdcausal" class="form-select form-select-sm" wire:model="causal" required>
            <option value="">Seleccionar...</option>
            <option value="NUEVO">NUEVO</option>
            <option value="RENOVACION">RENOVACION</option>
            <option value="RENUNCIA">RENUNCIA</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-sm-12">
        <label for="txtfecha_fin" class="fw-bold fs-6">Observación de contrato</label>
        <input type="text" id="txtfecha_fin" class="form-control form-control-sm" wire:model="observacion_contrato">
    </div>
</div>