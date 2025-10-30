<div class="modal fade @if($modal_abierto_bienes) show d-block @endif" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fa-brands fa-searchengin"></i> BUSCAR BIENES
                    </h1>
                    <button type="button" class="btn-close" wire:click="cerrar_bienes"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mt-3 mb-3">
                                    <input type="text" id="txt_searchbien" class="form-control form-control-sm" placeholder="Buscar por código patrimonial" wire:model.live="searchbien">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover table-sm table-xsmall">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">CÓDIGO PATRIMINIAL</th>
                                    <th scope="col">CÓDIGO MARGESI</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col">MARCA</th>
                                    <th scope="col">MODELO</th>
                                    <th scope="col">SERIE</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">ESTADO</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista_bienes as $bieninformatico)
                                    <tr>
                                        <td></td>
                                        <td>{{ $bieninformatico->cod_pat }}</td>
                                        <td>{{ $bieninformatico->cod_barra}}</td>
                                        <td>{{ $bieninformatico->bien}}</td>
                                        <td>{{ $bieninformatico->marca}}</td>
                                        <td>{{ $bieninformatico->modelo}}</td>
                                        <td>{{ $bieninformatico->serie}}</td>
                                        <td>{{ $bieninformatico->color}}</td>
                                        <td></td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group" role="group">
                                                   <button type="button" class="btn btn-outline-success btn-sm"  wire:click="agregar_bienes({{ $bieninformatico->id}})" @disabled(($bieninformatico->desplazamiento == '1' && $traslado == '1') || ($bieninformatico->desplazamiento == '0' && $traslado == '0'))>
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
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="cerrar_bienes">
                        <i class="fa-solid fa-square-xmark"></i><br>Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>