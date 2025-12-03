@extends('layouts.bootstrap5.index')

@section('title', 'Archivo')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-globe"></i> Archivo
        </h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
            <button class="nav-link active" id="carpetas-tab" data-bs-toggle="tab" data-bs-target="#carpetas" type="button" role="tab" aria-controls="carpetas" aria-selected="true">
                <i class="fa-regular fa-folder-open"></i> Carpetas Fiscales
            </button>

            @can('procesos.intranet.atenciones.index')
            <button class="nav-link" id="desplazamiento-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento" type="button" role="tab" aria-controls="desplazamiento" aria-selected="false">
                <i class="fa-solid fa-people-carry-box"></i> Desplazamiento de Carpetas
            </button>
            @endcan
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

        {{-- ====================== CARPETAS ====================== --}}
        <div class="tab-pane fade show active" id="carpetas" role="tabpanel" aria-labelledby="carpetas-tab" tabindex="0">

            <ul class="nav nav-pills mb-2" id="tab-carpetas" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="carpeta-inicio-tab" data-bs-toggle="tab" data-bs-target="#carpeta-inicio" type="button" role="tab">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="carpeta-inactivos-tab" data-bs-toggle="tab" data-bs-target="#carpeta-inactivos" type="button" role="tab">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="carpeta-reportes-tab" data-bs-toggle="tab" data-bs-target="#carpeta-reportes" type="button" role="tab">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="carpeta-auditoria-tab" data-bs-toggle="tab" data-bs-target="#carpeta-auditoria" type="button" role="tab">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="carpeta-inicio" role="tabpanel">
                    {{-- <livewire:intranet.configuracion.activos /> --}}
                </div>

                <div class="tab-pane fade" id="carpeta-inactivos" role="tabpanel"></div>
                <div class="tab-pane fade" id="carpeta-reportes" role="tabpanel"></div>
                <div class="tab-pane fade" id="carpeta-auditoria" role="tabpanel"></div>
            </div>
        </div>

        {{-- ====================== DESPLAZAMIENTO ====================== --}}
        <div class="tab-pane fade" id="desplazamiento" role="tabpanel" aria-labelledby="desplazamiento-tab" tabindex="0">

            <ul class="nav nav-pills mb-2" id="tab-desplazamiento" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="desplazamiento-inicio-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento-inicio" type="button" role="tab">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="desplazamiento-inactivos-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento-inactivos" type="button" role="tab">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="desplazamiento-reportes-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento-reportes" type="button" role="tab">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="desplazamiento-auditoria-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento-auditoria" type="button" role="tab">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="desplazamiento-inicio" role="tabpanel"></div>
                <div class="tab-pane fade" id="desplazamiento-inactivos" role="tabpanel"></div>
                <div class="tab-pane fade" id="desplazamiento-reportes" role="tabpanel"></div>
                <div class="tab-pane fade" id="desplazamiento-auditoria" role="tabpanel"></div>
            </div>

        </div>

    </div>
@endsection
