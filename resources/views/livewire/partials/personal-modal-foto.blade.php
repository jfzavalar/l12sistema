<!-- Modal cargar imagen -->
<div class="modal fade @if($modal_abierto_imagen) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                        <i class="fa-solid fa-file-image"></i> CARGAR IMAGEN
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_imagen"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <fieldset class="border p-3 rounded text-center">
                        {{-- Imagen previa (preview Livewire) --}}
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="img-fluid rounded-start mb-3" alt="Preview" width="200">
                        @else
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" 
                                class="img-fluid rounded-start mb-3" 
                                alt="Foto perfil" 
                                width="200">
                        @endif
                        <div class="col-lg-12">
                            <label for="fileimagen" class="fw-bold fs-6 mb-3">Foto de perfil</label>
                            <input type="file" id="fileimagen" class="form-control" wire:model="avatar" required>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer bg-dark-subtle">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_imagen">
                        <i class="fa-solid fa-square-xmark"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>