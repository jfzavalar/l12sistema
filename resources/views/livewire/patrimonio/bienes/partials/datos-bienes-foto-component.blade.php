{{-- Imagen previa (preview Livewire) --}}
@if ($foto)
    <img src="{{ $foto->temporaryUrl() }}" width="200">
@elseif($fotoactual)
    <img src="{{ asset('storage/'.$fotoactual) }}" width="200">
@else
    <img src="{{ asset('img/perfil.jpg') }}" width="200">
@endif

<div class="col-lg-12">
    <input type="file" id="fileimagen" class="form-control form-control-xs {{ $mostrarcargafoto }}" accept=".jpg,.jpeg,image/jpeg" wire:model="foto" wire:key="file-{{ $inputFileKey }}">
</div>