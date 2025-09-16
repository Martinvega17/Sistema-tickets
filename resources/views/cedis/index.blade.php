@extends('layouts.admin')

@section('content.dashboard')
    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado -->
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
            <form id="searchForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar por nombre</label>
                    <input type="text" id="searchInput" placeholder="Nombre del CEDIS"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                    <select id="regionFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todas las regiones</option>
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estatus</label>
                    <select id="statusFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="filterCedis()"
                        class="w-full px-4 py-2 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition duration-150 ease-in-out">Buscar</button>
                </div>
            </form>
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
                    <tbody id="cedisTableBody" class="bg-white divide-y divide-gray-200">
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
                                    <button onclick="toggleStatus({{ $cedi->id }}, '{{ $cedi->estatus }}')"
                                        class="{{ $cedi->estatus === 'activo' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} mr-3">
                                        <i
                                            class="bi {{ $cedi->estatus === 'activo' ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                        {{ $cedi->estatus === 'activo' ? 'Desactivar' : 'Activar' }}
                                    </button>
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
    </div>

    @include('cedis.modals.destroy')

    <!-- JavaScript simple para filtros -->
    <script>
        // Pasar datos de CEDIS a JavaScript
        const allCedis = @json($cedis);

        function filterCedis() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const regionId = document.getElementById('regionFilter').value;
            const status = document.getElementById('statusFilter').value;

            const filteredCedis = allCedis.filter(cedis => {
                const matchesSearch = cedis.nombre.toLowerCase().includes(searchTerm) ||
                    (cedis.codigo && cedis.codigo.toLowerCase().includes(searchTerm));
                const matchesRegion = !regionId || cedis.region_id == regionId;
                const matchesStatus = !status || cedis.estatus === status;

                return matchesSearch && matchesRegion && matchesStatus;
            });

            renderCedisTable(filteredCedis);
        }

        function renderCedisTable(cedisList) {
            const tbody = document.getElementById('cedisTableBody');
            tbody.innerHTML = cedisList.map(cedis => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">${cedis.nombre}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-400">
                            ${cedis.ingeniero ? cedis.ingeniero.nombre + ' ' + cedis.ingeniero.apellido : 'Sin asignar'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">${cedis.region ? cedis.region.nombre : 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${cedis.estatus === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${cedis.estatus === 'activo' ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/cedis/${cedis.id}/edit" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <button onclick="toggleStatus(${cedis.id}, '${cedis.estatus}')" 
                                class="${cedis.estatus === 'activo' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'} mr-3">
                            <i class="bi ${cedis.estatus === 'activo' ? 'bi-x-circle' : 'bi-check-circle'}"></i> 
                            ${cedis.estatus === 'activo' ? 'Desactivar' : 'Activar'}
                        </button>
                        <button onclick="openDeleteModal(${cedis.id}, '${cedis.nombre.replace(/'/g, "\\'")}')" 
                                class="text-red-600 hover:text-red-900">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Funciones para modales (mantener las que ya tienes)
        function openDeleteModal(cedisId, cedisName) {
            document.getElementById('deleteCedisName').textContent = cedisName;
            document.getElementById('deleteCedisModal').setAttribute('data-cedis-id', cedisId);
            document.getElementById('deleteCedisModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        async function confirmDeleteCedis() {
            const modal = document.getElementById('deleteCedisModal');
            const cedisId = modal.getAttribute('data-cedis-id');

            try {
                const response = await fetch(`/cedis/${cedisId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    alert('CEDIS eliminado correctamente');
                    window.location.reload();
                } else {
                    throw new Error('Error al eliminar');
                }
            } catch (error) {
                alert('Error al eliminar el CEDIS');
            }
        }

        async function toggleStatus(cedisId, currentStatus) {
            if (confirm(`¿Estás seguro de ${currentStatus === 'activo' ? 'desactivar' : 'activar'} este CEDIS?`)) {
                try {
                    const newStatus = currentStatus === 'activo' ? 'inactivo' : 'activo';
                    const response = await fetch(`/cedis/${cedisId}/estatus`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            estatus: newStatus
                        })
                    });

                    if (response.ok) {
                        alert('Estatus actualizado correctamente');
                        window.location.reload();
                    } else {
                        throw new Error('Error al cambiar estatus');
                    }
                } catch (error) {
                    alert('Error al cambiar el estatus del CEDIS');
                }
            }
        }
    </script>
@endsection
