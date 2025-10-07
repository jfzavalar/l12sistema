<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark">
    <div class="offcanvas-md offcanvas-end bg-dark" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                SISTEMA
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                @can('dashboard')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>
                @endcan

                <hr class="border border-light my-3">
                
                @can('procesos.admin')
                    <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                        PANEL ADMIN
                    </h6>
                @endcan
                
                @can('procesos.admin.users.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.admin.users.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.users.index') }}">
                            <i class="fa-solid fa-users"></i> Usuarios
                        </a>
                    </li>
                @endcan
                @can('procesos.admin.roles.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.admin.roles.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.roles.index') }}">
                            <i class="fa-solid fa-users-gear"></i> Roles
                        </a>
                    </li>
                @endcan

                @can('procesos.admin.roles.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                            <i class="fa-solid fa-users-gear"></i> Permisos
                        </a>
                    </li>
                @endcan

                <hr class="border border-light my-3">

                <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                    ADMINISTRACIÓN
                </h6>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#graph-up"></use>
                        </svg>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#puzzle"></use>
                        </svg>
                        Integrations
                    </a>
                </li>
            </ul>

            <hr class="border border-light my-3">

            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                INFORMÁTICA
            </h6>

            <ul class="nav flex-column mb-auto">
                @can('procesos.informatica.ips.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.informatica.firmasdigitales.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.firmasdigitales.index') }}">
                            <i class="fa-solid fa-signature"></i> Firmas digitales
                        </a>
                    </li>    
                @endcan
                @can('procesos.informatica.ips.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.informatica.ips.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.ips.index') }}">
                            <i class="fa-solid fa-robot"></i> IPs
                        </a>
                    </li>    
                @endcan
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#file-earmark-text"></use>
                        </svg>
                        Last quarter
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#file-earmark-text"></use>
                        </svg>
                        Social engagement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#file-earmark-text"></use>
                        </svg>
                        Year-end sale
                    </a>
                </li>
            </ul>

            <hr class="border border-light my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <i class="fa-solid fa-gear"></i> Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-white" style="background: none; border: none;">
                            <i class="fa-solid fa-door-open"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>