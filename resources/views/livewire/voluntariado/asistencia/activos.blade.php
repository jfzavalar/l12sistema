
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
            <form wire:submit.prevent="guardar">
                <div class="row">
                    <div class="col-xl-4">
                        <fieldset class="border p-3 rounded mb-3">
                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS PERSONALES</legend> --}}
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-sm-12">
                                    <label for="txt_dni" class="fw-bold fs-6">DNI</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar}} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <input type="text" id="txt_dni" class="form-control form-control-xs" wire:model.live="dni" maxlength="8" required>
                                    </div>
                                    @error('dni')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-8 col-lg-6 col-sm-12">
                                    <label for="txt_datos" class="fw-bold fs-6">Voluntario</label>
                                    <input type="text" id="txt_datos" class="form-control form-control-xs text-uppercase" wire:model="datos" disabled>
                                    @error('datos')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                                    <input type="text" id="txt_celular_personal" class="form-control form-control-xs" wire:model="cel_personal" disabled>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
                                    <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase" wire:model="correo_personal" disabled>
                                </div>
                            </div> 
                        </fieldset> 
                    </div>
                    <div class="col-xl-8">
                        <fieldset class="border p-3 rounded mb-3">
                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend> --}}
                            @include('livewire.partials.voluntarios-datos-institucionales')
                        </fieldset>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-sm-12">
                        <input type="date" class="form form-control form-control-sm" wire:model.live="filtro_fecha">
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searchbuscarvoluntario" placeholder="Buscar por DNI o Datos del Personal">
                            {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button> --}}
                        </div>
                    </div>
                </div>
                
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>

                            <th scope="col">SEDE</th>

                            <th scope="col">FECHA</th>
                            <th scope="col">ENTRADA</th>
                            <th scope="col">SALIDA</th>
                            <th scope="col">REGISTRA</th>
                            <th scope="col">SUBTOTAL</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td><b>{{ $item->dni }}</b><br>{{ $item->datos }}</td>

                                <td class="text-primary">
                                    <b>SEDE: </b>{{ $item->sede_destino }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_destino }}
                                </td>

                                <th>{{ $item->fecha }}</th>
                                <td><span class="badge rounded-pill text-bg-success fs-6">{{ $item->hora_entrada }}</span></td>
                                <td><span class="badge rounded-pill text-bg-secondary fs-6">{{ $item->hora_salida }}</span></td>
                                
                                <td>{{ $item->created_user }}</td>
                                <th>{{ $item->subtotal }}</th>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        {{-- <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button> --}}
                                        {{-- <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>                            --}}
                                        @can('procesos.voluntariado.asistencias.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="9">
                                <p></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Barra de paginación flotante con total --}}
    {{-- <div class="pagination-floating position-fixed bottom-0 start-50 translate-middle-x bg-white border-top shadow-sm py-2 px-4 w-100 w-md-auto" style="z-index: 1050;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small">
                <strong>Total de registros:</strong> {{ $lista_activos->total() }}
            </div>
            <div class="d-inline-block">
                {{ $lista_activos->links() }}
            </div>
        </div>
    </div> --}}
    <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div>

    <!-- Modal Nuevo-Editar-->


    <!-- Modal buscar personal -->
    <div wire:ignore.self class="modal fade" id="buscar-personal-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="buscar-personal-componentLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-5">
                <form action="">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="buscar-personal-componentLabel">
                            <i class="fa-solid fa-magnifying-glass"></i> BUSCAR VOLUNTARIOS
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_voluntarios->total() }}</span>
                                            <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar personal" wire:model.live="searchbuscarvoluntario">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Datos</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_voluntarios as $voluntario)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $voluntario->dni }}</th>
                                            <td>{{ $voluntario->datos }}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_voluntario({{ $voluntario->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                            <i class="fa-solid fa-circle-plus"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            {{ $lista_voluntarios->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                       
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                            <i class="fa-solid fa-door-closed"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Foto -->
    {{-- @include('livewire.partials.personal-modal-foto') --}}

    <!-- Modal PDF -->
    {{-- @include('livewire.partials.pdf-modal-cargar') --}}

</div>

