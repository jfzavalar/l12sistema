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
    <h3>DFJUNIN - DISTRIBUCIÓN DE PERSONAL</h3>
    
    <table class="tabla">
        <thead>
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
            @foreach ($ipersonal as $item)
                <tr>
                    <td></td>
                    <td>{{ $item->dni }}</td>
                    <td>{{ $item->datos }}</td>
                    <td>
                        {{ $item->sedeorigen }}
                        <br>
                        {{ $item->dependenciaorigen }}
                        <br>
                        {{ $item->despachoorigen }}
                    </td>
                    <td>{{ $item->regimen }}</td>
                    <td>{{ $item->cargo }}</td>
                </tr>               
            @endforeach
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
            {{-- <tr>
                @if ( $ipersonal->asignacion === "ASIGNACION")
                    <td class="borde-superior">Entregué Conforme<br>CARHUAMACA VILCHEZ DENIS<br>DNI : 10708588</td>
                @else
                    <td class="borde-superior">Entregué Conforme<br>{{ $ipersonal->datos }}<br>{{ $ipersonal->dni }}</td>
                @endif
                <td></td>
                <td></td>
                <td></td>
                @if ( $ipersonal->asignacion === "DEVOLUCION")
                    <td class="borde-superior">Recibí Conforme<br>CARHUAMACA VILCHEZ DENIS<br>DNI : 10708588</td>    
                @else
                    <td class="borde-superior">RecibíConforme<br>{{ $ipersonal->datos }}<br>{{ $ipersonal->dni }}</td>
                @endif
            </tr> --}}
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>
@endsection