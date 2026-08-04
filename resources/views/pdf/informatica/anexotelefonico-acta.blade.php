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
                <th style="text-align: right; font-size: 10px;">
                    <br>"OFICINA DE REDES Y COMUNICACIONES"
                    <br>OFICINA CENTRAL DE TECNOLOGÍAS DE LA INFORMACIÓN
                    <br>MINISTERIO PÚBLICO - FISCALÍA DE LA NACIÓN
                    <br> {{ $instanciaTbl->created_at }}
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
                    CONSTANCIA DE ASIGNACIÓN, REASIGNACIÓN O DEVOLUCIÓN 
                    <br>DE EQUIPO TELEFÓNICO - ACTA: N° {{ $instanciaTbl->id }}
                </th>
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
                <td colspan="3">
                    {{ $instanciaTbl->dni . " - " . $instanciaTbl->datos }}
                </td>
            </tr>
            <tr>
                <td><b>CARGO:</b></td>
                <td colspan="3">
                    {{ $instanciaTbl->regimen . " - " . $instanciaTbl->cargo }}
                </td>
            </tr>
            <tr>
                <td><b>SEDE:</b></td>
                <td colspan="3">
                    {{ $instanciaTbl->sededestino }}
                </td>
            </tr>
            <tr>
                <td><b>DEPENDENCIA:</b></td>
                <td colspan="3">
                    {{ $instanciaTbl->dependenciadestino }}
                </td>
            </tr>
            <tr>
                <td><b>DESPACHO:</b></td>
                <td colspan="3">
                    {{ $instanciaTbl->despachodestino . " - PIS0: " }}
                </td>
            </tr>
        </thead>
    </table>

    <br>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">REQUERIMIENTO</th>
            </tr>
        </thead>
    </table>

    <br>

    <table class="tabla">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>ANEXO</th>
                <th># SERIE</th>
                <th>MARCA</th>
                <th>MODELO</th>             
                <th>ESTADO</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">{{ $instanciaTbl->anexo }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->serie }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->marca }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->modelo }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->anexo }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->asignacionlibrecustodia }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <table width="100%">
        <thead>
            <tr>
                <th style="background-color: #e9ecef; color: black; text-align: center;">ACCESORIOS</th>
            </tr>
        </thead>
    </table>

    <br>

    <table class="tabla">
        <thead>
            <tr>
                <th>TRANSFORMADOR DE VOLTAJE</th>
                <th>AURICULARES</th>
                <th>BASE DE AURICULAR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ $instanciaTbl->transformador }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->auriculares }}</td>
                <td style="text-align: center;">{{ $instanciaTbl->baseauriculares }}</td>
            </tr>
        </tbody>
    </table>
    
</div>

<div class="footer">
    <table class="tabla-firma">
        <tbody>
            <tr>
                <td class="borde-superior">
                    ENTREGUÉ CONFORME
                    <br>{{ $instanciaTbl->informatico }}
                    <br>{{ $instanciaTbl->informatico_dni }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="borde-superior">
                    RECIBÍ CONFORME
                    <br>{{ $instanciaTbl->datos }}
                    <br>{{ $instanciaTbl->dni }}
                </td>
            </tr>
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>
@endsection