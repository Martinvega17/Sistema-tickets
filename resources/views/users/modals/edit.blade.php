<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-xl border-0 shadow-xl">
            <!-- Header -->
            <div class="modal-header bg-pepsi-blue text-white rounded-t-xl p-6">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h5 class="modal-title text-xl font-bold">Editar Usuario</h5>
                    </div>
                    <button type="button" class="text-white hover:text-gray-200 transition-colors"
                        data-bs-dismiss="modal" aria-label="Close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <form id="editUserForm">
                <div class="modal-body p-6 bg-gray-50">
                    <input type="hidden" id="edit_user_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-pepsi-red">*</span> Nombre
                            </label>
                            <input type="text" id="edit_nombre" name="nombre"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors"
                                placeholder="Ingresa el nombre" required>
                        </div>

                        <!-- Apellido -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-pepsi-red">*</span> Apellido
                            </label>
                            <input type="text" id="edit_apellido" name="apellido"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors"
                                placeholder="Ingresa el apellido" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Email
                        </label>
                        <input type="email" id="edit_email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors"
                            placeholder="usuario@pepsi.com" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Rol -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-pepsi-red">*</span> Rol
                            </label>
                            <select id="edit_rol_id" name="rol_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors appearance-none bg-white"
                                required>
                                <option value="">Seleccionar rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Región -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                            <select id="edit_region_id" name="region_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors appearance-none bg-white">
                                <option value="">Seleccionar región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- CEDIS -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CEDIS</label>
                            <select id="edit_cedis_id" name="cedis_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent transition-colors appearance-none bg-white">
                                <option value="">Seleccionar CEDIS</option>
                                @foreach ($cedis as $cedi)
                                    <option value="{{ $cedi->id }}">{{ $cedi->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-white rounded-b-xl p-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3 w-full">
                        <button type="button"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition-colors font-medium">
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
