@extends('layouts.app')

@section('title', 'Crear Nuevo Artículo')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Crear Nuevo Artículo</h1>
                    <p class="text-gray-600 mt-2">Agrega un nuevo artículo a la base de conocimientos</p>
                </div>
                <a href="{{ route('knowledgebase.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg">
                <!-- CORRECCIÓN PRINCIPAL: Cambiar action y method -->
                <form action="{{ route('knowledgebase.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- Token CSRF necesario -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" id="title" name="title"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required placeholder="Ingresa el título del artículo" value="{{ old('title') }}">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría
                                *</label>
                            <select id="category_id" name="category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Autor *</label>
                            <input type="text" id="author" name="author"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required placeholder="Nombre del autor" value="{{ old('author') }}">
                            <p class="text-gray-500 text-xs mt-2">Ingresa el nombre completo del autor</p>
                            @error('author')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Archivo PDF (Opcional)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="pdf_path"
                                    class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-file-pdf text-4xl text-red-500 mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click para
                                                subir</span> o arrastra un archivo</p>
                                        <p class="text-xs text-gray-500">PDF (MAX. 5MB)</p>
                                    </div>
                                    <input id="pdf_path" name="pdf_path" type="file" class="hidden" accept=".pdf" />
                                </label>
                            </div>
                            @error('pdf_path')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenido *</label>
                        <textarea id="content" name="content" rows="12"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required placeholder="Escribe el contenido del artículo aquí...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('knowledgebase.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Crear Artículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mostrar el nombre del archivo seleccionado
        document.getElementById('pdf_path').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = document.querySelector('label[for="pdf_path"]');

            if (fileName) {
                label.querySelector('p:first-child').innerHTML = `<span class="font-semibold">${fileName}</span>`;
                label.querySelector('p:last-child').textContent = "Haz clic para cambiar el archivo";
            }
        });
    </script>
@endsection
