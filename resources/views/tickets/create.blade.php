{{-- resources/views/tickets/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Nuevo Ticket')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Crear Nuevo Ticket
                            </h1>
                            <p class="text-gray-600 mt-1">Complete la información básica para crear un nuevo ticket de
                                soporte</p>
                        </div>
                        <a href="{{ route('tickets.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg flex items-center transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario Simplificado -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Información del Ticket</h2>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Región y CEDIS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Región <span class="text-red-500">*</span>
                            </label>
                            <select id="region_id" name="region_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar Región</option>
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
                            <label for="cedis_id" class="block text-sm font-medium text-gray-700 mb-2">
                                CEDIS <span class="text-red-500">*</span>
                            </label>
                            <select id="cedis_id" name="cedis_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Primero seleccione una región</option>
                            </select>
                            @error('cedis_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Título -->
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">
                            Título del Ticket <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Ej: Formateo de laptop L480">
                        @error('titulo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción Detallada <span class="text-red-500">*</span>
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="6" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Describa detalladamente el problema o solicitud...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categorización Básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                            <select id="area_id" name="area_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="servicio_id" class="block text-sm font-medium text-gray-700 mb-2">Servicio</label>
                            <select id="servicio_id" name="servicio_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}"
                                        {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                        {{ $servicio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Categorización Adicional -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select id="categoria_id" name="categoria_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="naturaleza_id"
                                class="block text-sm font-medium text-gray-700 mb-2">Naturaleza</label>
                            <select id="naturaleza_id" name="naturaleza_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar naturaleza</option>
                                @foreach ($naturalezas as $naturaleza)
                                    <option value="{{ $naturaleza->id }}"
                                        {{ old('naturaleza_id') == $naturaleza->id ? 'selected' : '' }}>
                                        {{ $naturaleza->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones
                            Adicionales</label>
                        <textarea id="observaciones" name="observaciones" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Observaciones adicionales o información complementaria...">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <!-- Footer del Formulario -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="text-sm text-gray-600">
                            Los campos marcados con <span class="text-red-500">*</span> son obligatorios.
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('tickets.index') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Crear Ticket
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {{-- AL FINAL DEL CONTENIDO, ANTES DE CERRAR EL DIV --}}
        </div>{{-- Cierre del container --}}




    </div>

    <!-- Información para el usuario -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Proceso de atención</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Una vez creado el ticket, será revisado por Mesa de Control quien lo asignará al personal de
                        soporte correspondiente.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

