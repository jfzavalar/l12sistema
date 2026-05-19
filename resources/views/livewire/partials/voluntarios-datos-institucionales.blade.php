<div class="row">
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="cmbcodsede" class="fw-bold fs-6">Sede</label>
        <div class="input-group">
            <select id="cmbcodsede" class="form-select form-select-xs" wire:model.change="codsede_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_sedes as $sede)
                    <option value="{{ $sede->cod }}">{{ $sede->nombre}}</option>
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

<div class="row">
    <div class="col-xl-4 col-lg-6 col-sm-12">
        <label for="txtdespacho" class="fw-bold fs-6">Tipo de registro</label>
        <div class="d-flex gap-2">
            <input type="radio" id="rb_entrada" name="entrada_salida" class="btn-check" value="1" autocomplete="off" wire:model.live="entrada_salida" required>
            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="rb_entrada">Entrada</label>

            <input type="radio" id="rb_salida" name="entrada_salida" class="btn-check" value="0" autocomplete="off" wire:model.live="entrada_salida" required>
            <label class="btn btn-outline-{{ $colorGuardarActualizar}} btn-xs flex-fill" for="rb_salida">Salida</label>
        </div>
        @error('entrada_salida')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-2 col-lg-6 col-sm-12">
        <label for="fecha_actual" class="fw-bold fs-6">Fecha</label>
        <input type="date" id="fecha_actual" class="form-control form-control-xs" wire:model="fecha" disabled>
    </div>

    {{-- <div class="col-xl-3 col-lg-6 col-sm-12" wire:poll.1000ms="actualizarHora"> --}}
    <div class="col-xl-2 col-lg-6 col-sm-12">
        <label for="hora_actual" class="fw-bold fs-6">Hora</label>
        <input type="time" id="hora_actual" class="form-control form-control-xs" step="1" wire:model="hora" disabled>          
    </div>

    <div class="col-xl-4 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
        <div class="input-group">
            <input type="text" id="txtobservacion" class="form-control form-control-xs" wire:model="observacion">
            <button type="submit" class="btn btn-primary btn-xs">
                <i class="fa-solid fa-floppy-disk"></i> Registrar
            </button>
        </div>
    </div>

</div>

{{-- <div class="row">
    <div class="col-xl-12 col-sm-12">
        <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
        <div class="input-group">
            <input type="text" id="txtobservacion" class="form-control form-control-xs" wire:model="observacion">
            <button type="submit" class="btn btn-primary btn-xs">
                <i class="fa-solid fa-floppy-disk"></i> Registrar
            </button>
        </div>
    </div>
</div> --}}