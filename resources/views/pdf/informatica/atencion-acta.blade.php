@extends('layouts.pdf.pdf')

@section('title', 'Formato PDF')

@section('content')
<div class="header">
    <table class="tabla-firma" width="100%">
        <thead>
            <tr>
                <th style="text-align: left;">
                    <br><img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="150">
                </th>
                <th style="text-align: right;">
                    <br>"OFICINA DE REDES Y COMUNICACIONES"
                    <br>OFICINA CENTRAL DE TECNOLOGÍAS DE LA INFORMACIÓN
                    <br>MINISTERIO PÚBLICO - FISCALÍA DE LA NACIÓN
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
                <th style="background-color: black; color: white; text-align: center;">FORMATO DE SOPORTE INFORMÁTICA 2026</th>
            </tr>
        </thead>
    </table>

    <p></p>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">DATOS DEL USUARIO</th>
            </tr>
        </thead>
    </table>
    
    <br>

    <table class="tabla">
        <thead>
            <tr>
                <td><b>USUARIO:</b></td>
                <td colspan="3">{{ $ipersonal->datos }}</td>
            </tr>
            <tr>
                <td><b>CARGO:</b></td>
                <td colspan="3">{{ $ipersonal->cargo }}</td>
            </tr>
            <tr>
                <td><b>SEDE:</b></td>
                <td colspan="3">{{ $ipersonal->sededestino }}</td>
            </tr>
            <tr>
                <td><b>DEPENDENCIA:</b></td>
                <td colspan="3">{{ $ipersonal->dependenciaorigen }}</td>
            </tr>
            <tr>
                <td><b>DESPACHO:</b></td>
                <td colspan="3">{{ $ipersonal->despachoorigen }}</td>
            </tr>
        </thead>
    </table>

    <br>

    @if ($ibien)
        <table width="100%">
            <thead>
                <tr>
                    <th style="background-color: #e9ecef; color: black; text-align: center;">DATOS DEL EQUIPO INFORMÁTICO</th>
                </tr>
            </thead>
        </table>

        <br>
        
        <table class="tabla">
            <thead>
                <tr>
                    <th colspan="4">
                        {{ $ipersonal->bien }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>COD: </b>{{ $ibien->codigo_barra }}</td>
                    <td><b>COD PATRIMONIO: </b>{{ $ibien->codigo_patrimonial }}</td>
                    <td><b>MARCA: </b>{{ $ibien->marca }}</td>
                    <td><b>MODELO: </b>{{ $ibien->modelo }}</td>
                </tr>
                <tr>
                    <td><b>SERIE: </b>{{ $ibien->nro_serie }}</td>
                    <td><b>MEDIDAS: </b>{{ $ibien->medidas }}</td>
                    <td><b>COLOR: </b>{{ $ibien->color }}</td>
                    <td><b>ESTADO: </b>{{ $ibien->estado }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <br>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">DATOS DEL SOPORTE PREVENTIVO / CORRECTIVO</th>
            </tr>
        </thead>
    </table>

    <br>

    <table class="tabla">
        <tbody>
            <tr>
                <td><b>SERVICIO: </b>{{ $ipersonal->servicio }}</td>
                <td><b>DETALLE: </b>{{ $ipersonal->detalle_servicio }}</td>
                <td><b>ESTADO: </b>{{ $ipersonal->estado }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <table class="tabla">
        <thead>
            <tr>
                <td><b>DETALLE DEL PROBLEMA:</b></td>
                <td colspan="3">{{ $ipersonal->detalle_problema }}</td>
            </tr>
            <tr>
                <td><b>SOLUCIÓN / RESPUESTA:</b></td>
                <td colspan="3"> {{ $ipersonal->respuesta }}</td>
            </tr>
        </thead>
    </table>

    <br>

    <table class="tabla">
        <thead>
            <tr>
                <th>USUARIO: OBSERVACIÓN</th>
                <th>INFORMÁTICO: RECOMENDACIÓN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $ipersonal->obs_usuario }}</td>
                <td>{{ $ipersonal->obs_informatico }}</td>
            </tr>
        </tbody>
    </table>
    
</div>

<div class="footer">
    <table class="tabla-firma">
        <tbody>
            <tr>
                <td class="borde-superior">INFORMÁTICO<br>{{ $ipersonal->informatico }}<br>{{ $ipersonal->informatico_dni }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="borde-superior">USUARIO<br>{{ $ipersonal->datos }}<br>{{ $ipersonal->dni }}</td>
            </tr>
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>
@endsection