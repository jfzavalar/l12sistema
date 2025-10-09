<div class="modal fade @if($modal_abierto_personal) show d-block @endif" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR PERSONAL
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_personal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mt-3 mb-3">
                                    <input type="text" id="txt_searchbien" class="form-control form-control-sm" placeholder="Buscar por código patrimonial" wire:model.live="searchpersonal">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">DATOS</th>
                                    <th scope="col">SEDE</th>
                                    <th scope="col">LOCAL</th>
                                    <th scope="col">DEPENDENCIA</th>
                                    <th scope="col">DESPACHO</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_personal as $personal)
                                    <tr>
                                        {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                        <td>{{ $personal->id }}</td>
                                        <td>{{ $personal->dni }}</td>
                                        <td>{{ $personal->datos }}</td>
                                        <td>{{ $personal->sede }}</td>
                                        <td></td>
                                        <td>{{ $personal->dependencia }}</td>
                                        <td></td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-success btn-sm" wire:click="agregar_personal({{ $personal->id }})" data-bs-toggle="modal" data-bs-target="#new-edit-Modal">
                                                        <i class="fa-solid fa-share-from-square"></i>
                                                    </button>
                                                </div>
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
                            </tbody>
                        </table>                      
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_personal">
                        <i class="fa-solid fa-square-xmark"></i><br>Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>