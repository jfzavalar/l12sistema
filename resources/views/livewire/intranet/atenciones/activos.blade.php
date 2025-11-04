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
                                    <h1><i class="fa-solid fa-chart-simple text-primary"></i></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    A
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1><i class="fa-solid fa-file-signature text-success"></i></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    B
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1><i class="fa-solid fa-signature text-danger"></i></h1>
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
                            <label for="txtsearchpersonalatenciones" class="btn btn-outline-primary btn-sm me-2">Total:</label>
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
                    {{-- <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <th>{{ $item->dni }}</th>
                                <td>{{ $item->datos }}</td>
                                <td>
                                    <b>SEDE: </b>{{ $item->sede_origen }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_origen }}
                                </td>
                                <td class="text-primary">
                                    <b>SEDE: </b>{{ $item->sede_destino }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_destino }}
                                </td>
                                <td><b>{{ $item->regimen }}</b></td>
                                <td>{{ $item->cargo }}</td>
                                <td>
                                    <b>CEL: </b>{{ $item->cel_personal }}
                                    <br>{{ $item->correo_personal }}
                                </td>
                                <td>
                                    <b>CEL: </b>{{ $item->cel_institucional }}
                                    <br>{{ $item->correo_institucional  }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="nuevo_contrato({{ $item->id }})">
                                            <i class="fa-solid fa-file"></i><br>Nuevo_contrato
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
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
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo-Editar-->
    <div class="modal fade @if($modal_abierto_atenciones) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-ticket"></i> NUEVO - ATENCIONES
                            @else
                                <i class="fa-solid fa-ticket"></i> EDITAR - ATENCIONES
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-3 col-sm-12">
                                    <fieldset class="border p-3 rounded text-center mb-3" disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">FOTO DE PERFIL</legend>
                                        @include('livewire.partials.personal-datos-foto')
                                    </fieldset>
                                </div>
                                <div class="col-xl-9 col-sm-12">
                                    {{-- <fieldset class="border p-3 rounded mb-3" disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend>
                                        @include('livewire.partials.personal-datos-institucionales-mir')
                                    </fieldset> --}}

                                    @include('livewire.partials.personal-datos-institucionales-mir')
                                    
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <fieldset class="border p-3 rounded mb-3">
                                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS PERSONALES</legend> --}}
                                                @include('livewire.partials.personal-datos-personales')
                                            </fieldset> 
                                        </div>
                                        <div class="col-xl-9">
                                            <fieldset class="border p-3 rounded mb-3" disabled>
                                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend> --}}
                                                @include('livewire.partials.personal-datos-institucionales')
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DETALLE DE LA ATENCIÓN</legend>
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <label for="cmb_reportado" class="fw-bold fs-6">REPORTADO POR</label>
                                                <select id="cmb_reportado" class="form-select form-select-xs">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="CEA">CEA</option>
                                                    <option value="CORREO">CORREO</option>
                                                    <option value="DOCUMENTO">DOCUMENTO</option>
                                                    <option value="LLAMADA">LLAMADA</option>
                                                    <option value="PERSONALMENTE">PERSONALMENTE</option>
                                                    <option value="SISTEMA">SISTEMA</option>
                                                    <option value="WHATSAPP">WHATSAPP</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="tipoi" class="fw-bold fs-6">TIPO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="tipoi" name="tipo" class="btn-check" value="INCIDENCIA" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="tipoi">INCIDENCIA</label>

                                                    <input type="radio" id="tipos" name="tipo" class="btn-check" value="SOLICITUD" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="tipos">SOLICITUD</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="txt_ind_sol" class="fw-bold fs-6">INDICENCIA/SOLICITUD</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-xs" wire:click="buscar_indicencia_solicitud">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" id="txt_ind_sol" class="form-control form-control-xs" wire:model="descripcion">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="txt_especificacion" class="fw-bold fs-6">ESPECIFICACIÓN (Incidencia / Solicitud)</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-xs" wire:click="buscar_indicencia_solicitud_desc">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" id="txt_especificacion" class="form-control form-control-xs" wire:model="detalle">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <label for="txt_cea" class="fw-bold fs-6">CEA</label>
                                                <input type="text" id="txt_cea" class="form-control form-control-xs">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="txt_cf" class="fw-bold fs-6">Carpeta Fiscal</label>
                                                <input type="text" id="txt_cf" class="form-control form-control-xs">
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="enviadoSi" class="fw-bold fs-6">Enviado a Lima</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="enviadoSi" name="enviadoLima" class="btn-check" value="SI" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="enviadoSi">Sí</label>

                                                    <input type="radio" id="enviadoNo" name="enviadoLima" class="btn-check" value="NO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="enviadoNo">No</label>
                                                </div>
                                            </div>

                                            <div class="col-xl-3">
                                                <label for="txt_glpi" class="fw-bold fs-6">GLPI</label>
                                                <input type="text" id="txt_glpi" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label for="text_descripcion" class="fw-bold fs-6">DESCRIPCIÓN (Opcional)</label>
                                                <input type="text" id="text_descripcion" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="border p-3 rounded mb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <label for="atendidoSi" class="fw-bold fs-6">ATENDIDO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="atendidoSi" name="atendido" class="btn-check" value="SI" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="atendidoSi">Sí</label>

                                                    <input type="radio" id="atendidoNo" name="atendido" class="btn-check" value="NO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="atendidoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="txtdespacho" class="fw-bold fs-6">TIEMPO DE ATENCIÓN</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="normal" name="tiempo" class="btn-check" value="NORMAL" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="normal">NORMAL (1 día)</label>

                                                    <input type="radio" id="regular" name="tiempo" class="btn-check" value="REGULAR" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="regular">REGULAR (2 a 5 días)</label>

                                                    <input type="radio" id="complejo" name="tiempo" class="btn-check" value="COMPLEJO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="complejo">COMPLEJO (mayor a 6 días)</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="txtdespacho" class="fw-bold fs-6">ADJUNTAR</label>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-dark btn-xs flex-fill" wire:click="cargarPDF1"> Seleccionar...</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label for="txt_sol_res" class="fw-bold fs-6">SOLUCIÓN / RESPUESTA</label>
                                                <input type="text" id="txt_sol_res" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i> Guardar y Responder <i class="fa-solid fa-envelope"></i>
                            @else
                                <i class="fa-solid fa-floppy-disk"></i> Actualizar
                            @endif    
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Incidencias y Solicitudes --}}
    <div class="modal fade @if($modal_abierto_incidencia_solicitud) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                        BUSCAR INCIDENCIAS O SOLICITUDES
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
    </div>

    {{-- Modal Incidencias y Solicitudes Detalle --}}
    <div class="modal fade @if($modal_abierto_incidencia_solicitud_detalle) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
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
    </div>


    {{-- Cargar varios documentos y e imágenes --}}

    <!-- Modal Cargar PDF -->
    <div class="modal fade @if($modal_abierto_pdf_cargar) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
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
                            {{-- Vista previa opcional --}}
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
    </div>
    


    @include('livewire.partials.personal-modal-buscar')

</div>
