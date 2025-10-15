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
                <div class="input-group mb-3">
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searcha" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo {{ $searcha }}
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE</th>
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">DESPACHO</th>
                            <th scope="col">REGIMEN</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">CORREO PERSONAL</th>
                            <th scope="col" class="table-success">ROLES</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->dni }}</td>
                                <td>{{ $item->datos }}</td>
                                <td>{{ $item->sede }}</td>
                                <td>{{ $item->dependencia }}</td>
                                <td></td>
                                <td>{{ $item->regimen }}</td>
                                <td>{{ $item->cargo }}</td>
                                <td>{{ $item->correo_personal }}</td>
                                <td>{{ $item->getRoleNames()->implode(' | ') }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-xs">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Password
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-info btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-envelope"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-dark btn-sm">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-handshake-simple"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-handshake-simple-slash"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm">
                                            <i class="fa-solid fa-upload"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm">
                                            <i class="fa-solid fa-timeline"></i>
                                        </button>                           --}}
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
    <div class="modal fade @if($modal_abierto_personal) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-4 col-sm-12">
                                    <fieldset class="border p-3 rounded text-center">
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
                                        <legend class="float-none w-outo px-3 fs-6">Datos Institucionales</legend>
                                        @include('livewire.partials.personal-datos-institucionales')
                                    </fieldset>
                                </div>
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

    @include('livewire.partials.personal-modal-foto')
    
    @include('livewire.partials.personal-modal-buscar')

</div>


