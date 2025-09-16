@extends('layouts.app')

@section('title', 'Crear Ticket - Pepsi')

@section('content')
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header con logo de Pepsi -->
        <div class="mb-6 flex items-center">
            <div class="w-10 h-10 bg-pepsi-blue rounded-full flex items-center justify-center mr-3">
                <span class="text-white font-bold text-lg">P</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Crear Nuevo Ticket</h1>
                <p class="mt-1 text-sm text-gray-600">Complete todos los campos requeridos para crear un nuevo ticket de
                    soporte.</p>
            </div>
        </div>

        <!-- Formulario con colores de Pepsi -->
        <form action="{{ route('tickets.store') }}" method="POST"
            class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            @csrf

            <div class="p-6 space-y-8">
                <!-- Sección de Información Básica -->
                <div class="bg-gradient-to-r from-pepsi-blue/5 to-blue-50 p-5 rounded-lg border border-pepsi-blue/10">
                    <h2 class="text-lg font-semibold text-pepsi-blue flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Información Básica del Ticket
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Campo de Título -->
                        <div class="md:col-span-2">
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                            <input type="text" name="titulo" id="titulo" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors"
                                placeholder="Ingrese el título del ticket">
                        </div>

                        <!-- Campo de Descripción -->
                        <div class="md:col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción
                                *</label>
                            <textarea name="descripcion" id="descripcion" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors"
                                placeholder="Describa detalladamente el problema o solicitud"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección de Clasificación -->
                <div class="bg-gradient-to-r from-pepsi-blue/5 to-blue-50 p-5 rounded-lg border border-pepsi-blue/10">
                    <h2 class="text-lg font-semibold text-pepsi-blue flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Información de Clasificación
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Área y Servicio -->
                        <div>
                            <label for="area_id" class="block text-sm font-medium text-gray-700 mb-1">Área *</label>
                            <select name="area_id" id="area_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione un área</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="servicio_id" class="block text-sm font-medium text-gray-700 mb-1">Servicio *</label>
                            <select name="servicio_id" id="servicio_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione un servicio</option>
                                <!-- Los servicios se cargarán dinámicamente via AJAX -->
                            </select>
                        </div>

                        <!-- Naturaleza y Tipo de Naturaleza -->
                        <div>
                            <label for="naturaleza_id" class="block text-sm font-medium text-gray-700 mb-1">Naturaleza
                                *</label>
                            <select name="naturaleza_id" id="naturaleza_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione la naturaleza</option>
                                @foreach ($naturalezas as $naturaleza)
                                    <option value="{{ $naturaleza->id }}">{{ $naturaleza->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Categoría y Grupo de Trabajo -->
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría
                                *</label>
                            <select name="categoria_id" id="categoria_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="grupo_trabajo_id" class="block text-sm font-medium text-gray-700 mb-1">Grupo de
                                Trabajo *</label>
                            <select name="grupo_trabajo_id" id="grupo_trabajo_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione un grupo</option>
                                @foreach ($gruposTrabajo as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actividad y Responsable -->
                        <div>
                            <label for="actividad_id" class="block text-sm font-medium text-gray-700 mb-1">Actividad
                                *</label>
                            <select name="actividad_id" id="actividad_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione una actividad</option>
                                @foreach ($actividades as $actividad)
                                    <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="responsable_id" class="block text-sm font-medium text-gray-700 mb-1">Responsable
                                *</label>
                            <select name="responsable_id" id="responsable_id" required
                                class="w-full px-4- py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione un responsable</option>
                                @foreach ($responsables as $responsable)
                                    <option value="{{ $responsable->id }}">{{ $responsable->nombre }}
                                        {{ $responsable->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección de Prioridad e Impacto -->
                <div class="bg-gradient-to-r from-pepsi-blue/5 to-blue-50 p-5 rounded-lg border border-pepsi-blue/10">
                    <h2 class="text-lg font-semibold text-pepsi-blue flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Prioridad e Impacto
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <!-- Impacto, Prioridad y Urgencia -->
                        <div>
                            <label for="impacto" class="block text-sm font-medium text-gray-700 mb-1">Impacto *</label>
                            <select name="impacto" id="impacto" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <div>
                            <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad
                                *</label>
                            <select name="prioridad" id="prioridad" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <div>
                            <label for="urgencia" class="block text-sm font-medium text-gray-700 mb-1">Urgencia *</label>
                            <select name="urgencia" id="urgencia" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección de Información Adicional -->
                <div class="bg-gradient-to-r from-pepsi-blue/5 to-blue-50 p-5 rounded-lg border border-pepsi-blue/10">
                    <h2 class="text-lg font-semibold text-pepsi-blue flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Información Adicional
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Fecha de Recepción -->
                        <div>
                            <label for="fecha_recepcion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                Recepción *</label>
                            <input type="datetime-local" name="fecha_recepcion" id="fecha_recepcion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                        </div>

                        <!-- CEDIS -->
                        <div>
                            <label for="cedis_id" class="block text-sm font-medium text-gray-700 mb-1">CEDIS *</label>
                            <select name="cedis_id" id="cedis_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="">Seleccione un CEDIS</option>
                                @foreach ($cedis as $cedi)
                                    <option value="{{ $cedi->id }}">{{ $cedi->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipo de Vía -->
                        <div>
                            <label for="tipo_via" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vía
                                *</label>
                            <select name="tipo_via" id="tipo_via" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                <option value="Correo electrónico">Correo electrónico</option>
                                <option value="Teléfono">Teléfono</option>
                                <option value="Presencial">Presencial</option>
                            </select>
                        </div>

                        <!-- Usuarios a Notificar -->
                        <div>
                            <label for="usuarios_notificar" class="block text-sm font-medium text-gray-700 mb-1">Usuarios
                                a notificar (CC)</label>
                            <select name="usuarios_notificar[]" id="usuarios_notificar" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors">
                                @if (isset($usuarios) && count($usuarios) > 0)
                                    @foreach ($usuarios as $user)
                                        <option value="{{ $user->id }}">{{ $user->nombre }} {{ $user->apellido }}
                                            ({{ $user->email }})</option>
                                    @endforeach
                                @else
                                    <!-- Opción alternativa si no hay usuarios disponibles -->
                                    <option value="">No hay usuarios disponibles</option>
                                @endif
                            </select>
                            <p class="mt-2 text-xs text-gray-500 bg-blue-50 p-2 rounded-md">
                                💡 Mantén presionada la tecla Ctrl (Cmd en Mac) para seleccionar múltiples usuarios
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div
                class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 flex justify-end space-x-4 border-t border-gray-200">
                <a href="{{ route('tickets.index') }}"
                    class="inline-flex items-center px-5 py-3 bg-gray-200 border border-transparent rounded-lg font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center px-5 py-3 bg-pepsi-blue border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pepsi-blue transition-colors shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear Ticket
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar servicios cuando se selecciona un área
            document.getElementById('area_id').addEventListener('change', function() {
                const areaId = this.value;
                const servicioSelect = document.getElementById('servicio_id');

                if (areaId) {
                    fetch(`/api/servicios/${areaId}`)
                        .then(response => response.json())
                        .then(data => {
                            servicioSelect.innerHTML =
                                '<option value="">Seleccione un servicio</option>';
                            data.forEach(servicio => {
                                servicioSelect.innerHTML +=
                                    `<option value="${servicio.id}">${servicio.nombre}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error al cargar servicios:', error);
                            servicioSelect.innerHTML =
                                '<option value="">Error al cargar servicios</option>';
                        });
                } else {
                    servicioSelect.innerHTML = '<option value="">Seleccione un servicio</option>';
                }
            });

            // Cargar tipos de naturaleza cuando se selecciona una naturaleza
            document.getElementById('naturaleza_id').addEventListener('change', function() {
                const naturalezaId = this.value;
                const tipoSelect = document.getElementById('tipo_naturaleza_id');

                if (naturalezaId) {
                    fetch(`/api/tipos-naturaleza/${naturalezaId}`)
                        .then(response => response.json())
                        .then(data => {
                            tipoSelect.innerHTML = '<option value="">Seleccione el tipo</option>';
                            data.forEach(tipo => {
                                tipoSelect.innerHTML +=
                                    `<option value="${tipo.id}">${tipo.nombre}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error al cargar tipos de naturaleza:', error);
                            tipoSelect.innerHTML = '<option value="">Error al cargar tipos</option>';
                        });
                } else {
                    tipoSelect.innerHTML = '<option value="">Seleccione el tipo</option>';
                }
            });

            // Establecer fecha y hora actual por defecto
            const now = new Date();
            const localDateTime = now.toISOString().slice(0, 16);
            document.getElementById('fecha_recepcion').value = localDateTime;

            // Añadir estilos a los selects múltiples
            const multiSelect = document.getElementById('usuarios_notificar');
            if (multiSelect) {
                multiSelect.classList.add('h-32');
            }
        });
    </script>
@endsection
