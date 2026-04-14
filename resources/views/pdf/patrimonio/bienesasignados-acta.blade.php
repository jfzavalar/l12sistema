@extends('layouts.pdf.pdf-horizontal')

@section('title', 'Formato PDF')

@section('content')
<div class="header">
    <table class="tabla-firma" width="100%">
        <thead>
            <tr>
                <th style="text-align: left; width: 1%; white-space: nowrap;">
                    <br><img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="150">
                </th>
                <th style="text-align: left;">
                    <br>Sistema Integrado de Gestión Administrativa:
                    <br>Módulo de Patrimonio
                    <br>Versión 25.01.01
                </th>
                <th style="text-align: right;">
                    <br>FECHA: {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('d/m/Y') }}
                    <br>HORA: {{ \Carbon\Carbon::now()->format('H:i:s') }}
                    <br>
                </th>
            </tr>
        </thead>
    </table>
</div>

{{-- <hr> --}}

<div class="content">
    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: black; color: white; text-align: center;">
                    ORDEN DE DESPLAZAMIENTO INTERNO DE BIENES PATRIMONIALES N° {{ $iasignacion->id }}
                    <br>MES: {{ strtoupper(\Carbon\Carbon::now()->locale('es')->translatedFormat('F')) }}
                </th>
            </tr>
        </thead>
    </table>

    {{-- <br> --}}

    <table width="100%" style="font-size: 10px;">
        <thead>
            <tr>
                <th width="50%" style="text-align: left;">UNIDAD EJECUTORA: 002 MINISTERIO PUBLICO - GERENCIA GENERAL</th>
            </tr>
            <tr>
                <th width="50%" style="text-align: left;">NRO. IDENTIFICACIÓN: 000200</th>
            </tr>
        </thead>
    </table>

    <br>

    <table width="100%" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="text-align: left; vertical-align: top;">Entrega</th>
                <td style="text-align: left; vertical-align: top;">
                    <b>Responsable: </b>{{ $ipersonal->datos }}
                    <br>
                    <b>Usuario: </b>{{ $iasignacion->datos }}
                    <br>
                    <b>Cento de Costo: </b>17.05 - ADMINISTRACIÓN DF JUNÍN
                    <br>
                    <b>Ubicación: </b>{{ $iasignacion->dependencia }}
                </td>
                <th style="text-align: left; vertical-align: top;">Destino</th>
                <td style="text-align: left; vertical-align: top;">
                    <b>Responsable: </b>{{ $ipersonal->datos }}
                    <br>
                    <b>Usuario: </b>{{ $iasignacion->datos2 }}
                    <br>
                    <b>Cento de Costo: </b>17.05 - ADMINISTRACIÓN DF JUNÍN
                    <br>
                    <b>Ubicación: </b>{{ $iasignacion->dependencia2 }}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th style="text-align: left; vertical-align: top;"><b>Referencia:</b> </th>
                <td style="text-align: left; vertical-align: top;">{{ $iasignacion->referencia }}</td>
                <th style="text-align: left; vertical-align: top;"><b>Motivo:</b> </th>
                <td style="text-align: left; vertical-align: top;">{{ $iasignacion->motivo }}</td>
            </tr>
        </tbody>
    </table>
    
    <br>

    <table width="100%" style="font-size: 9px;">
        <thead>
            <tr>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">N°</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Cód.Patrimonial</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Cód.Barras/Inv.Ant</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Descripción</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Marca</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Modelo</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Serie</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Medidas</th>
                <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ibien ?? [] as $item)
                <tr>
                    <td><b>{{ $loop->iteration }}</b></td>
                    <td>{{ $item->codigo_patrimonial }}</td>
                    <td>{{ $item->codigo_barra }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->marca }}</td>
                    <td>{{ $item->modelo }}</td>
                    <td>{{ $item->nro_serie }}</td>
                    <td>{{ $item->medidas }}</td>
                    <td>{{ $item->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

<div class="footer">
    <table class="tabla-firma">
        <tbody>
            <tr>
                <td class="borde-superior">Entregué conforme<br><br></td>
                <td></td>
                <td class="borde-superior">Recibí conforme<br><br></td>
                <td></td>
                <td class="borde-superior">Control Patrimonial<br><br></td>
            </tr>
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>

<script type="text/php">
    if (isset($pdf)) {

        $font = $fontMetrics->get_font("Arial", "normal");
        $size = 9;

        // 🔥 HEADER (derecha)
        $pdf->page_text(
            735, 15, // 👈 ajusta posición (x, y)
            "Página {PAGE_NUM} de {PAGE_COUNT}",
            $font,
            $size
        );

        // 🔥 FOOTER (opcional, si quieres duplicado abajo)
        $pdf->page_text(
            270, 820,
            "Página {PAGE_NUM} de {PAGE_COUNT}",
            $font,
            $size
        );
    }
</script>
@endsection