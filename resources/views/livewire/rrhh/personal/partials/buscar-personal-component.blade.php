<!-- Modal buscar personal -->
<div wire:ignore.self class="modal fade" id="buscar-personal-component" tabindex="-1" aria-labelledby="buscar-personal-componentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-5">
            <form action="">
                <div class="modal-header bg-{{ $colorHeaderModal }}">
                    <h1 class="modal-title fs-5" id="buscar-personal-componentLabel">
                        <i class="fa-solid fa-magnifying-glass"></i> BUSCAR PERSONAL
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-xl">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-2">
                                        <input type="text" id="searchsede" class="form-control form-control-sm" placeholder="Buscar personal" wire:model.live="searchpersonas">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Datos</th>
                                    <th scope="col"><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_personas as $persona)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $persona->dni }}</th>
                                        <td>{{ $persona->datos }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-{{ $colorAgregar}} btn-xs" wire:click="agregar_persona({{ $persona->id }})" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                                                        <i class="fa-solid fa-circle-plus"></i> Agregar
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
                                    <td colspan="4">
                                        {{ $lista_personas->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>                       
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nuevoEditarModal">
                        <i class="fa-solid fa-door-closed"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>