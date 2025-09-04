@extends('layouts.app')

@section('content')

@section('title')
    Base de Conocimientos
@endsection

<div class="flex">
    <!-- Main Content -->
    <div class="w-full p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Base de Conocimiento</h1>
                <p class="text-gray-600">Encuentra soluciones a problemas comunes</p>
            </div>
            <div class="flex items-center">
                <div class="relative mr-4">
                    <input type="text" placeholder="Buscar en conocimiento..."
                        class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Martín&background=0066CC&color=fff" alt="Usuario"
                        class="w-10 h-10 rounded-full">
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex items-center space-x-4">
                <span class="font-medium">Filtrar por:</span>
                <button class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200">Todos</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">Soporte
                    Técnico</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">Software</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">Hardware</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">Redes</button>
            </div>
        </div>

        <!-- Artículos destacados -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Artículos Destacados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Software</span>
                            <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Cómo resetear la contraseña de Windows</h3>
                        <p class="text-gray-600 text-sm mb-4">Guía paso a paso para recuperar acceso a equipos con
                            Windows cuando se ha olvidado la contraseña.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-eye mr-1"></i> 245
                            <i class="far fa-thumbs-up ml-3 mr-1"></i> 89%
                            <span class="ml-auto">Actualizado: 12/05/2023</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Urgente</span>
                            <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Solución a error de conexión de red</h3>
                        <p class="text-gray-600 text-sm mb-4">Procedimiento para resolver problemas comunes de
                            conectividad en la red corporativa.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-eye mr-1"></i> 189
                            <i class="far fa-thumbs-up ml-3 mr-1"></i> 94%
                            <span class="ml-auto">Actualizado: 05/06/2023</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Hardware</span>
                            <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Configuración de impresoras HP</h3>
                        <p class="text-gray-600 text-sm mb-4">Instalación y configuración de impresoras de la serie HP
                            LaserJet en la red de Pepsi.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-eye mr-1"></i> 312
                            <i class="far fa-thumbs-up ml-3 mr-1"></i> 91%
                            <span class="ml-auto">Actualizado: 18/04/2023</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Todos los artículos -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Todos los Artículos</h2>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Visitas</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rating</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($articles as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $article->category->color_class }}">
                                        {{ $article->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->views }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="ml-1 text-sm text-gray-700">{{ $article->rating }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('knowledgebase.article', $article->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>

                                    @if (in_array(Auth::user()->role_id, [1, 2, 3]))
                                        <a href="{{ route('knowledgebase.edit', $article->id) }}"
                                            class="text-green-600 hover:text-green-900 mr-3">Editar</a>
                                        <form action="{{ route('knowledgebase.destroy', $article->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple-100 {
        background-color: #f3e8ff;
    }

    .text-purple-800 {
        color: #6b21a8;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página de conocimiento cargada');
    });
</script>
@endsection
