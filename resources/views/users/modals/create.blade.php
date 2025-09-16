@extends('layouts.admin')

@section('title')
    Crear Nuevo Usuario
@endsection

@section('content.dashboard')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-pepsi-blue">Crear Nuevo Usuario</h1>
        <p class="text-gray-600 mt-2">Completa la información para registrar un nuevo usuario</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <form id="createUserForm" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna izquierda -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-pepsi-blue border-b pb-2">Información Personal</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Nombre
                        </label>
                        <input type="text" name="nombre" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Apellido
                        </label>
                        <input type="text" name="apellido" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Email
                        </label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Número de Nómina
                        </label>
                        <input type="text" name="numero_nomina" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="tel" name="telefono"
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
                        <select name="rol_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                            <option value="">Seleccionar rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Región</label>
                        <select name="region_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                            <option value="">Seleccionar región</option>
                            @foreach ($regiones as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CEDIS</label>
                        <select name="cedis_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                            <option value="">Seleccionar CEDIS</option>
                            @foreach ($cedis as $cedi)
                                <option value="{{ $cedi->id }}">{{ $cedi->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-pepsi-red">*</span> Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent pr-10"
                                placeholder="Ingresa la contraseña">
                            <button type="button" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                onclick="togglePassword(this)">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <span class="text-pepsi-red">*</span> Confirmar Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent pr-10"
                                placeholder="Confirma la contraseña">
                            <button type="button" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                onclick="togglePassword(this)">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('usuarios.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition-colors font-medium">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('.eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Manejar el envío del formulario
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('usuarios.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        // Mostrar errores de validación
                        alert('Por favor, corrige los errores en el formulario.');
                        console.error(data.errors);
                    } else {
                        alert('Usuario creado correctamente');
                        window.location.href = '{{ route('usuarios.index') }}';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al crear el usuario');
                });
        });
    </script>
@endsection
