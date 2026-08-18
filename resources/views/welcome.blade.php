@extends('layouts.bootstrap5pag.index')

@section('title', 'Intranet v12')



@section('content')

<main>
      <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#myCarousel"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#myCarousel"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#myCarousel"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('img/fondo2025.jpg') }}" class="d-block w-100" alt="Primera imagen del carrusel">
            <div class="container">
              <div class="carousel-caption text-start">
                <h1>Bienvenido a la Intranet</h1>
                <p class="opacity-75">
                  Distrito Fiscal de Junín
                </p>
                <p>
                  @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-dark btn-lg">
                                <i class="fa-solid fa-user"></i> Iniciar sesión
                            </a>

                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-address-card"></i> Register
                                </a>
                            @endif --}}
                        @endauth
                    </div>
                  @endif
                </p>
              </div>
            </div>
          </div>
          {{-- <div class="carousel-item">
            <svg
              aria-hidden="true"
              class="bd-placeholder-img"
              height="100%"
              preserveAspectRatio="xMidYMid slice"
              width="100%"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect
                width="100%"
                height="100%"
                fill="var(--bs-secondary-color)"
              ></rect>
            </svg>
            <div class="container">
              <div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>
                  Some representative placeholder content for the second slide
                  of the carousel.
                </p>
                <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
              </div>
            </div>
          </div> --}}
          {{-- <div class="carousel-item">
            <svg
              aria-hidden="true"
              class="bd-placeholder-img"
              height="100%"
              preserveAspectRatio="xMidYMid slice"
              width="100%"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect
                width="100%"
                height="100%"
                fill="var(--bs-secondary-color)"
              ></rect>
            </svg>
            <div class="container">
              <div class="carousel-caption text-end">
                <h1>One more for good measure.</h1>
                <p>
                  Some representative placeholder content for the third slide of
                  this carousel.
                </p>
                <p>
                  <a class="btn btn-lg btn-primary" href="#">Browse gallery</a>
                </p>
              </div>
            </div>
          </div> --}}
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#myCarousel"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#myCarousel"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <!-- Marketing messaging and featurettes
  ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
      <div class="container marketing">
        <!-- Three columns of text below the carousel -->
        <h2 class="text-center">SERVICIOS INTERNOS DEL DFJUNÍN</h2>
        <hr class="featurette-divider" />
        {{-- <fieldset class="border p-3 rounded mb-3">
          <legend class="float-none px-3 fs-6 fw-bold text-muted text-center rounded bg-primary-subtle">SERVICIOS INTERNOS DEL DFJUNÍN</legend> --}}
          <div class="row">
            <div class="col-lg-4">
              <svg aria-label="Placeholder" class="bd-placeholder-img rounded-circle" height="140" preserveAspectRatio="xMidYMid slice" role="img" width="140" xmlns="http://www.w3.org/2000/svg">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect>
              </svg>
              <h2 class="fw-normal">INFORMÁTICA</h2>
              <p>Registro de Incidencias / Solicitudes</p>
              <p>
                <a class="btn btn-primary" href="{{ route('paginas.informatica-atenciones.index') }}">
                    <i class="fa-solid fa-file"></i> Registrar &raquo;
                </a>
              </p>
            </div>

            
            {{-- <div class="col-lg-4">
              <svg
                aria-label="Placeholder"
                class="bd-placeholder-img rounded-circle"
                height="140"
                preserveAspectRatio="xMidYMid slice"
                role="img"
                width="140"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Placeholder</title>
                <rect
                  width="100%"
                  height="100%"
                  fill="var(--bs-secondary-color)"
                ></rect>
              </svg>
              <h2 class="fw-normal">Intranet DFJ v1.0</h2>
              <p>
                Modulos Administrativos
              </p>
              <p>
                <a class="btn btn-primary" href="http://10.13.100.19/dfjunin/">
                  <i class="fa-solid fa-user"></i> Acceder &raquo;
                </a>
              </p>
            </div>
            
            
            <div class="col-lg-4">
              <svg
                aria-label="Placeholder"
                class="bd-placeholder-img rounded-circle"
                height="140"
                preserveAspectRatio="xMidYMid slice"
                role="img"
                width="140"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Placeholder</title>
                <rect
                  width="100%"
                  height="100%"
                  fill="var(--bs-secondary-color)"
                ></rect>
              </svg>
              <h2 class="fw-normal">Intranet DFJ v2.0</h2>
              <p>
                Modulos Administrativos
              </p>
              <p>
                @if (Route::has('login'))
                  <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                      @auth
                          <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                      @else
                          <a href="{{ route('login') }}" class="btn btn-primary">
                              <i class="fa-solid fa-user"></i> Iniciar sesión
                          </a>
                      @endauth
                  </div>
                @endif
              </p>
            </div>
          </div> --}}
        {{-- </fieldset> --}}



        <!-- /.row -->
        <!-- START THE FEATURETTES -->
        {{-- <hr class="featurette-divider" /> --}}
        {{-- <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading fw-normal lh-1">
              First featurette heading.
              <span class="text-body-secondary">It’ll blow your mind.</span>
            </h2>
            <p class="lead">
              Some great placeholder content for the first featurette here.
              Imagine some exciting prose here.
            </p>
          </div>
          <div class="col-md-5">
            <svg
              aria-label="Placeholder: 500x500"
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              height="500"
              preserveAspectRatio="xMidYMid slice"
              role="img"
              width="500"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>Placeholder</title>
              <rect
                width="100%"
                height="100%"
                fill="var(--bs-secondary-bg)"
              ></rect>
              <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">
                500x500
              </text>
            </svg>
          </div>
        </div> --}}

        {{-- <hr class="featurette-divider" /> --}}

        {{-- <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading fw-normal lh-1">
              Oh yeah, it’s that good.
              <span class="text-body-secondary">See for yourself.</span>
            </h2>
            <p class="lead">
              Another featurette? Of course. More placeholder content here to
              give you an idea of how this layout would work with some actual
              real-world content in place.
            </p>
          </div>
          <div class="col-md-5 order-md-1">
            <svg
              aria-label="Placeholder: 500x500"
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              height="500"
              preserveAspectRatio="xMidYMid slice"
              role="img"
              width="500"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>Placeholder</title>
              <rect
                width="100%"
                height="100%"
                fill="var(--bs-secondary-bg)"
              ></rect>
              <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">
                500x500
              </text>
            </svg>
          </div>
        </div> --}}

        {{-- <hr class="featurette-divider" /> --}}

        {{-- <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading fw-normal lh-1">
                And lastly, this one.
                <span class="text-body-secondary">Checkmate.</span>
                </h2>
                <p class="lead">
                And yes, this is the last block of representative placeholder
                content. Again, not really intended to be actually read, simply
                here to give you a better view of what this would look like with
                some actual content. Your content.
                </p>
            </div>
          <div class="col-md-5">
            <svg
              aria-label="Placeholder: 500x500"
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              height="500"
              preserveAspectRatio="xMidYMid slice"
              role="img"
              width="500"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>Placeholder</title>
              <rect
                width="100%"
                height="100%"
                fill="var(--bs-secondary-bg)"
              ></rect>
              <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">
                500x500
              </text>
            </svg>
          </div>
        </div> --}}
        <hr class="featurette-divider" />
        <!-- /END THE FEATURETTES -->
      </div>
      <!-- /.container -->
      <!-- FOOTER -->
    </main>
    <!-- FOOTER -->
    <footer class="w-100 bg-dark text-white p-3">
      <div class="container-fluid">
          <div class="row">

              <!-- Logo / Copyright -->
              <div class="col-6 col-md-3 mb-3">
                  <a href="/"
                    class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
                      <i class="fa-brands fa-bootstrap fs-3 text-primary"></i>
                  </a>

                  <p class="mb-0">
                      © 2017–2025
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