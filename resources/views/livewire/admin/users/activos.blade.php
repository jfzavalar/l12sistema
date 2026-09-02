{{-- Tab 01 --}}
<div>
    @if (session()->has('danger'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                    <input type="text" id="txtsearchusuario" class="form-control form-control-sm me-1 is-valid" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                    <button type="button" id="btnnuevo" class="btn btn-dark btn-sm rounded-3" wire:click="listarInactivos">
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
                            <th scope="col" class="table-success">ROLES</th>
                            <th scope="col">OBSERVACIÓN</th>
                            <th scope="col" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td class="fw-bold">{{ $item->dni }}<br>{{ $item->datos }}</td>
                                <td>{!! $item->getRoleNames()->sort()->implode(' <br> ') !!}</td>
                                <td>{{ $item->cargo }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_password({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Reset_Password
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
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11">
                                {{ $lista_activos->links() }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO EDITAR --}}
    <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content rounded-5">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                        <div class="modal-body">
                        <div class="row">
                            {{-- <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div> --}}
                            
                            <div class="col-xl-12 col-sm-12">                           
                                <div class="row">
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.partials.componentes.persona-datos')
                                        </fieldset>
                                        {{-- <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                        </button> --}}
                                    </div>
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3" disabled>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                            @include('livewire.partials.componentes.personal-datos')
                                        </fieldset>
                                    </div>
                                </div>
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

    {{-- MODAL INACTIVOS --}}
    <div class="modal fade @if($modalInactivos) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
        <div class="modal-dialog" style="max-width:90%;">
            <div class="modal-content rounded-5">
                <div class="modal-header bg-danger-subtle">
                    <h1 class="modal-title fs-5" id="inactivosModalLabel">
                        <i class="fa-solid fa-trash"></i> INACTIVOS
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click=cerrar></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive small">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearchusuarioi" class="form-control form-control-sm" wire:model.live="searchi" placeholder="Buscar usuario">
                        </div>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-user"></i> DNI - PERSONAL
                                    </th>
                                    <th scope="col">ROLES</th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_inactivos as $item)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td class="text-danger fw-bold">{{ $item->dni }}<br>{{ $item->datos }}</td>
                                        <td>{{ $item->getRoleNames()->implode(' | ') }}</td>
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
                                                No se encontraron resultados!
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="11">
                                        {{ $lista_inactivos->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click=cerrar>
                        <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ACTUALIZAR PASSWORD -->
    <div class="modal fade @if($modalPasswordActualizar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
        <div class="modal-dialog modal-ms">
            <div class="modal-content">
                <form wire:submit.prevent="actualizar_password">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="user-password-componentLabel">
                            <i class="fa-solid fa-key"></i> RESTABLECER PASSWORD
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <label for="txt_password1"><strong>Password: Se restablece a su DNI</strong></label>
                        <input type="password" id="txt_password1" class="form-control form-control-sm" wire:model="password">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <br>Restablecer Contraseña
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-door-closed"></i>
                            <br>Cerrar
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

        {{-- MODAL BUSCAR BIENES PATRIMONIALES --}}
        {{-- @include('livewire.partials.modales.buscar-patrimonio-bienes') --}}
        
        {{-- MODAL CARGAR PDF --}}
        @include('livewire.partials.modales.cargar-pdf-acta')
        @include('livewire.partials.modales.cargar-pdf-evidencia')

</div>


