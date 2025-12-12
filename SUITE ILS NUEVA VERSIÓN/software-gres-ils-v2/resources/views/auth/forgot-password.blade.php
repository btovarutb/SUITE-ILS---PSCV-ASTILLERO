<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña - {{ config('app.name') }}</title>

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
        .reset-section {
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: #ffffff;
            position: relative;
        }

        .reset-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1;
            width: 100%;
            max-width: 400px;
            /* Animación de Fade In */
            opacity: 0;               /* Estado inicial */
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

            .reset-section {
                width: 100%;
                padding: 1rem;
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

    <!-- COLUMNA DERECHA: Restablecer Contraseña -->
    <div class="reset-section">
        <!-- Fondo de partículas -->
        <div id="particles-js"></div>

        <!-- Formulario de Restablecer Contraseña -->
        <div class="reset-card">
            <h1 class="text-2xl font-bold text-center mb-4 text-blue-900">
                {{ __('Restablecer Contraseña') }}
            </h1>

            <!-- Texto adicional -->
            <p class="text-center text-sm text-gray-500 mb-6 font-light">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-label for="email" :value="__('Correo Electrónico')" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Submit -->
                <div class="flex flex-col items-center mt-4 space-y-3 pr-4">
                    <x-button class="w-full text-center justify-center">
                        {{ __('Enviar Enlace de Restablecimiento') }}
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

<!-- Script para Partículas SIN interacción -->
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

<!-- Script del Carrusel -->
<script>
    const slides = [
        '/images/slide1.webp',
        '/images/slide2.webp',
        '/images/slide3.webp',
    ];

    let currentIndex = 0;
    const carouselImage = document.getElementById('carouselImage');
    const fadeDuration = 500;

    setInterval(() => {
        carouselImage.style.opacity = 0;

        setTimeout(() => {
            currentIndex = (currentIndex + 1) % slides.length;
            carouselImage.src = slides[currentIndex];
            carouselImage.style.opacity = 1;
        }, fadeDuration);
    }, 4000);
</script>

</body>
</html>
