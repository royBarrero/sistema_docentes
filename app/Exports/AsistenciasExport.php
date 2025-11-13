<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AsistenciasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $asistencias;
    protected $docente;

    public function __construct($asistencias, $docente = null)
    {
        $this->asistencias = $asistencias;
        $this->docente = $docente;
    }

    public function collection()
    {
        return $this->asistencias;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Día',
            'Docente',
            'Materia',
            'Grupo',
            'Aula',
            'Horario',
            'Hora Registro',
            'Estado',
            'Observación',
        ];
    }

    public function map($asistencia): array
    {
        return [
            Carbon::parse($asistencia->fecha)->format('d/m/Y'),
            Carbon::parse($asistencia->fecha)->locale('es')->isoFormat('dddd'),
            $asistencia->horario->docente->usuario->nombre_completo ?? 'N/A',
            $asistencia->horario->grupo->materia->nombre ?? 'N/A',
            $asistencia->horario->grupo->nombre ?? 'N/A',
            $asistencia->horario->aula->codigo ?? 'N/A',
            Carbon::parse($asistencia->horario->hora_inicio)->format('H:i') . ' - ' . 
            Carbon::parse($asistencia->horario->hora_fin)->format('H:i'),
            $asistencia->hora_registro ? Carbon::parse($asistencia->hora_registro)->format('H:i:s') : '-',
            $asistencia->estado,
            $asistencia->observacion ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Asistencias';
    }
}