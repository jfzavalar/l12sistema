<div class="row">
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="cmbcodsede" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <select id="cmbcodsede" class="form-select form-select-xs" wire:model.change="codsede_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_sedes as $sede)
                    <option value="{{ $sede->codsedeofi }}">{{ $sede->nomsedeofi}}</option>
                @endforeach
            </select>
            @error('sede_destino')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-xl-8 col-lg-6 col-sm-12">
        <label for="cmbcoddependencia" class="fw-bold fs-6">Dependencia</label>
        <div class="input-group position-relative">
            <select id="cmbcoddependencia" class="form-select form-select-xs" wire:model="coddependencia_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_dependencias as $dependencia)
                    <option value="{{ $dependencia->coddepofi }}" @selected($dependencia->coddepofi == $coddependencia_destino)>{{ $dependencia->nomdepofi }}</option>
                @endforeach
            </select>
            @error('dependencia_destino')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
        <input type="text" id="txtcelular_institucional" class="form-control form-control-xs" wire:model="cel_institucional">
    </div>
    <div class="col-xl-8 col-lg-6 col-sm-12">
        <label for="txtcorreo_institucional" class="fw-bold fs-6">Correo institucional</label>
        <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase" wire:model="correo_institucional">
    </div>
</div> --}}

{{-- <div class="row">
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Regimen</label>
        <div class="d-flex gap-2">
            <input type="radio" id="regimen276" name="regimen" class="btn-check" value="DL.276" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="regimen276">D.L.276</label>

            <input type="radio" id="regimen728" name="regimen" class="btn-check" value="DL.728" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="regimen728">D.L.728</label>

            <input type="radio" id="regimenCAS" name="regimen" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen">
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="regimenCAS">CAS</label>
        </div>
        @error('regimen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-xl-8 col-lg-6 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Cargo</label>
        <div class="input-group">
            <input type="text" id="txtdespacho" class="form-control form-control-xs" wire:model="cargo">
        </div>
        @error('cargo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div> --}}

<div class="row">
    <div class="col-xl-6 col-lg-6 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Tipo de registro</label>
        <div class="d-flex gap-2">
            <input type="radio" id="rb_entrada" name="entrada_salida" class="btn-check" value="1" autocomplete="off" wire:model.live="entrada_salida" required>
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="rb_entrada">Entrada</label>

            <input type="radio" id="rb_salida" name="entrada_salida" class="btn-check" value="0" autocomplete="off" wire:model.live="entrada_salida" required>
            <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="rb_salida">Salida</label>
        </div>
        @error('entrada_salida')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="fecha_actual" class="fw-bold fs-6">Fecha</label>
        <input type="date" id="fecha_actual" class="form-control form-control-xs" wire:model="fecha" disabled>
    </div>

    {{-- <div class="col-xl-3 col-lg-6 col-sm-12" wire:poll.1000ms="actualizarHora"> --}}
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <label for="hora_actual" class="fw-bold fs-6">Hora</label>
        <input type="time" id="hora_actual" class="form-control form-control-xs" step="1" wire:model="hora" disabled>          
    </div>

</div>

<div class="row">
    <div class="col-xl-12 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
        <div class="input-group">
            <input type="text" id="txtobservacion" class="form-control form-control-xs" wire:model="observacion">
            <button type="submit" class="btn btn-primary btn-xs">
                <i class="fa-solid fa-floppy-disk"></i> Registrar
            </button>
        </div>
    </div>
</div>