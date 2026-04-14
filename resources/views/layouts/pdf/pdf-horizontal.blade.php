<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name'))</title>
        <style>
            {!! file_get_contents(public_path('css/body.css')) !!}
            {!! file_get_contents(public_path('css/pagina-horizontal.css')) !!}
            {!! file_get_contents(public_path('css/tabla.css')) !!}
        </style>
        <style>
            .justificar {
                text-align: justify;
            }
            .cursiva {
                font-style: italic;
            }
            .negrita {
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        {{-- Content --}}
        <main class="app-main">
            <div class="app-content p-3">
                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        {{-- <footer class="app-footer text-center">
            <strong>© {{ date('Y') }} {{ config('app.name') }}</strong>
        </footer> --}}

    </body>
</html>