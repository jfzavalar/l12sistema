<div>
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" id="txtsearcha" class="form-control form-control-sm" wire:model.live="searchpersonalr" placeholder="Buscar por DNI o Datos del Personal">
                        </div>
                    </div>
                </div>
                
                <table class="table table-striped table-hover table-sm table-xsmall">
                    <thead class="table-primary text-center align-middle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI - DATOS
                            </th>
                            <th scope="col">SEDE</th>
                            <th scope="col">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($lista_reportes as $item)
                            <tr>
                                <th class="text-center">{{ $loop->iteration }}</th>
                                <td><b>{{ $item->dni }}</b><br>{{ $item->datos }}</td>
                                <td class="text-primary">
                                    <b>SEDE: </b>{{ $item->sede_destino }}
                                    <br><b>DEPENDENCIA: </b>{{ $item->dependencia_destino }}
                                </td>
                                <th>{{ $item->total_tiempo}}</th>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron resultados!
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4">
                                <p></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="dropdown position-fixed bottom-0 start-50 translate-middle-x mb-3 bg-primary-subtle shadow-sm rounded px-3 py-2">
        {{ $lista_reportes->links() }}
    </div>
</div>
