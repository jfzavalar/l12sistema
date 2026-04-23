{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Asignar sobrantes')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> ASIGNACIÓN DE BIENES SOBRANTES
        </h1>

    </div>

    <livewire:patrimonio.bienes.bienesasignacionsobrantes-component />
@endsection

@push('scripts')

@endpush