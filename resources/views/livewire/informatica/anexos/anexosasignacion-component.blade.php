<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-ticket"></i> ANEXOS TELEFÓNICOS:
        </h1>
        <div class="row">
            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                    <span class="alert alert-primary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                            TOTAL: {{ $estadisticas->total }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAtendido">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            ASIGNADOS: {{ $estadisticas->asignados + $estadisticas->reasignados  }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNoatendido">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            LIBRES: {{ $estadisticas->libres }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarEnviadolima">
                    <span class="alert alert-info d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            CUSTODIA: {{ $estadisticas->custodia }}
                        </span>
                    </span>
                </button>
            </div>
        </div>
    </div>

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
                            <th scope="col">REGIMEN - CARGO</th>
                            {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col" class="table-success">ANEXO</th>
                            <th scope="col" class="table-success">SERIE</th>
                            <th scope="col" class="table-success">ESTADO</th>
                            <th scope="col" class="table-success"></th>
                            <th scope="col" class="table-success">FECHA</th>
                            <th scope="col" class="table-dark">INFORMÁTICO</th>
                            <th scope="col" class="table-success">REGISTRADO POR</th>
                            <th scope="col" class="table-dark" colspan="3" ><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_activos as $item)
                            <tr>
                                <th>
                                    <i class="fa-solid fa-phone-volume me-1"></i>{{ $loop->iteration }}
                                </th>
                                <td>
                                    <b>{{ $item->dni }}</b>
                                    <br> {{ $item->datos }}
                                    <br>{{ $item->created_at }}
                                </td>
                                <td>
                                    <b>{{ $item->regimen }}</b>
                                    <br>
                                    {{ $item->cargo }}
                                </td>
                                <td>
                                    <b>SEDE: </b>{{ $item->sededestino }}
                                    <br>
                                    <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                    <br>
                                    <b>DESPACHO: </b>{{ $item->despachodestino }}
                                </td>
                                <td>
                                    <span class="badge py-1 bg-primary-subtle text-primary fs-7">
                                        {{ $item->anexo }}
                                    </span>
                                </td>
                                <th class="text-center">
                                    {{ $item->serie }}
                                    <br>{{ $item->marca }}
                                    <br>{{ $item->modelo }}
                                </th>
                                <td>{{ $item->estado }}</td>
                                <td>
                                    <span class="badge py-1 {{ in_array($item->asignacionlibrecustodia, ['ASIGNACION', 'REASIGNACION']) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $item->asignacionlibrecustodia }}
                                    </span>
                                    {{ $item->custodia }}
                                </td>
                                <td>
                                    Desde: {{ $item->asignacionlibrecustodiadesde}}
                                    <br>Hasta: {{ $item->asignacionlibrecustodiahasta}}
                                </td>
                                <td>{{ $item->informatico }}</td>
                                <td>{{ $item->created_user }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>
                                        @if ( $item->asignacionlibrecustodia !== "ASIGNACION" && $item->asignacionlibrecustodia !== "REASIGNACION")
                                            <button type="button" class="btn btn-outline-primary btn-xs" wire:click="nuevo({{ $item->id }},'REASIGNACION')">
                                                <i class="fa-solid fa-right-to-bracket"></i><br>Reasignar
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="nuevo({{ $item->id }},'DEVOLUCION')">
                                                <i class="fa-solid fa-right-from-bracket"></i><br>Devolver
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.anexotelefonico-acta', ['id' => $item->id]) }}" target="_blank">
                                            <i class="fa-solid fa-file-pdf"></i><br>Acta
                                        </a>
                                        <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                            <i class="fa-solid fa-upload"></i><br>Cargar
                                        </button>
                                        @if($item->ruta_documento)
                                            <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-file-signature"></i><br> Firmado
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-xs" wire:click="historial('{{ $item->anexo_id }}')">
                                        <i class="fa-solid fa-timeline"></i><br>Historial
                                    </button>  
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        ¡No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
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

    <div>
        {{-- Modal Nuevo-Editar --}}
        <div class="modal fade @if($modalNuevoEditarAbrir) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
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
                                    <fieldset class="border p-3 rounded mb-3" {{ $seccionDetalle }}>
                                        <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted text-center rounded bg-{{ $colorHeaderModal }}">DETALLES DEL ANEXO</legend>
                                        {{-- @include('livewire.rrhh.contratos.partials.datos-contrato-component') --}}
                                        <div class="row">
                                            <div class="col-xl-9">
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <label for="txtanexo" class="fw-bold fs-6">ANEXO:</label>
                                                        <div class="input-group input-group-xs">
                                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm" data-bs-toggle="modal" data-bs-target="#buscar-sedes-component">
                                                                <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                                            </button>
                                                            <input type="text" id="txtanexo" class="form-control form-control-sm" wire:model="anexo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="txtserie" class="fw-bold fs-6">SERIE:</label>
                                                        <input type="text" id="txtserie" class="form-control form-control-xs" wire:model="serie">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="txtmarca" class="fw-bold fs-6">MARCA:</label>
                                                        <input type="text" id="txtmarca" class="form-control form-control-xs" wire:model="marca" disabled>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="txtmodelo" class="fw-bold fs-6">MODELO:</label>
                                                        <input type="text" id="txtmodelo" class="form-control form-control-xs" wire:model="modelo" disabled>
                                                    </div>

                                                    <div class="col-xl-3">
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
                                                    
                                                    <div class="col-xl-3">
                                                        <label for="txtcargador" class="fw-bold fs-6">TRANSFORMADOR:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="Si" name="cargador" class="btn-check" value="SI" autocomplete="off" wire:model="transformador">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si">SI</label>

                                                            <input type="radio" id="No" name="cargador" class="btn-check" value="NO" autocomplete="off" wire:model="transformador">
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
                                                    <div class="col-xl-6">
                                                        <label for="txtcustodia" class="fw-bold fs-6">ASIGNACIÓN</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="asignacion" name="asignacionlibrecustodia"" class="btn-check" value="ASIGNACION" autocomplete="off" wire:model="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="asignacion">ASIGNACION</label>

                                                            <input type="radio" id="reasignacion" name="asignacionlibrecustodia"" class="btn-check" value="REASIGNACION" autocomplete="off" wire:model="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="reasignacion">REASIGNACION</label>

                                                            <input type="radio" id="devolucion" name="asignacionlibrecustodia"" class="btn-check" value="DEVOLUCION" autocomplete="off" wire:model="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="devolucion">DEVOLUCION</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="text-center">
                                                    @if ($tipo === "1")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo1.png') }}" width="250">
                                                    @elseif ($tipo === "2")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo2.png') }}" width="250">
                                                    @elseif ($tipo === "3")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo3.png') }}" width="250">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="border p-3 rounded mb-3">
                                        <div class="row">
                                            
                                            @if ($asignacionlibrecustodia === "REASIGNACION")
                                                <div class="col-12 col-xl">
                                                    <label for="txtbase" class="fw-bold fs-6">CUSTODIA</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="Si4" name="custodia" class="btn-check" value="SI" autocomplete="off" wire:model.live="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="Si4">SI</label>

                                                        <input type="radio" id="No4" name="custodia" class="btn-check" value="NO" autocomplete="off" wire:model.live="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="No4">NO</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($custodia === "SI")
                                                <div class="col-12 col-xl">
                                                    <label for="txtcustodia" class="fw-bold fs-6">MOTIVO</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="renuncia" name="motivo" class="btn-check" value="RENUNCIA" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="renuncia">RENUNCIA</label>

                                                        <input type="radio" id="licencia" name="motivo" class="btn-check" value="LICENCIA" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="licencia">LICENCIA</label>

                                                        <input type="radio" id="vacaciones" name="motivo" class="btn-check" value="VACACIONES" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="vacaciones">VACACIONES</label>                     
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($motivo === "LICENCIA" || $motivo === "VACACIONES")
                                                <div class="col-12 col-xl">
                                                    <label for="txtdede" class="fw-bold fs-6">DESDE:</label>
                                                    <input type="date" id="txtdede" class="form-control form-control-sm" wire:model="asignacionlibrecustodiadesde">
                                                </div>
                                                <div class="col-12 col-xl">
                                                    <label for="txthasta" class="fw-bold fs-6">HASTA:</label>
                                                    <input type="date" id="txthasta" class="form-control form-control-sm">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label for="txtobservacion" class="fw-bold fs-6">OBSERVACIÓN:</label>
                                                <input type="text" id="txtobservacion" class="form-control form-control-sm" wire:model="observacion">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="txt_informatico" class="fw-bold fs-6">INFORMÁTICO RESPONSABLE</label>
                                                <select id="txt_informatico" class="form-select form-select-sm" wire:model="informatico_dni" required>
                                                    <option value="">Seleccionar...</option>
                                                    @foreach ($lista_informaticos as $item)
                                                        <option value="{{ $item->dni }}">
                                                            {{ $item->dni . ' - ' . $item->datos }}
                                                        </option>
                                                    @endforeach
                                                </select>
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

        {{-- Modal historial --}}
        <div class="modal fade @if($modalHistorial) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog" style="max-width:90%;">
                <div class="modal-content">
                    <div class="modal-header bg-{{ $colorHeaderModal }}">
                        <h1 class="modal-title fs-5" id="nuevoEditarModalLabel">
                            <i class="fa-solid fa-file"></i> {{ $textoHeaderModal }}
                        </h1>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="historial_cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text fw-bold" id="basic-addon2">Total: </span>
                                        <input type="text" id="txtsearchusuario2" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI, Apellidos y Nombres o Anexo">
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
                                        <th scope="col">REGIMEN - CARGO</th>
                                        {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                                        <th scope="col">DEPENDENCIA</th>
                                        <th scope="col" class="table-success">ANEXO</th>
                                        <th scope="col" class="table-success">SERIE</th>
                                        <th scope="col" class="table-success">ESTADO</th>
                                        <th scope="col" class="table-success"></th>
                                        <th scope="col" class="table-success">FECHA</th>
                                        <th scope="col" class="table-dark">INFORMÁTICO</th>
                                        <th scope="col" class="table-success">REGISTRADO POR</th>
                                        <th scope="col" class="table-dark" colspan="1" ><i class="fa-solid fa-gears"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse ($lista_historial as $item)
                                        <tr>
                                            <th>
                                                <i class="fa-solid fa-phone-volume me-1"></i>{{ $loop->iteration }}
                                            </th>
                                            <td>
                                                <b>{{ $item->dni }}</b>
                                                <br> {{ $item->datos }}
                                                <br>{{ $item->created_at }}
                                            </td>
                                            <td>
                                                <b>{{ $item->regimen }}</b>
                                                <br>
                                                {{ $item->cargo }}
                                            </td>
                                            <td>
                                                <b>SEDE: </b>{{ $item->sededestino }}
                                                <br>
                                                <b>DEPENDENCIA: </b>{{ $item->dependenciadestino }}
                                                <br>
                                                <b>DESPACHO: </b>{{ $item->despachodestino }}
                                            </td>
                                            <td>
                                                <span class="badge py-1 bg-primary-subtle text-primary fs-7">
                                                    {{ $item->anexo }}
                                                </span>
                                            </td>
                                            <th class="text-center">
                                                {{ $item->serie }}
                                                <br>{{ $item->marca }}
                                                <br>{{ $item->modelo }}
                                            </th>
                                            <td>{{ $item->estado }}</td>
                                            <td>
                                                <span class="badge py-1 {{ in_array($item->asignacionlibrecustodia, ['ASIGNACION', 'REASIGNACION']) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                    {{ $item->asignacionlibrecustodia }}
                                                </span>
                                            </td>
                                            <td>
                                                Desde: {{ $item->asignacionlibrecustodiadesde}}
                                                <br>Hasta: {{ $item->asignacionlibrecustodiahasta}}
                                            </td>
                                            <td>{{ $item->informatico }}</td>
                                            <td>{{ $item->created_user }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a type="button" class="btn btn-outline-naranja btn-xs" href="{{ route('pdf.informatica.anexotelefonico-acta', ['id' => $item->id]) }}" target="_blank">
                                                        <i class="fa-solid fa-file-pdf"></i><br>Acta
                                                    </a>
                                                    <button type="button" class="btn btn-outline-warning btn-xs" wire:click="editar_pdf({{ $item->id }})">
                                                        <i class="fa-solid fa-upload"></i><br>Cargar
                                                    </button>
                                                    @if($item->ruta_documento)
                                                        <a type="button" class="btn btn-outline-dark btn-xs" href="{{ asset('storage/'.$item->ruta_documento) }}" target="_blank">
                                                            <i class="fa-solid fa-eye"></i> <i class="fa-solid fa-file-signature"></i><br> Firmado
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    ¡No se encontraron resultados!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        {{-- <td colspan="8">{{ $lista_activos->links() }}</td> --}}
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="historial_cerrar">
                            <i class="fa-solid fa-rectangle-xmark"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>


        {{--MODAL BUSCAR PERSONAL --}}
        @include('livewire.partials.modales.buscar-personal-datos')

        {{-- MODALE BUSCAR SEDES-DEPENDENCIAS-DESPACHOS --}}
        @include('livewire.partials.modales.buscar-personal-sede-dependencia-despacho')
        
        {{-- MODAL BUSCAR CARGO --}}
        @include('livewire.partials.modales.buscar-personal-cargo')

        {{-- MODAL CARGAR PDF --}}
        @include('livewire.partials.modales.cargar-pdf-acta')
        @include('livewire.partials.modales.cargar-pdf-evidencia')

    </div>

</div>

