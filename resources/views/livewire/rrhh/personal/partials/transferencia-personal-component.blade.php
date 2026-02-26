<div wire:ignore.self class="modal fade" id="transferirPersonalModal" tabindex="-1" aria-labelledby="transferirPersonalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="transferirPersonalLabel">
                        <i class="fa-brands fa-searchengin"></i> TRANSFERIR PERSONAL
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-12">
                                <label for="cmbcodsede" class="fw-bold fs-6">Sede</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-sedes-component">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <input type="text" id="txt_sede2" class="form-control form-control-xs bg-light" wire:model="sedeorigen" readonly required>
                                </div>
                                @error('sedeorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-sm-12">
                                <label for="cmbcoddependencia" class="fw-bold fs-6">Dependencia</label>
                                <div class="input-group position-relative">
                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-dependencias-component">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <input type="text" id="txt_dependencia2" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen" readonly required>
                                </div>
                                @error('dependenciaorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12">
                                <label for="cmbcoddependencia" class="fw-bold fs-6">Despacho</label>
                                <div class="input-group position-relative">
                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-despachos-component">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <input type="text" id="txt_despacho2" class="form-control form-control-xs bg-light" wire:model="despachoorigen" readonly required>
                                </div>
                                @error('despachoorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </fieldset>      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>