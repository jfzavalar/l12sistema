<div wire:ignore.self class="modal fade" id="pdf-cargar-component" tabindex="-1" aria-labelledby="pdf-cargar-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form wire:submit.prevent="actualizar_pdf">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="pdf-cargar-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> CARGAR PDF
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click = "cerrar_transferir_personal"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="border p-3 rounded mb-3">
                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">CARGA ACTA</legend>
                        <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                    </fieldset>      
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click = "cerrar_transferir_personal">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>