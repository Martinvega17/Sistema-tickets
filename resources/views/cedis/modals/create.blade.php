@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Crear Nuevo CEDIS</h1>
                <p class="text-gray-600 mt-2">Complete la información para registrar un nuevo Centro de Distribución</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <form action="{{ route('cedis.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Responsable -->
                        <div>
                            <label for="responsable"
                                class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                            <input type="text" id="responsable" name="responsable" value="{{ old('responsable') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                            @error('responsable')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Región -->
                        <div>
                            <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Región *</label>
                            <select id="region_id" name="region_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                                <option value="">Seleccionar región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}"
                                        {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ingeniero de Soporte -->
                        <div>
                            <label for="ingeniero_id" class="block text-sm font-medium text-gray-700 mb-2">Ingeniero de
                                Soporte</label>
                            <select id="ingeniero_id" name="ingeniero_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                                <option value="">Sin asignar</option>
                                @foreach ($ingenieros as $ingeniero)
                                    <option value="{{ $ingeniero->id }}"
                                        {{ old('ingeniero_id') == $ingeniero->id ? 'selected' : '' }}>
                                        {{ $ingeniero->name }} {{ $ingeniero->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ingeniero_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estatus -->
                        <div>
                            <label for="estatus" class="block text-sm font-medium text-gray-700 mb-2">Estatus *</label>
                            <select id="estatus" name="estatus" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">
                                <option value="activo" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('estatus')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mt-6">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150 ease-in-out">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end mt-8 space-x-4">
                        <a href="{{ route('cedis.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition duration-150 ease-in-out">
                            Crear CEDIS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir estilos para selects -->
    <style>
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
@endsection
