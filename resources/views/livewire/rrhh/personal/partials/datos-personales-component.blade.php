<div class="row">
    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_dni" class="fw-bold fs-6">DNI</label>
        <div class="input-group">
            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs {{ $mostrarBtnBuscarDni }}" wire:click="buscar_personal">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="text" id="txt_dni" class="form-control form-control-xs" placeholder="DNI" wire:model="dni" required>
            <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" placeholder="Nombres " wire:model="nombres" required>
        </div>
        @error('dni')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_datos" class="fw-bold fs-6">Apellido y Nombres</label>
        {{-- <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" wire:model="datos"> --}}
        <div class="input-group">
            <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" placeholder="Apellido paterno" wire:model="appaterno" required>
            <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" placeholder="Apellido materno" wire:model="apmaterno" required>
            {{-- <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" placeholder="Nombres " wire:model="nombres"> --}}
        </div>
        @error('datos')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
        <input type="text" id="txt_celular_personal" class="form-control form-control-xs" placeholder="Celular personal" wire:model="cel_personal">
    </div>

    <div class="col-xl-12 col-lg-6 col-sm-12">
        <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
        <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase" placeholder="Correo personal" wire:model="correo_personal">
    </div>
</div> 