<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    {{-- <div class="col-lg-1 col-sm-12">
                        <div class="input-group">
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#filtroModal">
                                <i class="fa-solid fa-filter"></i> Más Filtros:
                            </button>
                        </div>
                    </div> --}}

                    <div class="col-xl-9">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                        </div>
                    </div>
                    <div class="col-xl-3 text-end">
                        @can('mpfn.rrhh.personal.create')
                            <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button>
                        @endcan
                        @can('mpfn.rrhh.personal.edit')
                            <button type="button" id="btnnuevo" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#licenciasModal">
                                <i class="fa-solid fa-ban"></i> Licencias
                            </button>
                            <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                                <i class="fa-solid fa-ban"></i> Renuncias
                            </button>
                        @endcan
                        <button class="btn btn-success btn-sm" wire:click="exportarExcel">
                            <i class="fa fa-file-pdf"></i> Excel
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold bg-danger-subtle text-danger" id="basic-addon1">Filtrar por sede:</span>
                            <select id="filtrosede2" class="form-select form-select-sm" wire:model.live="filtrosede">
                                <option value="">TOTAL </option>
                                @foreach ($lista_sedes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold bg-danger-subtle text-danger" id="basic-addon1">Por dependencia:</span>
                            <select id="filtrodependencia2" class="form-select form-select-sm" wire:model.live="filtrodependencia">
                                <option value="">TOTAL </option>
                                @foreach ($lista_dependencias as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon1">Por régimen:</span>
                            <select id="filtroregimen2" class="form-select form-select-sm" wire:model.live="filtroregimen">
                                <option value="">TOTAL </option>
                                <option value="CAS">CAS </option>
                                <option value="D.L.276">D.L.276</option>
                                <option value="D.L.728">D.L.728 </option>
                            </select>
                            {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon1">Por cargo:</span>
                            <select id="filtrocargo2" class="form-select form-select-sm" wire:model.live="filtrocargo">
                                <option value="">TOTAL </option>
                                <option value="CONTRATO">CONTRATO </option>
                                @foreach ($lista_cargos2 as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
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
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" colspan="2" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>SEDE:</b> {{ $item->sedeorigen }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                </td>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>REGIMEN:</b> {{ $item->regimen }}
                                    <br>
                                    <b>CARGO:</b> {{ $item->cargo }}
                                </td>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>SEDE:</b> {{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachodestino }}
                                    <br>
                                    {{-- <b>De:</b>
                                    <b>Hasta:</b> --}}
                                </td>
                                <td class="text-nowrap">
                                    <b>Email personal:</b> {{ $item->correopersonal }}:
                                    <br><b>Cel. personal:</b> {{ $item->celpersonal }}
                                    <br><b>Email institucional:</b> {{ $item->correoinstitucional }}
                                    <br><b>Cel. institucional:</b> {{ $item->celinstitucional }}
                                </td>
                                <td class="text-center">
                                    <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                        @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                            text-bg-danger
                                        @endif">
                                        {{ $item->tipo_documento }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @can('mpfn.rrhh.personal.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        @can('mpfn.rrhh.personal.create')
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                </button>

                                                <ul class="dropdown-menu">

                                                    @if ($item->tipo_documento === "CONTRATO")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_adenda({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Adenda
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Licencia
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li>                                                       

                                                    @elseif($item->tipo_documento === "LICENCIA")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_contrato({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Contrato
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Incorporación
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li>

                                                    @elseif($item->tipo_documento === "ADENDA")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_adenda({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Adenda
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Licencia
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li> 

                                                    @else

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_contrato({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Contrato
                                                            </button>
                                                        </li>

                                                    @endif

                                                </ul>
                                            </div>
                                        @endcan
                                        <button type="button" class="btn btn-outline-info btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i><br>Ver
                                        </button> --}}
                                        @can('mpfn.rrhh.personal.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-dark btn-xs" wire:click="legajos1('{{ $item->dni }}','{{ $item->datos }}')">
                                            <i class="fa-solid fa-file-zipper"></i>Legajos
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">{{ $lista_activos->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div>

        {{-- Modal Nuevo-Editar --}}
        <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
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

        <!-- MODAL FILTRO - REPORTES -->
        <div wire:ignore.self class="modal fade" id="filtroModal" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="filtroModalLabel">
                            <i class="fa-solid fa-filter"></i> FILTROS - REPORTE : Total: {{ $lista_activos->total() }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Filtrar por sede:</span>
                                    <select id="filtrosede" class="form-select form-select-sm" wire:model.live="filtrosede">
                                        <option value="">TOTAL </option>
                                        @foreach ($lista_sedes as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Por dependencia:</span>
                                    <select id="filtrodependencia" class="form-select form-select-sm" wire:model.live="filtrodependencia">
                                        <option value="">TOTAL </option>
                                        @foreach ($lista_dependencias as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Por régimen:</span>
                                    <select id="filtroregimen" class="form-select form-select-sm" wire:model.live="filtroregimen">
                                        <option value="">TOTAL </option>
                                        <option value="CAS">CAS </option>
                                        <option value="D.L.276">D.L.276</option>
                                        <option value="D.L.728">D.L.728 </option>
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Por cargo:</span>
                                    <select id="filtrocargo" class="form-select form-select-sm" wire:model.live="filtrocargo">
                                        <option value="">TOTAL </option>
                                        <option value="CONTRATO">CONTRATO </option>
                                        @foreach ($lista_cargos2 as $item)
                                            <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-naranja btn-sm" wire:click="resetFiltros">
                            <i class="fa-solid fa-eraser"></i> Limpiar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Inactivos --}}
        <div wire:ignore.self class="modal fade" id="inactivosModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="inactivosModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-dark-subtle">
                        <h1 class="modal-title fs-5" id="inactivosModalLabel">
                            <i class="fa-solid fa-trash"></i> RENUNCIAS
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input id="searchrenuncias" type="text" class="form-control form-control-sm" wire:model.live="searchrenuncias" placeholder="Buscar">
                            </div>
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
                                        <th scope="col">CONDICIÓN</th>
                                        <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
                                        {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_inactivos as $item)
                                        <tr>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                DNI: {{ $item->dni }}
                                                <br>
                                                {{ $item->datos }}
                                            </th>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>REGIMEN:</b> {{ $item->regimen }}
                                                <br>
                                                <b>CARGO:</b> {{ $item->cargo }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachodestino }}
                                                <br>
                                                <b>De:</b>
                                                <b>Hasta:</b>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge 
                                                    @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) 
                                                        text-bg-primary
                                                    @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                                        text-bg-danger
                                                    @endif">
                                                    {{ $item->tipo_documento }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.edit')
                                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                        </button>
                                                    @endcan
                                                    @can('mpfn.rrhh.personal.create')
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                                    type="button" 
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false">
                                                                <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                @if ($item->tipo_documento === "CONTRATO")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>                                                       

                                                                @elseif($item->tipo_documento === "LICENCIA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Incorporación
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>

                                                                @elseif($item->tipo_documento === "ADENDA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li> 

                                                                @else

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                @endif

                                                            </ul>
                                                        </div>
                                                    @endcan
                                                    <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-eye"></i><br>Ver
                                                    </button> --}}
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">{{ $lista_inactivos->links() }}</td>
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

        {{-- Modal Licencias --}}
        <div wire:ignore.self class="modal fade" id="licenciasModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="licenciasModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-danger-subtle">
                        <h1 class="modal-title fs-5" id="licenciasModalLabel">
                            <i class="fa-solid fa-trash"></i> LICENCIAS
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchlicencias" placeholder="Buscar">
                            </div>
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
                                        <th scope="col">CONDICIÓN</th>
                                        <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
                                        {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_licencias as $item)
                                        <tr>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                DNI: {{ $item->dni }}
                                                <br>
                                                {{ $item->datos }}
                                            </th>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>REGIMEN:</b> {{ $item->regimen }}
                                                <br>
                                                <b>CARGO:</b> {{ $item->cargo }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachodestino }}
                                                <br>
                                                <b>De:</b>
                                                <b>Hasta:</b>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                                    @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                                        text-bg-danger
                                                    @endif">
                                                    {{ $item->tipo_documento }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.edit')
                                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                        </button>
                                                    @endcan
                                                    @can('mpfn.rrhh.personal.create')
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                                    type="button" 
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false">
                                                                <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                @if ($item->tipo_documento === "CONTRATO")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>                                                       

                                                                @elseif($item->tipo_documento === "LICENCIA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Incorporación
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>

                                                                @elseif($item->tipo_documento === "ADENDA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li> 

                                                                @else

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#nuevoEditarModal"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                @endif

                                                            </ul>
                                                        </div>
                                                    @endcan
                                                    <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-eye"></i><br>Ver
                                                    </button> --}}
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">{{ $lista_licencias->links() }}</td>
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

        {{-- Modal Historial --}}
        <div wire:ignore.self class="modal fade" id="historialModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="historialModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="historialModalLabel">
                            <i class="fa-solid fa-timeline"></i> HISTORIAL CONTRATOS / ADENDAS / RENUNCIAS
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchhistorial" class="form-control form-control-sm" wire:model.live="searchhistorial" placeholder="Buscar por número de convocatoria">
                                <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                                    <i class="fa-regular fa-file-pdf"></i> PDF
                                </a>
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> PERSONAL
                                        </th>
                                        <th scope="col">DEPENDENCIA ORIGEN</th>
                                        <th scope="col">UBICACIÓN FÍSICA</th>
                                        <th scope="col">REGIMEN</th>
                                        <th scope="col">CARGO</th>
                                        <th scope="col">N° DE CONVOCATORIA</th>
                                        <th scope="col">DATOS</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_historial as $item3)
                                        <tr>
                                            <th class="text-center">{{ $loop->iteration }}</th>
                                            <th>
                                                {{ $item3->dni }}
                                                <br>{{ $item3->datos }}
                                            </th>
                                            <td>
                                                <b>SEDE:</b> {{ $item3->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item3->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item3->despachoorigen }}
                                            </td>
                                            <td>
                                                <b>SEDE:</b> {{ $item3->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item3->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item3->despachodestino }}
                                            </td>
                                            <td>{{ $item3->regimen }}</td>
                                            <td>{{ $item3->cargo }}</td>
                                            <td>{{ $item3->numero_convocatoria }}</td>
                                        
                                            <td class="@if(in_array($item3->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-primary
                                                        @elseif(in_array($item3->tipo_documento, ['LICENCIA','RENUNCIA'])) text-danger
                                                        @endif">
                                                {{ $item3->tipo_documento }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($item3->fecha_fin)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.edit')
                                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item3->personal_id }})">
                                                            <i class="fa-solid fa-upload"></i><br>Cargar
                                                        </button>
                                                    @endcan
                                                    
                                                    @if($item3->ruta_documento)
                                                        <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item3->ruta_documento) }}" target="_blank">
                                                            <i class="fa-solid fa-file-signature"></i><br> Firmado
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
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

        

        <!-- Modal Detalles de persona personal -->
        <div wire:ignore.self class="modal fade" id="verDetallesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="verDetallesModalLabel"><i class="fa-solid fa-file-lines"></i> DETALLE: PERSONA - PERSONAL</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div>
                            <div class="col-xl-9 col-sm-12">
                                <fieldset class="border p-3 rounded mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                    @include('livewire.rrhh.personal.partials.datos-personales-component')
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <fieldset class="border p-3 rounded mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                    @include('livewire.rrhh.personal.partials.datos-institucionales-component')
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS CONTRATO / ADENDA / RENUNCIA</legend>
                                    <table class="table table-striped table-hover table-sm table-xsmall">
                                        <thead class="table-dark text-center align-middle">
                                            <tr>
                                                <th scope="col">#</th>
                                                {{-- <th scope="col">
                                                    <i class="fa-solid fa-user"></i> PERSONAL
                                                </th> --}}
                                                <th scope="col">DEPENDENCIA ORIGEN</th>
                                                {{-- <th scope="col">UBICACIÓN FÍSICA</th> --}}
                                                <th scope="col">REGIMEN</th>
                                                <th scope="col">CARGO</th>
                                                <th scope="col">N° DE CONVOCATORIA</th>
                                                <th scope="col">DATOS</th>
                                                {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                            @forelse ($lista_historial as $item3)
                                                <tr>
                                                    <th class="text-center">{{ $loop->iteration }}</th>
                                                    {{-- <th>
                                                        {{ $item3->dni }}
                                                        <br>{{ $item3->datos }}
                                                    </th> --}}
                                                    <td>
                                                        <b>SEDE:</b> {{ $item3->sedeorigen }}
                                                        <br>
                                                        <b>DEPENDENCIA:</b> {{ $item3->dependenciaorigen }}
                                                        <br>
                                                        <b>DESPACHO:</b> {{ $item3->despachoorigen }}
                                                    </td>
                                                    {{-- <td>
                                                        <b>SEDE:</b> {{ $item3->sededestino }}
                                                        <br>
                                                        <b>DEPENDENCIA:</b> {{ $item3->dependenciadestino }}
                                                        <br>
                                                        <b>DESPACHO:</b> {{ $item3->despachodestino }}
                                                    </td> --}}
                                                    <td>{{ $item3->regimen }}</td>
                                                    <td>{{ $item3->cargo }}</td>
                                                    <td>{{ $item3->numero_convocatoria }}</td>
                                                    <td class="@if($item3->tipo_documento == 'CONTRATO') text-success
                                                                @elseif($item3->tipo_documento == 'LICENCIA') text-danger
                                                                @elseif($item3->tipo_documento == 'RENUNCIA') text-danger
                                                                @elseif($item3->tipo_documento == 'ADENDA') text-primary
                                                                @endif">
                                                        {{ $item3->tipo_documento }}
                                                        <br>
                                                        {{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($item3->fecha_fin)->format('d/m/Y') }}
                                                    </td>
                                                    {{-- <td class="text-end">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item3->personal_id }})">
                                                                <i class="fa-solid fa-upload"></i><br>Cargar
                                                            </button>
                                                            @if($item3->ruta_documento)
                                                                <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item3->ruta_documento) }}" target="_blank">
                                                                    <i class="fa-solid fa-file-signature"></i><br> Ver-Firmado
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        <div class="alert alert-danger" role="alert">
                                                            ¡No se encontraron resultados!
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-naranja btn-sm">
                            <i class="fa-regular fa-file-pdf"></i> PDF
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Transferencia de Personal - Ubicación Física --}}
        {{-- <div wire:ignore.self class="modal fade" id="transferencia-personal-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="transferir-Personal-componentLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="transferir-Personal-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> {{ $textoHeaderModal }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click = "cerrar_transferir_personal"></button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS DE UBICACIÓN FÍSICA / TRANSFERENCIA</legend>
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12">
                                        @include('livewire.rrhh.personal.partials.sede-dependencia-despacho-component')
                                    </div>
                                    <div class="col-xl-12 col-sm-12 mb-3">
                                        @include('livewire.rrhh.personal.partials.datos-personales-transferencia-ubicacion-component')
                                    </div>                              
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click = "cerrar_transferir_personal">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <!-- Modal Historial - Traslado - Ubicación Física -->

        {{-- <div wire:ignore.self class="modal fade" id="transferencia-personal-historial-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="transferir-Personal-Historial-componentLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="transferir-Personal-Historial-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> {{ $textoHeaderModal }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click = "cerrar_transferir_personal"></button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS DE UBICACIÓN FÍSICA</legend>
                                @include('livewire.rrhh.personal.partials.sede-dependencia-despacho-component')
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click = "cerrar_transferir_personal">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        {{-- MODAL LEGAJOS --}}
        <div class="modal fade @if($modalLegajos) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> LEGAJOS: {{ $datos }}
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="legajos_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text fw-bold" id="basic-addon2">Total: </span>
                                        <input type="text" id="txtsearchusuario2" class="form-control form-control-sm" wire:model.live="searchhistoriallegajos" placeholder="Buscar por DNI, Apellidos y Nombres o Anexo">
                                        @can('mpfn.rrhh.personal.legajos.create',)
                                            <button type="button" class="btn btn-primary btn-sm" wire:click="nuevo_pdf">
                                                <i class="fa-solid fa-file"></i> Nuevo
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> DNI - PERSONAL
                                        </th>
                                        <th scope="col">REGIMEN - CARGO</th>
                                        {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                                        <th scope="col">DEPENDENCIA</th>
                                        <th scope="col" class="table-success">MOTIVO</th>
                                        <th scope="col" class="table-success">TITULO DOCUMENTO</th>
                                        <th scope="col" class="table-success">FECHA</th>
                                        <th scope="col" class="table-dark" colspan="1" ><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_legajos as $item)
                                        <tr>
                                            <th>
                                                <i class="fa-solid fa-phone-volume me-1"></i>{{ $loop->iteration }}
                                            </th>
                                            <td>
                                                <b>{{ $item->dni }}</b>
                                                <br> {{ $item->datos }}
                                                <br>{{ $item->created_at }}
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
                                                {{ $item->motivo }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->titulodocumento }}
                                            </td>
                                            <td>{{ $item->fechaemision }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    {{-- <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button> --}}
                                                    @if($item->ruta_legajo)
                                                        <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_legajo) }}" target="_blank">
                                                            <i class="fa-solid fa-eye"></i><br> Documento
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        {{-- <td colspan="8">{{ $lista_activos->links() }}</td> --}}
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="legajos_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @include('livewire.rrhh.personal.partials.buscar-personal-component')
        @include('livewire.rrhh.personal.partials.buscar-sedes-component')
        @include('livewire.rrhh.personal.partials.buscar-dependencias-component')
        @include('livewire.rrhh.personal.partials.buscar-despachos-component')
        @include('livewire.rrhh.personal.partials.buscar-cargos-component')

        {{-- @include('livewire.rrhh.personal.partials.2buscar-sedes-component')
        @include('livewire.rrhh.personal.partials.2buscar-dependencias-component')
        @include('livewire.rrhh.personal.partials.2buscar-despachos-component') --}}

        @include('livewire.rrhh.contratos.partials.pdf-cargar-component')

        
        
        {{-- MODAL CARGAR PDF --}}
        <div class="modal fade @if($modalPDFCargarLegajo) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form wire:submit.prevent="guardar_pdf">
                        <div class="modal-header bg-warning-subtle">
                            <h1 class="modal-title fs-5" id="pdf-cargar-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> CARGAR LEGAJOS
                            </h1>
                            <button type="button" class="btn-close" wire:click="cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-3 rounded mb-3">
                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-warning">CARGA ACTA</legend> --}}
                                <div class="row">
                                    <div class="col-xl-6">
                                        <label for="motivo" class="fw-bold fs-6">MOTIVO:</label>
                                        <input type="text" id="motivo" class="form-control form-control-sm" wire:model="motivo" required>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="titulodocumento" class="fw-bold fs-6">TITULO DOCUMENTO:</label>
                                        <input type="text" id="titulodocumento" class="form-control form-control-sm" wire:model="titulodocumento" required>
                                    </div>
                                    <div class="col-xl-4">
                                        <label for="fechaemision" class="fw-bold fs-6">FECHA EMISIÓN:</label>
                                        <input type="date" id="fechaemision" class="form-control form-control-sm" wire:model="fechaemision" required>
                                    </div>
                                    <div class="col-xl-8">
                                        <label for="filecontrato" class="fw-bold fs-6">CARGAR PDF:</label>
                                        <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                    </div>
                                </div>
                            </fieldset>      
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" wire:click = "cerrar">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('livewire.partials.modales.cargar-pdf-evidencia')
    </div>

</div>
