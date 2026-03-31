<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    {{-- <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                        </div>
                    </div> --}}
                    <div class="col-xl-12">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                            @can('mpfn.rrhh.personalrotacion.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                            @can('mpfn.rrhh.personalrotacion.destroy')
                                <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                                    <i class="fa-solid fa-ban"></i> Inactivos
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon1">Filtrar por sede:</span>
                            <select id="cmbfiltrotipodocumento" class="form-select form-select-sm" wire:model.live="filtrosede">
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
                            <span class="input-group-text fw-bold" id="basic-addon1">Por Dependencia:</span>
                            <select id="cmbfiltrotipodocumento2" class="form-select form-select-sm" wire:model.live="filtrodependencia">
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
                            <span class="input-group-text fw-bold" id="basic-addon1">Por Condición:</span>
                            <select id="cmbfiltrotipodocumento3" class="form-select form-select-sm" wire:model.live="filtrotipodocumento">
                                <option value="">TOTAL </option>
                                <option value="ADENDA">ADENDA </option>
                                <option value="CONTRATO">CONTRATO </option>
                                <option value="INCORPORACION">INCORPORACION </option>
                                <option value="LICENCIA">LICENCIA </option>
                                <option value="RENUNCIA">RENUNCIA </option>
                            </select>
                            {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon1">Por régimen:</span>
                            <select id="cmbfiltrotipodocumento4" class="form-select form-select-sm" wire:model.live="filtroregimen">
                                <option value="">TOTAL </option>
                                <option value="CAS">CAS </option>
                                <option value="D.L.276">D.L.276</option>
                                <option value="D.L.728">D.L.728 </option>
                            </select>
                            {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
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
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
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
                                        {{-- @can('mpfn.rrhh.personal.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan --}}
                                        {{-- @can('mpfn.rrhh.personal.create')
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
                                        @endcan --}}
                                        {{-- <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button> --}}
                                        {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i><br>Ver
                                        </button> --}}
                                    </div>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @can('mpfn.rrhh.personalrotacion.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialrotacionesModal" wire:click="historial_rotaciones('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
                                        @can('mpfn.rrhh.personalrotacion.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                </td>
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
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar personal
                                        </button>
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
                            <div class="col-xl-4">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ROTACIÓN</legend>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12">
                                            @include('livewire.rrhh.personal.partials.sede-dependencia-despacho-component')
                                        </div>                            
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-8">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS SUSTENTATORIOS</legend>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 mb-3">
                                            @include('livewire.rrhh.personal.partials.datos-personales-transferencia-ubicacion-component')
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

    {{-- Modal Inactivos --}}
    <div wire:ignore.self class="modal fade" id="inactivosModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="inactivosModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-dark-subtle">
                    <h1 class="modal-title fs-5" id="inactivosModalLabel">
                        <i class="fa-solid fa-trash"></i> INACTIVOS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchi" placeholder="Buscar">
                        </div>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-user"></i> PERSONAL
                                    </th>
                                    <th scope="col" class="table-secondary">DEPENDENCIA ORIGEN</th>
                                    <th scope="col" class="table-secondary">DEPENDENCIA DESTINO</th>
                                    <th scope="col" class="table-secondary">REGIMEN</th>
                                    <th scope="col" class="table-secondary">CARGO</th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_inactivos as $item2)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td>
                                            {{ $item2->dni }}
                                            <br>{{ $item2->datos }}
                                        </td>
                                        <td>
                                            SEDE: {{ $item2->sedeorigen }}
                                            <br>
                                            DEPENDENCIA: {{ $item2->dependenciaorigen }}
                                        </td>
                                        <td></td>
                                        <td>{{ $item2->regimen }}</td>
                                        <td>{{ $item2->cargo }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item2->id }})">
                                                    <i class="fa-solid fa-check-double"></i><br>Reactivar
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
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                        <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Historial --}}
    {{-- <div wire:ignore.self class="modal fade" id="historialModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="historialModalLabel" aria-hidden="true">
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
    </div> --}}

    {{-- Modal Historial Rotaciones --}}
    <div wire:ignore.self class="modal fade" id="historialrotacionesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="historialrotacionesModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="historialrotacionesModalLabel">
                        <i class="fa-solid fa-timeline"></i> HISTORIAL ROTACIONES
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchhistorialr" class="form-control form-control-sm" wire:model.live="searchhistorial" placeholder="Buscar por número de convocatoria">
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
                                    {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                                    <th scope="col">ROTACIÓN</th>
                                    <th scope="col">N° EXPEDIENTE</th>
                                    <th scope="col">MOTIVO</th>
                                    <th scope="col">DESDE</th>
                                    <th scope="col">HASTA</th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_historial_rotaciones as $item4)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <th>
                                            {{ $item4->dni }}
                                            <br>{{ $item4->datos }}
                                        </th>
                                        {{-- <td>
                                            <b>SEDE:</b> {{ $item4->sedeorigen }}
                                            <br>
                                            <b>DEPENDENCIA:</b> {{ $item4->dependenciaorigen }}
                                            <br>
                                            <b>DESPACHO:</b> {{ $item4->despachoorigen }}
                                        </td> --}}
                                        <td>
                                            <b>SEDE:</b> {{ $item4->sede }}
                                            <br>
                                            <b>DEPENDENCIA:</b> {{ $item4->dependencia }}
                                            <br>
                                            <b>DESPACHO:</b> {{ $item4->despacho }}
                                        </td>
                                        <td>
                                            {{ $item4->num_expediente }}
                                        </td>
                                        <td>
                                            {{ $item4->motivo_ubicacion }}
                                        </td>
                                        <td>
                                            {{ $item4->fecha_iniciou }}
                                        </td>
                                        <td>
                                            {{ $item4->fecha_finu }}
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                @can('mpfn.rrhh.personal.edit')
                                                    <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item4->personal_id }})">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button>
                                                @endcan
                                                
                                                @if($item4->ruta_documento)
                                                    <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item4->ruta_documento) }}" target="_blank">
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
    {{-- <div wire:ignore.self class="modal fade" id="verDetallesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
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
                                                <td class="@if($item3->tipo_documento == 'CONTRATO') text-success
                                                            @elseif($item3->tipo_documento == 'LICENCIA') text-danger
                                                            @elseif($item3->tipo_documento == 'RENUNCIA') text-danger
                                                            @elseif($item3->tipo_documento == 'ADENDA') text-primary
                                                            @endif">
                                                    {{ $item3->tipo_documento }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($item3->fecha_fin)->format('d/m/Y') }}
                                                </td>
                                                <td class="text-end">
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
    </div> --}}

    {{-- Modal Transferencia de Personal - Ubicación Física --}}
    <div wire:ignore.self class="modal fade" id="transferencia-personal-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="transferir-Personal-componentLabel" aria-hidden="true">
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
    </div>

    <!-- Modal Historial - Traslado - Ubicación Física -->

    <div wire:ignore.self class="modal fade" id="transferencia-personal-historial-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="transferir-Personal-Historial-componentLabel" aria-hidden="true">
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
    </div>


    @include('livewire.rrhh.personal.partials.buscar-personal-component')
    @include('livewire.rrhh.personal.partials.buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.buscar-despachos-component')
    @include('livewire.rrhh.personal.partials.buscar-cargos-component')

    @include('livewire.rrhh.personal.partials.2buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.2buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.2buscar-despachos-component')

    @include('livewire.rrhh.contratos.partials.pdf-cargar-component')

</div>
