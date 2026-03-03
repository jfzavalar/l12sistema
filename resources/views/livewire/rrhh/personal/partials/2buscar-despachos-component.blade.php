<!-- Modal buscar despachos -->
<div wire:ignore.self class="modal fade" id="2buscar-despachos-component" tabindex="-1" aria-labelledby="2buscar-despachos-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="2buscar-despachos-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR DESPACHOS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#transferencia-personal-component"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar despachos" wire:model.live="searchdespachos">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DESPACHO</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_despachos as $despacho)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $despacho->nombre }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_despacho({{ $despacho->id }})" data-bs-toggle="modal" data-bs-target="#transferencia-personal-component">
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
                                        {{ $lista_despachos->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>                        
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#transferencia-personal-component">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>