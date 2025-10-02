{{-- Tab 01 --}}
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
                <div class="input-group mb-3">
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searcha" placeholder="Buscar">
                    <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo {{ $searcha }}
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-small">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE</th>
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">DESPACHO</th>
                            <th scope="col">REGIMEN</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">CORREO PERSONAL</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->dni }}</td>
                                <td>{{ $item->datos }}</td>
                                <td>{{ $item->sede }}</td>
                                <td>{{ $item->dependencia }}</td>
                                <td></td>
                                <td>{{ $item->regimen }}</td>
                                <td>{{ $item->cargo }}</td>
                                <td>{{ $item->correo_personal }}</td>
                                <td class="d-flex justify-content-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-xs">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Password
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-info btn-sm">
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
                                        </button>                           --}}
                                        <button type="button" class="btn btn-outline-primary btn-xs">
                                            <i class="fa-solid fa-user-gear"></i><br>Asignar_rol
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">
                                No se encontraron resultados!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- Links de paginación --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <strong>Total de registros:</strong> {{ $lista_activos->total() }}
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    {{ $lista_activos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo-Editar-->
    <div class="modal fade @if($modal_abierto_personal) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> NUEVO
                            @else
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            @endif
                            {{ $ip_equipo }}
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center">
                                    <legend class="float-none w-outo px-3 fs-5">Foto</legend>
                                    <button type="button" class="btn btn-outline-secondary" wire:click="editar_imagen">
                                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" class="img-fluid rounded-start" alt="Foto perfil">
                                    </button>
                                    {{-- <p>Sede seleccionada: {{ $codsede }}</p>
                                    <p>Dependencia seleccionada: {{ $coddependencia }}</p> --}}

                                </fieldset>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-5">Datos Personales</legend>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12">
                                            <label for="txtdni" class="fw-bold fs-6">DNI</label>
                                            <input type="text" id="txtdni" class="form-control form-control-sm" wire:model="dni">
                                        </div>
                                        <div class="col-xl-12 col-sm-12">
                                            <label for="txtdatos" class="fw-bold fs-6">Personal</label>
                                            <input type="text" id="txtdatos" class="form-control form-control-sm" wire:model="datos">
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12">
                                            <label for="txtcelular_personal" class="fw-bold fs-6">Celular personal</label>
                                            <input type="text" id="txtcelular_personal" class="form-control form-control-sm" wire:model="cel_personal">
                                        </div>
                                        <div class="col-xl-12 col-sm-12">
                                            <label for="txtcorreo_personal" class="fw-bold fs-6">Correo personal</label>
                                            <input type="text" id="txtcorreo_personal" class="form-control form-control-sm" wire:model="correo_personal">
                                        </div>
                                    </div> 
                                </fieldset>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-5">Datos Institucionales</legend>
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label for="cmbcodsede" class="fw-bold fs-6">Sede</label>
                                            <div class="input-group">
                                                <button class="btn btn-secondary btn-sm">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                {{-- <input type="text" id="txtsede" class="form-control form-control-sm"> --}}
                                                <select id="cmbcodsede" class="form-select form-select-sm" wire:model.live="codsede">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_sedes as $item_sede)
                                                        <option value="{{ $item_sede->codsedeofi }}">{{ $item_sede->nomsedeofi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-sm-12">
                                            <label for="cmbcoddependencia" class="fw-bold fs-6">Dependencia</label>
                                            <div class="input-group">
                                                <button class="btn btn-secondary btn-sm">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                {{-- <input type="text" id="txtdependencia" class="form-control form-control-sm"> --}}
                                                <select id="cmbcoddependencia" class="form-select form-select-sm" wire:model.live="coddependencia">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_dependencias as $item_dependencia)
                                                        <option value="{{ $item_dependencia->coddepofi }}" @selected($item_dependencia->coddepofi == $coddependencia)>{{ $item_dependencia->nomdepofi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-4 col-sm-12">
                                            <label for="txtdespacho" class="fw-bold fs-6">Despacho</label>
                                            <div class="input-group">
                                                <button class="btn btn-secondary btn-sm">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtdespacho" class="form-control form-control-sm">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
                                            <input type="text" id="txtcelular_institucional" class="form-control form-control-sm" wire:model="cel_institucional">
                                        </div>
                                        <div class="col-xl-8 col-sm-12">
                                            <label for="txtcorreo_institucional" class="fw-bold fs-6">Correo institucional</label>
                                            <input type="text" id="txtcorreo_institucional" class="form-control form-control-sm" wire:model="correo_institucional">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label for="txtdespacho" class="fw-bold fs-6">Regimen</label>
                                            <div class="form-group">
                                                <input type="radio" id="regimen276" name="regimen" class="btn-check" value="DL.276" autocomplete="off" wire:model.live="regimen">
                                                <label class="btn btn-outline-primary btn-sm" for="regimen276">D.L.276</label>

                                                <input type="radio" id="regimen728" name="regimen" class="btn-check" value="DL.728" autocomplete="off" wire:model.live="regimen">
                                                <label class="btn btn-outline-primary btn-sm" for="regimen728">D.L.728</label>

                                                <input type="radio" id="regimenCAS" name="regimen" class="btn-check" value="CAS" autocomplete="off" wire:model.live="regimen">
                                                <label class="btn btn-outline-primary btn-sm" for="regimenCAS">CAS</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-sm-12">
                                            <label for="txtdespacho" class="fw-bold fs-6">Cargo</label>
                                            <div class="input-group">
                                                <button class="btn btn-secondary btn-sm">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                                <input type="text" id="txtdespacho" class="form-control form-control-sm" wire:model="cargo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12">
                                            <label for="txtobservacion" class="fw-bold fs-6">Observación</label>
                                            <input type="text" id="txtobservacion" class="form-control form-control-sm" wire:model="observacion">
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

    <!-- Modal cargar imagen -->
    <div class="modal fade @if($modal_abierto_imagen) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header bg-success-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file-image"></i> CARGAR IMAGEN
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_imagen"></button>
                    </div>
                    <div class="modal-body bg-secondary-subtle">
                        <fieldset class="border p-3 rounded text-center">
                            {{-- Imagen previa (preview Livewire) --}}
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="img-fluid rounded-start mb-3" alt="Preview" width="200">
                            @else
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/perfil.jpg') }}" 
                                    class="img-fluid rounded-start mb-3" 
                                    alt="Foto perfil" 
                                    width="200">
                            @endif
                            <div class="col-lg-12">
                                <label for="fileimagen" class="fw-bold fs-6 mb-3">FOTO</label>
                                <input type="file" id="fileimagen" class="form-control" wire:model="avatar" required>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer bg-dark-subtle">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Actualizar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_imagen">
                            <i class="fa-solid fa-square-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


