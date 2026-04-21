<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DFJunín: Correo Informática</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
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
                    <br>"Año de la Esperanza y el Fortalecimiento de la Democracia"
                    <br><strong>OFICINA DE INFORMÁTICA DFJUNÍN</strong>
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

        <div class="title">SOLICITUD / INCIDENCIA</div>
        
        <table class="table">
            <tr>
                <td><strong>SERVICIO</strong></td>
                <td>{{ $servicio }}</td>
            </tr>
            <tr>
                <td><strong>DETALLE</strong></td>
                <td>{{ $detalle_servicio }}</td>
            </tr>
        </table>

        <!-- TABLA -->
        <div class="title">INFORMACIÓN DEL USUARIO</div>

        <table class="table">
            <tr>
                <td><strong>DNI</strong></td>
                <td>{{ $dni }}</td>
            </tr>
            <tr>
                <td><strong>DATOS</strong></td>
                <td>{{ $datos }}</td>
            </tr>
            <tr>
                <td><strong>CARGO</strong></td>
                <td>{{ $cargo }}</td>
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