<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>@yield('title', config('app.name', 'Laravel')) | ILS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-vYtwG9B9tTBZh7owIuI+P4xPv7Y+9QzZHl+6Z4IDv2Oe6A0UJYfnwIpSJjoO75x6F4j83jvn3jDClIb5lWgYsQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Add the Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>
        /* Estilos para la pantalla de carga */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            backdrop-filter: blur(10px);
            pointer-events: none; /* Esto asegura que la pantalla de carga no interfiera con la interacción inicial */
        }

        #loadingScreen.show {
            opacity: 1;
            pointer-events: auto; /* Permitir la interacción cuando se muestra la pantalla de carga */
            overflow: hidden; /* Deshabilitar el scroll cuando la pantalla de carga esté activa */
        }

        .spinner {
            position: relative;
            width: 150px; /* Aumenta el tamaño del spinner */
            height: 150px; /* Aumenta el tamaño del spinner */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top: 5px solid #728694;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .spinner img {
            width: 70%;
            height: 70%;
            object-fit: contain;
            opacity: 0.4;
            animation: sail 2s ease-in-out infinite;
            margin-top: 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes sail {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <x-banner />

    <div id="loadingScreen">
        <div class="spinner">
            <img src="{{ asset('storage/images/spinnerlogoship.png') }}" alt="Loading">
        </div>
    </div>

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loadingScreen = document.getElementById('loadingScreen');
            const body = document.body;

            function showLoading() {
                loadingScreen.classList.add('show');
                body.style.overflow = 'hidden';
            }

            function hideLoading() {
                loadingScreen.classList.remove('show');
                body.style.overflow = 'auto';
            }

            document.querySelectorAll('.buque-card').forEach(function (card) {
                card.addEventListener('click', function (event) {
                    event.preventDefault();
                    showLoading();
                    const href = this.href;
                    setTimeout(function () {
                        window.location.href = href;
                    }, 500);
                });
            });

            window.addEventListener('load', function () {
                hideLoading();
            });
        });
    </script>
</body>
</html>
