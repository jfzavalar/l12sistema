<div class="row mb-2">
    <div class="col-xl-6 col-sm-12">
        <label for="cmbcodsede" class="fw-bold fs-6">Sede-Origen</label>
        <div class="input-group">
            <input type="text" id="txt_sedeorigen" class="form-control form-control-xs" wire:model="sede_origen" disabled>
            {{-- {{ $codsede_destino }} --}}
        </div>
    </div>
    <div class="col-xl-6 col-sm-12">
        <label for="cmbcoddependencia" class="fw-bold fs-6">Dependencia-origen</label>
        <div class="input-group position-relative">
            <input type="text" id="txt_dependenciaorigen" class="form-control form-control-xs" wire:model="dependencia_origen" disabled>
            {{-- {{ $coddependencia_destino }} --}}
        </div>
    </div>
</div>