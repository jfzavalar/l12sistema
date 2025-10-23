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
                {{-- <div class="input-group mb-3"> --}}
                    <div class="row g-3">
                        <div class="col-lg-2 col-sm-12">
                            <label for="" class="btn btn-outline-primary btn-sm me-2">Total de registros:</label>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_anio" wire:model="filtro_anio" class="form-select form-select-sm me-2">
                                <option value="">-- Año --</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                    <option value="{{ $anio }}">{{ $anio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_mes" wire:model="filtro_mes" class="form-select form-select-sm me-2">
                                <option value="">-- Mes --</option>
                                @foreach ([
                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                ] as $num => $mes)
                                    <option value="{{ $num }}">{{ $mes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searchpersonal" placeholder="Buscar por DNI o Datos del Personal">
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>
                            <th scope="col">TIPO</th>
                            <th scope="col">PEDIDO</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">MEDIO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col" class="bg-success-subtle">ATENDIDO POR</th>
                            <th scope="col" class="bg-success-subtle">SOLUCIÓN</th>
                            <th scope="col">GLPI</th>
                            <th scope="col">CEA</th>
                            <th scope="col">CARPETA</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    {{-- <tbody class="align-middle">
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
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
</div>
