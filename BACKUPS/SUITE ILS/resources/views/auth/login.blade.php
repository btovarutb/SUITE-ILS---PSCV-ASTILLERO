<x-guest-layout>
    @section('title') {{ 'Iniciar sesión' }} @endsection

    <div id="particles-js" class="absolute inset-0 z-0"></div> <!-- Contenedor de partículas -->

    <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-4 sm:py-12 z-10">
        <div class="max-w-4xl w-full grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-0 login-container" style="opacity: 0; transition: opacity 0.5s ease-in-out;">
            <div class="flex justify-center items-center">
                <img src="{{ asset('storage/images/CotecmarLogo.png') }}" alt="Cotecmar Logo" class="object-contain h-20 sm:h-60" draggable="false">
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex justify-center items-center" x-data="{ showPassword: false }">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input x-bind:type="showPassword ? 'text' : 'password'" id="password" class="block mt-1 w-full pl-3 pr-10" name="password" required autocomplete="current-password" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center translate-y-3">
                            <span class="h-full flex items-center cursor-pointer" @click="showPassword = !showPassword">
                                <!-- Ícono de ojo cerrado (para mostrar la contraseña) -->
                                <!-- Ícono de ojo abierto (para ocultar la contraseña) -->
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .394-.997.899-1.926 1.507-2.76M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3-9c4.478 0 8.268 2.943 9.542 7-.394.997-.899 1.926-1.507 2.76M10.5 5.275A10.05 10.05 0 0112 5c1.661 0 3.203.44 4.5 1.175" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                        <x-button class="ms-4">
                            {{ __('Entrar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="absolute bottom-0 w-full text-center  py-3 text-gray-600">
        Diseñado y Desarrollado por Cotecmar ILS | Todos los derechos reservados
    </footer>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const loginContainer = document.querySelector('.login-container');
                setTimeout(function () {
                    loginContainer.style.opacity = '1';
                }, 100);

                particlesJS('particles-js', {
                    particles: {
                        number: {
                            value: 80,
                            density: {
                                enable: true,
                                value_area: 800
                            }
                        },
                        color: {
                            value: '#a1a1a1'
                        },
                        shape: {
                            type: 'circle',
                            stroke: {
                                width: 0,
                                color: '#ffffff'
                            },
                            polygon: {
                                nb_sides: 5
                            },
                            image: {
                                src: 'img/github.svg',
                                width: 100,
                                height: 100
                            }
                        },
                        opacity: {
                            value: 0.5,
                            random: false,
                            anim: {
                                enable: false,
                                speed: 1,
                                opacity_min: 0.1,
                                sync: false
                            }
                        },
                        size: {
                            value: 3,
                            random: true,
                            anim: {
                                enable: false,
                                speed: 40,
                                size_min: 0.1,
                                sync: false
                            }
                        },
                        line_linked: {
                            enable: true,
                            distance: 150,
                            color: '#a1a1a1',
                            opacity: 0.4,
                            width: 1
                        },
                        move: {
                            enable: true,
                            speed: 3,
                            direction: 'none',
                            random: false,
                            straight: false,
                            out_mode: 'out',
                            bounce: false,
                            attract: {
                                enable: false,
                                rotateX: 600,
                                rotateY: 1200
                            }
                        }
                    },
                    interactivity: {
                        detect_on: 'canvas',
                        events: {
                            onhover: {
                                enable: true,
                                mode: 'repulse'
                            },
                            onclick: {
                                enable: true,
                                mode: 'push'
                            },
                            resize: true
                        },
                        modes: {
                            grab: {
                                distance: 400,
                                line_linked: {
                                    opacity: 1
                                }
                            },
                            bubble: {
                                distance: 400,
                                size: 40,
                                duration: 2,
                                opacity: 8,
                                speed: 3
                            },
                            repulse: {
                                distance: 200,
                                duration: 0.4
                            },
                            push: {
                                particles_nb: 4
                            },
                            remove: {
                                particles_nb: 2
                            }
                        }
                    },
                    retina_detect: true
                });
            });
        </script>
    @endpush
</x-guest-layout>
