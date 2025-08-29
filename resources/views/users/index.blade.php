@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-pepsi-blue">Gestión de Usuarios</h1>
        <p class="text-gray-600 mt-2">Administra los usuarios del sistema</p>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-200">
        <form action="{{ route('usuarios.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Búsqueda -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, email o nómina"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
            </div>

            <!-- Filtro por Rol -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                <select name="rol"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" {{ request('rol') == $rol->id ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Estatus -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estatus</label>
                <select name="estatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-blue focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="1" {{ request('estatus') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('estatus') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex items-end space-x-2">
                <button type="submit"
                    class="bg-pepsi-blue text-white px-4 py-2 rounded-lg hover:bg-pepsi-dark-blue transition-colors">
                    Filtrar
                </button>
                <a href="{{ route('usuarios.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Región/CEDIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-pepsi-red rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->nombre, 0, 1)) }}{{ strtoupper(substr($user->apellido, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->nombre }}
                                            {{ $user->apellido }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->numero_nomina }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full 
                            @if ($user->rol_id == 1) bg-red-100 text-red-800
                            @elseif($user->rol_id == 2) bg-blue-100 text-blue-800
                            @elseif($user->rol_id == 3) bg-green-100 text-green-800
                            @elseif($user->rol_id == 4) bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                                    {{ $user->rol->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $user->region->nombre ?? 'N/A' }}</div>
                                <div class="text-xs">{{ $user->cedis->nombre ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $user->estatus ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->estatus ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if (auth()->user()->rol_id == 1)
                                        <!-- Editar usuario -->
                                        <button onclick="editUser({{ $user }})"
                                            class="text-pepsi-blue hover:text-pepsi-dark-blue">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Restablecer contraseña -->
                                    @if (auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                                        <button onclick="resetPassword({{ $user->id }})"
                                            class="text-pepsi-red hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Activar/Desactivar -->
                                    @if (auth()->user()->rol_id == 1)
                                        <button onclick="toggleStatus({{ $user->id }}, {{ $user->estatus }})"
                                            class="{{ $user->estatus ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if ($user->estatus)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @endif
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modales -->
    @include('users.modals.edit')
    @include('users.modals.password')

    <script>
        // Funciones JavaScript para los modales y acciones
        function editUser(user) {
            // Llenar el modal de edición con los datos del usuario
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_nombre').value = user.nombre;
            document.getElementById('edit_apellido').value = user.apellido;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_rol_id').value = user.rol_id;
            document.getElementById('edit_region_id').value = user.region_id;
            document.getElementById('edit_cedis_id').value = user.cedis_id;

            // Mostrar el modal
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }

        function resetPassword(userId) {
            document.getElementById('reset_user_id').value = userId;
            document.getElementById('reset_password').value = '';
            document.getElementById('reset_password_confirmation').value = '';
            new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
        }

        function toggleStatus(userId, currentStatus) {
            if (confirm('¿Estás seguro de ' + (currentStatus ? 'desactivar' : 'activar') + ' este usuario?')) {
                fetch(`/usuarios/${userId}/estatus`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            estatus: currentStatus ? 0 : 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            location.reload();
                        }
                    });
            }
        }
    </script>

    <!-- Cargar Bootstrap JS si no está cargado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
