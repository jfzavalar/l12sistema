<!-- Modal Actualizar Password -->
<div wire:ignore.self class="modal fade" id="user-password-component" tabindex="-1" aria-labelledby="user-password-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <form wire:submit.prevent="actualizar_password">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="user-password-componentLabel">
                        <i class="fa-solid fa-key"></i> RESTABLECER PASSWORD
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal" wire:click="cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="txt_password1"><strong>Contraseña</strong></label>
                    <input type="password" id="txt_password1" class="form-control form-control-sm" wire:model="password">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <br>Restablecer Contraseña
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                        <i class="fa-solid fa-door-closed"></i>
                        <br>Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>