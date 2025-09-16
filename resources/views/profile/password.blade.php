@extends('layouts.admin')

@section('content.dashboard')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Configuración de Perfil</h1>
                <p class="text-sm text-gray-600 mt-2">Gestiona la seguridad de tu cuenta</p>
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
                                class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-all duration-200 group mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-building text-gray-600 text-sm"></i>
                                </div>
                                <span>Información de Empresa</span>
                                <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs"></i>
                            </a>

                            <a href="{{ route('profile.password') }}"
                                class="flex items-center px-4 py-3 rounded-lg bg-blue-50 text-blue-700 font-medium transition-all duration-200 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-lock text-blue-600 text-sm"></i>
                                </div>
                                <span>Cambiar Contraseña</span>
                                <i class="fas fa-chevron-right ml-auto text-blue-400 text-xs"></i>
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
                                    <i class="fas fa-lock text-blue-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800">Cambiar Contraseña</h2>
                                    <p class="text-sm text-gray-600 mt-1">Protege tu cuenta con una contraseña segura y
                                        actualizada</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <form id="passwordForm" class="space-y-6">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input type="password"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="current_password" required placeholder="Ingresa tu contraseña actual">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="new_password" required minlength="8"
                                            placeholder="Crea una nueva contraseña">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">La contraseña debe tener al menos 8 caracteres,
                                        incluyendo letras y números.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva
                                        Contraseña</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="new_password_confirmation" required
                                            placeholder="Confirma tu nueva contraseña">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Indicador de fortaleza de contraseña -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Requisitos de seguridad</h4>
                                    <ul class="text-xs text-gray-600 space-y-1">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Mínimo 8 caracteres
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Letras y números
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Diferente a la contraseña anterior
                                        </li>
                                    </ul>
                                </div>

                                <div class="pt-4 border-t border-gray-200 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-sm hover:shadow-md">
                                        <i class="fas fa-key mr-2"></i>
                                        Cambiar Contraseña
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-alt text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Seguridad de la cuenta</h3>
                                    <p class="mt-1 text-sm text-blue-600">Te recomendamos cambiar tu contraseña
                                        regularmente y no compartirla con nadie.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-lightbulb text-gray-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-800">Consejos de seguridad</h3>
                                    <p class="mt-1 text-sm text-gray-600">Usa una combinación de letras, números y
                                        símbolos. Evita información personal fácil de adivinar.</p>
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
            // Manejar envío del formulario de cambio de contraseña
            const passwordForm = document.getElementById('passwordForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Mostrar estado de carga
                    const submitBtn = passwordForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Cambiando...';
                    submitBtn.disabled = true;

                    fetch('{{ route('profile.updatePassword') }}', {
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
                                this.reset();
                            } else if (data.errors) {
                                for (const key in data.errors) {
                                    showNotification('error', data.errors[key][0]);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error al cambiar la contraseña');
                        })
                        .finally(() => {
                            // Restaurar estado del botón
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Función para mostrar/ocultar contraseña
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('.relative').querySelector('input');
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Función para mostrar notificaciones mejorada
            function showNotification(type, message) {
                // Usar toastr si está disponible
                if (typeof toastr !== 'undefined') {
                    toastr[type](message);
                }
                // Si no, usar SweetAlert si está disponible
                else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: type,
                        title: type === 'success' ? 'Éxito' : 'Error',
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                // Si no hay librerías de notificación, usar alertas nativas
                else {
                    alert(`${type.toUpperCase()}: ${message}`);
                }
            }
        });
    </script>
@endsection
