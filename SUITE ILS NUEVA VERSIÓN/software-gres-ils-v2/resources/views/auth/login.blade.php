<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Suite ILS | Cotecmar</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind y Vite (si usas Jetstream con Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Fuente global Inter */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Ocupa toda la pantalla */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Flexbox para alinear contenido */
        .main-container {
            display: flex;
            min-height: 100vh;
        }

        /* Carrusel */
        .carousel-container {
            width: 60%;
            position: relative;
            overflow: hidden;
        }

        .slide-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.8s ease-in-out;
            opacity: 1;
        }

        /* Fondo de partículas */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        /* Estilo del formulario */
        .login-section {
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: #ffffff;
            position: relative;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1;
            width: 100%;
            max-width: 400px;
            opacity: 0;
            animation: fadeIn 0.8s forwards ease-in-out;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Texto inferior */
        .footer-text {
            margin-top: 20px;
            font-size: 0.875rem;
            color: #6B7280;
            font-weight: 300;
            text-align: center;
        }

        /* OCULTAR CARRUSEL EN MÓVILES */
        @media (max-width: 768px) {
            .carousel-container {
                display: none;
            }

            .login-section {
                width: 100%;
                padding: 1rem;
            }
        }

        /* Efecto Suite ILS */
        .suite-ils-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .line {
            display: block;
            width: 3px;
            height: 40px;
            background-color: #105dad;
            margin-right: 10px;
            animation: growLine 0.6s ease-out forwards;
            transform: scaleY(0);
        }

        .suite-ils {
            display: inline-block;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(-30px);
            animation: slideIn 0.8s ease-out 0.6s forwards;
        }

        @keyframes growLine {
            to {
                transform: scaleY(1);
            }
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- COLUMNA IZQUIERDA: Carrusel -->
    <div class="carousel-container">
        <img id="carouselImage" src="/images/slide1.webp" alt="Slide" class="slide-image">
    </div>

    <!-- COLUMNA DERECHA: Login -->
    <div class="login-section">
        <!-- Fondo de partículas -->
        <div id="particles-js"></div>

        <!-- Formulario de Login -->
        <div class="login-card">
            <h1 class="text-2xl font-bold text-center mb-4 text-blue-900 suite-ils-container">
                <span class="text-left mr-2">Iniciar sesión</span>
                <span class="line"></span>
                <span class="suite-ils">SGESEN</span>
            </h1>

            <!-- Texto adicional -->
            <p class="text-center text-sm text-gray-500 mb-6 font-light">
                Bienvenido al Software de Grado de Esencialidad de Sistemas y Equipos Navales, recuerda usar este sistema con precaución y de manera responsable.
            </p>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-label for="email" :value="__('Correo Electrónico')" />
                    <x-input id="email" class="block mt-1 w-full"
                             type="email" name="email"
                             :value="old('email')"
                             required autofocus autocomplete="username" />
                </div>

                <!-- Password -->
                <div>
                    <x-label for="password" :value="__('Contraseña')" />
                    <x-input id="password" class="block mt-1 w-full"
                             type="password" name="password"
                             required autocomplete="current-password" />
                </div>

                <!-- Mostrar contraseña -->
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="show_password" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                    <label for="show_password" class="ml-2 text-sm text-gray-600">
                        {{ __('Mostrar contraseña') }}
                    </label>
                </div>

                <!-- Remember me -->
                <div class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">
                        {{ __('Recordarme') }}
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex flex-col items-center mt-4 space-y-3">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 text-center"
                           href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <x-button class="w-full text-center justify-center">
                        {{ __('Acceder') }}
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Texto inferior FUERA del formulario -->
        <p class="footer-text">
            Diseñado y Desarrollado por Cotecmar ILS | Todos los derechos reservados
        </p>
    </div>
</div>

@livewireScripts

<!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<!-- Script para Partículas -->
<script>
    particlesJS('particles-js', {
        "particles": {
            "number": {
                "value": 80,
                "density": { "enable": true, "value_area": 800 }
            },
            "color": { "value": "#2858c5" },
            "shape": { "type": "circle" },
            "opacity": {
                "value": 0.5,
                "random": true
            },
            "size": {
                "value": 3,
                "random": true
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#2858c5",
                "opacity": 0.2,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1,
                "direction": "none",
                "out_mode": "out"
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": { "enable": false },
                "onclick": { "enable": false }
            }
        },
        "retina_detect": true
    });
</script>

</body>
</html>
