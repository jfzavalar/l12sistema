<div class="table-responsive">
    {{-- Mensaje de error equipo duplicado --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table table-striped table-hover table-sm small table-xsmall">
        <thead class="table-dark text-center align-middle">
            <tr>
                <th scope="col">#</th>
                <th scope="col">CÓDIGO DE BARRAS</th>
                <th scope="col">CÓDIGO MARGESI</th>
                <th scope="col">DESCRIPCIÓN</th>
                <th scope="col">MARCA</th>
                <th scope="col">MODELO</th>
                <th scope="col">SERIE</th>
                <th scope="col">COLOR</th>
                <th scope="col">ESTADO</th>
                <th scope="col" class="text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" wire:click="agregar_bienes">
                            <i class="fas fa-plus-square fa-fw"></i> Agregar
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" wire:click="cargarEXCEL1">
                            <i class="fa-solid fa-file-excel"></i> Importar
                        </button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tempbienesinformaticos as $itemtemp => $tempbieninfo)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $tempbieninfo['cod_pat'] }}</td>
                    <td>{{ $tempbieninfo['cod_barra']}}</td>
                    <td>{{ $tempbieninfo['bien']}}</td>
                    <td>{{ $tempbieninfo['marca']}}</td>
                    <td>{{ $tempbieninfo['modelo']}}</td>
                    <td>{{ $tempbieninfo['serie']}}</td>
                    <td>{{ $tempbieninfo['color']}}</td>
                    <td>{{ $tempbieninfo['est_cons']}}</td>
                    <td class="text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-danger btn-xs" wire:click="eliminar_buscar_bieninformatico({{ $itemtemp }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>