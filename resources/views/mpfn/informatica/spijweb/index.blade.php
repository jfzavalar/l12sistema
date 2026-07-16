{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Spijweb')

@section('content')
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> TICKETS ATENCIONES: {{ strtoupper(now()->locale('es')->translatedFormat('F Y')) }}
        </h1>
    </div> --}}

    <livewire:informatica.spijweb.activos />
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop