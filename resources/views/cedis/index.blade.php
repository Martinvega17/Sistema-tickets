@extends('layouts.app')

@section('content')
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
                    <input type="text" name="search" placeholder="Nombre del CEDIS"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                    <select name="region" id="regionFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todas las regiones</option>
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estatus</label>
                    <select name="estatus"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
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
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center">
                                    <div class="loading mr-2"></div>
                                    Cargando CEDIS...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700" id="paginationInfo">
                            Cargando información...
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination"
                            id="paginationNav">
                            <!-- La paginación se generará dinámicamente -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('cedis.modals.destroy')
@endsection

<!-- Cargar el archivo JavaScript externo -->
<script src="{{ asset('js/cedis.js') }}"></script>
@include('cedis.modals.destroy')


