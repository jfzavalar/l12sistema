{{-- <label for="txt_dni" class="fw-bold fs-6">FOTO</label> --}}
@if ($foto)
    <img src="{{ $foto->temporaryUrl() }}" width="90">
@elseif($fotoactual)
    <img src="{{ asset('storage/'.$fotoactual) }}" width="90">
@else
    <img src="{{ asset('img/perfil.jpg') }}" width="90">
@endif