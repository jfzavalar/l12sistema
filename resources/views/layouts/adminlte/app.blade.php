<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">



        @vite(['resources/css/app-adminlte.css', 'resources/js/app-adminlte.js'])

        <style>
            /* 🔵 Estilo general de los botones de paginación */
            .pagination .page-link {
                border-radius: 50px !important; /* Bordes tipo pill */
                padding: 0.25rem 0.6rem;        /* Botones más compactos */
                font-size: 1rem;              /* Texto más pequeño */
                line-height: 1;                 /* Ajusta la altura del texto */
                color: #5e72e4;                 /* Color principal Argon */
            }

            /* 🟣 Hover y enfoque */
            .pagination .page-link:hover,
            .pagination .page-link:focus {
                background-color: #5e72e4;
                color: #fff;
                box-shadow: 0 0 6px rgba(94, 114, 228, 0.3);
            }

            /* 🟢 Estado activo */
            .pagination .page-item.active .page-link {
                background-color: #5e72e4 !important;
                border-color: #5e72e4 !important;
                color: #fff !important;
                box-shadow: 0 0 6px rgba(94, 114, 228, 0.4);
            }

            /* 🔘 Redondeo de bordes en los extremos (opcional, por si prefieres estilo clásico) */
            .pagination .page-item:first-child .page-link {
                border-top-left-radius: 50px;
                border-bottom-left-radius: 50px;
            }
            .pagination .page-item:last-child .page-link {
                border-top-right-radius: 50px;
                border-bottom-right-radius: 50px;
            }

            
            /* ------------------------------------- */
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
            .b-example-divider {
                width: 100%;
                height: 3rem;
                background-color: #0000001a;
                border: solid rgba(0, 0, 0, 0.15);
                border-width: 1px 0;
                box-shadow:
                inset 0 0.5em 1.5em #0000001a,
                inset 0 0.125em 0.5em #00000026;
            }
            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }
            .bi {
                vertical-align: -0.125em;
                fill: currentColor;
            }
            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }
            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .btn-bd-primary {
                --bd-violet-bg: #712cf9;
                --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
                --bs-btn-font-weight: 600;
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bd-violet-bg);
                --bs-btn-border-color: var(--bd-violet-bg);
                --bs-btn-hover-color: var(--bs-white);
                --bs-btn-hover-bg: #6528e0;
                --bs-btn-hover-border-color: #6528e0;
                --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                --bs-btn-active-color: var(--bs-btn-hover-color);
                --bs-btn-active-bg: #5a23c8;
                --bs-btn-active-border-color: #5a23c8;
            }
            .bd-mode-toggle {
                z-index: 1500;
            }
            .bd-mode-toggle .bi {
                width: 1em;
                height: 1em;
            }
            .bd-mode-toggle .dropdown-menu .active .bi {
                display: block !important;
            }

            /* ------------------------------------- */
            .btn-xs {
            --bs-btn-padding-y: .25rem !important;
            --bs-btn-padding-x: .5rem !important;
            --bs-btn-font-size: .70rem !important;
            }

            .btn-naranja {
            background-color: #ff8800;
            color: white;
            }
            .btn-naranja:hover {
                background-color: #e67600; /* naranja más oscuro */
                color: white;
            }

            .btn-azul-oscuro {
                background-color: #003366;
                color: white;
            }

            .btn-verde-lima {
                background-color: #00cc66;
                color: white;
            }

            .btn-outline-naranja {
                color: #ff8800;
                border: 1px solid #ff8800;
                background-color: transparent;
            }
            .btn-outline-naranja:hover {
                background-color: #ff8800;
                color: white;
            }

            .btn-outline-azul-oscuro {
                color: #003366;
                border: 1px solid #003366;
                background-color: transparent;
            }

            .btn-outline-azul-oscuro:hover {
                background-color: #003366;
                color: white;
            }

            .btn-outline-verde-lima {
                color: #00cc66;
                border: 1px solid #00cc66;
                background-color: transparent;
            }

            .btn-outline-verde-lima:hover {
                background-color: #00cc66;
                color: white;
            }

            /* ------------------------------------- */

            .form-control-xs.form-control {
            padding: .25rem .5rem;   /* arriba/abajo - izquierda/derecha */
            font-size: .75rem;       /* tamaño de letra */
            }

            .form-select-xs.form-select {
            padding: .25rem .5rem;   /* arriba/abajo - izquierda/derecha */
            font-size: .75rem;       /* tamaño de letra */
            }

            /* ===== Extra Small (xs) ===== */
            .input-group-xs > .form-control,
            .input-group-xs > .form-select,
            .input-group-xs > .input-group-text,
            .input-group-xs > .btn {
                padding: 0.15rem 0.3rem !important;  /* más pequeño que .sm */
                font-size: 0.7rem !important;        /* letra más chica */
                border-radius: 0.2rem !important;    /* esquinas compactas */
            }

            /* ===== Extra Span (xs) ===== */
            .input-group-text-xs.input-group-text {
                padding: .25rem .5rem;  /* arriba/abajo - izquierda/derecha */
                font-size: .75rem;      /* tamaño de letra */
                font-weight: bold;      /* negrita */
            }

            /* Tamaño extra pequeño para tablas */
            .table-xsmall {
                font-size: 0.70rem !important;   /* más chico que el normal */
            }
        </style>

        @livewireStyles

    </head>
    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

        <div class="app-wrapper">

            {{-- Navbar --}}
            <nav class="app-header navbar navbar-expand bg-body sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-lte-toggle="sidebar" href="#">
                                ☰
                            </a>
                        </li>
                    </ul>


                    {{-- Botones superior derecho --}}
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-sliders"></i> {{ Auth::user()->datos ?? 'Usuario' }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mpfn.intranet.configuracion.index') }}">
                                        <i class="fa-solid fa-gears"></i> Configuración
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    

                </div>
            </nav>



            {{-- Sidebar --}}
            {{-- <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="blue"> --}}
            <aside class="app-sidebar sidebar-custom shadow">
                <div class="sidebar-brand">
                    <a href="/" class="brand-link text-decoration-none text-white">
                        <i class="fa-brands fa-ubuntu text-white"></i>
                        <span class="brand-text fw-bold text-white">
                            {{ config('app.name') }}
                        </span>
                    </a>
                </div>

                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <ul class="nav sidebar-menu flex-column"
                            data-lte-toggle="treeview"
                            role="menu"
                            data-accordion="false">

                            {{-- Dashboard --}}
                            <li class="nav-item">
                                {{-- <a href="/dashboard" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-house"></i>
                                    <p>Dashboard</p>
                                </a> --}}
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('dashboard') }}">
                                    <i class="nav-icon fa-solid fa-house"></i>
                                    <p>DASHBOARD</p>
                                </a>
                            </li>

                            {{-- Administrador --}}
                            @can('procesos.admin.users.index')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class=" nav-icon fa-solid fa-user-tie"></i>
                                        <p>
                                            ADMIN
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        @can('procesos.admin.users.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.users.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.users.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Usuarios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('procesos.admin.roles.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.roles.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.roles.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Roles</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('procesos.admin.permissions.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Permisos</p>
                                                </a>
                                            </li>
                                        @endcan

                                        <hr class="ms-5 border-light">

                                        {{-- <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Cargos</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Régimen</p>
                                            </a>
                                        </li> --}}

                                        {{-- <hr class="ms-5 border-light"> --}}

                                        <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('mpfn.admin.sedes.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.admin.sedes.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Sedes</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('mpfn.admin.dependencias.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.admin.dependencias.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Dependencias</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Despachos</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endcan

                            {{-- CONTABILIDAD --}}
                            @can('mpfn.contabilidad')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-calculator"></i>
                                        <p>
                                            CONTABILIDAD
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>

                                    @can('mpfn.contabilidad.gastosoperativos.index')
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.contabilidad.gastosoperativos.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.contabilidad.gastosoperativos.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Gastos operativos</p>
                                                </a>
                                            </li>
                                        </ul>
                                    @endcan
                                </li>
                            @endcan

                            {{-- INFORMATICA --}}
                            @can('mpfn.informatica')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-brands fa-ubuntu"></i>
                                        <p>
                                            INFORMÁTICA
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    
                                    <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.informatica.anexos.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.informatica.anexos.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Anexos telefónicos</p>
                                                </a>
                                            </li>
                                        @can('procesos.informatica.firmasdigitales.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.informatica.firmasdigitales.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.firmasdigitales.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Certificados Digitales</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('procesos.informatica.ips.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.informatica.ips.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.ips.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>IPs</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mpfn.informatica.soporte.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.informatica.soporte.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.informatica.soporte.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Soporte</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('procesos.informatica.spijweb.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.informatica.spijweb.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.spijweb.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Spijweb</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            {{-- PATRIMONIO --}}
                            @can('mpfn.patrimonio')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-layer-group"></i>
                                        <p>
                                            PATRIMONIO
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        @can('mpfn.patrimonio.asignaciones.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.patrimonio.asignaciones.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.patrimonio.asignaciones.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Asignación de bienes</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mpfn.patrimonio.bienes.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.patrimonio.bienes.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.patrimonio.bienes.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Bienes patrimoniales</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mpfn.patrimonio.traslado.index')
                                        <li class="nav-item">
                                            <a class="nav-link ms-3 {{ request()->routeIs('mpfn.patrimonio.traslado.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.patrimonio.traslado.index') }}">
                                                <i class="nav-icon fa-regular fa-circle"></i>
                                                <p>Traslado temporal</p>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            {{-- RRHH --}}
                            @can('mpfn.rrhh')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-users-between-lines"></i>
                                        <p>
                                            RRHH
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        @can('mpfn.rrhh.persona.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.users.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.users.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Contratos</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mpfn.rrhh.persona.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.roles.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.roles.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Persona</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mpfn.rrhh.personal.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.rrhh.personal.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.rrhh.personal.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Personal</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.rrhh.personalrotacion.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.rrhh.personalrotacion.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Rotaciones</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            <hr class="border-white border-2">

                            {{-- INTRANET --}}
                            @can('mpfn.intranet')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-folder"></i>
                                        <p>
                                            INTRANET
                                            <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        @can('mpfn.intranet.expimportantes.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.intranet.expimportantes.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.intranet.expimportantes.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Exp. Importantes</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        @can('mpfn.intranet.atenciones.index')
                                            <li class="nav-item">
                                                <a class="nav-link ms-3 {{ request()->routeIs('mpfn.intranet.atenciones.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('mpfn.intranet.atenciones.index') }}">
                                                    <i class="nav-icon fa-regular fa-circle"></i>
                                                    <p>Tickets</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                        </ul>
                    </nav>
                </div>
            </aside>


            {{-- Content --}}
            <main class="app-main">
                <div class="app-content p-3">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            <footer class="app-footer text-center">
                <strong>© {{ date('Y') }} {{ config('app.name') }}</strong>
            </footer>

        </div>

        @livewireScripts

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                window.addEventListener('cerrar-modal', function (event) {

                    const modalId = event.detail.id;
                    const modalElement = document.getElementById(modalId);

                    if (!modalElement) return;

                    // 🔥 Forzar cierre con clase (100% efectivo)
                    modalElement.classList.remove('show');
                    modalElement.style.display = 'none';
                    modalElement.setAttribute('aria-hidden', 'true');
                    modalElement.removeAttribute('aria-modal');

                    // 🔥 Eliminar backdrop
                    document.querySelectorAll('.modal-backdrop')
                        .forEach(el => el.remove());

                    // 🔥 Limpiar body
                    document.body.classList.remove('modal-open');
                    document.body.style = '';
                });

            });
        </script>

        <script>
            document.addEventListener('livewire:initialized', () => {

                Livewire.on('alerta-actualizado', (data) => {

                    Swal.fire({
                        title: data.titulo,
                        text: data.mensaje,
                        icon: data.tipo,
                        confirmButtonColor: '#3085d6',

                        timer: 1500,              // 1.5 segundos
                        showConfirmButton: false  // oculta botón OK
                    });

                });

            });
        </script>

        <script>
            document.addEventListener('livewire:initialized', () => {

                Livewire.on('alerta-cancelar', (data) => {

                    Swal.fire({
                        title: data.titulo,
                        text: data.mensaje,
                        icon: data.tipo,
                        confirmButtonColor: '#3085d6',

                        timer: 1500,              // 1.5 segundos
                        showConfirmButton: false  // oculta botón OK
                    });

                });

            });
        </script>

        <script>
            let timeout;
            let tiempo = 3600000;

            function logout() {
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => {
                    window.location.href = "/login";
                });
            }

            function resetTimer() {
                clearTimeout(timeout);
                timeout = setTimeout(logout, tiempo);
            }

            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;
        </script>

    </body>
</html>
