<div class="row">
    <div class="col-xl-12 col-lg-6 col-sm-12">      
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_dni" class="fw-bold fs-6">DNI</label>
                <div class="input-group">
                    <button type="button" class="btn btn-dark btn-xs" wire:click="personalBuscar">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                    <input type="text" id="txt_dni" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror bg-light" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_nombres" class="fw-bold fs-6">Nombres</label>
                <input type="text" id="txt_nombres" class="form-control form-control-xs text-uppercase bg-light" placeholder="Nombres" wire:model="nombres" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_appaterno" class="fw-bold fs-6">Apellido paterno</label>
                <input type="text" id="txt_appaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido paterno" wire:model="appaterno" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_apmaterno" class="fw-bold fs-6">Apellido materno</label>
                <input type="text" id="txt_apmaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido materno" wire:model="apmaterno" readonly>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-6 col-sm-12">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                <input type="text" id="txt_celular_personal" class="form-control form-control-xs bg-light" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
                <input type="text" id="txtcelular_institucional" class="form-control form-control-xs bg-light" wire:model="celinstitucional" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txt_correo_personal" class="fw-bold fs-6">Email personal</label>
                <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase bg-light" placeholder="Correo personal" wire:model="correopersonal" readonly>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <label for="txtcorreo_institucional" class="fw-bold fs-6">Email institucional</label>
                <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase bg-light" wire:model="correoinstitucional" readonly>
            </div>
        </div>
    </div>
</div> 