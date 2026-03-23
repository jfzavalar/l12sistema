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
    <h4 style="text-align:center;">DFJUNIN - DISTRIBUCIÓN DE TOKENS AL PERSONAL FISCAL</h4>

        {{-- <h4 style="text-align:center; margin-top:20px; font-weight:bold;">
            DEPENDENCIA: {{ $dependencia }}
        </h4> --}}
        <br>

        <table class="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DNI - PERSONAL</th>
                    <th>DEPENDENCIA ORIGEN</th>
                    <th>REGIMEN - CARGO</th>
                    <th>ROTACIÓN</th>
                    <th>CONDICIÓN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datos as $item)
                    <tr>
                        <td class="text-center {{ $item->tipo_documento == 'RENUNCIA' ? 'text-danger' : '' }}">
                            {{ $loop->iteration }}
                        </td>

                        <td class="{{ $item->tipo_documento == 'RENUNCIA' ? 'text-danger' : '' }}">
                            DNI: {{ $item->dni }} <br>
                            {{ $item->datos }}
                        </td>

                        <td class="{{ $item->tipo_documento == 'RENUNCIA' ? 'text-danger' : '' }}">
                            <b>SEDE:</b> {{ $item->sedeorigen }} <br>
                            <b>DEPENDENCIA:</b> {{ $item->dependenciaorigen }} <br>
                            <b>DESPACHO:</b> {{ $item->despachoorigen }}
                        </td>

                        <td class="{{ $item->tipo_documento == 'RENUNCIA' ? 'text-danger' : '' }}">
                            <b>REGIMEN:</b> {{ $item->regimen }} <br>
                            <b>CARGO:</b> {{ $item->cargo }}
                        </td>

                        <td class="{{ $item->tipo_documento == 'RENUNCIA' ? 'text-danger' : '' }}">
                            <b>SEDE:</b> {{ $item->sededestino }} <br>
                            <b>DEPENDENCIA:</b> {{ $item->dependenciadestino }} <br>
                            <b>DESPACHO:</b> {{ $item->despachodestino }}
                        </td>

                        <td class="text-center">
                            @if(in_array($item->tipo_documento, ['ADENDA','CONTRATO','INCORPORACION']))
                                <span class="badge bg-primary">{{ $item->tipo_documento }}</span>
                            @elseif(in_array($item->tipo_documento, ['LICENCIA','RENUNCIA']))
                                <span class="badge bg-danger">{{ $item->tipo_documento }}</span>
                            @else
                                {{ $item->tipo_documento }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No se encontraron resultados
                        </td>
                    </tr>
                @endforelse
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
                {{-- <td class="borde-superior">ADMINISTRACIÓN<br>Responsable<br>DNI: </td> --}}
                <td></td>
                <td></td>
                <td></td>
                {{-- <td class="borde-superior">POTENCIAL HUMANO<br>Responsable<br>DNI: </td>     --}}
            </tr>
        </tbody>
    </table>

    <p></p>
    <hr>
    Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
</div>
@endsection