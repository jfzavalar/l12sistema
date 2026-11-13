@extends('layouts.pdf.pdf')

@section('title', 'Reporte PDF')

@section('content')
    <div class="header">
        <table class="tabla-firma" width="100%">
            <thead>
                <tr>
                    <th style="text-align: left;">
                        <br><img src="{{ public_path('img/mpfn_encabezado.png') }}" width="150">
                    </th>
                    <th style="text-align: right; font-size: 10px;">
                        <br>"OFICINA DE REDES Y COMUNICACIONES"
                        <br>OFICINA CENTRAL DE TECNOLOGÍAS DE LA INFORMACIÓN
                        <br>MINISTERIO PÚBLICO - FISCALÍA DE LA NACIÓN
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
                    <th style="background-color: black; color: white; text-align: center; padding: 8px;">
                        REPORTE DE ANEXOS TELEFÓNICOS
                    </th>
                </tr>
            </thead>
        </table>

        <p></p>

        @php
            // Agrupamos directamente por dependencia destino para garantizar que cada bloque pinte sus filas
            $instanciaAgrupada = $instanciaTbl->where('activo', '1')->groupBy('dependenciadestino');
        @endphp

        @foreach ($instanciaAgrupada as $dependencia => $grupoAnexos)
            <table class="tabla" style="width: 100%; margin-top: 15px; border-collapse: collapse;">
                <thead>
                    <!-- Cabecera de la Dependencia y su Total (colspan ajustado a 6 para 7 columnas totales) -->
                    <tr>
                        <td colspan="6"
                            style="font-size:11px; text-align:left; padding:6px 10px; font-weight:bold; background:#e9ecef; color:black;">
                            DEPENDENCIA: {{ $dependencia }}
                        </td>
                        <td
                            style="font-size:11px; text-align:center; padding:6px; font-weight:bold; background:#e9ecef; color:black;">
                            Total: {{ count($grupoAnexos) }}
                        </td>
                    </tr>
                    <!-- Cabeceras de las columnas -->
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2; text-align: center;">N°</th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2;">DEPENDENCIA</th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2;">USUARIO</th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2; text-align: center;">DNI</th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2; text-align: center;">CARGO
                        </th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2; text-align: center;">ESTADO
                        </th>
                        <th style="border: 1px solid #ddd; padding: 5px; background: #f2f2f2; text-align: center;">ANEXO
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Bucle de los registros reales de esta dependencia -->
                    @foreach ($grupoAnexos as $item)
                        <tr>
                            <!-- Se agrega la numeración automática con $loop->iteration -->
                            <td style="border: 1px solid #ddd; text-align: center; padding: 4px;">{{ $loop->iteration }}
                            </td>
                            <td style="border: 1px solid #ddd; padding: 4px;">{{ $item->dependenciadestino }}</td>
                            <td style="border: 1px solid #ddd; padding: 4px;">{{ $item->datos }}</td>
                            <td style="border: 1px solid #ddd; text-align: center; padding: 4px;">{{ $item->dni }}</td>
                            <td style="border: 1px solid #ddd; text-align: center; padding: 4px;">{{ $item->cargo }}</td>
                            <td style="border: 1px solid #ddd; text-align: center; padding: 4px;">
                                {{ $item->asignacionlibrecustodia }}</td>
                            <td style="border: 1px solid #ddd; text-align: center; padding: 4px;">{{ $item->anexo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>

    <div class="footer">
        {{-- @if ($instanciaTbl->asignacionlibrecustodia === 'DEVOLUCION')
            <table class="tabla-firma">
                <tbody>
                    <tr>
                        <td class="borde-superior">
                            ENTREGUÉ CONFORME
                            <br>{{ $instanciaTbl->datos }}
                            <br>{{ $instanciaTbl->dni }}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="borde-superior">
                            RECIBÍ CONFORME
                            <br>{{ $instanciaTbl->informatico }}
                            <br>{{ $instanciaTbl->informatico_dni }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <table class="tabla-firma">
                <tbody>
                    <tr>
                        <td class="borde-superior">
                            RESPONSABLE INFORMÁTICO
                            <br>{{ $instanciaTbl->informatico }}
                            <br>{{ $instanciaTbl->informatico_dni }}
                        </td>
                        <td></td>
                        @if ($penultimo)
                            <td class="borde-superior">
                                ENTREGUÉ CONFORME
                                <br>{{ $penultimo->datos }}
                                <br>{{ $penultimo->dni }}
                            </td>
                        @else
                            <td></td>
                        @endif
                        <td></td>
                        <td class="borde-superior">
                            RECIBÍ CONFORME
                            <br>{{ $instanciaTbl->datos }}
                            <br>{{ $instanciaTbl->dni }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif --}}

        <p></p>
        <hr>
        Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín
    </div>
@endsection
