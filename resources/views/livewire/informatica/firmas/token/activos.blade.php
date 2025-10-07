<div>
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
                            <th scope="col">DNI</th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE</th>
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">TOKEN</th>
                            <th scope="col">EXPIRACION</th>
                            <th scope="col">ASIGNACIÓN</th>
                            <th scope="col">
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $activo)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th>{{ $activo->dni }}</th>
                                <td>{{ $activo->datos }}</td>
                                <td>{{ $activo->sede }}</td>
                                <td>{{ $activo->dependencia }}</td>
                                <td>{{ $activo->cargo }}</td>
                                <td>{{ $activo->codtoken }}</td>
                                <td>{{ $activo->fecha_expiracion }}</td>
                                <td>
                                    @if ($activo->asignacion == "ASIGNACION" || $activo->asignacion == "REASIGNACION")
                                        <span class="badge rounded-pill text-bg-success">{{ $activo->asignacion }}</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">{{ $activo->asignacion }}</span>
                                    @endif
                                </td>
                                <td>
                                    @can('procesos.informatica.tokens.edit')
                                        @if ($activo->asignacion == "ASIGNACION" || $activo->asignacion == "REASIGNACION")
                                            <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="$emit('confirmarDevolucion', {{ $activo->id }})">
                                                <i class="fas fa-exchange-alt"></i><br>Devolver
                                            </button>
                                        @endif
                                        @if ($activo->asignacion == "DEVOLUCION")
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="reasignar1({{ $activo->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                                <i class="fas fa-exchange-alt"></i><br>Reasignar
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.tokens.edit')
                                                <button type="button" class="btn btn-outline-primary btn-xs" wire:click="editar({{ $activo->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                </button>
                                            @endcan
                                            {{-- <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                                <i class="fa-solid fa-eye"></i> Ver
                                            </button> --}}
                                            {{-- <a type="button" href="{{ route('pdf.informatica.token-acta', $activo->id) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                                <i class="fa-solid fa-print"></i> Acta
                                            </a> --}}
                                            {{-- <button type="button" class="btn btn-outline-dark btn-sm" wire:click="exportarPDF({{ $activo->id }})">
                                                <i class="fa-solid fa-file-arrow-down"></i> DescargarPDF
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-outline-success btn-sm" wire:click="cargarPDF1({{ $activo->id }})" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                <i class="fa-solid fa-file-pdf"></i> CargarPDF
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                <i class="fa-solid fa-file-pdf"></i> Firmado
                                            </button> --}}
                                            <button type="button" class="btn btn-outline-info btn-xs" wire:click="$set('codtoken','{{ $activo->codtoken }}')" data-bs-toggle="modal" data-bs-target="#historial-Modal">
                                                <i class="fa-solid fa-timeline"></i><br>Historial
                                            </button>     
                                            @can('procesos.informatica.tokens.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="$emit('confirmarEliminacion', {{ $activo->id }})">
                                                    <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                </button>
                                            @endcan                                
                                        </div>
                                    </div>       
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">                                        
                                            @if ($activo->actaruta)
                                                <a href="{{ asset($activo->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                                    <i class="fa-solid fa-file-pdf"></i><br>Firmado
                                                </a>
                                            @endif
                                        </div>
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
</div>
