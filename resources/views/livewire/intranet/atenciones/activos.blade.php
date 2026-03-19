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
                            <label class="btn btn-outline-primary btn-sm me-2">Total: {{ $lista_activos->total() }}</label>
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
                                <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm" placeholder="Buscar por DNI o Datos del Personal">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
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
                                <td colspan="13" class="text-center">
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
    {{-- <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div> --}}


    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%;">
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
                                <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }} disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div>

                            <div class="col-xl-10 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }} disabled>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.rrhh.personal.partials.datos-personales-component')
                                        </fieldset>
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar personal
                                        </button>
                                    </div>
                                    <div class="col-xl-8">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }} disabled>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                            @include('livewire.rrhh.personal.partials.datos-institucionales-component')
                                        </fieldset>
                                        <div class="row">
                                            <div class="col">
                                                @if ($dni)
                                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#transferencia-personal-component" wire:click="nuevo_transferir_personal({{ $persona_id }})">
                                                        <i class="fa-solid fa-people-arrows"></i> Cambiar Ubicación
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- REGISTRO DE TICKES --}}
                        <div class="row">
                            <div class="col-xl-8">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLE DE ATENCIONES</legend>
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label for="cmb_reportado" class="fw-bold fs-6">REPORTADO POR</label>
                                            <select id="cmb_reportado" class="form-select form-select-xs" wire:model="reportado_por">
                                                <option value="">Seleccionar...</option>
                                                <option value="CEA">CEA</option>
                                                <option value="CORREO">CORREO</option>
                                                <option value="DOCUMENTO">DOCUMENTO</option>
                                                <option value="LLAMADA">LLAMADA</option>
                                                <option value="PERSONALMENTE">PERSONALMENTE</option>
                                                <option value="SISTEMA">SISTEMA</option>
                                                <option value="WHATSAPP">WHATSAPP</option>
                                            </select>
                                            @error('reportado_por')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="txtservicio" class="fw-bold fs-6">SERVICIO</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-servicio-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtservicio" class="form-control form-control-xs" wire:model="servicio">
                                            </div>
                                            @error('servicio')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-xl-4">
                                            <label for="txtincidenciasolicitud" class="fw-bold fs-6">INCIDENCIA / SOLICITUD</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-inicidencia-solicitud-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtincidenciasolicitud" class="form-control form-control-xs" wire:model="incidenciasolicitud">
                                            </div>
                                            @error('incidenciasolicitud')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="tipoi" class="fw-bold fs-6">TIPO</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="tipoi" name="tipo" class="btn-check" value="1" autocomplete="off" wire:model.live="tipo">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipoi">INCIDENCIA</label>

                                                <input type="radio" id="tipos" name="tipo" class="btn-check" value="2" autocomplete="off" wire:model.live="tipo">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipos">SOLICITUD</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label for="txtcea" class="fw-bold fs-6">CEA</label>
                                            <input type="text" id="txtcea" class="form-control form-control-xs" wire:model="cea">
                                        </div>
                                        <div class="col-xl-4">
                                            <label for="txtsgf" class="fw-bold fs-6">Carpeta Fiscal</label>
                                            <input type="text" id="txtsgf" class="form-control form-control-xs" wire:model="sgf">
                                        </div>
                                        <div class="col-xl-2">
                                            <label class="fw-bold fs-6">Enviado a Lima</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="enviadoSi" name="enviadoLima" class="btn-check" value="SI" autocomplete="off" wire:model.live="enviado_lima">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoSi">Si</label>

                                                <input type="radio" id="enviadoNo" name="enviadoLima" class="btn-check" value="NO" autocomplete="off" wire:model.live="enviado_lima">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoNo">No</label>
                                            </div>
                                        </div>

                                        <div class="col-xl-3">
                                            <label for="txtglpi" class="fw-bold fs-6">GLPI</label>
                                            <input type="text" id="txtglpi" class="form-control form-control-xs" wire:model=glpi>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-xl-8 col-sm-12">
                                            <label for="txtobservacion" class="fw-bold fs-6">DETALLE DEL PROBLEMA</label>
                                            <div class="input-group input-group">
                                                <input type="text" id="txtobservacion" class="form-control form-control-xs" wire:model="observacion">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label for="txtobservacion" class="fw-bold fs-6">CARGAR EVIDENCIA</label>
                                            <div class="input-group">
                                                {{-- <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                                                    <i class="fa-solid fa-print"></i> Imprimir
                                                </button> --}}
                                                <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                                {{-- <button class="btn btn-outline-warning btn-xs" type="button" id="btncargarcontrato">
                                                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Cargar
                                                </button> --}}
                                                {{-- @if ($ruta_documento)
                                                    <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_documento) }}" target="_blank">
                                                        <i class="fa-solid fa-file-pdf"></i> Ver firmado
                                                    </a>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-4">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ATENCIÓN</legend>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <label class="fw-bold fs-6">ATENDIDO</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="atendidoSi" name="atendido" class="btn-check" value="SI" autocomplete="off" wire:model.live="atendido">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoSi">Sí</label>

                                                <input type="radio" id="atendidoNo" name="atendido" class="btn-check" value="NO" autocomplete="off" wire:model.live="atendido">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="normal" class="fw-bold fs-6">TIEMPO DE ATENCIÓN</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="normal" name="tiempo" class="btn-check" value="NORMAL" autocomplete="off" wire:model.live="tiempo_atencion">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="normal">NORMAL<br> (1 día)</label>

                                                <input type="radio" id="regular" name="tiempo" class="btn-check" value="REGULAR" autocomplete="off" wire:model.live="tiempo_atencion">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regular">REGULAR<br> (2 a 5 días)</label>

                                                <input type="radio" id="complejo" name="tiempo" class="btn-check" value="COMPLEJO" autocomplete="off" wire:model.live="tiempo_atencion">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="complejo">COMPLEJO<br> (mayor a 6 días)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <label for="txt_sol_res" class="fw-bold fs-6">SOLUCIÓN / RESPUESTA</label>
                                            <input type="text" id="txt_sol_res" class="form-control form-control-xs" wire:model="respuesta">
                                        </div>
                                    </div>
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

    {{-- Modal servicios --}}
    @include('livewire.intranet.atenciones.partials.buscar-servicio-component')

    {{-- Modal Incidencias y Solicitudes Detalle --}}
    @include('livewire.intranet.atenciones.partials.buscar-incidencia-solicitud-component')
    


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
    


    @include('livewire.rrhh.personal.partials.buscar-personal-component')

</div>
