// public/js/user-management.js

// Función para cargar datos del usuario
async function loadUserData(userId) {
    try {
        console.log('Cargando usuario ID:', userId);

        const response = await fetch(`/usuarios/${userId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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

        // Llenar el formulario
        document.getElementById('user_id').value = user.id;
        document.getElementById('nombre').value = user.nombre;
        document.getElementById('apellido').value = user.apellido;
        document.getElementById('email').value = user.email;
        document.getElementById('numero_nomina').value = user.numero_nomina;
        document.getElementById('telefono').value = user.telefono || '';
        document.getElementById('rol_id').value = user.rol_id;

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
function setupUserSearch() {
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.user-item').forEach(item => {
                const userName = item.querySelector('p').textContent.toLowerCase();
                item.style.display = userName.includes(searchTerm) ? 'block' : 'none';
            });
        });
    }
}

// Enviar formulario
function setupFormSubmission() {
    const form = document.getElementById('userForm');
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userId = document.getElementById('user_id').value;

            // Convertir FormData a objeto
            const data = Object.fromEntries(formData.entries());

            // Si la contraseña está vacía, eliminar los campos
            if (!data.nueva_password) {
                delete data.nueva_password;
                delete data.nueva_password_confirmation;
            }

            try {
                const response = await fetch(`/usuarios/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Usuario actualizado correctamente');
                    // Limpiar campos de contraseña
                    document.getElementById('nueva_password').value = '';
                    document.getElementById('nueva_password_confirmation').value = '';
                } else {
                    if (result.errors) {
                        alert('Error: ' + Object.values(result.errors).join(', '));
                    } else {
                        alert('Error al actualizar el usuario');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al actualizar el usuario');
            }
        });
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
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

// Configurar event listeners cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    setupUserSearch();
    setupFormSubmission();

    // Hacer funciones globales disponibles
    window.loadUserData = loadUserData;
    window.resetForm = resetForm;
    window.togglePassword = togglePassword;
});