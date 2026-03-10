@extends('layouts.pdf.pdf')

@section('title', 'Formato PDF')

@section('content')
<div class="header">
    <table class="tabla-firma" width="100%">
        <thead>
            <tr>
                <th style="text-align: left;">
                    <img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="200">
                </th>
                <th style="text-align: right;">
                    <br>"Año de la Esperanza y el Fortalecimiento de la Democracia"
                    <br>GERENCIA CENTRAL DE TECNOLOGÍA DE LA INFORMACIÓN
                    {{-- <br>OFICINA DE SOPORTE --}}
                </th>
            </tr>
        </thead>
    </table>
</div>

{{-- <hr> --}}

<div class="content">
    <h3>FORMATO DE MANTENIMIENTO 2026</h3>
    
    <table class="tabla">
        <thead>
            <tr>
                <th colspan="4">DATOS DEL USUARIO</th>
            </tr>
            <tr>
                <td>SEDE: </td>
                <td colspan="3">{{ $ipersonal->sedeorigen }}</td>
            </tr>
            <tr>
                <td>DEPENDENCIA: </td>
                <td colspan="3">{{ $ipersonal->dependenciaorigen }}</td>
            </tr>
            <tr>
                <td>USUARIO:</td>
                <td colspan="3">{{ $ipersonal->datos }}</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="4">EQUIPO INFORMATICO</th>
            </tr>
            <tr>
                <td>COD: {{ $ipersonal->bien_cod_patrimonial }}</td>
                <td>PATRIMONIO: {{ $ipersonal->bien }}</td>
                <td>MARCA: {{ $ipersonal->marca }}</td>
                <td>MODELO: {{ $ipersonal->modelo }}</td>
            </tr>
            <tr>
                <td>SERIE: {{ $ipersonal->serie }}</td>
                <td>MEDIDAS: {{ $ipersonal->medida }}</td>
                <td>COLOR: {{ $ipersonal->color }}</td>
                <td>ESTADO: {{ $ipersonal->estado }}</td>
            </tr>
            <tr>
                <th colspan="2">PREVENTIVO</th>
                <th colspan="2">CORRECTIVO</th>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p01 ? 'X' : ' ' }}) Abrir CASE para realizar limpieza</td>
                <td colspan="2">({{ $ipersonal->c01 ? 'X' : ' ' }}) Actualización de aplicaciones</td>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p02 ? 'X' : ' ' }}) Emplear una compresora de aire</td>
                <td colspan="2">({{ $ipersonal->c02 ? 'X' : ' ' }}) Actualización de sistema operativo</td>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p03 ? 'X' : ' ' }}) Limpieza de monitor</td>
                <td colspan="2">({{ $ipersonal->c03 ? 'X' : ' ' }}) Cambio de CPU</td>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p04 ? 'X' : ' ' }}) Limpieza de teclado</td>
                <td colspan="2">({{ $ipersonal->c04 ? 'X' : ' ' }}) Clonación</td>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p05 ? 'X' : ' ' }}) Verificar cables de conexión</td>
                <td colspan="2">({{ $ipersonal->c05 ? 'X' : ' ' }}) Formateo</td>
            </tr>
            <tr>
                <td colspan="2">({{ $ipersonal->p06 ? 'X' : ' ' }}) Realizar pruebas de operatividad</td>
                <td colspan="2">({{ $ipersonal->c06 ? 'X' : ' ' }}) Instalación de Antimalware</td>
            </tr>
            {{-- <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr> --}}
            <tr>
                <td colspan="2">({{ $ipersonal->p07 ? 'X' : ' ' }}) Otros: {{ $ipersonal->potros }}</td>
                <td colspan="2">({{ $ipersonal->c07 ? 'X' : ' ' }}) Otros: {{ $ipersonal->cotros }}</td>
            </tr>
            <tr>
                <th colspan="4">OBSERVACIÓN REPORTADO POR EL USUARIO</th>
            </tr>
            <tr>
                <td colspan="4">{{ $ipersonal->recomendacion_usuario }}</td>
            </tr>
            <tr>
                <th colspan="4">RECOMENDACIONES DEL PERSONAL INFORMÁTICO</th>
            </tr>
            <tr>
                <td colspan="4">{{ $ipersonal->observacion_usuario }}</td>
            </tr>
            <tr>
                <td>EQUIPO EN ESTADO OPERATIVO</td>
                <td>SI( )</td>
                <td>NO( )</td>
                <td>PENDIENTE ( )</td>
            </tr>
        </tbody>
    </table>
    {{-- <h5>
        Se precisa, que se debe dar estricto cumplimiento de la Resolución de la Gerencia General N° 1537-2014-MP-FN-GG, “Reglamento Interno para el Acceso y Uso de las Herramientas y Servicios Informáticos en el Ministerio Publico”, para el cuidado y uso de los bienes de la entidad.
    </h5> --}}

    {{-- <h6>
        Observación: 
        <br>En caso que cese sus funciones, sírvase a realizar la Transferencia del dispositivo a su sucesor o lo contrario, realizar la devolución en las Oficinas de Soporte Técnico, ubicado en el quinto piso de la Av. Isabel Flores de Oliva 3ra-cdra. Urbanización Sala, El Tambo Huancayo.
    </h6> --}}
</div>
<div class="footer">
    <table class="tabla-firma">
        <tbody>
            <tr>
                <td class="borde-superior">INFORMÁTICO<br>{{ auth()->user()->datos; }}<br>{{ auth()->user()->dni; }}</td>
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