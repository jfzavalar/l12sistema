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
                                <label for="cmd_filtro_dependencia" class="form-label">
                                    <strong><i class="fa-solid fa-filter"></i> Filtrar por Sede</strong>
                                </label>
                                <select id="cmd_filtro_dependencia" class="form-select form-select-sm" wire:model.live="filtro_dependencia">
                                    {{-- <option selected>Mostrar todo: Seleccionar sede</option> --}}
                                    <option value="">Seleccionar todo</option>
                                    @foreach ($lista_sedes_dependencias_despachos as $sedeb)
                                        <option value="{{ $sedeb->nomsedeofi }}">{{ $sedeb->nomsedeofi . ' - ' . $sedeb->total }} - Equipos registrados</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="cmb_filtro_ip" class="form-label">
                                    <strong><i class="fa-solid fa-filter"></i> Filtrar por IP</strong>
                                </label>
                                <select id="cmb_filtro_ip" class="form-select form-select-sm" wire:model.live="filtro_ip">
                                    <option value="">Seleccionar todo</option>
                                    <option value="1">Con IP</option>
                                    <option value="0">Sin IP</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="txt_searcha" class="form-label">
                                    <strong> <i class="fa-solid fa-filter"></i>Buscar por DNI - Código Patrimonial - IP</strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" id="txt_searcha" class="form-control form-control-sm" placeholder="Buscar por DNI - CÓDIGO PATRIMONIAL - IP" wire:model.live="searcha">
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
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
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
                            <div class="col-xl-4 col-sm-12">                              
                                @include('livewire.partials.personal-datos-foto')
                                @include('livewire.partials.personal-datos-personales')
                            </div>
                            <div class="col-xl-8 col-sm-12">
                                @include('livewire.partials.bienes-datos')
                                @include('livewire.partials.bienes-datos-informaticos')
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

    @include('livewire.partials.bienes-modal-buscar')

    @include('livewire.partials.personal-modal-foto')

</div>