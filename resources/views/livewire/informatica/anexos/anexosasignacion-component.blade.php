<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
        <h1 class="h2">
            <i class="fa-solid fa-blender-phone"></i> ANEXOS TELEFÓNICOS:
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
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAsignados">
                    <span class="alert alert-success d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            ASIGNADOS: {{ $estadisticas->asignados }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAsignados">
                    <span class="alert alert-secondary d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            REASIGNADOS: {{ $estadisticas->reasignados  }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarReasignados">
                    <span class="alert alert-danger d-block mb-0">
                        <span class="fw-bold">
                            <i class="fa-solid fa-check-double"></i>
                            DEVUELTOS: {{ $estadisticas->libres }}
                        </span>
                    </span>
                </button>
            </div>

            <div class="col-auto">
                <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarDevueltos">
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
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por Apellidos y Nombres O Anexo Telefónico">
                            @can('mpfn.informatica.anexos.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
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
                                <i class="fa-solid fa-user"></i> DNI - PERSONAL
                            </th>
                            <th scope="col">REGIMEN - CARGO</th>
                            {{-- <th scope="col">DEPENDENCIA ORIGEN</th> --}}
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col" class="table-success">ANEXO</th>
                            {{-- <th scope="col" class="table-success">SERIE</th> --}}
                            <th scope="col" class="table-success">ESTADO</th>
                            <th scope="col" class="table-success">EN_CUSTODIA</th>
                            {{-- <th scope="col" class="table-success">FECHA</th> --}}
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
                                <td class="text-center">
                                    <span class="badge py-1 bg-primary-subtle text-primary fs-7">
                                        {{ $item->anexo }}
                                    </span>
                                    <br>{{ $item->serie }}
                                    <br>{{ $item->marca }}
                                    <br>{{ $item->modelo }}
                                </td>
                                {{-- <th class="text-center">
                                    {{ $item->serie }}
                                    <br>{{ $item->marca }}
                                    <br>{{ $item->modelo }}
                                </th> --}}
                                <td class="text-center">
                                    <b>{{ $item->estado }}</b>
                                    <br>
                                    <span class="badge py-1 {{ in_array($item->asignacionlibrecustodia, ['ASIGNACION', 'REASIGNACION']) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $item->asignacionlibrecustodia }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge py-1 {{ in_array($item->custodia, ['NO']) ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} fs-7">
                                        {{ $item->custodia }}
                                    </span>
                                    <br>
                                    @if ($item->custodia === "SI")
                                        <b>Desde:</b>
                                        <br>
                                        <span class="text-primary">{{ $item->asignacionlibrecustodiadesde }}</span>
                                        <br>
                                        <b>Hasta:</b>
                                        <br>
                                        <span class="text-primary">{{ $item->asignacionlibrecustodiahasta}}</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    Desde: {{ $item->asignacionlibrecustodiadesde}}
                                    <br>Hasta: {{ $item->asignacionlibrecustodiahasta}}
                                </td> --}}
                                <td>{{ $item->informatico }}</td>
                                <td>{{ $item->created_user }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('mpfn.informatica.anexos.edit')
                                            <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                            </button>
                                        @endcan                                       
                                        {{-- @if ( $item->asignacionlibrecustodia !== "ASIGNACION" && $item->asignacionlibrecustodia !== "REASIGNACION") --}}
                                            <button type="button" class="btn btn-outline-primary btn-xs" wire:click="nuevo({{ $item->id }},'REASIGNACION')">
                                                <i class="fa-solid fa-right-to-bracket"></i><br>Reasignar
                                            </button>
                                        {{-- @else
                                            <button type="button" class="btn btn-outline-danger btn-xs" wire:click="nuevo({{ $item->id }},'DEVOLUCION')">
                                                <i class="fa-solid fa-right-from-bracket"></i><br>Devolver
                                            </button>
                                        @endif --}}
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
                                                            <button type="button" class="btn btn-{{ $colorGuardarActualizar }} btn-sm" wire:click="anexoBuscar">
                                                                <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                                            </button>
                                                            <input type="text" id="txtanexo" class="form-control form-control-sm" wire:model="anexo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="txtserie" class="fw-bold fs-6">SERIE:</label>
                                                        <input type="text" id="txtserie" class="form-control form-control-xs" wire:model="serie" disabled>
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
                                                        <label for="transformador_si" class="fw-bold fs-6">TRANSFORMADOR:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="transformador_si" name="transformador" class="btn-check" value="SI" autocomplete="off" wire:model.live="transformador">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="transformador_si">SI</label>

                                                            <input type="radio" id="transformador_no" name="transformador" class="btn-check" value="NO" autocomplete="off" wire:model.live="transformador">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="transformador_no">NO</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="auriculares_si" class="fw-bold fs-6">AURICULARES:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="auriculares_si" name="auriculares" class="btn-check" value="SI" autocomplete="off" wire:model.live="auriculares">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="auriculares_si">SI</label>

                                                            <input type="radio" id="auriculares_no" name="auriculares" class="btn-check" value="NO" autocomplete="off" wire:model.live="auriculares">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="auriculares_no">NO</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label for="baseauricular_si" class="fw-bold fs-6">BASE AURICULAR:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="baseauricular_si" name="baseauricular" class="btn-check" value="SI" autocomplete="off" wire:model.live="baseauriculares">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="baseauricular_si">SI</label>

                                                            <input type="radio" id="baseauricular_no" name="baseauricular" class="btn-check" value="NO" autocomplete="off" wire:model.live="baseauriculares">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="baseauricular_no">NO</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label for="estado_bueno" class="fw-bold fs-6">ESTADO:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="estado_bueno" name="estado" class="btn-check" value="BUENO" autocomplete="off" wire:model.live="estado">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="estado_bueno">BUENO</label>

                                                            <input type="radio" id="estado_malo" name="estado" class="btn-check" value="MALO" autocomplete="off" wire:model.live="estado">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="estado_malo">MALO</label>

                                                            <input type="radio" id="estado_regular" name="estado" class="btn-check" value="REGULAR" autocomplete="off" wire:model.live="estado">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="estado_regular">REGULAR</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label for="alc_asignacion" class="fw-bold fs-6">ASIGNACIÓN:</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" id="alc_asignacion" name="asignacionlibrecustodia" class="btn-check" value="ASIGNACION" autocomplete="off" wire:model.live="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="alc_asignacion">ASIGNACIÓN</label>

                                                            <input type="radio" id="alc_reasignacion" name="asignacionlibrecustodia" class="btn-check" value="REASIGNACION" autocomplete="off" wire:model.live="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="alc_reasignacion">REASIGNACIÓN</label>

                                                            <input type="radio" id="alc_devolucion" name="asignacionlibrecustodia" class="btn-check" value="DEVOLUCION" autocomplete="off" wire:model.live="asignacionlibrecustodia">
                                                            <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="alc_devolucion">DEVOLUCIÓN</label>
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
                                                    <label for="custodia_si" class="fw-bold fs-6">CUSTODIA:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="custodia_si" name="custodia" class="btn-check" value="SI" autocomplete="off" wire:model.live="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="custodia_si">SI</label>

                                                        <input type="radio" id="custodia_no" name="custodia" class="btn-check" value="NO" autocomplete="off" wire:model.live="custodia">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="custodia_no">NO</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($custodia === "SI")
                                                <div class="col-12 col-xl">
                                                    <label for="motivo_renuncia" class="fw-bold fs-6">MOTIVO:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="radio" id="motivo_renuncia" name="motivo" class="btn-check" value="RENUNCIA" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="motivo_renuncia">RENUNCIA</label>

                                                        <input type="radio" id="motivo_licencia" name="motivo" class="btn-check" value="LICENCIA" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="motivo_licencia">LICENCIA</label>

                                                        <input type="radio" id="motivo_vacaciones" name="motivo" class="btn-check" value="VACACIONES" autocomplete="off" wire:model.live="motivo">
                                                        <label class="btn btn-outline-{{ $colorGuardarActualizar }} btn-xs flex-fill" for="motivo_vacaciones">VACACIONES</label>
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
                                                    <input type="date" id="txthasta" class="form-control form-control-sm" wire:model="asignacionlibrecustodiahasta">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-1">
                                                <label for="cmbpiso" class="fw-bold fs-6">PISO:</label>
                                                <select name="" id="cmbpiso" class="form-select form-select-sm" wire:model="piso">
                                                    <option value="">...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-1">
                                                <label for="txtoficina" class="fw-bold fs-6">OFICINA:</label>
                                                <input type="text" id="txtoficina" class="form-control form-control-sm" wire:model="oficina">
                                            </div>

                                            <div class="col-xl-5">
                                                <label for="txtobservacion" class="fw-bold fs-6">OBSERVACIÓN:</label>
                                                <input type="text" id="txtobservacion" class="form-control form-control-sm" wire:model="observacion">
                                            </div>
                                            <div class="col-xl-5">
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
                                        {{-- <th scope="col" class="table-success">SERIE</th> --}}
                                        <th scope="col" class="table-success">ESTADO</th>
                                        <th scope="col" class="table-success">CUSTODIA</th>
                                        {{-- <th scope="col" class="table-success">FECHA</th> --}}
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
                                            <td class="text-center">
                                                <span class="badge py-1 bg-primary-subtle text-primary fs-7">
                                                    {{ $item->anexo }}
                                                </span>
                                                <br>{{ $item->serie }}
                                                <br>{{ $item->marca }}
                                                <br>{{ $item->modelo }}
                                            </td>
                                            {{-- <th class="text-center">
                                                
                                            </th> --}}
                                            <td class="text-center">
                                                {{ $item->estado }}
                                                <br>
                                                <span class="badge py-1 {{ in_array($item->asignacionlibrecustodia, ['ASIGNACION', 'REASIGNACION']) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                    {{ $item->asignacionlibrecustodia }}
                                                </span>
                                            </td>
                                            {{-- <td>
                                                
                                            </td> --}}
                                            <td class="text-center">
                                                <span class="badge py-1 {{ in_array($item->custodia, ['NO']) ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} fs-7">
                                                    {{ $item->custodia }}
                                                </span>
                                                <br>
                                                @if ($item->custodia === "SI")
                                                    <b>Desde:</b>
                                                    <br>
                                                    <span class="text-primary">{{ $item->asignacionlibrecustodiadesde }}</span>
                                                    <br>
                                                    <b>Hasta:</b>
                                                    <br>
                                                    <span class="text-primary">{{ $item->asignacionlibrecustodiahasta}}</span>
                                                @endif
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

        <div class="modal fade @if($modalAnexoBuscar) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content rounded-5">
                    <form action="">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="buscar-personal-componentLabel">
                                <i class="fa-solid fa-magnifying-glass"></i> BUSCAR ANEXO
                            </h1>
                            <button type="button" class="btn-close" wire:click="cerrarBuscar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive-xl">
                                <form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text input-group-text-xs fw-bold" id="basic-addon2">Total: {{ $lista_personas->total() }}</span>
                                                <input type="text" id="txtSearchAnexo" class="form-control form-control-sm" placeholder="Buscar anexo ..." wire:model.live="searchanexos">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-striped table-hover table-sm table-xsmall align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th></th>
                                            <th scope="col">ANEXO</th>
                                            <th scope="col">SERIE</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">MODELO</th>
                                            <th scope="col">MARCA</th>
                                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lista_anexos as $anexo)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>
                                                    @if ($anexo->tipo === "1")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo1.png') }}" width="80">
                                                    @elseif ($anexo->tipo === "2")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo2.png') }}" width="80">
                                                    @elseif ($anexo->tipo === "3")
                                                        <img src="{{ asset('storage/imagenes/anexos/tipo3.png') }}" width="80">
                                                    @endif
                                                </td>
                                                <th class="text-center fs-7">
                                                    {{ $anexo->anexo }}
                                                    <br>
                                                    <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar_anexo({{ $anexo->id }})">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </th>
                                                <td class="text-center">{{ $anexo->serie }}</td>
                                                <td class="text-center">{{ $anexo->tipo }}</td>
                                                <td class="text-center">{{ $anexo->modelo }}</td>
                                                <td class="text-center">{{ $anexo->marca }}</td>
                                                <td>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_anexo({{ $anexo->id }})">
                                                                <i class="fa-solid fa-circle-plus"></i><br>Agregar
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
                                            <td colspan="8">
                                                {{ $lista_anexos->links() }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>                       
                            </div>          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrarBuscar">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL PARA ACTUALIZAR ANEXO --}}

        <div class="modal fade @if($modalAnexoTelefonico) show d-block @endif bg-secondary bg-opacity-75" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-5">
                    <form wire:submit.prevent="actualizar_anexo">
                        <div class="modal-header bg-{{ $colorHeaderModal }}">
                            <h1 class="modal-title fs-5" id="buscar-personal-componentLabel">
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR ANEXO
                            </h1>
                            <button type="button" class="btn-close" wire:click="cerrar_anexo"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive-xl">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-6 col-sm-3">
                                        <label for="txtanexo2" class="fw-bold">ANEXO</label>
                                        <input type="text" id="txtanexo2" class="form-control form-control-sm" wire:model="anexo2">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-3">
                                        <label for="txtserie2" class="fw-bold">SERIE</label>
                                        <input type="text" id="txtserie2" class="form-control form-control-sm" wire:model="serie2">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-3">
                                        <label for="txttipo2" class="fw-bold">TIPO</label>
                                        <input type="text" id="txttipo2" class="form-control form-control-sm" wire:model="tipo2">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-3">
                                        <label for="txtmodelo2" class="fw-bold">MODELO</label>
                                        <input type="text" id="txtmodelo2" class="form-control form-control-sm" wire:model="modelo2">
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-3">
                                        <label for="txtmarca2" class="fw-bold">MARCA</label>
                                        <input type="text" id="txtmarca2" class="form-control form-control-sm" wire:model="marca2">
                                    </div>
                                    <div class="col-12 text-center">
                                        @if ($tipo2 === "1")
                                            <img src="{{ asset('storage/imagenes/anexos/tipo1.png') }}" width="300">
                                        @elseif ($tipo2 === "2")
                                            <img src="{{ asset('storage/imagenes/anexos/tipo2.png') }}" width="300">
                                        @elseif ($tipo2 === "3")
                                            <img src="{{ asset('storage/imagenes/anexos/tipo3.png') }}" width="300">
                                        @endif
                                    </div>
                                </div>                    
                            </div>          
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-{{ $colorGuardarActualizar }} btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Actualizar
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="cerrar_anexo">
                                <i class="fa-solid fa-door-closed"></i> Cerrar
                            </button>
                        </div>
                    </form>
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

