<div>
    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                {{-- <div class="col-xl-5 col-gl-6 col-sm-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Informatica</th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE")
                                    <tr class="align-middle" style="font-size: 12px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-danger text-white">
                                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Pendientes
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->no_atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-envelope"></i>Lima
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->enviado_lima }}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-xl-4 col-gl-6 col-sm-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Digitalizadores</th>
                                <th scope="col" colspan="3" class="text-center">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estadisticas as $item)
                                @if ($item->created_user_cargo === "TERCERO")
                                    <tr class="align-middle" style="font-size: 12px;">
                                        <th scope="row">{{ $item->created_user }}</th>
                                        <th style="white-space: nowrap;"></th>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-success text-white">
                                                        <i class="fa-solid fa-check me-2"></i>Atendidos
                                                    </button>
                                                    <label class="form-control form-control-xs text-end">{{ $item->atendidos }}</label>
                                                </div>
                                                <div class="input-group input-group-xs">
                                                    <button class="input-group-text bg-info text-white">
                                                        <i class="fa-solid fa-file-pdf"></i>Folios
                                                    </button>
                                                    <label class="form-control form-control-xs">{{ $item->digitalizado }}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}

                {{-- <div class="col-xl-3 col-gl-6 col-sm-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-primary" role="alert">
                                <h6 class="card-title">
                                    Total
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-chart-simple text-primary"></i> </h5>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="filtrarTotal">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-info" role="alert">
                                <h6 class="card-title">
                                    Lima
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> </h5>
                                    <button class="btn btn-outline-info btn-sm" wire:click="filtrarEnviadolima">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-success" role="alert">
                                <h6 class="card-title">
                                    Atendido
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> </h5>
                                    <button class="btn btn-outline-success btn-sm" wire:click="filtrarAtendido">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-sm-4">
                            <div class="alert alert-danger" role="alert">
                                <h6 class="card-title">
                                    Pendientes
                                </h6>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="fa-solid fa-check-double"></i> </h5>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="filtrarNoatendido">
                                        <i class="fa-solid fa-bars"></i> Listar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="table-responsive-xl">
                {{-- <div class="input-group mb-3"> --}}
                    <div class="row g-3">                   
                        <div class="col-lg-2 col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                
                            </div>
                        </div>

                        <div class="col-lg-10 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm me-1" placeholder="Buscar por IP" wire:model.live="search">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                                {{-- <button type="button" id="btnnuevoext" class="btn btn-info btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#nuevoEditarModalExt" wire:click="nuevo_externo">
                                    <i class="fa-solid fa-file"></i> Nuevo Externo
                                </button> --}}
                                <button class="btn btn-success btn-sm rounded-3" wire:click="exportarExcel">
                                    <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                                </button>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">GRUPO</th>
                            <th scope="col">IP</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col" colspan="2" class="table-darck"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-desktop"></i> {{ $loop->iteration }}
                                </th>
                                <td>
                                    {{ $item->grupo }}
                                </td>
                                <td>
                                    {{ $item->ip}}
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $item->estado === '1' ? 'text-bg-primary' : 'text-bg-success' }}">
                                        {{ $item->estado === '1' ? 'Asignado' : 'Libre' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->personalatencion_id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button> 
                                        @can('mpfn.intranet.atenciones.destroy')
                                            <button type="button" class="btn btn-outline-danger btn-xs">
                                                <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                            </button>
                                        @endcan
                                    </div>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            {{-- <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.atencion-acta', $item->personalatencion_id) }}" target="_blank">
                                                <i class="fa-solid fa-file-pdf"></i><br>Acta
                                            </a>
                                            @if ($item->utencioncreado === auth()->user()->datos)
                                                <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#pdf-cargar-component" wire:click="editar_pdf({{ $item->personalatencion_id }})">
                                                    <i class="fa-solid fa-upload"></i><br>Cargar
                                                </button>
                                            @endif
                                            @if($item->ruta_documento)
                                                <a type="button" class="btn btn-outline-info btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                    <i class="fa-solid fa-file-signature"></i><br> Firmado
                                                </a>
                                            @endif --}}
                                        </div>
                                    </td>
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
                    <tfoot>
                        <tr>
                            <td colspan="13">
                                {{-- {{ $lista_historial->links() }} --}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
