<div class="modal fade @if($modalPersonalSedeBuscar2) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-dark text-white">
                    <h1 class="modal-title fs-5" id="buscar-sedes-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR SEDE
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarBuscar2"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="txtSearchSede" class="form-control form-control-sm" placeholder="Buscar sede" wire:model.live="searchsedes">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">SEDE</th>
                                    <th scope="col">DETALLE</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_sedes as $sede)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sede->nombre }}</td>
                                        <td>{{ $sede->nombred }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_sede2({{ $sede->id }})">
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
                                    <td colspan="4">{{ $lista_sedes->links() }}</td>
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

<div class="modal fade @if($modalPersonalDependenciaBuscar2) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-dark text-white">
                    <h1 class="modal-title fs-5" id="buscar-dependencias-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR DEPENDENCIA
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarBuscar2"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="txtSearchDependencia" class="form-control form-control-sm" placeholder="Buscar dependencia" wire:model.live="searchdependencias">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DEPENDENCIA</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_dependencias2 as $dependencia)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dependencia->nombre }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_dependencia2({{ $dependencia->id }})">
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
                                        {{ $lista_dependencias->links() }}
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

<div class="modal fade @if($modalPersonalDespachoBuscar2) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-dark text-white">
                    <h1 class="modal-title fs-5" id="buscar-despachos-componentLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR DESPACHOS
                    </h1>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarBuscar2"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="txtSearchDespacho" class="form-control form-control-sm" placeholder="Buscar despachos" wire:model.live="searchdespachos">
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
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_despacho2({{ $despacho->id }})">
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
                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarBuscar2">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
