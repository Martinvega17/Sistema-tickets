@extends('layouts.admin')
@section('title', 'Editar Categoría')

@section('content_header')
    <div class="flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <i class="fas fa-edit text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-800">Editar Categoría: {{ $categoria->nombre }}</h1>
    </div>
@stop

@section('content.dashboard')
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre de la Categoría:</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                    value="{{ old('nombre', $categoria->nombre) }}" placeholder="Ej: Laptop, Software, Equipo de red"
                    required>
                @error('nombre')
                    <span class="text-red-500 text-sm mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Naturalezas:</label>
                    <div class="border rounded-lg p-3 max-h-60 overflow-y-auto">
                        @foreach ($naturalezas as $naturaleza)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="naturalezas[]" value="{{ $naturaleza->id }}"
                                    id="naturaleza_{{ $naturaleza->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2"
                                    {{ in_array($naturaleza->id, old('naturalezas', $naturalezasSeleccionadas)) ? 'checked' : '' }}>
                                <label for="naturaleza_{{ $naturaleza->id }}" class="text-sm text-gray-700">
                                    {{ $naturaleza->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('naturalezas')
                        <span class="text-red-500 text-sm mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Servicios:</label>
                    <div class="border rounded-lg p-3 max-h-60 overflow-y-auto">
                        @foreach ($servicios as $servicio)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}"
                                    id="servicio_{{ $servicio->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2"
                                    {{ in_array($servicio->id, old('servicios', $serviciosSeleccionados)) ? 'checked' : '' }}>
                                <label for="servicio_{{ $servicio->id }}" class="text-sm text-gray-700">
                                    {{ $servicio->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('servicios')
                        <span class="text-red-500 text-sm mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="estatus" class="block text-gray-700 font-medium mb-2">Estatus:</label>
                <select name="estatus" id="estatus"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="activo" {{ old('estatus', $categoria->estatus) == 'activo' ? 'selected' : '' }}>Activo
                    </option>
                    <option value="inactivo" {{ old('estatus', $categoria->estatus) == 'inactivo' ? 'selected' : '' }}>
                        Inactivo</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.categorias.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
@stop
