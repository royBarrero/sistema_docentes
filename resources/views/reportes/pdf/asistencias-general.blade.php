<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General de Asistencias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background-color: #e8f4f8;
            border: 1px solid #b8dce8;
        }
        .stat-item strong {
            display: block;
            font-size: 20px;
            color: #0066cc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
        }
        .badge-presente {
            background-color: #4CAF50;
            color: white;
        }
        .badge-retraso {
            background-color: #FFC107;
            color: black;
        }
        .badge-ausente {
            background-color: #F44336;
            color: white;
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
        <h1>REPORTE GENERAL DE ASISTENCIAS</h1>
        @if($fecha_inicio || $fecha_fin)
            <p>
                <strong>Período:</strong> 
                {{ $fecha_inicio ? \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') : 'Inicio' }} 
                - 
                {{ $fecha_fin ? \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') : 'Actualidad' }}
            </p>
        @else
            <p><strong>Todos los registros</strong></p>
        @endif
    </div>

    <div class="info-box">
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Total de registros:</strong> {{ $estadisticas['total'] }}</p>
    </div>

    <!-- Estadísticas Globales -->
    <div class="stats">
        <div class="stat-item">
            <strong>{{ $estadisticas['total'] }}</strong>
            <span>Total</span>
        </div>
        <div class="stat-item">
            <strong>{{ $estadisticas['presentes'] }}</strong>
            <span>Presentes</span>
        </div>
        <div class="stat-item">
            <strong>{{ $estadisticas['retrasos'] }}</strong>
            <span>Retrasos</span>
        </div>
        <div class="stat-item">
            <strong>{{ $estadisticas['ausentes'] }}</strong>
            <span>Ausentes</span>
        </div>
        <div class="stat-item">
            <strong>{{ $estadisticas['total'] > 0 ? round(($estadisticas['presentes'] / $estadisticas['total']) * 100, 1) : 0 }}%</strong>
            <span>% Asistencia</span>
        </div>
    </div>

    <!-- Tabla de asistencias -->
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Docente</th>
                <th>Materia</th>
                <th>Grupo</th>
                <th>Aula</th>
                <th>Horario</th>
                <th>Hora Reg.</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $asistencia)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $asistencia->horario->docente->usuario->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $asistencia->horario->grupo->materia->nombre ?? 'N/A' }}</td>
                    <td>{{ $asistencia->horario->grupo->nombre ?? 'N/A' }}</td>
                    <td>{{ $asistencia->horario->aula->codigo ?? 'N/A' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($asistencia->horario->hora_inicio)->format('H:i') }}-{{ \Carbon\Carbon::parse($asistencia->horario->hora_fin)->format('H:i') }}
                    </td>
                    <td>
                        {{ $asistencia->hora_registro ? \Carbon\Carbon::parse($asistencia->hora_registro)->format('H:i') : '-' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ strtolower($asistencia->estado) }}">
                            {{ $asistencia->estado }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión Docente - Reporte generado automáticamente</p>
        <p>Página 1 de 1</p>
    </div>
</body>
</html>