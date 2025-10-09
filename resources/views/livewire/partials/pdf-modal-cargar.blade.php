<!-- Modal Cargar PDF -->
<div class="modal fade @if($modal_abierto_pdf_cargar) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form wire:submit.prevent="cargarPDF2">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fa-solid fa-file-pdf"></i> CARGAR PDF
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_PDF" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mt-3 mb-3">
                        <input type="file" class="form-control" id="input-pdf" wire:model="pdf" accept="application/pdf" required>
                        @error('pdf') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <br>Guardar
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_PDF">
                        <i class="fa-solid fa-door-closed"></i>
                        <br>Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>