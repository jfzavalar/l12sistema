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

        {{-- ✅ FOOTER GLOBAL --}}
        <div class="footer">
            <p></p>
            <p></p>
            <p></p>
            <table class="tabla-firma" width="100%">
                <tr>
                    <td class="borde-superior">Entregué conforme</td>
                    <td></td>
                    <td class="borde-superior">Recibí conforme</td>
                    <td></td>
                    <td class="borde-superior">Control Patrimonial</td>
                </tr>
            </table>

            <hr>
            Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
        </div>

    </body>
</html>