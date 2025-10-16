<div class="row g-3">
    <label for="txt_solicitante" class="col-sm-3 col-form-label"><strong>SOLICITANTE: </strong></label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input type="text" id="txt_solicitante" class="form-control form-control-sm bg-light" wire:model="solicitante" readonly required>
            <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('solicitante')">
                <i class="fa-brands fa-searchengin"></i>
            </button>
        </div>
    </div>
</div>
<div class="row g-3">
    <label for="txt_responsable_traslado" class="col-sm-3 col-form-label"><strong>RESPONSABLE DE TRASLADO: </strong></label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input type="text" id="txt_responsable_traslado" class="form-control form-control-sm bg-light" wire:model="responsabletraslado" readonly>
            <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('traslado')">
                <i class="fa-brands fa-searchengin"></i>
            </button>
        </div>
    </div>
</div>
<div class="row g-3">
    <label for="cmb_sede_origen" class="col-sm-3 col-form-label"><strong>ORIGEN: </strong></label>
    <div class="col-lg-3 col-sm-3">
        {{-- <label class="form-label"><strong>ORIGEN: SEDE</strong></label> --}}
        <div class="input-group mb-3">
            <select id="cmb_sede_origen" class="form-select form-select-sm" wire:model.live="sede_origen">
                <option value="">Seleccionar...</option>
                @foreach ($lista_sedes as $item_sede)
                    <option value="{{ $item_sede->codsedeofi }}">{{ $item_sede->nomsedeofi }}</option>
                @endforeach
            </select>
            {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color}} btn-sm" data-bs-toggle="modal" data-bs-target="#sede-buscar-Modal">
                <i class="fa-brands fa-searchengin"></i>
            </button> --}}
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        {{-- <label class="form-label"><strong>DEPENDENCIA</strong></label> --}}
        <div class="input-group mb-3">
            <select id="cmb_dependencia_origen" class="form-select form-select-sm" wire:model.live="dependencia_origen">
                <option value="">Seleccionar...</option>
                @foreach ($lista_dependencias as $item_dependencia)
                    <option value="{{ $item_dependencia->coddepofi }}" @selected($item_dependencia->coddepofi == $coddependencia)>{{ $item_dependencia->nomdepofi }}</option>
                @endforeach
            </select>
            {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia-buscar-Modal">
                <i class="fa-brands fa-searchengin"></i>
            </button> --}}
        </div>
    </div>
</div>
<div class="row g-3">
    <label for="cmb_sede_destino" class="col-sm-3 col-form-label"><strong>DESTINO: </strong></label>
    <div class="col-lg-3 col-sm-3">
        {{-- <label class="form-label"><strong>ORIGEN: SEDE</strong></label> --}}
        <div class="input-group mb-3">
            <select id="cmb_sede_destino" class="form-select form-select-sm" wire:model.live="sede_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_sedes as $item_sede)
                    <option value="{{ $item_sede->codsedeofi }}">{{ $item_sede->nomsedeofi }}</option>
                @endforeach
            </select>
            {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#sede2-buscar-Modal">
                <i class="fa-brands fa-searchengin"></i>
            </button> --}}
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        {{-- <label class="form-label"><strong>DEPENDENCIA</strong></label> --}}
        <div class="input-group mb-3">
            <select id="cmb_dependencia_destino" class="form-select form-select-sm" wire:model.live="dependencia_destino">
                <option value="">Seleccionar...</option>
                @foreach ($lista_dependencias2 as $item_dependencia)
                    <option value="{{ $item_dependencia->coddepofi }}" @selected($item_dependencia->coddepofi == $coddependencia)>{{ $item_dependencia->nomdepofi }}</option>
                @endforeach
            </select>
            {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia2-buscar-Modal">
                <i class="fa-brands fa-searchengin"></i>
            </button> --}}
        </div>
    </div>
</div>
<div class="row g-3">
    <label for="txt_motivo" class="col-sm-3 col-form-label"><strong>MOTIVO: </strong></label>
    <div class="col-lg-9 col-sm-9">
        <input type="text" id="txt_motivo" class="form-control form-control-sm text-uppercase" wire:model="motivo_traslado" required>
    </div>
</div>