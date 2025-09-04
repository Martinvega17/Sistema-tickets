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
                <h1 class="text-2xl font-bold text-gray-800">Base de Conocimiento</h1>
                <p class="text-gray-600">Detalle del artículo</p>
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

        <!-- Breadcrumb -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <nav class="flex" aria-label="Breadcrumb">
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
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $article->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <!-- Article Header -->
            <div class="border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="px-3 py-1 {{ $article->category->color }} text-xs font-medium rounded-full">
                            {{ $article->category->name }}
                        </span>
                        <h2 class="text-xl font-semibold text-gray-800 mt-2">{{ $article->title }}</h2>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-4">
                            <i class="far fa-eye mr-1"></i> {{ $article->views }}
                            <i class="far fa-thumbs-up ml-3 mr-1"></i> {{ $article->rating }}%
                        </span>
                        @can('edit-article')
                            <div class="dropdown relative">
                                <button class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div
                                    class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                    <a href="{{ route('knowledgebase.edit', $article->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-edit mr-2"></i> Editar
                                    </a>
                                    <form action="{{ route('knowledgebase.destroy', $article->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                            onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                            <i class="fas fa-trash mr-2"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <span>Actualizado: {{ $article->updated_at->format('d/m/Y') }}</span>
                    <span class="mx-2">•</span>
                    <span>Por: {{ $article->author->name }}</span>
                </div>
            </div>

            <!-- Article Body -->
            <div class="px-6 py-4">
                <div class="prose max-w-none mb-6">
                    {!! $article->content !!}
                </div>

                <!-- Attachments -->
                @if ($article->attachments->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Documentos adjuntos</h3>
                        <div class="space-y-3">
                            @foreach ($article->attachments as $attachment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="far fa-file-pdf text-red-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $attachment->original_name }}</p>
                                            <p class="text-xs text-gray-500">{{ round($attachment->size / 1024, 1) }}
                                                KB</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($attachment->path) }}" target="_blank"
                                        class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-md hover:bg-blue-200">
                                        <i class="fas fa-download mr-1"></i> Descargar
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- PDF Viewer Modal (will be triggered by button) -->
                <div class="mt-6">
                    <button onclick="openPdfViewer('{{ Storage::url($article->attachments->first()->path) }}')"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                        <i class="far fa-file-pdf mr-2"></i> Ver documento PDF
                    </button>
                </div>
            </div>

            <!-- Article Footer -->
            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">¿Te resultó útil este artículo?</span>
                        <button class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-sm hover:bg-green-200">
                            <i class="far fa-thumbs-up mr-1"></i> Sí
                        </button>
                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200">
                            <i class="far fa-thumbs-down mr-1"></i> No
                        </button>
                    </div>
                    <div class="text-sm text-gray-500">
                        <a href="{{ route('knowledgebase.index') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Artículos relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($relatedArticles as $related)
                    <div class="bg-white rounded-lg shadow overflow-hidden transition duration-300 hover:shadow-md">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="px-3 py-1 {{ $related->category->color }} text-xs font-medium rounded-full">
                                    {{ $related->category->name }}
                                </span>
                                <i class="far fa-bookmark text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $related->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($related->summary, 100) }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-eye mr-1"></i> {{ $related->views }}
                                <i class="far fa-thumbs-up ml-3 mr-1"></i> {{ $related->rating }}%
                                <a href="{{ route('knowledgebase.show', $related->id) }}"
                                    class="ml-auto text-blue-600 hover:text-blue-800">Leer más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- PDF Viewer Modal -->
<div id="pdfViewerModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-11/12 h-5/6 max-w-6xl">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Visualizador de PDF</h3>
            <button onclick="closePdfViewer()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 h-full">
            <iframe id="pdfFrame" class="w-full h-full" frameborder="0"></iframe>
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

    /* Category colors */
    .bg-blue-100 {
        background-color: #dbeafe;
    }

    .text-blue-800 {
        color: #1e40af;
    }

    .bg-red-100 {
        background-color: #fee2e2;
    }

    .text-red-800 {
        color: #991b1b;
    }

    .bg-green-100 {
        background-color: #dcfce7;
    }

    .text-green-800 {
        color: #166534;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>

<script>
    function openPdfViewer(pdfUrl) {
        document.getElementById('pdfFrame').src = pdfUrl;
        document.getElementById('pdfViewerModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePdfViewer() {
        document.getElementById('pdfViewerModal').classList.add('hidden');
        document.getElementById('pdfFrame').src = '';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside content
    document.getElementById('pdfViewerModal').addEventListener('click', function(e) {
        if (e.target.id === 'pdfViewerModal') {
            closePdfViewer();
        }
    });

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePdfViewer();
        }
    });
</script>
@endsection
