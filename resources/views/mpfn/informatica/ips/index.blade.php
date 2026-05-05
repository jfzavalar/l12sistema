{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Ips')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> ADMINISTRACIÓN DE IPS
        </h1>
        {{-- <div class="btn-group">
            <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                <i class="fa-regular fa-file-pdf"></i> PDF
            </a>
            <button type="button" id="btnreporteexcel" class="btn btn-outline-success btn-sm">
                <i class="fa-regular fa-file-excel"></i> Excel
            </button>
        </div> --}}
    </div>

    <livewire:informatica.ips.ips-component />
@endsection

@push('scripts')

@endpush