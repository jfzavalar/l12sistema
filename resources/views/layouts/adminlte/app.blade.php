<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
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
            --bs-btn-font-size: .75rem !important;
            }

            .btn-naranja {
            background-color: #ff8800;
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

            /* Tamaño extra pequeño para tablas */
            .table-xsmall {
                font-size: 0.75rem !important;   /* más chico que el normal */
            }
        </style>

        @livewireStyles

    </head>
    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

        <div class="app-wrapper">

            {{-- Navbar --}}
            <nav class="app-header navbar navbar-expand bg-body">
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
                                <i class="fa-solid fa-sliders"></i> {{ Auth::user()->name ?? 'Usuario' }}
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
                                    <button class="dropdown-item">
                                        <i class="fa-solid fa-gears"></i> Configuración
                                    </button>
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
                                    <p>Dashboard</p>
                                </a>
                            </li>

                            {{-- Administrador --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-folder"></i>
                                    <p>
                                        Administrador
                                        <i class="nav-arrow fa-solid fa-angle-left right"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.users.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.users.index') }}">
                                            <i class="nav-icon fa-regular fa-circle"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.roles.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.roles.index') }}">
                                            <i class="nav-icon fa-regular fa-circle"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link ms-3 {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                                            <i class="nav-icon fa-regular fa-circle"></i>
                                            <p>Permisos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

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

    </body>
</html>
