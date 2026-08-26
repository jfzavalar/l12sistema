{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Desplazamiento')

@section('content')

    <livewire:patrimonio.bienes.bienestraslado-component />
    
@endsection

@push('scripts')
    {{-- <script>
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
    </script> --}}
@endpush