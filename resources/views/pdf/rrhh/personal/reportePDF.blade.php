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
    <h4 style="text-align:center;">DFJUNIN - DISTRIBUCIÓN DE PERSONAL POR DEPENDENCIA<br>TOTAL: {{ $personalAgrupado->flatten()->count() }}</h4>
    
    @foreach ($personalAgrupado as $dependencia => $personas)

        {{-- <h4 style="text-align:center; margin-top:20px; font-weight:bold;">
            DEPENDENCIA: {{ $dependencia }}
        </h4> --}}
        <br>

        <table class="tabla">
            <thead>
                <tr>
                    <th colspan="5" style="font-size:12px; text-align:center; padding:10px; font-weight:bold; background:#f2f2f2;">
                        {{ $dependencia }}
                    </th>
                    <th style="font-size:12px; text-align:center; padding:10px; font-weight:bold; background:#f2f2f2;">
                        Total: {{ count($personas) }}
                    </th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>DNI</th>
                    <th>DATOS</th>
                    <th>DEPENDENCIA</th>
                    <th>REGIMEN</th>
                    <th>CARGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($personas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->dni }}</td>
                        <td>{{ $item->datos }}</td>
                        <td>
                            {{ $item->sedeorigen }}<br>
                            {{ $item->dependenciaorigen }}<br>
                            {{ $item->despachoorigen }}
                        </td>
                        <td>{{ $item->regimen }}</td>
                        <td>{{ $item->cargo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endforeach
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
                <td class="borde-superior">ADMINISTRACIÓN<br>Responsable<br>DNI: </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="borde-superior">POTENCIAL HUMANO<br>Responsable<br>DNI: </td>    
            </tr>
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>
@endsection