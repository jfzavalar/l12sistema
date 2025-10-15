<div class="modal fade @if($modal_abierto_pdf_vista_previa) show d-block @endif" tabindex="-1">
    <div class="modal-dialog modal-xl" style="max-width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ACTA</h5>
                <button type="button" class="btn-close" wire:click="cerrar" aria-label="Cerrar"></button>
            </div>
        <div class="modal-body" style="height: 80vh;">
            <iframe 
                src="{{ $iddesplazamiento ? route('pdf.patrimonio.bieninformatico-traslado-acta', $iddesplazamiento) : '' }}" 
                frameborder="0" 
                style="width: 100%; height: 100%;" 
                allowfullscreen>
            </iframe>
        </div>
        <div class="modal-footer">
            <a href="{{ $iddesplazamiento ? route('pdf.patrimonio.bieninformatico-traslado-acta', $iddesplazamiento) : '#' }}" target="_blank" class="btn btn-success">
                <i class="fa-solid fa-book-open"></i> Abrir en nueva pestaña
            </a>
            <button type="button" class="btn btn-secondary" wire:click="cerrar">
                <i class="fa-solid fa-door-closed"></i> Cerrar
            </button>
        </div>
        </div>
    </div>
</div>