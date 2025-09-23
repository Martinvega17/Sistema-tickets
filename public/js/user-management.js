async function loadUserData(userId) {
    try {
        console.log('Cargando usuario ID:', userId);

        const response = await fetch(`/usuarios/${userId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        console.log('Response status:', response.status, response.statusText);

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response body:', errorText);

            if (response.status === 404) {
                throw new Error('Usuario no encontrado. ¿El ID existe?');
            } else if (response.status === 403) {
                throw new Error('No tienes permisos para ver este usuario');
            } else {
                throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
            }
        }

        const user = await response.json();
        console.log('Usuario cargado exitosamente:', user);

        // Llenar el formulario con todos los campos
        document.getElementById('user_id').value = user.id;
        document.getElementById('nombre').value = user.nombre;
        document.getElementById('apellido').value = user.apellido;
        document.getElementById('email').value = user.email;
        document.getElementById('numero_nomina').value = user.numero_nomina;
        document.getElementById('telefono').value = user.telefono || '';
        document.getElementById('rol_id').value = user.rol_id;

        // Campos de empresa (nuevos)
        document.getElementById('empresa').value = user.empresa || '';
        document.getElementById('pais').value = user.pais || '';
        document.getElementById('ubicacion').value = user.ubicacion || '';
        document.getElementById('ciudad').value = user.ciudad || '';
        document.getElementById('estado').value = user.estado || '';
        document.getElementById('departamento').value = user.departamento || '';
        document.getElementById('piso').value = user.piso || '';
        document.getElementById('torre').value = user.torre || '';
        document.getElementById('cargo').value = user.cargo || '';
        document.getElementById('centro_costos').value = user.centro_costos || '';

        // Ocultar mensaje inicial y mostrar formulario
        document.getElementById('initialMessage').classList.add('hidden');
        document.getElementById('userFormContent').classList.remove('hidden');

        // Resaltar usuario seleccionado
        document.querySelectorAll('.user-item').forEach(item => {
            item.classList.remove('bg-blue-100', 'border-pepsi-blue');
        });
        document.querySelector(`.user-item[data-user-id="${userId}"]`).classList.add('bg-blue-100', 'border-pepsi-blue');

    } catch (error) {
        console.error('Error completo:', error);
        alert('Error al cargar los datos del usuario: ' + error.message);
    }
}

// Función para buscar usuarios
document.getElementById('userSearch').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.user-item').forEach(item => {
        const userName = item.querySelector('p').textContent.toLowerCase();
        item.style.display = userName.includes(searchTerm) ? 'block' : 'none';
    });
});

// Enviar formulario
document.getElementById('userForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const userId = document.getElementById('user_id').value;

    // Convertir FormData a objeto
    const data = Object.fromEntries(formData.entries());

    // Si la contraseña está vacía, eliminar los campos
    if (!data.nueva_password) {
        delete data.nueva_password;
        delete data.nueva_password_confirmation;
    } else {
        // Validar que las contraseñas coincidan
        if (data.nueva_password !== data.nueva_password_confirmation) {
            showNotification('error', 'Las contraseñas no coinciden');
            return;
        }
    }

    // Mostrar estado de carga
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Guardando...
    `;
    submitBtn.disabled = true;

    try {
        const response = await fetch(`/usuarios/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                ...data,
                _method: 'PUT'
            })
        });

        const result = await response.json();

        if (response.ok) {
            showNotification('success', 'Usuario actualizado correctamente');

            // Limpiar campos de contraseña
            document.getElementById('nueva_password').value = '';
            document.getElementById('nueva_password_confirmation').value = '';

            // Opcional: recargar después de un breve delay para que se vea la notificación
            setTimeout(() => {
                location.reload();
            }, 1500);

        } else {
            if (result.errors) {
                const errorMessages = Object.values(result.errors).flat().join(', ');
                showNotification('error', errorMessages);
            } else if (result.message) {
                showNotification('error', result.message);
            } else {
                showNotification('error', 'Error al actualizar el usuario');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Error de conexión al actualizar el usuario');
    } finally {
        // Restaurar estado del botón
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

// Función para mostrar notificación (debes tener esta función definida)
function showNotification(type, message) {
    // Crear elemento de notificación si no existe
    let notificationContainer = document.getElementById('notification-container');
    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.id = 'notification-container';
        notificationContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(notificationContainer);
    }

    const notificationId = 'notification-' + Date.now();
    const notification = document.createElement('div');
    notification.id = notificationId;
    notification.className = `transform transition-all duration-300 translate-x-0 opacity-100`;

    const styles = {
        success: {
            bg: 'bg-green-50',
            border: 'border-green-500',
            text: 'text-green-800',
            icon: '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
            title: 'Éxito'
        },
        error: {
            bg: 'bg-red-50',
            border: 'border-red-500',
            text: 'text-red-800',
            icon: '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
            title: 'Error'
        }
    };

    const style = styles[type] || styles.info;

    notification.innerHTML = `
        <div class="min-w-80 bg-white rounded-lg shadow-lg border-l-4 ${style.border} p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${style.icon}
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium ${style.text}">${message}</p>
                </div>
                <button onclick="closeNotification('${notificationId}')" class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;

    notificationContainer.appendChild(notification);

    // Animar entrada
    setTimeout(() => {
        notification.classList.add('translate-x-0', 'opacity-100');
    }, 10);

    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        closeNotification(notificationId);
    }, 5000);
}

// Función para cerrar notificación
function closeNotification(id) {
    const notification = document.getElementById(id);
    if (notification) {
        notification.classList.remove('translate-x-0', 'opacity-100');
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
}

// Función para resetear el formulario
function resetForm() {
    document.getElementById('userForm').reset();
    document.getElementById('initialMessage').classList.remove('hidden');
    document.getElementById('userFormContent').classList.add('hidden');
    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.remove('bg-blue-100', 'border-pepsi-blue');
    });
}

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

// Funcionalidad para gestión de CEDIS
async function loadCedisData(cedisId) {
    try {
        const response = await fetch(`/cedis/${cedisId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Error al cargar datos');

        const cedis = await response.json();

        // Llenar modal de edición
        document.getElementById('edit_cedis_id').value = cedis.id;
        document.getElementById('edit_nombre').value = cedis.nombre;
        document.getElementById('edit_codigo').value = cedis.codigo;
        document.getElementById('edit_direccion').value = cedis.direccion || '';
        document.getElementById('edit_telefono').value = cedis.telefono || '';
        document.getElementById('edit_responsable').value = cedis.responsable || '';
        document.getElementById('edit_region_id').value = cedis.region_id;
        document.getElementById('edit_ingeniero_id').value = cedis.ingeniero_id || '';
        document.getElementById('edit_estatus').value = cedis.estatus;

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('editCedisModal')).show();

    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los datos del CEDIS');
    }
}

function toggleStatus(cedisId, currentStatus) {
    if (confirm(`¿Estás seguro de ${currentStatus === 'activo' ? 'desactivar' : 'activar'} este CEDIS?`)) {
        fetch(`/cedis/${cedisId}/estatus`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                estatus: currentStatus === 'activo' ? 'inactivo' : 'activo'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cambiar el estatus');
            });
    }
}

function showCreateModal() {
    // Resetear formulario
    document.getElementById('createCedisForm').reset();
    // Mostrar modal
    new bootstrap.Modal(document.getElementById('createCedisModal')).show();
}

// Configurar event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Configurar formulario de búsqueda
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams(formData).toString();
            window.location.href = `${window.location.pathname}?${params}`;
        });
    }
});

