{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Voluntariado')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> Marcación Voluntariado
        </h1>
        <div class="btn-group">
            {{-- <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                <i class="fa-regular fa-file-pdf"></i> PDF
            </a>
            <a id="btnreporteexcel" class="btn btn-outline-success btn-sm" href="{{ url('personas/exportar') }}">
                <i class="fa-regular fa-file-excel"></i> Excel
            </a> --}}
        </div>
    </div>

    <livewire:voluntariado.asistencia.activos />
@endsection

@section('css')
    
@stop


@section('js')
    {{-- Actualizar hora en tiempo real --}}
    <script>
        function actualizarHora() {
            const ahora = new Date();

            // Hora local exacta con segundos
            const horaLocal = ahora.toLocaleTimeString('es-PE', {
                hour12: false, 
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('hora_actual').value = horaLocal;
        }

        setInterval(actualizarHora, 1000);
        actualizarHora();
    </script>
@stop