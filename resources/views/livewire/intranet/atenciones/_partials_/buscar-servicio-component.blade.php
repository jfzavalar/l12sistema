<div wire:ignore.self class="modal fade" id="buscar-servicio-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="buscar-servicio-componentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h1 class="modal-title fs-5" id="buscar-servicio-componentLabel">
                    BUSCAR SERVICIO
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="cerrar_servicio" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="txtservicio" class="form-control form-control-sm mb-2" placeholder="Buscar por incidencia o solicitud" wire:model.live="searchservicios" >
                <div class="table-responsive small">
                    <table class="table table-striped table-hover table-sm table-xsmall">
                        <thead class="table-dark text-center align-middle">
                            <tr>
                                <th>#</th>
                                <th>SERVICIO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lista_servicios as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->servicio }}</td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_servicio({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                    <i class="fa-solid fa-share-from-square"></i> Agregar
                                                </button>
                                            </div>
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
                        </tbody>
                    </table>
                    {{ $lista_servicios->links() }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar_servicio" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                    <i class="fa-solid fa-square-xmark"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>