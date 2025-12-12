<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GRES: {{ $buque->nombre_proyecto }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            position: relative;
            margin-top: 80px;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('storage/images/BackgroundPDF.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
        }
        .header, .footer {
            width: 100%;
            text-align: center;
            position: fixed;
            z-index: 2;
        }
        .header {
            top: 0;
        }
        .footer {
            bottom: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .content {
            padding: 50px;
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
            box-sizing: border-box;
        }
        .cover-page {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            z-index: 1;
            margin-top: 50%;
        }
        .cover-page h1 {
            color: #1c345c;
        }
        h2, p, h3 {
            margin: 0 0 10px 0;
            word-wrap: break-word;
            color: #1c345c;
        }
        .collaborators {
            margin-top: 20px;
            text-align: center;
        }
        .system-block {
            margin-bottom: 50px;
        }
        .system-title {
            font-size: 18px;
            font-weight: bold;
            color: #1c345c;
        }
        .system-mec {
            margin-top: 10px;
            font-size: 16px;
            font-style: italic;
            color: #555;
        }
        .table-container {
            margin-top: 20px;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        table th {
            background-color: #1c345c;
            color: white;
        }
    </style>
</head>
<body>
<div class="background"></div>

<!-- Portada -->
<div class="cover-page">
    <h1>ANEXO GRES - SISTEMAS: {{ $buque->nombre_proyecto }}</h1>
    <div class="collaborators">
        @foreach ($buque->colaboradores as $colaborador)
            <h3>{{ $colaborador->col_cargo }} {{ $colaborador->col_nombre }} {{ $colaborador->col_entidad }}</h3>
        @endforeach
    </div>
</div>

<div class="page-break"></div>

<!-- Contenido de los sistemas con MEC asignado -->
<div class="content">
    @foreach($sistemasBuques as $sistema)
        @if(!empty($sistema->pivot->mec))
            <div class="system-block">
                <div class="system-title">{{ $sistema->codigo }}: {{ strtoupper($sistema->nombre) }}</div>
                <div class="system-mec">MEC asignado: {{ $sistema->pivot->mec }}</div>

                @if(!empty($sistema->pivot->observaciones))
                    <div class="table-container">
                        <table>
                            <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Observación</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sistema->pivot->observaciones as $pregunta => $observacion)
                                <tr>
                                    <td>{{ ucfirst($pregunta) }}</td>
                                    <td>{{ $observacion }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="page-break"></div>
        @endif
    @endforeach
</div>
</body>
</html>
