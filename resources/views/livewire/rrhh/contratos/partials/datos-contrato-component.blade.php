<div class="row">
    <div class="col-xl-2 col-sm-12">
        <label for="txtconvocatoria" class="fw-bold fs-6">N° de convocatoria</label>
        <input type="text" id="txtconvocatoria" class="form-control form-control-xs text-uppercase" wire:model="numero_convocatoria">
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txttipodocumento" class="fw-bold fs-6">Tipo de documento</label>
        <input type="text" id="txttipodocumento" class="form-control form-control-xs" wire:model="tipo_documento" disabled>
        {{-- <select id="cmdobsconvocatoria" class="form-select form-select-xs" wire:model="tipo_documento">
            <option value="">Selecionar...</option>
            <option value="ADENDA">ADENDA</option>
            <option value="CONTRATO">CONTRATO</option>
            <option value="RENUNCIA">RENUNCIA</option>
        </select> --}}
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txtfechainiciocontrato" class="fw-bold fs-6">Fecha de inicio</label>
        <input type="date" id="txtfechainiciocontrato" class="form-control form-control-xs" wire:model="fecha_inicio">
        @error('fecha_inicio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-2 col-sm-12">
        <label for="txtfechafincontrato" class="fw-bold fs-6">Fecha de fin</label>
        <input type="date" id="txtfechafincontrato" class="form-control form-control-xs" wire:model="fecha_fin">
        @error('fecha_fin')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="col-xl-4 col-sm-12">
        <label for="filecontrato" class="fw-bold fs-6">Contrato</label>
        <div class="input-group">
            <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                <i class="fa-solid fa-print"></i> Imprimir
            </button>
            <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
            {{-- <button class="btn btn-outline-warning btn-xs" type="button" id="btncargarcontrato">
                <i class="fa-solid fa-arrow-up-from-bracket"></i> Cargar
            </button> --}}
            @if ($ruta_documento)
                <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_documento) }}" target="_blank">
                    <i class="fa-solid fa-file-pdf"></i> Ver firmado
                </a>
            @endif
        </div>
    </div>
</div>