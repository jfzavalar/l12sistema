<div>
    <div class="tab-content" id="myTabContent">
        
        {{-- Pestaña 01 --}}
        <div class="tab-pane show active" id="index-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <div class="row mt-3">
                <div class="col-xl-6">
                    <table class="table table-striped table-sm table-xsmall">
                        <thead class="table-dark text-center align-middle">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center" scope="col">USUARIOS</th>
                                <th class="text-center" scope="col">FORMATOS</th>
                                <th class="text-center" scope="col">USUARIOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($totales_asignados as $tactivos)
                                <tr class="align-middle" style="font-size: 12px;">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th>{{ $tactivos->created_user }}</th>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white" wire:click="$set('filtro_formatos','ENVIADO')" id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-check me-2"></i>Enviado
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_enviados }}" readonly>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-danger text-white" wire:click="$set('filtro_formatos','PENDIENTE')" id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendiente
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_pendientes }}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-success text-white" wire:click="$set('filtro_usuarios','ENVIADO')"  id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-check me-2"></i>Enviado
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_enviados_u }}" readonly>
                                            </div>
                                            <div class="input-group input-group-xs">
                                                <button class="input-group-text bg-danger text-white" wire:click="$set('filtro_usuarios','PENDIENTE')" id="inputGroup-sizing-sm">
                                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendiente
                                                </button>
                                                <input type="text" class="form-control text-end" value="{{ $tactivos->total_pendientes_u }}" readonly>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h5 class="card-title">
                                    Total
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2><i class="fa-solid fa-chart-simple text-primary"></i> {{ $conteo_rutas->con_ruta + $conteo_rutas->sin_ruta }}</h2>
                                    <button class="btn btn-outline-primary btn-sm"  wire:click="$set('filtro_rutas','')">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h5 class="card-title">
                                    Firmadas
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2><i class="fa-solid fa-file-signature text-success"></i> {{ $conteo_rutas->con_ruta }}</h2>
                                    <button class="btn btn-outline-success btn-sm" wire:click="$set('filtro_rutas','con')">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h5 class="card-title">
                                    Sin Firmar
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2><i class="fa-solid fa-signature text-danger"></i> {{ $conteo_rutas->sin_ruta }}</h2>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="$set('filtro_rutas','sin')">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Buscar por DNI o Datos del Personal" wire:model.live="search">
                            @can('procesos.informatica.spijweb.create')
                                <button type="button" class="btn btn-primary btn-sm" wire:click="nuevo" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                    <i class="fa-solid fa-file"></i> Nuevo Registro
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><i class="fa-solid fa-user"></i> DNI - DATOS</th>
                            <th scope="col">SEDE - DEPENDENCIA</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">FORMATOS</th>
                            <th scope="col">USUARIO</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><b>{{ $item->dni }}</b> <br> {{ $item->datos }}</td>
                                <td><b>{{ $item->sede_origen }}</b> <br> {{ $item->dependencia_origen }}</td>
                                <td>{{ $item->cargo }}</td>
                                <td>
                                    @if ($item->estado_formato === "ENVIADO")
                                        <span class="badge rounded-pill text-bg-success">ENVIADO</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">PENDIENTE</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->estado_userpass === "ENVIADO")
                                        <span class="badge rounded-pill text-bg-success">ENVIADO</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">PENDIENTE</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.spijweb.edit')
                                                <button type="button" class="btn btn-outline-primary btn-xs" wire:click="editar({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                </button>
                                            @endcan
                                            {{-- <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                                <i class="fa-solid fa-eye"></i> Ver
                                            </button> --}}
                                            {{-- <a type="button" href="{{ route('pdf.informatica.spijweb-acta', $item->id) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                                <i class="fa-solid fa-print"></i>VerActa
                                            </a> --}}
                                            {{-- <button type="button" class="btn btn-outline-dark btn-sm" wire:click="exportarPDF({{ $item->id }})">
                                                <i class="fa-solid fa-file-arrow-down"></i> DescargarPDF
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                <i class="fa-solid fa-file-pdf"></i>DescargarActa
                                            </button> --}}
                                            @can('procesos.informatica.spijweb.create')
                                                <button type="button" class="btn btn-outline-dark btn-xs" wire:click="enviar_correo1({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#enviar-correo-Modal">
                                                    <i class="fa-solid fa-truck-fast"></i><br>EnviarActa
                                                </button>
                                            @endcan
                                            {{-- <button type="button" class="btn btn-outline-dark btn-sm" wire:click="enviar_correo1({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#enviar-correo-usuario-Modal">
                                                <i class="fa-solid fa-user-tag"></i> EnviarUsuario
                                            </button> --}}

                                            @can('procesos.informatica.spijweb.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="$emit('confirmarEliminacion', {{ $item->id }})">
                                                    <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.spijweb.edit')
                                                <button type="button" class="btn btn-outline-info btn-xs" wire:click="cargarPDF1({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#pdf-cargar-Modal">
                                                    <i class="fa-solid fa-file-pdf"></i><br>Cargar_Acta
                                                </button>
                                            @endcan
                                            @if ($item->actaruta)
                                                <a href="{{ asset($item->actaruta) }}" target="_blank" class="btn btn-outline-warning btn-xs">
                                                    <i class="fa-solid fa-file-pdf"></i><br>Ver_Acta
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <tfoot>
                        {{-- Links de paginación --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>Total de registros:</strong> {{ $lista_activos->total() }}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{ $lista_activos->links() }}
                            </div>
                        </div>
                    </tfoot>
            </div>
        </div>

        {{-- Pestaña 02 --}}
        <div class="tab-pane fade fade" id="inactivos-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <form>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control" placeholder="Buscar por DNI o Datos del Personal" aria-label="Recipient’s username" aria-describedby="button-addon2">
                            {{-- <button type="button" class="btn btn-outline-primary" wire:click="nuevo" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button> --}}
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-sm small align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">DNI</th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE</th>
                            {{-- <th scope="col">LOCAL</th> --}}
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">CARGO</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lista_inactivos as $item2)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item2->dni }}</td>
                                <td>{{ $item2->datos }}</td>
                                <td>{{ $item2->sede }}</td>
                                <td></td>
                                <td>{{ $item2->dependencia }}</td>
                                <td>{{ $item2->cargo }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.spijweb.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="$emit('confirmarReactivacion', {{ $item2->id }})">
                                                    <i class="fa-solid fa-trash-can-arrow-up"></i><br>Reactivar
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">
                                No existen registros
                            </div>
                        @endforelse
                    </tbody>
                </table>
                <tfoot>
                    {{-- Links de paginación --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>Total de registros:</strong> {{ $lista_inactivos->total() }}
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            {{ $lista_inactivos->links() }}
                        </div>
                    </div>
                </tfoot>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="new-edit-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form wire:submit.prevent={{ $guardar_actualizar }}>
                    <div class="modal-header {{ $color_modal_header }}">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $nuevo_editar }} REGISTRO
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_nuevo" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <fieldset class="border p-4 rounded mb-4">
                                    {{-- <legend class="float-none w-outo px-3">Formulario</legend> --}}
                                    <div class="row g-3">
                                        <div class="input-group">
                                            <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#personal-buscar-Modal">
                                                <i class="fa-brands fa-searchengin"></i> Buscar
                                            </button>
                                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $dni . ' - ' . $datos . ' - ' . $cargo . ' - ' . $regimen }}" readonly>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label fw-bold">DNI</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="dni" readonly required>
                                            @error('dni')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-sm-12">
                                            <label class="form-label fw-bold">Apellidos y Nombres</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="datos" readonly required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label fw-bold">Cargo</label>
                                            <div class="input-group">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#cargo-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" wire:model="cargo" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label fw-bold">Régimen</label>
                                            <div class="form-group">
                                                <input type="radio" class="btn-check" name="options-outlined" value="DL.276" wire:model="regimen" id="success-outlined" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm" for="success-outlined">D.L.276</label>

                                                <input type="radio" class="btn-check" name="options-outlined" value="DL.728" wire:model="regimen" id="danger-outlined" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm" for="danger-outlined">D.L.728</label>

                                                <input type="radio" class="btn-check" name="options-outlined" value="CAS" wire:model="regimen" id="info-outlined" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm" for="info-outlined">CAS</label>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label fw-bold">Sede</label>
                                            <div class="input-group mb-3">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#sede-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" wire:model="sede_origen" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label fw-bold">Dependencia</label>
                                            <div class="input-group mb-3">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" wire:model="dependencia_origen" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label fw-bold">Correo Institucional</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="correo_institucional" readonly>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label fw-bold">Celular Institucional</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="cel_institucional" readonly>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label fw-bold">Correo Personal</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="correo_personal" readonly>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <label class="form-label fw-bold">Celular Personal</label>
                                            <input type="text" class="form-control form-control-sm bg-light" wire:model="cel_personal" readonly>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-4 rounded">
                                    <div class="row g-3">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label"><strong>USUARIO</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="usuariospijweb" required>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label"><strong>CONTRASEÑA</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="passwordspijweb" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div> 
                            {{-- <div class="col-xl-4 border-start-1">
                                <fieldset class="border p-4 rounded mb-4">
                                    <legend class="float-none w-outo px-3">Datos del Personal</legend>
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#personal-buscar-Modal">
                                            <i class="fa-solid fa-copy"></i> Copiar
                                        </button>
                                        <input type="text" class="form-control" value="{{ $dni . ' - ' . $datos . ' - ' . $cargo . ' - ' . $regimen }}">
                                    </div>
                                    <br><label class="form-label">DNI:</label> {{ $dni }}
                                    <br><label class="form-label">Datos:</label> {{ $datos }}
                                    <br><label class="form-label">CARGO:</label> {{ $cargo }}
                                    <br><label class="form-label">REGIMEN:</label> {{ $regimen }}
                                    <br><label class="form-label">SEDE:</label> {{ $sede }}
                                    <br><label class="form-label">DEPENDENCIA:</label> {{ $dependencia }}
                                    <br><label class="form-label">CORREO INSTITUCIONAL:</label> {{ $correo_institucional }}
                                    <br><label class="form-label">CELULAR INSTITUCIONAL:</label> {{ $cel_institucional }}
                                    <br><label class="form-label">CORREO PERSONAL:</label> {{ $correo_personal }}
                                    <br><label class="form-label">CELULAR PERSONAL:</label>  {{ $cel_personal }}
                                </fieldset>
                            </div>     --}}
                        </div>         
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn {{ $color_boton }} btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <br>Guardar
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_nuevo" data-bs-dismiss="modal">
                            <i class="fa-solid fa-door-closed"></i>
                            <br>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('livewire.partials.2personal-cargo-modal-buscar')
    @include('livewire.partials.2personal-dependencia-modal-buscar')
    @include('livewire.partials.2personal-sede-modal-buscar')

    @include('livewire.partials.2personal-spijweb-modal-enviar-correo')
    {{-- @include('livewire.partials.modalenviarcorreousuario') --}}
    @include('livewire.partials.2personal-datos-modal-buscar')
    @include('livewire.partials.2personal-spijweb-modal-pdf-cargar')
    
    
</div>

