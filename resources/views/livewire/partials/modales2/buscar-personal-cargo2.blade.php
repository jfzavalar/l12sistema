<div class="modal fade @if($modalPersonalCargoBuscar2) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="buscar-cargos-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR CARGOS
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarBuscar2"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="txtSearchCargo" class="form-control form-control-sm" placeholder="Buscar cargos" wire:model.live="searchcargos">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">CARGOS</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_cargos as $cargo)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $cargo->nombre }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_cargo2({{ $cargo->id }})">
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
                                    <td colspan="3">
                                        {{ $lista_cargos->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>                       
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarBuscar2">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>