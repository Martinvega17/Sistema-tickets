@extends('layouts.admin')

@section('title', 'Administrar CEDIS')

@section('content.dashboard')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Administración de CEDIS</h2>
                        <p class="text-sm text-gray-500 mt-1">Gestione los centros de distribución de su organización</p>
                    </div>
                    <a href="{{ route('admin.cedis.create') }}"
                        class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors flex items-center justify-center space-x-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Nuevo CEDIS</span>
                    </a>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div id="flash-success" class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    <script>
                        setTimeout(() => {
                            const banner = document.getElementById('flash-success');
                            if (banner) {
                                banner.style.transition = "opacity 0.5s";
                                banner.style.opacity = 0;
                                setTimeout(() => banner.remove(), 500);
                            }
                        }, 4000);
                    </script>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Results Count -->
                <div class="mb-4 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Mostrando <span class="font-medium">{{ $cedis->count() }}</span> de
                        <span class="font-medium">{{ $cedis->total() }}</span> resultados
                    </p>
                </div>

                <!-- Filters Section -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Búsqueda por texto -->
                    <div>
                        <label for="filtro_busqueda" class="block text-sm font-medium text-gray-700 mb-2">Buscar:</label>
                        <input type="text" id="filtro_busqueda"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nombre, dirección, responsable, teléfono...">
                    </div>

                    <!-- Filtro por región -->
                    <div>
                        <label for="filtro_region" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por
                            Region:</label>
                        <select id="filtro_region"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las regiones</option>
                            @foreach ($regiones as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Contador de resultados filtrados -->
                <div id="contador-filtrado" class="mb-4 hidden">
                    <p class="text-sm text-blue-600">
                        <span id="resultados-visibles">0</span> resultados coinciden con los filtros
                    </p>
                    <button onclick="limpiarFiltros()" class="text-sm text-gray-500 hover:text-gray-700 underline mt-1">
                        Limpiar filtros
                    </button>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre / Dirección</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Región</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responsable</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Teléfono</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tabla-cedis">
                            @foreach ($cedis as $cedi)
                                <tr class="cedis-row hover:bg-gray-50 transition-colors"
                                    data-region="{{ $cedi->region_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $cedi->nombre }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($cedi->direccion, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 bg-blue-50 px-2 py-1 rounded-full inline-block">
                                            {{ $cedi->region->nombre ?? 'Sin región' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cedi->responsable ?: '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cedi->telefono ?: '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $cedi->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($cedi->estatus) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.cedis.edit', $cedi->id) }}"
                                                class="text-blue-600 hover:text-blue-900 transition-colors flex items-center"
                                                title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Editar</span>
                                            </a>

                                            <form action="{{ route('admin.cedis.toggle-status', $cedi->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estatus"
                                                    value="{{ $cedi->estatus == 'activo' ? 'inactivo' : 'activo' }}">
                                                <button type="submit"
                                                    class="text-yellow-600 hover:text-yellow-900 transition-colors flex items-center"
                                                    title="{{ $cedi->estatus == 'activo' ? 'Desactivar' : 'Activar' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        @if ($cedi->estatus == 'activo')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        @endif
                                                    </svg>
                                                    <span>{{ $cedi->estatus == 'activo' ? 'Desactivar' : 'Activar' }}</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.cedis.destroy', $cedi->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors flex items-center"
                                                    onclick="return confirm('¿Estás seguro de eliminar este CEDIS?')"
                                                    title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Eliminar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $cedis->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtroRegion = document.getElementById('filtro_region');
            const filtroBusqueda = document.getElementById('filtro_busqueda');
            const filasCedis = document.querySelectorAll('.cedis-row');
            const contadorFiltrado = document.getElementById('contador-filtrado');
            const resultadosVisiblesSpan = document.getElementById('resultados-visibles');

            function aplicarFiltros() {
                const regionId = filtroRegion.value;
                const textoBusqueda = filtroBusqueda.value.toLowerCase().trim();
                let resultadosVisibles = 0;

                filasCedis.forEach(fila => {
                    const regionFila = fila.getAttribute('data-region');
                    const textoFila = fila.textContent.toLowerCase();

                    // Verificar si coincide con región
                    const coincideRegion = regionId === '' || regionFila === regionId;

                    // Verificar si coincide con texto de búsqueda
                    const coincideTexto = textoBusqueda === '' || textoFila.includes(textoBusqueda);

                    if (coincideRegion && coincideTexto) {
                        fila.style.display = '';
                        resultadosVisibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                // Actualizar contador
                if (regionId !== '' || textoBusqueda !== '') {
                    contadorFiltrado.classList.remove('hidden');
                    resultadosVisiblesSpan.textContent = resultadosVisibles;
                } else {
                    contadorFiltrado.classList.add('hidden');
                }
            }

            function limpiarFiltros() {
                filtroRegion.value = '';
                filtroBusqueda.value = '';
                aplicarFiltros();
            }

            // Event listeners
            filtroRegion.addEventListener('change', aplicarFiltros);
            filtroBusqueda.addEventListener('input', function() {
                // Usar debounce para no ejecutar demasiadas veces
                clearTimeout(window.filtroTimeout);
                window.filtroTimeout = setTimeout(aplicarFiltros, 300);
            });

            // Aplicar filtros inicialmente
            aplicarFiltros();

            // Hacer la función global para el botón de limpiar
            window.limpiarFiltros = limpiarFiltros;
        });
    </script>
@endsection
