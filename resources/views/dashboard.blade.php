{{-- @extends('layouts.bootstrap5.index') --}}
@extends('layouts.adminlte.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fa-solid fa-house"></i> DASHBOARD</h1>
        <div class="btn-group">
            {{-- @include('layouts.bootstrap5.btnlogin') --}}
        </div>
    </div>

    <div class="row g-3">

        <!-- CARD 1 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-4 border-primary h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <h5 class="fw-bold mb-1">
                            INFORMATICA
                        </h5>

                        <small class="text-muted">
                            REQUERIMIENTOS
                        </small>

                        <div class="mt-2">
                            <span class="badge bg-light text-primary border">
                                CANTIDAD
                            </span>
                        </div>

                        <div class="mt-2 fw-bold text-primary">
                            59
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="position-relative">

                            <div class="bg-light rounded-3 p-2 fs-3">
                                📦
                            </div>

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                5
                            </span>

                        </div>
                    </div>

                </div>

                <div class="mt-3 text-end">
                    <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('mpfn.informatica.requerimientos.index') }}">
                        Registrar
                    </a>
                </div>

            </div>
        </div>

        <!-- CARD 2 -->
        {{-- <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-4 border-primary h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <h6 class="fw-bold mb-1">
                            Pedido #9038660227
                        </h6>

                        <small class="text-muted">
                            Entrega el 27 de marzo.
                        </small>

                        <div class="mt-2">
                            <span class="badge bg-light text-primary border">
                                Inkafarma
                            </span>
                        </div>

                        <div class="mt-2 fw-bold text-primary">
                            S/59
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="position-relative">

                            <div class="bg-light rounded-3 p-2 fs-3">
                                📦
                            </div>

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                5
                            </span>

                        </div>
                    </div>

                </div>

                <div class="mt-3 text-end">
                    <button class="btn btn-outline-primary btn-sm rounded-pill">
                        Listo para recoger
                    </button>
                </div>

            </div>
        </div> --}}

    </div>
        
@endsection