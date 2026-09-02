<div class="row">
    <div class="col-xl-12 col-lg-6 col-sm-12">      
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_dni2" class="fw-bold fs-6">DNI</label>
                <div class="input-group">
                    <button type="button" class="btn btn-dark btn-xs" wire:click="personalBuscar2">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                    <input type="text" id="txt_dni2" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni2" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror bg-light" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_nombres2" class="fw-bold fs-6">Nombres</label>
                <input type="text" id="txt_nombres2" class="form-control form-control-xs text-uppercase bg-light" placeholder="Nombres" wire:model="nombres2" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_appaterno2" class="fw-bold fs-6">Apellido paterno</label>
                <input type="text" id="txt_appaterno2" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido paterno" wire:model="appaterno2" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_apmaterno2" class="fw-bold fs-6">Apellido materno</label>
                <input type="text" id="txt_apmaterno2" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido materno" wire:model="apmaterno2" readonly>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-6 col-sm-12">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_celular_personal2" class="fw-bold fs-6">Celular personal</label>
                <input type="text" id="txt_celular_personal2" class="form-control form-control-xs bg-light" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal2" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txtcelular_institucional2" class="fw-bold fs-6">Celular institucional</label>
                <input type="text" id="txtcelular_institucional2" class="form-control form-control-xs bg-light" wire:model="celinstitucional2" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_correo_personal2" class="fw-bold fs-6">Email personal</label>
                <input type="text" id="txt_correo_personal2" class="form-control form-control-xs text-lowercase bg-light" placeholder="Correo personal" wire:model="correopersonal2" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txtcorreo_institucional2" class="fw-bold fs-6">Email institucional</label>
                <input type="text" id="txtcorreo_institucional2" class="form-control form-control-xs text-lowercase bg-light" wire:model="correoinstitucional2" readonly>
            </div>
        </div>
    </div>
</div> 