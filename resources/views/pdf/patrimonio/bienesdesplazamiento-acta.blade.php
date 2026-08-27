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
    <p></p>
    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: black; color: white; text-align: center;">
                    ORDEN DE DESPLAZAMIENTO TEMPORAL DE BIENES PATRIMONIALES N° {{ $instanciaTbl->id }}
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
                <th style="text-align: left; vertical-align: top;">ORIGEN</th>
                <td style="text-align: left; vertical-align: top;">
                    <b>Usuario: </b>{{ $instanciaTbl->datos }}
                    <br>
                    <b>Sede: </b>{{ $instanciaTbl->sedeorigen }}
                    <br>
                    <b>Dependencia: </b>{{ $instanciaTbl->dependenciaorigen }}
                    <br>
                    <b>Despacho: </b>{{ $instanciaTbl->despachoorigen }}
                </td>
                <th style="text-align: left; vertical-align: top;">DESTINO</th>
                <td style="text-align: left; vertical-align: top;">
                    <b>Usuario: </b>{{ $instanciaTbl->datos2 }}
                    <br>
                    <b>Sede: </b>{{ $instanciaTbl->sedeorigen2 }}
                    <br>
                    <b>Dependencia: </b>{{ $instanciaTbl->dependenciaorigen2 }}
                    <br>
                    <b>Despacho: </b>{{ $instanciaTbl->despachoorigen2 }}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th style="text-align: left; vertical-align: top;"><b>REFERENCIA:</b> </th>
                <td style="text-align: left; vertical-align: top;">{{ $instanciaTbl->referencia }}</td>
                <th style="text-align: left; vertical-align: top;"><b>MOTIVO:</b> </th>
                <td style="text-align: left; vertical-align: top;">{{ $instanciaTbl->motivo }}</td>
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
            @foreach ($iBien ?? [] as $item)
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