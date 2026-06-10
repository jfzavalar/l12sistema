<?php

namespace App\Exports;

use App\Models\Persona;
use App\Models\PersonalesAtencione;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TicketsfiltrosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $search, 
                $filtro_atendido, 
                $filtro_enviadolima, 
                $filtro_atendidou, 
                $filtro_anio, 
                $filtro_mes,
                $filtro_sede,
                $filtro_dependencia,
                $filtro_servicio,
                $filtro_incidencia;

    public function __construct($search, 
                                $filtro_atendido, 
                                $filtro_enviadolima, 
                                $filtro_atendidou, 
                                $filtro_anio, 
                                $filtro_mes,
                                $filtro_sede,
                                $filtro_dependencia,
                                $filtro_servicio,
                                $filtro_incidencia)
    {
        $this->search = $search;
        $this->filtro_atendido = $filtro_atendido;
        $this->filtro_enviadolima = $filtro_enviadolima;
        $this->filtro_atendidou = $filtro_atendidou;
        $this->filtro_anio = $filtro_anio;
        $this->filtro_mes = $filtro_mes;

        $this->filtro_sede = $filtro_sede;
        $this->filtro_dependencia = $filtro_dependencia;
        $this->filtro_servicio = $filtro_servicio;
        $this->filtro_incidencia = $filtro_incidencia;
    }

    public function collection()
    {
        return PersonalesAtencione::select(
                'personales_atenciones.*'
            )

            ->where('personales_atenciones.activo', 1)

            // FILTRO ATENDIDO
            ->when($this->filtro_atendido, function ($q) {

                $q->where(
                    'personales_atenciones.atendido',
                    $this->filtro_atendido
                );

            })
            // FILTRO ENVIADO LIMA
            ->when($this->filtro_enviadolima, function ($q) {

                $q->where(
                    'personales_atenciones.enviado_lima',
                    $this->filtro_enviadolima
                );

            })
            // FILTRO ATENDIDO USUARIO
            ->when($this->filtro_atendidou, function ($q) {

                $q->where(
                    'personales_atenciones.atendido',
                    $this->filtro_atendidou
                );

            })
            // FILTRO AÑO
            ->when($this->filtro_anio, function ($q) {

                $q->whereYear(
                    'personales_atenciones.created_at',
                    $this->filtro_anio
                );

            })
            // FILTRO MES
            ->when($this->filtro_mes, function ($q) {

                $q->whereMonth(
                    'personales_atenciones.created_at',
                    $this->filtro_mes
                );

            })
            // FILTRO SEDE
            ->when($this->filtro_sede, function ($q) {

                $q->where(
                    'sededestino',
                    $this->filtro_sede
                );

            })
            // FILTRO DEPENDENCIA
            ->when($this->filtro_dependencia, function ($q) {

                $q->where(
                    'dependenciadestino',
                    $this->filtro_dependencia
                );

            })
            // FILTRO SERVICIO
            ->when($this->filtro_servicio, function ($q) {

                $q->where(
                    'servicio',
                    $this->filtro_servicio
                );

            })
            // FILTRO SERVICIO
            ->when($this->filtro_incidencia, function ($q) {

                $q->where(
                    'detalle_servicio',
                    $this->filtro_incidencia
                );

            })

            ->orderBy('personales_atenciones.id', 'desc')

            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'persona_id',
            'dni',
            'nombres',
            'appaterno',
            'apmaterno',
            'celpersonal',
            'celinstitucional',
            'correopersonal',
            'correoinstitucional',
            'datos',
            'personal_id',
            'codsedeorigen',
            'sedeorigen',
            'coddependenciaorigen',
            'dependenciaorigen',
            'coddespachoorigen',
            'despachoorigen',
            'codsededestino',
            'sededestino',
            'coddependenciadestino',
            'dependenciadestino',
            'coddespachodestino',
            'despachodestino',
            'regimen',
            'tipo_regimen',
            'cargo',
            'cargo_condicion',
            'reportado_por',
            'solicitud_incidencia',
            'servicio',
            'detalle_servicio',
            'bien_id',
            'cod',
            'cod_patrimonial',
            'datos_bien',
            'ip',
            'cea',
            'sgf',
            'glpi',
            'enviado_lima',
            'detalle_problema',
            'ncopias',
            'obs_usuario',
            'obs_informatico',
            'estado',
            'atendido',
            'atendido_por_id',
            'atendido_por_dni',
            'atendido_por_datos',
            'tiempo_atencion',
            'respuesta',
            'conformidad',
            'ruta_evidencia',
            'ruta_documento',
            'informatico_dni',
            'informatico',
            'activo',
            'created_user_cargo',
            'created_user',
            'updated_user',
            'created_at',
            'updated_at',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Bordes a toda la tabla
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Centrar encabezado
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
