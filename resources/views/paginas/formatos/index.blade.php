@extends('layouts.bootstrap5pag.index')

@section('title', 'Formatos y Anexos')



@section('content')

<main>
    {{-- <div class="row p-4">
        <div class="col-xl-6 col-lg-12">
            <fieldset class="border p-3 rounded mb-3">
                <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-primary-subtle">DIRECTIVAS</legend>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col" style="width: 5%;">N°</th>
                            <th scope="col">DOCUMENTO</th>
                            <th scope="col" style="width: 10%;">
                                <i class="fa-solid fa-gear" aria-hidden="true"></i>
                                <span class="visually-hidden">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center fw-bold">1</td>
                            <td>
                                REGLAMENTO INTERNO PARA EL ACCESO Y USO DE LAS HERRAMIENTAS Y SERVICIOS INFORMÁTICOS EN EL MINISTERIO PÚBLICO
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('storage/formatos/informatica/directivas/INFORMATICA_N_001_2018_MP_FN.pdf') }}" class="btn btn-outline-warning btn-sm" target="_blank" rel="noopener noreferrer" title="Ver documento PDF" aria-label="Ver documento PDF">
                                    <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>

        <div class="col-xl-6 col-lg-12">
            <fieldset class="border p-3 rounded mb-3">
                <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-primary-subtle">FORMATOS Y ANEXOS</legend>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col" style="width: 5%;">N°</th>
                            <th scope="col">DOCUMENTO</th>
                            <th scope="col" style="width: 10%;">
                                <i class="fa-solid fa-gear" aria-hidden="true"></i>
                                <span class="visually-hidden">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center fw-bold">1</td>
                            <td>
                                CARTA DE RIESTO - APROBADO
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('storage/formatos/informatica/formatos/2026_Carta_de_Riesgo.docx') }}" class="btn btn-outline-primary btn-sm" download title="Descargar documento Word" aria-label="Descargar documento Word">
                                    <i class="fa-solid fa-file-word" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div> --}}



    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 p-5">
    <!-- Documento 1 -->
        <div class="col-xl-6">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-danger">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 text-danger rounded p-3 me-3">
                            <i class="fa-regular fa-file-lines fa-2x"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark border mb-1">Directiva</span>
                            <small class="text-muted d-block">PDF • 1.0 MB</small>
                        </div>
                    </div>
                    <h6 class="card-title text-dark fw-bold flex-grow-1">
                        N° 001-2018-MP-FN
                    </h6>
                    <p class="card-text text-muted small">
                        Reglamento interno para el acceso y uso de herramientas informáticas.
                    </p>
                    <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>2018</span>
                        <a href="{{ asset('storage/formatos/informatica/directivas/INFORMATICA_N_001_2018_MP_FN.pdf') }}" 
                        class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                        target="_blank" 
                        rel="noopener noreferrer">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Ver PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-danger">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 text-danger rounded p-3 me-3">
                            <i class="fa-regular fa-file-lines fa-2x"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark border mb-1">Formato</span>
                            <small class="text-muted d-block">WORD • 1.0 MB</small>
                        </div>
                    </div>
                    <h6 class="card-title text-dark fw-bold flex-grow-1">
                        2026 Carta de Riesgo
                    </h6>
                    <p class="card-text text-muted small">
                        Carta de riesgo para la solicitud de acceso a los diferentes sistema del MP.
                    </p>
                    <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>2026</span>
                        <a href="{{ asset('storage/formatos/informatica/formatos/2026_Carta_de_Riesgo.docx') }}" 
                        class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                        target="_blank" 
                        rel="noopener noreferrer">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Descargar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- FOOTER -->
<footer class="w-100 bg-dark text-white p-3">
    <div class="container-fluid">
        <div class="row">

            <!-- Logo / Copyright -->
            <div class="col-6 col-md-3 mb-3">
                {{-- <a href="/"
                class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
                    <i class="fa-brands fa-bootstrap fs-3 text-primary"></i>
                </a> --}}

                <p class="mb-0">
                    2026
                </p>
            </div>

            <!-- Features -->
            <div class="col-6 col-md-3 mb-3">
            <h5>MPFN</h5>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="https://aulavirtualmp.mpfn.gob.pe" class="nav-link p-0" target="_blank">
                    AULA VIRTUAL
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a href="https://cea.mpfn.gob.pe" class="nav-link p-0" target="_blank">
                    CEA
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="https://portalogti.mpfn.gob.pe" class="nav-link p-0" target="_blank">
                    GLPI
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="http://intranet.mpfn.gob.pe" class="nav-link p-0" target="_blank">
                    INTRANET
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="https://cfe-int.mpfn.gob.pe/generador-notificaciones/" class="nav-link p-0" target="_blank">
                    NOTIFICACIONES
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="https://sistemas2.mpfn.gob.pe" class="nav-link p-0" target="_blank">
                    SISTEMAS2
                    </a>
                </li>

            </ul>
            </div>

            <!-- Resources -->
            <div class="col-6 col-md-3 mb-3">
            <h5>EXTERNOS</h5>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0" target="_blank">
                    MIGRACIONES
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="https://msiap.pj.gob.pe/msiap/faces/login.jsp" class="nav-link p-0" target="_blank">
                    MSIAP
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="https://casillas.pj.gob.pe/sinoe/login.xhtml" class="nav-link p-0" target="_blank">
                    SINOE
                </a>
                </li>

                {{-- <li class="nav-item mb-2">
                <a href="#" class="nav-link p-0">
                    Final resource
                </a>
                </li> --}}

            </ul>
            </div>

            <!-- About -->
            <div class="col-6 col-md-3 mb-3">
                <h5>SERVICIOS</h5>

                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0" target="_blank">
                        INFORMÁTICA
                    </a>
                    </li>

                    {{-- <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0">
                        MSIAP
                    </a>
                    </li>

                    <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0">
                        SINOE
                    </a>
                    </li>

                    <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0">
                        Terms
                    </a>
                    </li> --}}

                </ul>
            </div>

        </div>
    </div>
</footer>

@endsection



@push('scripts')

@endpush