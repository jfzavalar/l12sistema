<div class="row">
    <div class="col-xl-12 col-lg-6 col-sm-12">      
        <div class="row">
            <div class="col">
                <label for="txt_dni" class="fw-bold fs-6">DNI</label>
                <input type="text" id="txt_dni" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror">
                @error('dni')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col">
                <label for="txt_nombres" class="fw-bold fs-6">Nombres</label>
                <input type="text" id="txt_nombres" class="form-control form-control-xs text-uppercase" placeholder="Nombres " wire:model="nombres">
                @error('nombres')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <div class="row">
            <div class="col">
                <label for="txt_appaterno" class="fw-bold fs-6">Apellido paterno</label>
                <input type="text" id="txt_appaterno" class="form-control form-control-xs text-uppercase" placeholder="Apellido paterno" wire:model="appaterno">
                @error('appaterno')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col">
                <label for="txt_apmaterno" class="fw-bold fs-6">Apellido materno</label>
                <input type="text" id="txt_apmaterno" class="form-control form-control-xs text-uppercase" placeholder="Apellido materno" wire:model="apmaterno">
                @error('apmaterno')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-6 col-sm-12">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12">
                <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                <input type="text" id="txt_celular_personal" class="form-control form-control-xs" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)">
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-12">
                <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
                <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase" placeholder="Correo personal" wire:model="correopersonal">
            </div>
        </div>
    </div>
</div> 