<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Fitrar:</span>
                            <select id="cmbfitroanio" class="form-select form-select-sm" wire:model.live="filtroanio">
                                @foreach($anios as $anio)
                                    <option value="{{ $anio }}">{{ $anio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-10">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Nombres y Apellidos">
                            @can('mpfn.rrhh.personal.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="generarGastosOperativos">
                                    <i class="fa-solid fa-file"></i> Genera Nuevo Año Fiscal
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                            <th scope="col">REGIMEN - CARGO</th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col">AÑO</th>
                            <th scope="col" class="table-success">ENE</th>
                            <th scope="col" class="table-success">FEB</th>
                            <th scope="col" class="table-success">MAR</th>
                            <th scope="col" class="table-success">ABR</th>
                            <th scope="col" class="table-success">MAY</th>
                            <th scope="col" class="table-success">JUN</th>
                            <th scope="col" class="table-success">JUL</th>
                            <th scope="col" class="table-success">AGO</th>
                            <th scope="col" class="table-success">SEP</th>
                            <th scope="col" class="table-success">OCT</th>
                            <th scope="col" class="table-success">NOV</th>
                            <th scope="col" class="table-success">DIC</th>
                            <th scope="col" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                {{-- <td>
                                    <b>SEDE:</b> {{ $item->sedeorigen }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                </td> --}}
                                <td>
                                    <b>REGIMEN:</b> {{ $item->regimen }}
                                    <br>
                                    <b>CARGO:</b> {{ $item->cargo }}
                                </td>
                                <td>
                                    <b>SEDE:</b> {{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachodestino }}
                                    <br>
                                </td>
                                <td class="text-nowrap">
                                    <b>Email personal:</b> {{ $item->correopersonal }}:
                                    <br><b>Cel. personal:</b> {{ $item->celpersonal }}
                                    <br><b>Email institucional:</b> {{ $item->correoinstitucional }}
                                    <br><b>Cel. institucional:</b> {{ $item->celinstitucional }}
                                </td>
                                <td class="text-center">
                                    <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                        @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                            text-bg-danger
                                        @endif">
                                        {{ $item->tipo_documento }}
                                    </span>
                                </td>
                                <th>
                                    <span class="badge bg-light text-primary border">
                                        {{ $item->anio }}
                                    </span>
                                </th>
                                @foreach(['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'] as $mes)
                                    <td class="text-center">
                                        <button type="button"
                                            wire:click="entregado({{ $item->gastosoperativos_id }}, '{{ $mes }}')"
                                            class="btn {{ $item->$mes == '1' ? 'btn-success' : 'btn-danger' }} btn-sm rounded-circle">
                                            {{ $item->$mes == '1' ? 'E' : 'P' }}
                                        </button>
                                    </td>
                                @endforeach
                                
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="20" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="20">{{ $lista_activos->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Alerta al Cambio de estado-->
    <div class="modal fade @if($modal_abierto_alerta_cambio_estado) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-ms">
            <div class="modal-content">
                {{-- <form wire:submit.prevent="{{ $btn_guardar_actualizar }}"> --}}
                <form wire:submit.prevent="actualizar_entregado">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-bell"></i> ALERTA
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_alerta_cambio_estado"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <label for="cmb_reportado" class="fw-bold fs-6">OBSERVACIONES:</label>
                                <textarea id="txtupdated_motivo" class="form-control" rows="10" style="font-size: 12px; white-space: nowrap; overflow-x: auto;" wire:model="updated_motivo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Guardar Observación
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_alerta_cambio_estado">
                            <i class="fa-solid fa-square-xmark me-1"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
