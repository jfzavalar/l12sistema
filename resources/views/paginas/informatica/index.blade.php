@extends('layouts.bootstrap5pag.index')

@section('title', 'Registrar Atención')



@section('content')

<main>
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    </div>
        <div class="container marketing">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-2 border-bottom">
                {{-- <h1 class="h2">
                    <i class="fa-solid fa-users-between-lines"></i> INFORMATICA: REGISTRAR INCIDENCIAS / SOLICITUDES
                </h1> --}}
                {{-- <div class="row">
                    <div class="col-auto">
                        <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarTotal">
                            <span class="alert alert-primary d-block mb-0">
                                <span class="fw-bold">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    TOTAL:
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarEnviadolima">
                            <span class="alert alert-info d-block mb-0">
                                <span class="fw-bold">
                                    <i class="fa-solid fa-check-double"></i>
                                    LIMA:
                                </span>
                            </span>
                        </button>
                    </div>

                    <div class="col-auto">
                        <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarAtendido">
                            <span class="alert alert-success d-block mb-0">
                                <span class="fw-bold">
                                    <i class="fa-solid fa-check-double"></i>
                                    ATENDIDOS:
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn text-start p-0 border-0 bg-transparent" wire:click="filtrarNoatendido">
                            <span class="alert alert-danger d-block mb-0">
                                <span class="fw-bold">
                                    <i class="fa-solid fa-check-double"></i>
                                    PENDIENTES:
                                </span>
                            </span>
                        </button>
                    </div>
                </div> --}}
            </div>

            <div class="card">
                {{-- <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="txtdni">DNI</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" id="txtdni" class="form-control form-control-sm">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-body">
                    <livewire:paginas.informatica-atenciones />
                </div>
            </div>
        </div>
        
    </main>

@endsection



@push('scripts')

@endpush