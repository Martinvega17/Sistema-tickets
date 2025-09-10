@extends('layouts.admin')
@section('title', 'Administrar Categorías')

@section('content.dashboard')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Administrar Categorías</h2>
                    <a href="{{ route('admin.categorias.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nueva Categoría
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Información de paginación -->
                <div class="mb-4 text-sm text-gray-600">
                    Mostrando {{ $categorias->firstItem() }} - {{ $categorias->lastItem() }} de {{ $categorias->total() }}
                    categorías
                </div>

                <!-- Filtros -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="filtro_naturaleza" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por
                            Naturaleza:</label>
                        <select id="filtro_naturaleza"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las naturalezas</option>
                            @foreach ($naturalezas as $naturaleza)
                                <option value="{{ $naturaleza->id }}">{{ $naturaleza->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filtro_servicio" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por
                            Servicio:</label>
                        <select id="filtro_servicio"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los servicios</option>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filtro_estatus" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por
                            Estatus:</label>
                        <select id="filtro_estatus"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estatus</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="tabla-categorias">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Naturalezas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Servicios
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estatus
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tickets
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categorias as $categoria)
                                <tr class="categoria-row"
                                    data-naturalezas="{{ $categoria->naturalezas->pluck('id')->implode(',') }}"
                                    data-servicios="{{ $categoria->servicios->pluck('id')->implode(',') }}"
                                    data-estatus="{{ $categoria->estatus }}">
                                    <!-- Columna Nombre -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $categoria->nombre }}</div>
                                    </td>

                                    <!-- Columna Naturalezas -->
                                    <td class="px-6 py-4">
                                        @if ($categoria->naturalezas && count($categoria->naturalezas) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($categoria->naturalezas as $naturaleza)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $naturaleza->nombre }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">Sin naturalezas</span>
                                        @endif
                                    </td>

                                    <!-- Columna Servicios -->
                                    <td class="px-6 py-4">
                                        @if ($categoria->servicios && count($categoria->servicios) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($categoria->servicios as $servicio)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                        {{ $servicio->nombre }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">Sin servicios</span>
                                        @endif
                                    </td>

                                    <!-- Columna Estatus -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $categoria->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $categoria->estatus }}
                                        </span>
                                    </td>

                                    <!-- Columna Tickets -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $categoria->tickets()->count() }}
                                    </td>

                                    <!-- Columna Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.categorias.edit', $categoria->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.categorias.destroy', $categoria->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                <i class="fas fa-trash mr-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $categorias->links() }}
                </div>

                @if ($categorias->isEmpty())
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                        <p class="text-gray-500">No hay categorías registradas.</p>
                        <a href="{{ route('admin.categorias.create') }}"
                            class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                            Crear la primera categoría
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtroNaturaleza = document.getElementById('filtro_naturaleza');
            const filtroServicio = document.getElementById('filtro_servicio');
            const filtroEstatus = document.getElementById('filtro_estatus');
            const filasCategorias = document.querySelectorAll('.categoria-row');

            function aplicarFiltros() {
                const naturalezaId = filtroNaturaleza.value;
                const servicioId = filtroServicio.value;
                const estatus = filtroEstatus.value;

                filasCategorias.forEach(fila => {
                    const filaNaturalezas = fila.getAttribute('data-naturalezas').split(',');
                    const filaServicios = fila.getAttribute('data-servicios').split(',');
                    const filaEstatus = fila.getAttribute('data-estatus');

                    const coincideNaturaleza = naturalezaId === '' || filaNaturalezas.includes(
                    naturalezaId);
                    const coincideServicio = servicioId === '' || filaServicios.includes(servicioId);
                    const coincideEstatus = estatus === '' || filaEstatus === estatus;

                    if (coincideNaturaleza && coincideServicio && coincideEstatus) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                });
            }

            filtroNaturaleza.addEventListener('change', aplicarFiltros);
            filtroServicio.addEventListener('change', aplicarFiltros);
            filtroEstatus.addEventListener('change', aplicarFiltros);
        });
    </script>
@endsection
