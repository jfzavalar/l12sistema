<div class="row">
    <div class="col-xl-4 col-sm-12 mt-2">
        <label for="txtresolucionu" class="fw-bold fs-6">N° Expediente</label>
        <input type="text" id="txtresolucionu" class="form-control form-control-xs" wire:model="num_expediente">
        @error('num_expediente')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-8 col-sm-12 mt-2">
        <label for="filecontrato" class="fw-bold fs-6">Resolución de ubicación o transferencia</label>
        <div class="input-group">
            {{-- <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                <i class="fa-solid fa-print"></i> Imprimir
            </button> --}}
            <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
            @if ($ruta_documento)
                <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_documento) }}" target="_blank">
                    <i class="fa-solid fa-file-pdf"></i> Ver firmado
                </a>
            @endif
        </div>
    </div>
    <div class="col-xl-2 col-sm-12 mt-2">
        <label for="txtfechainiciou" class="fw-bold fs-6">Fecha de inicio</label>
        <input type="date" id="txtfechainiciou" class="form-control form-control-xs" wire:model="fecha_iniciou">
        @error('fecha_iniciou')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-2 col-sm-12 mt-2">
        <label for="txtfechafinu" class="fw-bold fs-6">Fecha de fin</label>
        <input type="date" id="txtfechafinu" class="form-control form-control-xs" wire:model="fecha_finu">
        @error('fecha_finu')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-8 col-sm-12 mt-2">
        <label for="txtresolucionu" class="fw-bold fs-6">Observación o motivo</label>
        <input type="text" id="txtresolucionu" class="form-control form-control-xs" wire:model="motivo_ubicacion">
        @error('motivou')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>                              
</div>