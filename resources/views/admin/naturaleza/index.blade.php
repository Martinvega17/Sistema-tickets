@extends('layouts.admin')
@section('title', 'Naturalezas')

@section('content_header')
    <div class="flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <i class="fas fa-leaf text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-800">Gestión de Naturalezas</h1>
    </div>
@stop

@section('content.dashboard')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800">Lista de Naturalezas</h2>
            <a href="{{ route('admin.naturaleza.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition">
                <i class="fas fa-plus mr-2"></i> Nueva Naturaleza
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Estatus
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            Categorías</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($naturalezas as $naturaleza)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $naturaleza->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $naturaleza->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($naturaleza->estatus) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $naturaleza->categorias->count() }} categorías
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">

                                    <a href="{{ route('admin.naturaleza.edit', $naturaleza) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg transition flex items-center text-sm"
                                        title="Editar">
                                        <i class="fas fa-edit mr-1 text-xs"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.naturaleza.destroy', $naturaleza) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta naturaleza?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition flex items-center text-sm w-full"
                                            title="Eliminar">
                                            <i class="fas fa-trash mr-1 text-xs"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($naturalezas->isEmpty())
            <div class="bg-blue-50 text-blue-700 p-6 rounded-lg text-center mt-6">
                <i class="fas fa-info-circle text-2xl mb-3"></i>
                <p class="font-medium">No hay naturalezas registradas</p>
                <p class="text-sm mt-2">Comienza creando tu primera naturaleza</p>
                <a href="{{ route('admin.naturaleza.create') }}"
                    class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Crear Naturaleza
                </a>
            </div>
        @endif
    </div>
@stop
