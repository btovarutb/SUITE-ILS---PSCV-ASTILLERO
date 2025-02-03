<!-- Menú de navegación -->
<nav x-data="{ open: false, adminOpen: false }" class="bg-white border-b border-gray-100 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Sección izquierda del navbar -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('storage/images/CotecmarLogo.png') }}" alt="Cotecmar Logo" class="block h-12 w-auto">
                    </a>
                </div>

                <!-- Items del menú principal -->
                <div class="hidden space-x-12 sm:-my-px sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="transition duration-300 ease-in-out hover:text-gray-700 cursor-pointer text-lg">
                        {{ __('Panel de Control') }}
                    </x-nav-link>

                    <!-- Dropdown del Panel de Administración -->
                    <div @mouseenter="adminOpen = true" @mouseleave="adminOpen = false" class="relative">
                        <x-nav-link class="transition duration-300 ease-in-out hover:text-gray-700 cursor-pointer text-lg">
                            {{ __('Panel de Administración') }}
                        </x-nav-link>

                        <!-- Ajustes del dropdown con AlpineJS -->
                        <div
                            x-show="adminOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md py-3 text-lg z-50">
                            <x-dropdown-link href="{{ route('buques.index') }}">
                                {{ __('Buques') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('users.index') }}">
                                {{ __('Gestión de Usuarios') }}
                            </x-dropdown-link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección derecha del navbar (usuario y configuración) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Perfil de usuario -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-4 py-3 border border-transparent text-lg leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Panel de Control') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link class="transition duration-300 ease-in-out hover:text-gray-700 text-lg">
                {{ __('Administración') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
