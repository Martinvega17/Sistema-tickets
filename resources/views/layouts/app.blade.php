<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sistema de Tickets Pepsi</title>
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
    </script>
    <style>
        .pepsi-gradient {
            background: linear-gradient(135deg, #004B93 0%, #0070C0 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Nuevos estilos para self-service */
        .solution-card {
            transition: all 0.2s ease;
        }

        .solution-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 75, 147, 0.15);
        }
    </style>
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="flex flex-col w-64 pepsi-gradient text-white">
        <div class="flex items-center justify-center h-20 border-b border-blue-700 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-pepsi-red rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">P</span>
                </div>
                <h1 class="text-xl font-bold">Pepsi Tickets</h1>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg bg-blue-700/30 hover:bg-blue-700/50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Inicio
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                Tickets
            </a>
            <a href="/cedis" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                CEDIS
            </a>
            <a href="/usuarios" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Usuarios
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Reportes
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
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between h-20 bg-white shadow-sm px-6">
            <div>
                <h2 class="text-2xl font-bold text-pepsi-blue">Dashboard</h2>
                <p class="text-sm text-gray-600">Bienvenido al sistema de tickets de Pepsi</p>
            </div>

            <div class="relative" id="user-menu-container">
                <button id="user-menu-button"
                    class="flex items-center space-x-2 text-pepsi-blue focus:outline-none px-3 py-2 rounded-md hover:bg-gray-100 transition-colors">
                    <span class="font-medium">{{ Auth::user()->nombre }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="user-menu-dropdown"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-10 border border-gray-200">
                    <a href="{{ route('configuracion') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-pepsi-blue transition-colors">
                        Configuración
                    </a>
                    <a href="{{ route('logout') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-pepsi-red transition-colors"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const userMenuContainer = document.getElementById('user-menu-container');

            // Alternar menú al hacer clic en el botón
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!userMenuContainer.contains(e.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
            });

            // Cerrar menú al presionar la tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    userMenuDropdown.classList.add('hidden');
                }
            });

            // Prevenir que el clic en el menú lo cierre
            userMenuDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>
