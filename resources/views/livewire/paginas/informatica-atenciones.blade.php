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

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> REGISTRO DE INCIDENCIAS / SOLICITUDES: {{ strtoupper(now()->locale('es')->translatedFormat('F Y')) }}
        </h1>
        {{-- <div class="row">
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                    <span class="alert alert-primary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            TOTAL: {{ $estadisticas2->total }}
                        </span>
                    </span>
                </button>
            </div>
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarEnviadolima">
                    <span class="alert alert-info d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            LIMA: {{ $estadisticas2->enviado_lima }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAtendido">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            ATENDIDO: {{ $estadisticas2->atendidos }}
                        </span>
                    </span>
                </button>
            </div>
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNoatendido">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            PENDIENTES: {{ $estadisticas2->no_atendidos }}
                        </span>
                    </span>
                </button>
            </div>
        </div> --}}
    </div>

    

    <div class="card">
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <i class="fa-solid fa-user"></i> Informatica
                                </th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE")
                                    <tr class="align-middle" style="font-size: 10px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white" wire:click="filtrarAtendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <div class="form-control form-control-xs text-end">{{ $item->atendidos }}</div>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-danger text-white" wire:click="filtrarNoatendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendientes
                                                    </button>
                                                    <div class="form-control form-control-xs text-end">{{ $item->no_atendidos }}</div>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white" wire:click="filtrarEnviadolima('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-envelope me-1"></i>Lima
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-2">{{ $item->enviado_lima }}</div>
                                                    <a type="button" class="btn btn-dark" href="{{ route('pdf.informatica.atencion-por-usuario-acta', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                        <i class="fa-solid fa-print me-1"></i>Reporte
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <i class="fa-solid fa-user"></i> Digitalizadores
                                </th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "TERCERO")
                                    <tr class="align-middle" style="font-size: 10px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white" wire:click="filtrarAtendido('{{ $item->created_user}}')">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-1">{{ $item->atendidos }}</div>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-file-pdf me-1"></i>Folios
                                                    </button>
                                                    <div class="form-control form-control-xs text-end me-2">{{ $item->digitalizado }}</div>
                                                    <a type="button" class="btn btn-dark" href="{{ route('pdf.informatica.atencion-por-usuario-acta2', ['dni' => $item->atendido_por_dni,'anio' => $filtro_anio, 'mes' => $filtro_mes]) }}" target="_blank">
                                                        <i class="fa-solid fa-print me-1"></i>Reporte
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}

            <div class="table-responsive-xl">
                <div class="row g-3 mb-2">                      
                    {{-- <div class="col-lg-2 col-sm-12">
                        <div class="input-group">
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#filtroModal">
                                <i class="fa-solid fa-filter"></i> Filtrar por:
                            </button>
                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                    <input type="text" name="search" id="search" class="form-control form-control-sm me-1 fw-bold is-valid" placeholder="INGRESE SU DNI" wire:model.live="search" required>
                                </div>
                                @error('dni')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-10">
                                <label class="form-control form-control-sm me-1 fw-bold">{{ $datos . ' | ' . $sededestino . ' | ' . $dependenciadestino }}</label>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-6">
                        <fieldset class="border p-3 rounded mb-3" disabled>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6 col-sm-12">      
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_dni" class="fw-bold fs-6">DNI</label>
                                            <div class="input-group">
                                                <input type="text" id="txt_dni" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror bg-light" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_nombres" class="fw-bold fs-6">Nombres</label>
                                            <input type="text" id="txt_nombres" class="form-control form-control-xs text-uppercase bg-light" placeholder="Nombres" wire:model="nombres" readonly>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_appaterno" class="fw-bold fs-6">Apellido paterno</label>
                                            <input type="text" id="txt_appaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido paterno" wire:model="appaterno" readonly>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_apmaterno" class="fw-bold fs-6">Apellido materno</label>
                                            <input type="text" id="txt_apmaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido materno" wire:model="apmaterno" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                                            <input type="text" id="txt_celular_personal" class="form-control form-control-xs bg-light" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)" readonly>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
                                            <input type="text" id="txtcelular_institucional" class="form-control form-control-xs bg-light" wire:model="celinstitucional" readonly>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txt_correo_personal" class="fw-bold fs-6">Email personal</label>
                                            <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase bg-light" placeholder="Correo personal" wire:model="correopersonal" readonly>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                            <label for="txtcorreo_institucional" class="fw-bold fs-6">Email institucional</label>
                                            <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase bg-light" wire:model="correoinstitucional" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div> --}}
                    {{-- <div class="col-xl-6">
                        <fieldset class="border p-3 rounded mb-3" disabled>
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-sm-12">
                                    <label for="txt_sede" class="fw-bold fs-6">Sede</label>
                                    <div class="input-group">
                                        <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="sedeorigen" readonly required>
                                    </div>
                                    @error('sedeorigen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <label for="txt_dependencia" class="fw-bold fs-6">Dependencia</label>
                                    <div class="input-group position-relative">
                                        <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen" readonly required>
                                    </div>
                                    @error('dependenciaorigen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-6 col-sm-12">
                                    <label for="txt_despacho" class="fw-bold fs-6">Despacho</label>
                                    <div class="input-group position-relative">
                                        <input type="text" id="txt_despacho" class="form-control form-control-xs bg-light" wire:model="despachoorigen" readonly required>
                                    </div>
                                    @error('despachoorigen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-sm-12">
                                    <label for="regimen276" class="fw-bold fs-6">Regimen</label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" id="regimen276" name="regimen" class="btn-check" value="D.L.276" autocomplete="off" wire:model.live="regimen">
                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen276">D.L.276</label>

                                        <input type="radio" id="regimen728" name="regimen" class="btn-check" value="D.L.728" autocomplete="off" wire:model.live="regimen">
                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimen728">D.L.728</label>

                                        <input type="radio" id="regimenCAS" name="regimen" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen">
                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="regimenCAS">CAS</label>
                                    </div>
                                    @error('regimen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 col-sm-12">
                                    <label for="tiporegimen" class="fw-bold fs-6">Tipo</label>
                                    <select id="tiporegimen" class="form-select form-select-xs" wire:model.live="tipo_regimen">
                                        <option value="">Seleccionar...</option>
                                        <option value="INDETERMINADO">INDETERMINADO</option>
                                        <option value="TRANSITORIO">TRANSITORIO</option>
                                        <option value="SUPLENCIA">SUPLENCIA</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-12">
                                    <label for="txt_cargo" class="fw-bold fs-6">Cargo</label>
                                    <div class="input-group">
                                        <input type="text" id="txt_cargo" class="form-control form-control-xs bg-light" wire:model="cargo" readonly required>
                                    </div>
                                    @error('cargo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-6 col-sm-12">
                                    <label for="cargo_condicion" class="fw-bold fs-6">Condición</label>
                                    <select id="cargo_condicion" class="form-select form-select-xs" wire:model.live="cargo_condicion">
                                        <option value="">Seleccionar...</option>
                                        <option value="TITULAR">TITULAR</option>
                                        <option value="PROVINCIAL">PROVISIONAL</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div> --}}
                    <div class="col-xl-12">
                        <fieldset class="border p-3 rounded mb-3">
                            <div class="row">                      
                                <div class="col-xl-4">
                                    <label for="txtservicio" class="fw-bold fs-6">SERVICIO</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="servicioBuscar">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                        </button>
                                        <input type="text" id="txtservicio" class="form-control form-control-xs bg-light" wire:model="servicio" readonly required>
                                    </div>
                                    @error('servicio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-8">
                                    <label for="txtdetalle_servicio" class="fw-bold fs-6">SOLICITUD / INCIDENCIA</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="servicioDetalleBuscar">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                        </button>
                                        <input type="text" id="txtdetalle_servicio" class="form-control form-control-xs bg-light" wire:model="detalle_servicio" readonly required>
                                    </div>
                                    @error('detalle_servicio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label for="txtcod" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs {{ $mostrarcontroles }}" wire:click="bienesBuscar">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar bienes
                                                </button>
                                                <input type="text" id="txtcod" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod" readonly >
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtcodpatrimonial" class="fw-bold fs-6 {{ $mostrarcontroles }}">COD_PATRIMONIAL</label>
                                            <div class="input-group">
                                                {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Cod. Patrimonial</span> --}}
                                                <input type="text" id="txtcodpatrimonial" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="cod_patrimonial" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="txtequipo" class="fw-bold fs-6 {{ $mostrarcontroles }}">BIEN INFORMATICO</label>
                                            <div class="input-group">
                                                {{-- <span class="input-group-text input-group-text-xs {{ $mostrarcontroles }}" id="basic-addon1">Bien</span> --}}
                                                <input type="text" id="txtequipo" class="form-control form-control-xs {{ $mostrarcontroles }} bg-light is-valid" wire:model="datos_bien" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="txtip" class="fw-bold fs-6 {{ $mostrarcontroles }}">IP</label>
                                            <input type="text" id="txtip" class="form-control form-control-xs {{ $mostrarcontroles }} is-valid" wire:model.defer="bien_ip" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" readonly>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-12 mt-3">
                                    <label for="txtobservacion" class="fw-bold fs-6">ESPECIFICAR EL DETALLE DEL PROBLEMA PARA BRINDARLE EL SOPORTE ADECUADO</label>
                                    <div class="input-group input-group">
                                        <input type="text" id="txtobservacion" class="form-control form-control-xs text-uppercase is-valid" wire:model="detalle_problema">
                                    </div>
                                </div>
                                {{-- <div class="col-xl-4">
                                    <label for="txtobservacion" class="fw-bold fs-6">CARGAR EVIDENCIA</label>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                            @if ($ruta_evidencia)
                                                <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_evidencia) }}" target="_blank">
                                                    <i class="fa-solid fa-file-pdf"></i> Ver Evidencia
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>--}}

                                <div class="col-xl-12 mt-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                                <input type="text" name="search" id="search" class="form-control form-control-sm me-1 fw-bold is-valid" placeholder="INGRESE SU DNI" wire:model.live="search" required>
                                            </div>
                                            @error('dni')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-xl-10">
                                            <label class="form-control form-control-sm me-1 fw-bold">{{ $datos . ' | ' . $sededestino . ' | ' . $dependenciadestino }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 text-end">
                                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 mt-3" wire:click="guardar">
                                        <i class="fa-solid fa-floppy-disk"></i><br> Guardar
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#TICKET</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> SOLICITANTE
                            </th>
                            {{-- <th scope="col">REGIMEN - CARGO</th> --}}
                            {{-- <th scope="col" class="table-danger">TIPO</th> --}}
                            <th scope="col" class="bg-success-subtle">MEDIO</th>
                            <th scope="col" class="bg-success-subtle">TIPO</th>
                            <th scope="col" class="bg-success-subtle">DESCRIPCIÓN DEL SERVICIO</th>
                            <th scope="col" class="bg-success-subtle">SOLUCIÓN</th>                     
                            <th scope="col" class="bg-success-subtle">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" colspan="3" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-ticket"></i> {{ $item->id }}
                                </th>
                                <td>
                                    <b>{{ $item->dni }}</b>
                                    <br> {{ $item->datos }}
                                    <br>{{ $item->created_at }}
                                </td>
                                {{-- <td>
                                    <b>{{ $item->regimen }}</b>
                                    <br>
                                    {{ $item->cargo }}
                                </td> --}}
                                {{-- <td>
                                    <b>SEDE: </b>{{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO: </b>{{ $item->despachodestino }}
                                </td> --}}
                                <td class="text-center align-middle">
                                    @if ($item->reportado_por === "CEA")
                                        <b>CEA</b>
                                    @elseif (($item->reportado_por === "CORREO"))
                                        <i class="fa-solid fa-envelope"></i>
                                    @elseif (($item->reportado_por === "DOCUMENTO"))
                                        <i class="fa-solid fa-file"></i>
                                    @elseif (($item->reportado_por === "GESTION"))
                                        <i class="fa-brands fa-black-tie"></i>
                                    @elseif (($item->reportado_por === "LLAMADA"))
                                        <i class="fa-solid fa-phone"></i>
                                    @elseif (($item->reportado_por === "PERSONALMENTE"))
                                        <i class="fa-solid fa-user"></i>
                                    @elseif (($item->reportado_por === "SISTEMA"))
                                        <i class="fa-brands fa-windows"></i>
                                    @elseif (($item->reportado_por === "WHATSAPP"))
                                        <i class="fa-brands fa-whatsapp"></i>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge py-1 rounded-pill {{ $item->solicitud_incidencia == 'INCIDENCIA' ? 'bg-primary-subtle text-primary' : 'bg-dark-subtle text-dark' }}">
                                        {{ $item->solicitud_incidencia }}
                                    </span>
                                </td>
                                <td>
                                    <b>TIPO: </b>{{ $item->solicitud_incidencia }}
                                    <br>
                                    <b>SERVICIO: </b> {{ $item->servicio }}
                                    <br>
                                    <b>DESCRIPCIÓN: </b>{{ $item->detalle_servicio }}
                                </td>
                                <td>
                                    {{ $item->respuesta }}
                                </td>
                                <td class="text-center align-middle">
                                    @php
                                        $estadoAtendido = match($item->atendido) {
                                            'SI' => ['clase' => 'bg-success-subtle text-success', 'texto' => 'ATENDIDO'],
                                            'NO' => ['clase' => 'bg-danger-subtle text-danger', 'texto' => 'NO ATENDIDO'],
                                            default => ['clase' => 'bg-warning-subtle text-warning', 'texto' => 'REGISTRADO'],
                                        };
                                    @endphp
                                    <span class="badge py-1 rounded-pill {{ $estadoAtendido['clase'] }}">
                                        {{ $estadoAtendido['texto'] }}
                                    </span>
                                </td>
                                <td class="text-center align-middle small text-nowrap">
                                    {{ $item->atendido_por_datos}}
                                    <br>
                                    <b>{{ $item->created_at }}</b>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        {{-- @if ($item->created_user === auth()->user()->datos || auth()->user()->hasRole('Admin-Super'))
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button> 
                                        @endif
                                        @can('mpfn.intranet.atenciones.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan --}}
                                    </div>
                                </td>
                                <td class="text-stard">
                                    <div class="btn-group" role="group">
                                        {{-- @if (!empty($item->id))
                                            <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.atencion-acta', ['id' => $item->id]) }}" target="_blank">
                                                <i class="fa-solid fa-file-pdf"></i><br>Acta
                                            </a>
                                        @endif

                                        @if ($item->created_user === auth()->user()->datos || auth()->user()->hasRole('Admin-Super'))
                                            <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item->id }})">
                                                <i class="fa-solid fa-upload"></i><br>Cargar
                                            </button>
                                        @endif
                                        @if($item->ruta_documento)
                                            <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-file-signature"></i><br> Firmado
                                            </a>
                                        @endif --}}
                                    </div>
                                </td>
                                <td class="text-stard">
                                    {{-- <div class="btn-group" role="group">
                                        @if($item->ruta_evidencia)
                                            <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_evidencia) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-receipt"></i><br> Evidencia
                                            </a>
                                        @endif
                                    </div> --}}
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
                    <tfoot>
                        <tr>
                            <td colspan="13">
                                {{ $lista_activos->links() }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Barra de paginación flotante con total --}}
    {{-- <div class="pagination-floating position-fixed bottom-0 start-50 translate-middle-x bg-white border-top shadow-sm py-2 px-4 w-100 w-md-auto" style="z-index: 1050;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-muted small">
                <strong>Total de registros:</strong> {{ $lista_atenciones->total() }}
            </div>
            <div class="d-inline-block">
                {{ $lista_atenciones->links() }}
            </div>
        </div>
    </div> --}}

    {{-- Flotante - paginación --}}
    {{-- <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
    </div> --}}

    <div>
        {{-- MODAL BUSCAR SERVICIO --}}
        <div class="modal fade @if($modalInformaticaServicioBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="buscar-servicio-componentLabel">
                            BUSCAR SERVICIO
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="txtSearchServicio" class="form-control form-control-sm mb-2" placeholder="Buscar por incidencia o solicitud" wire:model.live="searchservicios" >
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
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_servicio({{ $item->id }})">
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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL BUSCAR INCIDENCIAS / SOLICITUDES --}}
        <div class="modal fade @if($modalInformaticaServicioDetalleBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-secondary-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            BUSCAR INCIDENCIAS / SOLICITUDES
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="txtSearchServicioDetalle" class="form-control form-control-sm mb-2" placeholder="Buscar por detalle incidencia o solicitud" wire:model.live="searchincidenciasolicitud">
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
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="agregar_incidencia_solicitud({{ $item2->id }})">
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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL BUSCAR BIENES PATRIMONIALES --}}
        @include('livewire.partials.modales.buscar-patrimonio-bienes')
        
        {{-- MODAL CARGAR PDF --}}
        @include('livewire.intranet.atenciones.partials.pdf-cargar-component')
    </div>

</div>
