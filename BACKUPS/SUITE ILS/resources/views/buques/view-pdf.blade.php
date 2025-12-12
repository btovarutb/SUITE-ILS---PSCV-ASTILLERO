<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GRES: {{ $buque->nombre_proyecto }}</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .pdf-container {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body>
    <iframe class="pdf-container" src="{{ route('buques.exportPdf', ['buque' => $buque->id]) }}"></iframe>
</body>
</html>
