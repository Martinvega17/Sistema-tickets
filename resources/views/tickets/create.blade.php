@extends('layouts.admin')

@section('title', 'Crear Nuevo Ticket')

@section('content.dashboard')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Crear Nuevo Ticket</h2>
                        <p class="text-sm text-gray-500 mt-1">Reporte un problema o solicite soporte técnico</p>
                    </div>
                    <a href="{{ route('tickets.index') }}"
                        class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al listado
                    </a>
                </div>

                <!-- Información del usuario actual -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Información del solicitante</h3>
                    <p class="text-sm text-blue-700">
                        <strong>Usuario:</strong> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}<br>
                        <strong>Nómina:</strong> {{ Auth::user()->numero_nomina }}<br>
                        <strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Form Section -->
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Información Básica -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Información del Reporte</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título del Reporte <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="titulo" value="{{ old('titulo') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('titulo') border-red-500 @enderror"
                                placeholder="Ej: Problema con equipo de cómputo, Solicitud de software, etc.">
                            @error('titulo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Detallada <span
                                    class="text-red-500">*</span></label>
                            <textarea name="descripcion" rows="5" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('descripcion') border-red-500 @enderror"
                                placeholder="Describa detalladamente el problema o solicitud. Incluya cualquier información que pueda ayudar a resolverlo más rápido.">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ubicación -->
                        <div class="md:col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Ubicación del Problema</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región <span
                                    class="text-red-500">*</span></label>
                            <select name="region_id" id="region_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('region_id') border-red-500 @enderror">
                                <option value="">Seleccione la región</option>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">CEDIS/Planta <span
                                    class="text-red-500">*</span></label>
                            <select name="cedis_id" id="cedis_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('cedis_id') border-red-500 @enderror">
                                <option value="">Primero seleccione una región</option>
                                <!-- Los CEDIS se cargarán via AJAX según la región seleccionada -->
                            </select>
                            @error('cedis_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Área <span
                                    class="text-red-500">*</span></label>
                            <select name="area_id" id="area_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('area_id') border-red-500 @enderror">
                                <option value="">Seleccione el área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Servicio</label>
                            <select name="servicio_id" id="servicio_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('servicio_id') border-red-500 @enderror">
                                <option value="">Seleccione el servicio</option>
                                <!-- Los servicios se cargarán via AJAX según el área seleccionada -->
                            </select>
                            @error('servicio_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información Adicional -->
                        <div class="md:col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Información Adicional</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Adicionales
                                (Opcional)</label>
                            <textarea name="observaciones" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border @error('observaciones') border-red-500 @enderror"
                                placeholder="Agregue cualquier información adicional que considere relevante.">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información sobre el proceso -->
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
                        <h3 class="text-sm font-medium text-green-800 mb-2">¿Qué sucede después?</h3>
                        <ul class="text-sm text-green-700 list-disc list-inside space-y-1">
                            <li>El ticket será asignado automáticamente a Mesa de Control (Rol 2)</li>
                            <li>Mesa de Control revisará y asignará al ingeniero correspondiente según la región</li>
                            <li>Recibirá notificaciones sobre el progreso de su ticket</li>
                            <li>Puede consultar el estatus en cualquier momento desde esta plataforma</li>
                        </ul>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col-reverse md:flex-row md:justify-end md:space-x-3 space-y-3 md:space-y-0 pt-6 border-t border-gray-200">
                        <a href="{{ route('tickets.index') }}"
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
                            Crear Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para cargar CEDIS y servicios dinámicamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const regionSelect = document.querySelector('select[name="region_id"]');
            const cedisSelect = document.querySelector('select[name="cedis_id"]');
            const areaSelect = document.querySelector('select[name="area_id"]');
            const servicioSelect = document.querySelector('select[name="servicio_id"]');

            // Función para cargar CEDIS por región
            function cargarCedisPorRegion(regionId) {
                // Limpiar CEDIS
                cedisSelect.innerHTML = '<option value="">Cargando CEDIS...</option>';
                cedisSelect.disabled = true;

                if (regionId) {
                    fetch(`/cedis-por-region/${regionId}`)
                        .then(response => response.json())
                        .then(cedis => {
                            cedisSelect.innerHTML = '<option value="">Seleccione el CEDIS/Planta</option>';

                            if (cedis.length === 0) {
                                cedisSelect.innerHTML = '<option value="">No hay CEDIS en esta región</option>';
                            } else {
                                cedis.forEach(cedi => {
                                    const option = document.createElement('option');
                                    option.value = cedi.id;
                                    option.textContent = cedi.nombre;
                                    cedisSelect.appendChild(option);
                                });
                            }
                            cedisSelect.disabled = false;

                            // Seleccionar CEDIS anterior si existe (en caso de error de validación)
                            @if (old('cedis_id'))
                                setTimeout(() => {
                                    cedisSelect.value = "{{ old('cedis_id') }}";
                                }, 100);
                            @endif
                        })
                        .catch(error => {
                            console.error('Error al cargar CEDIS:', error);
                            cedisSelect.innerHTML = '<option value="">Error al cargar CEDIS</option>';
                            cedisSelect.disabled = false;
                        });
                } else {
                    cedisSelect.innerHTML = '<option value="">Primero seleccione una región</option>';
                    cedisSelect.disabled = false;
                }
            }

            // Función para cargar servicios por área
            function cargarServiciosPorArea(areaId) {
                // Limpiar servicios
                servicioSelect.innerHTML = '<option value="">Cargando servicios...</option>';
                servicioSelect.disabled = true;

                if (areaId) {
                    fetch(`/api/servicios/${areaId}`)
                        .then(response => response.json())
                        .then(servicios => {
                            servicioSelect.innerHTML = '<option value="">Seleccione el servicio</option>';

                            if (servicios.length === 0) {
                                servicioSelect.innerHTML =
                                    '<option value="">No hay servicios en esta área</option>';
                            } else {
                                servicios.forEach(servicio => {
                                    const option = document.createElement('option');
                                    option.value = servicio.id;
                                    option.textContent = servicio.nombre;
                                    servicioSelect.appendChild(option);
                                });
                            }
                            servicioSelect.disabled = false;

                            // Seleccionar servicio anterior si existe (en caso de error de validación)
                            @if (old('servicio_id'))
                                setTimeout(() => {
                                    servicioSelect.value = "{{ old('servicio_id') }}";
                                }, 100);
                            @endif
                        })
                        .catch(error => {
                            console.error('Error al cargar servicios:', error);
                            servicioSelect.innerHTML = '<option value="">Error al cargar servicios</option>';
                            servicioSelect.disabled = false;
                        });
                } else {
                    servicioSelect.innerHTML = '<option value="">Seleccione el servicio</option>';
                    servicioSelect.disabled = false;
                }
            }

            // Event listeners
            if (regionSelect && cedisSelect) {
                regionSelect.addEventListener('change', function() {
                    cargarCedisPorRegion(this.value);
                });
            }

            if (areaSelect && servicioSelect) {
                areaSelect.addEventListener('change', function() {
                    cargarServiciosPorArea(this.value);
                });
            }

            // Cargar datos iniciales si hay valores en old (en caso de error de validación)
            @if (old('region_id'))
                // Cargar CEDIS de la región seleccionada
                cargarCedisPorRegion("{{ old('region_id') }}");
            @endif

            @if (old('area_id'))
                // Cargar servicios del área seleccionada
                cargarServiciosPorArea("{{ old('area_id') }}");
            @endif
        });
    </script>
@endsection
