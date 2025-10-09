{{-- <fieldset class="border p-3 rounded text-center" disabled>
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Foto de perfil</legend> --}}
    <button type="button" class="btn btn-outline-secondary" wire:click="editar_imagen">
        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" class="img-fluid rounded-start" alt="Foto perfil">
    </button>
{{-- </fieldset> --}}