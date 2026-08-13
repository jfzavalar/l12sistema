<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-users-between-lines"></i> PERSONAL
        </h1>
        <div class="row">
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                    <span class="alert alert-primary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            PERSONAL: {{ $estadisticas->total }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFiscales">
                    <span class="alert alert-secondary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            FISCALES: {{ $estadisticas->fiscales}}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFSuperior">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            F.Superior: {{ $estadisticas->fsuperior }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFProvincial">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            F.Provincial: {{ $estadisticas->fprovincial }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFASuperior">
                    <span class="alert alert-info d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            F.A.Superior: {{ $estadisticas->fasuperior }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFAProvincial">
                    <span class="alert alert-warning d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            F.A.Provincial: {{ $estadisticas->faprovincial }}
                        </span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-lg-1 col-sm-12">
                        <div class="input-group">
                            <button type="button" class="btn btn-dark btn-sm" wire:click="reportesFiltros">
                                <i class="fa-solid fa-filter"></i> Filtrar por:
                            </button>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                        </div>
                    </div>
                    <div class="col-xl-3 text-end">
                        @can('mpfn.rrhh.personal.create')
                            <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo personal
                            </button>
                        @endcan
                        @can('mpfn.rrhh.personal.edit')
                            <button type="button" id="btnnuevo" class="btn btn-danger btn-sm" wire:click="licencias_listar">
                                <i class="fa-solid fa-ban"></i> Licencias
                            </button>
                            <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" wire:click="renuncias_listar">
                                <i class="fa-solid fa-ban"></i> Renuncias
                            </button>
                        @endcan
                    </div>
                </div>
                
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col">DEPENDENCIA ORIGEN</th>
                            <th scope="col">REGIMEN - CARGO</th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" colspan="2" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    DNI: {{ $item->dni }}
                                    <br>
                                    {{ $item->datos }}
                                </th>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>SEDE:</b> {{ $item->sedeorigen }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                </td>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>REGIMEN:</b> {{ $item->regimen }}
                                    <br>
                                    <b>CARGO:</b> {{ $item->cargo }}
                                </td>
                                <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                    <b>SEDE:</b> {{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO:</b> {{ $item->despachodestino }}
                                    <br>
                                    {{-- <b>De:</b>
                                    <b>Hasta:</b> --}}
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
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @can('mpfn.rrhh.personal.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        @can('mpfn.rrhh.personal.create')
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-xs dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                </button>

                                                <ul class="dropdown-menu">

                                                    @if ($item->tipo_documento === "CONTRATO")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_adenda({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Adenda
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Licencia
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li>                                                       

                                                    @elseif($item->tipo_documento === "LICENCIA")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_contrato({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Contrato
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Incorporación
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li>

                                                    @elseif($item->tipo_documento === "ADENDA")

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_adenda({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Adenda
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Licencia
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_renuncia({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Renuncia
                                                            </button>
                                                        </li> 

                                                    @else

                                                        <li>
                                                            <button class="dropdown-item text-dark"
                                                                    wire:click="nuevo_contrato({{ $item->id }})">
                                                                <i class="fa-solid fa-file"></i> Contrato
                                                            </button>
                                                        </li>

                                                    @endif

                                                </ul>
                                            </div>
                                        @endcan
                                        <button type="button" class="btn btn-outline-info btn-xs" data-bs-toggle="modal" data-bs-target="#historialModal" wire:click="historial_documentos('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-eye"></i><br>Ver
                                        </button> --}}
                                        @can('mpfn.rrhh.personal.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-dark btn-xs" wire:click="legajos1('{{ $item->dni }}','{{ $item->datos }}')">
                                            <i class="fa-solid fa-file-zipper"></i>Legajos
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">{{ $lista_activos->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div>
        {{-- Modal Nuevo-Editar --}}
        <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="cerrar"></button>
                    </div>
                    <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-xl-2 col-sm-12">
                                    <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }}>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                        @if ($foto)
                                            <img src="{{ $foto->temporaryUrl() }}" width="150">
                                        @elseif($fotoactual)
                                            <img src="{{ asset('storage/'.$fotoactual) }}" width="150">
                                        @else
                                            <img src="{{ asset('img/perfil.jpg') }}" width="150">
                                        @endif
                                        <div class="col-lg-12">
                                            <input type="file" id="fileimagen" class="form-control form-control-xs {{ $mostrarcargafoto }}" accept=".jpg,.jpeg,image/jpeg" wire:model="foto" wire:key="file-{{ $inputFileKey }}">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xl-10 col-sm-12">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-6 col-sm-12">      
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="txt_dni" class="fw-bold fs-6">DNI</label>
                                                                <input type="text" id="txt_dni" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror">
                                                                @error('dni')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="txt_nombres" class="fw-bold fs-6">Nombres</label>
                                                                <input type="text" id="txt_nombres" class="form-control form-control-xs text-uppercase" placeholder="Nombres " wire:model="nombres">
                                                                @error('nombres')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-lg-6 col-sm-12">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="txt_appaterno" class="fw-bold fs-6">Apellido paterno</label>
                                                                <input type="text" id="txt_appaterno" class="form-control form-control-xs text-uppercase" placeholder="Apellido paterno" wire:model="appaterno">
                                                                @error('appaterno')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="txt_apmaterno" class="fw-bold fs-6">Apellido materno</label>
                                                                <input type="text" id="txt_apmaterno" class="form-control form-control-xs text-uppercase" placeholder="Apellido materno" wire:model="apmaterno">
                                                                @error('apmaterno')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-6 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-sm-12">
                                                                <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                                                                <input type="text" id="txt_celular_personal" class="form-control form-control-xs" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)">
                                                            </div>

                                                            <div class="col-xl-6 col-lg-6 col-sm-12">
                                                                <label for="txt_correo_personal" class="fw-bold fs-6">Correo personal</label>
                                                                <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase" placeholder="Correo personal" wire:model="correopersonal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-8">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
                                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_sede" class="fw-bold fs-6">Sede</label>
                                                            <div class="input-group">
                                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="sedeBuscar">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                </button>
                                                                <input type="text" id="txt_sede" class="form-control form-control-xs bg-light" wire:model="sedeorigen" readonly required>
                                                            </div>
                                                            @error('sedeorigen')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-sm-12">
                                                            <label for="txt_dependencia" class="fw-bold fs-6">Dependencia</label>
                                                            <div class="input-group position-relative">
                                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="dependenciaBuscar">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                </button>
                                                                <input type="text" id="txt_dependencia" class="form-control form-control-xs bg-light" wire:model="dependenciaorigen" readonly required>
                                                            </div>
                                                            @error('dependenciaorigen')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_despacho" class="fw-bold fs-6">Despacho</label>
                                                            <div class="input-group position-relative">
                                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="despachoBuscar">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                </button>
                                                                <input type="text" id="txt_despacho" class="form-control form-control-xs bg-light" wire:model="despachoorigen" readonly required>
                                                            </div>
                                                            @error('despachoorigen')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-sm-12">
                                                            <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
                                                            <input type="text" id="txtcelular_institucional" class="form-control form-control-xs" wire:model="celinstitucional">
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-sm-12">
                                                            <label for="txtcorreo_institucional" class="fw-bold fs-6">Correo institucional</label>
                                                            <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase" wire:model="correoinstitucional">
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
                                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" wire:click="cargoBuscar">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                </button>
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
                                                                <option value="PROVISIONAL">PROVISIONAL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <fieldset class="border p-3 rounded mb-3">
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS CONTRATO / ADENDA / RENUNCIA</legend>
                                        <div class="row">
                                            <div class="col-xl-2 col-sm-12">
                                                <label for="txtconvocatoria" class="fw-bold fs-6">N° de convocatoria</label>
                                                <input type="text" id="txtconvocatoria" class="form-control form-control-xs text-uppercase" wire:model="numero_convocatoria">
                                            </div>
                                            <div class="col-xl-2 col-sm-12">
                                                <label for="txttipodocumento" class="fw-bold fs-6">Tipo de documento</label>
                                                <input type="text" id="txttipodocumento" class="form-control form-control-xs" wire:model="tipo_documento" disabled>
                                            </div>
                                            <div class="col-xl-2 col-sm-12">
                                                <label for="txtfechainiciocontrato" class="fw-bold fs-6">Fecha de inicio</label>
                                                <input type="date" id="txtfechainiciocontrato" class="form-control form-control-xs" wire:model="fecha_inicio">
                                                @error('fecha_inicio')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-xl-2 col-sm-12">
                                                <label for="txtfechafincontrato" class="fw-bold fs-6">Fecha de fin</label>
                                                <input type="date" id="txtfechafincontrato" class="form-control form-control-xs" wire:model="fecha_fin">
                                                @error('fecha_fin')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xl-4 col-sm-12">
                                                <label for="filecontrato" class="fw-bold fs-6">Contrato</label>
                                                <div class="input-group">
                                                    <button class="btn btn-outline-dark btn-xs" type="button" id="btnimprimircontrato">
                                                        <i class="fa-solid fa-print"></i> Imprimir
                                                    </button>
                                                    <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                                    {{-- <button class="btn btn-outline-warning btn-xs" type="button" id="btncargarcontrato">
                                                        <i class="fa-solid fa-arrow-up-from-bracket"></i> Cargar
                                                    </button> --}}
                                                    @if ($ruta_documento)
                                                        <a class="btn btn-{{ $colorAgregar }} btn-xs" type="button" id="btnverevidencia" href="{{ asset('storage/'.$ruta_documento) }}" target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i> Ver firmado
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }}
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                                <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL FILTRO - REPORTES -->
        <div class="modal fade @if($modalReportesFiltros) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="filtroModalLabel">
                            <i class="fa-solid fa-filter"></i> FILTROS - REPORTE : Total: {{ $lista_activos->total() }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold bg-danger-subtle text-danger" id="basic-addon1">Filtrar por sede:</span>
                                    <select id="filtrosede2" class="form-select form-select-sm" wire:model.live="filtrosede">
                                        <option value="">TOTAL </option>
                                        @foreach ($lista_sedes as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold bg-danger-subtle text-danger" id="basic-addon1">Por dependencia:</span>
                                    <select id="filtrodependencia2" class="form-select form-select-sm" wire:model.live="filtrodependencia">
                                        <option value="">TOTAL </option>
                                        @foreach ($lista_dependencias as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Por régimen:</span>
                                    <select id="filtroregimen2" class="form-select form-select-sm" wire:model.live="filtroregimen">
                                        <option value="">TOTAL </option>
                                        <option value="CAS">CAS </option>
                                        <option value="D.L.276">D.L.276</option>
                                        <option value="D.L.728">D.L.728 </option>
                                    </select>
                                    {{-- <span class="input-group-text" id="basic-addon2">{{ $lista_activos->total() }}</span> --}}
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Por cargo:</span>
                                    <select id="filtrocargo2" class="form-select form-select-sm" wire:model.live="filtrocargo">
                                        <option value="">TOTAL </option>
                                        <option value="CONTRATO">CONTRATO </option>
                                        @foreach ($lista_cargos2 as $item)
                                            <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-naranja btn-sm" wire:click="resetFiltros">
                            <i class="fa-solid fa-eraser"></i> Limpiar
                        </button>
                        <button class="btn btn-success btn-sm" wire:click="exportarExcel">
                            <i class="fa fa-file-pdf"></i> Exporta a Excel
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrarBuscar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL HISTORIAL --}}
        <div class="modal fade @if($modalHistorial) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="historialModalLabel">
                            <i class="fa-solid fa-timeline"></i> HISTORIAL CONTRATOS: ADENDAS / LICENCIAS / RENUNCIAS
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="historial_documentos_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchhistorial" class="form-control form-control-sm" wire:model.live="searchhistorial" placeholder="Buscar por número de convocatoria">
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> PERSONAL
                                        </th>
                                        <th scope="col">DEPENDENCIA ORIGEN</th>
                                        <th scope="col" class="table-danger">UBICACIÓN FÍSICA</th>
                                        <th scope="col">REGIMEN - CARGO</th>
                                        <th scope="col">N° DE CONVOCATORIA</th>
                                        <th scope="col">DATOS</th>
                                        <th scope="col">INICIO</th>
                                        <th scope="col">FIN</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_historial as $item3)
                                        <tr>
                                            <th class="text-center">{{ $loop->iteration }}</th>
                                            <th>
                                                {{ $item3->dni }}
                                                <br>{{ $item3->datos }}
                                            </th>
                                            <td>
                                                <b>SEDE:</b> {{ $item3->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item3->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item3->despachoorigen }}
                                            </td>
                                            <td>
                                                <b>SEDE:</b> {{ $item3->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item3->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item3->despachodestino }}
                                            </td>
                                            <td>
                                                <b>REGIMEN:</b> {{ $item3->regimen }}
                                                <br>
                                                <b>CARGO:</b> {{ $item3->cargo }}
                                            </td>
                                            <td>{{ $item3->numero_convocatoria }}</td>
                                        
                                            <th class="@if(in_array($item3->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-primary
                                                        @elseif(in_array($item3->tipo_documento, ['LICENCIA','RENUNCIA'])) text-danger
                                                        @endif text-center">
                                                {{ $item3->tipo_documento }}
                                            </th>
                                            <td>{{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($item3->fecha_fin)->format('d/m/Y') }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="historial_editar('{{ $item3->personal_id }}')">
                                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                        </button>
                                                    @endcan
                                                    @can('mpfn.rrhh.personal.edit')
                                                        <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item3->personal_id }})">
                                                            <i class="fa-solid fa-upload"></i><br>Cargar
                                                        </button>
                                                    @endcan
                                                    
                                                    @if($item3->ruta_documento)
                                                        <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item3->ruta_documento) }}" target="_blank">
                                                            <i class="fa-solid fa-file-signature"></i><br> Firmado
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10">{{ $lista_historial->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="historial_documentos_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Inactivos --}}

        {{-- MODAL LICENCIAS --}}
        <div class="modal fade @if($modalLicenciasListar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-danger-subtle">
                        <h1 class="modal-title fs-5" id="licenciasModalLabel">
                            <i class="fa-solid fa-list"></i> LICENCIAS
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="licencias_listar_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchlicencias" placeholder="Buscar">
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> DNI - PERSONAL
                                        </th>
                                        <th scope="col">DEPENDENCIA ORIGEN</th>
                                        <th scope="col">REGIMEN - CARGO</th>
                                        <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                                        <th scope="col">CONDICIÓN</th>
                                        <th scope="col" colspan="2" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                                        {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_licencias as $item)
                                        <tr>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                DNI: {{ $item->dni }}
                                                <br>
                                                {{ $item->datos }}
                                            </th>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>REGIMEN:</b> {{ $item->regimen }}
                                                <br>
                                                <b>CARGO:</b> {{ $item->cargo }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachodestino }}
                                                <br>
                                                <b>De:</b>
                                                <b>Hasta:</b>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                                    @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                                        text-bg-danger
                                                    @endif">
                                                    {{ $item->tipo_documento }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                        </button>
                                                    @endcan
                                                    @can('mpfn.rrhh.personal.create')
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                                    type="button" 
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false">
                                                                <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                @if ($item->tipo_documento === "CONTRATO")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>                                                       

                                                                @elseif($item->tipo_documento === "LICENCIA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Incorporación
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>

                                                                @elseif($item->tipo_documento === "ADENDA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li> 

                                                                @else

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                @endif

                                                            </ul>
                                                        </div>
                                                    @endcan
                                                    {{-- <button type="button" class="btn btn-outline-warning btn-xs" wire:click="historial_documentos('{{ $item->dni }}')">
                                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                                    </button> --}}
                                                    {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-eye"></i><br>Ver
                                                    </button> --}}
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10">{{ $lista_licencias->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="licencias_listar_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>  
        
        {{-- MODAL RENUNCIAS --}}
        <div class="modal fade @if($modalRenunciasListar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h1 class="modal-title fs-5" id="licenciasModalLabel">
                            <i class="fa-solid fa-list"></i> RENUNCIAS
                        </h1>
                        <button type="button" class="btn-close btn-close-white" aria-label="Close" wire:click="renuncias_listar_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchlicencias" placeholder="Buscar">
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> DNI - PERSONAL
                                        </th>
                                        <th scope="col">DEPENDENCIA ORIGEN</th>
                                        <th scope="col">REGIMEN - CARGO</th>
                                        <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                                        <th scope="col">CONDICIÓN</th>
                                        <th scope="col" colspan="2" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                                        {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_renuncias as $item)
                                        <tr>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>{{ $loop->iteration }}</th>
                                            <th @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                DNI: {{ $item->dni }}
                                                <br>
                                                {{ $item->datos }}
                                            </th>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sedeorigen }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachoorigen }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>REGIMEN:</b> {{ $item->regimen }}
                                                <br>
                                                <b>CARGO:</b> {{ $item->cargo }}
                                            </td>
                                            <td @class(['text-danger' => $item->tipo_documento == 'RENUNCIA'])>
                                                <b>SEDE:</b> {{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO:</b> {{ $item->despachodestino }}
                                                <br>
                                                <b>De:</b>
                                                <b>Hasta:</b>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION'])) text-bg-primary
                                                    @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                                        text-bg-danger
                                                    @endif">
                                                    {{ $item->tipo_documento }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                        </button>
                                                    @endcan
                                                    @can('mpfn.rrhh.personal.create')
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" 
                                                                    type="button" 
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false">
                                                                <i class="fa-solid fa-list"></i></i> <i class="fa-solid fa-newspaper"></i><br>Trámite
                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                @if ($item->tipo_documento === "CONTRATO")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>                                                       

                                                                @elseif($item->tipo_documento === "LICENCIA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_incorporacion({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Incorporación
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li>

                                                                @elseif($item->tipo_documento === "ADENDA")

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_adenda({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Adenda
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_licencia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Licencia
                                                                        </button>
                                                                    </li>

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_renuncia({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Renuncia
                                                                        </button>
                                                                    </li> 

                                                                @else

                                                                    <li>
                                                                        <button class="dropdown-item text-dark"
                                                                                wire:click="nuevo_contrato({{ $item->id }})">
                                                                            <i class="fa-solid fa-file"></i> Contrato
                                                                        </button>
                                                                    </li>

                                                                @endif

                                                            </ul>
                                                        </div>
                                                    @endcan
                                                    {{-- <button type="button" class="btn btn-outline-warning btn-xs" wire:click="historial_documentos('{{ $item->dni }}')">
                                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                                    </button> --}}
                                                    {{-- <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#verDetallesModal" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-eye"></i><br>Ver
                                                    </button> --}}
                                                    @can('mpfn.rrhh.personal.destroy')
                                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10">{{ $lista_licencias->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="renuncias_listar_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Modal Detalles de persona personal -->
        <div wire:ignore.self class="modal fade" id="verDetallesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="verDetallesModalLabel"><i class="fa-solid fa-file-lines"></i> DETALLE: PERSONA - PERSONAL</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div>
                            <div class="col-xl-9 col-sm-12">
                                <fieldset class="border p-3 rounded mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                    @include('livewire.rrhh.personal.partials.datos-personales-component')
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <fieldset class="border p-3 rounded mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                    @include('livewire.rrhh.personal.partials.datos-institucionales-component')
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS CONTRATO / ADENDA / RENUNCIA</legend>
                                    <table class="table table-striped table-hover table-sm table-xsmall">
                                        <thead class="table-dark text-center align-middle">
                                            <tr>
                                                <th scope="col">#</th>
                                                {{-- <th scope="col">
                                                    <i class="fa-solid fa-user"></i> PERSONAL
                                                </th> --}}
                                                <th scope="col">DEPENDENCIA ORIGEN</th>
                                                {{-- <th scope="col">UBICACIÓN FÍSICA</th> --}}
                                                <th scope="col">REGIMEN</th>
                                                <th scope="col">CARGO</th>
                                                <th scope="col">N° DE CONVOCATORIA</th>
                                                <th scope="col">DATOS</th>
                                                {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                            @forelse ($lista_historial as $item3)
                                                <tr>
                                                    <th class="text-center">{{ $loop->iteration }}</th>
                                                    {{-- <th>
                                                        {{ $item3->dni }}
                                                        <br>{{ $item3->datos }}
                                                    </th> --}}
                                                    <td>
                                                        <b>SEDE:</b> {{ $item3->sedeorigen }}
                                                        <br>
                                                        <b>DEPENDENCIA:</b> {{ $item3->dependenciaorigen }}
                                                        <br>
                                                        <b>DESPACHO:</b> {{ $item3->despachoorigen }}
                                                    </td>
                                                    {{-- <td>
                                                        <b>SEDE:</b> {{ $item3->sededestino }}
                                                        <br>
                                                        <b>DEPENDENCIA:</b> {{ $item3->dependenciadestino }}
                                                        <br>
                                                        <b>DESPACHO:</b> {{ $item3->despachodestino }}
                                                    </td> --}}
                                                    <td>{{ $item3->regimen }}</td>
                                                    <td>{{ $item3->cargo }}</td>
                                                    <td>{{ $item3->numero_convocatoria }}</td>
                                                    <td class="@if($item3->tipo_documento == 'CONTRATO') text-success
                                                                @elseif($item3->tipo_documento == 'LICENCIA') text-danger
                                                                @elseif($item3->tipo_documento == 'RENUNCIA') text-danger
                                                                @elseif($item3->tipo_documento == 'ADENDA') text-primary
                                                                @endif">
                                                        {{ $item3->tipo_documento }}
                                                        <br>
                                                        {{ \Carbon\Carbon::parse($item3->fecha_inicio)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($item3->fecha_fin)->format('d/m/Y') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        <div class="alert alert-danger" role="alert">
                                                            ¡No se encontraron resultados!
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a type="button" href="{{ route('pdf.rrhh.personal.reportePDF') }}" target="_blank" class="btn btn-naranja btn-sm">
                            <i class="fa-regular fa-file-pdf"></i> PDF
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL LEGAJOS --}}
        <div class="modal fade @if($modalLegajos) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> LEGAJOS: {{ $datos }}
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="legajos_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text fw-bold" id="basic-addon2">Total: </span>
                                        <input type="text" id="txtsearchusuario2" class="form-control form-control-sm" wire:model.live="searchhistoriallegajos" placeholder="Buscar por DNI, Apellidos y Nombres o Anexo">
                                        @can('mpfn.rrhh.personal.legajos.create',)
                                            <button type="button" class="btn btn-primary btn-sm" wire:click="nuevo_pdf">
                                                <i class="fa-solid fa-file"></i> Nuevo
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
                                        <th scope="col">REGIMEN - CARGO</th>
                                        {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                                        <th scope="col">DEPENDENCIA</th>
                                        <th scope="col" class="table-success">MOTIVO</th>
                                        <th scope="col" class="table-success">TITULO DOCUMENTO</th>
                                        <th scope="col" class="table-success">FECHA</th>
                                        <th scope="col" class="table-dark" colspan="1" ><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_legajos as $item)
                                        <tr>
                                            <th>
                                                <i class="fa-solid fa-phone-volume me-1"></i>{{ $loop->iteration }}
                                            </th>
                                            <td>
                                                <b>{{ $item->dni }}</b>
                                                <br> {{ $item->datos }}
                                                <br>{{ $item->created_at }}
                                            </td>
                                            <td>
                                                <b>{{ $item->regimen }}</b>
                                                <br>
                                                {{ $item->cargo }}
                                            </td>
                                            <td>
                                                <b>SEDE: </b>{{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO: </b>{{ $item->despachodestino }}
                                            </td>
                                            <td>
                                                {{ $item->motivo }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->titulodocumento }}
                                            </td>
                                            <td>{{ $item->fechaemision }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    {{-- <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button> --}}
                                                    @if($item->ruta_legajo)
                                                        <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_legajo) }}" target="_blank">
                                                            <i class="fa-solid fa-eye"></i><br> Documento
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        {{-- <td colspan="8">{{ $lista_activos->links() }}</td> --}}
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="legajos_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        
        
        {{-- MODAL CARGAR PDF --}}
        <div class="modal fade @if($modalPDFCargarLegajo) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form wire:submit.prevent="guardar_pdf">
                        <div class="modal-header bg-warning-subtle">
                            <h1 class="modal-title fs-5" id="pdf-cargar-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> CARGAR LEGAJOS
                            </h1>
                            <button type="button" class="btn-close" wire:click="cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-3 rounded mb-3">
                                {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-warning">CARGA ACTA</legend> --}}
                                <div class="row">
                                    <div class="col-xl-6">
                                        <label for="motivo" class="fw-bold fs-6">MOTIVO:</label>
                                        <input type="text" id="motivo" class="form-control form-control-sm" wire:model="motivo" required>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="titulodocumento" class="fw-bold fs-6">TITULO DOCUMENTO:</label>
                                        <input type="text" id="titulodocumento" class="form-control form-control-sm" wire:model="titulodocumento" required>
                                    </div>
                                    <div class="col-xl-4">
                                        <label for="fechaemision" class="fw-bold fs-6">FECHA EMISIÓN:</label>
                                        <input type="date" id="fechaemision" class="form-control form-control-sm" wire:model="fechaemision" required>
                                    </div>
                                    <div class="col-xl-8">
                                        <label for="filecontrato" class="fw-bold fs-6">CARGAR PDF:</label>
                                        <input type="file" class="form-control form-control-xs" id="filecontrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept="application/pdf" wire:model="pdf_acta">
                                    </div>
                                </div>
                            </fieldset>      
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" wire:click = "cerrar">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{--MODAL BUSCAR PERSONAL --}}
        @include('livewire.partials.modales.buscar-personal-datos')

        {{-- MODALE BUSCAR SEDES-DEPENDENCIAS-DESPACHOS --}}
        @include('livewire.partials.modales.buscar-personal-sede-dependencia-despacho')
        
        {{-- MODAL BUSCAR CARGO --}}
        @include('livewire.partials.modales.buscar-personal-cargo')

        {{-- MODAL CARGAR PDF --}}
        @include('livewire.partials.modales.cargar-pdf-acta')
        @include('livewire.partials.modales.cargar-pdf-evidencia')


    </div>

</div>
