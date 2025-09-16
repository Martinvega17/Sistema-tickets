@extends('layouts.admin')

@section('content.dashboard')
    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado -->

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de CEDIS</h1>
                <p class="text-gray-600 mt-2">Administra los Centros de Distribución del sistema</p>
            </div>
            @if (in_array(Auth::user()->rol_id, [1, 2]))
                <a href="{{ route('cedis.create') }}"
                    class="mt-4 md:mt-0 px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition duration-150 ease-in-out flex items-center">
                    <i class="bi bi-plus-circle mr-2"></i> Nuevo CEDIS
                </a>
            @endif
        </div>

        <!-- Filtros de búsqueda -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar por nombre</label>
                    <input type="text" id="searchInput" placeholder="Nombre del CEDIS o Ingeniero"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                    <select id="regionSelect"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todas las regiones</option>
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estatus</label>
                    <select id="estatusSelect"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="limpiarFiltros()"
                        class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out">
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Información de resultados -->
        <div class="mb-4 text-sm text-gray-600">
            Mostrando <span id="contadorActual">{{ $cedis->count() }}</span> de {{ $cedis->count() }} CEDIS
        </div>

        <!-- Tabla de CEDIS -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ingeniero Asignado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Región</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tablaCedis">
                        @foreach ($cedis as $cedi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cedi->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-400">
                                        {{ $cedi->ingeniero ? $cedi->ingeniero->nombre . ' ' . $cedi->ingeniero->apellido : 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cedi->region ? $cedi->region->nombre : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cedi->estatus === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $cedi->estatus === 'activo' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('cedis.edit', $cedi->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <form action="{{ route('cedis.toggle-status', $cedi->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estatus"
                                            value="{{ $cedi->estatus === 'activo' ? 'inactivo' : 'activo' }}">
                                        <button type="submit"
                                            class="{{ $cedi->estatus === 'activo' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} mr-3"
                                            onclick="return confirm('¿Estás seguro que quieres {{ $cedi->estatus === 'activo' ? 'desactivar' : 'activar' }} el CEDIS \'{{ $cedi->nombre }}\'?')">
                                            <i
                                                class="bi {{ $cedi->estatus === 'activo' ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                            {{ $cedi->estatus === 'activo' ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <button
                                        onclick="openDeleteModal({{ $cedi->id }}, '{{ addslashes($cedi->nombre) }}')"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($cedis->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No hay CEDIS registrados.</p>
            </div>
        @endif
    </div>

    <!-- Paginación alineada a la derecha -->
    @if ($cedis->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-end border-t border-gray-200 sm:px-6">
            {{ $cedis->links('vendor.pagination.custom') }}
        </div>
    @endif
    </div>

    @if ($cedis->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">No hay CEDIS registrados.</p>
        </div>
    @endif
    </div>

    @include('cedis.modals.destroy')

    <script>
        // Datos de los CEDIS para filtrar
        const cedisData = [
            @foreach ($cedis as $cedi)
                {
                    id: {{ $cedi->id }},
                    nombre: "{{ $cedi->nombre }}",
                    region_id: "{{ $cedi->region_id }}",
                    region_nombre: "{{ $cedi->region ? $cedi->region->nombre : '' }}",
                    estatus: "{{ $cedi->estatus }}",
                    ingeniero: "{{ $cedi->ingeniero ? $cedi->ingeniero->nombre . ' ' . $cedi->ingeniero->apellido : '' }}",
                    html: `{!! '<tr>' .
                        '<td class="px-6 py-4 whitespace-nowrap">' .
                        $cedi->nombre .
                        '</td>' .
                        '<td class="px-6 py-4 whitespace-nowrap"><span class="text-gray-400">' .
                        ($cedi->ingeniero ? $cedi->ingeniero->nombre . ' ' . $cedi->ingeniero->apellido : 'Sin asignar') .
                        '</span></td>' .
                        '<td class="px-6 py-4 whitespace-nowrap">' .
                        ($cedi->region ? $cedi->region->nombre : 'N/A') .
                        '</td>' .
                        '<td class="px-6 py-4 whitespace-nowrap">' .
                        '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' .
                        ($cedi->estatus === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') .
                        '">' .
                        ($cedi->estatus === 'activo' ? 'Activo' : 'Inactivo') .
                        '</span>' .
                        '</td>' .
                        '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">' .
                        '<a href="/cedis/' .
                        $cedi->id .
                        '/edit" class="text-blue-600 hover:text-blue-900 mr-3">' .
                        '<i class="bi bi-pencil-square"></i> Editar' .
                        '</a>' .
                        '<form action="/cedis/' .
                        $cedi->id .
                        '/toggle-status" method="POST" class="inline-block">' .
                        '@csrf @method("PUT")' .
                        '<button type="submit" class="' .
                        ($cedi->estatus === 'activo' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900') .
                        ' mr-3">' .
                        '<i class="bi ' .
                        ($cedi->estatus === 'activo' ? 'bi-x-circle' : 'bi-check-circle') .
                        '"></i>' .
                        ($cedi->estatus === 'activo' ? 'Desactivar' : 'Activar') .
                        '</button>' .
                        '</form>' .
                        '<button onclick="openDeleteModal(' .
                        $cedi->id .
                        ', \'' .
                        addslashes($cedi->nombre) .
                        '\')" class="text-red-600 hover:text-red-900">' .
                        '<i class="bi bi-trash"></i> Eliminar' .
                        '</button>' .
                        '</td>' .
                        '</tr>' !!}`
                },
            @endforeach
        ];

        function aplicarFiltros() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const regionValue = document.getElementById('regionSelect').value;
            const estatusValue = document.getElementById('estatusSelect').value;

            const resultadosFiltrados = cedisData.filter(cedi => {
                const coincideBusqueda = searchValue === '' ||
                    cedi.nombre.toLowerCase().includes(searchValue) ||
                    cedi.ingeniero.toLowerCase().includes(searchValue);
                const coincideRegion = regionValue === '' || cedi.region_id == regionValue;
                const coincideEstatus = estatusValue === '' || cedi.estatus === estatusValue;

                return coincideBusqueda && coincideRegion && coincideEstatus;
            });

            // Actualizar tabla
            const tablaBody = document.getElementById('tablaCedis');
            tablaBody.innerHTML = resultadosFiltrados.map(cedi => cedi.html).join('');

            // Actualizar contador
            document.getElementById('contadorActual').textContent = resultadosFiltrados.length;
        }

        function limpiarFiltros() {
            document.getElementById('searchInput').value = '';
            document.getElementById('regionSelect').value = '';
            document.getElementById('estatusSelect').value = '';
            aplicarFiltros();
        }

        // Configurar event listeners
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
            document.getElementById('regionSelect').addEventListener('change', aplicarFiltros);
            document.getElementById('estatusSelect').addEventListener('change', aplicarFiltros);
        });

        // Funciones para modales (si las necesitas)
        function openDeleteModal(cedisId, cedisName) {
            if (document.getElementById('deleteCedisName')) {
                document.getElementById('deleteCedisName').textContent = cedisName;
            }
            if (document.getElementById('deleteCedisModal')) {
                const modal = document.getElementById('deleteCedisModal');
                modal.setAttribute('data-cedis-id', cedisId);
                modal.classList.remove('hidden');
            }
        }

        function closeModal(modalId) {
            if (document.getElementById(modalId)) {
                document.getElementById(modalId).classList.add('hidden');
            }
        }
    </script>
@section('scripts')
    <script src="{{ asset('js/cedis.js') }}"></script>
@endsection
@endsection
