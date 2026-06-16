<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">REDES</th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-primary btn-xs text-nowrap w-100" wire:click = "filtrarTotal('')">
                                        <i class="fa-solid fa-check-double"></i>TOTAL
                                    </button>
                                </th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-success btn-xs text-nowrap w-100" wire:click = "filtrarAsignados('')">
                                        <i class="fa-solid fa-check me-2"></i>ASIG
                                    </button>
                                </th>
                                <th scope="col" class="text-center">
                                    <button type="button" class="btn btn-danger btn-xs text-nowrap w-100" wire:click = "filtrarLibres('')">
                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>LIBRES
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reportes as $item)
                                <tr class="align-middle" style="font-size: 10px;">
                                    <th scope="row">{{ $item->red }}</th>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-xs text-nowrap w-100 d-flex justify-content-between align-items-center" wire:click = "filtrarTotal('{{ $item->red }}')">
                                            <i class="fa-solid fa-check-double"></i> {{ $item->total }}
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btn-xs text-nowrap w-100 d-flex justify-content-between align-items-center" wire:click = "filtrarAsignados('{{ $item->red }}')">
                                            <i class="fa-solid fa-check me-2"></i> {{ $item->asignados }}
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-xs text-nowrap w-100 d-flex justify-content-between align-items-center" wire:click = "filtrarLibres('{{ $item->red }}')">
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
                    <div class="table-responsive-xl">
                        <div class="row g-3">                   
                            <div class="col-lg-2 col-sm-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-10 col-sm-12">
                                <div class="input-group mb-3"> 
                                    <input type="text" id="txtsearchpersonalatenciones2" class="form-control form-control-sm me-1" placeholder="Buscar por Código Patrimonial o IP" wire:model.live="search">
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
                                            <span class="badge px-3 py-1 rounded-pill {{ $item->estado == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                {{ $item->estado === '1' ? 'ASIGNADO' : 'LIBRE' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->updated_user}}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                @if ( $item->codigo_patrimonial )
                                                    <button type="button" class="btn btn-outline-success btn-xs rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar_asignar_ip({{ $item->id }})">
                                                        <i class="fa-solid fa-pen-to-square me-1"></i>Liberar
                                                    </button> 
                                                @else
                                                    <button type="button" class="btn btn-outline-primary btn-xs rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo_asignar_ip({{ $item->id }})">
                                                        <i class="fa-solid fa-file me-1"></i>Asignar
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            @if ( $item->codigo_patrimonial )
                                                <button type="button" class="btn btn-outline-info btn-xs rounded-4 me-1" data-bs-toggle="modal" data-bs-target="#verPersonalModal" wire:click="ver_personal('{{ $item->codigo_patrimonial }}')">
                                                    <i class="fa-solid fa-user-check"></i>Usuario
                                                </button>
                                            @endif
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

    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%;">
            <div class="modal-content">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                        <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar"></button>
                </div>
                <form wire:submit.prevent="{{ $funcionGuardarActualizar }}">
                    <div class="modal-body">
                        <div class="row">
                            {{-- <div class="col-xl-1 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }} disabled>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">PERFIL</legend>
                                    @include('livewire.partials.componentes.persona-foto')
                                </fieldset>
                            </div> --}}

                            <div class="col-xl-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.partials.componentes.persona-datos')
                                        </fieldset>
                                        {{-- <input list="personales" class="form-control form-control-sm" placeholder="Seleccionar...">
                                        <datalist id="personales">
                                            @foreach ($lista_personas2 as $personal)
                                                <option value="{{ $personal->dni }}">{{ $personal->datos }}</option>
                                            @endforeach
                                        </datalist> --}}
                                    </div>
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS INSTITUCIONALES</legend>
                                            @include('livewire.partials.componentes.personal-datos')
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- REGISTRO DE TICKES --}}
                        <div class="row">
                            <fieldset class="border p-3 rounded mb-3">
                                <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">EQUIPO INFORMÁTICO</legend>
                                <div class="row g-3">
                                    <div class="col-xl-2 col-lg-6 col-sm-12">
                                        <label for="txt_cod_pat" class="form-label"><strong>Código Patrimonial</strong></label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-bienes-component">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                            <input type="text" id="txt_cod_pat" class="form-control form-control-xs text-uppercase" wire:model="codigo_patrimonial">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-sm-12">
                                        <label for="txt_equipo_detalle" class="form-label"><strong>Bien</strong></label>
                                        <input type="text" id="txt_equipo_detalle" class="form-control form-control-xs" wire:model="descripcion">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_desc_ubif" class="form-label"><strong>Marca</strong></label>
                                        <input type="text" id="txt_desc_ubif" class="form-control form-control-xs text-uppercase" wire:model="marca">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_marca" class="form-label fw-bold">Modelo</label>
                                        <input type="text" id="txt_marca" class="form-control form-control-xs text-uppercase" wire:model="modelo">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_modelo" class="form-label fw-bold">N° Serie</label>
                                        <input type="text" id="txt_modelo" class="form-control form-control-xs text-uppercase" wire:model="nro_serie">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_serie" class="form-label fw-bold">Color</label>
                                        <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="color">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_serie" class="form-label fw-bold">Estado</label>
                                        <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="estado">
                                    </div>
                                    <div class="col-xl-1 col-lg-6 col-sm-12">
                                        <label for="txt_serie" class="form-label fw-bold">Ip</label>
                                        <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase bg-primary-subtle" wire:model="bien_ip" readonly>
                                    </div>
                                </div>
                            </fieldset>     
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> {{ $textoGuardarActualizar }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </form>
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
                                <div class="col-xl-12">
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }} disabled>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">EQUIPO INFORMÁTICO</legend>
                                        <div class="row g-3">
                                            <div class="col-xl-2 col-lg-6 col-sm-12">
                                                <label for="txt_cod_pat" class="form-label"><strong>Código Patrimonial</strong></label>
                                                <input type="text" id="txt_cod_pat" class="form-control form-control-xs text-uppercase" wire:model="codigo_patrimonial">
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-sm-12">
                                                <label for="txt_equipo_detalle" class="form-label"><strong>Bien</strong></label>
                                                <input type="text" id="txt_equipo_detalle" class="form-control form-control-xs bg-light" wire:model="descripcion" readonly>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_desc_ubif" class="form-label"><strong>Marca</strong></label>
                                                <input type="text" id="txt_desc_ubif" class="form-control form-control-xs text-uppercase bg-light" wire:model="marca" readonly>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_marca" class="form-label fw-bold">Modelo</label>
                                                <input type="text" id="txt_marca" class="form-control form-control-xs text-uppercase" wire:model="modelo" required>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_modelo" class="form-label fw-bold">N° Serie</label>
                                                <input type="text" id="txt_modelo" class="form-control form-control-xs text-uppercase" wire:model="nro_serie" required>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_serie" class="form-label fw-bold">Color</label>
                                                <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="color" required>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_serie" class="form-label fw-bold">Estado</label>
                                                <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="estado" required>
                                            </div>
                                            <div class="col-xl-1 col-lg-6 col-sm-12">
                                                <label for="txt_serie" class="form-label fw-bold">Ip</label>
                                                <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="bien_ip" required>
                                            </div>
                                        </div>
                                    </fieldset>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="cerrar">
                        <i class="fa-solid fa-door-open"></i> Cerrar
                    </button>
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

    {{-- Modal burcar personal --}}
    @include('livewire.rrhh.personal.partials.buscar-personal-component')

    {{-- Modal bienes patrimoniales --}}
    @include('livewire.patrimonio.bienes.partials.buscar-bienes-component')
</div>
