<div>
    @if (session()->has('danger'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-xl-4 col-gl-6 col-sm-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Informatica</th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse ($totales_asignados as $tactivos) --}}
                                <tr class="align-middle" style="font-size: 12px;">
                                    <th scope="row">Usuario</th>
                                    <th style="white-space: nowrap;"></th>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white">
                                                    <i class="fa-solid fa-check me-2"></i>Atendidos
                                                </button>
                                                <label class="form-control form-control-xs"></label>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-danger text-white">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendientes
                                                </button>
                                                <label class="form-control form-control-xs"></label>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-info text-white">
                                                    <i class="fa-solid fa-envelope"></i>Lima
                                                </button>
                                                <label class="form-control form-control-xs"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            {{-- @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-4 col-gl-6 col-sm-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Digitalizadores</th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse ($totales_asignados as $tactivos) --}}
                                <tr class="align-middle" style="font-size: 12px;">
                                    <th scope="row">Usuario</th>
                                    <th style="white-space: nowrap;"></th>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white">
                                                    <i class="fa-solid fa-check me-2"></i>Atendidos
                                                </button>
                                                <label class="form-control form-control-xs"></label>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-info text-white">
                                                    <i class="fa-solid fa-file-pdf"></i>Folios
                                                </button>
                                                <label class="form-control form-control-xs"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            {{-- @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>

                <div class="col-xl-4 col-gl-6 col-sm-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h5 class="card-title">
                                    Total
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4><i class="fa-solid fa-chart-simple text-primary"></i></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    A
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4><i class="fa-solid fa-file-signature text-success"></i></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    B
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4><i class="fa-solid fa-signature text-danger"></i></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive small">
                {{-- <div class="input-group mb-3"> --}}
                    <div class="row g-3">
                        <div class="col-lg-2 col-sm-12">
                            <label for="txtsearchpersonalatenciones" class="btn btn-outline-primary btn-sm me-2">Total: {{ $lista_activos->total() }}</label>
                        </div>
                        
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_anio" wire:model="filtro_anio" class="form-select form-select-sm me-2">
                                <option value="">-- Año --</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                    <option value="{{ $anio }}" {{ $anio == date('Y') ? 'selected' : '' }}>
                                        {{ $anio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_mes" wire:model="filtro_mes" class="form-select form-select-sm me-2">
                                <option value="">-- Mes --</option>
                                @foreach ([
                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                ] as $num => $mes)
                                    <option value="{{ $num }}" {{ $num == date('n') ? 'selected' : '' }}>
                                        {{ $mes }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearchpersonalatenciones" class="form-control form-control-sm" wire:model.live="searchpersonalatenciones" placeholder="Buscar por DNI o Datos del Personal">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>
                            <th scope="col">TIPO</th>
                            <th scope="col">PEDIDO</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">MEDIO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" class="bg-success-subtle">SOLUCIÓN</th>
                            <th scope="col">GLPI</th>
                            <th scope="col">CEA</th>
                            <th scope="col">CARPETA</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-ticket"></i> {{ $loop->iteration }}
                                </th>
                                <td><b>{{ $item->dni }}</b> <br> {{ $item->datos }}</td>
                                <td></td>
                                <td>
                                    
                                </td>
                                <td class="text-primary">
                                    
                                </td>
                                <td>{{ $item->reportado_por }}</td>
                                <td>
                                    <span class="badge rounded-pill text-bg-success">
                                        ATENDIDO
                                    </span>
                                </td>
                                <td>{{ $item->created_user }}</td>
                                <td>

                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>                   
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>                           
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13"><br></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Barra de paginación flotante con total --}}
    {{-- <div class="pagination-floating position-fixed bottom-0 start-50 translate-middle-x bg-white border-top shadow-sm py-2 px-4 w-100 w-md-auto" style="z-index: 1050;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small">
                <strong>Total de registros:</strong> {{ $lista_atenciones->total() }}
            </div>
            <div class="d-inline-block">
                {{ $lista_atenciones->links() }}
            </div>
        </div>
    </div> --}}

    {{-- Flotante - paginación --}}
    <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div>


    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }}>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div>

                            <div class="col-xl-10 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.rrhh.personal.partials.datos-personales-component')
                                        </fieldset>
                                        {{-- <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm" data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                        </button> --}}
                                    </div>
                                    <div class="col-xl-8">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                            @include('livewire.rrhh.personal.partials.datos-institucionales-component')
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS CONTRATO / ADENDA / RENUNCIA</legend>
                                    @include('livewire.rrhh.contratos.partials.datos-contrato-component')
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Incidencias y Solicitudes --}}
    {{-- <div class="modal fade @if($modal_abierto_incidencia_solicitud) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                        BUSCAR SERVICIO
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_indicencia_solicitud"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control form-control-sm mb-2" placeholder="Buscar por incidencia o solicitud" wire:model.live="searchincidenciasolicitud">
                    <div class="table-responsive small">
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Incidencia / Solicitud</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_indicencias_solicitudes as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td></td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-success btn-sm" wire:click="agregar_indicencia_solicitud('{{ $item->descripcion }}')">
                                                        <i class="fa-solid fa-share-from-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <div class="alert alert-danger" role="alert">
                                                No se encontraron resultados!
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $lista_indicencias_solicitudes->links() }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_indicencia_solicitud">
                        <i class="fa-solid fa-square-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Modal Incidencias y Solicitudes Detalle --}}
    {{-- <div class="modal fade @if($modal_abierto_incidencia_solicitud_detalle) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                        BUSCAR DETALLE DE INCIDENCIAS O SOLICITUDES
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_indicencia_solicitud_desc"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control form-control-sm mb-2" placeholder="Buscar por detalle incidencia o solicitud" wire:model.live="searchincidenciasolicituddesc">
                    <div class="table-responsive small">
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Incidencia / Solicitud</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_indicencias_solicitudes_desc as $item2)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td></td>
                                        <td>{{ $item2->detalle }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-success btn-sm" wire:click="agregar_indicencia_solicitud_desc('{{ $item2->detalle }}')">
                                                        <i class="fa-solid fa-share-from-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <div class="alert alert-danger" role="alert">
                                                No se encontraron resultados!
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $lista_indicencias_solicitudes_desc->links() }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_indicencia_solicitud_desc">
                        <i class="fa-solid fa-square-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- Cargar varios documentos y e imágenes --}}

    <!-- Modal Cargar PDF -->
    {{-- <div class="modal fade @if($modal_abierto_pdf_cargar) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="cargarPDF2">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <i class="fa-solid fa-file-pdf"></i> CARGAR PDF
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_PDF" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mt-3 mb-3">
                            <input 
                                type="file" 
                                class="form-control" 
                                id="input-pdf" 
                                wire:model="pdfs" 
                                accept="application/pdf" 
                                multiple 
                                required
                            >
                            @error('pdfs.*') 
                                <span class="text-danger small">{{ $message }}</span> 
                            @enderror
                            Vista previa opcional
                        </div>
                        @if ($pdfs)
                            <ul class="list-group mt-2">
                                @foreach ($pdfs as $index => $file)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="text-truncate" style="max-width: 75%;">
                                            <i class="fa-solid fa-file-zipper"></i>
                                            {{ $file->getClientOriginalName() }}
                                            <span class="badge bg-light text-dark">
                                                {{ number_format($file->getSize() / 1024, 1) }} KB
                                            </span>
                                        </div>
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-danger btn-sm rounded-circle"
                                            title="Quitar este archivo"
                                            wire:click="eliminarPDF({{ $index }})"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <br>Guardar
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_PDF">
                            <i class="fa-solid fa-door-closed"></i>
                            <br>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    


    {{-- @include('livewire.partials.personal-modal-buscar') --}}

</div>
