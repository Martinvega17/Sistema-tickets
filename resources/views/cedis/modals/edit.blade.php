@extends('layouts.admin')

@section('content.dashboard')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Editar CEDIS</h1>
                <p class="text-gray-600 mt-2">Modifique la información del Centro de Distribución</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <form id="editCedisForm" class="p-6">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_cedis_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del CEDIS *</label>
                            <input type="text" id="edit_nombre" name="nombre" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150"
                                placeholder="Ingrese el nombre del CEDIS">
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="tel" id="edit_telefono" name="telefono"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150"
                                placeholder="Número de teléfono">
                        </div>

                        <!-- Responsable -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                            <input type="text" id="edit_responsable" name="responsable"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150"
                                placeholder="Nombre del responsable">
                        </div>

                        <!-- Región -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región *</label>
                            <select id="edit_region_id" name="region_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150">
                                <option value="">Seleccionar región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ingeniero de Soporte -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ingeniero de Soporte</label>
                            <select id="edit_ingeniero_id" name="ingeniero_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150">
                                <option value="">Sin asignar</option>
                                @foreach ($ingenieros as $ingeniero)
                                    <option value="{{ $ingeniero->id }}">
                                        {{ $ingeniero->name }} {{ $ingeniero->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Estatus -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estatus *</label>
                            <select id="edit_estatus" name="estatus" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                        <textarea id="edit_direccion" name="direccion" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition duration-150"
                            placeholder="Dirección completa del CEDIS"></textarea>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end mt-8 space-x-4">
                        <a href="{{ route('cedis.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition duration-150">
                            <i class="bi bi-check-circle mr-2"></i> Actualizar CEDIS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir JavaScript para el formulario de edición -->
    <script>
        // Función segura para obtener el token CSRF
        function getCsrfToken() {
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.content;
            }
            console.error('CSRF token meta tag not found');
            return '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Cargar datos del CEDIS
            const cedisId = {{ $cedis->id }};
            loadCedisData(cedisId);

            // Manejar envío del formulario
            document.getElementById('editCedisForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                await handleEditCedis(e);
            });
        });

        async function loadCedisData(cedisId) {
            try {
                const response = await fetch(`/cedis/${cedisId}`);

                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }

                const cedis = await response.json();

                // Llenar el formulario
                document.getElementById('edit_cedis_id').value = cedis.id;
                document.getElementById('edit_nombre').value = cedis.nombre;
                document.getElementById('edit_telefono').value = cedis.telefono || '';
                document.getElementById('edit_responsable').value = cedis.responsable || '';
                document.getElementById('edit_region_id').value = cedis.region_id;
                document.getElementById('edit_ingeniero_id').value = cedis.ingeniero_id || '';
                document.getElementById('edit_estatus').value = cedis.estatus;
                document.getElementById('edit_direccion').value = cedis.direccion || '';

            } catch (error) {
                console.error('Error al cargar datos del CEDIS:', error);
                alert('Error al cargar los datos del CEDIS: ' + error.message);
            }
        }

        async function handleEditCedis(e) {
            try {
                e.preventDefault(); // ← AÑADIR ESTO
                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());
                const cedisId = data.id;

                const response = await fetch(`/cedis/${cedisId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || `Error HTTP: ${response.status}`);
                }

                const result = await response.json();
                alert(result.message || 'CEDIS actualizado correctamente');

                // Redirigir al índice
                window.location.href = "{{ route('cedis.index') }}";
            } catch (error) {
                console.error('Error al actualizar CEDIS:', error);
                alert('Error al actualizar el CEDIS: ' + error.message);
            }
        }
    </script>

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
