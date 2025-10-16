<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orden_Desplazamiento_Interno_Bienes_Patrimoniales</title>
        <style>
            @import url('./css/body.css');
            @import url('./css/pagina-horizontal.css');
            @import url('./css/tabla.css');
            /* @import url('./css/text.css'); */
        </style>
        <style>
            .justificar {
                text-align: justify;
            }
            .cursiva {
                font-style: italic;
            }
            .negrita {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <table class="tabla-firma" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: left;">
                            <img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="100">
                        </th>
                        <th style="text-align: right;">
                            <br><span style="font-size: 8px;">"Año de la recuperación y consolidación de la economía peruana"</span>
                            <br><span style="font-size: 8px;">Fecha: {{ date('d/m/Y') }}</span>
                            <br><span style="font-size: 8px;">Hora: {{ date('H:i:s') }}</span>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        
        <div class="content">
            <div style="font-size: 12px; text-align: center; font-weight: bold;">
                ORDEN DE DESPLAZAMIENTO INSTERNO DE BIENES PATRIMONIALES N°
                <br>MES
            </div>

            <br>
            
            <table class="tabla-datos-2" width="100%">
                <tbody>
                    <tr>
                        <th>UNIDAD EJECUTORA:</th>
                        <td>002 MINISTERIO PUBLICO - GERENCIA GENERAL</td>
                    </tr>
                    <tr>
                        <th>NRO. IDENTIFICACIÓN:</th>
                        <td>000200</td>
                    </tr>
                    <tr>
                        <th>ENTREGA:</th>
                        <td></td>
                        <th>RESPONSABLE:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table class="tabla-datos-2">
                                <tbody>
                                    <tr>
                                        <th>Responsable: </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th></th><td></td>
                                    </tr>
                                    <tr>
                                        <th>Usuario: </th>
                                        <td> {{ ' ' . $instanciaTbl->datos }}</td>
                                    </tr>
                                    <tr>
                                        <th></th><td></td>
                                    </tr>
                                    <tr>
                                        <th>Centro de Costo: </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th></th><td></td>
                                    </tr>
                                    <tr>
                                        <th>Ubicación: </th>
                                        <td>{{ ' ' . $instanciaTbl->sede_destino . ' - ' . $instanciaTbl->dependencia_destino }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                        <td>
                            <table class="tabla-datos-2">
                                <tbody>
                                    <tr>
                                        <th>Responsable: </th>
                                        <td> {{ ' ' . $instanciaTbl->solicitante }}</td>
                                    </tr>
                                    <tr><th></th><td></td></tr>
                                    <tr>
                                        <th>Usuario: </th>
                                        <td> {{ ' ' . $instanciaTbl->responsabletraslado }}</td>
                                    </tr>
                                    <tr><th></th><td></td></tr>
                                    <tr>
                                        <th>Centro de Costo: </th>
                                        <td></td>
                                    </tr>
                                    <tr><th></th><td></td></tr>
                                    <tr>
                                        <th>Ubicación: </th>
                                        <td> {{ ' ' . $instanciaTbl->sede_destino . ' - ' . $instanciaTbl->dependencia_destino }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>REFERENCIA:</th>
                        <td></td>
                        <th>MOTIVO:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>FECHA DE ASIGNACIÓN:</th>
                        <td>{{ date('d/m/Y') }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
            <br>

            <table style="font-size: 9px; border-collapse: collapse; width: 100%;">
                <thead style="border: 1px solid black;">
                    <tr>
                        <th style="white-space: nowrap; width: 1%;">N°</th>
                        <th>Cod. Patrimonial</th>
                        <th style="white-space: nowrap;">Cod. Barras/Inv. Ant</th>
                        <th>DESCRIPCION</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>SERIE</th>
                        <th>Medidas</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instanciaTbl_detalle as $item)
                        <tr>
                            <td style="white-space: nowrap;">{{ $loop->iteration }}<</td>
                            <td style="white-space: nowrap;">{{ $item->cod_pat }}</td>
                            <td style="white-space: nowrap;">{{ $item->cod_barra }}</td>
                            <td style="white-space: nowrap;">{{ $item->bien }}</td>
                            <td style="white-space: nowrap;">{{ $item->marca }}</td>
                            <td style="white-space: nowrap;">{{ $item->modelo }}</td>
                            <td style="white-space: nowrap;">{{ $item->serie }}</td>
                            <td style="white-space: nowrap;">{{ $item->color }}</td>
                            <td style="white-space: nowrap;">{{ $item->est_cons }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <table class="tabla-firma">
                <tbody>
                    <tr>
                        <td><p></p><p></p><p></p></td>
                    </tr>
                    <tr>                                             
                        <td class="borde-superior">Entregué Conforme</td>                        
                        <td></td>                       
                        <td class="borde-superior">Recibí Conforme</td>     
                        <td></td>                        
                        <td class="borde-superior">Control Patrimonial<br></td> 
                    </tr>
                </tbody>
            </table>

            {{-- <hr style="border: 0; border-top: 1px solid #000;">
            <span style="font-size: 9px;">Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín</span> --}}
        </div>
    </body>
</html>
