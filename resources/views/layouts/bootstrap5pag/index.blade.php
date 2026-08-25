<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Astro v5.9.2" />
    
    
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        
    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/5.3/examples/carousel/"
    />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <script src="{{ asset('superadmin/bootstrap/assets/js/color-modes.js') }}"></script> --}}
    <link href="{{ asset('superadmin/bootstrap/assets/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <meta name="theme-color" content="#712cf9" />
    <link href="{{ asset('superadmin/bootstrap/carousel/carousel.css') }}" rel="stylesheet" />


    @yield('css')


    <style>
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
        box-shadow: inset 0 0.5em 1.5em #0000001a,
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
    </style>

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
            --bs-btn-font-size: .65rem !important;
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
                font-size: .60rem;      /* tamaño de letra */
                
            }

            /* Tamaño extra pequeño para tablas */
            .table-xsmall {
                font-size: 0.70rem !important;   /* más chico que el normal */
            }
        </style>
        @livewireStyles
  </head>
  <body>
    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path
          d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"
        ></path>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path
          d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"
        ></path>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path
          d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"
        ></path>
        <path
          d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"
        ></path>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path
          d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"
        ></path>
      </symbol>
    </svg> --}}
    {{-- <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button
        class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
        id="bd-theme"
        type="button"
        aria-expanded="false"
        data-bs-toggle="dropdown"
        aria-label="Toggle theme (auto)"
      >
        <svg class="bi my-1 theme-icon-active" aria-hidden="true">
          <use href="#circle-half"></use>
        </svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul
        class="dropdown-menu dropdown-menu-end shadow"
        aria-labelledby="bd-theme-text"
      >
        <li>
          <button
            type="button"
            class="dropdown-item d-flex align-items-center"
            data-bs-theme-value="light"
            aria-pressed="false"
          >
            <svg class="bi me-2 opacity-50" aria-hidden="true">
              <use href="#sun-fill"></use>
            </svg>
            Light
            <svg class="bi ms-auto d-none" aria-hidden="true">
              <use href="#check2"></use>
            </svg>
          </button>
        </li>
        <li>
          <button
            type="button"
            class="dropdown-item d-flex align-items-center"
            data-bs-theme-value="dark"
            aria-pressed="false"
          >
            <svg class="bi me-2 opacity-50" aria-hidden="true">
              <use href="#moon-stars-fill"></use>
            </svg>
            Dark
            <svg class="bi ms-auto d-none" aria-hidden="true">
              <use href="#check2"></use>
            </svg>
          </button>
        </li>
        <li>
          <button
            type="button"
            class="dropdown-item d-flex align-items-center active"
            data-bs-theme-value="auto"
            aria-pressed="true"
          >
            <svg class="bi me-2 opacity-50" aria-hidden="true">
              <use href="#circle-half"></use>
            </svg>
            Auto
            <svg class="bi ms-auto d-none" aria-hidden="true">
              <use href="#check2"></use>
            </svg>
          </button>
        </li>
      </ul>
    </div> --}}
    <header data-bs-theme="dark">
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
          {{-- <a class="navbar-brand" href="#">DF Junín</a> --}}
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i> Home
                </a>
              </li>
              {{-- <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li> --}}
            </ul>
            {{-- <form class="d-flex" role="search">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-outline-success" type="submit">
                Search
              </button>
            </form> --}}
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
              {{-- <button class="btn btn-primary me-2">
                <i class="fa-brands fa-uber"></i> Intranet FN
              </button>
              <button class="btn btn-primary me-2">
                <i class="fa-brands fa-servicestack"></i> Intranet DFJunin v1.0
              </button> --}}
              @if (Route::has('login'))
                  <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                      @auth
                          <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                      @else
                          <a href="{{ route('login') }}" class="btn btn-primary">
                              <i class="fa-solid fa-user"></i> Iniciar Sesión
                          </a>

                          {{-- @if (Route::has('register'))
                              <a href="{{ route('register') }}" class="btn btn-primary">
                                  <i class="fa-solid fa-address-card"></i> Register
                              </a>
                          @endif --}}
                      @endauth
                  </div>
              @endif
            </div>
          </div>
        </div>
      </nav>
    </header>

    @livewireScripts

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('content')
    
    <script src="{{ asset('superadmin/bootstrap/assets/dist/js/bootstrap.bundle.min.js') }}" class="astro-vvvwv3sm"></script>
    
    {{-- MODALES DE ALERTA ACTUALIZAR--}}

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
  </body>
</html>
