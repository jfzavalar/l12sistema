{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Firmas Digitales')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-signature"></i> Firmas Digitales
        </h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                <i class="fa-brands fa-usb"></i> Firmas - Token
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                <i class="fa-solid fa-computer"></i> Firmas - PC
            </button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            {{-- Tramite de Tokens --}}
            <livewire:informatica.firmas.token.activos />
        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            {{-- Tramite de PCs --}}
            {{-- <livewire:informatica.firmas.pc.activos /> --}}
        </div>
    </div>
        
@endsection

@push('scripts')
    <script>
        // Escucha el evento que despacha el componente después de actualizar
        Livewire.on('alerta-actualizado', (data) => {
            Swal.fire({
                position: "center",
                icon: data.tipo ?? "success",
                title: data.titulo ?? "Actualización exitosa",
                text: data.mensaje ?? "",
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endpush