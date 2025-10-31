<div class="card min-vh-100">
    <div class="card-body">
        <div class="row">
            
            <div class="col-xl-6">
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="card border-2 shadow-sm" style="border-top: 4px solid var(--bs-primary);">
                    <form wire:submit.prevent="actualizar_password">
                        {{-- <div class="card-header">
                            CAMBIAR PASSWORD
                        </div> --}}
                        <div class="card-body">                          
                            <div class="row g-3">
                                {{-- Contraseña anterior --}}
                                <div class="col-xl-12">
                                    <label for="txt_pass_anterior" class="fw-bold">Contraseña actual:</label>
                                    <div class="input-group input-group-sm">
                                        <input 
                                            type="password" 
                                            id="txt_pass_anterior" 
                                            class="form-control @error('pass_anterior') is-invalid @enderror"
                                            wire:model.defer="pass_anterior"
                                        >
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('txt_pass_anterior', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('pass_anterior') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                                    @enderror
                                </div>

                                {{-- Nueva contraseña --}}
                                <div class="col-xl-12">
                                    <label for="txt_pass_nuevo" class="fw-bold">Nueva contraseña:</label>
                                    <div class="input-group input-group-sm">
                                        <input 
                                            type="password" 
                                            id="txt_pass_nuevo" 
                                            class="form-control @error('pass_nuevo') is-invalid @enderror"
                                            wire:model.defer="pass_nuevo"
                                        >
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('txt_pass_nuevo', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('pass_nuevo') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                                    @enderror
                                </div>

                                {{-- Repetir contraseña --}}
                                <div class="col-xl-12">
                                    <label for="txt_pass_repetir" class="fw-bold">Repetir contraseña:</label>
                                    <div class="input-group input-group-sm">
                                        <input 
                                            type="password" 
                                            id="txt_pass_repetir" 
                                            class="form-control @error('pass_repetir') is-invalid @enderror"
                                            wire:model.defer="pass_repetir"
                                        >
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('txt_pass_repetir', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('pass_repetir') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Actualizar
                            </button>
                            <button type="reset" class="btn btn-warning btn-sm text-white">
                                <i class="fa-solid fa-eraser"></i> Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card border-2 shadow-sm" style="border-top: 4px solid var(--bs-primary);">
                    {{-- <div class="card-header">
                        DATOS DEL PERSONAL
                    </div> --}}
                    <div class="card-body">
                        {{-- Aquí puedes poner la info del usuario --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
