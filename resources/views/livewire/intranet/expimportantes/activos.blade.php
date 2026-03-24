<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="input-group mb-2">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                            @can('mpfn.intranet.expimportantes.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                            @can('mpfn.intranet.expimportantes.destroy')
                                <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                                    <i class="fa-solid fa-ban"></i> Inactivos
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                            <th scope="col" class="table-secondary">EXPEDIENTE</th>
                            <th scope="col" class="table-secondary">MOTIVO - DETALLE</th>
                            <th scope="col" class="table-secondary">UBICACIÓN</th>
                            <th scope="col" class="table-secondary">ASIGNADO A</th>
                            <th scope="col" class="table-secondary">DESDE</th>
                            <th scope="col" class="table-secondary">ESTADO</th>
                            @can('mpfn.intranet.expimportantes.edit')
                                <th scope="col" class="table-dark"><i class="fa-solid fa-gears"></i></th>  
                            @endcan                         
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th></th>
                                <th>
                                    {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                {{-- <td>
                                    <b>SEDE: {{ $item->sedeorigen }}</b>
                                    <br>
                                    {{ $item->dependenciaorigen }}
                                </td> --}}
                                <td>
                                    {{ $item->numexpediente }}
                                </td>
                                <td>
                                    {{ $item->expdetalle }}
                                </td>
                                <td>
                                    {{ $item->asignado_a }}
                                </td>
                                <td>
                                    {{ $item->oficina_ubicacion }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->fecha)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $item->estado == 'PENDIENTE' ? 'bg-danger' : '' }}
                                        {{ $item->estado == 'FINALIZADO' ? 'bg-success' : '' }}">
                                        {{ $item->estado }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @can('mpfn.intranet.expimportantes.edit')
                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>   
                                    @endcan
                                    <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->numexpediente }}')">
                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                    </button>                                  
                                </td>
                            </tr>                            
                        @empty
                            
                        @endforelse
                    </tbody>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS DEL EXPEDIENTE</legend>
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label for="txtexp" class="fw-bold fs-6">N° de Expediente</label>
                                            <input type="text" id="txtexp" class="form-control form-control-xs text-uppercase" wire:model="numexpediente" {{ $bloquear_inputs }} required>
                                            @error('numexpediente')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtexpdetalle" class="fw-bold fs-6">Motivo o detalle</label>
                                            <input type="text" id="txtexpdetalle" class="form-control form-control-xs text-uppercase" wire:model="expdetalle" {{ $bloquear_inputs }} required>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="cmbestadoexp" class="fw-bold fs-6">Estado</label>
                                            <select id="cmbestadoexp" class="form-select form-select-xs" wire:model="estado" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="PENDIENTE">PENDIENTE</option>
                                                <option value="FINALIZADO">FINALIZADO</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtubicacion" class="fw-bold fs-6">Ubicación</label>
                                            <input type="text" id="txtubicacion" class="form-control form-control-xs text-uppercase" wire:model="oficina_ubicacion" required>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtasignadoa" class="fw-bold fs-6">Asignado a: </label>
                                            <input type="text" id="txtasignadoa" class="form-control form-control-xs text-uppercase" wire:model="asignado_a" required>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtfecha" class="fw-bold fs-6">Desde: </label>
                                            <input type="date" id="txtfecha" class="form-control form-control-xs" wire:model="fecha" required>
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
                            {{-- <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-outline-naranja btn-sm">
                                <i class="fa-regular fa-file-pdf"></i> PDF
                            </a> --}}
                        </div>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-user"></i> DNI - PERSONAL
                                    </th>
                                    {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                                    <th scope="col" class="table-secondary">EXPEDIENTE</th>
                                    <th scope="col" class="table-secondary">MOTIVO - DETALLE</th>
                                    <th scope="col" class="table-secondary">UBICACIÓN</th>
                                    <th scope="col" class="table-secondary">ASIGNADO A</th>
                                    <th scope="col" class="table-secondary">DESDE</th>
                                    <th scope="col" class="table-secondary">ESTADO</th>
                                    {{-- @can('mpfn.intranet.expimportantes.edit')
                                        <th scope="col" class="table-dark"><i class="fa-solid fa-gears"></i></th>  
                                    @endcan                          --}}
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_historial as $item)
                                    <tr>
                                        <th></th>
                                        <th>
                                            {{ $item->dni }}
                                            <br>
                                            {{ $item->datos }}
                                        </th>
                                        {{-- <td>
                                            <b>SEDE: {{ $item->sedeorigen }}</b>
                                            <br>
                                            {{ $item->dependenciaorigen }}
                                        </td> --}}
                                        <td>
                                            {{ $item->numexpediente }}
                                        </td>
                                        <td>
                                            {{ $item->expdetalle }}
                                        </td>
                                        <td>
                                            {{ $item->asignado_a }}
                                        </td>
                                        <td>
                                            {{ $item->oficina_ubicacion }}
                                        </td>
                                        <td>
                                            {{ $item->fecha }}
                                        </td>
                                        <td>
                                            <span class="badge 
                                                {{ $item->estado == 'PENDIENTE' ? 'bg-danger' : '' }}
                                                {{ $item->estado == 'FINALIZADO' ? 'bg-success' : '' }}">
                                                {{ $item->estado }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            @can('mpfn.intranet.expimportantes.edit')
                                                <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                </button>   
                                            @endcan
                                            <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                                <i class="fa-solid fa-timeline"></i><br>Historial
                                            </button>                                  
                                        </td> --}}
                                    </tr>                            
                                @empty
                                    
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

    @include('livewire.rrhh.personal.partials.buscar-personal-component')

</div>
