<div class="modal fade @if($modalPDFEvidenciaCargar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form wire:submit.prevent="actualizar_pdf">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="pdf-cargar-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> CARGAR PDF EVIDENCIA
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="border p-3 rounded mb-3">
                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">CARGA EVIDENCIA</legend>
                        <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                    </fieldset>      
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" wire:click = "cerrar">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>