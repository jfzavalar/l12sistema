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
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
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
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col" class="table-danger">ESTADO</th>
                            <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
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
                                <td class="text-center">
                                    <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                        @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                            text-bg-danger
                                        @endif">
                                        {{ $item->tipo_documento }}
                                    </span>
                                </td>
                                <td @class(['text-danger' => \Carbon\Carbon::parse($item->fecha_finu)->lt(now())])>
                                    <b>SEDE:</b> {{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachodestino }}
                                    <br>
                                    <b>De: </b>{{ $item->fecha_iniciou }}
                                    <b>Hasta: </b>{{ $item->fecha_finu }}
                                </td>
                                <th>
                                    {{ $item->estado }}
                                </th>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @can('mpfn.rrhh.personalrotacion.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        @can('mpfn.rrhh.personalrotacion.edit')
                                            <button type="button" class="btn btn-outline-primary btn-xs" wire:click="nuevo_retorno({{ $item->rotacion_id }})">
                                                <i class="fa-solid fa-arrow-right-arrow-left"></i><br>Retornar
                                            </button>
                                        @endcan
                                        <button type="button" class="btn btn-outline-warning btn-xs" wire:click="historial_rotaciones('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
                                        @can('mpfn.rrhh.personalrotacion.destroy')
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
                            <td colspan="8">{{ $lista_activos->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div>
        {{-- Modal Nuevo-Editar --}}
        <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="cerrar"></button>
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
                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm" wire:click="personalBuscar">
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
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionUbicacion }}>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">ROTACIÓN</legend>
                                        <div class="row">
                                            <div class="col-xl-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <label for="txt_sede2" class="fw-bold fs-6">Sede</label>
                                                        <div class="input-group">
                                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="sedeBuscar">
                                                                <i class="fa-solid fa-magnifying-glass"></i>
                                                            </button>
                                                            <input type="text" id="txt_sede2" class="form-control form-control-xs bg-light" wire:model="sededestino" readonly required>
                                                        </div>
                                                        @error('sededestino')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="txt_dependencia2" class="fw-bold fs-6">Dependencia</label>
                                                        <div class="input-group position-relative">
                                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="dependenciaBuscar">
                                                                <i class="fa-solid fa-magnifying-glass"></i>
                                                            </button>
                                                            <input type="text" id="txt_dependencia2" class="form-control form-control-xs bg-light" wire:model="dependenciadestino" readonly required>
                                                        </div>
                                                        @error('dependenciadestino')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="txt_despacho2" class="fw-bold fs-6">Despacho</label>
                                                        <div class="input-group position-relative">
                                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="despachoBuscar">
                                                                <i class="fa-solid fa-magnifying-glass"></i>
                                                            </button>
                                                            <input type="text" id="txt_despacho2" class="form-control form-control-xs bg-light" wire:model="despachodestino" readonly required>
                                                        </div>
                                                        @error('despachodestino')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>                            
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-8">
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionRotacion }}>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS SUSTENTATORIOS</legend>
                                        <div class="row">
                                            <div class="col-xl-12 col-sm-12 mb-3">
                                                <div class="row">
                                                    <div class="col-xl-4 col-sm-12 mt-2">
                                                        <label for="txtresolucionu" class="fw-bold fs-6">N° Expediente</label>
                                                        <input type="text" id="txtresolucionu" class="form-control form-control-xs" wire:model="num_expediente">
                                                        @error('num_expediente')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-8 col-sm-12 mt-2">
                                                        <label for="filecontrato" class="fw-bold fs-6">Resolución de ubicación o transferencia</label>
                                                        <div class="input-group">
                                                            {{-- <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                                                                <i class="fa-solid fa-print"></i> Imprimir
                                                            </button> --}}
                                                            <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                                            @if ($ruta_documento)
                                                                <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_documento) }}" target="_blank">
                                                                    <i class="fa-solid fa-file-pdf"></i> Ver firmado
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-sm-12 mt-2">
                                                        <label for="txtfechainiciou" class="fw-bold fs-6">Fecha de inicio</label>
                                                        <input type="date" id="txtfechainiciou" class="form-control form-control-xs" wire:model="fecha_iniciou">
                                                        @error('fecha_iniciou')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-2 col-sm-12 mt-2">
                                                        <label for="txtfechafinu" class="fw-bold fs-6">Fecha de fin</label>
                                                        <input type="date" id="txtfechafinu" class="form-control form-control-xs" wire:model="fecha_finu">
                                                        @error('fecha_finu')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-8 col-sm-12 mt-2">
                                                        <label for="txtobservacionu" class="fw-bold fs-6">Observación o motivo</label>
                                                        <input type="text" id="txtobservacionu" class="form-control form-control-xs" wire:model="motivo_ubicacion">
                                                        @error('motivou')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>                              
                                                </div>
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
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                                <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Inactivos --}}
        <div class="modal fade @if($modalInactivos) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-dark-subtle">
                        <h1 class="modal-title fs-5" id="inactivosModalLabel">
                            <i class="fa-solid fa-trash"></i> INACTIVOS
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchi" placeholder="Buscar por dni o Apellidos y nombres">
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
                                        <th scope="col">CONDICIÓN</th>
                                        <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                                        <th scope="col" class="table-danger">ESTADO</th>
                                        <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
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
                                            <td class="text-center">
                                                <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                                    @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                                        text-bg-danger
                                                    @endif">
                                                    {{ $item->tipo_documento }}
                                                </span>
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
                                            <th>
                                                {{ $item->estado }}
                                            </th>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personalrotacion.edit')
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Historial Rotaciones --}}
        <div class="modal fade @if($modalHistorial) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="historialrotacionesModalLabel">
                            <i class="fa-solid fa-timeline"></i> HISTORIAL ROTACIONES
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="historial_rotaciones_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchhistorialr" class="form-control form-control-sm" wire:model.live="searchhistorial" placeholder="Buscar por dni o Apellidos y nombres">
                                {{-- <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                                    <i class="fa-regular fa-file-pdf"></i> PDF
                                </a> --}}
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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="historial_rotaciones_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

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

        <div wire:ignore.self class="modal fade" id="pdf-cargar-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="pdf-cargar-componentLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form wire:submit.prevent="actualizar_pdf">
                        <div class="modal-header bg-warning-subtle">
                            <h1 class="modal-title fs-5" id="pdf-cargar-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> CARGAR PDF
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click = "cerrar_transferir_personal"></button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-3 rounded mb-3">
                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">CARGA ACTA</legend>
                                <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
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

        {{--MODAL BUSCAR PERSONAL --}}
        @include('livewire.partials.modales.buscar-personal-datos')

        {{-- MODALE BUSCAR SEDES-DEPENDENCIAS-DESPACHOS --}}
        @include('livewire.partials.modales.buscar-personal-sede-dependencia-despacho')
        
        {{-- MODAL BUSCAR CARGO --}}
        @include('livewire.partials.modales.buscar-personal-cargo')

        {{-- MODAL CARGAR PDF --}}
        @include('livewire.partials.modales.cargar-pdf-acta')
        @include('livewire.partials.modales.cargar-pdf-evidencia')


    </div>

</div>
