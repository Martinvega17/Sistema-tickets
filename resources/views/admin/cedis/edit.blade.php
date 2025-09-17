@extends('layouts.admin')

@section('title', 'Editar CEDIS')

@section('content.dashboard')
    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Editar CEDIS</h2>
                        <p class="text-sm text-gray-500 mt-1">Actualice la información del centro de distribución</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $cedis->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($cedis->estatus) }}
                        </span>
                    </div>
                </div>

                <!-- Form Section -->
                <form action="{{ route('admin.cedis.update', $cedis->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región <span
                                    class="text-red-500">*</span></label>
                            <select name="region_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('region_id') border-red-500 @enderror">
                                <option value="">Seleccione una región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}"
                                        {{ old('region_id', $cedis->region_id) == $region->id ? 'selected' : '' }}>
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
                            <input type="text" name="nombre" value="{{ old('nombre', $cedis->nombre) }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('nombre') border-red-500 @enderror"
                                placeholder="Nombre del CEDIS">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <textarea name="direccion" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('direccion') border-red-500 @enderror"
                                placeholder="Dirección completa del CEDIS">{{ old('direccion', $cedis->direccion) }}</textarea>
                            @error('direccion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $cedis->telefono) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('telefono') border-red-500 @enderror"
                                placeholder="Número de teléfono">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                            <input type="text" name="responsable" value="{{ old('responsable', $cedis->responsable) }}"
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
                                <option value="activo" {{ old('estatus', $cedis->estatus) == 'activo' ? 'selected' : '' }}>
                                    Activo</option>
                                <option value="inactivo"
                                    {{ old('estatus', $cedis->estatus) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar CEDIS
                        </button>
                    </div>
                </form>

                <!-- Additional Information Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información del CEDIS
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="bg-gray-50 p-3 rounded-md">
                            <div class="text-xs text-gray-500 uppercase font-medium mb-1">Creado</div>
                            <div class="text-gray-700">{{ $cedis->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <div class="text-xs text-gray-500 uppercase font-medium mb-1">Última actualización</div>
                            <div class="text-gray-700">{{ $cedis->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @if ($cedis->tickets()->count() > 0)
                            <div class="md:col-span-2 bg-blue-50 p-3 rounded-md">
                                <div class="text-xs text-blue-500 uppercase font-medium mb-1">Tickets asociados</div>
                                <div class="text-blue-700">{{ $cedis->tickets()->count() }} ticket(s) vinculados</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
