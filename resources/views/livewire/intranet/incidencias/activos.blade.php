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
                            <label for="txtsearchpersonalatenciones" class="btn btn-outline-primary btn-sm me-2">Total:</label>
                        </div>
                        
                        <div class="col-lg-2 col-sm-12">
                            <select name="filtro_anio" wire:model="filtro_anio" class="form-select form-select-sm me-2">
                                <option value="">-- Año --</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $anio)
                                    <option value="{{ $anio }}" {{ $anio == date('Y') ? 'selected' : '' }}>
                                        {{ $anio }}
                                    </option>
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
                                    <option value="{{ $num }}" {{ $num == date('n') ? 'selected' : '' }}>
                                        {{ $mes }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="input-group mb-3"> 
                                <input type="text" id="txtsearchpersonalatenciones" class="form-control form-control-sm" placeholder="Buscar por DNI o Datos del Personal">
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
                    <tbody class="align-middle">
                        {{-- @forelse ($lista_atenciones as $item) --}}
                            <tr>
                                <th class="text-center">
                                    <i class="fa-solid fa-ticket"></i>
                                </th>
                                <td></td>
                                <td></td>
                                <td>
                                    
                                </td>
                                <td class="text-primary">
                                    
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>                   
                                        <button type="button" class="btn btn-outline-danger btn-xs">
                                            <i class="fa-solid fa-trash-can"></i><br>Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>                           
                        {{-- @empty
                            <tr>
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13"><br></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
