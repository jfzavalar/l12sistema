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
                    <input type="text" id="txtsearchi" class="form-control form-control-sm" wire:model.live="searchusuarioi" placeholder="Buscar">
                </div>
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">DATOS</th>
                            <th scope="col">SEDE</th>
                            <th scope="col">DEPENDENCIA</th>
                            <th scope="col">DESPACHO</th>
                            <th scope="col">REGIMEN</th>
                            <th scope="col">CARGO</th>
                            <th scope="col">CORREO PERSONAL</th>
                            <th scope="col"><i class="fa-solid fa-gears"></i></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_inactivos as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->dni }}</td>
                                <td>{{ $item->datos }}</td>
                                <td>{{ $item->sede }}</td>
                                <td>{{ $item->dependencia }}</td>
                                <td></td>
                                <td>{{ $item->regimen }}</td>
                                <td>{{ $item->cargo }}</td>
                                <td>{{ $item->correo_personal }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-xs" wire:click="editar" data-bs-toggle="modal" data-bs-target="#NuevoEditarModal">
                                            <i class="fa-solid fa-pen-to-square"></i><br>Editar
                                        </button>                   
                                        <button type="button" class="btn btn-outline-danger btn-xs" wire:click="activar({{ $item->id }})">
                                            <i class="fa-solid fa-trash-can"></i><br>Reactivar
                                        </button>
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