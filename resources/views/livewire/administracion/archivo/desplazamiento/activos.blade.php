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
                    
                </div>
            </form>

            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="searchusuario" placeholder="Buscar por DNI o Datos del Personal">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo
                    </button>
                </div>

                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th  scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DESTINO
                            </th>
                            <th scope="col">SEDE - DESTINO</th>
                            <th scope="col">COD CARPETA FISCAL</th>
                            <th scope="col">FOLIOS1</th>
                            <th scope="col">FOLIOS2</th>
                            <th scope="col">OFICIO DE PRÉSTAMO:</th>
                            <th scope="col" class="table-success">
                                <i class="fa-solid fa-user"></i> DNI - ORIGEN
                            </th>
                            <th scope="col" class="table-success">SEDE - ORIGEN</th>
                            <th scope="col" class="table-success">OFICIO DE DEVOLUCIÓN:</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">
                                <i class="fa-solid fa-gears"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr @if (is_null($item->ip)) class="text-danger" @endif>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $loop->iteration }}</th>
                                <td @if (is_null($item->ip)) class="text-danger" @endif> <b> {{ $item->cod_usuario}} </b> <br> {{ $item->desc_usuario }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->nomsedeofi }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif> <b> {{ $item->cod_pat }} </b> <br> {{ $item->bien }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->familia }}</td>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->ip }}</th>
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
                                <td colspan="12" class="text-center">
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
    {{-- Flotante - paginación --}}
    <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_activos->links() }}
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
                            <div class="col-xl-2 col-sm-12" >
                                <fieldset class="border p-3 rounded text-center" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted rounded bg-{{ $modal_header_color }}">FOTO DE PERFIL</legend>
                                    @include('livewire.partials.personal-datos-foto')
                                </fieldset>                           
                            </div>
                            <div class="col-xl-3 col-sm-12" >
                                <fieldset class="border p-3 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DATOS PERSONALES</legend>
                                    @include('livewire.partials.personal-datos-personales')
                                </fieldset>   
                            </div>
                            <div class="col-xl-7 col-sm-12">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DATOS INSTITUCIONALES</legend>
                                    @include('livewire.partials.personal-datos-institucionales')
                                </fieldset>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <fieldset class="border p-4 rounded">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DETALLES DE LAS CARPETAS SOLICITADAS</legend>
                                    <div class="table-responsive small">
                                        <table class="table table-striped table-hover table-sm table-xsmall">
                                            <thead class="table-dark text-center align-middle">
                                                <tr>
                                                    <th  scope="col">#</th>
                                                    <th scope="col">CARPETA FISCAL</th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-gears"></i>
                                                    </th>
                                                    <th scope="col">
                                                        <button type="button" class="btn btn-primary btn-xs">
                                                            <i class="fa-solid fa-square-plus"></i> Agregar carpeta
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                            </tbody>
                                        </table>
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
    
    @include('livewire.partials.personal-modal-buscar')

</div>