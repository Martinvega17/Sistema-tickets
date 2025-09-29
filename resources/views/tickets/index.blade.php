@php
    use App\Models\Ticket;
@endphp
@extends('layouts.admin')

@section('title', 'Administración de Tickets')

@section('content.dashboard')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Administración de Tickets</h2>
                        <p class="text-sm text-gray-500 mt-1">Gestione todos los tickets del sistema</p>
                    </div>
                    <a href="{{ route('tickets.create') }}"
                        class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors flex items-center justify-center space-x-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Nuevo Ticket</span>
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
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Búsqueda -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar:</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Título, descripción, usuario...">
                    </div>

                    <!-- Filtro por estatus -->
                    <div>
                        <label for="estatus" class="block text-sm font-medium text-gray-700 mb-2">Estatus:</label>
                        <select id="estatus" name="estatus"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estatus</option>
                            <option value="Abierto" {{ request('estatus') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                            <option value="En progreso" {{ request('estatus') == 'En progreso' ? 'selected' : '' }}>En
                                progreso</option>
                            <option value="En espera" {{ request('estatus') == 'En espera' ? 'selected' : '' }}>En espera
                            </option>
                            <option value="Resuelto" {{ request('estatus') == 'Resuelto' ? 'selected' : '' }}>Resuelto
                            </option>
                            <option value="Cerrado" {{ request('estatus') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>

                    <!-- Filtro por prioridad -->
                    <div>
                        <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad:</label>
                        <select id="prioridad" name="prioridad"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las prioridades</option>
                            <option value="Baja" {{ request('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                            <option value="Media" {{ request('prioridad') == 'Media' ? 'selected' : '' }}>Media</option>
                            <option value="Alta" {{ request('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                            <option value="Crítica" {{ request('prioridad') == 'Crítica' ? 'selected' : '' }}>Crítica
                            </option>
                        </select>
                    </div>

                    <!-- Filtro por CEDIS -->
                    <div>
                        <label for="cedis_id" class="block text-sm font-medium text-gray-700 mb-2">CEDIS:</label>
                        <select id="cedis_id" name="cedis_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los CEDIS</option>
                            @foreach ($cedis as $cedi)
                                <option value="{{ $cedi->id }}"
                                    {{ request('cedis_id') == $cedi->id ? 'selected' : '' }}>
                                    {{ $cedi->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botones de filtro -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                    <div class="flex space-x-2">
                        <button type="button" id="btnFiltrar"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors shadow-sm">
                            Filtrar
                        </button>
                        <a href="{{ route('tickets.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md transition-colors shadow-sm">
                            Limpiar
                        </a>
                    </div>

                    <!-- Estadísticas rápidas -->
                    <div class="flex space-x-4 text-sm text-gray-600">
                        <span>Total: <strong>{{ $tickets->total() }}</strong></span>
                        <span>Abiertos: <strong
                                class="text-red-600">{{ \App\Models\Tickets::abiertos()->count() }}</strong></span>
                        <span>En progreso: <strong
                                class="text-blue-600">{{ \App\Models\Tickets::enProgreso()->count() }}</strong></span>
                        <span>Resueltos: <strong
                                class="text-green-600">{{ \App\Models\Tickets::resueltos()->count() }}</strong></span>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    CEDIS
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estatus
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prioridad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Recepción
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $ticket->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($ticket->titulo, 50) }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($ticket->descripcion, 70) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $ticket->usuario->numero_nomina }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticket->cedis->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if ($ticket->estatus == 'Abierto') bg-red-100 text-red-800
                                            @elseif($ticket->estatus == 'En progreso') bg-blue-100 text-blue-800
                                            @elseif($ticket->estatus == 'En espera') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->estatus == 'Resuelto') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $ticket->estatus }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if ($ticket->prioridad == 'Baja') bg-green-100 text-green-800
                                            @elseif($ticket->prioridad == 'Media') bg-blue-100 text-blue-800
                                            @elseif($ticket->prioridad == 'Alta') bg-orange-100 text-orange-800
                                            @elseif($ticket->prioridad == 'Crítica') bg-red-100 text-red-800 @endif">
                                            {{ $ticket->prioridad }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticket->fecha_recepcion->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('tickets.show', $ticket->id) }}"
                                                class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('tickets.edit', $ticket->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('¿Está seguro de eliminar este ticket?')"
                                                    title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No se encontraron tickets.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtrado automático al cambiar selects
            const filterSelects = ['search', 'estatus', 'prioridad', 'cedis_id'];

            filterSelects.forEach(selectId => {
                const element = document.getElementById(selectId);
                if (element) {
                    element.addEventListener('change', function() {
                        document.getElementById('btnFiltrar').click();
                    });
                }
            });

            // Botón filtrar
            document.getElementById('btnFiltrar').addEventListener('click', function() {
                const search = document.getElementById('search').value;
                const estatus = document.getElementById('estatus').value;
                const prioridad = document.getElementById('prioridad').value;
                const cedis_id = document.getElementById('cedis_id').value;

                const params = new URLSearchParams();

                if (search) params.append('search', search);
                if (estatus) params.append('estatus', estatus);
                if (prioridad) params.append('prioridad', prioridad);
                if (cedis_id) params.append('cedis_id', cedis_id);

                window.location.href = '{{ route('tickets.index') }}?' + params.toString();
            });
        });
    </script>
@endsection
