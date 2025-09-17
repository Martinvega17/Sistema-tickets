<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Sistema de Tickets Pepsi')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'pepsi-blue': '#004B93',
                            'pepsi-red': '#D50032',
                            'pepsi-white': '#FFFFFF',
                            'pepsi-light-blue': '#0070C0',
                            'pepsi-dark-blue': '#003366',
                        }
                    }
                }
            }
            .countdown - animation {
                animation: pulse 2 s infinite;
            }

        @keyframes pulse {
            0 % {
                opacity: 1;
            }
            50 % {
                opacity: 0.5;
            }
            100 % {
                opacity: 1;
            }
        }

        .progress - bar {
            transition: width 1 s linear;
        }
    </script>
    <style>
        .admin-gradient {
            background: linear-gradient(135deg, #004B93 0%, #003366 100%);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-radius: 0.5rem;
            overflow: hidden;
            right: 0;
        }

        /* ELIMINAMOS COMPLETAMENTE EL HOVER */
    </style>
    @yield('styles')
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar Admin -->
    <div class="flex flex-col w-64 admin-gradient text-white">
        <div class="flex items-center justify-center h-20 border-b border-blue-700 p-4">
            <div class="flex items-center space-x-3">
                <!-- Logo personalizable -->
                <div class="w-18 h-18 rounded-full flex items-center justify-center overflow-hidden">
                    <!-- Reemplaza la ruta con la de tu logo -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Pepsi" class="w-full h-full object-contain p-1">
                    <!-- Fallback si la imagen no carga -->
                    <span class="text-pepsi-blue font-bold text-lg hidden">P</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <!-- ... (el resto del menú lateral se mantiene igual) ... -->
            <a href="/admin/dashboard"
                class="flex items-center px-4 py-3 rounded-lg bg-blue-700/30 hover:bg-blue-700/50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>

            <!-- Menú Administrativo -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-blue-200 uppercase tracking-wider">Administración</p>
            </div>

            <a href="{{ route('admin.areas.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Áreas
            </a>

            <a href="{{ route('admin.categorias.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Categorías
            </a>

            <a href="{{ route('admin.naturaleza.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Naturaleza
            </a>

            <a href="" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Actividades
            </a>

            <a href="{{ route('admin.servicios.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Servicios
            </a>

            <!-- Separador -->
            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-blue-200 uppercase tracking-wider">Sistema</p>
            </div>

            <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Usuarios
            </a>

            <a href="{{ route('cedis.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                CEDIS
            </a>

            <a href="{{ route('admin.regiones.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Regiones
            </a>

            <a href="{{ route('tickets.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                Tickets
            </a>
        </nav>

        <div class="p-4 border-t border-blue-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-pepsi-red rounded-full flex items-center justify-center">
                    <span
                        class="text-white font-bold">{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}{{ strtoupper(substr(Auth::user()->apellido, 0, 1)) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ Auth::user()->nombre }}</p>
                    <p class="text-xs text-blue-200">{{ Auth::user()->email }}</p>
                    <p class="text-xs text-blue-300">Administrador</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between h-20 bg-white shadow-sm px-6">
            <!-- Título a la izquierda -->
            <div>
                <h2 class="text-2xl font-bold text-pepsi-blue">Panel de Administración</h2>
                <p class="text-sm text-gray-600">Gestión completa del sistema de tickets</p>
            </div>

            <!-- Menú de usuario en la parte superior derecha -->
            <div class="flex items-center space-x-4">


                <div class="relative">
                    <button class="flex items-center space-x-3 focus:outline-none" onclick="toggleUserMenu()">
                        <div class="w-10 h-10 bg-pepsi-blue rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}{{ strtoupper(substr(Auth::user()->apellido, 0, 1)) }}
                            </span>
                        </div>
                        <div class="text-left hidden md:block">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div id="userDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Configuración
                            </div>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Cerrar sesión
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content.dashboard')
        </main>
    </div>

    <script>
        // Función para mostrar/ocultar el menú de usuario
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Cerrar el menú al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.querySelector('[onclick="toggleUserMenu()"]');

            if (!dropdown.contains(event.target) && event.target !== button && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Prevenir que el menú se cierre al hacer clic dentro de él
        document.getElementById('userDropdown').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>

    <!-- Modal de Sesión Expirada -->
    <div id="sessionExpiredModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-96">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 text-center mt-4">Sesión Expirada</h3>
            <p class="text-gray-600 text-center mt-2">Su sesión ha expirado por inactividad. Será redirigido para
                iniciar sesión nuevamente.</p>
            <div class="mt-6 flex justify-center">
                <a href="{{ route('login') }}"
                    class="bg-pepsi-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Ir a Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
</body>
@yield('scripts')

<script src="{{ asset('js/session-timeout.js') }}"></script>
<script src="{{ asset('js/user-menu.js') }}"></script>

</html>
