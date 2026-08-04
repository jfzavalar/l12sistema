<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm me-2" wire:model.live="search" placeholder="Buscar quién transfiere">
                            @can('mpfn.patrimonio.asignaciones.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> PERSONAL QUE TRANSFIERE
                            </th>
                            <th scope="col" class="table-success">
                                <i class="fa-solid fa-user"></i> PERSONAL QUE RECEPCIONA
                            </th>
                            <th scope="col">CANTIDAD DE BIENES ASIGNADOS</th>
                            <th scope="col" class="table-dark"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>
                                    <b>DNI:</b> {{ $item->dni }}
                                    <br><b>DATOS:</b> {{ $item->datos }}
                                    <br><b>CARGO:</b> {{ $item->cargo }}
                                    <br><b>SEDE:</b> {{ $item->sede }}
                                    <br><b>DEPENDENCIA:</b> {{ $item->dependencia }}
                                    <br><b>DESPACHO:</b> {{ $item->despacho }}
                                </td>
                                <td>
                                    <b>DNI:</b> {{ $item->dni2 }}
                                    <br><b>DATOS:</b> {{ $item->datos2 }}
                                    <br><b>CARGO:</b> {{ $item->cargo2 }}
                                    <br><b>SEDE:</b> {{ $item->sede2 }}
                                    <br><b>DEPENDENCIA:</b> {{ $item->dependencia2 }}
                                    <br><b>DESPACHO:</b> {{ $item->despacho2 }}
                                </td>
                                <td></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('mpfn.patrimonio.asignaciones.create')
                                            <button type="button" class="btn btn-outline-success btn-xs" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan
                                        <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.patrimonio.bienesasignados-acta', $item->id) }}" target="_blank">
                                            <i class="fa-solid fa-file-pdf"></i><br>Acta
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">{{ $lista_activos->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Nuevo-Editar --}}
    <div wire:ignore.self class="modal fade" id="nuevoEditarModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nuevoEditarModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:90%;">
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
                            {{-- <div class="col-xl-2 col-sm-12">
                                <fieldset class="border p-3 rounded text-center mb-3" {{ $seccionFoto }}>
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">FOTO DE PERFIL</legend>
                                    @include('livewire.rrhh.personal.partials.datos-foto-component')
                                </fieldset>
                            </div> --}}

                            <div class="col-xl-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS ASIGNADO</legend>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-6 col-sm-12">      
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_dni2" class="fw-bold fs-6">DNI</label>
                                                            <div class="input-group">
                                                                <button type="button" class="btn btn-dark btn-xs"data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                                                </button>
                                                                <input type="text" id="txt_dni2" maxlength="8" pattern="[0-9]*" placeholder="DNI" wire:model.lazy="dni2" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)" class="form-control form-control-xs @error('dni') is-invalid border-danger shadow-sm @enderror bg-light" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_nombres" class="fw-bold fs-6">Nombres</label>
                                                            <input type="text" id="txt_nombres" class="form-control form-control-xs text-uppercase bg-light" placeholder="Nombres" wire:model="nombres" readonly>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_appaterno" class="fw-bold fs-6">Apellido paterno</label>
                                                            <input type="text" id="txt_appaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido paterno" wire:model="appaterno" readonly>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_apmaterno" class="fw-bold fs-6">Apellido materno</label>
                                                            <input type="text" id="txt_apmaterno" class="form-control form-control-xs text-uppercase bg-light" placeholder="Apellido materno" wire:model="apmaterno" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_celular_personal" class="fw-bold fs-6">Celular personal</label>
                                                            <input type="text" id="txt_celular_personal" class="form-control form-control-xs bg-light" maxlength="9" pattern="[0-9]*" placeholder="Celular personal" wire:model="celpersonal" oninput="this.value = this.value.replace(/\D/g,'').slice(0,9)" readonly>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txtcelular_institucional" class="fw-bold fs-6">Celular institucional</label>
                                                            <input type="text" id="txtcelular_institucional" class="form-control form-control-xs bg-light" wire:model="celinstitucional" readonly>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txt_correo_personal" class="fw-bold fs-6">Email personal</label>
                                                            <input type="text" id="txt_correo_personal" class="form-control form-control-xs text-lowercase bg-light" placeholder="Correo personal" wire:model="correopersonal" readonly>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-sm-12">
                                                            <label for="txtcorreo_institucional" class="fw-bold fs-6">Email institucional</label>
                                                            <input type="text" id="txtcorreo_institucional" class="form-control form-control-xs text-lowercase bg-light" wire:model="correoinstitucional" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('livewire.partials.componentes.personal-datos')
                                        </fieldset>
                                        <div class="row">
                                            {{-- <div class="col-xl-2">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-personal-component">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar personal
                                                </button>
                                            </div> --}}
                                            <div class="col-xl-12">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text-xs" id="basic-addon1">Referencia</span>
                                                    <input type="text" class="form-control form-control-xs" wire:model="referencia">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3">
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONAL POR ASIGNAR</legend>
                                            @include('livewire.partials.componentes.persona-datos2')
                                            @include('livewire.partials.componentes.personal-datos2')
                                        </fieldset>
                                        <div class="row">
                                            {{-- <div class="col-xl-2">
                                                <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-personal-component2">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar personal
                                                </button>
                                            </div> --}}
                                            <div class="col-xl-12">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text-xs" id="basic-addon1">Motivo</span>
                                                    <input type="text" class="form-control form-control-xs" wire:model="motivo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mt-3 mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">BIENES EN ASIGNACIÓN</legend>
                                    <div class="table-responsive-xl">
                                        <table class="table table-striped table-hover table-sm table-xsmall">
                                            <thead class="table-dark text-center align-middle">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-user"></i> COD
                                                    </th>
                                                    <th scope="col">COD PATRIMONIAL</th>
                                                    <th scope="col">BIEN</th>
                                                    <th scope="col">MARCA</th>
                                                    <th scope="col">MODELO</th>
                                                    <th scope="col">SERIE</th>
                                                    <th scope="col">MEDIDAS</th>
                                                    <th scope="col">COLOR</th>
                                                    <th scope="col">ESTADO</th>
                                                    <th scope="col" class="table-dark text-end">
                                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs"
                                                            data-bs-toggle="modal" data-bs-target="#buscar-bienes-component">
                                                            <i class="fa-solid fa-circle-plus"></i> Agregar bienes
                                                        </button>
                                                    </th>
                                                    {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($bienes as $index => $bien)
                                                    <tr>
                                                        <th>{{ $index + 1 }}</th>
                                                        <td>{{ $bien['codigo_barra'] }}</td>
                                                        <td>{{ $bien['codigo_patrimonial'] }}</td>
                                                        <td>{{ $bien['descripcion'] }}</td>
                                                        <td>{{ $bien['marca'] }}</td>
                                                        <td>{{ $bien['modelo'] }}</td>
                                                        <td>{{ $bien['nro_serie'] }}</td>
                                                        <td>{{ $bien['medidas'] }}</td>
                                                        <td>{{ $bien['color'] }}</td>
                                                        <td>{{ $bien['estado'] }}</td>
                                                        <td class="text-end">
                                                            <button type="button" wire:click="eliminarBien({{ $index }})" class="btn btn-danger btn-xs">
                                                                <i class="fa-solid fa-trash"></i> Quitar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="11" class="text-center">
                                                            <div class="alert alert-danger" role="alert">
                                                                ¡No se encontraron resultados!
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
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


    {{-- @include('livewire.rrhh.personal.partials.buscar-personal-component') --}}
    <!-- Modal buscar personal -->
    <div wire:ignore.self class="modal fade" id="buscar-personal-component" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="buscar-personal-componentLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-5">
                <form action="">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="buscar-personal-componentLabel">
                            <i class="fa-solid fa-magnifying-glass"></i> BUSCAR PERSONAL
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_personas->total() }}</span>
                                            <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar personal" wire:model.live="searchpersonas">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-hover table-sm table-xsmall">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Datos</th>
                                        <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lista_personas as $persona)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $persona->dni }}</th>
                                            <td>{{ $persona->datos }}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_persona({{ $persona->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                            <i class="fa-solid fa-circle-plus"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            {{ $lista_personas->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                       
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                            <i class="fa-solid fa-door-closed"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('livewire.rrhh.personal.partials.buscar-personal-component2')
    @include('livewire.rrhh.personal.partials.buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.buscar-despachos-component')
    @include('livewire.rrhh.personal.partials.buscar-cargos-component')

    {{-- @include('livewire.rrhh.personal.partials.2buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.2buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.2buscar-despachos-component') --}}

    @include('livewire.rrhh.contratos.partials.pdf-cargar-component')

    {{-- Modal bienes patrimoniales --}}
    @include('livewire.patrimonio.bienes.partials.buscar-bienes-component')

</div>
