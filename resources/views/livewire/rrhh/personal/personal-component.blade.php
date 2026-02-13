<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                    <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal" wire:click="cerrar">
                        <i class="fa-solid fa-ban"></i> Inactivos
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> PERSONAL
                            </th>
                            <th scope="col" class="table-success">DEPENDENCIA ORIGEN</th>
                            <th scope="col" class="table-success">DEPENDENCIA DESTINO</th>
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
                                    <br>{{ $item->datos }}
                                </th>
                                <td></td>
                                <td></td>
                                <td>{{ $item->regimen }}</td>
                                <td></td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i><br>Ver
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>                                     
                                    </div>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-file-shield"></i><br>Nuevo Contrato
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-timeline"></i><br>Historial Contrato
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="">
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.foto-component')
                                </fieldset>
                            </div>
                            
                            <div class="col-xl-10 col-sm-12">                           
                                <div class="row">
                                    <div class="col-xl-4">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.rrhh.personal.partials.datos-personales-component')
                                        </fieldset> 
                                    </div>
                                    <div class="col-xl-8">
                                        <fieldset class="border p-3 rounded mb-3">
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
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS DEL ÚLTIMO CONTRATO</legend>
                                    @include('livewire.rrhh.contratos.partials.datos-contrato-component')
                                </fieldset> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
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
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchinactivo" placeholder="Buscar">
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
                                @forelse ($lista_activos as $item)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td>
                                            {{ $item->dni }}
                                            <br>{{ $item->datos }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $item->regimen }}</td>
                                        <td></td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
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

</div>
