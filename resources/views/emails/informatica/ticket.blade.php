<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DFJunín: Informática</title>

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #333;
            }

            .container {
                width: 100%;
                max-width: 700px;
                margin: auto;
            }

            .header-table {
                width: 100%;
            }

            .table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 10px;
            }

            .table td, .table th {
                border: 1px solid #000;
                padding: 6px;
            }

            .table th {
                background-color: #cfcfd1;
                font-size: 12px;
            }

            .table td {
                font-size: 12px;
            }

            .footer {
                margin-top: 20px;
                font-size: 11px;
                text-align: center;
                color: #555;
            }

            .title {
                font-weight: bold;
                text-align: center;
                font-size: 14px;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container">

            <!-- HEADER -->
            <table class="header-table">
                <tr>
                    <td style="text-align: left;">
                        <img src="https://www.ccpancash.org/images/news/u5OdLjPLDAQf5acRUXorl6nsF5Oo7H98sU4bpe8v.png" width="180">
                    </td>
                    <td style="text-align: right; font-size: 11px;">
                        {{-- <br>"OFICINA DE REDES Y COMUNICACIONES" --}}
                        <br><strong>OFICINA DE TECNOLOGÍAS DE LA INFORMACIÓN DFJUNÍN</strong>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- MENSAJE -->
            <p>Estimado(a):</p>

            <p>
                Se le remite la información correspondiente a su solicitud procesada por el área de informática.
                Revise los archivos adjuntos para más detalles.
            </p>

            <!-- TABLA  DATOS PERSONALES-->
            <div class="title">INFORMACIÓN DEL USUARIO</div>

            <table class="table">
                <tr>
                    <td><strong>DATOS</strong></td>
                    <td>{{ $dni . ' - ' . $datos . '-' . $cargo }}</td>
                </tr>
                <tr>
                    <td><strong>SEDE</strong></td>
                    <td>{{ $sede }}</td>
                </tr>
                <tr>
                    <td><strong>DEPENDENCIA</strong></td>
                    <td>{{ $dependencia }}</td>
                </tr>
                <tr>
                    <td><strong>DESPACHO</strong></td>
                    <td>{{ $despacho }}</td>
                </tr>
            </table>

            <div class="title">SOLICITUD / INCIDENCIA</div>
            
            <!-- TABLA  SOLICITUD 7 INCIDENCIA-->
            <table class="table">
                <tr>
                    <td><strong>SOPORTE</strong></td>
                    <td>{{ $servicio . ' - ' . $detalle_servicio }}</td>
                </tr>
                <tr>
                    <td><strong>RESPUESTA</strong></td>
                    <td> {{ $respuesta }}</td>
                </tr>
                @if ($servicio === "DIGITALIZACION - CARPETAS")
                    <tr>
                        <td><strong>COPIAS DIGITALIZADAS</strong></td>
                        <td></td>
                    </tr>
                @endif
                @if ($servicio === "EQUIPO DE COMPUTO")
                    <tr>
                        <td><strong>COD PATRIMONIAL</strong></td>
                        <td>{{ $cod_patrimonial }}</td>
                    </tr>
                    <tr>
                        <td><strong>BIEN INFORMATICO</strong></td>
                        <td> {{ $datos_bien }}</td>
                    </tr>
                @endif
            </table>

            {{-- @if ($enviado_lima === "SI")
                <div class="title">DETALLES DE LA ATENCIÓN</div>
            
                <!-- ENVIADO A LIMA-->
                <table class="table">
                    <tr>
                        <th>ENVIADO A LIMA: {{ $enviado_lima }}</th>
                        <th>GLPI - TICKET: {{ $glpi }}</th>
                    </tr>
                </table>
            @endif --}}

            <!-- MENSAJE FINAL -->
            <p style="margin-top:15px;">
                Este correo ha sido generado automáticamente. Por favor, no responder.
            </p>

            <!-- FOOTER -->
            <div class="footer">
                Ministerio Público - Fiscalía de la Nación <br>
                Distrito Fiscal Junín - Oficina de Tecnologías de la Información
            </div>

        </div>
    </body>
</html>