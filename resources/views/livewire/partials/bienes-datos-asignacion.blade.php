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
                <th scope="col">
                    <button type="button" class="btn btn-success btn-sm" wire:click="buscar_bien">
                        <i class="fas fa-plus-square fa-fw"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tempbienesinformaticos as $itemtemp => $tempbieninfo)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $tempbieninfo['cod_patrimonial'] }}</td>
                    <td>{{ $tempbieninfo['cod_barra']}}</td>
                    <td>{{ $tempbieninfo['desc_bien']}}</td>
                    <td>{{ $tempbieninfo['desc_marca']}}</td>
                    <td>{{ $tempbieninfo['modelo']}}</td>
                    <td>{{ $tempbieninfo['nro_serie']}}</td>
                    <td>{{ $tempbieninfo['desc_color']}}</td>
                    <td>{{ $tempbieninfo['des_estado_conservacion']}}</td>
                    <td>
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