<button type="button" class="btn btn-outline-secondary" wire:click="editar_imagen">
    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" class="img-fluid rounded-start" alt="Foto perfil">
</button>