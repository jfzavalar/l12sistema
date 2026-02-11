<div class="row">
    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_dni" class="fw-bold fs-6">DNI</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm" wire:click="buscar_personal">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dni" class="form-control form-control-xs" wire:model="dni">
        </div>
        @error('dni')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_datos" class="fw-bold fs-6">Apellido y Nombres</label>
        <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" wire:model="datos">
        @error('datos')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
        <input type="text" id="txt_celular_personal" class="form-control form-control-xs" wire:model="cel_personal">
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
        <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase" wire:model="correo_personal">
    </div>
</div> 