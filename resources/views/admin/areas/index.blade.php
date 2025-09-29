@extends('layouts.admin')

@section('title', 'Administrar Áreas')

@section('content.dashboard')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Administrar Áreas</h2>
                    <a href="{{ route('admin.areas.create') }}"
                        class="w-full sm:w-auto bg-pepsi-blue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-center text-sm sm:text-base">
                        + Nueva Área
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Vista para móviles -->
                <div class="block sm:hidden">
                    <div class="space-y-4">
                        @foreach ($areas as $area)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $area->nombre }}</div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $area->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $area->estatus }}
                                    </span>
                                </div>
                                <div class="flex space-x-3 mt-3">
                                    <a href="{{ route('admin.areas.edit', $area->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm">Editar</a>
                                    <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta área?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Vista para tablets y desktop -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estatus
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($areas as $area)
                                <tr>
                                    <td class="px-4 py-4 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $area->nombre }}</div>
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $area->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $area->estatus }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 sm:py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.areas.edit', $area->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar esta área?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

               
            </div>
        </div>
    </div>
@endsection