<div>
    <h3 class="text-muted fw-bold mb-1 text-center">
        DIRECTORIO TELEFÓNICO MINISTERIO PÚBLICO - DISTRITO FISCAL DE JUNÍN
    </h3>
    <br>
    <h3 class="text-muted fw-bold mb-1 text-center">
        CENTRAL DF JUNIN: 064-602987
    </h3>
    <p></p>
    <div class="table-responsive-xl">
        <div class="row mb-3">                      
            <div class="col-xl-3">
                <label for="txtsearch" class="fw-bold fs-6">BUSCAR POR PERSONAL</label>
                <div class="input-group">
                    <span class="input-group-text fw-bold" id="basic-addon2">Total: {{ $lista_activos->total() }}</span>
                    <input type="text" name="txtsearch" id="txtsearch" class="form-control" placeholder="Buscar por Datos del Personal" wire:model.live="search">
                </div>
            </div>
            <div class="col-xl-2">
                <label for="txtsearch3" class="fw-bold fs-6">ANEXO</label>
                <input type="text" name="txtsearch3" id="txtsearch3" class="form-control" placeholder="Buscar por número" wire:model.live="searchanexo">
            </div>
            <div class="col-xl-2">
                <label for="cmbsearch1" class="fw-bold fs-6">SEDE</label>
                <select name="cmbsearch1" id="cmbsearch1" class="form-select" wire:model.live="searchsede">
                    <option value="">Seleccionar...</option>
                    @foreach ($lista_sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-5">
                <label for="cmbsearch2" class="fw-bold fs-6">DEPENDENCIA</label>
                <select name="cmbsearch2" id="cmbsearch2" class="form-select" wire:model.live="searchdependencia">
                    <option value="">Seleccionar...</option>
                    @foreach ($lista_dependencias as $dependencia)
                        <option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-xl-7">
                <label for="txtsearch2" class="fw-bold fs-6">DEPENDENCIA</label>
                <input type="text" name="txtsearch2" id="txtsearch2" class="form-control" placeholder="Buscar por Dependencia" wire:model.live="searchdependencia">
            </div> --}}
        </div>

        <table class="table table-hover table-xsmall">
            <thead class="table-primary text-center align-middle">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">DNI - PERSONAL</th>
                    <th scope="col">DEPENDENCIA</th>
                    <th scope="col">PISO - OFICINA</th>
                    {{-- <th scope="col">CARGO</th> --}}
                    <th scope="col">ANEXO</th>
                    <th scope="col" colspan="3" class="table-dark">
                        <i class="fa-solid fa-gears"></i>
                    </th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @forelse ($lista_activos as $item1)
                    <tr class="shadow-sm border-0 border-start border-4 border-secondary rounded-start">
                        <th>
                            <i class="fa-solid fa-phone-volume text-success"></i> {{ $loop->iteration }}
                        </th>
                        <th>
                            {{ $item1->datos }}
                            <br>
                            <small class="text-muted fs-6 fw-bold">{{ $item1->cargo }}</small>
                        </th>
                        <td>
                            <b>SEDE:</b> {{ $item1->sededestino }} <br>
                            <b>DEPENDENCIA:</b> {{ $item1->dependenciadestino }} <br>
                            <b>DESPACHO:</b> {{ $item1->despachodestino }}
                        </td>
                        <th>
                            PISO: {{ $item1->piso }}
                            <br>
                            OFICINA: {{ $item1->oficina }}
                            <br>
                            {{ $item1->observacion }}
                        </th>
                        {{-- <td>{{ $item1->cargo }}</td> --}}
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success border fs-6">
                                {{ $item1->anexo }}
                            </span>
                        </td>
                        <!-- Aquí puedes poner botones de acción en las 3 columnas -->
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="8">

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="alert alert-danger" role="alert">
                                No se encontraron resultados!
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        {{ $lista_activos->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
