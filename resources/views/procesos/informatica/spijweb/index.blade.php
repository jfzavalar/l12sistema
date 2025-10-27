@extends('layouts.bootstrap5.index')

@section('title', 'Spijweb')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-viewfinder"></i> Spijweb
        </h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
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
            <livewire:informatica.spijweb.activos />
        </div>
        <div class="tab-pane fade" id="2-tab-pane" role="tabpanel" aria-labelledby="2-tab" tabindex="0">
            {{-- <livewire:dashboard.inactivos /> --}}
        </div>
        <div class="tab-pane fade" id="3-tab-pane" role="tabpanel" aria-labelledby="3-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="4-tab-pane" role="tabpanel" aria-labelledby="4-tab" tabindex="0">...</div>
    </div>
        
@endsection


@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop


@section('js')
    {{-- Cerrar modal despues de guardar --}}
    <script>
        window.addEventListener('cerrar-modal',()=>{
            const modal = bootstrap.Modal.getInstance(document.getElementById('new-edit-Modal'));
            if (modal){
                modal.hide();
            }

            // Alerta
            Swal.fire({
                title: "Los datos se guardaron correctamente!",
                icon: "success",
                draggable: true
            });
        });
    </script>

    {{-- Cerrar modal despues de enviar correo --}}
    <script>
        window.addEventListener('cerrar-enviar-modal',()=>{
            const modal = bootstrap.Modal.getInstance(document.getElementById('enviar-correo-Modal'));
            if (modal){
                modal.hide();
            }

            // Alerta
            Swal.fire({
                title: "Los datos se enviaron correctamente!",
                icon: "success",
                draggable: true
            });
        });
    </script>

    {{-- Cancelar operación --}}
    <script>
        window.addEventListener('cancelar-proceso', event => {
            Swal.fire({
                icon: 'error',
                title: "CANCELAR",
                text: "Se canceló la operación",
                footer: ""
            });
        });
    </script>

    {{-- Eliminar Registros --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('confirmarEliminacion', id => {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('eliminar', id);
                        Swal.fire("¡Eliminado!", "El registro ha sido eliminado.", "success");
                    }
                });
            });
        });
    </script>

    {{-- Reactivar Registros --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('confirmarReactivacion', id => {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, reactivar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('reactivar', id);
                        Swal.fire("¡Reactivación!", "El registro ha sido reactivado.", "success");
                    }
                });
            });
        });
    </script>

    {{-- Limpiar input file pdf --}}
    <script>
        window.addEventListener('reset-pdf-input', () => {
            document.getElementById('input-pdf').value = '';
        });
    </script>

    {{-- Cerrar modal de cargar PDF --}}
    <script>
        window.addEventListener('cerrar-modal-pdf', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('pdf-cargar-Modal'));
            if (modal) modal.hide();
            Swal.fire({
                icon: 'success',
                title: '¡Archivo cargado!',
                text: 'El PDF se ha subido correctamente.',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@stop