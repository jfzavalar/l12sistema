{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> TICKETS ATENCIONES
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

    <livewire:intranet.atenciones.activos />
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop


@section('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copiar-portapapeles', (texto) => {

                // ✅ Método moderno (solo HTTPS)
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(texto)
                        .then(() => {
                            alert('Copiado ✅');
                        })
                        .catch(err => {
                            console.error('Clipboard error:', err);
                        });

                } else {
                    // 🔥 Fallback universal
                    let textarea = document.createElement("textarea");
                    textarea.value = texto;
                    textarea.style.position = "fixed"; // evita scroll
                    textarea.style.opacity = "0";

                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();

                    try {
                        document.execCommand('copy');
                        alert('Copiado (fallback) ✅');
                    } catch (err) {
                        console.error('Fallback error:', err);
                    }

                    document.body.removeChild(textarea);
                }

            });
        });
        </script>
@stop