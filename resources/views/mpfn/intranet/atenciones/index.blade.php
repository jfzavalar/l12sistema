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
            Livewire.on('copiar-portapapeles', async (texto) => {

                console.log('Texto recibido:', texto);

                if (!texto) {
                    alert('Texto vacío ❌');
                    return;
                }

                // 🔥 1. MÉTODO MODERNO (requiere HTTPS)
                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(texto);
                        alert('Copiado ✅ (moderno)');
                        return;
                    }
                } catch (e) {
                    console.warn('Clipboard API falló:', e);
                }

                // 🔥 2. FALLBACK REAL
                try {
                    const textarea = document.createElement("textarea");
                    textarea.value = texto;

                    // 👇 IMPORTANTE (visible para algunos navegadores)
                    textarea.style.position = "fixed";
                    textarea.style.top = "10px";
                    textarea.style.left = "10px";
                    textarea.style.width = "200px";
                    textarea.style.height = "50px";
                    textarea.style.opacity = "1";

                    document.body.appendChild(textarea);

                    textarea.focus();
                    textarea.select();

                    const successful = document.execCommand('copy');

                    document.body.removeChild(textarea);

                    if (successful) {
                        alert('Copiado ✅');
                    } else {
                        alert('No se pudo copiar ❌');
                    }

                } catch (err) {
                    console.error(err);
                    alert('Error al copiar ❌');
                }

            });
        });
    </script>
@stop