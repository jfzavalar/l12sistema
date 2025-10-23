<div class="card">
    <div class="card-body">
        <div class="table-responsive small">
            <div class="input-group mb-3">
                <input type="text" id="txt_searchbienesinactivos" class="form-control form-control-sm" wire:model.live="searchbienesinactivos" placeholder="Buscar por código patrimonial">
                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                    <i class="fa-solid fa-file"></i> Nuevo
                </button>
            </div>
            <table class="table table-striped table-hover table-sm table-xsmall">
                <thead class="table-primary text-center align-middle">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">N° PECOSA</th>
                        <th scope="col">CLASE</th>
                        <th scope="col">FAMILIA</th>
                        <th scope="col">COD_PATRIMONIAL</th>
                        <th scope="col">COD_BARRA</th>
                        <th scope="col">BIEN</th>
                        <th scope="col">MARCA</th>
                        <th scope="col">MODELO</th>
                        <th scope="col">SERIE</th>
                        <th scope="col">MEDIDAS</th>
                        <th scope="col">COLOR</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ASIGNACIÓN</th>
                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse ($lista_inactivos as $activo)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <th>{{ $activo->nro_pecosa }}</th>
                            <th>{{ $activo->clase }}</th>
                            <td>{{ $activo->familia }}</td>
                            <th class="text-primary">{{ $activo->cod_pat }}</th>
                            <td>{{ $activo->cod_barra }}</td>
                            <td>{{ $activo->bien }}</td>
                            <td>{{ $activo->marca }}</td>
                            <td>{{ $activo->modelo }}</td>
                            <td>{{ $activo->serie }}</td>
                            <td>{{ $activo->serie }}</td>
                            <td>{{ $activo->color }}</td>
                            <td>{{ $activo->est_cons }}</td>
                            <td>
                                @if ($activo->asignacion == "1")
                                    <span class="badge rounded-pill text-bg-success">Asignado</span>
                                @elseif($activo->asignacion == "0")
                                    <span class="badge rounded-pill text-bg-danger">Devuelto</span>
                                @endif
                            </td>
                            <td>
                                {{-- @if ($activo->asignacion == "1")
                                    <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="devolver2({{ $activo->id }})">
                                        <i class="fas fa-exchange-alt"></i><br>Devolver
                                    </button>
                                @elseif($activo->asignacion == "0")
                                    <button type="button" class="btn btn-outline-danger btn-xs" wire:click="reasignar1({{ $activo->id }})">
                                        <i class="fas fa-exchange-alt"></i><br>Reasignar
                                    </button>
                                @endif --}}
                            </td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="btn-group" role="group">
                                        @can('procesos.informatica.tokens.destroy')
                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="activar({{ $item->id }})">
                                                <i class="fa-solid fa-check-double"></i><br>Reactivar
                                            </button>
                                        @endcan
                                    </div>
                                </div>       
                            </td>
                            {{-- <td>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="btn-group" role="group">                                        
                                        @if ($activo->actaruta)
                                            <a href="{{ asset($activo->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-xs">
                                                <i class="fa-solid fa-file-pdf"></i><br>Firmado
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="text-center">
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
