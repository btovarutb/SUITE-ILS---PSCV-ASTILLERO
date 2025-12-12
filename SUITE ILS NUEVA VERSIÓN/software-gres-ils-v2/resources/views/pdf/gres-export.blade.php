<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Márgenes generales */
        @page {
            margin: 0cm 1.5cm;
        }
        /* Portada sin márgenes para fondo full-bleed */
        @page :first {
            margin: 0;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            line-height: 1.6;
        }

        /* ===== PORTADA ===== */
        .portada {
            text-align: center;
            width: 216mm;       /* si sigues en A4 puedes dejar 210 x 297, pero 216x279 no afecta DomPDF */
            height: 279mm;      /* mantenlo igual al otro PDF para consistencia visual */
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            padding: 0;
            color: white; /* textos en blanco */
            @if(!empty($portadaBase64))
                background-image: url('{{ $portadaBase64 }}');
            @endif
        }

        .portada-titulo {
            margin-top: 250px;       /* margin top como el otro PDF */
            font-size: 36px;
            font-weight: bold;
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
            line-height: 1.2;
            color: white;
            white-space: pre-line;   /* respeta saltos de línea */
        }

        .colaboradores {
            margin: 30px auto;
            max-width: 80%;
            position: relative;
            z-index: 1;
            color: white;            /* blanco en portada */
            font-size: 14px;
        }

        .fecha-generacion {
            color: white;
            font-size: 16px;
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }

        .portada-logo {
            text-align: center;
            margin-top: 40px;
            position: relative;
            z-index: 1;
        }

        .portada-logo img {
            height: 80px;
            width: auto;
            opacity: 60%;
        }

        /* ===== HEADER ===== (mismo color que el otro PDF) */
        .header {
            background-color: #0e253d;
            color: white;
            padding: 15px 30px;
            margin: 0 -1.5cm 20px -1.5cm;
            text-align: left;
        }

        .header h1, .header img {
            display: inline-block;
            vertical-align: middle;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 20px;
            font-weight: lighter;
            white-space: nowrap;
            padding-right: 20px;
        }

        .header img {
            height: 40px;
            width: auto;
            float: right;
            padding-bottom: 10px;
        }

        .content-wrapper {
            padding: 20px 30px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .system-info {
            position: relative;
            margin-bottom: 20px;
        }

        .system-info-left {
            display: block;
            max-width: 70%;
            padding-right: 120px;
        }

        .group-system {
            color: #013882;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .system-name {
            font-size: 18px;
            color: #013882;
            margin: 0;
            font-weight: normal;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .mec-box {
            background-color: #013882;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            position: absolute;
            top: 0;
            right: 0;
            white-space: nowrap;
            min-width: fit-content;
            font-size: 16px;
        }

        .diagram-container {
            margin-bottom: 5px;
            border: 1px solid #013882;
            padding: 10px;
            text-align: center;
        }

        .diagram-container img {
            max-width: 80%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .diagram-citation {
            font-style: italic;
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 5px;
        }

        .observations-section {
            margin-bottom: 20px;
            max-width: 100%;
            padding-right: 30px;
        }

        .observations-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #013882;
        }

        /* ===== Observaciones mejoradas (igual que equipos) ===== */
        .observations-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .obs-item {
            display: grid;
            width: 100%;
            grid-template-columns: 1fr;
            gap: 6px;
            padding: 10px 12px;
            margin-bottom: 10px;
            border: 1px solid #d6e1f5;
            border-radius: 6px;
            background: #f7faff;
            page-break-inside: avoid;
        }

        .obs-q {
            font-weight: 700;
            color: #013882;
            font-size: 13px;
            line-height: 1.35;
        }

        .obs-qnum {
            display: inline-block;
            min-width: 28px;
            padding: 2px 6px;
            margin-right: 6px;
            border-radius: 12px;
            background: #013882;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            text-align: center;
        }

        .obs-text {
            color: #013882;
            font-size: 13px;
            line-height: 1.5;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .continuation-header {
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .numero-pagina {
            position: fixed;
            bottom: 1cm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: rgba(0, 0, 0, 0.5);
        }
    </style>

</head>
<body>
<div class="portada">
    <h1 class="portada-titulo">{!! nl2br(e($titulo)) !!}</h1>

    @if(!empty($colaboradores))
        <div class="colaboradores">
            @foreach($colaboradores as $colaborador)
                {{ $colaborador['nombre'] }} {{ $colaborador['apellido'] }} - {{ $colaborador['cargo'] }} {{ $colaborador['entidad'] }}<br>
            @endforeach
        </div>
    @endif

    <div class="fecha-generacion">
        {{ $fechaGeneracion }}
    </div>
    <div class="portada-logo">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" alt="COTECMAR">
        @endif
    </div>
</div>


@php $numeroPagina = 1; @endphp

@php
    $PREGUNTAS = [
        1 => '¿SE PIERDE CAPACIDAD DE LA UNIDAD SI EL EQUIPO QUEDA INOPERATIVO?',
        2 => '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, SISTEMA O MEDIO AMBIENTE?',
        3 => '¿EXISTE REDUNDANCIA DENTRO DEL EQUIPO PARA MITIGAR EL EFECTO ADVERSO?',
        4 => '¿CAUSA ALGUNA LIMITACIÓN SOBRE ALGUNA MISIÓN?',
        5 => '¿EXISTEN REDUNDANCIAS DENTRO DEL EQUIPO?',
        6 => '¿MITIGA COMPLETAMENTE EL EFECTO DE LA LIMITACIÓN?',
        7 => '¿QUÉ PÉRDIDAS SERÍAN? (A) Menores o 1 misión - (B) Más de 1 misión',
    ];
@endphp


@foreach($sistemas as $sistema)
    @php
        $observaciones = $sistema['observaciones'];
        $totalObservaciones = count($observaciones);
        $observacionesPorPagina = 10;
        $observacionesMostradasInicial = min(1, $totalObservaciones);
    @endphp

    <div class="page-break">
        <div class="header">
            <h1>Anexo de Grado de Esencialidad (GRES)</h1>
            @if($headerLogoBase64)
                <img src="{{ $headerLogoBase64 }}" alt="COTECMAR">
            @endif
        </div>

        <div class="content-wrapper">
            <div class="system-info">
                <div class="system-info-left">
                    <div class="group-system">GRUPO {{ $sistema['grupo_codigo'] }} - SISTEMA {{ $sistema['codigo'] }}</div>
                    <h2 class="system-name">{{ $sistema['nombre'] }}</h2>
                </div>
                <div class="mec-box">
                    MEC {{ $sistema['mec'] }}
                </div>
            </div>

            <div class="diagram-container">
                <img src="{{ $sistema['diagrama'] }}" alt="Diagrama del sistema">
            </div>
            <div class="diagram-citation">
                Basado en I. García, Anatomía de sistemas: Su análisis y su apoyo. Ediciones Díaz de Santos, 2016.
            </div>

            @if($totalObservaciones > 0)
                <div class="observations-section">
                    <h3 class="observations-title">Observaciones</h3>
                    <ul class="observations-list">
                        @for($i = 0; $i < $observacionesMostradasInicial; $i++)
                            @php
                                $qNum  = (int)($observaciones[$i]['pregunta'] ?? 0);
                                $qText = $PREGUNTAS[$qNum] ?? ("Pregunta " . $qNum);
                                $oText = (string)($observaciones[$i]['texto'] ?? '');
                            @endphp
                            <li class="obs-item">
                                <div class="obs-q">
                                    <span class="obs-qnum">P{{ $qNum }}</span>
                                    {{ $qText }}
                                </div>
                                <div class="obs-text">
                                    {{ $oText }}
                                </div>
                            </li>
                        @endfor
                    </ul>

                </div>
                @if($totalObservaciones > $observacionesMostradasInicial)
                    <div class="continuation-header">Continúa en la siguiente página...</div>
                @endif
            @endif

            <div class="numero-pagina">{{ $numeroPagina }}</div>
            @php $numeroPagina++; @endphp
        </div>
    </div>

    @php
        $observacionesMostradas = $observacionesMostradasInicial;
    @endphp

    @while($observacionesMostradas < $totalObservaciones)
        <div class="page-break">
            <div class="header">
                <h1>Anexo de Grado de Esencialidad (GRES)</h1>
                @if($headerLogoBase64)
                    <img src="{{ $headerLogoBase64 }}" alt="COTECMAR">
                @endif
            </div>

            <div class="content-wrapper">
                <div class="system-info">
                    <div class="system-info-left">
                        <div class="group-system">GRUPO {{ $sistema['grupo_codigo'] }} - SISTEMA {{ $sistema['codigo'] }}</div>
                        <h2 class="system-name">{{ $sistema['nombre'] }}</h2>
                    </div>
                    <div class="mec-box">
                        MEC {{ $sistema['mec'] }}
                    </div>
                </div>

                <div class="observations-section">
                    <h3 class="observations-title">Observaciones</h3>
                    <ul class="observations-list">
                        @for($i = $observacionesMostradas; $i < min($observacionesMostradas + $observacionesPorPagina, $totalObservaciones); $i++)
                            @php
                                $qNum  = (int)($observaciones[$i]['pregunta'] ?? 0);
                                $qText = $PREGUNTAS[$qNum] ?? ("Pregunta " . $qNum);
                                $oText = (string)($observaciones[$i]['texto'] ?? '');
                            @endphp
                            <li class="obs-item">
                                <div class="obs-q">
                                    <span class="obs-qnum">P{{ $qNum }}</span>
                                    {{ $qText }}
                                </div>
                                <div class="obs-text">
                                    {{ $oText }}
                                </div>
                            </li>
                        @endfor
                    </ul>

                </div>

                @if($observacionesMostradas + $observacionesPorPagina < $totalObservaciones)
                    <div class="continuation-header">Continúa en la siguiente página...</div>
                @endif

                <div class="numero-pagina">{{ $numeroPagina }}</div>
                @php
                    $numeroPagina++;
                    $observacionesMostradas += $observacionesPorPagina;
                @endphp
            </div>
        </div>
    @endwhile
@endforeach

</body>
</html>

