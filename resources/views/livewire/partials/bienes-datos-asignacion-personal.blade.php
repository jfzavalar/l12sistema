<div class="row g-3">
    <label for="txt_solicitante" class="col-sm-3 col-form-label"><strong>PERSONAL QUE ENTREGA: </strong></label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input type="text" id="txt_solicitante" class="form-control form-control-sm bg-light" wire:model="personal_entrega" readonly required>
            <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('solicitante')">
                <i class="fa-brands fa-searchengin"></i>
            </button>
        </div>
    </div>
</div>
<div class="row g-3">
    <label for="txt_responsable_traslado" class="col-sm-3 col-form-label"><strong>PERSONAL QUE RECIBE: </strong></label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input type="text" id="txt_responsable_traslado" class="form-control form-control-sm bg-light" wire:model="personal_recepciona" readonly>
            <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('traslado')">
                <i class="fa-brands fa-searchengin"></i>
            </button>
        </div>
    </div>
</div>

<div class="row g-3">
    <label for="txt_motivo" class="col-sm-3 col-form-label"><strong>MOTIVO: </strong></label>
    <div class="col-lg-9 col-sm-9">
        <input type="text" id="txt_motivo" class="form-control form-control-sm text-uppercase" wire:model="motivo_traslado" required>
    </div>
</div>