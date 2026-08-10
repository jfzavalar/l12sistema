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
                Se le remite Acta para la entrega de credenciales del SPIJWEB.
            </p>

            <!-- TABLA  DATOS PERSONALES-->
            <div class="title">INFORMACIÓN DEL USUARIO</div>

            <table class="table">
                <tr>
                    <td><strong>DATOS</strong></td>
                    <td>{{ $registro->dni . ' - ' . $registro->datos . ' - ' . $registro->cargo }}</td>
                </tr>
                <tr>
                    <td><strong>SEDE</strong></td>
                    <td>{{ $registro->sededestino }}</td>
                </tr>
                <tr>
                    <td><strong>DEPENDENCIA</strong></td>
                    <td>{{ $registro->dependenciadestino }}</td>
                </tr>
                <tr>
                    <td><strong>DESPACHO</strong></td>
                    <td>{{ $registro->despachodestino }}</td>
                </tr>
            </table>

            <div class="title">FIRMARLO Y SELLARLO, O CON FIRMA DIGITAL</div>
            <div class="title">DEVOLVER POR CORREO ELECTRÓNICO</div>
            <div class="title">GRACIAS</div>

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