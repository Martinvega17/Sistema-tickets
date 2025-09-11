// session-timeout.js
class SessionTimeout {
    constructor() {
        this.timeout = null;
        this.warningTimeout = null;
        this.warningTime = 20 * 60; // 9 minutos en segundos (aviso)
        this.expireTime = 21 * 60; // 10 minutos en segundos (sesión expirada)
        this.warningModal = null;
        this.expiredModal = null;
        this.countdownInterval = null;

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.resetTimer();
    }

    setupEventListeners() {
        const events = [
            'load', 'mousemove', 'keypress', 'click', 'scroll', 'mousedown', 'touchstart',
            'keydown', 'mouseover', 'touchmove', 'input', 'change'
        ];

        events.forEach(event => {
            window.addEventListener(event, () => this.resetTimer());
        });
    }

    resetTimer() {
        // Limpiar timeouts existentes
        clearTimeout(this.timeout);
        clearTimeout(this.warningTimeout);
        clearInterval(this.countdownInterval);

        // Ocultar modales si están visibles
        this.hideWarningModal();
        this.hideExpiredModal();

        // Establecer timeout para advertencia
        this.warningTimeout = setTimeout(() => {
            this.showWarningModal();
        }, this.warningTime * 1000);

        // Establecer timeout para expiración completa
        this.timeout = setTimeout(() => {
            this.showExpiredModal();
        }, this.expireTime * 1000);
    }

    showWarningModal() {
        // Crear modal de advertencia si no existe
        if (!this.warningModal) {
            this.createWarningModal();
        }

        // Mostrar modal de advertencia
        this.warningModal.classList.remove('hidden');

        // Iniciar cuenta regresiva visual
        this.startWarningCountdown();
    }

    hideWarningModal() {
        if (this.warningModal) {
            this.warningModal.classList.add('hidden');
        }
    }

    showExpiredModal() {
        // Ocultar advertencia primero
        this.hideWarningModal();

        // Crear modal de expiración si no existe
        if (!this.expiredModal) {
            this.createExpiredModal();
        }

        // Mostrar modal de expiración
        this.expiredModal.classList.remove('hidden');

        // Redirigir después de 5 segundos usando POST
        setTimeout(() => {
            this.performLogout();
        }, 5000);
    }

    hideExpiredModal() {
        if (this.expiredModal) {
            this.expiredModal.classList.add('hidden');
        }
    }

    startWarningCountdown() {
        const timeLeft = this.expireTime - this.warningTime;
        const countdownElement = document.getElementById('countdown');
        const progressBar = document.getElementById('countdown-progress');

        if (!countdownElement || !progressBar) return;

        let secondsLeft = timeLeft;

        // Actualizar inmediatamente
        this.updateCountdownDisplay(countdownElement, progressBar, secondsLeft, timeLeft);

        this.countdownInterval = setInterval(() => {
            if (secondsLeft <= 0) {
                clearInterval(this.countdownInterval);
                return;
            }

            secondsLeft--;
            this.updateCountdownDisplay(countdownElement, progressBar, secondsLeft, timeLeft);

        }, 1000);
    }

    updateCountdownDisplay(element, progressBar, secondsLeft, totalTime) {
        // Actualizar texto de cuenta regresiva
        const minutes = Math.floor(secondsLeft / 60);
        const seconds = secondsLeft % 60;
        element.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

        // Actualizar barra de progreso
        const progressPercentage = (secondsLeft / totalTime) * 100;
        progressBar.style.width = `${progressPercentage}%`;

        // Cambiar color cuando quede poco tiempo
        if (secondsLeft < 30) {
            progressBar.classList.remove('bg-yellow-500');
            progressBar.classList.add('bg-red-500');
        }
    }

    extendSession() {
        // Limpiar intervalos
        clearInterval(this.countdownInterval);

        // Reiniciar el temporizador
        this.resetTimer();

        // Ocultar modal de advertencia
        this.hideWarningModal();

        // Mostrar mensaje de confirmación
        this.showSessionExtendedMessage();
    }

    showSessionExtendedMessage() {
        // Crear un toast de confirmación
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Sesión extendida
            </div>
        `;
        document.body.appendChild(toast);

        // Remover después de 3 segundos
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    performLogout() {
        // Crear un formulario temporal para hacer logout via POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = window.location.origin + '/logout';

        // Agregar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }

        // Agregar al documento y enviar
        document.body.appendChild(form);
        form.submit();
    }

    createWarningModal() {
        const modalHTML = `
            <div id="sessionWarningModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-xl p-6 w-96">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mt-4">Sesión por Expirar</h3>
                    <p class="text-gray-600 text-center mt-2">Su sesión está a punto de expirar por inactividad.</p>
                    
                    <!-- Cuenta regresiva -->
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div id="countdown-progress" class="bg-yellow-500 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                    </div>
                    <p class="text-center text-sm text-gray-600 mt-2">
                        Tiempo restante: <span id="countdown" class="font-bold">2:00</span>
                    </p>
                    
                    <div class="mt-6 flex justify-center space-x-4">
                        <button onclick="sessionTimeout.extendSession()" class="bg-pepsi-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Permanecer Conectado
                        </button>
                        <button onclick="sessionTimeout.performLogout()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                            Cerrar Sesión
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.warningModal = document.getElementById('sessionWarningModal');
    }

    createExpiredModal() {
        const modalHTML = `
            <div id="sessionExpiredModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-xl p-6 w-96">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mt-4">Sesión Expirada</h3>
                    <p class="text-gray-600 text-center mt-2">Su sesión ha expirado por inactividad. Será redirigido para iniciar sesión nuevamente.</p>
                    
                    <!-- Cuenta regresiva para redirección -->
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Redirigiendo en <span id="redirect-countdown">5</span> segundos...
                    </p>
                    
                    <div class="mt-6 flex justify-center">
                        <button onclick="sessionTimeout.performLogout()" class="bg-pepsi-blue text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Volver a Iniciar Sesión
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.expiredModal = document.getElementById('sessionExpiredModal');

        // Iniciar cuenta regresiva de redirección
        this.startRedirectCountdown();
    }

    startRedirectCountdown() {
        let secondsLeft = 5;
        const countdownElement = document.getElementById('redirect-countdown');

        if (!countdownElement) return;

        countdownElement.textContent = secondsLeft;

        const redirectInterval = setInterval(() => {
            secondsLeft--;

            if (secondsLeft <= 0) {
                clearInterval(redirectInterval);
                return;
            }

            countdownElement.textContent = secondsLeft;
        }, 1000);
    }
}

// Hacer la instancia global para que los botones del modal puedan acceder a ella
let sessionTimeout;

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {
    sessionTimeout = new SessionTimeout();
});