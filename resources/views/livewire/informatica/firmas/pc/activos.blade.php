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
            <div class="row">
                <div class="col-xl-6">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" colspan="2">Instalación de Firmas por Informático</th>
                                {{-- <th scope="col"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($totales_asignados as $tactivos)
                                <tr class="align-middle" style="font-size: 12px;">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th style="white-space: nowrap;">{{ $tactivos->created_user }}</th>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white" id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-check me-2"></i>Asignados
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_asignados }}" readonly>
                                            </div>
                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <button class="input-group-text bg-danger text-white" id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Devueltos
                                                </button>
                                                <input type="text" class="form-control" value="{{ $tactivos->total_devueltos }}" readonly>
                                            </div> --}}
                                        </div>
                                    </td>
                                    
                                </tr>
                            @empty
                                
                            @endforelse
                            {{-- <tr>
                                <th></th>
                                <th>Total</th>
                                <th>{{ $lista_activos->total() }}</th>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive small">
                    <div class="input-group mb-3">
                        <input type="text" id="txtsearcha2" class="form-control form-control-sm" wire:model.live="searcha2" placeholder="Buscar por DNI o Datos del Personal">
                        <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                            <i class="fa-solid fa-file"></i> Nuevo
                        </button>
                    </div>
                    <table class="table table-striped table-hover table-sm table-xsmall">
                        <thead class="table-success text-center align-middle">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><i class="fa-solid fa-user"></i> DNI</th>
                                <th scope="col">DATOS</th>
                                <th scope="col">SEDE</th>
                                <th scope="col">DEPENDENCIA</th>
                                <th scope="col">CARGO</th>
                                <th scope="col">TOKEN</th>
                                <th scope="col">EXPIRACION</th>
                                {{-- <th scope="col">ASIGNACION</th> --}}
                                <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse ($lista_activos as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->dni }}</td>
                                    <td>{{ $item->datos }}</td>
                                    <td>{{ $item->sede }}</td>
                                    <td>{{ $item->dependencia }}</td>
                                    <td>{{ $item->cargo }}</td>
                                    <td>{{ $item->codtoken }}</td>
                                    <td>{{ $item->fecha_expiracion }}</td>
                                    {{-- <td>
                                        @if ($item->asignacion == "ASIGNACION" || $item->asignacion == "REASIGNACION")
                                            <span class="badge rounded-pill text-bg-success">{{ $item->asignacion }}</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-danger">{{ $item->asignacion }}</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="btn-group" role="group">
                                                @can('procesos.informatica.firmaspcs.edit')
                                                    <button type="button" class="btn btn-outline-primary btn-xs" wire:click="editar({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                                        <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                    </button>
                                                @endcan  
                                                @can('procesos.informatica.firmaspcs.destroy')
                                                    <button type="button" class="btn btn-outline-danger btn-xs" wire:click="$emit('confirmarEliminacion', {{ $item->id }})">
                                                        <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                    </button>
                                                @endcan                                    
                                            </div>
                                        </div>    
                                    </td>
                                    {{-- <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="btn-group" role="group">                                        
                                                @if ($item->actaruta)
                                                    <a href="{{ asset($item->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                                        <i class="fa-solid fa-file-pdf"></i> Firmado
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td> --}}
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
    <div class="modal fade @if($modal_abierto_firmapc) show d-block @endif" tabindex="-1">
        {{-- <div class="modal-dialog modal-xl" style="max-width:90%;"> --}}
        <div class="modal-dialog modal-xl" style="max-width:90%;">>
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO - PC
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR - PC
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <fieldset class="border p-3 rounded text-center" disabled>
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
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Datos Institucionales</legend>
                                    @include('livewire.partials.personal-datos-institucionales')
                                </fieldset>
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Detalles de firma token</legend>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="txt_fecha_expiracion_pc" class="form-label fw-bold fs-6">Fecha Expiración</label>
                                            <input type="date" id="txt_fecha_expiracion_pc" class="form-control" wire:model="fecha_expiracion">
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="txt_observacion_pc" class="form-label fw-bold fs-6">Observación</label>
                                            <input type="text" id="txt_observacion_pc" class="form-control" wire:model="observacion">
                                        </div>
                                    </div>
                                </fieldset>
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

    @include('livewire.partials.personal-modal-buscar')

    @include('livewire.partials.pdf-modal-cargar')

</div>
