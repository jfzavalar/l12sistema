<?php

namespace App\Exports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PersonasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select('personas.id','personas.dni','personas.datos','personas.celpersonal','personas.correopersonal',
                'personales.celinstitucional',
                'personales.correoinstitucional',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen')
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
            'SEDE',
            'DEPENDENCIA',
            'DESPACHO',
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
