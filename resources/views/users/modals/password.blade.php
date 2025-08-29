<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-xl border-0 shadow-xl">
            <!-- Header -->
            <div class="modal-header bg-pepsi-red text-white rounded-t-xl p-6">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                </path>
                            </svg>
                        </div>
                        <h5 class="modal-title text-xl font-bold">Restablecer Contraseña</h5>
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
            <form id="resetPasswordForm">
                <div class="modal-body p-6 bg-gray-50">
                    <input type="hidden" id="reset_user_id" name="user_id">

                    <div class="space-y-4">
                        <!-- Nueva Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-pepsi-red">*</span> Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" id="reset_password" name="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-red focus:border-transparent transition-colors pr-10"
                                    placeholder="Mínimo 8 caracteres" required minlength="8">
                                <button type="button"
                                    class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('reset_password')">
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
                            <p class="text-xs text-gray-500 mt-1">La contraseña debe tener al menos 8 caracteres</p>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-pepsi-red">*</span> Confirmar Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" id="reset_password_confirmation" name="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pepsi-red focus:border-transparent transition-colors pr-10"
                                    placeholder="Confirma tu contraseña" required>
                                <button type="button"
                                    class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('reset_password_confirmation')">
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
                            class="px-6 py-3 bg-pepsi-red text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Restablecer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Función para mostrar/ocultar contraseña
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eyeIcon = input.parentNode.querySelector('.eye-icon');

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            input.type = 'password';
            eyeIcon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }

    // Agregar estilos para los selects con flecha
    const style = document.createElement('style');
    style.textContent = `
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
`;
    document.head.appendChild(style);
</script>
