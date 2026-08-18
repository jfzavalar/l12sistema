<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">

                    <div class="col-xl-4">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_servicios->total() }}</span>
                            <input type="text" id="txtsearcservicio" class="form-control form-control-sm" wire:model.live="searchservicios" placeholder="Buscar por SERVICIO">
                            {{-- @can('mpfn.rrhh.personal.create') --}}
                                <button type="button" id="btnnuevoservicio" class="btn btn-primary btn-sm" wire:click="nuevo_servicio">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            {{-- @endcan --}}
                            
                        </div>
                        {{ $lista_servicios->links() }}
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-user"></i> SERVICIO
                                    </th>
                                    <th scope="col" class="table-dark">
                                        <i class="fa-solid fa-gears"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_servicios as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $item->servicio }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-success btn-xs me-2" wire:click="editar_servicio({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                                </button>
                                                <button type="button" class="btn btn-info btn-xs me-2" wire:click="listar_servicios_detalle({{ $item->id }})">
                                                    <i class="fa-solid fa-list me-1"></i>Listar detalles
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs">
                                                    <i class="fa-solid fa-trash me-1"></i>Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="alert alert-danger" role="alert">
                                                ¡No se encontraron resultados!
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <td colspan="3">{{ $lista_servicios->links() }}</td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>

                    <div class="col-xl-8">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_servicios_detalles->total() }}</span>
                            <input type="text" id="txtsearchdetalle" class="form-control form-control-sm" wire:model.live="searchserviciosdetalles" placeholder="Buscar por INCIDENCIA / SOLICITUD">
                            @if ($servicio_id)
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo_servicio_detalle">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endif                           
                        </div>
                        {{ $lista_servicios_detalles->links() }}
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        SERVICIO
                                    </th>
                                    <th scope="col">
                                        INCIDENCIA / SOLICITUD
                                    </th>
                                    <th scope="col">
                                        RESPUESTA
                                    </th>
                                    <th scope="col" class="table-dark">
                                        <i class="fa-solid fa-gears"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_servicios_detalles as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $item->servicio }}</td>
                                        <td>{{ $item->incidencia_solicitud }}</td>
                                        <td>{{ $item->respuesta }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-success btn-xs me-2" wire:click="editar_servicio_detalle({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs">
                                                    <i class="fa-solid fa-trash me-1"></i>Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="alert alert-danger" role="alert">
                                                ¡No se encontraron resultados!
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <td colspan="3">{{ $lista_servicios->links() }}</td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL NUEVO EDITAR SERVICIO -->
    <div class="modal fade @if($modal_abierto_servicio) show d-block @endif" id="NuevoEditarServicioModal" tabindex="-1">
        <div class="modal-dialog modal-ms">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $funcionGuardarActualizarServicio }}">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_nuevo_servicio"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <label for="txtservicio" class="fw-bold fs-6">SERVICIO:</label>
                                <input id="txtservicio" type="text" class="form-control form-control-sm" wire:model="servicio">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorBotonGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i>{{ $textoBotonGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_nuevo_servicio">
                            <i class="fa-solid fa-square-xmark me-1"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL NUEVO EDITAR SERVICIO DETALLE-->
    <div class="modal fade @if($modal_abierto_servicio_detalle) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
        <div class="modal-dialog modal-ms">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $funcionGuardarActualizarServicio }}">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_nuevo_servicio_detalle"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <label for="txtdetalle" class="fw-bold fs-6">SERVICIO</label>
                                <input id="txtdetalle" type="text" class="form-control form-control-sm" wire:model="incidencia_solicitud_servicio" readonly>
                            </div>
                            <div class="col-xl-12">
                                <label for="cmbtipo" class="fw-bold fs-6">TIPO</label>
                                <select id="cmbtipo" class="form-select form-select-sm" wire:model="incidencia_solicitud_tipo_desc">
                                    <option value="">Selecciona...</option>
                                    <option value="INCIDENCIA">INCIDENCIA</option>
                                    <option value="SOLICITUD">SOLICITUD</option>
                                </select>
                            </div>
                            <div class="col-xl-12">
                                <label for="cmbincsol" class="fw-bold fs-6">INCIDENCIA / SOLICITUD</label>
                                <input id="cmbincsol" type="text" class="form-control form-control-sm" wire:model="incidencia_solicitud">
                            </div>
                            <div class="col-xl-12">
                                <label for="txtrespuesta" class="fw-bold fs-6">RESPUESTA</label>
                                <input id="txtrespuesta" type="text" class="form-control form-control-sm" wire:model="incidencia_solicitud_respuesta">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorBotonGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i>{{ $textoBotonGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_nuevo_servicio_detalle">
                            <i class="fa-solid fa-square-xmark me-1"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
