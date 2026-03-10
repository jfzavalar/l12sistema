<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-primary text-white" id="basic-addon1">CONDICIÓN:</span>
                            <select name="cmdfiltrocondicion" id="cmbfiltrocondicion" class="form-select form-select-sm" wire:model.live="filtrotipodocumento">
                                <option value="">TOTAL </option>
                                <option value="ADENDA">ADENDA </option>
                                <option value="CONTRATO">CONTRATO </option>
                                <option value="INCORPORACION">INCORPORACION </option>
                                <option value="LICENCIA">LICENCIA </option>
                                <option value="RENUNCIA">RENUNCIA </option>
                            </select>
                            <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-success text-white" id="basic-addon1">RÉGIMEN:</span>
                            <select name="cmdfiltrotipodocumento" id="cmbfiltrotipodocumento" class="form-select form-select-sm" wire:model.live="filtroregimen">
                                <option value="">TOTAL </option>
                                <option value="CAS">CAS </option>
                                <option value="D.L.276">D.L.276</option>
                                <option value="D.L.728">D.L.728 </option>
                            </select>
                            <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-2">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                            @can('mpfn.informatica.soporte.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                            @can('mpfn.informatica.soporte.destroy')
                                <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                                    <i class="fa-solid fa-ban"></i> Inactivos
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
                            <th scope="col" class="table-success">DEPENDENCIA ORIGEN</th>
                            <th scope="col" class="table-danger">BIEN UBICACIÓN FÍSICA</th> 
                            <th scope="col" class="table-success">REGIMEN - CARGO</th>                        
                            <th scope="col">BIENES PATRIMONIALES</th>
                            <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                <td>
                                    <b>SEDE:</b> {{ $item->sedeorigen }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                </td>
                                <td>
                                    <b>SEDE:</b> {{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachodestino }}
                                </td>
                                <td>
                                    <b>REGIMEN:</b> {{ $item->regimen }}
                                    <br>
                                    <b>CARGO:</b> {{ $item->cargo }}
                                </td>
                                <td class="text-center">
                                    {{ $item->bien_cod_patrimonial }}
                                    <br>
                                    {{ $item->bien }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @can('mpfn.informatica.soporte.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->soporte_id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        @can('mpfn.informatica.soporte.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                <td class="text-end">
                                    {{-- <div class="btn-group" role="group">
                                        @can('mpfn.rrhh.personal.create')
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="fa-solid fa-list"></i></i><br>Trámite
                                                </button>

                                                <ul class="dropdown-menu">

                                                    @if ($item->tipo_documento === "CONTRATO")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_adenda({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Adenda
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Licencia
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Renuncia
                                                            </button>
                                                        </li>                                                       

                                                    @elseif($item->tipo_documento === "LICENCIA")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Incorporación
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Renuncia
                                                            </button>
                                                        </li>

                                                    @else

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#nuevoEditarModal"
                                                                    wire:click="nuevo_contrato({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-check"></i> Contrato
                                                            </button>
                                                        </li>

                                                    @endif

                                                </ul>
                                            </div>
                                        @endcan
                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
                                    </div> --}}
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
                                <fieldset class="border p-3 rounded mb-3" {{ $seccionBienpatrimonial }}>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">BIEN PATRIMONIAL</legend>
                                    @include('livewire.patrimonio.bienes.partials.datos-bienes-component')
                                </fieldset>
                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-bienes-component">
                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar patrimonio
                                </button>
                            </div>
                            <div class="col-xl-8">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">SOPORTE</legend>
                                    @include('livewire.informatica.partials.datos-soporte-component')
                                </fieldset>
                            </div>
                        </div>
                        @include('livewire.informatica.partials.datos-soporte-observacion-component')
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

    @include('livewire.rrhh.personal.partials.buscar-personal-component')

    @include('livewire.patrimonio.bienes.partials.buscar-bienes-component')
</div>
