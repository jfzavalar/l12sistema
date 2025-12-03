<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark">
    <div class="offcanvas-md offcanvas-end bg-dark" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">
                SISTEMA
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>

        <!-- Asegura que el cuerpo del sidebar use toda la altura y permita scroll interno -->
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto h-100">
            <ul class="nav flex-column">
                @can('dashboard')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>
                @endcan
            </ul>

            {{-- --------------------------------------------------------------------------- --}}

            @can('procesos.admin')
                <hr class="border border-light my-3">

                <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                    PANEL ADMIN
                </h6>
            @endcan

            <ul class="nav flex-column">                      
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

                @can('procesos.admin.permissions.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.admin.permissions.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.admin.permissions.index') }}">
                            <i class="fa-solid fa-key"></i> Permisos
                        </a>
                    </li>
                @endcan
            </ul>


            {{-- --------------------------------------------------------------------------- --}}

            @can('procesos.administracion')
                <hr class="border border-light my-3">
            
                <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                    ADMINISTRACIÓN
                </h6>
            @endcan

            <ul class="nav flex-column"> 
                @can('procesos.administracion.archivo.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.administracion.archivo.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.administracion.archivo.index') }}">
                            <i class="fa-solid fa-boxes-stacked"></i> Archivo
                        </a>
                    </li>
                @endcan
                @can('procesos.administracion.patrimonio.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.administracion.patrimonio.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.administracion.patrimonio.index') }}">
                            <i class="fa-solid fa-boxes-stacked"></i> Patrimonio
                        </a>
                    </li>
                @endcan
                @can('procesos.administracion.rrhh.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.administracion.rrhh.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.administracion.rrhh.index') }}">
                            <i class="fa-solid fa-users-rectangle"></i> RRHH
                        </a>
                    </li>
                @endcan
            </ul>

            {{-- --------------------------------------------------------------------------- --}}

            @can('procesos.informatica')
                <hr class="border border-light my-3">

                <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                    INFORMÁTICA
                </h6>
            @endcan

            <ul class="nav flex-column mb-auto">
                @can('procesos.informatica.firmaspcs.index')
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
                @can('procesos.informatica.spijweb.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.informatica.spijweb.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.informatica.spijweb.index') }}">
                            <i class="fa-solid fa-users-viewfinder"></i> Spijweb
                        </a>
                    </li>
                @endcan
            </ul>


            {{-- --------------------------------------------------------------------------- --}}

            @can('procesos.voluntariado')
                <hr class="border border-light my-3">

                <h6 class="sidebar-heading px-3 mt-4 mb-1 text-uppercase text-white">
                    VOLUNTARIADO
                </h6>
            @endcan

            <ul class="nav flex-column mb-auto">
                @can('procesos.voluntariado.index')
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('procesos.voluntariado.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.voluntariado.index') }}">
                            <i class="fa-solid fa-clock"></i> Registro de asistencia
                        </a>
                    </li>
                @endcan
            </ul>

            {{-- --------------------------------------------------------------------------- --}}

            <hr class="border border-light my-3">

            <ul class="nav flex-column mb-auto">
                @can('procesos.intranet.index')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('procesos.intranet.index') ? 'active bg-primary text-white fw-bold rounded-pill' : 'text-white' }}" href="{{ route('procesos.intranet.index') }}">
                            <i class="fa-solid fa-gear"></i> Configuración
                        </a>
                    </li>
                @endcan

                {{-- <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 text-white" href="#">
                        <i class="fa-solid fa-gear"></i> Configuración
                    </a>
                </li> --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start" style="background: none; border: none;">
                            <i class="fa-solid fa-door-open"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <p></p>
    </div>
</div>