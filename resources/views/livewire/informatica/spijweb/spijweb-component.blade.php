<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-ticket"></i> SPIJWEB - CREDENCIALES
        </h1>
        <div class="row">
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                    <span class="alert alert-primary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            TOTAL: {{ $estadisticas->total }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarFormatos">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-file"></i>
                            FORMATOS: {{ $estadisticas->fasignados }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNoformatos">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-file"></i>
                            PENDIENTES: {{ $estadisticas->fpendientes }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarUsuario">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-user"></i>
                            USUARIOS: {{ $estadisticas->uasignados }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNousuario">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-user"></i>
                            PENDIENTES: {{ $estadisticas->upendientes }}
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
                            {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button> --}}
                            @can('mpfn.informatica.spijweb.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" wire:click="generarListaDeEntregaDeSpijweb">
                                    <i class="fa-solid fa-list"></i> Generar Año Fiscal
                                </button>
                            @endcan
                            {{-- @can('mpfn.rrhh.personal.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="generarGastosOperativos">
                                    <i class="fa-solid fa-file"></i> Genera Nuevo Año Fiscal
                                </button>
                            @endcan --}}
                            <button type="button" class="btn btn-dark btn-sm rounded-3" wire:click="licencias_listar">
                                <i class="fa-solid fa-list"></i> Licencias
                            </button>
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
                            <th scope="col">
                                CARGO - REGIMEN
                            </th>
                            <th scope="col" class="table-danger">UBICACIÓN FÍSICA</th>
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
                            <th scope="col">CONDICIÓN</th>
                            @can('mpfn.informatica.spijweb.create')
                                <th scope="col" class="table-success">FORMATOS</th>
                                <th scope="col" class="table-success">USUARIO Y CONTRASEÑA</th>
                            @endcan
                            <th scope="col" colspan="2" class="table-dark"><i class="fa-solid fa-gears"></i></th>
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
                                </th>
                                <th>
                                    {{ $item->cargo }}
                                    <br>
                                    {{ $item->regimen }}
                                </th>
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
                                @can('mpfn.informatica.spijweb.create')
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-{{ $item->enviarformatos === 'NO' ? 'danger' : 'info' }} btn-xs" wire:click="enviar_acta1({{ $item->id }})">
                                            <i class="fa-solid fa-envelope"></i><br>Enviar
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-{{ $item->enviarusuario === 'NO' ? 'danger' : 'info' }} btn-xs" wire:click="enviar_usuario1({{ $item->id }})">
                                            <i class="fa-solid fa-envelope"></i><br>Enviar
                                        </button>
                                    </td>
                                @endcan
                                @can('mpfn.informatica.spijweb.destroy')
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-success btn-xs">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        </div>
                                    </td>
                                @endcan
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.anexotelefonico-acta', ['id' => $item->id]) }}" target="_blank">
                                            <i class="fa-solid fa-file-pdf"></i><br>Acta
                                        </a> --}}
                                        @can('mpfn.informatica.spijweb.create')
                                            <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                                <i class="fa-solid fa-upload"></i><br>Cargar
                                            </button>
                                        @endcan
                                        @if($item->ruta_documento)
                                            <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-file-signature"></i><br> Firmado
                                            </a>
                                        @endif
                                    </div>
                                </td>
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

    <div>
        {{-- MODAL NUEVO EDITAR --}}
        <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
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
                                <div class="col-xl-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                                @include('livewire.partials.componentes.persona-datos')
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-6">
                                            <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
                                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                                @include('livewire.partials.componentes.personal-datos')
                                            </fieldset>
                                        </div>
                                        {{-- <div class="col-xl-2">
                                            <textarea id="textoCopiar" class="form-control" rows="10" style="font-size: 12px; white-space: nowrap; overflow-x: auto;" readonly>{{ $this->generarTexto() }}</textarea>
                                            <button onclick="copiarTexto()" class="btn btn-dark btn-xs mb-1">
                                                <i class="fa-solid fa-copy"></i> Copiar Datos
                                            </button>                                 
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionDetalle }}>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLES SPIJWEB</legend>
                                        <div class="row">
                                            @if ($textoHeaderModal === "ENVIAR USUARIO")
                                                <div class="col-xl-2">
                                                    <label for="txtusuario" class="fw-bold fs-6">Usuario</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-dark btn-xs" wire:click="licenciaBuscar">
                                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                                        </button>
                                                        <input type="textusuario" id="txt" class="form-control form-control-sm" wire:model="usuario" required>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <label for="txtpassword" class="fw-bold fs-6">Contraseña</label>
                                                    <input type="textpassword" id="txt" class="form-control form-control-sm" wire:model="password" required>
                                                </div>
                                            @endif
                                            <div class="col-xl-8">
                                                <label for="txtenviar" class="fw-bold fs-6">Enviar a:</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" id="email_personal" name="enviar" class="btn-check" value="{{ $correopersonal }}" autocomplete="off" wire:model.live="enviar_a">
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-sm flex-fill" for="email_personal">Email personal: {{ $correopersonal }}</label>

                                                    <input type="radio" id="email_institucional" name="enviar" class="btn-check" value="{{ $correoinstitucional }}" autocomplete="off" wire:model.live="enviar_a">
                                                    <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-sm flex-fill" for="email_institucional">Email institucional: {{ $correoinstitucional }}</label>
                                                </div>
                                            </div>
                                        </div>                                 
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{ $spijwebasignado_id }} - {{ $usuario }}
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

        {{-- MODAL BUSCAR LICENCIA --}}
        <div class="modal fade @if($modalLicenciaBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="buscar-sedes-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> BUSCAR LICENCIA
                            </h1>
                            <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarBuscar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive-xl">
                                <form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_licencias->total() }}</span>
                                                <input type="text" id="txtSearchLicencia" class="form-control form-control-sm" placeholder="Buscar licencia" wire:model.live="searchlicencias">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-striped table-hover table-sm table-xsmall">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">USUARIO</th>
                                            <th scope="col">PASSWORD</th>
                                            <th scope="col">ASINADO</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lista_licencias as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->usuario }}</td>
                                                <td>{{ $item->password }}</td>
                                                <td class="text-center">
                                                    @if ($item->asignado === '0')
                                                        <span class="badge bg-success-subtle text-success-emphasis px-3 py-2">
                                                            <i class="fa-solid fa-circle-check me-1"></i>
                                                            Libre
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-plus"></i> Agregar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="align-middle"><td colspan="5">Sin registros.</td></tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">{{ $lista_licencias->links() }}</td>
                                        </tr>
                                    </tfoot>
                                </table>                      
                            </div>          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarBuscar">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL BUSCAR LICENCIAS --}}

        <div class="modal fade @if($modalLicenciaListar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="buscar-sedes-componentLabel">
                                <i class="fa-brands fa-searchengin"></i> BUSCAR LICENCIA
                            </h1>
                            <button type="button" class="btn-close" aria-label="Close" wire:click="cerrarListar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive-xl">
                                <form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_licencias->total() }}</span>
                                                <input type="text" id="txtSearchLicencia" class="form-control form-control-sm" placeholder="Buscar licencia" wire:model.live="searchlicencias">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-striped table-hover table-sm table-xsmall">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">USUARIO</th>
                                            <th scope="col">PASSWORD</th>
                                            <th scope="col">ASINADO</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lista_licencias as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->usuario }}</td>
                                                <td>{{ $item->password }}</td>
                                                <td class="text-center">
                                                    @if ($item->asignado === '0')
                                                        <span class="badge bg-success-subtle text-success-emphasis px-3 py-2">
                                                            <i class="fa-solid fa-circle-check me-1"></i>
                                                            Libre
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_licencia({{ $item->id }})">
                                                                <i class="fa-solid fa-circle-plus"></i> Agregar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="align-middle"><td colspan="5">Sin registros.</td></tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">{{ $lista_licencias->links() }}</td>
                                        </tr>
                                    </tfoot>
                                </table>                      
                            </div>          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarListar">
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
