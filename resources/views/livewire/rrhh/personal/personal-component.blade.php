<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchusuario" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                    <button type="button" id="btnnuevo" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal" wire:click="cerrar">
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
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">REGIMEN</th>
                            <th scope="col">CARGO</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->dni }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#intranet-password-Modal" wire:click="editar_password({{ $item->dni }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Password
                                        </button>
                                        <a href="{{ route('procesos.admin.users.roles.edit', $item->id) }}" class="btn btn-outline-primary btn-xs">
                                            <i class="fa-solid fa-user-gear"></i><br>Asignar_rol
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
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
    </div>

    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                        <i class="fa-solid fa-file"></i> NUEVO
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-12">
                            <fieldset class="border p-3 rounded text-center mb-3">
                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                @include('livewire.rrhh.personal.partials.foto-component')
                            </fieldset>
                        </div>
                        
                        <div class="col-xl-10 col-sm-12">

                            {{-- @include('livewire.partials.personal-datos-institucionales-mir') --}}
                            
                            <div class="row">
                                <div class="col-xl-3">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                        @include('livewire.rrhh.personal.partials.datos-personales-component')
                                    </fieldset> 
                                </div>
                                <div class="col-xl-9">
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
                                {{-- @include('livewire.partials.personal-datos-contrato') --}}
                            </fieldset> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-file"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Inactivos --}}
    <div wire:ignore.self class="modal fade" id="inactivosModal" tabindex="-1" aria-labelledby="inactivosModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle">
                    <h1 class="modal-title fs-5" id="inactivosModalLabel">INACTIVOS</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
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
