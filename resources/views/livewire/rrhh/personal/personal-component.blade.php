<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-2">
                    <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                    <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                        <i class="fa-solid fa-ban"></i> Inactivos
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col" class="table-success">DEPENDENCIA ORIGEN</th>
                            <th scope="col" class="table-success">UBICACIÓN FÍSICA</th>
                            <th scope="col" class="table-success">REGIMEN</th>
                            <th scope="col" class="table-success">CARGO</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <th>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                <td>
                                    SEDE: {{ $item->sedeorigen }}
                                    <br>
                                    DEPENDENCIA: {{ $item->dependenciaorigen }}
                                </td>
                                <td></td>
                                <td>{{ $item->regimen }}</td>
                                <td>{{ $item->cargo }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i><br>Ver
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#transferirPersonalModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-people-arrows"></i><br>Transferencia
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>
                                    </div>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo_adenda({{ $item->id }})">
                                            <i class="fa-solid fa-file-shield"></i><br>Adenda
                                        </button>
                                        <button type="button" class="btn btn-outline-dark btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo_renuncia({{ $item->id }})">
                                            <i class="fa-solid fa-file-shield"></i><br>Renuncia
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo_contrato({{ $item->id }})">
                                            <i class="fa-solid fa-file-shield"></i><br>Contrato
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
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
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
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
                                    @include('livewire.rrhh.personal.partials.foto-component')
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

    {{-- Modal Inactivos --}}
    <div wire:ignore.self class="modal fade" id="inactivosModal" tabindex="-1" aria-labelledby="inactivosModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-dark-subtle">
                    <h1 class="modal-title fs-5" id="inactivosModalLabel">
                        <i class="fa-solid fa-trash"></i> INACTIVOS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive small">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchi" placeholder="Buscar">
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
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Historial --}}
    <div wire:ignore.self class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h1 class="modal-title fs-5" id="historialModalLabel">
                        <i class="fa-solid fa-timeline"></i> HISTORIAL CONTRATOS / ADENDAS / RENUNCIAS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive small">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchdocumento" placeholder="Buscar por número de convocatoria">
                        </div>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-user"></i> PERSONAL
                                    </th>
                                    <th scope="col">DEPENDENCIA ORIGEN</th>
                                    <th scope="col">DEPENDENCIA DESTINO</th>
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
                                            SEDE: {{ $item3->sedeorigen }}
                                            <br>
                                            DEPENDENCIA: {{ $item3->dependenciaorigen }}
                                        </td>
                                        <td></td>
                                        <td>{{ $item3->regimen }}</td>
                                        <td>{{ $item3->cargo }}</td>
                                        <td>{{ $item3->numero_convocatoria }}</td>
                                        <td>
                                            {{ $item3->tipo_documento }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item3->id }})">
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
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
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

    @include('livewire.rrhh.personal.partials.transferencia-personal-component')

</div>
