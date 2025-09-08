@extends('layouts.admin')
@section('title', 'Editar Naturaleza')

@section('content_header')
    <div class="flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <i class="fas fa-edit text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-800">Editar Naturaleza: {{ $naturaleza->nombre }}</h1>
    </div>
@stop

@section('content.dashboard')
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.naturaleza.update', $naturaleza) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre de la Naturaleza:</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                    value="{{ old('nombre', $naturaleza->nombre) }}" placeholder="Ej: Soporte TI" required>
                @error('nombre')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="estatus" class="block text-gray-700 font-medium mb-2">Estatus:</label>
                <select name="estatus" id="estatus"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="activo" {{ old('estatus', $naturaleza->estatus) == 'activo' ? 'selected' : '' }}>Activo
                    </option>
                    <option value="inactivo" {{ old('estatus', $naturaleza->estatus) == 'inactivo' ? 'selected' : '' }}>
                        Inactivo</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.naturaleza.show', $naturaleza) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center">
                    <i class="fas fa-eye mr-2"></i> Ver Categorías
                </a>
                <a href="{{ route('admin.naturaleza.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Actualizar Naturaleza
                </button>
            </div>
        </form>
    </div>
@stop
