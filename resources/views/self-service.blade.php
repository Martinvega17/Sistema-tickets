@extends('layouts.app')

@section('content')
    <div class="mb-8">

        <p class="text-gray-600 mt-2">Autogestiona todas las solicitudes y consulta la librería de soluciones</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna principal (2/3) -->
        <div class="lg:col-span-2">
            <!-- Más solicitudes -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-pepsi-blue mb-4">Más solicitudes</h2>
                <p class="text-gray-600 mb-4">Aquí encontrarás todos los solicitudes, respuestas y actividades.</p>

                <!-- Lista de tickets recientes (puedes reemplazar con datos reales) -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium">Problema con acceso al sistema</h4>
                            <p class="text-sm text-gray-500">Creado hace 2 horas</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">En proceso</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium">Solicitud de software nuevo</h4>
                            <p class="text-sm text-gray-500">Creado hace 1 día</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Pendiente</span>
                    </div>
                </div>
            </div>

            <!-- Artículos destacados -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-pepsi-blue mb-4">Artículos destacados</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($articulosDestacados as $articulo)
                        <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-pepsi-blue">{{ $articulo['titulo'] }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $articulo['categoria'] }}</p>
                            <button class="mt-3 text-pepsi-blue hover:text-pepsi-red text-sm font-medium">
                                Leer más →
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Columna lateral (1/3) -->
        <div class="space-y-6">
            <!-- Crear Nueva Solicitud -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-pepsi-blue rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pepsi-blue">Crear Nueva Solicitud</h3>
                </div>
                <p class="text-gray-600 mb-4">Envía una solicitud a tu equipo de soporte.</p>
                <button
                    class="w-full bg-pepsi-blue text-white py-2 px-4 rounded-lg hover:bg-pepsi-dark-blue transition-colors">
                    Crear solicitud
                </button>
            </div>

            <!-- Librería de Soluciones -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-pepsi-red rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pepsi-red">Librería de Soluciones</h3>
                </div>
                <p class="text-gray-600 mb-4">Encuentra las respuestas a tus posibles preguntas.</p>

                <!-- Buscador -->
                <div class="mb-4">
                    <div class="relative">
                        <input type="text" placeholder="Entra aquí para buscar"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <svg class="w-5 h-5 absolute right-3 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <button class="w-full bg-pepsi-red text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                    Explorar soluciones
                </button>
            </div>

            <!-- Marker Place -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-pepsi-light-blue rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14v6m-3-3h6M6 10h2a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2zm10-4a2 2 0 11-4 0 2 2 0 014 0zM6 20h12">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pepsi-light-blue">Market Place</h3>
                </div>
                <p class="text-gray-600 mb-4">Solicita aquí fácilmente los elementos que necesitan de tus áreas.</p>
                <button
                    class="w-full bg-pepsi-light-blue text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Acceder al Market Place
                </button>
            </div>

            <!-- Información del usuario -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pepsi-red rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}{{ strtoupper(substr(Auth::user()->apellido, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-pepsi-blue">{{ Auth::user()->nombre }}</h3>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="text-center">
                    <button class="text-pepsi-blue hover:text-pepsi-red text-sm font-medium">
                        Ver mi perfil →
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
