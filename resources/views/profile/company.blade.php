@php
    $rolId = auth()->user()->rol_id;
    $isAdminDashboard = in_array($rolId, [1, 2]); // Admin y Supervisor
    $layout = $isAdminDashboard ? 'layouts.admin' : 'layouts.app';
    $section = $isAdminDashboard ? 'content.dashboard' : 'content';
@endphp

@extends($layout)

@section($section)
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Configuración de Perfil</h1>
                <p class="text-sm text-gray-600 mt-2">Gestiona la información de tu empresa</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Menú lateral mejorado -->
                <div class="w-full lg:w-80 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Panel de Configuración</h2>
                        </div>
                        <nav class="p-2">
                            <a href="{{ route('profile.personal') }}"
                                class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all duration-200 group mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <span>Datos Personales</span>
                                <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs"></i>
                            </a>

                            <a href="{{ route('profile.company') }}"
                                class="flex items-center px-4 py-3 rounded-lg bg-blue-50 text-blue-700 font-medium transition-all duration-200 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-building text-blue-600 text-sm"></i>
                                </div>
                                <span>Información de Empresa</span>
                                <i class="fas fa-chevron-right ml-auto text-blue-400 text-xs"></i>
                            </a>

                            <a href="{{ route('profile.password') }}"
                                class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all duration-200 group mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-lock text-gray-600 text-sm"></i>
                                </div>
                                <span>Cambiar Contraseña</span>
                                <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Tarjeta de información del usuario -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 p-5">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full mx-auto flex items-center justify-center text-white text-xl font-bold mb-3">
                                {{ substr($user->nombre, 0, 1) }}{{ substr($user->apellido, 0, 1) }}
                            </div>
                            <h3 class="font-semibold text-gray-800">{{ $user->nombre }} {{ $user->apellido }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
                            <div class="mt-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $user->rol->nombre }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido principal mejorado -->
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-building text-blue-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800">Información de Empresa</h2>
                                    <p class="text-sm text-gray-600 mt-1">Asegúrate de que los datos de tu empresa estén
                                        correctos para una mejor comunicación</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <form id="companyDataForm" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Empresa *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-building text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="empresa" value="{{ $user->empresa }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">País *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-globe-americas text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="pais" value="{{ $user->pais ?? 'México' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        </div>
                                        <input type="text"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="ubicacion" value="{{ $user->ubicacion ?? 'Todo México' }}"
                                            {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-city text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="ciudad" value="{{ $user->ciudad }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-map text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="estado" value="{{ $user->estado }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-sitemap text-gray-400"></i>
                                        </div>
                                        <input type="text"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="departamento" value="{{ $user->departamento ?? 'General' }}"
                                            {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Piso</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-layer-group text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="piso" value="{{ $user->piso ?? 'N/A' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Torre</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-building text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="torre" value="{{ $user->torre ?? 'N/A' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Cargo *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-briefcase text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="cargo" value="{{ $user->cargo ?? 'Tecnico' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Centro de Costos
                                            *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-dollar-sign text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="centro_costos" value="{{ $user->centro_costos ?? 'Default' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                                    <div class="pt-4 border-t border-gray-200 flex justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-sm hover:shadow-md">
                                            <i class="fas fa-save mr-2"></i>
                                            Guardar Cambios
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Información de la empresa</h3>
                                    <p class="mt-1 text-sm text-blue-600">Solo usuarios administradores y supervisores
                                        pueden modificar esta información.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-alt text-gray-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-800">Datos corporativos</h3>
                                    <p class="mt-1 text-sm text-gray-600">Esta información se utiliza para reportes y
                                        comunicación interna dentro de la organización.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar envío del formulario de datos de empresa
            const companyForm = document.getElementById('companyDataForm');
            if (companyForm) {
                companyForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Mostrar estado de carga
                    const submitBtn = companyForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...';
                        submitBtn.disabled = true;
                    }

                    fetch('{{ route('profile.updateCompany') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: new URLSearchParams(new FormData(this))
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.message) {
                                showNotification('success', data.message);
                            } else if (data.error) {
                                showNotification('error', data.error);
                            } else if (data.errors) {
                                for (const key in data.errors) {
                                    showNotification('error', data.errors[key][0]);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error al actualizar los datos');
                        })
                        .finally(() => {
                            // Restaurar estado del botón
                            if (submitBtn) {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            }
                        });
                });
            }

            // Función para mostrar notificaciones mejorada
            // Función para mostrar notificación mejorada con Tailwind
            function showNotification(type, message) {
                // Crear elemento de notificación si no existe
                let notification = document.getElementById('custom-notification');
                if (!notification) {
                    notification = document.createElement('div');
                    notification.id = 'custom-notification';
                    notification.className = 'fixed top-4 right-4 z-50 max-w-sm w-full';
                    document.body.appendChild(notification);
                }

                const borderColors = {
                    'success': 'border-green-500',
                    'error': 'border-red-500',
                    'warning': 'border-yellow-500',
                    'info': 'border-blue-500'
                };

                const icons = {
                    'success': '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                    'error': '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    'warning': '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
                    'info': '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                };

                const title = type === 'success' ? 'Éxito' : type === 'error' ? 'Error' : type === 'warning' ?
                    'Advertencia' : 'Información';

                notification.innerHTML = `
        <div class="bg-white rounded-lg shadow-lg border-l-4 ${borderColors[type]} p-4 transform transition-all duration-300 translate-x-0 opacity-100">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${icons[type]}
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-900">${title}</h3>
                    <p class="text-sm text-gray-600">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;

                // Ocultar automáticamente después de 5 segundos
                setTimeout(() => {
                    if (notification.innerHTML) {
                        notification.querySelector('div').classList.add('translate-x-full', 'opacity-0');
                        setTimeout(() => notification.innerHTML = '', 300);
                    }
                }, 5000);
            }
        });
    </script>
@endsection
