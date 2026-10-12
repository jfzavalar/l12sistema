<?php

namespace App\Exports;

use App\Models\InformaticasBienesAnexosAsignaciones;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AnexosfiltrosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected   $filtro_sede,
                $filtro_dependencia;

    public function __construct($filtro_sede,
                                $filtro_dependencia)
    {
        $this->filtro_sede = $filtro_sede;
        $this->filtro_dependencia = $filtro_dependencia;
    }

    public function collection()
    {
        return InformaticasBienesAnexosAsignaciones::select('anexo','tipo','datos','dni','cargo','asignacionlibrecustodia','custodia')

            ->where('activo', 1)

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

            ->orderBy('datos')

            ->get();
    }

    public function headings(): array
    {
        return [
            'ANEXO',
            'TIPO',
            'DATOS',
            'DNI',
            'CARGO',
            'ESTADO',
            'CUSTODIA',
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
