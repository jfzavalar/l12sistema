<div class="card">
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-xl-6">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" colspan="3" class="text-center">Registro de bienes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($totales_por_sede as $tactivos)
                            <tr class="align-middle" style="font-size: 12px;">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th style="white-space: nowrap;">{{ $tactivos->nomsedeofi }}</th>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div class="input-group input-group-xs">
                                            <button class="input-group-text bg-success text-white">
                                                <i class="fa-solid fa-check me-2"></i>Con IP
                                            </button>
                                            <input type="text" class="form-control text-end" value="{{ $tactivos->con_ip }}" readonly>
                                        </div>
                                        <div class="input-group input-group-xs">
                                            <button class="input-group-text bg-danger text-white">
                                                <i class="fa-solid fa-triangle-exclamation me-2"></i>Sin IP
                                            </button>
                                            <input type="text" class="form-control text-end" value="{{ $tactivos->sin_ip }}" readonly>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-xs">
                                        <input type="text"class="form-control fw-bold text-end" value="{{ $tactivos->total }}" readonly>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="align-middle"><td colspan="3">Sin registros.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-sm-4">
                        <div class="alert alert-primary" role="alert">
                            <h5 class="card-title">
                                Total Bienes
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><i class="fa-solid fa-chart-simple text-primary"></i> </h3>
                                <button class="btn btn-outline-primary btn-sm" wire:click="$set('filtro_rutas','')">
                                    <i class="fa-solid fa-bars"></i> Listar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-4">
                        <div class="alert alert-success" role="alert">
                            <h5 class="card-title">
                                Actas Firmadas
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><i class="fa-solid fa-file-signature text-success"></i> </h3>
                                <button class="btn btn-outline-success btn-sm" wire:click="$set('filtro_rutas','con')">
                                    <i class="fa-solid fa-bars"></i> Listar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-4">
                        <div class="alert alert-danger" role="alert">
                            <h5 class="card-title">
                                Actas sin Firmar
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3><i class="fa-solid fa-signature text-danger"></i> </h3>
                                <button class="btn btn-outline-danger btn-sm" wire:click="$set('filtro_rutas','sin')">
                                    <i class="fa-solid fa-bars"></i> Listar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>