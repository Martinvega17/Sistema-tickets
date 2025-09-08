@extends('layouts.admin')

@section('title', 'Crear Servicio')

@section('content.dashboard')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center mb-6">
                    <a href="{{ route('admin.servicios.index') }}" class="text-pepsi-blue hover:text-blue-700 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Crear Nuevo Servicio</h2>
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

                <form action="{{ route('admin.servicios.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="area_id" class="block text-sm font-medium text-gray-700 mb-1">Área *</label>
                            <select name="area_id" id="area_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue">
                                <option value="">Seleccione un área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio
                                *</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pepsi-blue focus:border-pepsi-blue"
                                value="{{ old('nombre') }}"
                                placeholder="Ej: Mantenimiento preventivo, Soporte técnico, etc.">
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
                        <a href="{{ route('admin.servicios.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-pepsi-blue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Crear Servicio
                        </button>
                    </div>
                </form>

                <!-- Ejemplos de servicios por área -->
                <div class="mt-8 bg-gray-50 p-4 rounded-md">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Ejemplos de servicios por área:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium text-pepsi-blue">Computo Central:</span>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                <li>Mantenimiento de servidores</li>
                                <li>Gestión de bases de datos</li>
                                <li>Virtualización</li>
                            </ul>
                        </div>
                        <div>
                            <span class="font-medium text-green-600">Redes:</span>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                <li>Configuración de routers</li>
                                <li>Gestión de switches</li>
                                <li>Monitoreo de red</li>
                            </ul>
                        </div>
                        <div>
                            <span class="font-medium text-purple-600">Telefonia:</span>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                <li>Configuración de PBX</li>
                                <li>Soporte a teléfonos IP</li>
                                <li>Gestión de extensiones</li>
                            </ul>
                        </div>
                        <div>
                            <span class="font-medium text-orange-600">Sistemas:</span>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                <li>Desarrollo de software</li>
                                <li>Gestión de aplicaciones</li>
                                <li>Soporte a usuarios</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
