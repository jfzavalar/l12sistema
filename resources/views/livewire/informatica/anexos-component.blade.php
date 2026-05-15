<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text fw-bold" id="basic-addon2">Total: </span>
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI, Apellidos y Nombres o Anexo">
                            {{-- @can('mpfn.rrhh.personal.create') --}}
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            {{-- @endcan --}}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col">DEPENDENCIA ORIGEN</th>
                            <th scope="col">REGIMEN - CARGO</th>
                            <th scope="col" class="table-danger">ROTACIÓN: UBICACIÓN FÍSICA</th>
                            <th scope="col">MEDIOS DE COMUNICACIÓN</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" class="table-success">ANEXO</th>
                            <th scope="col" class="table-success">ESTADO</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        {{-- @forelse ($lista_activos as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $item->cod }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->nombred }}</td>
                                <td>{{ $item->direccion }}</td>
                                <td>{{ $item->departamento }}</td>
                                <td>{{ $item->provincia }}</td>
                                <td>{{ $item->distrito }}</td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            {{-- <td colspan="8">{{ $lista_activos->links() }}</td> --}}
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
                            <div class="col-xl-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersona }}>
                                            <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DATOS PERSONALES</legend>
                                            @include('livewire.partials.componentes.persona-datos')
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6">
                                        <fieldset class="border p-3 rounded mb-3" {{ $seccionPersonal }}>
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
                        <div class="row">
                            <div class="col">
                                <fieldset class="border p-3 rounded mb-3">
                                    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLES DEL ANEXO</legend>
                                    {{-- @include('livewire.rrhh.contratos.partials.datos-contrato-component') --}}
                                    <div class="row">
                                        <div class="col-xl-8">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label for="txtanexo" class="fw-bold fs-6">ANEXO:</label>
                                                    <div class="input-group input-group-xs">
                                                        <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-xs" data-bs-toggle="modal" data-bs-target="#buscar-sedes-component">
                                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar anexo
                                                        </button>
                                                        <input type="text" id="txtanexo" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="1" class="fw-bold fs-6">TIPO</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="1" name="tipo" class="btn-check" value="1" autocomplete="off" wire:model.live="tipo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="1">1</label>

                                                        <input type="radio" id="2" name="tipo" class="btn-check" value="2" autocomplete="off" wire:model.live="tipo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="2">2</label>

                                                        <input type="radio" id="3" name="tipo" class="btn-check" value="3" autocomplete="off" wire:model.live="tipo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="3">3</label>
                                                    </div>
                                                    @error('regimen')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txtmarca" class="fw-bold fs-6">MARCA:</label>
                                                    <input type="text" id="txtserie" class="form-control form-control-sm" wire:model="marca" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txtmodelo" class="fw-bold fs-6">MODELO:</label>
                                                    <input type="text" id="txtserie" class="form-control form-control-sm" wire:model="modelo" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txtserie" class="fw-bold fs-6">SERIE:</label>
                                                    <input type="text" id="txtserie" class="form-control form-control-sm">
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="txtestado" class="fw-bold fs-6">ESTADO:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="BUENO" name="estado" class="btn-check" value="BUENO" autocomplete="off" wire:model="estado">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="BUENO">BUENO</label>

                                                        <input type="radio" id="MALO" name="estado" class="btn-check" value="MALO" autocomplete="off" wire:model="estado">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="MALO">MALO</label>

                                                        <input type="radio" id="REGULAR" name="estado" class="btn-check" value="REGULAR" autocomplete="off" wire:model="estado">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="REGULAR">REGULAR</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label for="txtcargador" class="fw-bold fs-6">TRANSFORMADOR:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="Si" name="cargador" class="btn-check" value="SI" autocomplete="off" wire:model="cargador">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si">SI</label>

                                                        <input type="radio" id="No" name="cargador" class="btn-check" value="NO" autocomplete="off" wire:model="cargador">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="No">NO</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label for="txtauticulares" class="fw-bold fs-6">AURICULARES:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="Si2" name="auriculares" class="btn-check" value="SI" autocomplete="off" wire:model="auriculares">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si2">SI</label>

                                                        <input type="radio" id="No2" name="auriculares" class="btn-check" value="NO" autocomplete="off" wire:model="auriculares">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="No2">NO</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label for="txtbase" class="fw-bold fs-6">BASE AURICULAR:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="Si3" name="baseauricular" class="btn-check" value="SI" autocomplete="off" wire:model="baseauriculares">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si3">SI</label>

                                                        <input type="radio" id="No3" name="baseauricular" class="btn-check" value="NO" autocomplete="off" wire:model="baseauriculares">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="No3">NO</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label for="txtcustodia" class="fw-bold fs-6">CUSTODIA:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="Si4" name="custodia" class="btn-check" value="SI" autocomplete="off" wire:model="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si4">SI</label>

                                                        <input type="radio" id="No4" name="custodia" class="btn-check" value="NO" autocomplete="off" wire:model="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="No4">NO</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="txtobservacion" class="fw-bold fs-6">OBSERVACIÓN:</label>
                                                    <input type="text" id="txtobservacion" class="form-control form-control-sm" wire:model="observacionanexo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="text-center">
                                                @if ($tipo === "1")
                                                    <img src="{{ asset('storage/imagenes/anexos/tipo1.png') }}" width="400">
                                                @elseif ($tipo === "2")
                                                    <img src="{{ asset('storage/imagenes/anexos/tipo2.png') }}" width="400">
                                                @elseif ($tipo === "3")
                                                    <img src="{{ asset('storage/imagenes/anexos/tipo3.png') }}" width="400">
                                                @endif
                                            </div>
                                        </div>
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

    @include('livewire.rrhh.personal.partials.buscar-personal-component')
    @include('livewire.rrhh.personal.partials.buscar-sedes-component')
    @include('livewire.rrhh.personal.partials.buscar-dependencias-component')
    @include('livewire.rrhh.personal.partials.buscar-despachos-component')
    @include('livewire.rrhh.personal.partials.buscar-cargos-component')

    @include('livewire.rrhh.contratos.partials.pdf-cargar-component')
</div>

