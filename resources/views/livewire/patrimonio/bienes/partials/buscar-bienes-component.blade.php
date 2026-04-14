<!-- Modal buscar personal -->
<div wire:ignore.self class="modal fade" id="buscar-bienes-component" tabindex="-1" aria-labelledby="buscar-bienes-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-5">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="buscar-bienes-componentLabel">
                        <i class="fa-solid fa-magnifying-glass"></i> BUSCAR BIENES
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar por código patrimonial" wire:model.live="searchbienes">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">COD</th>
                                    <th scope="col">COD PATRIMONIAL</th>
                                    <th scope="col">BIEN</th>
                                    <th scope="col">ESTADO</th>
                                    <th scope="col"></th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_bienes as $bien)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $bien->cod }}</th>
                                        <td>{{ $bien->cod_patrimonial }}</td>
                                        <td>{{ $bien->bien }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $bien->asignacion === 'ASIGNADO' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                {{ $bien->asignacion === 'ASIGNADO' ? 'ASIGNADO' : 'LIBRE' }}
                                            </span>
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_bien({{ $bien->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
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
                                    <td colspan="6">
                                        {{ $lista_bienes->links() }}
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