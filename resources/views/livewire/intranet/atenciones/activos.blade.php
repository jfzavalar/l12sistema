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
                <div class="col-xl-5 col-gl-6 col-sm-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Informatica</th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE")
                                    <tr class="align-middle" style="font-size: 12px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-danger text-white">
                                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendientes
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->no_atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-envelope"></i> Lima
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->enviado_lima }}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
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
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "TERCERO")
                                    <tr class="align-middle" style="font-size: 12px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-file-pdf"></i>Folios
                                                    </button>
                                                    <label class="form-control form-control-xs">{{ $item->digitalizado }}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="col-xl-3 col-gl-6 col-sm-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h6 class="card-title">
                                    Total
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-chart-simple text-primary"></i>{{ $estadisticas2->total }}</h5>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="filtrarTotal">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-info" role="alert">
                                <h6 class="card-title">
                                    Lima
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> {{ $estadisticas2->enviado_lima }}</h5>
                                    <button class="btn btn-outline-info btn-sm" wire:click="filtrarEnviadolima">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h6 class="card-title">
                                    Atendido
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> {{ $estadisticas2->atendidos }}</h5>
                                    <button class="btn btn-outline-success btn-sm" wire:click="filtrarAtendido">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h6 class="card-title">
                                    Pendientes
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> {{ $estadisticas2->no_atendidos }}</h5>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="filtrarNoatendido">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive-xl">
                {{-- <div class="input-group mb-3"> --}}
                    <div class="row g-3">
                        {{-- <div class="col-lg-2 col-sm-12">
                            <label class="btn btn-outline-primary btn-sm me-2">Total: {{ $lista_activos->total() }}</label>
                        </div> --}}                      
                        <div class="col-lg-2 col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                <select wire:model="filtro_anio" class="form-select form-select-sm me-2">
                                    <option value="">-- Año --</option>
                                    @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                        <option value="{{ $anio }}">{{ $anio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-12">
                            <select wire:model.live="filtro_mes" class="form-select form-select-sm me-2">
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

                        <div class="col-lg-8 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm" placeholder="Buscar por DNI o Datos del Personal" wire:model.live="search">
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
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col">DEPENDENCIA ORIGEN</th>
                            <th scope="col">REGIMEN - CARGO</th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col" class="bg-success-subtle">DESCRIPCIÓN DEL SERVICIO</th>
                            <th scope="col" class="bg-success-subtle">MEDIO</th>
                            <th scope="col" class="bg-success-subtle">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" colspan="2" class="table-darck"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-ticket"></i> {{ $loop->iteration }}
                                </th>
                                <td><b>{{ $item->dni }}</b> <br> {{ $item->datos }}</td>
                                <td>
                                    <b>SEDE: </b>{{ $item->sedeorigen }}
                                    <br>
                                    <b>DEPENDENCIA: </b>{{ $item->dependenciaorigen }}
                                    <br>
                                    <b>DESPACHO: </b>{{ $item->despachoorigen }}
                                </td>
                                <td>
                                    <b>{{ $item->regimen }}</b>
                                    <br>
                                    {{ $item->cargo }}
                                </td>
                                <td>
                                    <b>SEDE: </b>{{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO: </b>{{ $item->despachodestino }}
                                </td>
                                <td>
                                    <b>TIPO: </b>{{ $item->solicitud_incidencia }}
                                    <br>
                                    <b>SERVICIO: </b> {{ $item->servicio }}
                                    <br>
                                    <b>DESCRIPCIÓN: </b>{{ $item->detalle_servicio }}
                                </td>
                                <td>{{ $item->reportado_por }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $item->atendido === 'SI' ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ $item->atendido === 'SI' ? 'Atendido' : 'No atendido' }}
                                    </span>
                                </td>
                                <td>{{ $item->atendido_por_datos}}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @if ($item->utencioncreado === auth()->user()->datos)
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->personalatencion_id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button> 
                                        @endif
                                        @can('mpfn.intranet.atenciones.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.atencion-acta', $item->personalatencion_id) }}" target="_blank">
                                                <i class="fa-solid fa-file-pdf"></i><br>Acta
                                            </a>
                                            @if ($item->utencioncreado === auth()->user()->datos)
                                                <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item->personalatencion_id }})">
                                                    <i class="fa-solid fa-upload"></i><br>Cargar
                                                </button>
                                            @endif
                                            @if($item->ruta_documento)
                                                <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                    <i class="fa-solid fa-file-signature"></i><br> Firmado
                                                </a>
                                            @endif
                                        </div>
                                    </td>
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
                                {{ $lista_historial->links() }}
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
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs me-2"
                                            data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
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
                                                {{-- @if ($dni)
                                                    <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#transferencia-personal-component" wire:click="nuevo_transferir_personal({{ $persona_id }})">
                                                        <i class="fa-solid fa-people-arrows"></i> Cambiar Ubicación
                                                    </button>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- REGISTRO DE TICKES --}}
                        <div class="row">
                            <div class="col-xl-7">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLE DE LA INCIDENCIA/SOLICITUD</legend>
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label for="cmb_reportado" class="fw-bold fs-6">REPORTADO POR</label>
                                            <select id="cmb_reportado" class="form-select form-select-xs" wire:model="reportado_por" read required>
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
                                        <div class="col-xl-3">
                                            <label for="txtservicio" class="fw-bold fs-6">SERVICIO</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-servicio-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtservicio" class="form-control form-control-xs bg-light" wire:model="servicio" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <label for="txtdetalle_servicio" class="fw-bold fs-6">SOLICITUD / INCIDENCIA</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-inicidencia-solicitud-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtdetalle_servicio" class="form-control form-control-xs bg-light" wire:model="detalle_servicio" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="tipoi" class="fw-bold fs-6">TIPO</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="tipoi" name="solicitud_incidencia" class="btn-check" value="INCIDENCIA" autocomplete="off" wire:model.live="solicitud_incidencia">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipoi">INCIDENCIA</label>

                                                <input type="radio" id="tipos" name="solicitud_incidencia" class="btn-check" value="SOLICITUD" autocomplete="off" wire:model.live="solicitud_incidencia">
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="tipos">SOLICITUD</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label for="txtcod" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs {{ $mostrarcontroles }}"
                                                    data-bs-toggle="modal" data-bs-target="#buscar-bienes-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtcodpatrimonial" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD_PATRIMONIAL</label>
                                            <div class="input-group">
                                                {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Cod. Patrimonial</span> --}}
                                                <input type="text" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod_patrimonial" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="txtequipo" class="fw-bold fs-6 {{ $mostrarcontroles }}">PC / LAPTOP</label>
                                            <div class="input-group">
                                                {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Bien</span> --}}
                                                <input type="text" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="datos_bien" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtip" class="fw-bold fs-6 {{ $mostrarcontroles }}">IP</label>
                                            <input type="text" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="bien_ip"  readonly>
                                        </div>
                                    </div>
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
                                            <label class="fw-bold fs-6">Enviado a Lima</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="enviadoSi" name="enviadoLima" class="btn-check" value="SI" autocomplete="off" wire:model.live="enviado_lima" required>
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoSi">Si</label>

                                                <input type="radio" id="enviadoNo" name="enviadoLima" class="btn-check" value="NO" autocomplete="off" wire:model.live="enviado_lima" required>
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="enviadoNo">No</label>
                                            </div>
                                        </div>
                                        @if ($enviado_lima === "SI")
                                            <div class="col-12 col-xl">
                                                <label for="txtglpi" class="fw-bold fs-6 {{ $mostrarcontrolgpli }}">GLPI</label>
                                                <input type="text" id="txtglpi" class="form-control form-control-xs text-uppercase {{ $mostrarcontrolgpli }}" wire:model=glpi>
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
                                    @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA", "SERVIDORES"]))
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
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ATENCIÓN</legend>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <label class="fw-bold fs-6">ATENDIDO</label>
                                            <div class="d-flex gap-2">
                                                <input type="radio" id="atendidoSi" name="atendido" class="btn-check" value="SI" autocomplete="off" wire:model.live="atendido" required>
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoSi">Sí</label>

                                                <input type="radio" id="atendidoNo" name="atendido" class="btn-check" value="NO" autocomplete="off" wire:model.live="atendido" required>
                                                <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="atendidoNo">No</label>
                                            </div>
                                        </div>
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
                                            <input type="text" id="txt_sol_res" class="form-control form-control-xs text-uppercase" wire:model="respuesta">
                                        </div>
                                        @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA", "SERVIDORES"]))
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
                                                <select id="txt_informatico" class="form-select form-select-xs {{ $mostrarcontroles }}" wire:model="informatico" required>
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_informaticos as $item)
                                                        <option value='@json(["dni"=>$item->dni,"datos"=>$item->datos])'>
                                                            {{ $item->datos }}
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

    {{-- Modal bienes patrimoniales --}}
    @include('livewire.patrimonio.bienes.partials.buscar-bienes-component')
    


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
    

    @include('livewire.intranet.atenciones.partials.pdf-cargar-component')
    @include('livewire.rrhh.personal.partials.buscar-personal-component')

</div>
