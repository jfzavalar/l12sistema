<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">REDES</th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-primary btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarTotal('')">
                                        <i class="fa-solid fa-check-double"></i>TOTAL
                                    </button>
                                </th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-success btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarAsignados('')">
                                        <i class="fa-solid fa-check me-2"></i>ASIGNADOS
                                    </button>
                                </th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-danger btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarLibres('')">
                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>LIBRES
                                    </button>
                                </th>
                                <th scope="col" class="text-center">
                                    PCs
                                </th>
                                <th scope="col" class="text-center">
                                    LAPTOPs
                                </th>
                                <th scope="col" class="text-center">
                                    IMPRESORAS
                                </th>
                                <th scope="col" class="text-center">
                                    FOTOCOPIADORAS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reportes as $item)
                                <tr class="align-middle" style="font-size: 10px;">
                                    <th scope="row">{{ $item->red }}</th>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarTotal('{{ $item->red }}')">
                                            <i class="fa-solid fa-check-double"></i> {{ $item->total }}
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarAsignados('{{ $item->red }}')">
                                            <i class="fa-solid fa-check me-2"></i> {{ $item->asignados }}
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-xs text-nowrap w-100" data-bs-toggle="modal" data-bs-target="#listaIpsModal" wire:click = "filtrarLibres('{{ $item->red }}')">
                                            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $item->libres }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <div class="row">
                        {{-- <div class="col-xl-6 col-gl-6 col-sm-12">
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
                        </div> --}}
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

                    {{-- <div class="table-responsive-xl">
                        
                    </div> --}}
                </div>
            </div>          
        </div>
    </div>

    {{-- Modal Usuario del Equipo --}}
    <div wire:ignore.self class="modal fade" id="verPersonalModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verPersonalModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%;">
            <div class="modal-content">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="verPersonalModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }} disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                        @include('livewire.partials.componentes.persona-datos')
                                    </fieldset>
                                </div>
                                <div class="col-xl-6">
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }} disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                        @include('livewire.partials.componentes.personal-datos')
                                    </fieldset>
                                </div>
                                {{-- <div class="col-xl-2">
                                    <textarea id="textoCopiar" class="form-control" rows="10" style="font-size: 12px; white-space: nowrap; overflow-x: auto;" readonly>{{ $this->generarTexto() }}</textarea>
                                    <button onclick="copiarTexto()" class="btn btn-dark btn-xs mb-1">
                                        <i class="fa-solid fa-copy"></i> Copiar Datos
                                    </button>                                 
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Ips --}}
    <div wire:ignore.self class="modal fade" id="listaIpsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="listaIpsModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%;">
            <div class="modal-content">
                <div class="modal-header bg-primary-subtle">
                    <h1 class="modal-title fs-5" id="listaIpsModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">

                        <div class="row g-3">                   
                            <div class="col-lg-2 col-sm-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-10 col-sm-12">
                                <div class="input-group mb-3"> 
                                    <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm me-1" placeholder="Buscar por IP" wire:model.live="search">
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">RED</th>
                                    <th scope="col">GRUPO</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">COD PATRIMONIAL</th>
                                    <th scope="col">BIEN INFORMATICO</th>
                                    {{-- <th scope="col">DEPENDENCIA</th> --}}
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
                                        <td>{{ $item->bien}}</td>
                                        {{-- <td>{{ $item->ubicac_fisica}}</td> --}}
                                        <td class="text-center">
                                            <span class="badge px-3 py-1 rounded-pill {{ $item->estado == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                                {{ $item->estado === '1' ? 'ASIGNADO' : 'LIBRE' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->updated_user}}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                @if ( $item->codigo_patrimonial )
                                                    <button type="button" class="btn btn-outline-dark btn-sm rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#verPersonalModal" wire:click="ver_personal('{{ $item->codigo_patrimonial }}')">
                                                        <i class="fa-solid fa-user-tie"></i>
                                                    </button> 
                                                @endif
                                                {{-- <button type="button" class="btn btn-outline-success btn-sm rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->personalatencion_id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i><br>
                                                </button>
                                                @can('mpfn.intranet.atenciones.destroy')
                                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-4 me-1">
                                                        <i class="fa-solid fa-trash-can"></i><br>
                                                    </button>
                                                @endcan --}}
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
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
