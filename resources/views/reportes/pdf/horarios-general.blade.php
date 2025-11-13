<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General de Horarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
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
            font-size: 11px;
        }
        .info-box {
            background-color: #f0f0f0;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 5px;
        }
        .info-box p {
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 9px;
        }
        td {
            padding: 4px;
            border-bottom: 1px solid #ddd;
            font-size: 8px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .day-badge {
            background-color: #2196F3;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE GENERAL DE HORARIOS</h1>
        <p><strong>Gestión Académica:</strong> {{ $gestion->nombre }}</p>
        <p>{{ $gestion->fecha_inicio->format('d/m/Y') }} - {{ $gestion->fecha_fin->format('d/m/Y') }}</p>
    </div>

    <div class="info-box">
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Total de horarios:</strong> {{ $horarios->count() }}</p>
        <p><strong>Total de docentes:</strong> {{ $horarios->unique('docente_id')->count() }}</p>
    </div>

    <!-- Tabla de horarios -->
    <table>
        <thead>
            <tr>
                <th>Día</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Docente</th>
                <th>Materia</th>
                <th>Grupo</th>
                <th>Aula</th>
                <th>Cap.</th>
            </tr>
        </thead>
        <tbody>
            @php
                $dias = [
                    1 => 'Lun',
                    2 => 'Mar',
                    3 => 'Mié',
                    4 => 'Jue',
                    5 => 'Vie',
                    6 => 'Sáb',
                    7 => 'Dom',
                ];
            @endphp
            
            @foreach($horarios as $horario)
                <tr>
                    <td>
                        <span class="day-badge">{{ $dias[$horario->dia_semana] ?? 'N/A' }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                    <td>{{ $horario->docente->usuario->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $horario->grupo->materia->nombre ?? 'N/A' }}</td>
                    <td>{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                    <td>{{ $horario->aula->codigo ?? 'N/A' }}</td>
                    <td>{{ $horario->aula->capacidad ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión Docente - Reporte generado automáticamente</p>
        <p>Total de registros: {{ $horarios->count() }}</p>
    </div>
</body>
</html>