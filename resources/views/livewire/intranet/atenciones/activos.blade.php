<div>
    {{-- @if (session()->has('danger'))
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
    @endif --}}

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-ticket"></i> TICKETS: {{ strtoupper(now()->locale('es')->translatedFormat('F Y')) }}
        </h1>
        <div class="row">
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                    <span class="alert alert-primary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            TOTAL: {{ $estadisticas2->total }}
                        </span>
                    </span>
                </button>
            </div>
            
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAtendido">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            ATENDIDOS: {{ $estadisticas2->atendidos }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNoatendido">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            PENDIENTES: {{ $estadisticas2->no_atendidos }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarEnviadolima">
                    <span class="alert alert-info d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            LIMA: {{ $estadisticas2->enviado_lima }}
                        </span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <i class="fa-solid fa-user"></i> Informatica
                                </th>
                                <th scope="col" colspan="2" class="text-center">Tickets</th>
                                <th class="text-center">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE")
                                    <tr class="align-middle" style="font-size: 10px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white" wire:click="filtrarAtendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <div class="form-control form-control-xs text-end">{{ $item->atendidos }}</div>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-danger text-white" wire:click="filtrarNoatendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendientes
                                                    </button>
                                                    <div class="form-control form-control-xs text-end">{{ $item->no_atendidos }}</div>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white" wire:click="filtrarEnviadolima('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-envelope me-1"></i>Lima
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-2">{{ $item->enviado_lima }}</div>
                                                    {{-- <a type="button" class="btn btn-dark" href="{{ route('pdf.informatica.atencion-por-usuario-acta', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                        <i class="fa-solid fa-print me-1"></i>Reporte
                                                    </a> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a type="button" class="btn btn-dark btn-xs" href="{{ route('pdf.informatica.atencion-por-usuario-acta', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                <i class="fa-solid fa-print me-1"></i>Reporte
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <i class="fa-solid fa-user"></i> Digitalizadores
                                </th>
                                <th scope="col" colspan="2" class="text-center">Tickets</th>
                                <th class="text-center">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "TERCERO")
                                    <tr class="align-middle" style="font-size: 10px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white" wire:click="filtrarAtendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-1">{{ $item->atendidos }}</div>
                                                </div>
                                                {{-- <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-warning text-white" wire:click="filtrarAtendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-file-circle-plus me-1"></i>Digitalización
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-1">{{ $item->atendidos }}</div>
                                                </div> --}}
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-file-pdf me-1"></i>Folios
                                                    </button>
                                                    <div class="form-control form-control-xs text-end">{{ $item->digitalizado }}</div>
                                                    {{-- <a type="button" class="btn btn-dark" href="{{ route('pdf.informatica.atencion-por-usuario-acta2', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                        <i class="fa-solid fa-print me-1"></i>Reporte
                                                    </a> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a type="button" class="btn btn-dark btn-xs" href="{{ route('pdf.informatica.atencion-por-usuario-acta2', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                <i class="fa-solid fa-print me-1"></i>Reporte
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-responsive-xl">
                    <div class="row g-3">                      
                        <div class="col-lg-1 col-sm-12">
                            <div class="input-group">
                                <button type="button" class="btn btn-dark btn-sm" wire:click="reportesFiltros">
                                    <i class="fa-solid fa-filter"></i> Filtrar por:
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-11 col-sm-12">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                <input type="text" name="txtsearchpersonalatenciones2" id="txtsearchpersonalatenciones2" class="form-control form-control-sm me-1" placeholder="Buscar por DNI o Datos del Personal" wire:model.live="search">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#TICKET</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> SOLICITANTE
                            </th>
                            {{-- <th scope="col">REGIMEN - CARGO</th> --}}
                            {{-- <th scope="col" class="table-danger">TIPO</th> --}}
                            <th scope="col" class="bg-success-subtle">MEDIO</th>
                            <th scope="col" class="bg-success-subtle">TIPO</th>
                            <th scope="col" class="bg-success-subtle">DESCRIPCIÓN DEL SERVICIO</th>
                            <th scope="col" class="bg-success-subtle">SOLUCIÓN</th>                     
                            <th scope="col" class="bg-success-subtle">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" colspan="3" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-ticket"></i> {{ $item->id }}
                                </th>
                                <td>
                                    <b>{{ $item->dni }}</b>
                                    <br> {{ $item->datos }}
                                    <br>{{ $item->created_at }}
                                </td>
                                {{-- <td>
                                    <b>{{ $item->regimen }}</b>
                                    <br>
                                    {{ $item->cargo }}
                                </td> --}}
                                {{-- <td>
                                    <b>SEDE: </b>{{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO: </b>{{ $item->despachodestino }}
                                </td> --}}
                                <td class="text-center align-middle">
                                    @if ($item->reportado_por === "CEA")
                                        <b>CEA</b>
                                    @elseif (($item->reportado_por === "CORREO"))
                                        <i class="fa-solid fa-envelope"></i>
                                    @elseif (($item->reportado_por === "DOCUMENTO"))
                                        <i class="fa-solid fa-file"></i>
                                    @elseif (($item->reportado_por === "GESTION"))
                                        <i class="fa-brands fa-black-tie"></i>
                                    @elseif (($item->reportado_por === "LLAMADA"))
                                        <i class="fa-solid fa-phone"></i>
                                    @elseif (($item->reportado_por === "PERSONALMENTE"))
                                        <i class="fa-solid fa-user"></i>
                                    @elseif (($item->reportado_por === "SISTEMA"))
                                        <i class="fa-brands fa-windows"></i>
                                    @elseif (($item->reportado_por === "WHATSAPP"))
                                        <i class="fa-brands fa-whatsapp"></i>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge py-1 rounded-pill {{ $item->solicitud_incidencia == 'INCIDENCIA' ? 'bg-primary-subtle text-primary' : 'bg-dark-subtle text-dark' }}">
                                        {{ $item->solicitud_incidencia }}
                                    </span>
                                </td>
                                <td>
                                    <b>TIPO: </b>{{ $item->solicitud_incidencia }}
                                    <br>
                                    <b>SERVICIO: </b> {{ $item->servicio }}
                                    <br>
                                    <b>DESCRIPCIÓN: </b>{{ $item->detalle_servicio }}
                                </td>
                                <td>
                                    {{ $item->respuesta }}
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge py-1 rounded-pill {{ $item->atendido == 'SI' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $item->atendido === 'SI' ? 'ATENDIDO' : 'NO ATENDIDO' }}
                                    </span>
                                </td>
                                <td class="text-center align-middle small text-nowrap">
                                    {{ $item->atendido_por_datos}}
                                    <br>
                                    <b>{{ $item->created_at }}</b>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @if ($item->created_user === auth()->user()->datos || auth()->user()->hasRole('Admin-Super'))
                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button> 
                                        @endif
                                        @can('mpfn.intranet.atenciones.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                                <td class="text-stard">
                                    <div class="btn-group" role="group">
                                        @if (!empty($item->id))
                                            <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.atencion-acta', ['id' => $item->id]) }}" target="_blank">
                                                <i class="fa-solid fa-file-pdf"></i><br>Acta
                                            </a>
                                        @endif

                                        @if ($item->created_user === auth()->user()->datos || auth()->user()->hasRole('Admin-Super'))
                                            <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                                <i class="fa-solid fa-upload"></i><br>Cargar
                                            </button>
                                        @endif
                                        @if($item->ruta_documento)
                                            <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-file-signature"></i><br> Firmado
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-stard">
                                    <div class="btn-group" role="group">
                                        @if($item->ruta_evidencia)
                                            <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_evidencia) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-receipt"></i><br> Evidencia
                                            </a>
                                        @endif
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
                            <td colspan="13">
                                {{ $lista_activos->links() }}
                            </td>
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
    {{-- <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true"> --}}
    {{-- <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true"> --}}
    <div>
        <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
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
                                {{-- <div class="col-xl-1 col-sm-12">
                                    <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }} disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">PERFIL</legend>
                                        @include('livewire.partials.componentes.persona-foto')
                                    </fieldset>
                                </div> --}}

                                <div class="col-xl-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                                <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                                @include('livewire.partials.componentes.persona-datos')
                                            </fieldset>
                                            {{-- <input list="personales" class="form-control form-control-sm" placeholder="Seleccionar...">
                                            <datalist id="personales">
                                                @foreach ($lista_personas2 as $personal)
                                                    <option value="{{ $personal->dni }}">{{ $personal->datos }}</option>
                                                @endforeach
                                            </datalist> --}}
                                        </div>
                                        <div class="col-xl-5">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
                                                <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                                @include('livewire.partials.componentes.personal-datos')
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2">
                                            <textarea id="textoCopiar" class="form-control" rows="10" style="font-size: 12px; white-space: nowrap; overflow-x: auto;" readonly>{{ $this->generarTexto() }}</textarea>
                                            <button onclick="copiarTexto()" class="btn btn-dark btn-xs mb-1">
                                                <i class="fa-solid fa-copy"></i> Copiar Datos
                                            </button>                                 
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- REGISTRO DE TICKES --}}
                            <div class="row">
                                <div class="col-xl-7">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLE DE LA INCIDENCIA/SOLICITUD</legend>
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <label for="cmb_reportado" class="fw-bold fs-6">REPORTADO POR</label>
                                                <select id="cmb_reportado" class="form-select form-select-xs" wire:model="reportado_por" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="CEA">CEA</option>
                                                    <option value="CORREO">CORREO</option>
                                                    <option value="DOCUMENTO">DOCUMENTO</option>
                                                    <option value="DOCUMENTO">GESTION</option>
                                                    <option value="LLAMADA">LLAMADA</option>
                                                    <option value="PERSONALMENTE">PERSONALMENTE</option>
                                                    <option value="SISTEMA">SISTEMA</option>
                                                    <option value="WHATSAPP">WHATSAPP</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <label for="txtservicio" class="fw-bold fs-6">SERVICIO</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="servicioBuscar">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" id="txtservicio" class="form-control form-control-xs bg-light" wire:model="servicio" readonly required>
                                                </div>
                                                @error('servicio')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="txtdetalle_servicio" class="fw-bold fs-6">SOLICITUD / INCIDENCIA</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="servicioDetalleBuscar">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" id="txtdetalle_servicio" class="form-control form-control-xs bg-light" wire:model="detalle_servicio" readonly required>
                                                </div>
                                                @error('detalle_servicio')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-xl-3">
                                                <label for="tipoi" class="fw-bold fs-6">TIPO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="tipoi" name="solicitud_incidencia" class="btn-check" value="INCIDENCIA" autocomplete="off" wire:model.live="solicitud_incidencia" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipoi">INCIDENCIA</label>

                                                    <input type="radio" id="tipos" name="solicitud_incidencia" class="btn-check" value="SOLICITUD" autocomplete="off" wire:model.live="solicitud_incidencia" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipos">SOLICITUD</label>
                                                </div>
                                            </div>
                                        </div>
                                        @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
                                            <div class="row">
                                                <div class="col-xl-2">
                                                    <label for="txtcod" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs {{ $mostrarcontroles }}" wire:click="bienesBuscar">
                                                            <i class="fa-solid fa-magnifying-glass"></i>
                                                        </button>
                                                        <input type="text" id="txtcod" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <label for="txtcodpatrimonial" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD_PATRIMONIAL</label>
                                                    <div class="input-group">
                                                        {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Cod. Patrimonial</span> --}}
                                                        <input type="text" id="txtcodpatrimonial" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod_patrimonial" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txtequipo" class="fw-bold fs-6 {{ $mostrarcontroles }}">BIEN INFORMATICO</label>
                                                    <div class="input-group">
                                                        {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Bien</span> --}}
                                                        <input type="text" id="txtequipo" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="datos_bien" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <label for="txtip" class="fw-bold fs-6 {{ $mostrarcontroles }}">IP</label>
                                                    <input type="text" id="txtip" class="form-control form-control-xs {{ $mostrarcontroles }} is-valid" wire:model.defer="bien_ip" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-12 col-xl">
                                                <label for="txtcea" class="fw-bold fs-6">CEA</label>
                                                <input type="text" id="txtcea" class="form-control form-control-xs text-uppercase" wire:model="cea">
                                            </div>
                                            <div class="col-12 col-xl">
                                                <label for="txtsgf" class="fw-bold fs-6">N° CARPETA FISCAL</label>
                                                <input type="text" id="txtsgf" class="form-control form-control-xs text-uppercase" wire:model="sgf">
                                            </div>
                                            <div class="col-12 col-xl">
                                                <label for="txtobservacion" class="fw-bold fs-6">CARGAR EVIDENCIA</label>
                                                <div class="input-group">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                                        @if ($ruta_evidencia)
                                                            <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_evidencia) }}" target="_blank">
                                                                <i class="fa-solid fa-file-pdf"></i> Ver Evidencia
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($servicio_id === 7 || $servicio === "DIGITALIZACION - CARPETAS" )
                                                <div class="col-12 col-xl">
                                                    <label for="txtncopias" class="fw-bold fs-6"># DE COPIAS</label>
                                                    <div class="input-group input-group">
                                                        <input type="number" id="txtncopias" class="form-control form-control-xs is-valid" wire:model="ncopias" min="0">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-xl">
                                                <label for="txtobservacion" class="fw-bold fs-6">DETALLE DEL PROBLEMA</label>
                                                <div class="input-group input-group">
                                                    <input type="text" id="txtobservacion" class="form-control form-control-xs text-uppercase" wire:model="detalle_problema">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- @if (!in_array($this->servicio_id, [9, 11, 19]) || !in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
                                            <div class="row">                                       
                                                <div class="col-12 col-xl">
                                                    <label for="txtcea" class="fw-bold fs-6">CEA</label>
                                                    <input type="text" id="txtcea" class="form-control form-control-xs text-uppercase" wire:model="cea">
                                                </div>
                                                <div class="col-12 col-xl">
                                                    <label for="txtsgf" class="fw-bold fs-6">N° CARPETA FISCAL</label>
                                                    <input type="text" id="txtsgf" class="form-control form-control-xs text-uppercase" wire:model="sgf">
                                                </div>
                                            </div>
                                        @endif --}}
                                        @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label for="txt_obs_usuario" class="fw-bold fs-6">USUARIO - OBSERVACION</label>
                                                    <input type="text" id="txt_obs_usuario" class="form-control form-control-xs text-uppercase" wire:model="obs_usuario">
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txt_obs_informatico" class="fw-bold fs-6">INFORMÁTICO - RECOMENDACIÓN</label>
                                                    <input type="text" id="txt_obs_informatico" class="form-control form-control-xs text-uppercase" wire:model="obs_informatico">
                                                </div>
                                            </div>
                                        @endif

                                    </fieldset>
                                </div>
                                <div class="col-xl-5">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ATENCIÓN</legend>
                                        <div class="row">
                                            <div class="col-12 col-xl">
                                                <label for="enviadoSi" class="fw-bold fs-6">Enviado a Lima</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="enviadoSi" name="enviadoLima" class="btn-check" value="SI" autocomplete="off" wire:model.live="enviado_lima" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoSi">Si</label>

                                                    <input type="radio" id="enviadoNo" name="enviadoLima" class="btn-check" value="NO" autocomplete="off" wire:model.live="enviado_lima" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoNo">No</label>
                                                </div>
                                            </div>
                                            @if ($enviado_lima === "SI")
                                                <div class="col-12 col-xl">
                                                    <label for="txtglpi" class="fw-bold fs-6">GLPI</label>
                                                    <input type="text" id="txtglpi" class="form-control form-control-xs text-uppercase text-end" wire:model="glpi">
                                                </div>
                                            @endif
                                            <div class="col-12 col-xl">
                                                <label for="atendidoSi" class="fw-bold fs-6">ATENDIDO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="atendidoSi" name="atendido" class="btn-check" value="SI" autocomplete="off" wire:model.live="atendido" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoSi">Sí</label>

                                                    <input type="radio" id="atendidoNo" name="atendido" class="btn-check" value="NO" autocomplete="off" wire:model.live="atendido" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label for="normal" class="fw-bold fs-6">TIEMPO DE ATENCIÓN</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="normal" name="tiempo" class="btn-check" value="NORMAL" autocomplete="off" wire:model.live="tiempo_atencion" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="normal">NORMAL (1 día)</label>

                                                    <input type="radio" id="regular" name="tiempo" class="btn-check" value="REGULAR" autocomplete="off" wire:model.live="tiempo_atencion" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regular">REGULAR (2 a 5 días)</label>

                                                    <input type="radio" id="complejo" name="tiempo" class="btn-check" value="COMPLEJO" autocomplete="off" wire:model.live="tiempo_atencion" required>
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="complejo">COMPLEJO (mayor a 6 días)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-xl">
                                                <label for="txt_sol_res" class="fw-bold fs-6">SOLUCIÓN / RESPUESTA</label>
                                                <input type="text" id="txt_sol_res" class="form-control form-control-xs" wire:model="respuesta">
                                            </div>
                                            @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
                                                <div class="col-12 col-xl">
                                                    <label for="cmb_estado" class="fw-bold fs-6 {{ $mostrarcontroles }}">ESTADO DEL EQUIPO</label>
                                                    <select id="cmb_estado" class="form-select form-select-xs {{ $mostrarcontroles }}" wire:model="estado_bien" required>
                                                        <option value="">Selecionar...</option>
                                                        <option value="OPERATIVO">OPERATIVO</option>
                                                        <option value="INOPERATIVO">INOPERATIVO</option>
                                                        <option value="PENDIENTE">PENDIENTE</option>
                                                    </select>
                                                </div> 
                                            
                                                <div class="col-xl-12">
                                                    <label for="txt_informatico" class="fw-bold fs-6 {{ $mostrarcontroles }}">INFORMÁTICO RESPONSABLE</label>
                                                    <select id="txt_informatico" class="form-select form-select-xs {{ $mostrarcontroles }}" wire:model="informatico_dni" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($lista_informaticos as $item)
                                                            <option value="{{ $item->dni }}">
                                                                {{ $item->dni . ' - ' . $item->datos }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            @endif 
                                            {{-- {{ $informatico_dni }} - {{ $informatico }}          --}}
                                        </div>
                                        @if ($this->detalle_servicio === "REQUISITOS")
                                            <div class="row">
                                                @if ($formato1)
                                                    <div class="col-12 col-xl">
                                                        {{-- <label for="txt_formato1" class="fw-bold fs-6">FORMATOS</label> --}}
                                                        <br>
                                                        <a href="{{ asset('storage/' . $formato1) }}" target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i>01-Formato
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($formato2)
                                                    <div class="col-12 col-xl">
                                                        {{-- <label for="txt_formato2" class="fw-bold fs-6">FORMATOS</label> --}}
                                                        <br>
                                                        <a href="{{ asset('storage/' . $formato2) }}" target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i>02-Formato
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($formato3)
                                                    <div class="col-12 col-xl">
                                                        {{-- <label for="txt_formato2" class="fw-bold fs-6">FORMATOS</label> --}}
                                                        <br>
                                                        <a href="{{ asset('storage/' . $formato3) }}" target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i>03-Formato
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($formato4)
                                                    <div class="col-12 col-xl">
                                                        {{-- <label for="txt_formato2" class="fw-bold fs-6">FORMATOS</label> --}}
                                                        <br>
                                                        <a href="{{ asset('storage/' . $formato4) }}" target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i>04-Formato
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }} y reponder <i class="fa-solid fa-envelope"></i>
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                                <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL FILTRO - REPORTES -->
        <div class="modal fade @if($modalReportesFiltros) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="filtroModalLabel">
                            <i class="fa-solid fa-filter"></i> FILTROS - REPORTE : Total: {{ $lista_activos->total() }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">                      
                            <div class="col-lg-1 col-sm-12">
                                <label for="cmbfiltro_anio" class="fw-bold fs-6">Año</label>
                                <div class="input-group">
                                    {{-- <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span> --}}
                                    <select id="cmbfiltro_anio" wire:model.live="filtro_anio" class="form-select form-select-sm me-2">
                                        <option value="">-- Año --</option>
                                        @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                            <option value="{{ $anio }}">{{ $anio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-12">
                                <label for="txt_sede" class="fw-bold fs-6">Mes</label>
                                <select id="cmbfiltro_mes" wire:model.live="filtro_mes" class="form-select form-select-sm">
                                    <option value="">-- Mes --</option>
                                    @foreach([
                                        1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',
                                        5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',
                                        9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'
                                    ] as $num => $mes)
                                        <option value="{{ $num }}">{{ $mes }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-sm-12">
                                <label for="cmb_filtrosede" class="fw-bold fs-6">Sede</label>
                                <div class="input-group">
                                    {{-- <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="filtrosedeorigen" readonly required> --}}
                                    <select id="cmb_filtrosede" class="form-select form-select-sm" wire:model.live="filtro_sede">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($lista_sedes_filtro as $sede)
                                            <option value="{{ $sede->nombre }}">{{ $sede->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sedeorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12">
                                <label for="cmb_filtrodependencia" class="fw-bold fs-6">Dependencia</label>
                                <div class="input-group position-relative">
                                    {{-- <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="filtrodependenciaorigen" readonly required> --}}
                                    <select id="cmb_filtrodependencia" class="form-select form-select-sm" wire:model.live="filtro_dependencia">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($lista_dependencias_filtro as $dependencia)
                                            <option value="{{ $dependencia->nombre }}">{{ $dependencia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('dependenciaorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-2 col-lg-6 col-sm-12">
                                <label for="cmb_filtroservicio" class="fw-bold fs-6">Servicio</label>
                                <div class="input-group">
                                    {{-- <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="filtrosedeorigen" readonly required> --}}
                                    <select id="cmb_filtroservicio" class="form-select form-select-sm" wire:model.live="filtro_servicio">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($lista_servicios_filtro as $servicio)
                                            <option value="{{ $servicio->servicio }}">{{ $servicio->servicio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sedeorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-12">
                                <label for="cmb_filtroincidencia" class="fw-bold fs-6">Incidencia/Solicitud</label>
                                <div class="input-group position-relative">
                                    {{-- <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="filtrodependenciaorigen" readonly required> --}}
                                    <select id="cmb_filtroincidencia" class="form-select form-select-sm" wire:model.live="filtro_incidencia">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($lista_incidencias_solicitudes_filtro as $incidencia)
                                            <option value="{{ $incidencia->incidencia_solicitud }}">{{ $incidencia->incidencia_solicitud }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('dependenciaorigen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-naranja btn-sm" wire:click="resetFiltros">
                            <i class="fa-solid fa-eraser"></i> Limpiar
                        </button>
                        <button class="btn btn-success btn-sm" wire:click="exportarExcel">
                            <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL BUSCAR SERVICIO --}}
        <div class="modal fade @if($modalInformaticaServicioBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="buscar-servicio-componentLabel">
                            BUSCAR SERVICIO
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="txtSearchServicio" class="form-control form-control-sm mb-2" placeholder="Buscar por incidencia o solicitud" wire:model.live="searchservicios" >
                        <div class="table-responsive small">
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th>#</th>
                                        <th>SERVICIO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_servicios as $item)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $item->servicio }}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_servicio({{ $item->id }})">
                                                            <i class="fa-solid fa-share-from-square"></i> Agregar
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
                            {{ $lista_servicios->links() }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL BUSCAR INCIDENCIAS / SOLICITUDES --}}
        <div class="modal fade @if($modalInformaticaServicioDetalleBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-secondary-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            BUSCAR INCIDENCIAS / SOLICITUDES
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="txtSearchServicioDetalle" class="form-control form-control-sm mb-2" placeholder="Buscar por detalle incidencia o solicitud" wire:model.live="searchincidenciasolicitud">
                        <div class="table-responsive small">
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th>#</th>
                                        <th>Servicio</th>
                                        <th>Incidencia / Solicitud</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_incidencias_solicitudes as $item2)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $item2->servicio }}</td>
                                            <td>{{ $item2->incidencia_solicitud }}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_incidencia_solicitud({{ $item2->id }})">
                                                            <i class="fa-solid fa-share-from-square"></i> Agregar
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
                            {{ $lista_incidencias_solicitudes->links() }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{--MODAL BUSCAR PERSONAL --}}
        @include('livewire.partials.modales.buscar-personal-datos')

        {{-- MODALE BUSCAR SEDES-DEPENDENCIAS-DESPACHOS --}}
        @include('livewire.partials.modales.buscar-personal-sede-dependencia-despacho')
        
        {{-- MODAL BUSCAR CARGO --}}
        @include('livewire.partials.modales.buscar-personal-cargo')

        {{-- MODAL BUSCAR BIENES PATRIMONIALES --}}
        @include('livewire.partials.modales.buscar-patrimonio-bienes')
        
        {{-- MODAL CARGAR PDF --}}
        @include('livewire.partials.modales.cargar-pdf-acta')
        @include('livewire.partials.modales.cargar-pdf-evidencia')
    </div>

</div>
