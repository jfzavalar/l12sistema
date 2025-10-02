{{-- Tab 01 --}}
<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo" data-bs-toggle="modal" data-bs-target="#NuevoEditarModal">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">Header2</th>
                            <th scope="col">Header3</th>
                            <th scope="col">Header4</th>
                            <th scope="col">Header5</th>
                            <th scope="col">Header6</th>
                            <th scope="col">Header7</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-success btn-sm" wire:click="editar" data-bs-toggle="modal" data-bs-target="#NuevoEditarModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-envelope"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-dark btn-sm">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-handshake-simple"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-handshake-simple-slash"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm">
                                        <i class="fa-solid fa-upload"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm">
                                        <i class="fa-solid fa-timeline"></i>
                                    </button>                          
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo-Editar-->
    <div wire:ignore.self class="modal fade" id="NuevoEditarModal" tabindex="-1" aria-labelledby="NuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent={{ $btn_guardar_actualizar }}>
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            @endif
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            @else
                                <i class="fa-solid fa-floppy-disk"></i> Actualizar
                            @endif    
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

