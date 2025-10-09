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
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searcha" placeholder="Buscar por DNI o Datos del Personal">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo {{ $searcha }}
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
