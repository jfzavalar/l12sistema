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
    protected $search, $filtro_atendido, $filtro_enviadolima, $filtro_atendidou, $filtro_anio, $filtro_mes;

    public function __construct($search, $filtro_atendido, $filtro_enviadolima, $filtro_atendidou, $filtro_anio, $filtro_mes)
    {
        $this->search = $search;
        $this->filtro_atendido = $filtro_atendido;
        $this->filtro_enviadolima = $filtro_enviadolima;
        $this->filtro_atendidou = $filtro_atendidou;
        $this->filtro_anio = $filtro_anio;
        $this->filtro_mes = $filtro_mes;
    }

    public function collection()
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('personales_atenciones','personas.id', '=', 'personales_atenciones.persona_id')
            ->select(
                'personas.id',
                'personas.dni',
                'personas.datos',
                'personas.celpersonal',
                'personas.correopersonal',

                'personales.celinstitucional',
                'personales.correoinstitucional',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.cargo_condicion',
                'personales.sedeorigen as sede',
                'personales.dependenciaorigen as dependencia',
                'personales.despachoorigen as despacho',
                'personales.sededestino as sedeu',
                'personales.dependenciadestino as dependenciau',
                'personales.despachodestino as despachou',

                'personales.tipo_documento as condicion',

                'personales_atenciones.reportado_por',
                'personales_atenciones.servicio',
                'personales_atenciones.detalle_servicio',
                'personales_atenciones.solicitud_incidencia',
                'personales_atenciones.atendido',
                'personales_atenciones.atendido_por_datos',
            )
            ->where('personales.activo', 1)

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->filtro_atendido, fn($q) =>
                $q->where('atendido', $this->filtro_atendido)
            )
            ->when($this->filtro_enviadolima, fn($q) =>
                $q->where('enviado_lima', $this->filtro_enviadolima)
            )
            ->when($this->filtro_atendidou, fn($q) =>
                $q->where('atendido', $this->filtro_atendidou)
            )

            // 🔥 FILTRO AÑO
            ->when($this->filtro_anio, function ($q) {
                $q->whereYear('personales_atenciones.created_at', $this->filtro_anio);
            })

            // 🔥 FILTRO MES
            ->when($this->filtro_mes, function ($q) {
                $q->whereMonth('personales_atenciones.created_at', $this->filtro_mes);
            })

            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'DNI',
            'DATOS',
            'CEL_PERSONAL',
            'CORREO_PERSONAL',

            'CEL_INSTITUCIONAL',
            'CORREO_INSTITUCIONAL',
            'REGIMEN',
            'TIPO_REGIMEN',
            'CARGO',
            'CONDICION',

            'SEDE',
            'DEPENDENCIA',
            'DESPACHO',
            'SEDE_ROTACION',
            'DEPENDENCIA_ROTACION',
            'DESPACHO_ROTACION',

            'CONDICION',

            'REPORTADO_POR',
            'SERVICIO',
            'DETALLE',
            'SOLICITUD-INCIDENCIA',
            'ATENDIDO',
            'ATENDIDO_POR',
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
