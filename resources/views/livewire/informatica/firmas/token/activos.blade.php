<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-2 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h5 class="card-title">
                                    Total Tokens
                                </h5><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-chart-simple text-primary"></i> {{ $estadisticas->total }}</h3>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="filtrarTotal">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    Actas Firmadas
                                </h5><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-signature text-success"></i> {{ $estadisticas->firmadas }}</h3>
                                    <button class="btn btn-outline-success btn-sm" wire:click="filtrarFirmadas">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    Actas sin Firmar
                                </h5><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-signature text-success"></i> {{ $estadisticas->sin_firmar }}</h3>
                                    <button class="btn btn-outline-success btn-sm" wire:click="filtrarSinFirmar">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    Asignados
                                </h5><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-file-signature text-danger"></i> {{ $estadisticas->asignacion }}</h3>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="filtrarAsignados">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    Devueltos
                                </h5><br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-file-signature text-danger"></i>  {{ $estadisticas->devolucion }}</h3>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="filtrarDevueltos">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-sm-4">

                            <!-- ✅ Verificados -->
                            <div class="alert alert-secondary mb-2" role="alert">
                                <h5 class="card-title">Verificados</h5>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>
                                        <i class="fa-solid fa-file-signature"></i> 
                                        {{ $estadisticas->verificados }}
                                    </h3>

                                    <button class="btn btn-outline-secondary btn-sm" wire:click="filtrarVerificados">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>

                            <!-- ✅ No verificados -->
                            <div class="alert alert-secondary" role="alert">
                                <h5 class="card-title">No Verificados</h5>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>
                                        <i class="fa-solid fa-file-signature"></i> 
                                        {{ $estadisticas->no_verificados }}
                                    </h3>

                                    <button class="btn btn-outline-secondary btn-sm" wire:click="filtrarNoVerificados">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive small">               
                <div class="row">
                    {{-- <div class="col-lg-1 col-sm-12">
                        <label class="btn btn-outline-primary btn-sm me-2">Total: {{ $lista_activos->total() }}</label>
                    </div> --}}
                    <div class="col-lg-12 col-sm-12">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Datos del Personal">
                            @can('procesos.informatica.firmasdigitales.index')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                            <button class="btn btn-naranja" wire:click="exportarPDF">
                                <i class="fa fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text fw-bold" id="basic-addon1">Filtrar por:</span>
                            <select name="cmbfiltroAsignacion" id="cmbfiltroAsignacion" class="form-select form-select-sm" wire:model.live="filtroasignacion">
                                <option value="">TOTAL</option>
                                <option value="ASIGNACION">ASIGNACION</option>
                                <option value="DEVOLUCION">DEVOLUCION</option>
                            </select>
                        </div>
                    </div>
                </div>                    --}}
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><i class="fa-solid fa-user"></i> DNI - DATOS</th>
                            <th scope="col">SEDE <br> DEPENDENCIA</th>
                            <th scope="col">VERIFICAR</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">CODTOKEN</th>
                            <th scope="col">EXPIRACION</th>
                            <th scope="col">ASIGNACIÓN</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>
                                    {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                <td>
                                    <b>SEDE: {{ $item->sedeorigen }}</b>
                                    <br>
                                    {{ $item->dependenciaorigen }}
                                </td>
                                <td>
                                    <button 
                                        wire:click="verificarfirmatoken({{ $item->id }})"
                                        class="btn {{ $item->verificar == '1' ? 'btn-success' : 'btn-danger' }} btn-sm rounded-circle">
                                        {{ $item->verificar == '1' ? 'OK' : 'X' }}
                                    </button>
                                </td>
                                <td>{{ $item->cargo }}</td>
                                <td>{{ $item->token_codigo }}</td>
                                <td>{{ $item->fecha_expiracion }}</td>
                                <td>
                                    @if ($item->asignacion == "ASIGNACION" || $item->asignacion == "REASIGNACION")
                                        <span class="badge rounded-pill text-bg-success">{{ $item->asignacion }}</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">{{ $item->asignacion }}</span>
                                    @endif
                                </td>
                                <td>
                                    @can('procesos.informatica.tokens.edit')
                                        @if ($item->asignacion == "ASIGNACION" || $item->asignacion == "REASIGNACION")
                                            <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="nuevo_devolucion({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                <i class="fas fa-exchange-alt"></i><br>Devolver
                                            </button>
                                        @endif
                                        @if ($item->asignacion == "DEVOLUCION")
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="nuevo_reasignacion({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                <i class="fas fa-exchange-alt"></i><br>Reasignar
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.tokens.edit')
                                                <button type="button" class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                </button>
                                            @endcan
                                            {{-- <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                                <i class="fa-solid fa-eye"></i> Ver
                                            </button> --}}
                                            {{-- <a type="button" href="{{ route('pdf.informatica.token-acta', $activo->id) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                                <i class="fa-solid fa-print"></i> Acta
                                            </a> --}}
                                            {{-- <button type="button" class="btn btn-outline-dark btn-sm" wire:click="exportarPDF({{ $activo->id }})">
                                                <i class="fa-solid fa-file-arrow-down"></i> DescargarPDF
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-outline-success btn-sm" wire:click="cargarPDF1({{ $activo->id }})" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                <i class="fa-solid fa-file-pdf"></i> CargarPDF
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                <i class="fa-solid fa-file-pdf"></i> Firmado
                                            </button> --}}
                                            <button type="button" class="btn btn-outline-info btn-xs" data-bs-toggle="modal" data-bs-target="#historial-componentModal" wire:click="historial_tokens('{{ $item->token_id }}')">
                                                <i class="fa-solid fa-timeline"></i><br>Historial
                                            </button>     
                                            {{-- @can('procesos.informatica.tokens.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $activo->id }})">
                                                    <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                </button>
                                            @endcan --}}
                                        </div>
                                    </div>       
                                </td>
                                {{-- <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">                                        
                                            @if ($activo->actaruta)
                                                <a href="{{ asset($activo->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-xs">
                                                    <i class="fa-solid fa-file-pdf"></i><br>Firmado
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td> --}}
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
                            <td colspan="9">
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
                <strong>Total de registros:</strong> {{ $lista_activos->total() }}
            </div>
            <div class="d-inline-block">
                {{ $lista_activos->links() }}
            </div>
        </div>
    </div> --}}
    {{-- <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div> --}}

    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width:90%;">>
            <div class="modal-content">
                <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar" data-bs-dismiss="modal"></button>
                    </div>
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
                                            {{-- <div class="col">
                                                <input type="text" class="form-control form-control-xs" wire:model="sededestino" disabled>                                      
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-xs" wire:model="dependenciadestino" disabled>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-xs" wire:model="despachodestino" disabled>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ASIGNACIÓN / DEVOLUCIÓN DE TOKEN</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_token_codigo" class="fw-bold fs-6">Token</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-token-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txt_token_codigo" class="form-control form-control-xs bg-light" wire:model="token_codigo" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_equipo" class="fw-bold fs-6">Equipo</label>
                                            <div class="input-group">
                                                <input type="text" id="txt_equipo" class="form-control form-control-xs bg-light" wire:model="equipo" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_modelo" class="fw-bold fs-6">Modelo</label>
                                            <div class="input-group">
                                                <input type="text" id="txt_modelo" class="form-control form-control-xs bg-light" wire:model="modelo" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_operativo" class="fw-bold fs-6">Operativo</label>
                                            <div class="input-group">
                                                <input type="text" id="txt_operativo" class="form-control form-control-xs bg-light" wire:model="operativo" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="txt_fecha_expiracion_token" class="form-label fw-bold fs-6">Fecha Expiración</label>
                                            <input type="date" id="txt_fecha_expiracion_token" class="form-control form-control-sm" wire:model="fecha_expiracion">
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <label for="txt_observacion_token" class="form-label fw-bold fs-6">Observación</label>
                                            <input type="text" id="txt_observacion_token" class="form-control form-control-sm" wire:model="observacion">
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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar" data-bs-dismiss="modal">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal buscar personal -->
    <div wire:ignore.self class="modal fade" id="buscar-token-component" tabindex="-1" aria-labelledby="buscar-token-componentLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-5">
                <form action="">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="buscar-token-componentLabel">
                            <i class="fa-solid fa-magnifying-glass"></i> BUSCAR TOKEN
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-2">
                                            <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar token" wire:model.live="searchtokens">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">CODIGO</th>
                                        <th scope="col">EQUIPO</th>
                                        <th scope="col">MODELO</th>
                                        <th scope="col">OPERATIVO</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_bienes_tokens as $token)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $token->codigo }}</th>
                                            <td>{{ $token->equipo }}</td>
                                            <td>{{ $token->modelo }}</td>
                                            <td>{{ $token->operativo }}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_token({{ $token->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                            <i class="fa-solid fa-circle-plus"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            {{ $lista_bienes_tokens->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                       
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_token" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                            <i class="fa-solid fa-door-closed"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Historial --}}
    <div wire:ignore.self class="modal fade" id="historial-componentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="historial-componentModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="historial-componentModalLabel">
                        <i class="fa-solid fa-timeline"></i> HISTORIAL ASIGNACIÓN / DEVOLUCIÓN DE TOKENS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchhistorial" placeholder="Buscar por dni o apellidos y nombres">
                            {{-- <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                                <i class="fa-regular fa-file-pdf"></i> PDF
                            </a> --}}
                        </div>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><i class="fa-solid fa-user"></i> DNI - DATOS</th>
                                    <th scope="col">SEDE <br> DEPENDENCIA</th>
                                    <th scope="col">CARGO</th>
                                    <th scope="col">CODTOKEN</th>
                                    <th scope="col">EXPIRACION</th>
                                    <th scope="col">ASIGNACIÓN</th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_historial as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <th>
                                            {{ $item->dni }}
                                            <br>
                                            {{ $item->datos }}
                                        </th>
                                        <td>
                                            <b>SEDE: {{ $item->sedeorigen }}</b>
                                            <br>
                                            {{ $item->dependenciaorigen }}
                                        </td>
                                        <td>{{ $item->cargo }}</td>
                                        <td>{{ $item->token_codigo }}</td>
                                        <td>{{ $item->fecha_expiracion }}</td>
                                        <td>
                                            @if ($item->asignacion == "ASIGNACION" || $item->asignacion == "REASIGNACION")
                                                <span class="badge rounded-pill text-bg-success">{{ $item->asignacion }}</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-danger">{{ $item->asignacion }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <a type="button" href="{{ route('pdf.informatica.token-acta', $item->id) }}" target="_blank" class="btn btn-outline-dark btn-xs">
                                                        <i class="fa-solid fa-print"></i><br>Acta
                                                    </a>
                                                    {{-- <button type="button" class="btn btn-outline-dark" wire:click="imprimirPDF({{ $historial->id }})">
                                                        <i class="fa-solid fa-print"></i>
                                                    </button> --}}
                                                    @can('procesos.informatica.tokens.edit')
                                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item->id }})">
                                                            <i class="fa-solid fa-upload"></i><br>Cargar
                                                        </button>
                                                    @endcan
                                                    @if ($item->ruta_documento)
                                                        <a href="{{ asset($item->ruta_documento) }}" target="_blank" class="btn btn-outline-info btn-xs">
                                                            <i class="fa-solid fa-file-pdf"></i><br>Firmado
                                                        </a>
                                                    @endif
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
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        {{ $lista_historial->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    @include('livewire.informatica.firmas.partials.pdf-cargar-component')

    @include('livewire.rrhh.personal.partials.buscar-personal-component')

</div>
