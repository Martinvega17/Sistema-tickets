@extends('layouts.admin')

@section('title')
    Gestión de Usuarios
@endsection


@section('content.dashboard')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-pepsi-blue">Gestión de Usuarios</h1>
        <p class="text-gray-600 mt-2">Selecciona un usuario para editar su información</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Lista de Usuarios -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-pepsi-blue mb-4">Seleccionar Usuario</h2>

                <!-- Búsqueda -->
                <div class="mb-4">
                    <input type="text" id="userSearch" placeholder="Buscar usuario..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                </div>

                <!-- Lista de usuarios -->
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach ($users as $user)
                        <div class="user-item p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors"
                            data-user-id="{{ $user->id }}" onclick="loadUserData({{ $user->id }})">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-pepsi-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">
                                        {{ strtoupper(substr($user->nombre, 0, 1)) }}{{ strtoupper(substr($user->apellido, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->nombre }} {{ $user->apellido }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Formulario de Edición -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-pepsi-blue mb-6">Información del Usuario</h2>

                <form id="userForm" class="space-y-6">
                    <input type="hidden" id="user_id" name="id">

                    <!-- Mensaje inicial -->
                    <div id="initialMessage" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-gray-500">Selecciona un usuario de la lista para editar su información</p>
                    </div>

                    <!-- Formulario (oculto inicialmente) -->
                    <div id="userFormContent" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Columna izquierda -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-pepsi-blue border-b pb-2">Información Personal</h3>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="text-pepsi-red">*</span> Nombre
                                    </label>
                                    <input type="text" id="nombre" name="nombre"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="text-pepsi-red">*</span> Apellido
                                    </label>
                                    <input type="text" id="apellido" name="apellido"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="text-pepsi-red">*</span> Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="text-pepsi-red">*</span> Número de Nómina
                                    </label>
                                    <input type="text" id="numero_nomina" name="numero_nomina"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <input type="tel" id="telefono" name="telefono"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-pepsi-blue border-b pb-2">Información Corporativa</h3>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="text-pepsi-red">*</span> Rol
                                    </label>
                                    <select id="rol_id" name="rol_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent"
                                        required>
                                        <option value="">Seleccionar rol</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                                    <input type="text" id="empresa" name="empresa" value="GEPP"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent bg-gray-50"
                                        readonly>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">País</label>
                                    <input type="text" id="pais" name="pais" value="México"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent bg-gray-50"
                                        readonly>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                        <select id="estado" name="estado"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                                            <option value="">Seleccionar estado</option>
                                            <option value="San Luis Potosí">San Luis Potosí</option>
                                            <!-- Agrega más estados según necesites -->
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                                        <select id="ciudad" name="ciudad"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                                            <option value="">Seleccionar ciudad</option>
                                            <option value="San Luis Potosí">San Luis Potosí</option>
                                            <!-- Agrega más ciudades según necesites -->
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                                    <select id="departamento" name="departamento"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                                        <option value="">Seleccionar departamento</option>
                                        <option value="General">General</option>
                                        <option value="Tecnico">Técnico</option>
                                        <!-- Agrega más departamentos según necesites -->
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                                    <select id="cargo" name="cargo"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                                        <option value="">Seleccionar cargo</option>
                                        <option value="Tecnico">Técnico</option>
                                        <!-- Agrega más cargos según necesites -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Sección para cambiar contraseña -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-pepsi-blue mb-4">Cambiar Contraseña</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nueva Contraseña
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="nueva_password" name="nueva_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent pr-10"
                                            placeholder="Dejar vacío para no cambiar">
                                        <button type="button"
                                            class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('nueva_password')">
                                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirmar Contraseña
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="nueva_password_confirmation"
                                            name="nueva_password_confirmation"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent pr-10"
                                            placeholder="Confirmar nueva contraseña">
                                        <button type="button"
                                            class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('nueva_password_confirmation')">
                                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-2">La contraseña debe tener al menos 8 caracteres. Dejar
                                vacío si no deseas cambiarla.</p>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" onclick="resetForm()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition-colors font-medium">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir el archivo JavaScript externo -->
    <script src="{{ asset('js/user-management.js') }}"></script>

    <style>
        .user-item {
            transition: all 0.2s ease;
        }

        .user-item:hover {
            transform: translateX(2px);
        }

        /* Estilos para selects */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        select:focus {
            outline: none;
            ring: 2px;
            ring-color: #004B93;
            border-color: #004B93;
        }
    </style>
@endsection
