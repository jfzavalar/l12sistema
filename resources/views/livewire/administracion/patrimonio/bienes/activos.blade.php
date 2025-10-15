<div>
    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-xl-6">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" colspan="3" class="text-center">Registro de bienes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($totales_asignados as $tactivos)
                                <tr class="align-middle" style="font-size: 12px;">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th style="white-space: nowrap;">{{ $tactivos->created_user }}</th>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white" wire:click="setFiltrosAsignados('{{ $tactivos->created_user }}')">
                                                    <i class="fa-solid fa-check me-2"></i>Asignados
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_asignados }}" readonly>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-danger text-white" wire:click="setFiltrosDevueltos('{{ $tactivos->created_user }}')">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Devueltos
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_devueltos }}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-xs">
                                            <input type="text" class="form-control fw-bold text-end" value="{{ $tactivos->total_asignados + $tactivos->total_devueltos }}" readonly>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h5 class="card-title">
                                    Total Bienes
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-chart-simple text-primary"></i> {{ $conteo_rutas->con_ruta + $conteo_rutas->sin_ruta }}</h3>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="$set('filtro_rutas','')">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    Actas Firmadas
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-file-signature text-success"></i> {{ $conteo_rutas->con_ruta }}</h3>
                                    <button class="btn btn-outline-success btn-sm" wire:click="$set('filtro_rutas','con')">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    Actas sin Firmar
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3><i class="fa-solid fa-signature text-danger"></i> {{ $conteo_rutas->sin_ruta }}</h3>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="$set('filtro_rutas','sin')">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searcha" placeholder="Buscar por DNI o Datos del Personal">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><i class="fa-solid fa-user"></i> DNI</th>
                            <th scope="col">DATOS</th>
                            <th scope="col">COD_PATRIMONIAL</th>
                            <th scope="col">BIEN</th>
                            <th scope="col">MARCA</th>
                            <th scope="col">MODELO</th>
                            <th scope="col">SERIE</th>
                            <th scope="col">COLOR</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $activo)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>{{ $activo->cod_usuario }}</th>
                                <td>{{ $activo->desc_usuario }}</td>
                                <td>{{ $activo->cod_pat }}</td>
                                <td>{{ $activo->bien }}</td>
                                <td>{{ $activo->marca }}</td>
                                <td>{{ $activo->modelo }}</td>
                                <td>{{ $activo->serie }}</td>
                                <td>{{ $activo->color }}</td>
                                <td>
                                    @if ($activo->asignacion == "ASIGNACION" || $activo->asignacion == "REASIGNACION")
                                        <span class="badge rounded-pill text-bg-success">{{ $activo->asignacion }}</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">{{ $activo->asignacion }}</span>
                                    @endif
                                </td>
                                <td>
                                    @can('procesos.informatica.tokens.edit')
                                        @if ($activo->asignacion == "ASIGNACION" || $activo->asignacion == "REASIGNACION")
                                            <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="devolver2({{ $activo->id }})">
                                                <i class="fas fa-exchange-alt"></i><br>Devolver
                                            </button>
                                        @endif
                                        @if ($activo->asignacion == "DEVOLUCION")
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="reasignar1({{ $activo->id }})">
                                                <i class="fas fa-exchange-alt"></i><br>Reasignar
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.tokens.edit')
                                                <button type="button" class="btn btn-outline-primary btn-xs" wire:click="editar({{ $activo->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
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
                                            <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial_tokens('{{ $activo->codtoken }}')" >
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
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- Links de paginación --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <strong>Total de registros:</strong> {{ $lista_activos->total() }}
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    {{ $lista_activos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo-Editar-->
    <div class="modal fade @if($modal_abierto_token) show d-block @endif" tabindex="-1">
        {{-- <div class="modal-dialog modal-xl" style="max-width:90%;"> --}}
        <div class="modal-dialog modal-xl" style="max-width:90%;">>
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO - TOKEN
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR - TOKEN
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <fieldset class="border p-3 rounded text-center" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Foto de perfil</legend>
                                    @include('livewire.partials.personal-datos-foto')
                                </fieldset>
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Datos Personales</legend>
                                    @include('livewire.partials.personal-datos-personales')
                                </fieldset>  
                            </div>
                            <div class="col-xl-8 col-sm-12">
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Datos Institucionales</legend>
                                    @include('livewire.partials.personal-datos-institucionales')
                                </fieldset>
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Detalles de firma token</legend>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="txt_fecha_expiracion_token" class="form-label fw-bold fs-6">Fecha Expiración</label>
                                            <input type="date" id="txt_fecha_expiracion_token" class="form-control" wire:model="fecha_expiracion">
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="txt_observacion_token" class="form-label fw-bold fs-6">Observación</label>
                                            <input type="text" id="txt_observacion_token" class="form-control" wire:model="observacion">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i><br>Guardar
                            @else
                                <i class="fa-solid fa-floppy-disk"></i><br>Actualizar
                            @endif    
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-square-xmark"></i><br>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal historial -->
    <div class="modal fade @if($modal_abierto_historial_token) show d-block @endif" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-timeline"></i> HISTORIAL TOKENS
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_historial_tokens"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">DATOS</th>
                                        <th scope="col">SEDE</th>
                                        {{-- <th scope="col">LOCAL</th> --}}
                                        <th scope="col">DEPENDENCIA</th>
                                        {{-- <th scope="col">DESPACHO</th> --}}
                                        <th scope="col">CARGO</th>
                                        <th scope="col">ASIGNACIÓN</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_historial as $historial)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $historial->dni }}</td>
                                            <td>{{ $historial->datos }}</td>
                                            <td>{{ $historial->sede }}</td>
                                            {{-- <td></td> --}}
                                            <td>{{ $historial->dependencia }}</td>
                                            <td>{{ $historial->cargo }}</td>
                                            <td>
                                                @if ($historial->asignacion == "ASIGNACION" || $historial->asignacion == "REASIGNACION")
                                                    <span class="badge rounded-pill text-bg-success">{{ $historial->asignacion }}</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-danger">{{ $historial->asignacion }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <a type="button" href="{{ route('pdf.informatica.token-acta', $historial->id) }}" target="_blank" class="btn btn-outline-dark btn-xs">
                                                            <i class="fa-solid fa-print"></i><br>Acta
                                                        </a>
                                                        {{-- <button type="button" class="btn btn-outline-dark" wire:click="imprimirPDF({{ $historial->id }})">
                                                            <i class="fa-solid fa-print"></i>
                                                        </button> --}}
                                                        @can('procesos.informatica.tokens.edit')
                                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="cargarPDF1({{ $historial->id }})" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                                <i class="fa-solid fa-file-pdf"></i><br>CargarPDF
                                                            </button>
                                                        @endcan
                                                        @if ($historial->actaruta)
                                                            <a href="{{ asset($historial->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-xs">
                                                                <i class="fa-solid fa-file-pdf"></i><br>Firmado
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger" role="alert">
                                            No existen registros
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- Links de paginación --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>Total de registros:</strong> {{ $lista_historial->total() }}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{ $lista_historial->links() }}
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_historial_tokens">
                            <i class="fa-solid fa-door-closed"></i>
                                <br>Cerrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('livewire.partials.personal-modal-buscar')

    @include('livewire.partials.pdf-modal-cargar')

    <!-- Modal historial -->
    <div class="modal fade @if($modal_abierto_pdf_imprimir) show d-block @endif" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                vdfvdfvfdvdf
            </div>
        </div>
    </div>
</div>
