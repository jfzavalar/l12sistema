{{-- Tab 01 --}}
<div>
    @if (session()->has('danger'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="search_personali" placeholder="Buscar por DNI o Datos del Personal">
                    {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                        <i class="fa-solid fa-file"></i> Nuevo personal
                    </button> --}}
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-dark text-center align-middle">
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
                        @forelse ($lista_inactivos as $item)
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
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="activar({{ $item->id }})">
                                            <i class="fa-solid fa-check-double"></i><br>Reactivar
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
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- Links de paginación --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <strong>Total de registros:</strong> {{ $lista_inactivos->total() }}
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    {{ $lista_inactivos->links() }}
                </div>
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
                                            <td class="text-primary"><b>{{ $item->fecha_inicio}} <br> {{  $item->fecha_fin }}</b></td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    {{-- <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                        <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                                    </button> --}}
                                                    <button type="button" class="btn btn-outline-secondary btn-xs">
                                                        <i class="fa-solid fa-eye"></i><br>Detalles
                                                    </button>
                                                    <button type="button" class="btn btn-outline-warning btn-xs">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button>
                                                    <button type="button" class="btn btn-outline-dark btn-xs">
                                                        <i class="fa-solid fa-file-pdf"></i><br>Contrato
                                                    </button>
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
</div>
