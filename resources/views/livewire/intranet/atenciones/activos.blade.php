<div>
    @if (session()->has('danger'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                {{-- <div class="input-group mb-3"> --}}
                    <div class="row g-3">
                        <div class="col-lg-2 col-sm-12">
                            <label for="txtsearchpersonalatenciones" class="btn btn-outline-primary btn-sm me-2">Total:</label>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_anio" wire:model="filtro_anio" class="form-select form-select-sm me-2">
                                <option value="">-- Año --</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                    <option value="{{ $anio }}">{{ $anio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_mes" wire:model="filtro_mes" class="form-select form-select-sm me-2">
                                <option value="">-- Mes --</option>
                                @foreach ([
                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                ] as $num => $mes)
                                    <option value="{{ $num }}">{{ $mes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearchpersonalatenciones" class="form-control form-control-sm" wire:model.live="searchpersonalatenciones" placeholder="Buscar por DNI o Datos del Personal">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>
                            <th scope="col">TIPO</th>
                            <th scope="col">PEDIDO</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">MEDIO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" class="bg-success-subtle">SOLUCIÓN</th>
                            <th scope="col">GLPI</th>
                            <th scope="col">CEA</th>
                            <th scope="col">CARPETA</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    {{-- <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <th>{{ $item->dni }}</th>
                                <td>{{ $item->datos }}</td>
                                <td>
                                    <b>SEDE: </b>{{ $item->sede_origen }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_origen }}
                                </td>
                                <td class="text-primary">
                                    <b>SEDE: </b>{{ $item->sede_destino }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_destino }}
                                </td>
                                <td><b>{{ $item->regimen }}</b></td>
                                <td>{{ $item->cargo }}</td>
                                <td>
                                    <b>CEL: </b>{{ $item->cel_personal }}
                                    <br>{{ $item->correo_personal }}
                                </td>
                                <td>
                                    <b>CEL: </b>{{ $item->cel_institucional }}
                                    <br>{{ $item->correo_institucional  }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary btn-xs" wire:click="nuevo_contrato({{ $item->id }})">
                                            <i class="fa-solid fa-file"></i><br>Nuevo_contrato
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>                           
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>
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
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo-Editar-->
    <div class="modal fade @if($modal_abierto_atenciones) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-ticket"></i> NUEVO - ATENCIONES
                            @else
                                <i class="fa-solid fa-ticket"></i> EDITAR - ATENCIONES
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-3 col-sm-12">
                                    <fieldset class="border p-3 rounded text-center mb-3" disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">FOTO DE PERFIL</legend>
                                        @include('livewire.partials.personal-datos-foto')
                                    </fieldset>
                                </div>
                                <div class="col-xl-9 col-sm-12">
                                    {{-- <fieldset class="border p-3 rounded mb-3" disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend>
                                        @include('livewire.partials.personal-datos-institucionales-mir')
                                    </fieldset> --}}

                                    @include('livewire.partials.personal-datos-institucionales-mir')
                                    
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <fieldset class="border p-3 rounded mb-3">
                                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS PERSONALES</legend> --}}
                                                @include('livewire.partials.personal-datos-personales')
                                            </fieldset> 
                                        </div>
                                        <div class="col-xl-9">
                                            <fieldset class="border p-3 rounded mb-3" disabled>
                                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend> --}}
                                                @include('livewire.partials.personal-datos-institucionales')
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DETALLE DE LA ATENCIÓN</legend>
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <label for="" class="fw-bold fs-6">REPORTADO POR</label>
                                                <select name="" id="" class="form-select form-select-xs">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="CEA">CEA</option>
                                                    <option value="CORREO">CORREO</option>
                                                    <option value="DOCUMENTO">DOCUMENTO</option>
                                                    <option value="LLAMADA">LLAMADA</option>
                                                    <option value="PERSONALMENTE">PERSONALMENTE</option>
                                                    <option value="SISTEMA">SISTEMA</option>
                                                    <option value="WHATSAPP">WHATSAPP</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="" class="fw-bold fs-6">TIPO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="tipoi" name="tipo" class="btn-check" value="INCIDENCIA" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="tipoi">INCIDENCIA</label>

                                                    <input type="radio" id="tipos" name="tipo" class="btn-check" value="SOLICITUD" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="tipos">SOLICITUD</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="" class="fw-bold fs-6">INDICENCIA/SOLICITUD</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-xs">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" class="form-control form-control-xs">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="" class="fw-bold fs-6">ESPECIFICACIÓN (Incidencia / Solicitud)</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-xs">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <input type="text" class="form-control form-control-xs">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <label for="" class="fw-bold fs-6">CEA</label>
                                                <input type="text" class="form-control form-control-xs">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="" class="fw-bold fs-6">Carpeta Fiscal</label>
                                                <input type="text" class="form-control form-control-xs">
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="txtdespacho" class="fw-bold fs-6">Enviado a Lima</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="enviadoSi" name="enviadoLima" class="btn-check" value="SI" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="enviadoSi">Sí</label>

                                                    <input type="radio" id="enviadoNo" name="enviadoLima" class="btn-check" value="NO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="enviadoNo">No</label>
                                                </div>
                                            </div>

                                            <div class="col-xl-3">
                                                <label for="" class="fw-bold fs-6">GLPI</label>
                                                <input type="text" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label for="" class="fw-bold fs-6">DESCRIPCIÓN (Opcional)</label>
                                                <input type="text" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="border p-3 rounded mb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <label for="txtdespacho" class="fw-bold fs-6">ATENDIDO</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="atendidoSi" name="atendido" class="btn-check" value="SI" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="atendidoSi">Sí</label>

                                                    <input type="radio" id="atendidoNo" name="atendido" class="btn-check" value="NO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="atendidoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="txtdespacho" class="fw-bold fs-6">TIEMPO DE ATENCIÓN</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="normal" name="tiempo" class="btn-check" value="NORMAL" autocomplete="off" checked>
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="normal">NORMAL (1 día)</label>

                                                    <input type="radio" id="regular" name="tiempo" class="btn-check" value="REGULAR" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="regular">REGULAR (2 a 5 días)</label>

                                                    <input type="radio" id="complejo" name="tiempo" class="btn-check" value="COMPLEJO" autocomplete="off">
                                                    <label class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill" for="complejo">COMPLEJO (mayor a 6 días)</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="txtdespacho" class="fw-bold fs-6">ADJUNTAR ARCHIVOS</label>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-{{ $btn_guardar_actualizar_color }} btn-xs flex-fill"> Seleccionar...</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label for="" class="fw-bold fs-6">SOLUCIÓN / RESPUESTA</label>
                                                <input type="text" class="form-control form-control-xs">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i> Guardar y Responder <i class="fa-solid fa-envelope"></i>
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

    @include('livewire.partials.personal-modal-buscar')

</div>
