@extends('layouts.bootstrap5.index')

@section('title', 'Ips')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">IPs</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-house"></i>
                </button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi" aria-hidden="true">
                <use xlink:href="#calendar3"></use>
                </svg>
                This week
            </button>
        </div>
    </div>

    <ul class="nav nav-pills mb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="1-tab" data-bs-toggle="tab" data-bs-target="#1-tab-pane" type="button" role="tab" aria-controls="1-tab-pane" aria-selected="true">
                <i class="fa-solid fa-house-user"></i> Inicio
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="2-tab" data-bs-toggle="tab" data-bs-target="#2-tab-pane" type="button" role="tab" aria-controls="2-tab-pane" aria-selected="false">
                <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="3-tab" data-bs-toggle="tab" data-bs-target="#3-tab-pane" type="button" role="tab" aria-controls="3-tab-pane" aria-selected="false">
                <i class="fa-solid fa-chart-pie"></i> Reportes
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="4-tab" data-bs-toggle="tab" data-bs-target="#4-tab-pane" type="button" role="tab" aria-controls="4-tab-pane" aria-selected="false">
                <i class="fa-solid fa-audio-description"></i> Auditoría
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="1-tab-pane" role="tabpanel" aria-labelledby="1-tab" tabindex="0">
            <livewire:informatica.ips.activos />
        </div>
        <div class="tab-pane fade" id="2-tab-pane" role="tabpanel" aria-labelledby="2-tab" tabindex="0">
            {{-- <livewire:dashboard.inactivos /> --}}
        </div>
        <div class="tab-pane fade" id="3-tab-pane" role="tabpanel" aria-labelledby="3-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="4-tab-pane" role="tabpanel" aria-labelledby="4-tab" tabindex="0">...</div>
    </div>
        
@endsection