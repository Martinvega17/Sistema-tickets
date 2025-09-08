@extends('layouts.admin')

@section('title', 'Crear Área')

@section('content.dashboard')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nueva Área</h2>

                <form action="{{ route('admin.areas.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue"
                                value="{{ old('nombre') }}">
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estatus" class="block text-sm font-medium text-gray-700 mb-1">Estatus *</label>
                            <select name="estatus" id="estatus" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue">
                                <option value="activo" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('estatus')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.areas.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-pepsi-blue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Crear Área
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
