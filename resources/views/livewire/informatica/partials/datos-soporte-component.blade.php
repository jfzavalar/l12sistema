<div class="row">
    <div class="col">
        <fieldset class="border p-3 rounded mb-3">
        <legend>Mantenimiento preventivo</legend>
            <div class="form-check form-check-sm">
                <input id="p1" class="form-check-input" type="checkbox" wire:model="p01">
                <label for="p1" class="form-check-label small">Abrir CASE para realizar limpieza</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="p2" class="form-check-input" type="checkbox" wire:model="p02">
                <label for="p2" class="form-check-label small">Emplear una compresora de aire</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="p3" class="form-check-input" type="checkbox" wire:model="p03">
                <label for="p3" class="form-check-label small">Limpieza de monitor</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="p4" class="form-check-input" type="checkbox" wire:model="p04">
                <label for="p4" class="form-check-label small">Limpieza de teclado</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="p5" class="form-check-input" type="checkbox" wire:model="p05">
                <label for="p5" class="form-check-label small">Verificar cables de conexión</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="p6" class="form-check-input" type="checkbox" wire:model="p06">
                <label for="p6" class="form-check-label small">Realizar pruebas de operatividad</label>
            </div>
            <div class="input-group">
                <div class="form-check form-check-sm me-3">
                    <input id="p7" class="form-check-input" type="checkbox" wire:model="p07">
                    <label for="p7" class="form-check-label small">Otros: </label></label>
                </div>
                <input id="txt_potros" type="text" class="form-control form-control-xs" wire:model="potros">
            </div>
        </fieldset>
    </div>
    <div class="col">
        <fieldset class="border p-3 rounded mb-3">
            <legend>Mantenimiento correctivo</legend>
            <div class="form-check form-check-sm">
                <input id="c1" class="form-check-input" type="checkbox" wire:model="c01">
                <label for="c1" class="form-check-label small">Actualización de aplicaciones</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="c2" class="form-check-input" type="checkbox" wire:model="c02">
                <label for="c2" class="form-check-label small">Actualización de sistema operativo</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="c3" class="form-check-input" type="checkbox" wire:model="c03">
                <label for="c3" class="form-check-label small">Cambio de CPU</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="c4" class="form-check-input" type="checkbox" wire:model="c04">
                <label for="c4" class="form-check-label small">Clonación</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="c5" class="form-check-input" type="checkbox" wire:model="c05">
                <label for="c5" class="form-check-label small">Formateo</label>
            </div>
            <div class="form-check form-check-sm">
                <input id="c6" class="form-check-input" type="checkbox" wire:model="c06">
                <label for="c6" class="form-check-label small">Instalación de Antimalware</label>
            </div>
            <div class="input-group">
                <div class="form-check form-check-sm me-3">
                    <input id="c7" class="form-check-input" type="checkbox" wire:model="c07">
                    <label for="c7" class="form-check-label small">Otros: </label></label>
                </div>
                <input id="txt_cotros" type="text" class="form-control form-control-xs" wire:model="cotros">
            </div>
        </fieldset>
    </div>
</div>