<div class="row">
    <div class="col-xl-2 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
        <select id="cmdobsconvocatoria" class="form-select form-select-xs">
            <option value="">Selecionar...</option>
            <option value="NUEVO">NUEVO</option>
            <option value="RENOVACION">RENOVACION</option>
        </select>
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">N° de convocatoria</label>
        <input type="text" id="txtconvocatoria" class="form-control form-control-xs" wire:model="convocatoria">
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Fecha de inicio</label>
        <input type="date" id="txtfechainiciocontrato" class="form-control form-control-xs" wire:model="fechainiciocontrato">
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Fecha de fin</label>
        <input type="date" id="txtfechafincontrato" class="form-control form-control-xs" wire:model="fechafincontrato">
    </div>
    
    <div class="col-xl-4 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Contrato</label>
        <div class="input-group">
            <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                <i class="fa-solid fa-print"></i> Imprimir
            </button>
            <button class="btn btn-outline-warning btn-xs" type="button" id="btncargarcontrato">
                <i class="fa-solid fa-arrow-up-from-bracket"></i> Cargar
            </button>
            <button class="btn btn-outline-secondary btn-xs" type="button" id="btnvercontrato">
                <i class="fa-solid fa-file-pdf"></i> Ver firmado
            </button>
        </div>
    </div>
</div>