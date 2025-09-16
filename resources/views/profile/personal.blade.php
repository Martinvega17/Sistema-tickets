@extends('layouts.admin')

@section('content.dashboard')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Configuración de Perfil</h1>
                <p class="text-sm text-gray-600 mt-2">Gestiona tu información personal y preferencias</p>
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
                                class="flex items-center px-4 py-3 rounded-lg bg-blue-50 text-blue-700 font-medium transition-all duration-200 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>Datos Personales</span>
                                <i class="fas fa-chevron-right ml-auto text-blue-400 text-xs"></i>
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
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800">Datos Personales</h2>
                                    <p class="text-sm text-gray-600 mt-1">Mantén tu información personal actualizada y
                                        privada</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <form id="personalDataForm" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="nombre" value="{{ $user->nombre }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="apellido" value="{{ $user->apellido }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Género *</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-venus-mars text-gray-400"></i>
                                            </div>
                                            <select
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition-all"
                                                name="genero">
                                                <option value="">Seleccionar género</option>
                                                <option value="Masculino"
                                                    {{ $user->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="Femenino"
                                                    {{ $user->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Otro" {{ $user->genero == 'Otro' ? 'selected' : '' }}>Otro
                                                </option>
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-phone text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="telefono" value="{{ $user->telefono }}">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email"
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            name="email" value="{{ $user->email }}"
                                            {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Extensión</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-hashtag text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="extension" value="{{ $user->extension }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Zona horaria</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-clock text-gray-400"></i>
                                            </div>
                                            <input type="text"
                                                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                name="zona_horaria"
                                                value="{{ $user->zona_horaria ?? 'México: (UTC-06:00)' }}"
                                                {{ Auth::user()->rol_id > 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Idioma de
                                        preferencia</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-globe text-gray-400"></i>
                                        </div>
                                        <select
                                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition-all"
                                            name="idioma" id="languageSelect">
                                            <option value="ES" {{ $user->idioma == 'ES' ? 'selected' : '' }}>Español
                                                (ES)</option>
                                            <option value="EN" {{ $user->idioma == 'EN' ? 'selected' : '' }}>English
                                                (EN)</option>
                                            <option value="PT" {{ $user->idioma == 'PT' ? 'selected' : '' }}>Português
                                                (PT)</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-sm hover:shadow-md">
                                        <i class="fas fa-save mr-2"></i>
                                        Guardar Cambios
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
                                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                                    <p class="mt-1 text-sm text-blue-600">Los campos marcados con * son obligatorios. Tu
                                        información personal está protegida según nuestras políticas de privacidad.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-alt text-gray-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-800">Seguridad de datos</h3>
                                    <p class="mt-1 text-sm text-gray-600">Tus datos están encriptados y protegidos.
                                        Recomendamos actualizar tu contraseña regularmente.</p>
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
            // Manejar envío del formulario de datos personales
            const personalForm = document.getElementById('personalDataForm');
            if (personalForm) {
                personalForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Mostrar estado de carga
                    const submitBtn = personalForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...';
                    submitBtn.disabled = true;

                    fetch('{{ route('profile.updatePersonal') }}', {
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
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Manejar cambio de idioma
            const languageSelect = document.getElementById('languageSelect');
            if (languageSelect) {
                languageSelect.addEventListener('change', function() {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('idioma', this.value);

                    fetch('{{ route('profile.updateLanguage') }}', {
                            method: 'POST',
                            body: formData
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
                                // Recargar para aplicar el idioma
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else if (data.errors) {
                                for (const key in data.errors) {
                                    showNotification('error', data.errors[key][0]);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error al cambiar el idioma');
                        });
                });
            }

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
