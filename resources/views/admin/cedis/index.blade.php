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
                @endif

                <!-- Filters Section -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Búsqueda por texto -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar:</label>
                        <input type="text" id="search" value="{{ $search ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nombre, dirección, responsable, teléfono...">
                    </div>

                    <!-- Filtro por región -->
                    <div>
                        <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por
                            Región:</label>
                        <select id="region_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las regiones</option>
                            @foreach ($regiones as $region)
                                <option value="{{ $region->id }}"
                                    {{ ($regionId ?? '') == $region->id ? 'selected' : '' }}>
                                    {{ $region->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-end space-x-2">
                        <button id="btnFiltrar"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors shadow-sm">
                            Filtrar
                        </button>
                        <button id="btnLimpiar"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md transition-colors shadow-sm">
                            Limpiar
                        </button>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div id="loading" class="hidden mb-4 text-center">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Buscando...</span>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="mb-4 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Mostrando <span id="result-count">{{ $cedis->count() }}</span> de
                        <span id="total-count">{{ $cedis->total() }}</span> resultados
                        <span id="filtered-indicator" class="text-blue-600 ml-2 hidden">(Filtrados)</span>
                    </p>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Direccion</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Región</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responsable</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Teléfono</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="cedis-table-body">
                            @include('admin.cedis.partials.cedis_rows', ['cedis' => $cedis])
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="mt-6">
                    {{ $cedis->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== Obtener token CSRF =====
            function getCsrfToken() {
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                if (metaTag) return metaTag.content;
                console.error('CSRF token meta tag not found');
                return '';
            }

            // ===== Elementos del DOM =====
            const searchInput = document.getElementById('search');
            const regionSelect = document.getElementById('region_id');
            const btnFiltrar = document.getElementById('btnFiltrar');
            const btnLimpiar = document.getElementById('btnLimpiar');
            const loading = document.getElementById('loading');
            const tableBody = document.getElementById('cedis-table-body');
            const pagination = document.getElementById('pagination');
            const resultCount = document.getElementById('result-count');
            const totalCount = document.getElementById('total-count');
            const filteredIndicator = document.getElementById('filtered-indicator');

            let currentPage = 1;
            let searchTimeout;
            let currentFilters = {
                search: '',
                region_id: ''
            };

            // ===== Función principal para cargar CEDIS vía AJAX =====
            function cargarCedis(page = 1) {
                currentPage = page;
                currentFilters.search = searchInput.value;
                currentFilters.region_id = regionSelect.value;

                console.log('Cargando página:', page, 'con filtros:', currentFilters);

                // Mostrar loading
                loading.classList.remove('hidden');
                tableBody.innerHTML = `<tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                <div class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Cargando...
                </div>
            </td>
        </tr>`;

                // Usar URL directa para evitar problemas con las rutas
                const url = '/admin/cedis/filter';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            search: currentFilters.search,
                            region_id: currentFilters.region_id,
                            page: page
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos:', data);

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        // Actualizar tabla y paginación
                        tableBody.innerHTML = data.html;
                        pagination.innerHTML = data.pagination_html;

                        // Re-attach event listeners a los nuevos enlaces de paginación
                        attachPaginationListeners();

                        // Actualizar contadores
                        resultCount.textContent = data.pagination.count || 0;
                        totalCount.textContent = data.pagination.total;

                        // Actualizar filtros actuales
                        if (data.filters) {
                            currentFilters = data.filters;
                        }

                        // Indicador de filtrado
                        if (currentFilters.search || currentFilters.region_id) {
                            filteredIndicator.classList.remove('hidden');
                        } else {
                            filteredIndicator.classList.add('hidden');
                        }

                        loading.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error en fetch:', error);
                        tableBody.innerHTML = `<tr>
                    <td colspan="6" class="px-6 py-4 text-center text-red-500">
                        Error al cargar los datos: ${error.message}
                    </td>
                </tr>`;
                        loading.classList.add('hidden');
                    });
            }

            // ===== Función para adjuntar listeners de paginación =====
            function attachPaginationListeners() {
                const paginationLinks = document.querySelectorAll('#pagination a');

                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Extraer número de página del href
                        const url = new URL(this.href);
                        const pageParam = url.searchParams.get('page');
                        const page = pageParam ? parseInt(pageParam) : 1;

                        console.log('Cambiando a página:', page);
                        cargarCedis(page);
                    });
                });
            }

            // ===== Eventos =====
            btnFiltrar.addEventListener('click', () => cargarCedis(1));

            btnLimpiar.addEventListener('click', () => {
                searchInput.value = '';
                regionSelect.value = '';
                cargarCedis(1);
            });

            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => cargarCedis(1), 500);
            });

            regionSelect.addEventListener('change', () => cargarCedis(1));

            // Adjuntar listeners iniciales
            attachPaginationListeners();

            // Cargar datos iniciales
            cargarCedis(1);
        });
    </script>

@endsection
