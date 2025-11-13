<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario - {{ $docente->usuario->nombre_completo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .info-box p {
            margin: 5px 0;
        }
        .day-section {
            margin-bottom: 20px;
        }
        .day-header {
            background-color: #2196F3;
            color: white;
            padding: 8px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background-color: #e8f4f8;
            border: 1px solid #b8dce8;
        }
        .summary-item strong {
            display: block;
            font-size: 18px;
            color: #0066cc;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HORARIO SEMANAL</h1>
        <p><strong>Docente:</strong> {{ $docente->usuario->nombre_completo }}</p>
        <p><strong>Gestión Académica:</strong> {{ $gestion->nombre }}</p>
        <p>{{ $gestion->fecha_inicio->format('d/m/Y') }} - {{ $gestion->fecha_fin->format('d/m/Y') }}</p>
    </div>

    <div class="info-box">
        <p><strong>Email:</strong> {{ $docente->usuario->email ?? 'N/A' }}</p>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Resumen -->
    <div class="summary">
        <div class="summary-item">
            <strong>{{ $horarios->unique('grupo.materia_id')->count() }}</strong>
            <span>Materias</span>
        </div>
        <div class="summary-item">
            <strong>{{ $horarios->unique('grupo_id')->count() }}</strong>
            <span>Grupos</span>
        </div>
        <div class="summary-item">
            <strong>{{ $horarios->count() }}</strong>
            <span>Clases/Semana</span>
        </div>
    </div>

    <!-- Horarios por día -->
    @php
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];
    @endphp

    @foreach($horariosPorDia as $dia => $horariosDelDia)
        <div class="day-section">
            <div class="day-header">{{ $dias[$dia] ?? 'N/A' }}</div>
            <table>
                <thead>
                    <tr>
                        <th>Horario</th>
                        <th>Materia</th>
                        <th>Grupo</th>
                        <th>Aula</th>
                        <th>Capacidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horariosDelDia as $horario)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                            </td>
                            <td>{{ $horario->grupo->materia->nombre ?? 'N/A' }}</td>
                            <td>{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                            <td>{{ $horario->aula->codigo ?? 'N/A' }}</td>
                            <td>{{ $horario->aula->capacidad ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <p>Sistema de Gestión Docente - Reporte generado automáticamente</p>
    </div>
</body>
</html>