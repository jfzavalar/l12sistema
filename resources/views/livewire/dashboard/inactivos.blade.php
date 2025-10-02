{{-- Tab 02 --}}
<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <div class="input-group mb-3">
                    <input type="text" id="txtsearchi" class="form-control form-control-sm" placeholder="Buscar">
                </div>
                <table class="table table-striped table-hover table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <i class="fa-solid fa-user"></i> DNI
                            </th>
                            <th scope="col">Header2</th>
                            <th scope="col">Header3</th>
                            <th scope="col">Header4</th>
                            <th scope="col">Header5</th>
                            <th scope="col">Header6</th>
                            <th scope="col">Header7</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-success btn-sm" wire:click="editar" data-bs-toggle="modal" data-bs-target="#NuevoEditarModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>                   
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

