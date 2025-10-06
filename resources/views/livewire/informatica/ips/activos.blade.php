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
            <form>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-lg-4 col-sm-12">
                                <label class="form-label">
                                    <strong><i class="fa-solid fa-filter"></i> Filtrar por Sede</strong>
                                </label>
                                <select class="form-select form-select-sm" wire:model.live="filtro_dependencia">
                                    {{-- <option selected>Mostrar todo: Seleccionar sede</option> --}}
                                    <option value="">Seleccionar todo</option>
                                    @foreach ($lista_sedes_dependencias_despachos as $sedeb)
                                        <option value="{{ $sedeb->nomsedeofi }}">{{ $sedeb->nomsedeofi . ' - ' . $sedeb->total }} - Equipos registrados</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label class="form-label">
                                    <strong><i class="fa-solid fa-filter"></i> Filtrar por IP</strong>
                                </label>
                                <select class="form-select form-select-sm" wire:model.live="filtro_ip">
                                    <option value="">Seleccionar todo</option>
                                    <option value="1">Con IP</option>
                                    <option value="0">Sin IP</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label class="form-label">
                                    <strong> <i class="fa-solid fa-filter"></i>Buscar por DNI - Código Patrimonial - IP</strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Buscar por DNI - CÓDIGO PATRIMONIAL - IP" wire:model.live="searcha">
                                    @can('procesos.informatica.ips.create')
                                        <button type="button" id="btnnuevo" class="btn btn-outline-primary btn-sm" wire:click="nuevo">
                                            <i class="fa-solid fa-file"></i> Nuevo
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive small">
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th  scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">PERSONAL</th>
                            <th scope="col">COD PATRIMONIAL</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">IP</th>
                            <th scope="col">MARCA</th>
                            <th scope="col">MODELO</th>
                            <th scope="col">SERIE</th>
                            <th scope="col">
                                <i class="fa-solid fa-gears"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr @if (is_null($item->ip)) class="text-danger" @endif>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $loop->iteration }}</th>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->cod_usuario}}</th>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->desc_usuario }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->cod_pat }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->bien }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->ip }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->marca}}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->modelo }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->serie }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.ips.edit')
                                                <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            @endcan
                                            @can('procesos.informatica.ips.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="$emit('confirmarEliminacion', {{ $item->id }})">
                                                    <i class="fa-solid fa-trash-can"></i> Eliminar
                                                </button>
                                            @endcan
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
    <div class="modal fade @if($modal_abierto_personal) show d-block @endif" tabindex="-1">
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
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center">
                                    <legend class="float-none w-outo px-3 fs-6">Foto de perfil</legend>
                                    <button type="button" class="btn btn-outline-secondary" wire:click="editar_imagen">
                                        
                                    </button>
                                </fieldset>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6">Datos Personales</legend>
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
                                <fieldset class="border p-4 rounded">
                                    <legend class="float-none w-outo px-3 fs-6">Bien informático</legend>
                                    <div class="input-group">
                                        @can('procesos.informatica.ips.create')
                                            <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color}} btn-sm" data-bs-toggle="modal" data-bs-target="#agregarpatrimoniobieninformaticoModal">
                                                <i class="fa-brands fa-searchengin"></i> Buscar
                                            </button>
                                        @endcan
                                        <input type="text" class="form-control form-control-sm bg-light" wire:model="equipo_detalle" readonly>
                                    </div>
                                    {{-- <div class="row g-3 mt-1">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Sede</strong></label>
                                            <div class="input-group">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#sede-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-sm-12">
                                            <label class="form-label"><strong>Dependencia</strong></label>
                                            <div class="input-group">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly required>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row g-3">
                                        {{-- <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Despacho</strong></label>
                                            <div class="input-group">
                                                <button type="button" class="btn {{ $color_boton }} btn-sm" data-bs-toggle="modal" data-bs-target="#dependencia-buscar-Modal">
                                                    <i class="fa-brands fa-searchengin"></i> Buscar
                                                </button>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly required>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-12 col-sm-12">
                                            <label class="form-label"><strong>Ubicación física</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase bg-light" wire:model="desc_ubif" readonly required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Código patrimonial</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" wire:model="cod_pat" required>
                                            @error('cod_pat')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>IP</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" wire:model="ip" required>
                                            @error('ip')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Sistema operativo</strong></label>
                                            <select class="form-select form-select-sm" wire:model="sistema_operativo" required>
                                                <option selected>Seleccionar...</option>
                                                <option value="WINDOWS_10">WINDOWS_10</option>
                                                <option value="WINDOWS_11">WINDOWS_11</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Marca</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" wire:model="marca" required>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Modelo</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" wire:model="modelo" required>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>SERIE</strong></label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" wire:model="serie" required>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label"><strong>Usuario administrador</strong></label>
                                            <select class="form-select form-select-sm" wire:model="user_admin" required>
                                                <option selected>Seleccionar...</option>
                                                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                                <option value="FISCALIA">FISCALIA</option>
                                                <option value="SOPORTE">SOPORTE</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label"><strong>Password administrador</strong></label>
                                            <select class="form-select form-select-sm" wire:model="pass_admin" required>
                                                <option selected>Seleccionar...</option>
                                                <option value="informaticajunin@2024">informaticajunin@2024</option>
                                                <option value="redjunin@10000">redjunin@10000</option>
                                                <option value="redjunin@20000">redjunin@20000</option>
                                                <option value="redjunin@30000">redjunin@30000</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr class="border-2">

                                    <div class="row g-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Impresora 01</strong></label>
                                            <select class="form-select form-select-sm" wire:model="impresora01">
                                                <option selected>Seleccionar...</option>
                                                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                                                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                                                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                                                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Impresora 02</strong></label>
                                            <select class="form-select form-select-sm" wire:model="impresora02">
                                                <option selected>Seleccionar...</option>
                                                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                                                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                                                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                                                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>Impresora 03</strong></label>
                                            <select class="form-select form-select-sm" wire:model="impresora03">
                                                <option selected>Seleccionar...</option>
                                                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                                                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                                                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                                                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>IP Impresora 01</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="ip_impresora01">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>IP Impresora 02</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="ip_impresora02">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label"><strong>IP Impresora 03</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="ip_impresora03">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-12 col-sm-12">
                                            <label class="form-label"><strong>Observación</strong></label>
                                            <input type="text" class="form-control form-control-sm" wire:model="observacion">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i><br>Guardar
                            @else
                                <i class="fa-solid fa-floppy-disk"></i><br>Actualizar
                            @endif    
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar">
                            <i class="fa-solid fa-square-xmark"></i><br>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal cargar imagen -->
    <div class="modal fade @if($modal_abierto_imagen) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header bg-warning-subtle">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            <i class="fa-solid fa-file-image"></i> CARGAR IMAGEN
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_imagen"></button>
                    </div>
                    <div class="modal-body bg-secondary-subtle">
                        
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