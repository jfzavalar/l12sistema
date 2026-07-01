@extends('layouts.pdf.pdf-horizontal2')

@section('title', 'Reporte PDF')

@section('content')
<div class="header">
    <table class="tabla-firma" width="100%">
        <thead>
            <tr>
                <th style="text-align: left;">
                    {{-- <br><img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="150"> --}}
                </th>
                <th style="text-align: right;">
                    <br>"DFJUNIN"
                    <br>OFICINA CENTRAL DE TECNOLOGÍAS DE LA INFORMACIÓN
                </th>
            </tr>
        </thead>
    </table>
</div>



<div class="content">
    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: black; color: white; text-align: center;">REPORTE DE TICKETS</th>
            </tr>
        </thead>
    </table>

    {{-- <p></p>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">DATOS DEL USUARIO</th>
            </tr>
        </thead>
    </table>
    
    <br> --}}

    <table class="tabla">
        <thead>
            <tr>
                <th>PERSONAL:</th>
                <td colspan="3">{{ $iusuario->datos }}</td>
                <th>AÑO:</th>
                <td>{{ $anio }}</td>
                <th>MES:</th>
                <td>{{ $nombreMes }}</td>
            </tr>
        </thead>
    </table>

    <br>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">ATENCIONES: INCIDENCIAS Y SOLICITUDES - {{ $iatenciones_por_usuario->count() }}</th>
            </tr>
        </thead>
    </table>
    <br>

    <table class="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>SOLICITANTE</th>
                <th>PEDIDO</th>
                <th>MEDIO</th>
                <th>SOLUCIÓN</th>
                <th>FECHA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iatenciones_por_usuario as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->datos }}</td>
                    <td>
                        SERVICIO: {{ $item->servicio }}
                        <br>
                        DETALLE: {{ $item->detalle_servicio }}
                    </td>
                    <td>{{ $item->reportado_por }}</td>
                    <td>{{ $item->respuesta }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

<div class="footer">
    {{-- <table class="tabla-firma">
        <tbody>
            <tr>
                <td class="borde-superior">INFORMÁTICO<br></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="borde-superior">USUARIO<br></td>
            </tr>
        </tbody>
    </table>

    <p></p> --}}
    <hr>
    {{-- Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín --}}
</div>
@endsection