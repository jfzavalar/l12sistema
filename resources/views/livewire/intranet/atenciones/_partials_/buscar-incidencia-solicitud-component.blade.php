<div wire:ignore.self class="modal fade" id="buscar-inicidencia-solicitud-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="buscar-inicidencia-solicitud-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary-subtle">
                <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                    BUSCAR INCIDENCIAS / SOLICITUDES
                </h1>
                <button type="button" class="btn-close" wire:click="cerrar_incidencia_solicitud" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
            </div>
            <div class="modal-body">
                <input id="txtBuscarDetalle" type="text" class="form-control form-control-sm mb-2" placeholder="Buscar por detalle incidencia o solicitud" wire:model.live="searchincidenciasolicitud">
                <div class="table-responsive small">
                    <table class="table table-striped table-hover table-sm table-xsmall">
                        <thead class="table-dark text-center align-middle">
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Incidencia / Solicitud</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lista_incidencias_solicitudes as $item2)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item2->servicio }}</td>
                                    <td>{{ $item2->incidencia_solicitud }}</td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_incidencia_solicitud({{ $item2->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
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
                    {{ $lista_incidencias_solicitudes->links() }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_incidencia_solicitud" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                    <i class="fa-solid fa-square-xmark"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>