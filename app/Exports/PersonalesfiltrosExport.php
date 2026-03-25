<?php

namespace App\Exports;

use App\Models\Persona;
use App\Models\Personale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PersonalesfiltrosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $filtrosede, $filtrodependencia, $search, $filtrotipodocumento, $filtroregimen;

    public function __construct($search, $filtrosede, $filtrodependencia, $filtrotipodocumento, $filtroregimen)
    {
        $this->search = $search;
        $this->filtrosede = $filtrosede;
        $this->filtrodependencia = $filtrodependencia;
        $this->filtrotipodocumento = $filtrotipodocumento;
        $this->filtroregimen = $filtroregimen;
    }

    public function collection()
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
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
                'personales.sedeorigen as sede',
                'personales.dependenciaorigen as dependencia',
                'personales.despachoorigen as despacho',
                'personales.tipo_documento as condicion',
            )
            ->where('personales.activo', 1)

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->filtrosede, function ($query) {
                $query->where('personales.codsedeorigen', $this->filtrosede);
            })

            ->when($this->filtrodependencia, function ($query) {
                $query->where('personales.coddependenciaorigen', $this->filtrodependencia);
            })

            ->when($this->filtrotipodocumento, function ($query) {
                $query->where('personales.tipo_documento', 'like', '%' . $this->filtrotipodocumento . '%');
            })

            ->when($this->filtroregimen, function ($query) {
                $query->where('personales.regimen', 'like', '%' . $this->filtroregimen . '%');
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
            'SEDE',
            'DEPENDENCIA',
            'DESPACHO',
            'CONDICION',
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
