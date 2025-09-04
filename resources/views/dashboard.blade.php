@extends('layouts.app')

@section('content')
    <div class="p-4 bg-yellow-200">
        <strong>Debug Usuario:</strong>
        {{ Auth::user() ? Auth::user()->name . ' - Rol: ' . Auth::user()->role_id : 'No hay usuario logueado' }}
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Hola, <span class="text-pepsi-blue">{{ Auth::user()->nombre }}</span>!
            @if (Auth::user()->rol_id == 1)
                <span class="text-sm bg-pepsi-red text-white px-2 py-1 rounded-full ml-2">Administrador</span>
            @elseif(Auth::user()->rol_id == 2)
                <span class="text-sm bg-pepsi-blue text-white px-2 py-1 rounded-full ml-2">Supervisor</span>
            @elseif(Auth::user()->rol_id == 3)
                <span class="text-sm bg-green-600 text-white px-2 py-1 rounded-full ml-2">Coordinador</span>
            @elseif(Auth::user()->rol_id == 4)
                <span class="text-sm bg-purple-600 text-white px-2 py-1 rounded-full ml-2">Soporte</span>
            @elseif(Auth::user()->rol_id == 5)
                <span class="text-sm bg-indigo-600 text-white px-2 py-1 rounded-full ml-2">Usuario</span>
            @endif
        </h1>
        <p class="text-gray-600 mt-2">Bienvenido al sistema de tickets de Pepsi</p>
    </div>

    <!-- Tarjetas comunes para todos los usuarios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Tarjeta de Conocimiento -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-start mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Conocimiento</h3>
                    <p class="text-gray-600 text-sm mt-1">Documenta artículos disponibles para autogestión de usuarios</p>
                </div>
            </div>
            <a href="/conocimiento" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mt-2">
                <span>Explorar base de conocimiento</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Tarjeta de Helpdesk -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-start mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Helpdesk</h3>
                    <p class="text-gray-600 text-sm mt-1">Gestiona tickets de soporte y da seguimiento a solicitudes</p>
                </div>
            </div>
            <a href="#" class="inline-flex items-center text-sm text-green-600 hover:text-green-800 mt-2">
                <span>Ver tickets</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Tarjeta de Self Service -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-start mb-4">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Self Service</h3>
                    <p class="text-gray-600 text-sm mt-1">Autogestiona soluciones y consulta base de conocimiento</p>
                </div>
            </div>
            <a href="/self-service" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-800 mt-2">
                <span>Acceder al self service</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Sección de Gestión (Admin, Supervisor y Coordinador) -->
    @if (in_array(Auth::user()->rol_id, [1, 2, 3]))
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-pepsi-blue mb-6">Gestión del Sistema</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Gestión de Usuarios -->
                <a href="{{ route('usuarios.index') }}"
                    class="card-hover bg-white rounded-xl shadow-md p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pepsi-blue rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Gestión de Usuarios</h3>
                            <p class="text-gray-600 text-sm">Administra usuarios del sistema</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-xs text-pepsi-blue">
                            <i class="bi bi-arrow-right mr-1"></i> Gestionar acceso
                        </span>
                    </div>
                </a>

                <!-- Otras tarjetas de gestión si las hay -->
            </div>
        </div>
    @endif

    <!-- Sección de CEDIS (solo para Admin y Supervisor) -->
    @if (in_array(Auth::user()->rol_id, [1, 2]))
        <div class="mt-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-pepsi-blue">Gestión de CEDIS</h2>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cedis.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition duration-150 ease-in-out">
                        <i class="bi bi-plus-circle mr-2"></i> Nuevo CEDIS
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Gestión de CEDIS -->
                <a href="{{ route('cedis.index') }}"
                    class="card-hover bg-white rounded-xl shadow-md p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-pepsi-blue to-pepsi-dark-blue rounded-lg flex items-center justify-center mr-4 bg-pepsi-blue">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Gestión de CEDIS</h3>
                            <p class="text-gray-600 text-sm">Administra los centros de distribución</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-xs text-pepsi-blue">
                            <i class="bi bi-arrow-right mr-1"></i> Ver todos los CEDIS
                        </span>
                    </div>
                </a>
            </div>
        </div>
    @endif

    <!-- Sección para Soporte (Rol 4) -->
@endsection

@section('styles')
    <style>
        .card-hover {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #004B93;
        }
    </style>
@endsection
