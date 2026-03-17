{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Exp. Importantes')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> Experientes Importantes
        </h1>
        {{-- <div class="btn-group">
            <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                <i class="fa-regular fa-file-pdf"></i> PDF
            </a>
            <a id="btnreporteexcel" class="btn btn-outline-success btn-sm" href="{{ url('personas/exportar') }}">
                <i class="fa-regular fa-file-excel"></i> Excel
            </a>
        </div> --}}
    </div>

    <livewire:intranet.expimportantes.activos />
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop


@section('js')

@stop