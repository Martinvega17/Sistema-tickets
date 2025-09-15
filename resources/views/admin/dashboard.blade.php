@extends('layouts.admin')

@section('title', 'Dashboard Administrativo')

@section('content.dashboard')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Panel de Administración
        </h1>
        <p class="text-gray-600 mt-2">Resumen general del sistema de tickets de Pepsi</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tickets -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-pepsi-blue">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_tickets'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tickets Abiertos -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tickets Abiertos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['tickets_abiertos'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tickets en Progreso -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En Progreso</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['tickets_en_progreso'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tickets Resueltos -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tickets Resueltos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['tickets_resueltos'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Tickets Recientes -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tickets Recientes</h3>
            <div class="space-y-4">
                @foreach ($ticketsRecientes as $ticket)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">#{{ $ticket->id }} - {{ $ticket->titulo }}</p>
                            <p class="text-sm text-gray-600">{{ $ticket->usuario->nombre }} - {{ $ticket->cedis->nombre }}
                            </p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if ($ticket->estatus == 'Abierto') bg-yellow-100 text-yellow-800
                    @elseif($ticket->estatus == 'En progreso') bg-blue-100 text-blue-800
                    @elseif($ticket->estatus == 'Resuelto') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                            {{ $ticket->estatus }}
                        </span>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('tickets.index') }}" class="block text-center mt-4 text-pepsi-blue hover:text-blue-700">
                Ver todos los tickets →
            </a>
        </div>

        <!-- Resumen del Sistema -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Resumen del Sistema</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-pepsi-blue">{{ $stats['total_usuarios'] }}</p>
                    <p class="text-sm text-gray-600">Usuarios</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['total_cedis'] }}</p>
                    <p class="text-sm text-gray-600">CEDIS Activos</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['total_areas'] }}</p>
                    <p class="text-sm text-gray-600">Áreas</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['total_categorias'] }}</p>
                    <p class="text-sm text-gray-600">Categorías</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Gestión de Catálogos</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.areas.index') }}"
                class="p-4 bg-blue-50 rounded-lg text-center hover:bg-blue-100 transition-colors">
                <svg class="w-8 h-8 text-pepsi-blue mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-4 0H9m4 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10m4 0h4">
                    </path>
                </svg>
                <span class="text-sm font-medium">Áreas</span>
            </a>

            <a href="{{ route('admin.servicios.index') }}"
                class="p-4 bg-green-50 rounded-lg text-center hover:bg-green-100 transition-colors">
                <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
                <span class="text-sm font-medium">Servicios</span>
            </a>

            <a href="{{ route('admin.naturaleza.index') }}"
                class="p-4 bg-purple-50 rounded-lg text-center hover:bg-purple-100 transition-colors">
                <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z">
                    </path>
                </svg>
                <span class="text-sm font-medium">Naturaleza</span>
            </a>

            <a href="{{ route('admin.categorias.index') }}"
                class="p-4 bg-orange-50 rounded-lg text-center hover:bg-orange-100 transition-colors">
                <svg class="w-8 h-8 text-orange-600 mx-auto mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                <span class="text-sm font-medium">Categorías</span>
            </a>
        </div>
    </div>
@endsection
