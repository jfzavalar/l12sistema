<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-2">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Filtrar por:</span>
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
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm me-1" wire:model.live="search" placeholder="Buscar por DNI o Nombres y Apellidos">
                            {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button> --}}
                            <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" wire:click="generarListaDeEntregaDeGastosOperativos">
                                <i class="fa-solid fa-list"></i> General Año Fiscal
                            </button>
                            {{-- @can('mpfn.rrhh.personal.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="generarGastosOperativos">
                                    <i class="fa-solid fa-file"></i> Genera Nuevo Año Fiscal
                                </button>
                            @endcan --}}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">AÑO</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
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
                                <th>{{ $item->anio }}</th>
                                <th>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                    <br>
                                    REGIMEN: {{ $item->regimen }}
                                    <br>
                                    CARGO: {{ $item->cargo }}
                                </th>
                                <td>
                                    <b>SEDE:</b> {{ $item->sede }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependencia }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despacho }}
                                    <br>
                                </td>
                                <td class="text-nowrap">
                                    <b>Email personal:</b> {{ $item->correopersonal }}:
                                    <br><b>Cel. personal:</b> {{ $item->celpersonal }}
                                    <br><b>Email institucional:</b> {{ $item->correoinstitucional }}
                                    <br><b>Cel. institucional:</b> {{ $item->celinstitucional }}
                                </td>
                                @php
                                    $meses = [
                                        'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                                        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
                                    ];
                                @endphp
                                @foreach ($meses as $mes)
                                    <td class="text-center">
                                        <button
                                            type="button"
                                            class="btn {{ $item->$mes == 1 ? 'btn-outline-primary' : 'btn-outline-danger' }} btn-sm rounded-pill"
                                            wire:click="editar_entregado({{ $item->id }}, '{{ $mes }}')">

                                            @if ($item->$mes == 1)
                                                <i class="fa-solid fa-check-double"></i>
                                            @else
                                                <i class="fa-solid fa-xmark"></i>
                                            @endif

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

    {{-- MODAL NUEVO EDITAR --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%;">
            <div class="modal-content">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                    <div class="modal-body">
                        <div class="row">
                            {{-- <div class="col-xl-1 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }} disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">PERFIL</legend>
                                    @include('livewire.partials.componentes.persona-foto')
                                </fieldset>
                            </div> --}}

                            <div class="col-xl-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                            <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.partials.componentes.persona-datos')
                                        </fieldset>
                                        {{-- <input list="personales" class="form-control form-control-sm" placeholder="Seleccionar...">
                                        <datalist id="personales">
                                            @foreach ($lista_personas2 as $personal)
                                                <option value="{{ $personal->dni }}">{{ $personal->datos }}</option>
                                            @endforeach
                                        </datalist> --}}
                                    </div>
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
                                            <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                            @include('livewire.partials.componentes.personal-datos')
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- REGISTRO DE TICKES --}}
                        {{-- <div class="row">
                            <div class="col-xl-12">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLE DE LA INCIDENCIA/SOLICITUD</legend>
                                    </fieldset>
                            </div>
                        </div> --}}
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Alerta al Cambio de estado-->
    <div class="modal fade @if($modal_abierto_alerta_cambio_estado) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-ms">
            <div class="modal-content">
                {{-- <form wire:submit.prevent="{{ $btn_guardar_actualizar }}"> --}}
                <form wire:submit.prevent="actualizar_entregado">
                    <div class="modal-header bg-success-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file-pen"></i> Actualizar
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_alerta_cambio_estado"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <label for="cmb_reportado" class="fw-bold fs-6">OBSERVACIONES:</label>
                                <textarea id="txtupdated_motivo" class="form-control" rows="3" style="font-size: 12px; white-space: nowrap; overflow-x: auto;" wire:model="mes_observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_alerta_cambio_estado">
                            <i class="fa-solid fa-square-xmark me-1"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--MODAL BUSCAR PERSONAL --}}
    @include('livewire.rrhh.personal.partials.buscar-personal-component')

    {{-- MODALE BUSCAR SEDES-DEPENDENCIAS-DESPACHOS --}}

    @include('livewire.rrhh.personal.partials.buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.buscar-despachos-component')

    {{-- MODAL BUSCAR CARGO --}}
    @include('livewire.rrhh.personal.partials.buscar-cargos-component')

</div>
