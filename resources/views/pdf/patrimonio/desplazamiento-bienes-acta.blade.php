<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ACTA DE DESPLAZAMIENTO</title>
        <style>
            @import url('./css/body.css');
            @import url('./css/pagina.css');
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
                            <img src="{{ public_path('img/mpfn_encabezado.png') }}"  width="200">
                        </th>
                        <th style="text-align: right;">
                            <br><span style="font-size: 10px;">"Año de la recuperación y consolidación de la economía peruana"</span>
                            <table class="tabla-encabezado">
                                <thead>
                                    <tr>
                                        <th>N° Autorización de desplazo:</th>
                                        <td>{{ $instanciaTbl->id }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Fecha de emisión:</th>
                                        <td>{{ date('d/m/Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                </thead>
            </table>
            <hr style="border: 0; border-top: 1px solid #000;">
        </div>
        
        <div class="content">
            <div style="font-size: 10px; text-align: center; font-weight: bold;">
                FORMATO N° 1
                <br>AUTORIZACIÓN DE DESPLAZAMIENTO DE BIENES PATRIMONIALES
            </div>
            <p></p>
            <table class="tabla-datos">
                <thead>

                </thead>
                <tbody>
                    <tr>
                        <th>SOLICITANTE</th>
                        <td> {{ ' ' . $instanciaTbl->solicitante }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>RESPONSABLE DE TRASLADO</th>
                        <td> {{ ' ' . $instanciaTbl->responsabletraslado }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>DEPENDENCIA DE ORIGEN</th>
                        <td> {{ ' ' . $instanciaTbl->sede_origen . ' ' . $instanciaTbl->dependencia_origen }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>DEPENDENCIA DE DESTINO</th>
                        <td> {{ ' ' . $instanciaTbl->sede_destino . ' ' . $instanciaTbl->dependencia_destino }}</td>
                    </tr>
                    <tr>
                        <tr><th></th><td></td></tr>
                        <th>MOTIVO</th>
                        <td> {{ ' ' . $instanciaTbl->motivo_traslado }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>TIPO DE TRASLADO</th>
                        <td> {{ ' ' . $instanciaTbl->tipotraslado }}</td>
                    </tr>
                </tbody>
            </table>
            <p></p>
            <table class="tabla">
                <thead >
                    <tr>
                        <th>N°</th>
                        <th>CODIGO BARRAS</th>
                        <th>CODIGO MARGESI</th>
                        <th>DESCRIPCION</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>SERIE</th>
                        <th>COLOR</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instanciaTbl_detalle as $item)
                        <tr>
                            <td>1</td>
                            <td>{{ $item->cod_patrimonial }}</td>
                            <td>{{ $item->cod_barra }}</td>
                            <td>{{ $item->bien }}</td>
                            <td>{{ $item->marca }}</td>
                            <td>{{ $item->modelo }}</td>
                            <td>{{ $item->serie }}</td>
                            <td>{{ $item->color }}</td>
                            <td>{{ $item->est_cons }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p></p>
            <table class="tabla-datos">
                <thead>

                </thead>
                <tbody>
                    <tr>
                        <th>FECHA DE SALIDA</th>
                        <td>{{ ' ' . $instanciaTbl->fechasalida }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>FECHA POSIBLE DE RETORNO</th>
                        <td>{{ ' ' . $instanciaTbl->fecharetorno }}</td>
                    </tr>
                    <tr><th></th><td></td></tr>
                    <tr>
                        <th>OBSERVACIÓN</th>
                        <td>{{ ' ' . $instanciaTbl->observacion }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <table class="tabla-firma">
                <tbody>
                    <tr>                        
                        <td class="borde-superior">Firma y sello del solicitante</td>
                        <td></td>                        
                        <td class="borde-superior">V.B. Responsable Control Patrimonial</td>                        
                        <td></td>                       
                        <td class="borde-superior">V.B. Responsable Administrador</td>     
                        <td></td>                        
                        <td class="borde-superior">V.B. Seguridad<br></td> 
                    </tr>
                </tbody>
            </table>

            <p></p>
            <hr style="border: 0; border-top: 1px solid #000;">
            <span style="font-size: 9px;">Ministerio Público - Fiscalía de Nación - Distrito Fiscal Junín</span>
        </div>
    </body>
</html>
