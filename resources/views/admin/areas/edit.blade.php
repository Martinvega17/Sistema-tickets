@extends('layouts.admin')

@section('title', 'Editar Área')

@section('content.dashboard')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center mb-6">
                    <a href="{{ route('admin.areas.index') }}" class="text-pepsi-blue hover:text-blue-700 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Editar Área</h2>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.areas.update', $area->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue"
                                value="{{ old('nombre', $area->nombre) }}" placeholder="Ingrese el nombre del área">
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estatus" class="block text-sm font-medium text-gray-700 mb-1">Estatus *</label>
                            <select name="estatus" id="estatus" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue">
                                <option value="activo" {{ old('estatus', $area->estatus) == 'activo' ? 'selected' : '' }}>
                                    Activo</option>
                                <option value="inactivo"
                                    {{ old('estatus', $area->estatus) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estatus')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información adicional -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Información del Área</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">ID:</span> {{ $area->id }}
                                </div>
                                <div>
                                    <span class="font-medium">Creado:</span> {{ $area->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Actualizado:</span>
                                    {{ $area->updated_at->format('d/m/Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Tickets asociados:</span> {{ $area->tickets()->count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.areas.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-pepsi-blue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Actualizar Área
                        </button>
                    </div>
                </form>

                <!-- Sección de eliminación (opcional) -->
                @if ($area->tickets()->count() == 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-red-600 mb-3">Zona de peligro</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Una vez que elimines un área, no hay vuelta atrás. Por favor, ten cuidado.
                        </p>
                        <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta área? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                                Eliminar Área
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">No se puede eliminar</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Esta área tiene {{ $area->tickets()->count() }} tickets asociados y no puede ser
                                            eliminada.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
