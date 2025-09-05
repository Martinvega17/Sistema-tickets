@extends('layouts.app')

@section('title', 'Base de Conocimientos')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-pepsi-blue">Base de Conocimientos</h1>
        <p class="text-gray-600">Encuentra soluciones a problemas comunes</p>
    </div>

    <!-- Botón Crear Artículo -->
    @if (in_array(Auth::user()->rol_id, [1, 2, 3]))
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Artículos de Conocimiento</h2>
            <a href="{{ route('knowledgebase.create') }}"
                class="bg-pepsi-blue hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-plus-circle mr-2"></i> Crear Nuevo Artículo
            </a>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center space-x-4">
            <span class="font-medium text-gray-700">Filtrar por:</span>
            <button
                class="px-4 py-1 bg-pepsi-blue text-white rounded-full hover:bg-blue-700 transition-colors">Todos</button>
            @if (isset($categories) && $categories->count() > 0)
                @foreach ($categories as $category)
                    <button
                        class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors category-filter"
                        data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            @else
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full">General</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full">Soporte Técnico</button>
                <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-full">Software</button>
            @endif
        </div>
    </div>

    <!-- Artículos destacados - SOLUCIÓN PRINCIPAL -->
    @if (isset($featuredArticles) && $featuredArticles->count() > 0)
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Artículos Destacados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($featuredArticles as $article)
                    <div
                        class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md border-l-4 border-pepsi-blue">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                    {{ $article->category->name ?? 'General' }}
                                </span>
                                <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-pepsi-blue">{{ $article->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                @if (!empty($article->content))
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                @else
                                    Este artículo no tiene contenido aún.
                                @endif
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-eye mr-1"></i> {{ $article->views ?? 0 }}
                                <i class="far fa-thumbs-up ml-3 mr-1"></i>
                                @if ($article->rating > 0)
                                    {{ round(($article->rating / 5) * 100) }}%
                                @else
                                    N/A
                                @endif
                                <span class="ml-auto">{{ $article->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Mensaje alternativo si no hay artículos destacados -->
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-yellow-400 mt-1"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>No hay artículos destacados.</strong> Crea algunos artículos con contenido para que
                        aparezcan aquí.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Todos los artículos -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Todos los Artículos</h2>
            <span class="text-sm text-gray-500">{{ isset($articles) ? $articles->count() : 0 }} artículos encontrados</span>
        </div>

        @if (isset($articles) && $articles->count() > 0)
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
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $article->category->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->views ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="ml-1 text-sm text-gray-700">
                                            @if ($article->rating > 0)
                                                {{ number_format($article->rating, 1) }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('knowledgebase.article', $article->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                    @if (in_array(Auth::user()->rol_id, [1, 2, 3]))
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
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">No hay artículos disponibles</h3>
                <p class="text-gray-500 mb-4">Aún no se han creado artículos en la base de conocimientos.</p>
                @if (in_array(Auth::user()->rol_id, [1, 2, 3]))
                    <a href="{{ route('knowledgebase.create') }}"
                        class="bg-pepsi-blue hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg inline-flex items-center transition-colors">
                        <i class="fas fa-plus-circle mr-2"></i> Crear Primer Artículo
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .transition-colors {
            transition: background-color 0.2s ease;
        }
    </style>
@endsection
