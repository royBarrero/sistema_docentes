<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HorariosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $horarios;
    protected $docente;

    public function __construct($horarios, $docente = null)
    {
        $this->horarios = $horarios;
        $this->docente = $docente;
    }

    public function collection()
    {
        return $this->horarios;
    }

    public function headings(): array
    {
        return [
            'Día',
            'Hora Inicio',
            'Hora Fin',
            'Docente',
            'Materia',
            'Grupo',
            'Aula',
            'Capacidad',
            'Estado',
        ];
    }

    public function map($horario): array
    {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];

        return [
            $dias[$horario->dia_semana] ?? 'N/A',
            Carbon::parse($horario->hora_inicio)->format('H:i'),
            Carbon::parse($horario->hora_fin)->format('H:i'),
            $horario->docente->usuario->nombre_completo ?? 'N/A',
            $horario->grupo->materia->nombre ?? 'N/A',
            $horario->grupo->nombre ?? 'N/A',
            $horario->aula->codigo ?? 'N/A',
            $horario->aula->capacidad ?? 'N/A',
            $horario->estado,
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
        return 'Horarios';
    }
}