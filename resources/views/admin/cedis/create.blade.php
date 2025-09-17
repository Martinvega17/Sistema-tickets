@extends('layouts.admin')

@section('title', 'Crear CEDIS')

@section('content.dashboard')
    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Crear Nuevo CEDIS</h2>
                        <p class="text-sm text-gray-500 mt-1">Complete la información para registrar un nuevo centro de
                            distribución</p>
                    </div>
                    <a href="{{ route('admin.cedis.index') }}"
                        class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al listado
                    </a>
                </div>

                <!-- Form Section -->
                <form action="{{ route('admin.cedis.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región <span
                                    class="text-red-500">*</span></label>
                            <select name="region_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('region_id') border-red-500 @enderror">
                                <option value="">Seleccione una región</option>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('nombre') border-red-500 @enderror"
                                placeholder="Ingrese el nombre del CEDIS">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <textarea name="direccion" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('direccion') border-red-500 @enderror"
                                placeholder="Ingrese la dirección completa del CEDIS">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('telefono') border-red-500 @enderror"
                                placeholder="Ej: +1 234 567 8900">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                            <input type="text" name="responsable" value="{{ old('responsable') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('responsable') border-red-500 @enderror"
                                placeholder="Nombre del responsable">
                            @error('responsable')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estatus <span
                                    class="text-red-500">*</span></label>
                            <select name="estatus" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('estatus') border-red-500 @enderror">
                                <option value="activo" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('estatus')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col-reverse md:flex-row md:justify-end md:space-x-3 space-y-3 md:space-y-0 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.cedis.index') }}"
                            class="inline-flex justify-center items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Crear CEDIS
                        </button>
                    </div>
                </form>

                <!-- Help Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información importante
                    </h3>
                    <div class="bg-blue-50 p-4 rounded-md">
                        <ul class="list-disc list-inside space-y-2 text-sm text-blue-700">
                            <li>Los campos marcados con <span class="text-red-500">*</span> son obligatorios</li>
                            <li>Asegúrese de que el nombre del CEDIS sea único en el sistema</li>
                            <li>El estatus "Activo" permitirá que el CEDIS esté disponible para su uso inmediato</li>
                            <li>Puede cambiar el estatus en cualquier momento desde la opción de edición</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
