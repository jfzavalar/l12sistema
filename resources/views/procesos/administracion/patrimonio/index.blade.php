@extends('layouts.bootstrap5.index')

@section('title', 'Patrimonio')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-boxes-stacked"></i> Patrimonio
        </h1>
        <div class="btn-group">
            @include('layouts.bootstrap5.btnlogin')
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
            <button class="nav-link active" id="bienes-tab" data-bs-toggle="tab" data-bs-target="#bienes" type="button" role="tab" aria-controls="bienes" aria-selected="true">
                <i class="fa-solid fa-layer-group"></i> Bienes
            </button>
            <button class="nav-link" id="asignacion-bienes-tab" data-bs-toggle="tab" data-bs-target="#asignacion-bienes" type="button" role="tab" aria-controls="asignacion-bienes" aria-selected="false">
                <i class="fa-solid fa-people-carry-box"></i> Asignación
            </button>
            <button class="nav-link" id="desplazamiento-bienes-tab" data-bs-toggle="tab" data-bs-target="#desplazamiento-bienes" type="button" role="tab" aria-controls="desplazamiento-bienes" aria-selected="false">
                <i class="fa-solid fa-people-carry-box"></i> Desplazamiento
            </button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="bienes" role="tabpanel" aria-labelledby="bienes-tab" tabindex="0">
            {{-- Tramite de Tokens --}}
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
                    <livewire:administracion.patrimonio.bienes.activos />
                </div>
                <div class="tab-pane fade" id="2-tab-pane" role="tabpanel" aria-labelledby="2-tab" tabindex="0">
                    
                </div>
                <div class="tab-pane fade" id="3-tab-pane" role="tabpanel" aria-labelledby="3-tab" tabindex="0">
                    
                </div>
                <div class="tab-pane fade" id="4-tab-pane" role="tabpanel" aria-labelledby="4-tab" tabindex="0">

                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="asignacion-bienes" role="tabpanel" aria-labelledby="asignacion-bienes-tab" tabindex="0">

        </div>

        <div class="tab-pane fade" id="desplazamiento-bienes" role="tabpanel" aria-labelledby="desplazamiento-bienes-tab" tabindex="0">
            {{-- Tramite de PCs --}}
            <ul class="nav nav-pills mb-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="5-tab" data-bs-toggle="tab" data-bs-target="#5-tab-pane" type="button" role="tab" aria-controls="5-tab-pane" aria-selected="true">
                        <i class="fa-solid fa-house-user"></i> Inicio
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="6-tab" data-bs-toggle="tab" data-bs-target="#6-tab-pane" type="button" role="tab" aria-controls="6-tab-pane" aria-selected="false">
                        <i class="fa-solid fa-house-circle-xmark"></i> Inactivos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="7-tab" data-bs-toggle="tab" data-bs-target="#7-tab-pane" type="button" role="tab" aria-controls="7-tab-pane" aria-selected="false">
                        <i class="fa-solid fa-chart-pie"></i> Reportes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="8-tab" data-bs-toggle="tab" data-bs-target="#8-tab-pane" type="button" role="tab" aria-controls="8-tab-pane" aria-selected="false">
                        <i class="fa-solid fa-audio-description"></i> Auditoría
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="5-tab-pane" role="tabpanel" aria-labelledby="5-tab" tabindex="0">
                    {{-- <livewire:administracion.patrimonio.desplazamiento.activos /> --}}
                </div>
                <div class="tab-pane fade" id="6-tab-pane" role="tabpanel" aria-labelledby="6-tab" tabindex="0">
                    
                </div>
                <div class="tab-pane fade" id="7-tab-pane" role="tabpanel" aria-labelledby="7-tab" tabindex="0">
                </div>
                <div class="tab-pane fade" id="8-tab-pane" role="tabpanel" aria-labelledby="8-tab" tabindex="0">

                </div>
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
@endpush