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
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searchpersonal" placeholder="Buscar por DNI o Datos del Personal">
                    <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo personal
                    </button>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE - ORIGEN</th>
                            <th scope="col">SEDE</th>
                            <th scope="col">REGIMEN</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">DATOS PERSONALES</th>
                            <th scope="col">DATOS INSTITUCIONALES</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
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
                                        {{-- <button type="button" class="btn btn-outline-secondary btn-xs">
                                            <i class="fa-solid fa-eye"></i><br>Detalles
                                        </button> --}}
                                        {{--  <button type="button" class="btn btn-outline-secondary btn-sm">
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
                                        </button> --}}
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
                                <i class="fa-solid fa-file"></i> NUEVO
                            @elseif($modal_header_titulo === "editar")
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            @elseif($modal_header_titulo === "nuevo_contrato")
                                <i class="fa-solid fa-pen-to-square"></i> NUEVO CONTRATO
                            @endif
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3">
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
                                        <fieldset class="border p-3 rounded mb-3">
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
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $modal_header_color }}">DATOS DEL ÚLTIMO CONTRATO</legend>
                                    @include('livewire.partials.personal-datos-contrato')
                                </fieldset> 
                            </div>
                        </div>
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

    <!-- Modal Historial -->
    <div class="modal fade @if($modal_abierto_historial) show d-block @endif" tabindex="-1">
        {{-- <div class="modal-dialog modal-xl" style="max-width:90%;"> --}}
        <div class="modal-dialog modal-xl" style="max-width:90%;">
            <div class="modal-content">
                <form>
                    <div class="modal-header bg-info-subtle">
                        <h1 class="modal-title fs-5">
                            <i class="fa-solid fa-timeline"></i> HISTORIAL
                        </h1>
                        <button type="button" class="btn-close" wire:click="cerrar_historial"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive small">
                            <div class="input-group mb-3">
                                <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="search_historial" placeholder="Buscar por DNI o Datos del Personal">
                            </div>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fa-solid fa-user"></i> DNI
                                        </th>
                                        <th scope="col">DATOS</th>
                                        <th scope="col">SEDE - ORIGEN</th>
                                        <th scope="col">SEDE</th>
                                        <th scope="col">REGIMEN</th>
                                        <th scope="col">CARGO</th>
                                        <th scope="col">INTERVALO</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_historial as $item)
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
                                            <td class="text-primary"><b> {{  $item->fecha_fin }} <br> {{ $item->fecha_inicio}}</b></td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    {{-- <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                    </button> --}}
                                                    {{-- <button type="button" class="btn btn-outline-secondary btn-xs">
                                                        <i class="fa-solid fa-eye"></i><br>Detalles
                                                    </button> --}}
                                                    <button type="button" class="btn btn-outline-warning btn-xs" wire:click="cargarPDF1({{ $item->id }})">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button>
                                                    @if ($item->actaruta)
                                                        <a href="{{ asset($item->actaruta) }}" target="_blank" class="btn btn-outline-dark btn-xs">
                                                            <i class="fa-solid fa-file-pdf"></i><br>Contrato
                                                        </a>
                                                    @endif
                                                     {{-- <button type="button" class="btn btn-outline-primary btn-xs">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-dark btn-xs">
                                                        <i class="fa-solid fa-print"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btn-xs">
                                                        <i class="fa-solid fa-handshake-simple"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-xs">
                                                        <i class="fa-solid fa-handshake-simple-slash"></i>
                                                    </button> --}}
                                                    
                                                    {{-- <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial({{ $item->id }})">
                                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                                    </button>                           
                                                    <button type="button" class="btn btn-outline-danger btn-xs" wire:click="desactivar({{ $item->id }})">
                                                        <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                                    </button> --}}
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_historial">
                            <i class="fa-solid fa-square-xmark"></i><br>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Foto -->
    @include('livewire.partials.personal-modal-foto')

    <!-- Modal PDF -->
    @include('livewire.partials.pdf-modal-cargar')

</div>


