<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3">
                    <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">REDES</th>
                                        <th scope="col" colspan="3" class="text-center">DISTRIBUCIÓN DE IPS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reportes as $item)
                                        {{-- @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE") --}}
                                            <tr class="align-middle" style="font-size: 12px;">
                                                <th scope="row">{{ $item->red }}</th>
                                                <th style="white-space: nowrap;"></th>
                                                <td>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="input-group input-group-xs">
                                                            <button class="input-group-text bg-primary text-white">
                                                                Total
                                                            </button>
                                                            <label class="form-control form-control-xs text-end">{{ $item->total }}</label>
                                                        </div>
                                                        <div class="input-group input-group-xs">
                                                            <button class="input-group-text bg-success text-white">
                                                                <i class="fa-solid fa-check me-2"></i>
                                                            </button>
                                                            <label class="form-control form-control-xs text-end">{{ $item->asignados }}</label>
                                                        </div>
                                                        <div class="input-group input-group-xs">
                                                            <button class="input-group-text bg-danger text-white">
                                                                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                                            </button>
                                                            <label class="form-control form-control-xs text-end">{{ $item->libres }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        {{-- @endif --}}
                                    @empty
                                        <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-xl-6 col-gl-6 col-sm-12">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Informatica</th>
                                        <th scope="col" colspan="3" class="text-center">Tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($estadisticas as $item)
                                        {{-- @if ($item->created_user_cargo === "INFORMATICO" || $item->created_user_cargo === "SOPORTE") --}}
                                            <tr class="align-middle" style="font-size: 12px;">
                                                <th scope="row">{{ $item->updated_user }}</th>
                                                <th style="white-space: nowrap;"></th>
                                                <td>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="input-group input-group-xs">
                                                            <button class="input-group-text bg-success text-white">
                                                                <i class="fa-solid fa-check me-2"></i>Asignados
                                                            </button>
                                                            <label class="form-control form-control-xs text-end">{{ $item->asignados }}</label>
                                                        </div>
                                                        {{-- <div class="input-group input-group-xs">
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
                                                        </div> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        {{-- @endif --}}
                                    @empty
                                        <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="col-xl-4 col-gl-6 col-sm-12">
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

                        {{-- <div class="col-xl-6 col-gl-6 col-sm-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-sm-4">
                                    <div class="alert alert-primary" role="alert">
                                        <h6 class="card-title">
                                            Total
                                        </h6>
                                        <br>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5><i class="fa-solid fa-chart-simple text-primary"></i> {{ $estadisticas2->total }}</h5>
                                            <button class="btn btn-outline-primary btn-sm" wire:click="filtrarTotal">
                                                <i class="fa-solid fa-bars"></i> Listar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-sm-4">
                                    <div class="alert alert-success" role="alert">
                                        <h6 class="card-title">
                                            Asignados
                                        </h6>
                                        <br>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5><i class="fa-solid fa-check-double"></i> {{ $estadisticas2->asignados }}</h5>
                                            <button class="btn btn-outline-success btn-sm" wire:click="filtrarAsignados">
                                                <i class="fa-solid fa-bars"></i> Listar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-sm-4">
                                    <div class="alert alert-danger" role="alert">
                                        <h6 class="card-title">
                                            Libres
                                        </h6>
                                        <br>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5><i class="fa-solid fa-check-double"></i> {{ $estadisticas2->libres }}</h5>
                                            <button class="btn btn-outline-danger btn-sm" wire:click="filtrarLibres">
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
                                <div class="col-lg-4 col-sm-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                        <select id="cmb_filtrored" class="form-select formselect-sm me-2"  wire:model.live="filtrored">
                                            <option value="">RED</option>
                                            @foreach ($lista_redes as $red)
                                                <option value="{{ $red->red }}">{{ $red->red }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input list="redes" id="txt_filtro_redes" class="form-control form-control-sm" placeholder="Filtrar Red" wire:model.live="filtro_red">
                                        <datalist id="redes">
                                            @foreach ($lista_redes as $red)
                                                <option value="{{ $red->red }}">{{ $red->red }}</option>
                                            @endforeach
                                        </datalist> --}}
                                        <select id="cmb_filtroinformatico" class="form-select formselect-sm" wire:model.live="filtroinformatico">
                                            <option value="">INFORMATICO</option>
                                            @foreach ($lista_informaticos as $informatico)
                                                <option value="{{ $informatico->updated_user }}">{{ $informatico->updated_user }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input list="informaticos" id="txt_filtro_redes" class="form-control form-control-sm" placeholder="Filtrar Informático" wire:model.live="filtro_informatico">
                                        <datalist id="informaticos">
                                            @foreach ($lista_informaticos as $informatico)
                                                <option value="{{ $informatico->updated_user }}">{{ $informatico->updated_user }}</option>
                                            @endforeach
                                        </datalist> --}}
                                    </div>
                                </div>

                                <div class="col-lg-8 col-sm-12">
                                    <div class="input-group mb-3"> 
                                        <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm me-1" placeholder="Buscar por IP" wire:model.live="search">
                                        {{-- <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                            <i class="fa-solid fa-file"></i> Nuevo
                                        </button>
                                        <button class="btn btn-success btn-sm rounded-3" wire:click="exportarExcel">
                                            <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">RED</th>
                                    <th scope="col">GRUPO</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">COD PATRIMONIAL</th>
                                    <th scope="col">BIEN INFORMATICO</th>
                                    <th scope="col">DEPENDENCIA</th>
                                    <th scope="col">ESTADO</th>
                                    <th scope="col">REGISTRADO POR</th>
                                    <th scope="col" colspan="2" class="table-darck"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @forelse ($lista_activos as $item)
                                    <tr>
                                        <th class="text-center">
                                            <i class="fa-solid fa-desktop {{ $item->estado === '1' ? 'text-success' : 'text-danger' }}"></i> {{ $loop->iteration }}
                                        </th>
                                        <th>{{ $item->red }}</th>
                                        <td>{{ $item->grupo }}</td>
                                        <td>{{ $item->ip}}</td>
                                        <td>{{ $item->codigo_patrimonial}}</td>
                                        <td>{{ $item->descripcion}}</td>
                                        <td>{{ $item->ubicac_fisica}}</td>
                                        <td class="text-center">
                                            <span class="badge px-3 py-1 rounded-pill {{ $item->estado == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                                {{ $item->estado === '1' ? 'ASIGNADO' : 'LIBRE' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->updated_user}}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-success btn-sm rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->personalatencion_id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>
                                                </button> 
                                                @can('mpfn.intranet.atenciones.destroy')
                                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-4 me-1">
                                                        <i class="fa-solid fa-trash-can"></i><br>
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
                                        {{ $lista_activos->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</div>
