@extends('layouts.app')

@section('content')
@section('title')
    {{ $article->title }} - Base de Conocimientos
@endsection

<div class="flex">
    <!-- Main Content -->
    <div class="w-full p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('knowledgebase.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i>
                                Base de Conocimiento
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span
                                    class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $article->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-800">{{ $article->title }}</h1>
                <p class="text-gray-600">Actualizado: {{ $article->updated_at->format('d/m/Y') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                @can('update', $article)
                    <a href="{{ route('knowledgebase.edit', $article->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-edit mr-2"></i> Editar
                    </a>
                @endcan

                @can('delete', $article)
                    <form action="{{ route('knowledgebase.destroy', $article->id) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar este artículo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                            <i class="fas fa-trash mr-2"></i> Eliminar
                        </button>
                    </form>
                @endcan

                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Martín&background=0066CC&color=fff" alt="Usuario"
                        class="w-10 h-10 rounded-full">
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 {{ $article->category->color_class }} text-xs font-medium rounded-full">
                        {{ $article->category->name }}
                    </span>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="far fa-eye mr-1"></i> {{ $article->views }}
                        <div class="flex items-center ml-3">
                            <i class="far fa-thumbs-up mr-1"></i>
                            <span>{{ $article->rating }}%</span>
                        </div>
                    </div>
                </div>

                @if ($article->pdf_path)
                    <a href="{{ route('knowledgebase.download.pdf', $article->id) }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i> Descargar PDF
                    </a>
                @endif
            </div>

            <div class="prose max-w-none mb-6">
                {!! $article->content !!}
            </div>

            <!-- Sección de archivo PDF (si existe) -->
            @if ($article->pdf_path)
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Documentación Adjunta</h3>
                    <div class="bg-gray-50 p-4 rounded-lg flex items-center">
                        <div class="mr-4 text-red-600 text-3xl">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="flex-grow">
                            <p class="font-medium">Manual: {{ $article->title }}</p>
                            <p class="text-sm text-gray-600">PDF -
                                {{ round(Storage::size($article->pdf_path) / 1024) }} KB</p>
                        </div>
                        <a href="{{ route('knowledgebase.download.pdf', $article->id) }}"
                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                            <i class="fas fa-download mr-1"></i> Descargar
                        </a>
                    </div>
                </div>
            @endif

            <!-- Valoración del artículo -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">¿Te resultó útil este artículo?</h3>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 feedback-btn"
                        data-article-id="{{ $article->id }}" data-helpful="1">
                        <i class="far fa-thumbs-up mr-2"></i> Sí
                    </button>
                    <button class="px-4 py-2 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 feedback-btn"
                        data-article-id="{{ $article->id }}" data-helpful="0">
                        <i class="far fa-thumbs-down mr-2"></i> No
                    </button>
                </div>
            </div>
        </div>

        <!-- Artículos relacionados -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Artículos Relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($relatedArticles as $related)
                    <div class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="px-3 py-1 {{ $related->category->color_class }} text-xs font-medium rounded-full">
                                    {{ $related->category->name }}
                                </span>
                                <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">
                                <a href="{{ route('knowledgebase.article', $related->id) }}"
                                    class="hover:text-blue-600">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($related->summary, 100) }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-eye mr-1"></i> {{ $related->views }}
                                <i class="far fa-thumbs-up ml-3 mr-1"></i> {{ $related->rating }}%
                            </div>
                        </div>
                    </div>
                @endforeach
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

    .bg-green-100 {
        background-color: #dcfce7;
    }

    .text-green-800 {
        color: #166534;
    }

    .bg-red-100 {
        background-color: #fee2e2;
    }

    .text-red-800 {
        color: #991b1b;
    }

    .bg-blue-100 {
        background-color: #dbeafe;
    }

    .text-blue-800 {
        color: #1e40af;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar la valoración del artículo
        document.querySelectorAll('.feedback-btn').forEach(button => {
            button.addEventListener('click', function() {
                const articleId = this.dataset.articleId;
                const helpful = this.dataset.helpful;

                fetch('/knowledgebase/article/' + articleId + '/feedback', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            helpful: helpful
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('¡Gracias por tu feedback!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>
@endsection
