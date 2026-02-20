{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users"></i> Personal
        </h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
        </div>
    </div>

    <livewire:rrhh.personal.personal-component />
@endsection

@push('scripts')
    <script>
    document.addEventListener('livewire:init', () => {

        Livewire.on('cerrar-sede-modal', () => {
            let modal = bootstrap.Modal.getInstance(document.getElementById('sedeModal'));
            if (modal) modal.hide();
        });

        Livewire.on('abrir-nuevo-modal', () => {
            let modal = new bootstrap.Modal(document.getElementById('nuevoEditarModal'));
            modal.show();
        });

    });
    </script>
@endpush