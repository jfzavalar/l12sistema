{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'INF-Tickets')

@section('content')
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> TICKETS ATENCIONES: {{ strtoupper(now()->locale('es')->translatedFormat('F Y')) }}
        </h1>
    </div> --}}

    <livewire:intranet.atenciones.activos />
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop


@section('js')
    <script>
        function copiarTexto() {
            const textarea = document.getElementById("textoCopiar");

            textarea.focus();
            textarea.select();

            try {
                const ok = document.execCommand('copy');

                if (ok) {
                    alert('Copiado correctamente');
                } else {
                    alert('No se pudo copiar');
                }

            } catch (err) {
                console.error(err);
                alert('Error al copiar');
            }
        }
    </script>
@stop
