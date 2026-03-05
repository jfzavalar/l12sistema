{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Intranet')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-globe"></i> Intranet
        </h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
            <button class="nav-link active" id="configuracion-tab" data-bs-toggle="tab" data-bs-target="#configuracion" type="button" role="tab" aria-controls="configuracion" aria-selected="true">
                <i class="fa-solid fa-gear"></i> Configuración
            </button>
            @can('procesos.intranet.atenciones.index')
                <button class="nav-link" id="personal-atenciones-tab" data-bs-toggle="tab" data-bs-target="#personal-atenciones" type="button" role="tab" aria-controls="personal-atenciones" aria-selected="false">
                    <i class="fa-solid fa-ticket"></i> Atenciones
                </button>
            @endcan
            @can('procesos.intranet.incidencia.index')
                <button class="nav-link" id="personal-incidencias-tab" data-bs-toggle="tab" data-bs-target="#personal-incidencias" type="button" role="tab" aria-controls="personal-incidencias" aria-selected="false">
                    <i class="fa-solid fa-user-pen"></i> Registro de incidencias / solicitudes
                </button>
            @endcan
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        {{-- ====================== CONFIGURACIÓN ====================== --}}
        <div class="tab-pane fade show active" id="configuracion" role="tabpanel" aria-labelledby="configuracion-tab" tabindex="0">
            <ul class="nav nav-pills mb-2" id="tab-configuracion" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="conf-inicio-tab" data-bs-toggle="tab" data-bs-target="#conf-inicio" type="button" role="tab" aria-controls="conf-inicio" aria-selected="true">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="conf-inactivos-tab" data-bs-toggle="tab" data-bs-target="#conf-inactivos" type="button" role="tab" aria-controls="conf-inactivos" aria-selected="false">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="conf-reportes-tab" data-bs-toggle="tab" data-bs-target="#conf-reportes" type="button" role="tab" aria-controls="conf-reportes" aria-selected="false">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="conf-auditoria-tab" data-bs-toggle="tab" data-bs-target="#conf-auditoria" type="button" role="tab" aria-controls="conf-auditoria" aria-selected="false">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="tab-content-configuracion">
                <div class="tab-pane fade show active" id="conf-inicio" role="tabpanel" aria-labelledby="conf-inicio-tab" tabindex="0">
                    <livewire:intranet.configuracion.activos />
                </div>
                <div class="tab-pane fade" id="conf-inactivos" role="tabpanel" aria-labelledby="conf-inactivos-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="conf-reportes" role="tabpanel" aria-labelledby="conf-reportes-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="conf-auditoria" role="tabpanel" aria-labelledby="conf-auditoria-tab" tabindex="0"></div>
            </div>
        </div>

        {{-- ====================== ATENCIONES ====================== --}}
        <div class="tab-pane fade" id="personal-atenciones" role="tabpanel" aria-labelledby="personal-atenciones-tab" tabindex="0">
            <ul class="nav nav-pills mb-2" id="tab-atenciones" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="aten-inicio-tab" data-bs-toggle="tab" data-bs-target="#aten-inicio" type="button" role="tab" aria-controls="aten-inicio" aria-selected="true">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="aten-inactivos-tab" data-bs-toggle="tab" data-bs-target="#aten-inactivos" type="button" role="tab" aria-controls="aten-inactivos" aria-selected="false">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="aten-reportes-tab" data-bs-toggle="tab" data-bs-target="#aten-reportes" type="button" role="tab" aria-controls="aten-reportes" aria-selected="false">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="aten-auditoria-tab" data-bs-toggle="tab" data-bs-target="#aten-auditoria" type="button" role="tab" aria-controls="aten-auditoria" aria-selected="false">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="tab-content-atenciones">
                <div class="tab-pane fade show active" id="aten-inicio" role="tabpanel" aria-labelledby="aten-inicio-tab" tabindex="0">
                    <livewire:intranet.atenciones.activos />
                </div>
                <div class="tab-pane fade" id="aten-inactivos" role="tabpanel" aria-labelledby="aten-inactivos-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="aten-reportes" role="tabpanel" aria-labelledby="aten-reportes-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="aten-auditoria" role="tabpanel" aria-labelledby="aten-auditoria-tab" tabindex="0"></div>
            </div>
        </div>

        {{-- ====================== INCIDENCIAS ====================== --}}
        <div class="tab-pane fade" id="personal-incidencias" role="tabpanel" aria-labelledby="personal-incidencias-tab" tabindex="0">
            <ul class="nav nav-pills mb-2" id="tab-incidencias" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="incidencia-inicio-tab" data-bs-toggle="tab" data-bs-target="#incidencia-inicio" type="button" role="tab" aria-controls="incidencia-inicio" aria-selected="true">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="incidencia-inactivos-tab" data-bs-toggle="tab" data-bs-target="#incidencia-inactivos" type="button" role="tab" aria-controls="incidencia-inactivos" aria-selected="false">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="incidencia-reportes-tab" data-bs-toggle="tab" data-bs-target="#incidencia-reportes" type="button" role="tab" aria-controls="incidencia-reportes" aria-selected="false">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="incidencia-auditoria-tab" data-bs-toggle="tab" data-bs-target="#incidencia-auditoria" type="button" role="tab" aria-controls="incidencia-auditoria" aria-selected="false">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="tab-content-incidencias">
                <div class="tab-pane fade show active" id="incidencia-inicio" role="tabpanel" aria-labelledby="incidencia-inicio-tab" tabindex="0">
                    <livewire:intranet.incidencias.activos />
                </div>
                <div class="tab-pane fade" id="incidencia-inactivos" role="tabpanel" aria-labelledby="incidencia-inactivos-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="incidencia-reportes" role="tabpanel" aria-labelledby="incidencia-reportes-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="incidencia-auditoria" role="tabpanel" aria-labelledby="incidencia-auditoria-tab" tabindex="0"></div>
            </div>
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

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush