{{-- <fieldset class="border p-3 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Datos Personales</legend> --}}
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <label for="txt_dni" class="fw-bold fs-6">DNI</label>
            <div class="input-group">
                <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" id="txt_dni" class="form-control form-control-sm" wire:model="dni">
            </div>
            @error('dni')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-xl-12 col-sm-12">
            <label for="txt_datos" class="fw-bold fs-6">Personal</label>
            <input type="text" id="txt_datos" class="form-control form-control-sm" wire:model="datos">
        </div>
        <div class="col-xl-12 col-sm-12">
            <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
            <input type="text" id="txt_celular_personal" class="form-control form-control-sm" wire:model="cel_personal">
        </div>
        <div class="col-xl-12 col-sm-12">
            <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
            <input type="text" id="txt_correo_personal" class="form-control form-control-sm" wire:model="correo_personal">
        </div>
    </div> 
{{-- </fieldset> --}}