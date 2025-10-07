{{-- Tab 02 --}}
<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
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
                <div class="input-group mb-3">
                    <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchi" placeholder="Buscar">
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th  scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">PERSONAL</th>
                            <th scope="col">COD PATRIMONIAL</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">IP</th>
                            <th scope="col">MARCA</th>
                            <th scope="col">MODELO</th>
                            <th scope="col">SERIE</th>
                            <th scope="col">
                                <i class="fa-solid fa-gears"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_inactivos as $item)
                            <tr @if (is_null($item->ip)) class="text-danger" @endif>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $loop->iteration }}</th>
                                <th @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->cod_usuario}}</th>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->desc_usuario }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->cod_pat }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->bien }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->ip }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->marca}}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->modelo }}</td>
                                <td @if (is_null($item->ip)) class="text-danger" @endif>{{ $item->serie }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="btn-group" role="group">
                                            @can('procesos.informatica.ips.edit')
                                                <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar({{ $item->id }})">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            @endcan
                                            @can('procesos.informatica.ips.destroy')
                                                <button type="button" class="btn btn-outline-danger btn-xs" wire:click="activar({{ $item->id }})">
                                                    <i class="fa-solid fa-check-double"></i> Activar
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- Links de paginación --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <strong>Total de registros:</strong> {{ $lista_inactivos->total() }}
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    {{ $lista_inactivos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
