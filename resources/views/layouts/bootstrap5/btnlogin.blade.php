<button type="button" class="btn btn-primary btn-sm dropdown-toggle me-3" data-bs-toggle="dropdown" aria-expanded="false">
    {{ auth()->user()->datos }}
</button>

<ul class="dropdown-menu dropdown-menu-end">
    {{-- <li><button class="dropdown-item" type="button">Action</button></li> --}}
    <li>
        <a href="#" class="dropdown-item" type="button">
            <i class="fa-solid fa-gear"></i> Configuración
        </a>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class=" dropdown-item" style="background: none; border: none;">
                <i class="fa-solid fa-door-open"></i> Cerrar Sesión
            </button>
        </form>  
    </li>
</ul>