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
    </script>
    <style>
        .admin-gradient {
            background: linear-gradient(135deg, #004B93 0%, #003366 100%);
        }
    </style>
    @yield('styles')
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar Admin -->
    <div class="flex flex-col w-64 admin-gradient text-white">
        <div class="flex items-center justify-center h-20 border-b border-blue-700 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-pepsi-red rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">P</span>
                </div>
                <h1 class="text-xl font-bold">Admin Pepsi</h1>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
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

            <a href="" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Categorías
            </a>

            <a href="" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Naturalezas
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
            <div class="mt-3">
                <a href="{{ route('dashboard') }}" class="text-xs text-blue-300 hover:text-white flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Volver al Dashboard Principal
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between h-20 bg-white shadow-sm px-6">
            <div>
                <h2 class="text-2xl font-bold text-pepsi-blue">Panel de Administración</h2>
                <p class="text-sm text-gray-600">Gestión completa del sistema de tickets</p>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>

            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content.dashboard')
        </main>
    </div>
</body>

</html>
