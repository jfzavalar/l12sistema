<div class="row">
    <div class="col-xl-4 col-sm-12">
        <label for="cmbcodsede" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <select id="cmbcodsede" class="form-select form-select-sm" wire:model.change="codsede_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_sedes as $sede)
                    <option value="{{ $sede->codsedeofi }}">{{ $sede->nomsedeofi}}</option>
                @endforeach
            </select>
            {{-- {{ $codsede_destino }} --}}
        </div>
    </div>
    <div class="col-xl-8 col-sm-12">
        <label for="cmbcoddependencia" class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <select id="cmbcoddependencia" class="form-select form-select-sm" wire:model="coddependencia_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_dependencias as $dependencia)
                    <option value="{{ $dependencia->coddepofi }}" @selected($dependencia->coddepofi == $coddependencia_destino)>{{ $dependencia->nomdepofi }}</option>
                @endforeach
            </select>
            {{-- {{ $coddependencia_destino }} --}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-sm-12">
        <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
        <input type="text" id="txtcelular_institucional" class="form-control form-control-sm" wire:model="cel_institucional">
    </div>
    <div class="col-xl-8 col-sm-12">
        <label for="txtcorreo_institucional" class="fw-bold fs-6">Correo institucional</label>
        <input type="text" id="txtcorreo_institucional" class="form-control form-control-sm" wire:model="correo_institucional">
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Regimen</label>
        <div class="form-group">
            <input type="radio" id="regimen276" name="regimen" class="btn-check" value="DL.276" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-sm" for="regimen276">D.L.276</label>

            <input type="radio" id="regimen728" name="regimen" class="btn-check" value="DL.728" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-sm" for="regimen728">D.L.728</label>

            <input type="radio" id="regimenCAS" name="regimen" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-sm" for="regimenCAS">CAS</label>
        </div>
    </div>
    <div class="col-xl-8 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Cargo</label>
        <div class="input-group">
            {{-- <button class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button> --}}
            <input type="text" id="txtdespacho" class="form-control form-control-sm" wire:model="cargo">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
        <input type="text" id="txtobservacion" class="form-control form-control-sm" wire:model="observacion">
    </div>
</div>