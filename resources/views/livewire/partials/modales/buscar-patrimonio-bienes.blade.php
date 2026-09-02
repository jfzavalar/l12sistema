<div class="modal fade @if($modalPatrimonioBienesBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-5">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="buscar-bienes-componentLabel">
                        <i class="fa-solid fa-magnifying-glass"></i> BUSCAR BIENES
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="txtSearchBienes" class="form-control form-control-sm" placeholder="Buscar por CODIGO DE BARRA o CODIGO PATRIMONIAL" wire:model.live="searchbienes">
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
                                    @can('mpfn.informatica')
                                        <th scope="col">ESTADO</th>
                                    @endcan
                                    <th scope="col"></th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_bienes as $bien)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $bien->codigo_barra }}</th>
                                        <td>{{ $bien->codigo_patrimonial }}</td>
                                        <td>{{ $bien->descripcion }}</td>
                                        @can('mpfn.informatica')
                                            <td>
                                                <span class="badge rounded-pill {{ $bien->asignacion === 'ASIGNADO' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ $bien->asignacion === 'ASIGNADO' ? 'ASIGNADO' : 'LIBRE' }}
                                                </span>
                                            </td>
                                        @endcan
                                        <td></td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_bien({{ $bien->id }})">
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
                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarBuscar">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>