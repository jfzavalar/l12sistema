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
            <form wire:submit.prevent="guardar">
                <div class="row">
                    <div class="col-xl-4">
                        <fieldset class="border p-3 rounded mb-3">
                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS PERSONALES</legend> --}}
                            @include('livewire.partials.voluntarios-datos-personales')
                        </fieldset> 
                    </div>
                    <div class="col-xl-8">
                        <fieldset class="border p-3 rounded mb-3">
                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend> --}}
                            @include('livewire.partials.voluntarios-datos-institucionales')
                        </fieldset>
                    </div>
                </div>
            </form>

            <div class="table-responsive small">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-sm-12">
                        <input type="date" class="form form-control form-control-sm" wire:model="filtro_fecha">
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searchpersonal" placeholder="Buscar por DNI o Datos del Personal">
                            {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                <i class="fa-solid fa-file"></i> Nuevo
                            </button> --}}
                        </div>
                    </div>
                </div>
                
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>
                            {{-- <th scope="col">DATOS</th> --}}
                            {{-- <th scope="col">SEDE - ORIGEN</th> --}}
                            <th scope="col">SEDE</th>
                            {{-- <th scope="col">REGIMEN</th> --}}
                            {{-- <th scope="col">CARGO</th> --}}
                            {{-- <th scope="col">INFORMACIÓN PERSONAL</th> --}}
                            {{-- <th scope="col">DATOS INSTITUCIONALES</th> --}}
                            <th scope="col">TIPO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">MARCACIÓN</th>
                            {{-- <th scope="col">SALIDA</th> --}}
                            <th scope="col">REGISTRA</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td><b>{{ $item->dni }}</b><br>{{ $item->datos }}</td>
                                {{-- <td></td> --}}
                                {{-- <td>
                                    <b>SEDE: </b>{{ $item->sede_origen }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_origen }}
                                </td> --}}
                                <td class="text-primary">
                                    <b>SEDE: </b>{{ $item->sede_destino }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_destino }}
                                </td>
                                {{-- <td><b>{{ $item->regimen }}</b></td> --}}
                                {{-- <td>{{ $item->cargo }}</td> --}}
                                {{-- <td>
                                    <b>CEL: </b>{{ $item->cel_personal }}
                                    <br>{{ $item->correo_personal }}
                                </td> --}}
                                {{-- <td>
                                    <b>CEL: </b>{{ $item->cel_institucional }}
                                    <br>{{ $item->correo_institucional  }}
                                </td> --}}
                                <td>
                                    @if ($item->entrada_salida === "1")
                                        <span class="badge rounded-pill text-bg-success">ENTRADA</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">SALIDA</span>
                                    @endif
                                </td>
                                <td>{{ $item->fecha }}</td>
                                <td>{{ $item->hora_entrada }}</td>
                                {{-- <td>{{ $item->hora_salida }}</td> --}}
                                <td>{{ $item->created_user }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        {{-- <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button> --}}
                                        {{-- <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial('{{ $item->dni }}')">
                                            <i class="fa-solid fa-timeline"></i><br>Historial
                                        </button>                            --}}
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
    <div class="modal fade @if($modal_abierto_personal) show d-block @endif" id="NuevoEditarModal" tabindex="-1">
        {{-- <div class="modal-dialog modal-xl" style="max-width:90%;"> --}}
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $btn_guardar_actualizar }}">
                    <div class="modal-header bg-{{ $modal_header_color }}">
                        <h1 class="modal-title fs-5" id="NuevoEditarModalLabel">
                            @if ($modal_header_titulo === "nuevo")
                                <i class="fa-solid fa-file"></i> <i class="fa-solid fa-user-clock"></i> NUEVO REGISTRO DE ASISTENCIA
                            @elseif($modal_header_titulo === "editar")
                                <i class="fa-solid fa-pen-to-square"></i> <i class="fa-solid fa-user-clock"></i> EDITAR REGISTRO DE ASISTENCIA
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- <div class="col-xl-3 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">FOTO DE PERFIL</legend>
                                    @include('livewire.partials.personal-datos-foto')
                                </fieldset>
                            </div> --}}
                            <div class="col-xl-12 col-sm-12">
                                {{-- <fieldset class="border p-3 rounded mb-3" disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend>
                                    @include('livewire.partials.personal-datos-institucionales-mir')
                                </fieldset> --}}

                                {{-- @include('livewire.partials.personal-datos-institucionales-mir') --}}
                                
                                <div class="row">
                                    <div class="col-xl-4">
                                        <fieldset class="border p-3 rounded mb-3">
                                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS PERSONALES</legend> --}}
                                            @include('livewire.partials.voluntarios-datos-personales')
                                        </fieldset> 
                                    </div>
                                    <div class="col-xl-8">
                                        <fieldset class="border p-3 rounded mb-3">
                                            {{-- <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center text-decoration-underline">DATOS INSTITUCIONALES</legend> --}}
                                            @include('livewire.partials.voluntarios-datos-institucionales')
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DATOS DEL ÚLTIMO CONTRATO</legend>
                                    @include('livewire.partials.personal-datos-contrato')
                                </fieldset> 
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $btn_guardar_actualizar_color }} btn-sm">
                            @if ($btn_guardar_actualizar === "guardar")
                                <i class="fa-solid fa-floppy-disk"></i><br>Guardar
                            @elseif($btn_guardar_actualizar === "actualizar")
                                <i class="fa-solid fa-floppy-disk"></i><br>Actualizar
                            @elseif($btn_guardar_actualizar === "guardar_contrato")
                                <i class="fa-solid fa-floppy-disk"></i><br>Guardar Contrato
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

    <!-- Modal Foto -->
    @include('livewire.partials.personal-modal-buscar')

    <!-- Modal Foto -->
    {{-- @include('livewire.partials.personal-modal-foto') --}}

    <!-- Modal PDF -->
    {{-- @include('livewire.partials.pdf-modal-cargar') --}}

</div>

