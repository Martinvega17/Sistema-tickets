@extends('layouts.admin')
@section('title', 'Crear Categoría')

@section('content_header')
    <div class="flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <i class="fas fa-tag text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-800">Crear Nueva Categoría</h1>
    </div>
@stop

@section('content.dashboard')
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre de la Categoría:</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                    value="{{ old('nombre') }}" placeholder="Ej: Monitores, Impresoras, Software Office" required>
                @error('nombre')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="naturaleza_id" class="block text-gray-700 font-medium mb-2">Naturaleza:</label>
                <select name="naturaleza_id" id="naturaleza_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('naturaleza_id') border-red-500 @enderror"
                    required>
                    <option value="">Selecciona una naturaleza</option>
                    @foreach ($naturalezas as $naturaleza)
                        <option value="{{ $naturaleza->id }}"
                            {{ old('naturaleza_id') == $naturaleza->id ? 'selected' : '' }}>
                            {{ $naturaleza->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('naturaleza_id')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="servicio_id" class="block text-gray-700 font-medium mb-2">Servicio:</label>
                <select name="servicio_id" id="servicio_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('servicio_id') border-red-500 @enderror"
                    required>
                    <option value="">Selecciona un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('servicio_id')
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
                    <option value="activo" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.categorias.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Crear Categoría
                </button>
            </div>
        </form>
    </div>
@stop
