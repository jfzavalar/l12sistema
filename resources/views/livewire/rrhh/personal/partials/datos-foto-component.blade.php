{{-- <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#foto-cargar-component">
    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" class="img-fluid rounded-start" alt="Foto perfil">
</button> --}}

{{-- Imagen previa (preview Livewire) --}}
@if ($foto)
    <img src="{{ $foto->temporaryUrl() }}" width="200">
@elseif($fotoactual)
    <img src="{{ asset('storage/'.$fotoactual) }}" width="200">
@else
    <img src="{{ asset('img/perfil.jpg') }}" width="200">
@endif

<div class="col-lg-12">
    <input type="file" id="fileimagen" class="form-control form-control-xs" wire:model="foto" wire:key="file-{{ $inputFileKey }}">
</div>