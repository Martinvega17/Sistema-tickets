@extends('layouts.app')

@section('title', 'Crear Nuevo Artículo')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Base de Conocimientos</h1>
                <p class="text-indigo-100">Sistema de gestión de artículos</p>
            </div>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="#" class="hover:text-indigo-200 transition"><i class="fas fa-home mr-1"></i> Inicio</a>
                    </li>
                    <li><a href="#" class="hover:text-indigo-200 transition"><i class="fas fa-book mr-1"></i>
                            Artículos</a></li>
                    <li><a href="#" class="hover:text-indigo-200 transition"><i class="fas fa-user mr-1"></i> Mi
                            Cuenta</a></li>
                </ul>
            </nav>
        </div>
    </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header del formulario -->
                <div class="bg-indigo-600 text-white px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">Crear Nuevo Artículo</h2>
                            <p class="text-indigo-100">Agrega un nuevo artículo a la base de conocimientos</p>
                        </div>
                        <a href="#"
                            class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg transition flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="px-8 py-6">
                    <form action="{{ route('knowledgebase.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                                <input type="text" id="title" name="title"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required placeholder="Ingresa el título del artículo">
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría
                                    *</label>
                                <select id="category_id" name="category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Autor *</label>
                                <input type="text" id="author" name="author"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required placeholder="Nombre del autor">
                                <p class="text-gray-500 text-xs mt-2">Ingresa el nombre completo del autor</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Archivo PDF (Opcional)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="pdf_path"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-file-pdf text-3xl text-red-500 mb-3"></i>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click para
                                                    subir</span> o arrastra un archivo</p>
                                            <p class="text-xs text-gray-500">PDF (MAX. 5MB)</p>
                                        </div>
                                        <input id="pdf_path" name="pdf_path" type="file" class="hidden"
                                            accept=".pdf" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenido *</label>
                            <textarea id="content" name="content" rows="12"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required placeholder="Escribe el contenido del artículo aquí..."></textarea>
                        </div>

                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="#"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i> Cancelar
                            </a>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Crear Artículo
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2023 Base de Conocimientos. Todos los derechos reservados.</p>
        </div>
    </footer>
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

        // Tabs functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-600');
                });
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Add active class to clicked tab and corresponding content
                button.classList.remove('text-gray-600');
                button.classList.add('text-blue-600', 'border-blue-600');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Simular envío de formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Formulario enviado correctamente a la ruta: knowledgebase.store');
        });
    </script>
@endsection
