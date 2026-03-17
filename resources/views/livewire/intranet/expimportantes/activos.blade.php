<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-xl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="input-group mb-2">
                            <input type="text" id="txtsearchusuario" class="form-control form-control-sm" wire:model.live="search" placeholder="Buscar por DNI o Apellidos y Nombres">
                            @can('mpfn.rrhh.personal.create')
                                <button type="button" id="btnnuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal" wire:click="nuevo">
                                    <i class="fa-solid fa-file"></i> Nuevo
                                </button>
                            @endcan
                            @can('mpfn.rrhh.personal.destroy')
                                <button type="button" id="btnnuevo" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#inactivosModal">
                                    <i class="fa-solid fa-ban"></i> Inactivos
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
                            <th scope="col">DEPENDENCIA ORIGEN</th>
                            <th scope="col">REGIMEN - CARGO</th>
                            <th scope="col" class="table-danger">N° Expediente</th>
                            <th scope="col">CONDICIÓN</th>
                            <th scope="col" colspan="2"><i class="fa-solid fa-gears"></i></th>
                            {{-- <th scope="col"><i class="fa-solid fa-gears"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
