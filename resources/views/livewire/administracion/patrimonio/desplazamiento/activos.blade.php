{{-- Tab 01 --}}
<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txt_searchabienesdesplazamientoa" class="form-control form-control-sm" wire:model.live="searchabienesdesplazamientoa" placeholder="Buscar por código patrimonial">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                        <thead class="table-primary text-center align-middle">
                        <tr class="text-center align-middle">
                            <th scope="col">#ACTA</th>
                            <th scope="col">SOLICITANTE</th>
                            <th scope="col">RESPONSABLE DE TRASLADO</th>
                            <th scope="col" class="table-dark">SEDE ORIGEN</th>
                            <th scope="col" class="table-secondary">SEDE DESTINO</th>
                            <th scope="col">MOTIVO</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">FECHA SALIDA</th>
                            <th scope="col">FECHA RETORNO</th>
                            <th scope="col">OBSERVACIÓN</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lista_activos as $item2)
                            <tr>
                                <th scope="row">{{ $item2->id }}</th>
                                <td>{{ $item2->solicitante }}</td>
                                <td>{{ $item2->responsabletraslado }}</td>
                                <td><strong>{{ $item2->sede_origen }}</strong><br>{{ $item2->dependencia_origen }}</td>
                                <td><strong>{{ $item2->sede_destino }}</strong><br>{{ $item2->dependencia_destino }}</td>
                                <td>{{ $item2->motivo_traslado }}</td>
                                <td>{{ $item2->tipotraslado }}</td>
                                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($item2->fechasalida)->format('d-m-Y') }}</td>
                                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($item2->fecharetorno)->format('d-m-Y') }}</td>
                                <td>{{ $item2->observacion }}</td>
                                <td>
                                    @if ($item2->traslado == "TRASLADADO")
                                        <h6><span class="badge bg-danger-subtle text-danger">TRASLADADO</span></h6>
                                        <br>{!! nl2br(e($item2->lista_equipos_traslado)) !!}
                                    @else
                                        <h6><span class="badge bg-success-subtle text-success">DEVUELTO</span></h6>
                                        <br>{!! nl2br(e($item2->lista_equipos_traslado)) !!}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-info" type="button" wire:click="ver({{ $item2->id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-dark" type="button" wire:click="imprimir({{ $item2->id }})">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" type="button" wire:click="cargarPDF1({{ $item2->id }})">
                                            <i class="fa-solid fa-upload"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" type="button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        {{-- <div class="btn-group" role="group">  
                                            <button type="button" class="btn btn-outline-dark dropdown-toggle btn-xs me-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-list"></i> Acciones
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="dropdown-item btn-xs" type="button" wire:click="$set('iddesplazamiento',{{ $item2->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-detalle-Modal">
                                                        <i class="fa-solid fa-eye"></i> Ver detalle
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item btn-xs" type="button" wire:click="$set('iddesplazamiento', {{ $item2->id }})"  data-bs-toggle="modal" data-bs-target="#pdfModal">
                                                        <i class="fa-solid fa-print"></i> Imprimir formato
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item btn-xs" type="button" wire:click="cargarPDF1({{ $item2->id }})" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                        <i class="fa-solid fa-upload"></i> Cargar formato
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item btn-xs" type="button">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>      

                                            @if ($item2->actaruta)
                                                <a href="{{ asset($item2->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                            @endif
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td>
                                <p></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Barra de paginación flotante con total --}}
    {{-- <div class="pagination-floating position-fixed bottom-0 start-50 translate-middle-x bg-white border-top shadow-sm py-2 px-4 w-100 w-md-auto" style="z-index: 1050;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small">
                <strong>Total de registros:</strong> {{ $lista_activos->total() }}
            </div>
            <div class="d-inline-block">
                {{ $lista_activos->links() }}
            </div>
        </div>
    </div> --}}
    <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div>

    <!-- Modal Nuevo-Editar-->
    <div class="modal fade @if($modal_abierto_bien_desplazamiento) show d-block @endif" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent={{ $btn_guardar_actualizar }}>
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO - DESPLAZAMIENTO
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR - DESPLAZAMIENTO
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <fieldset class="border p-3 rounded mb-3">
                                    {{-- <legend class="float-none w-outo px-3">Formulario</legend> --}}
                                    <div class="row g-3">
                                        <label for="txt_solicitante" class="col-sm-3 col-form-label"><strong>SOLICITANTE: </strong></label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" id="txt_solicitante" class="form-control form-control-sm bg-light" wire:model="solicitante" readonly required>
                                                <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('solicitante')">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="txt_responsable_traslado" class="col-sm-3 col-form-label"><strong>RESPONSABLE DE TRASLADO: </strong></label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" id="txt_responsable_traslado" class="form-control form-control-sm bg-light" wire:model="responsabletraslado" readonly>
                                                <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" wire:click="buscar_personal('traslado')">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="cmb_sede_origen" class="col-sm-3 col-form-label"><strong>ORIGEN: </strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            {{-- <label class="form-label"><strong>ORIGEN: SEDE</strong></label> --}}
                                            <div class="input-group mb-3">
                                                <select id="cmb_sede_origen" class="form-select form-select-sm" wire:model.live="sede_origen">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_sedes as $item_sede)
                                                        <option value="{{ $item_sede->codsedeofi }}">{{ $item_sede->nomsedeofi }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color}} btn-sm" data-bs-toggle="modal" data-bs-target="#sede-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            {{-- <label class="form-label"><strong>DEPENDENCIA</strong></label> --}}
                                            <div class="input-group mb-3">
                                                <select id="cmb_dependencia_origen" class="form-select form-select-sm" wire:model.live="dependencia_origen">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_dependencias as $item_dependencia)
                                                        <option value="{{ $item_dependencia->coddepofi }}" @selected($item_dependencia->coddepofi == $coddependencia)>{{ $item_dependencia->nomdepofi }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="cmb_sede_destino" class="col-sm-3 col-form-label"><strong>DESTINO: </strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            {{-- <label class="form-label"><strong>ORIGEN: SEDE</strong></label> --}}
                                            <div class="input-group mb-3">
                                                <select id="cmb_sede_destino" class="form-select form-select-sm" wire:model.live="sede_destino">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_sedes as $item_sede)
                                                        <option value="{{ $item_sede->codsedeofi }}">{{ $item_sede->nomsedeofi }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#sede2-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            {{-- <label class="form-label"><strong>DEPENDENCIA</strong></label> --}}
                                            <div class="input-group mb-3">
                                                <select id="cmb_dependencia_destino" class="form-select form-select-sm" wire:model.live="dependencia_destino">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_dependencias2 as $item_dependencia)
                                                        <option value="{{ $item_dependencia->coddepofi }}" @selected($item_dependencia->coddepofi == $coddependencia)>{{ $item_dependencia->nomdepofi }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia2-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="txt_motivo" class="col-sm-3 col-form-label"><strong>MOTIVO: </strong></label>
                                        <div class="col-lg-9 col-sm-9">
                                            <input type="text" id="txt_motivo" class="form-control form-control-sm text-uppercase" wire:model="motivo_traslado" required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="success-outlined" class="col-sm-3 col-form-label"><strong>TIPO DE TRASLADO: </strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            <div class="form-group">
                                                <input type="radio" class="btn-check" name="options-outlined" value="INTERNO" wire:model="tipotraslado" id="success-outlined" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm" for="success-outlined">INTERNO</label>

                                                <input type="radio" class="btn-check" name="options-outlined" value="EXTERNO" wire:model="tipotraslado" id="danger-outlined" autocomplete="off">
                                                <label class="btn btn-outline-danger btn-sm" for="danger-outlined">EXTERNO</label>
                                            </div> 
                                        </div>
                                        <label for="success-outlined2" class="col-sm-3 col-form-label"><strong>TIPO DE OPERACIÓN: </strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            <div class="form-group">
                                                <input type="radio" class="btn-check" name="options-outlined2" value="TRASLADADO" wire:model="traslado" id="success-outlined2" autocomplete="off">
                                                <label class="btn btn-outline-danger btn-sm" wire:click="$set('habilitar_btn_agregar_bienes','')" for="success-outlined2">TRASLADO</label>

                                                <input type="radio" class="btn-check" name="options-outlined2" value="DEVOLUCION" wire:model="traslado" id="danger-outlined2" autocomplete="off">
                                                <label class="btn btn-outline-success btn-sm" wire:click="operacion_traslado_equipos" for="danger-outlined2">DEVOLUCION</label>
                                            </div> 
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-3 rounded mb-3">
                                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                        <h6><strong>DETALLE DE BIENES INFORMÁTICOS</strong></h6>
                                        {{-- @if ($vdni && $vlocal && $vdependencia && $vcargo) --}}
                                            {{-- <button type="button" class="btn btn-success btn-sm" wire:click="$set('btnaccion2','guardarbiendetalletemp')" data-bs-toggle="modal" data-bs-target="#agregarpatrimoniobieninformaticoModal"> --}}
                                            <button type="button" class="btn btn-success btn-sm" wire:click="buscar_bien" {{ $habilitar_btn_agregar_bienes }}>
                                                <i class="fas fa-plus-square fa-fw"></i> Agregar bienes
                                            </button>
                                        {{-- @endif --}}
                                    </div>
                                    <div class="table-responsive">
                                        {{-- Mensaje de error equipo duplicado --}}
                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <table class="table table-striped table-hover table-sm small align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">CÓDIGO DE BARRAS</th>
                                                    <th scope="col">CÓDIGO MARGESI</th>
                                                    <th scope="col">DESCRIPCIÓN</th>
                                                    <th scope="col">MARCA</th>
                                                    <th scope="col">MODELO</th>
                                                    <th scope="col">SERIE</th>
                                                    <th scope="col">COLOR</th>
                                                    <th scope="col">ESTADO</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tempbienesinformaticos as $itemtemp => $tempbieninfo)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $tempbieninfo['cod_patrimonial'] }}</td>
                                                        <td>{{ $tempbieninfo['cod_barra']}}</td>
                                                        <td>{{ $tempbieninfo['desc_bien']}}</td>
                                                        <td>{{ $tempbieninfo['desc_marca']}}</td>
                                                        <td>{{ $tempbieninfo['modelo']}}</td>
                                                        <td>{{ $tempbieninfo['nro_serie']}}</td>
                                                        <td>{{ $tempbieninfo['desc_color']}}</td>
                                                        <td>{{ $tempbieninfo['des_estado_conservacion']}}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-danger btn-sm" wire:click="eliminar_buscar_bieninformatico({{ $itemtemp }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-3 rounded mb-1">
                                    <div class="row g-3">
                                        <label for="txt_fechasalida" class="col-sm-3 col-form-label"><strong>FECHA DE SALIDA:</strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            <input type="date" id="txt_fechasalida" class="form-control form-control-sm" wire:model="fechasalida" required>
                                        </div>
                                        <label for="txt_fecharetorno" class="col-sm-3 col-form-label"><strong>FECHA POSIBLE DE RETORNO:</strong></label>
                                        <div class="col-lg-3 col-sm-3">
                                            <input type="date" id="txt_fecharetorno" class="form-control form-control-sm" wire:model="fecharetorno" required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="txt_observacion" class="col-sm-3 col-form-label"><strong>OBSERVACIONES:</strong></label>
                                        <div class="col-lg-9 col-sm-9">
                                            <input type="text" id="txt_observacion" class="form-control form-control-sm text-uppercase" wire:model="observacion" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div> 
                        </div>         
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            @else
                                <i class="fa-solid fa-floppy-disk"></i> Actualizar
                            @endif    
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETALLE REGISTRO-->
    <div class="modal fade @if($modal_abierto_bien_desplazamiento_detalle) show d-block @endif" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                {{-- <form wire:submit.prevent={{ $guardar_actualizar }}> --}}
                    <div class="modal-header bg-secondary-subtle">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <i class="fa-solid fa-bars"></i> DETALLE DE BIENES TRANSFERIDOS
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm small">
                                <thead class="table-dark align-middle">
                                    <tr class="text-center">
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col"># ACTA</th>
                                        <th scope="col">CÓDIGO DE BARRAS</th>
                                        <th scope="col">CÓDIGO MARGESI</th>
                                        <th scope="col">DESCRIPCIÓN</th>
                                        <th scope="col">MARCA</th>
                                        <th scope="col">MODELO</th>
                                        <th scope="col">SERIE</th>
                                        <th scope="col">COLOR</th>
                                        <th scope="col">ESTADO</th>
                                        <th scope="col">TRASLADO</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_desplazamientos_detalle as $activo_detalle)
                                        <tr>
                                            {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                            <th scope="row">{{ $activo_detalle->id_biendesplazamiento }}</th>
                                            <td>{{ $activo_detalle->cod_patrimonial }}</td>
                                            <td>{{ $activo_detalle->cod_barra }}</td>
                                            <td>{{ $activo_detalle->bien}}</td>
                                            <td>{{ $activo_detalle->marca}}</td>
                                            <td>{{ $activo_detalle->modelo}}</td>
                                            <td>{{ $activo_detalle->serie}}</td>
                                            <td>{{ $activo_detalle->color}}</td>
                                            <td>{{ $activo_detalle->est_cons}}</td>
                                            <td>
                                                @if ($activo_detalle->traslado == "TRASLADADO")
                                                    <h6><span class="badge bg-danger-subtle text-danger">TRASLADADO</span></h6>
                                                @else
                                                    <h6><span class="badge bg-success-subtle text-success">DEVUELTO</span></h6>
                                                @endif
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger" role="alert">
                                            No existen registros
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn {{ $color_boton }}">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <br>Guardar
                        </button> --}}
                        <button type="button" class="btn btn-outline-secondary" wire:click="cerrar">
                            <i class="fa-solid fa-door-closed"></i>
                            Cerrar
                        </button>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>

    @include('livewire.partials.personal-modal-buscar')
    @include('livewire.partials.bienes-modal-buscar')
    @include('livewire.partials.pdf-modal-cargar')
    @include('livewire.partials.pdf-modal-vista-previa')

</div>

